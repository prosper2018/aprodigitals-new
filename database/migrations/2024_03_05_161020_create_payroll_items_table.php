<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    
        Schema::create('payroll_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('payroll_id');
            $table->bigInteger('staff_id');
            $table->integer('present')->nullable()->default(0);
            $table->integer('absent')->nullable()->default(0);
            $table->text('late');
            $table->double('salary', 50, 2);
            $table->double('current_usd_salary', 50, 2);
            $table->double('allowance_amount', 50, 2);
            $table->double('allowance_usd_amount', 50, 2);
            $table->text('allowances');
            $table->double('deduction_amount', 50, 2);
            $table->double('deduction_usd_amount', 50, 2);
            $table->text('deductions');
            $table->double('loan_amount', 50, 2);
            $table->double('loan_usd_amount', 50, 2);
            $table->text('loans');
            $table->double('adjustment_amount', 50, 2)->nullable();
            $table->double('adjustment_usd_amount', 50, 2)->nullable();
            $table->text('adjustments')->nullable();
            $table->double('net', 50, 2);
            $table->double('net_usd', 50, 2);
            $table->date('payment_date');
            $table->bigInteger('payment_status')->default(100);
            $table->string('paid_by', 50);
            $table->string('posted_user', 50)->nullable();
            $table->string('posted_ip', 30)->nullable();
            $table->bigInteger('posted_userid')->nullable();
            $table->tinyInteger('is_deleted')->nullable()->default(0);
            $table->tinyInteger('is_loan_paid')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_items');
    }
};
