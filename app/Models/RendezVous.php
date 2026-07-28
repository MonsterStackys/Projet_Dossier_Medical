<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    // Nom de table explicite car la pluralisation automatique de Laravel
    // donnerait "rendez_vouses", ce qui est incorrect.
    protected $table = 'rendez_vous';

    protected $fillable = [
        'patient_id',
        'user_id',
        'date_rendez_vous',
        'statut',
        'motif',
    ];

    protected $casts = [
        'date_rendez_vous' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}