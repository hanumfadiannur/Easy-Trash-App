<?php

namespace App\Http\Controllers;

use App\Models\Map;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MapController extends Controller
{


    public function index2()
    {
        $locations = Map::all();
        return view('maps', compact('locations'));
    }
}
