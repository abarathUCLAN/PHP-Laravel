<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectIntroduction extends Model
{
    protected $table = 'introductions';

    protected $fillable = ['content'];
}
