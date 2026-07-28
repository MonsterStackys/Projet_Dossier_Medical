<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\JournalAudit;

class PatientController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:gerer-patients'),
        ];
    }

    public function index(Request $request)
    {
        $recherche = $request->input('q');

        $patients = Patient::when($recherche, function ($query, $recherche) {
                $query->where('nom', 'like', "%{$recherche}%")
                    ->orWhere('prenom', 'like', "%{$recherche}%")
                    ->orWhere('telephone', 'like', "%{$recherche}%");
            })
            ->orderBy('nom')
            ->paginate(15);

        return view('patients.index', compact('patients', 'recherche'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date|before:today',
            'sexe' => 'required|in:M,F',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'groupe_sanguin' => 'nullable|string|max:5',
            'antecedents' => 'nullable|string',
        ]);

        $patient = Patient::create($data);

        $dossier = $patient->dossierMedical()->create([
            'date_creation' => now(),
            'statut' => 'actif',
        ]);

        JournalAudit::log('creation_patient', $dossier->id, "Création du dossier de {$patient->nom_complet}");

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Patient enregistré avec succès.');
    }

    public function show(Patient $patient)
    {
        $patient->load('dossierMedical.consultations', 'rendezVous');

        // Traçabilité : on journalise chaque consultation d'un dossier médical
        if ($patient->dossierMedical) {
            JournalAudit::log('consultation_dossier', $patient->dossierMedical->id, "Consultation du dossier de {$patient->nom_complet}");
        }

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date|before:today',
            'sexe' => 'required|in:M,F',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'groupe_sanguin' => 'nullable|string|max:5',
            'antecedents' => 'nullable|string',
        ]);

        $patient->update($data);

        JournalAudit::log('modification_patient', $patient->dossierMedical?->id, "Modification des informations de {$patient->nom_complet}");

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Dossier mis à jour.');
    }

    public function destroy(Patient $patient)
    {
        // Suppression définitive réservée à l'admin (traçabilité et prévention
        // des pertes de données médicales par erreur). Préférer l'archivage
        // (toggleArchive) pour un usage courant.
        if (! auth()->user()->hasRole('admin')) {
            abort(403, "Seul l'administrateur peut supprimer définitivement un patient.");
        }

        JournalAudit::log('suppression_patient', null, "Suppression définitive de {$patient->nom_complet}");

        $patient->delete();
        return redirect()->route('patients.index')
            ->with('success', 'Patient supprimé définitivement.');
    }

    // Archive ou réactive le dossier médical du patient (exigence M4)
    public function toggleArchive(Patient $patient)
    {
        $dossier = $patient->dossierMedical;
        $nouveauStatut = $dossier->statut === 'actif' ? 'archive' : 'actif';
        $dossier->update(['statut' => $nouveauStatut]);

        JournalAudit::log('archivage_dossier', $dossier->id, "Statut changé en '{$nouveauStatut}' pour {$patient->nom_complet}");

        $label = $nouveauStatut === 'archive' ? 'archivé' : 'réactivé';

        return redirect()->route('patients.show', $patient)
            ->with('success', "Dossier {$label}.");
    }
}