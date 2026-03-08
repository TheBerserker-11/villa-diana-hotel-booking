<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Hall;

class EventController extends Controller
{
    /**
     * PUBLIC EVENTS LIST PAGE
     * /events
     */
    public function index()
    {
        $events = Event::with('images')->latest()->get();
        $halls  = Hall::all();

        return view('events.index', compact('events', 'halls'));
    }

    /**
     * EVENT SEARCH
     * /events/search?q=
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        $events = Event::with('images')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->get();

        $halls = Hall::all();

        return view('events.index', compact('events', 'halls'));
    }

    /**
     * SHOW SINGLE EVENT PAGE
     * /events/{id}
     */
    public function show(Event $event)
    {
        $event->load('images');

        return view('events.show', compact('event'));
    }
}
