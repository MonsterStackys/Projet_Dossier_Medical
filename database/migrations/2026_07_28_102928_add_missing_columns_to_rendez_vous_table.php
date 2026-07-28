<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rendez_vous', function (Blueprint $table) {
            if (! Schema::hasColumn('rendez_vous', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('patient_id')->constrained()->nullOnDelete();
            }
            if (! Schema::hasColumn('rendez_vous', 'motif')) {
                $table->text('motif')->nullable()->after('statut');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rendez_vous', function (Blueprint $table) {
            if (Schema::hasColumn('rendez_vous', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('rendez_vous', 'motif')) {
                $table->dropColumn('motif');
            }
        });
    }
};