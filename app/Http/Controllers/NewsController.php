<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\News;
use Carbon;
use Input;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::News();
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

    public function update($id) {
        $article = News::findOrFail($id);
        $title = Input::get('title');
        $description = Input::get('description');
        $main = Input::get('main');
        $banner = Input::get('banner');

        $main = $main == "true" ? 1 : 0;
        $banner = $banner == "true" ? 1 : 0;

        $article->update([
            'title'         => $title,
            'description'   => $description,
            'main'          => $main,
            'banner'        => $banner
        ]);

        return 'Updated';
    }
}
