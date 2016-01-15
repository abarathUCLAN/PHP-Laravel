<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectQuality extends Model
{
    protected $table = 'project_qualities';

    protected $fillable = ['content'];
}
