<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TargetState extends Model
{
    protected $table = 'target_states';

    protected $fillable = ['content'];
}
