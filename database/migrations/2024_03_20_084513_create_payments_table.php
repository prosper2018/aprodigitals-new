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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('loan_id')->unsigned();
            $table->bigInteger('staff_id')->unsigned();
            $table->decimal('amount', 50, 2)->default(0.00);
            $table->decimal('penalty_amount', 50, 2)->default(0.00);
            $table->tinyInteger('overdue')->nullable()->default(0)->comment('0=no , 1 = yes');
            $table->tinyInteger('payment_type')->nullable()->default(0)->comment('1=salary deduction , 2 = cash repayment');
            $table->dateTime('date_created')->nullable();
            $table->string('posted_user', 50)->nullable();
            $table->string('posted_ip', 30)->nullable();
            $table->bigInteger('posted_userid')->nullable();
            $table->string('aff_sch_id', 100)->nullable();
            $table->timestamps();
            $table->SoftDeletes();

            $table->foreign('loan_id')->references('id')->on('loan_applications')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
