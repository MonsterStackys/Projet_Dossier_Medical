<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\DossierMedical;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\JournalAudit;

class ConsultationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:gerer-consultations'),
        ];
    }

    public function create(DossierMedical $dossier)
    {
        return view('consultations.create', compact('dossier'));
    }

    public function store(Request $request, DossierMedical $dossier)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'motif' => 'required|string|max:255',
            'diagnostic' => 'nullable|string',
            'traitement' => 'nullable|string',
        ]);

        $dossier->consultations()->create([
            ...$data,
            'user_id' => auth()->id(),
        ]);

        JournalAudit::log('creation_consultation', $dossier->id, "Nouvelle consultation pour le dossier #{$dossier->id}");

        return redirect()->route('patients.show', $dossier->patient_id)
            ->with('success', 'Consultation enregistrée.');
    }

    public function show(Consultation $consultation)
    {
        $consultation->load('agent', 'dossierMedical.patient');
        return view('consultations.show', compact('consultation'));
    }

    public function edit(Consultation $consultation)
    {
        return view('consultations.edit', compact('consultation'));
    }

    public function update(Request $request, Consultation $consultation)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'motif' => 'required|string|max:255',
            'diagnostic' => 'nullable|string',
            'traitement' => 'nullable|string',
        ]);

        $consultation->update($data);

        JournalAudit::log('modification_consultation', $consultation->dossier_id, "Modification de la consultation #{$consultation->id}");

        return redirect()->route('patients.show', $consultation->dossierMedical->patient_id)
            ->with('success', 'Consultation mise à jour.');
    }

    public function destroy(Consultation $consultation)
    {
        $patientId = $consultation->dossierMedical->patient_id;
        $dossierId = $consultation->dossier_id;

        JournalAudit::log('suppression_consultation', $dossierId, "Suppression de la consultation #{$consultation->id}");

        $consultation->delete();

        return redirect()->route('patients.show', $patientId)
            ->with('success', 'Consultation supprimée.');
    }
}