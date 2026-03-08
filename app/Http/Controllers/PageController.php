<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;
use App\Models\Review;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    private const EXTRA_PAX_FEE = 1200;

    /**
     * Exclude rooms that have overlapping orders for the given date range.
     * IMPORTANT: Cancelled orders should NOT block availability.
     */
    private function excludeUnavailableRooms($query, $checkIn, $checkOut)
    {
        return $query->whereDoesntHave('orders', function ($q) use ($checkIn, $checkOut) {

            // ✅ Cancelled bookings must not block rooms
            $q->where('status', '!=', 'cancelled');

            // ✅ Overlap logic
            $q->where(function ($overlap) use ($checkIn, $checkOut) {
                $overlap->whereBetween('check_in', [$checkIn, $checkOut])
                        ->orWhereBetween('check_out', [$checkIn, $checkOut])
                        ->orWhere(function ($q2) use ($checkIn, $checkOut) {
                            $q2->where('check_in', '<', $checkIn)
                               ->where('check_out', '>', $checkOut);
                        });
            });
        });
    }

    public function index(): View
    {
        $rooms = Room::with('roomtype.inclusions')->get();
        $reviews = Review::latest()->take(10)->get();

        return view('pages.home', compact('rooms', 'reviews'));
    }

    public function list_rooms(Request $request)
    {
        $roomsQuery = Room::with('roomtype.inclusions')->where('status', 1);

        $fields = [
            'check_in'     => $request->query('check_in', null),
            'check_out'    => $request->query('check_out', null),
            'adults'       => (int) $request->query('adults', 1),
            'children'     => (int) $request->query('children', 0),
            'infants'      => (int) $request->query('infants', 0),
            'pets'         => (int) $request->query('pets', 0),
            'desc'         => $request->query('desc', null),
            'room_type_id' => $request->query('room_type_id', null),
        ];

        $totalGuests = max(1, $fields['adults'] + $fields['children'] + $fields['infants']);

        // ✅ Availability filter (cancelled orders won't block anymore)
        if ($fields['check_in'] && $fields['check_out']) {
            $roomsQuery = $this->excludeUnavailableRooms($roomsQuery, $fields['check_in'], $fields['check_out']);
        }

        if ($fields['desc']) $roomsQuery = $roomsQuery->where('desc', $fields['desc']);
        if ($fields['room_type_id']) $roomsQuery = $roomsQuery->where('room_type_id', $fields['room_type_id']);

        if (Schema::hasColumn('rooms', 'max_capacity')) {
            $roomsQuery
                ->where('max_capacity', '>=', $totalGuests)
                ->orderBy('max_capacity', 'asc')
                ->orderBy('price', 'asc');
        }

        $rooms = $roomsQuery->get();

        $rooms->each(function ($room) use ($totalGuests) {
            $base = (float) ($room->price ?? 0);

            $included = 1;
            if (Schema::hasColumn('rooms', 'included_pax')) {
                $included = max(1, (int) ($room->included_pax ?? 1));
            }

            $extraPax = max(0, $totalGuests - $included);
            $perNight = $base + ($extraPax * self::EXTRA_PAX_FEE);

            $room->computed_total_per_night = $perNight;
            $room->computed_extra_pax = $extraPax;
            $room->computed_total_guests = $totalGuests;
        });

        $reviews = Review::latest()->take(10)->get();

        return view('pages.list-rooms', [
            'rooms'       => $rooms,
            'fields'      => $fields,
            'searched'    => $request->filled(['check_in', 'check_out']),
            'reviews'     => $reviews,
            'totalGuests' => $totalGuests,
        ]);
    }

    public function search(Request $request)
    {
        $validatedData = $request->validate([
            'check_in'     => ['required', 'date', 'after:today'],
            'check_out'    => ['required', 'date', 'after:check_in'],
            'adults'       => ['required', 'integer', 'min:1'],
            'children'     => ['nullable', 'integer', 'min:0'],
            'infants'      => ['nullable', 'integer', 'min:0'],
            'pets'         => ['nullable', 'integer', 'min:0'],
            'desc'         => ['nullable', 'string'],
            'room_type_id' => ['nullable', 'integer'],
        ]);

        $totalGuests = max(
            1,
            (int) $validatedData['adults']
            + (int) ($validatedData['children'] ?? 0)
            + (int) ($validatedData['infants'] ?? 0)
        );

        $roomsQuery = Room::with('roomtype.inclusions')
            ->where('status', 1)
            ->when(!empty($validatedData['desc']), function ($query) use ($validatedData) {
                $query->where('desc', $validatedData['desc']);
            })
            ->when(!empty($validatedData['room_type_id']), function ($query) use ($validatedData) {
                $query->where('room_type_id', $validatedData['room_type_id']);
            });

        // ✅ Availability filter (cancelled orders won't block anymore)
        $roomsQuery = $this->excludeUnavailableRooms(
            $roomsQuery,
            $validatedData['check_in'],
            $validatedData['check_out']
        );

        if (Schema::hasColumn('rooms', 'max_capacity')) {
            $roomsQuery
                ->where('max_capacity', '>=', $totalGuests)
                ->orderBy('max_capacity', 'asc')
                ->orderBy('price', 'asc');
        }

        $rooms = $roomsQuery->get();

        $rooms->each(function ($room) use ($totalGuests) {
            $base = (float) ($room->price ?? 0);

            $included = 1;
            if (Schema::hasColumn('rooms', 'included_pax')) {
                $included = max(1, (int) ($room->included_pax ?? 1));
            }

            $extraPax = max(0, $totalGuests - $included);
            $room->computed_extra_pax = $extraPax;
            $room->computed_total_per_night = $base + ($extraPax * self::EXTRA_PAX_FEE);
            $room->computed_total_guests = $totalGuests;
        });

        $searched = true;

        $fields = [
            'check_in'     => $validatedData['check_in'],
            'check_out'    => $validatedData['check_out'],
            'adults'       => $validatedData['adults'] ?? 1,
            'children'     => $validatedData['children'] ?? 0,
            'infants'      => $validatedData['infants'] ?? 0,
            'pets'         => $validatedData['pets'] ?? 0,
            'desc'         => $validatedData['desc'] ?? null,
            'room_type_id' => $validatedData['room_type_id'] ?? null,
        ];

        $reviews = Review::latest()->take(10)->get();

        return view('pages.list-rooms', compact('rooms', 'searched', 'fields', 'reviews', 'totalGuests'));
    }

    public function showProfile()
    {
        return view('pages.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->save();

        return redirect()->route('profile');
    }

    public function showRoom(Request $request, $roomId)
    {
        $room = Room::findOrFail($roomId);
        $feedbacks = Feedback::where('room_id', $roomId)->get();

        $fields = [
            'check_in'     => $request->check_in ?? null,
            'check_out'    => $request->check_out ?? null,
            'adults'       => $request->adults ?? 1,
            'children'     => $request->children ?? 0,
            'infants'      => $request->infants ?? 0,
            'pets'         => $request->pets ?? 0,
            'desc'         => $request->desc ?? null,
            'room_type_id' => $request->room_type_id ?? null,
        ];

        return view('sections.room-container-details', compact('room', 'feedbacks', 'fields'));
    }

    public function showRoomTour($id)
    {
        $room = Room::findOrFail($id);
        return view('pages.room-tour', compact('room'));
    }
}