<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            if (!Schema::hasColumn('promos', 'start_date')) {
                $table->date('start_date')->nullable();
            }
            if (!Schema::hasColumn('promos', 'end_date')) {
                $table->date('end_date')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            if (Schema::hasColumn('promos', 'start_date')) {
                $table->dropColumn('start_date');
            }
            if (Schema::hasColumn('promos', 'end_date')) {
                $table->dropColumn('end_date');
            }
        });
    }
};
