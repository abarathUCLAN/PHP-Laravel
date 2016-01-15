<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonFunctionalRequirement extends Model
{
    protected $table = 'nonfunctional_requirements';

    protected $fillable = ['content', 'name'];
}
