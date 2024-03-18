<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendingRequests extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'link',
        'description',
        'request_id',
        'request_type',
        'staff_id',
        'status',
        'posted_user',
        'posted_ip',
        'posted_userid',
    ];
}
