<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomControllerA extends Controller
{
    private const CAPACITY_BUCKETS = [2, 3, 6, 8, 16, 20, 22];

    public function index(Request $request)
    {
        $search = trim((string) $request->get('search', ''));

        $rooms = Room::with(['roomtype.inclusions'])
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->whereHas('roomtype', function ($rt) use ($search) {
                            $rt->where('name', 'like', "%{$search}%");
                        })
                    ->orWhere('bed_type', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhere('total_room', 'like', "%{$search}%")
                    ->orWhere('no_beds', 'like', "%{$search}%")
                    ->orWhere('included_pax', 'like', "%{$search}%")
                    ->orWhere('max_capacity', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('admin.rooms.index', compact('rooms', 'search'));
    }

    public function create()
    {
        $types = RoomType::all();
        return view('admin.rooms.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'total_room'    => 'required|numeric',
            'no_beds'       => 'required|numeric',
            'price'         => 'required|numeric',
            'desc'          => 'nullable|string',
            'kuula_link'    => 'nullable|url',
            'room_type_id'  => 'required|exists:room_types,id',
            'bed_type'      => 'required|string|max:255',
            'image'         => 'nullable|image|max:2048',

            'included_pax'  => 'required|integer|min:1|max:22',
            'max_capacity'  => 'required|integer|in:2,3,6,8,16,20,22',
        ]);

        $room = new Room();
        $room->total_room   = $request->total_room;
        $room->no_beds      = $request->no_beds;
        $room->price        = $request->price;
        $room->desc         = $request->desc;
        $room->kuula_link   = $request->kuula_link;
        $room->room_type_id = $request->room_type_id;
        $room->bed_type     = $request->bed_type;
        $room->status       = $request->has('status');

        $room->included_pax = $request->included_pax;
        $room->max_capacity = $request->max_capacity;

        if ($request->hasFile('image')) {
            $filename = time().'_'.$request->image->getClientOriginalName();
            $path = $request->image->storeAs('rooms', $filename, 'public');
            $room->image = $path;
        }

        $room->save();

        AdminActivityLog::record(
            $request->user(),
            'create_room',
            'Room',
            $room->id,
            ['room_type_id' => $room->room_type_id]
        );

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room added successfully!');
    }

    public function edit(int $id)
    {
        $room = Room::findOrFail($id);
        $types = RoomType::all();
        return view('admin.rooms.edit', compact('room', 'types'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'total_room'   => 'required|numeric',
            'no_beds'      => 'required|numeric',
            'price'        => 'required|numeric',
            'desc'         => 'nullable|string',
            'kuula_link'   => 'nullable|url',
            'room_type_id' => 'required|exists:room_types,id',
            'bed_type'     => 'nullable|string|max:255',
            'image'        => 'nullable|image|max:2048',

            'included_pax'  => 'required|integer|min:1|max:22',
            'max_capacity'  => 'required|integer|in:2,3,6,8,16,20,22',
        ]);

        $room->total_room   = $request->total_room;
        $room->no_beds      = $request->no_beds;
        $room->price        = $request->price;
        $room->desc         = $request->desc;
        $room->kuula_link   = $request->kuula_link;
        $room->room_type_id = $request->room_type_id;
        $room->bed_type     = $request->bed_type;
        $room->status       = $request->has('status');

        $room->included_pax = $request->included_pax;
        $room->max_capacity = $request->max_capacity;

        if ($request->hasFile('image')) {
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }

            $filename = time().'_'.$request->image->getClientOriginalName();
            $path = $request->image->storeAs('rooms', $filename, 'public');
            $room->image = $path;
        }

        $room->save();

        AdminActivityLog::record(
            $request->user(),
            'update_room',
            'Room',
            $room->id,
            ['room_type_id' => $room->room_type_id]
        );

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room updated successfully!');
    }

    public function destroy(Room $room)
    {
        $roomId = $room->id;
        $roomTypeId = $room->room_type_id;
        $room->delete();

        AdminActivityLog::record(
            request()->user(),
            'delete_room',
            'Room',
            $roomId,
            ['room_type_id' => $roomTypeId]
        );

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully!');
    }
}
