<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Models\Review;

class RoomTypeController extends Controller {

    
    public function index() {

        $types = RoomType::all();
        return view('admin.roomtypes.index', compact('types'));
    }

    
    public function create() {
        
        $types = RoomType::all();   // Fetch all room types
        return view('admin.roomtypes.create', compact('types'));
    }


    
    public function store(Request $request) {

        $validatedData = $request->validate([
            'name' => ['required', 'unique:room_types,name,' . $id],
        ]);

        RoomType::create($validatedData);

        return redirect()->route('admin.roomtypes.index')
            ->with('message', 'Your list has been created!');
    }

    
    public function show(RoomType $roomType) {
    }

    
    public function edit(int $id) {
        $type = RoomType::findOrFail($id);
        $this->authorize('update', $type);

        return view('admin.roomtypes.edit', compact('type'));
    }

    public function update(Request $request, int $id) {
        $validatedData = $request->validate([
            'name' => ['required', 'unique:room_types,name']
        ]);

        $type = RoomType::findOrFail($id);
        $type->update($validatedData);

        return redirect()->route('admin.roomtypes.index')
            ->with('message', 'Your RoomType has been updated!');
    }

    
    public function destroy(int $id) {

        $type = RoomType::findOrFail($id);
        $this->authorize('delete', $type);
        $type->delete();
        return redirect()->route('admin.roomtypes.index')
            ->with('message', 'Your RoomType has been deleted!');
    }
}
