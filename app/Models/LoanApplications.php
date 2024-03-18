<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanApplications extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ref_no',
        'loan_type',
        'staff_id',
        'amount',
        'usd_amount',
        'loan_balance',
        'reason',
        'start_date',
        'app_status',
        'repayment_type',
        'number_of_days',
        'number_of_repayments',
        'currency_type',
        'end_date',
        'submitted_date',
        'submitted_by',
        'approved_date',
        'approved_by',
        'rejection_date',
        'rejected_by',
        'comments_reason'
    ];
}
