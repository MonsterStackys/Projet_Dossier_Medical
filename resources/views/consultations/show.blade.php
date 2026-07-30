<x-app-layout>
    <x-slot name="header">
        <nav class="flex items-center gap-1.5">
            <span>Accueil</span>
            <span class="text-gray-300">/</span>
            <a href="{{ route('patients.index') }}" class="hover:text-teal-700">Patients</a>
            <span class="text-gray-300">/</span>
            <a href="{{ route('patients.show', $consultation->dossierMedical->patient_id) }}" class="hover:text-teal-700">{{ $consultation->dossierMedical->patient->nom_complet }}</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-700 font-medium">Consultation</span>
        </nav>
    </x-slot>

    <div class="p-4 sm:p-6">
        <div class="max-w-2xl mx-auto space-y-4">

            <h1 class="text-xl font-semibold text-gray-800">
                Consultation du {{ $consultation->date?->format('d/m/Y') }}
            </h1>

            @if (session('success'))
                <div class="p-3 bg-green-50 border border-green-200 text-green-800 rounded-md text-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <dl class="space-y-4 text-sm">
                    <div>
                        <dt class="text-gray-400 text-xs uppercase mb-0.5">Agent traitant</dt>
                        <dd class="text-gray-800">{{ $consultation->agent->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 text-xs uppercase mb-0.5">Motif</dt>
                        <dd class="text-gray-800">{{ $consultation->motif }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 text-xs uppercase mb-0.5">Diagnostic</dt>
                        <dd class="text-gray-800">{{ $consultation->diagnostic ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400 text-xs uppercase mb-0.5">Traitement prescrit</dt>
                        <dd class="text-gray-800">{{ $consultation->traitement ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('patients.show', $consultation->dossierMedical->patient_id) }}" class="text-sm text-gray-600 hover:text-gray-800">← Retour au dossier patient</a>
                <div class="flex items-center gap-2">
                    <a href="{{ route('consultations.edit', $consultation) }}"
                       class="inline-flex items-center gap-1.5 bg-sky-50 hover:bg-sky-100 text-sky-700 px-3 py-2 rounded-md text-sm font-medium">
                        Modifier
                    </a>
                    <form action="{{ route('consultations.destroy', $consultation) }}" method="POST"
                          onsubmit="return confirm('Supprimer cette consultation ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-700 px-3 py-2 rounded-md text-sm font-medium">Supprimer</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>