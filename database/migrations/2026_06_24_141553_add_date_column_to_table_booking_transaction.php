<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    private $table_name = 'booking_transactions';

    public function up(): void
    {
        if(!Schema::hasColumn($this->table_name, 'date')) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->date('date')->after('court_schedule_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasColumn($this->table_name, 'date')) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->dropColumn('date');
            });
        }
    }
};
