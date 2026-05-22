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
        Schema::create('court_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('court_id');
            $table->foreign('court_id')->references('id')->on('badminton_courts')->onDelete('cascade');
            $table->string('day')->comment('day of the week: sunday, monday, tuesday, etc.');
            $table->time('open_time');
            $table->time('close_time');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->unsignedInteger('deleted_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('court_schedules');
    }
};
