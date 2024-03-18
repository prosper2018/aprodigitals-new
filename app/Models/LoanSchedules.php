<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanSchedules extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'resch_id',
        'loan_id',
        'pre_amount_due',
        'pre_date_due',
        'amount_due',
        'date_due',
        'paid_amount',
        'outstanding_amount',
        'reason_comment',
        'date_created',
        'posted_user',
        'posted_ip',
        'posted_userid'
    ];
}
