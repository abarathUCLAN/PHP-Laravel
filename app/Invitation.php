<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitations';

    protected $fillable = ['firstname', 'lastname', 'type', 'email'];

    protected $hidden = ['owner'];
}

?>
