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
        $played = Match::Calendar('Завершен')->get();
        $notPlayed = Match::Calendar('Ожидается')->get();
        return view('calendar.index', compact('played', 'notPlayed'));
    }
}