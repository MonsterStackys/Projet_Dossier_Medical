<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\JournalAudit;

class RendezVousController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:gerer-rendezvous'),
        ];
    }

    public function index()
    {
        $rendezVous = RendezVous::with('patient')
            ->orderBy('date_rendez_vous')
            ->paginate(20);

        return view('rendezvous.index', compact('rendezVous'));
    }

    public function create(Patient $patient)
    {
        return view('rendezvous.create', compact('patient'));
    }

    public function store(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'date_rendez_vous' => 'required|date|after:now',
            'motif' => 'nullable|string',
        ]);

        $rendezvous = $patient->rendezVous()->create([
            ...$data,
            'user_id' => auth()->id(),
            'statut' => 'en_attente',
        ]);

        JournalAudit::log('creation_rendezvous', $patient->dossierMedical?->id, "Rendez-vous planifié le {$rendezvous->date_rendez_vous->format('d/m/Y H:i')} pour {$patient->nom_complet}");

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Rendez-vous planifié.');
    }

    public function update(Request $request, RendezVous $rendezvous)
    {
        $data = $request->validate([
            'statut' => 'required|in:en_attente,honore,annule',
        ]);

        $ancienStatut = $rendezvous->statut;
        $rendezvous->update($data);

        JournalAudit::log('modification_rendezvous', $rendezvous->patient->dossierMedical?->id, "Statut du rendez-vous #{$rendezvous->id} changé de '{$ancienStatut}' à '{$data['statut']}'");

        return back()->with('success', 'Statut du rendez-vous mis à jour.');
    }

    public function destroy(RendezVous $rendezvous)
    {
        $patientId = $rendezvous->patient_id;

        JournalAudit::log('suppression_rendezvous', $rendezvous->patient->dossierMedical?->id, "Suppression du rendez-vous #{$rendezvous->id}");

        $rendezvous->delete();

        return redirect()->route('patients.show', $patientId)
            ->with('success', 'Rendez-vous supprimé.');
    }
}