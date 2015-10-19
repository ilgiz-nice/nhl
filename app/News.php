<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'description',
        'photo',
        'main'
    ];

    public function scopeMainNews($query) {
        $query->where('main', 1);
    }

    public function scopeNews($query) {
        $query->orderBy('created_at', 'DESC');
    }

    public function scopeDate($query, $param = 'ASC') {
        $query->orderBy('created_at', $param)->first();
    }
}
