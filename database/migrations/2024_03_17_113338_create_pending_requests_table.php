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
        Schema::create('pending_requests', function (Blueprint $table) {
            $table->id();
            $table->string('link', 100)->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('request_id')->default(0);
            $table->enum('request_type', ['loan', 'leave'])->nullable();
            $table->bigInteger('staff_id')->default(0);
            $table->char('status', 1)->default('0');
            $table->timestamps();
            $table->string('posted_user', 50)->nullable();
            $table->string('posted_ip', 30)->nullable();
            $table->bigInteger('posted_userid')->nullable();
            $table->softDeletes(); // Adds a `deleted_at` column for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_requests');
    }
};
