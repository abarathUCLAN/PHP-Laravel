<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StyleGuide extends Model
{
    protected $table = 'style_guides';

    protected $fillable = ['name', 'content'];
}
