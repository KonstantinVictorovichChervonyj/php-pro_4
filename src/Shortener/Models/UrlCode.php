<?php

namespace App\Shortener\Models;

use Illuminate\Database\Eloquent\Model;

class UrlCode extends Model
{
    protected $table = 'url_codes';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'url',
        'code'
    ];

}