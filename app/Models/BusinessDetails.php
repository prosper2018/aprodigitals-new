<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessDetails extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['business_name', 'address', 'description', 'logo', 'posted_user', 'posted_userid', 'posted_ip'];
}
