<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory, SoftDeletes;

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
