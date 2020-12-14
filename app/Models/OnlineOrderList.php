<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineOrderList extends Model
{
    protected $table = 'ONLINE_ORDER_LIST';
    protected $primaryKey = 'LIST_NO';
    public $incrementing = false;
    public $timestamps = false;
}
