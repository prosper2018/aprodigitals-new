<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'loan_id',
        'staff_id',
        'amount',
        'penalty_amount',
        'overdue',
        'payment_type',
        'date_created',
        'posted_user',
        'posted_ip',
        'posted_userid',
        'aff_sch_id',
        'updated_at',
    ];
}
