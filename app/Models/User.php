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
        // 'role_name',
        'firstname',
        'lastname',
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
        'created',
        'modified',
        'authorize_status',
        'hint_question',
        'hint_answer',
        'override_wh',
        'extend_wh',
        'station_code',
        'login_status',
        'staff_id',
        'trans_allow',
        'posted_user',
        'posted_ip',
        'address',
        'state',
        'dob',
        'gender',
        'trans_sms',
        'trans_pin',
        'bvn',
        'bvn_verified',
        'completed_reg',
        'userid',
        'nin'
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
