<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NiceToHave extends Model
{
    protected $table = 'niceToHaves';

    protected $fillable = ['name', 'content'];
}
