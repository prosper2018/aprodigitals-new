<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_id',
        'position_name',
        'position_enabled',
        'created',
        'requires_login',
        'posted_user',
        'posted_ip',
        'posted_userid',
        'is_deleted',
    ];
}
