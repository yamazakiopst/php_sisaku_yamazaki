<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineMember extends Model
{
    protected $table = 'ONLINE_MEMBER';
    protected $primaryKey = 'MEMBER_NO';
    public $incrementing = false;
    public $timestamps = false;
}
