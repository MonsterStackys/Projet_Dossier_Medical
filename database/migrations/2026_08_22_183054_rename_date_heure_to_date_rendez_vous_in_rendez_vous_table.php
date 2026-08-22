<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('rendez_vous', 'date_heure') && ! Schema::hasColumn('rendez_vous', 'date_rendez_vous')) {
            Schema::table('rendez_vous', function (Blueprint $table) {
                $table->renameColumn('date_heure', 'date_rendez_vous');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('rendez_vous', 'date_rendez_vous') && ! Schema::hasColumn('rendez_vous', 'date_heure')) {
            Schema::table('rendez_vous', function (Blueprint $table) {
                $table->renameColumn('date_rendez_vous', 'date_heure');
            });
        }
    }
};