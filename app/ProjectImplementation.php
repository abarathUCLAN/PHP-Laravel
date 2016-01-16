<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectImplementation extends Model
{
    protected $table = 'project_implementations';

    protected $fillable = ['content'];
}
