<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcceptanceProtocol extends Model
{
    protected $table = 'acceptance_protocols';

    protected $fillable = ['criteriaName', 'criteria', 'fullfiled', 'note', 'requirement'];
}
