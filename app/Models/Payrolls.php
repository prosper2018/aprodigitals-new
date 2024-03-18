<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payrolls extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'ref_no',
        'date_from',
        'date_to',
        'payroll_type',
        'status',
        'posted_user',
        'posted_ip',
        'posted_userid',
        'is_deleted'
    ];
}
