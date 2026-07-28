<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            if (! Schema::hasColumn('consultations', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('dossier_id')->constrained()->nullOnDelete();
            }
            if (! Schema::hasColumn('consultations', 'date')) {
                $table->date('date')->nullable()->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            if (Schema::hasColumn('consultations', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('consultations', 'date')) {
                $table->dropColumn('date');
            }
        });
    }
};