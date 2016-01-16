<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FunctionalRequirement extends Model
{
    protected $table = 'functional_requirements';

    protected $fillable = ['content', 'name'];
}
