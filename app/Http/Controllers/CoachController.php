<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Coach;

class CoachController extends Controller
{
    public function create(Request $request) {
        move_uploaded_file($request->photo->getRealPath(), public_path('images/') . $request->photo->getClientOriginalName());
        Coach::create([
            'name' => $request->name,
            'birthday' => $request->birthday,
            'photo' => 'images/' . $request->photo->getClientOriginalName()
        ]);

        return redirect('/manager');
    }
}
