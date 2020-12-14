<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineProduct extends Model
{
    protected $table = 'ONLINE_PRODUCT';
    protected $primaryKey = 'PRODUCT_CODE';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}
