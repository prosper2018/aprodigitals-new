<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'position_id',
        'position_name',
        'firstname',
        'lastname',
        'display_name',
        'email',
        'mobile_phone',
        'passchg_logon',
        'pass_expire',
        'pass_dateexpire',
        'pass_change',
        'reset_pwd_link',
        'user_disabled',
        'user_locked',
        'day_1',
        'day_2',
        'day_3',
        'day_4',
        'day_5',
        'day_6',
        'day_7',
        'pin_missed',
        'last_used',
        'authorize_status',
        'hint_question',
        'hint_answer',
        'override_wh',
        'extend_wh',
        'contact_address',
        'office_state',
        'office_lga',
        'posted_user',
        'posted_ip',
        'business_id',
        'dob',
        'gender',
        'auth_pin',
        'bvn',
        'bank_code',
        'bank_name',
        'bank_account_name',
        'bank_account_no',
        'nationality',
        'religion',
        'department_id',
        'photo',
        'staff_id_card',
        'nin',
        'is_mfa',
        'status',
        'online_status',
        'login_status',
        'comments_reason',
        'sacked_by',
        'sacked_on',
        'recalled_by',
        'recalled_on',
        'mfa_otp',
        'is_email_verified',
        'email_token',
        'mfa_type',
        'otp_date',
        'marital_status',
        'employment_date',
        'termination_date',
        'employment_type',
        'entry_salary',
        'current_salary',
        'current_usd_salary',
        'last_increment',
        'last_increment_date',
        'last_promotion',
        'submittedon_date',
        'email_verified_at',
        'remember_token',
        'is_deleted',
        'verified',
        'verification_token' ,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
