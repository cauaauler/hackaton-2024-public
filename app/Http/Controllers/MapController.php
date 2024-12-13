<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function store($latitude, $longitude)
    {
        return response()->json([
            'message' =>  $latitude, $longitude,
        ]);
    }
}
