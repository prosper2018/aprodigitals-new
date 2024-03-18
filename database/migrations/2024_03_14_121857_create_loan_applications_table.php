<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ref_no')->nullable();
            $table->bigInteger('loan_type')->nullable();
            $table->bigInteger('staff_id')->nullable();
            $table->decimal('amount', 50, 0)->nullable();
            $table->float('usd_amount');
            $table->decimal('loan_balance', 50, 0)->nullable();
            $table->text('reason')->nullable();
            $table->date('start_date')->nullable();
            $table->bigInteger('app_status')->default(100);
            $table->bigInteger('repayment_type')->default(100);
            $table->bigInteger('number_of_days')->default(0);
            $table->bigInteger('number_of_repayments')->default(0);
            $table->string('currency_type', 20)->default('naira');
            $table->date('end_date')->nullable();
            $table->dateTime('submitted_date')->nullable();
            $table->string('submitted_by', 50)->nullable();
            $table->dateTime('approved_date')->nullable();
            $table->string('approved_by', 50)->nullable();
            $table->dateTime('rejection_date')->nullable();
            $table->string('rejected_by', 50)->nullable();
            $table->text('comments_reason')->nullable();
            $table->timestamps();
            $table->index('ref_no');
            $table->softDeletes(); // Add soft delete column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_applications');
    }
};
