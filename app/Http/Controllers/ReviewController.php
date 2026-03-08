<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    private const REVIEW_ELIGIBLE_STATUSES = [
        'confirmed',
        'approved',
        'completed',
    ];

    public function index()
    {
        $reviews = Review::latest()->get();
        $canWriteReview = $this->userCanWriteReview();
        $reviewEligibilityMessage = $canWriteReview
            ? null
            : 'Only users with a confirmed, approved, or completed booking can write a review.';

        return view('reviews.index', compact('reviews', 'canWriteReview', 'reviewEligibilityMessage'));
    }

    public function store(Request $request)
    {
        if (!$this->userCanWriteReview()) {
            return redirect()
                ->route('reviews.index')
                ->with('error', 'You can only review after you have a confirmed, approved, or completed booking.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'insider_tip' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'stay_date' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only([
            'name',
            'location',
            'title',
            'insider_tip',
            'content',
            'rating',
            'stay_date',
        ]);

        $data['user_id'] = Auth::id();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        Review::create($data);

        return redirect()->route('reviews.index')->with('success', 'Review added successfully!');
    }


    public function destroy(\App\Models\Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            return redirect()->back()->with('error', 'You are not allowed to delete this review.');
        }

        if ($review->avatar) {
            Storage::disk('public')->delete($review->avatar);
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }

    private function userCanWriteReview(): bool
    {
        $userId = Auth::id();
        if (!$userId) {
            return false;
        }

        $query = Order::query()->where('user_id', $userId);
        if (!Schema::hasColumn('orders', 'status')) {
            return $query->exists();
        }

        return $query
            ->where(function ($query) {
                $statuses = self::REVIEW_ELIGIBLE_STATUSES;
                $query->whereRaw('LOWER(status) = ?', [$statuses[0]]);

                foreach (array_slice($statuses, 1) as $status) {
                    $query->orWhereRaw('LOWER(status) = ?', [$status]);
                }
            })
            ->exists();
    }
}
