<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Season;

class SeasonsController extends Controller
{
    public function create(Request $request) {
        Season::create([
            'season' => $request->season,
            'active' => 1
        ]);

        return redirect('/manager');
    }
}
