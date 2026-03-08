<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class AmenityController extends Controller
{
    public function brickyard()
    {
        return view('amenities.brickyard');
    }

    public function swim()
    {
        return view('amenities.swim');
    }

    public function activities()
    {
        return view('amenities.activities');
    }
}
