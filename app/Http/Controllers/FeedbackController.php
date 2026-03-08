<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request, $roomId)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'comment' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        Feedback::create([
            'room_id' => $roomId,
            'user_name' => $request->user_name,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Feedback submitted!');
    }

    public function show($roomId)
    {
        $feedbacks = Feedback::where('room_id', $roomId)->get();
        return view('feedbacks.show', compact('feedbacks'));
    }
}
