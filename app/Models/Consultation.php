<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'dossier_id',
        'user_id',
        'date',
        'motif',
        'diagnostic',
        'prescription',
    ];

    protected $casts = [
        'date' => 'date',
        'diagnostic' => 'encrypted',
        'prescription' => 'encrypted',
    ];

    public function dossierMedical()
    {
        return $this->belongsTo(DossierMedical::class, 'dossier_id');
    }

    // Agent traitant (médecin/infirmier) qui a réalisé la consultation
    public function agent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}