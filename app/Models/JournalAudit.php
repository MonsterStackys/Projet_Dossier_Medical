<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalAudit extends Model
{
    public $timestamps = false; // on gère created_at manuellement, pas de updated_at

    protected $fillable = [
        'user_id',
        'action',
        'dossier_id',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dossierMedical()
    {
        return $this->belongsTo(DossierMedical::class, 'dossier_id');
    }

    // Raccourci pour enregistrer une entrée d'audit depuis n'importe où dans le code
    public static function log(string $action, ?int $dossierId = null, ?string $description = null): void
    {
        static::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'dossier_id' => $dossierId,
            'description' => $description,
            'created_at' => now(),
        ]);
    }
}