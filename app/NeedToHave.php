<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NeedToHave extends Model
{
    protected $table = 'needToHaves';

    protected $fillable = ['name', 'content'];
}
