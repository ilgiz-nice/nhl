<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'description',
        'photo',
        'banner',
        'main'
    ];

    public function scopeMainNews($query) {
        $query->where('banner', 1);
    }

    public function scopeNews($query) {
        Carbon::setLocale('ru');
        $first = News::orderBy('created_at', 'ASC')->first()->created_at;
        $last = News::orderBy('created_at', 'DESC')->first()->created_at;
        $news = News::all();
        $array = array();
        for ($i = Carbon::parse($last); $i >= Carbon::parse($first); $i = $i->subDay()) {
            $temp = array();
            foreach ($news as $n) {
                if (Carbon::parse($n->created_at)->format('Y-m-d') == $i->format('Y-m-d')) {
                    array_push($temp, $n);
                }
            }
            if (count($temp) != 0) {
                $object = (object) array();
                $object->date = $i->format('d-M-y');
                $object->news = $temp;
                array_push($array, $object);
            }
        }

        return $array;
    }

    public function scopeDate($query, $param = 'ASC') {
        $query->orderBy('created_at', $param)->first();
    }
}
