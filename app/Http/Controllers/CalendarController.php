<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Match;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function index() {

        return view('calendar.index', compact('result'));
    }
}