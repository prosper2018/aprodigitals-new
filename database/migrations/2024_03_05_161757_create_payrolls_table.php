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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->text('ref_no');
            $table->date('date_from');
            $table->date('date_to');
            $table->tinyInteger('payroll_type');
            $table->tinyInteger('status')->default(0);
            $table->string('posted_user', 50)->nullable();
            $table->string('posted_ip', 30)->nullable();
            $table->bigInteger('posted_userid')->nullable();
            $table->tinyInteger('is_deleted')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
