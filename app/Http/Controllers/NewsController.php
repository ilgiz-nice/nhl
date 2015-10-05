<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\News;

class NewsController extends Controller
{
    public function index() {
        $news = News::all();
        return view('news.index', compact('news'));
    }

    public function create(Request $request) {
        move_uploaded_file($request->file->getRealPath(), public_path('images/') . $request->file->getClientOriginalName());
        News::create([
            'title' => $request->title,
            'description' => $request->description,
            'photo' => 'images/' . $request->file->getClientOriginalName()
        ]);

        return redirect('/manager');
    }
}
