<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActualState extends Model
{
    protected $table = 'actual_states';

    protected $fillable = ['content'];
}
