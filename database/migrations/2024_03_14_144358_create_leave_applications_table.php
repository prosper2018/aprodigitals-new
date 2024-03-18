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
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('leave_type')->nullable();
            $table->bigInteger('staff_id')->nullable();
            $table->text('reason')->nullable();
            $table->string('app_document', 200)->nullable();
            $table->date('start_date')->nullable();
            $table->bigInteger('app_status')->nullable()->default(100);
            $table->datetime('end_date')->nullable();
            $table->string('submitted_by', 50)->nullable();
            $table->datetime('approved_date')->nullable();
            $table->string('approved_by', 50)->nullable();
            $table->datetime('rejection_date')->nullable();
            $table->string('rejected_by', 50)->nullable();
            $table->text('comments_reason')->nullable();
            $table->bigInteger('is_deleted')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_applications');
    }
};
