<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectUse extends Model
{
    protected $table = 'project_uses';

    protected $fillable = ['content'];
}
