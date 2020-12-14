<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineCategory extends Model
{
    protected $table = 'ONLINE_CATEGORY';
    protected $primaryKey = 'CTGR_ID';
    public $incrementing = false;
    public $timestamps = false;
}
