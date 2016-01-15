<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductData extends Model
{
    protected $table = 'product_datas';

    protected $fillable = ['content'];
}
