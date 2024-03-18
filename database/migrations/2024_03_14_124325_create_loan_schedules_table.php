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
        Schema::create('loan_schedules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('resch_id')->nullable();
            $table->bigInteger('loan_id')->nullable(false);
            $table->decimal('pre_amount_due', 50, 2)->nullable();
            $table->date('pre_date_due')->nullable();
            $table->decimal('amount_due', 50, 2)->nullable(false);
            $table->date('date_due')->nullable(false);
            $table->decimal('paid_amount', 50, 2)->nullable();
            $table->decimal('outstanding_amount', 50, 2)->nullable();
            $table->string('reason_comment', 100)->nullable()->default('0');
            $table->datetime('date_created')->nullable();
            $table->string('posted_user', 50)->nullable();
            $table->string('posted_ip', 30)->nullable();
            $table->bigInteger('posted_userid')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Add soft delete column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_schedules');
    }
};
