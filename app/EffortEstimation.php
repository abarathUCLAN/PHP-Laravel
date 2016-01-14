<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EffortEstimation extends Model
{
    protected $table = 'estimations';

    protected $fillable = ['content'];
}
