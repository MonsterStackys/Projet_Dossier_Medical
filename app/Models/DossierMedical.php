<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierMedical extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'date_creation',
        'statut',
    ];

    protected $casts = [
        'date_creation' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Module Consultations - à créer à l'étape suivante
    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'dossier_id');
    }
}