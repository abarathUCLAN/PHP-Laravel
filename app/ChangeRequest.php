<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeRequest extends Model
{
    protected $table = 'change_requests';

    protected $fillable = ['name', 'content'];
}
