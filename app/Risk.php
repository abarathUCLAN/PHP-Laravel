<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    protected $table = 'risks';

    protected $fillable = ['name', 'content'];
}
