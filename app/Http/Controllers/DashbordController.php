<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Consultation;
use App\Models\RendezVous;
use App\Models\DossierMedical;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'dossiers_actifs' => DossierMedical::where('statut', 'actif')->count(),
            'dossiers_archives' => DossierMedical::where('statut', 'archive')->count(),
            'consultations_mois' => Consultation::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->count(),
            'rendezvous_aujourdhui' => RendezVous::whereDate('date_rendez_vous', today())
                ->where('statut', 'en_attente')
                ->count(),
        ];

        $prochainsRdv = RendezVous::with('patient')
            ->where('statut', 'en_attente')
            ->where('date_rendez_vous', '>=', now())
            ->orderBy('date_rendez_vous')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'prochainsRdv'));
    }
}