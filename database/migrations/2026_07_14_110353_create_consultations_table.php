<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dossier_id')->constrained('dossier_medicals')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // agent traitant
            $table->date('date');
            $table->string('motif');
            $table->text('diagnostic')->nullable();
            $table->text('prescription')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};