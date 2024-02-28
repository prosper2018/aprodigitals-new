<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('otp_verified')->default(false);
            $table->timestamp('otp_generated_at')->nullable();
            $table->dropColumn('otp_date');
            $table->dropColumn('reset_pwd_link');
            $table->dropColumn('is_email_verified');
        });

        DB::table('parameters')->insert([
            [
                'parameter_name' => 'otp_time',
                'parameter_value' => 3,
                'privilege_flag' => 1,
                'parameter_description' => 'OTP Expiration Time',
                'created' => NOW(),
            ]
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
