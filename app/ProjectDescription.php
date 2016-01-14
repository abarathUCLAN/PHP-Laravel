<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectDescription extends Model
{
    protected $table = 'project_descriptions';

    protected $fillable = ['description'];
}
