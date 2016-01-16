<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectManual extends Model
{
    protected $table = 'project_manuals';

    protected $fillable = ['content'];
}
