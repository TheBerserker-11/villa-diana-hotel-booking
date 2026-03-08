<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminEventController extends Controller
{
    public function index()
    {
        $events = Event::with('images')->latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // Main image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        $event = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // Additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                if (!$img || !$img->isValid()) continue;

                $path = $img->store('events', 'public');

                EventImage::create([
                    'event_id' => $event->id,
                    'image' => $path, // ✅ FIXED
                ]);
            }
        }

        return redirect()->route('admin.events.index')->with('success', 'Event created!');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // Update base fields
        $event->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Update main image (optional)
        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }

            $event->image = $request->file('image')->store('events', 'public');
            $event->save();
        }

        // Add additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                if (!$img || !$img->isValid()) continue;

                $path = $img->store('events', 'public');

                EventImage::create([
                    'event_id' => $event->id,
                    'image' => $path, // ✅ FIXED
                ]);
            }
        }

        return redirect()->route('admin.events.index')->with('success', 'Event updated!');
    }

    public function destroy(Event $event)
    {
        // Delete additional images
        foreach ($event->images as $img) {
            Storage::disk('public')->delete($img->image);
            $img->delete();
        }

        // Delete main image
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted!');
    }

    public function destroyImage($id)
    {
        $image = EventImage::findOrFail($id);

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Image deleted!');
    }
}