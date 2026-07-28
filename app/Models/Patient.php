<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'sexe',
        'telephone',
        'adresse',
        'groupe_sanguin',
        'antecedents',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'antecedents' => 'encrypted', // donnée médicale sensible chiffrée en base
    ];

    // Un patient a un seul dossier médical
    public function dossierMedical()
    {
        return $this->hasOne(DossierMedical::class);
    }

    // Un patient a plusieurs rendez-vous
    public function rendezVous()
    {
        return $this->hasMany(\App\Models\RendezVous::class);
    }

    // Accesseur pratique pour l'affichage
    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }
}