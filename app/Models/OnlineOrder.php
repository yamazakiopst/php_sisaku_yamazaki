<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineOrder extends Model
{
    protected $table = 'ONLINE_ORDER';
    protected $primaryKey = 'ORDER_NO';
    public $incrementing = false;
    public $timestamps = false;
}
