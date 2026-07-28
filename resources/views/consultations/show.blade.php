<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Consultation du {{ $consultation->date?->format('d/m/Y') }} — {{ $consultation->dossierMedical->patient->nom_complet }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <dl class="space-y-4 text-sm">
                    <div>
                        <dt class="text-gray-500">Agent traitant</dt>
                        <dd>{{ $consultation->agent->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Motif</dt>
                        <dd>{{ $consultation->motif }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Diagnostic</dt>
                        <dd>{{ $consultation->diagnostic ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Traitement prescrit</dt>
                        <dd>{{ $consultation->traitement ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('patients.show', $consultation->dossierMedical->patient_id) }}" class="text-gray-600 text-sm">← Retour au dossier patient</a>
                <div class="space-x-2">
                    <a href="{{ route('consultations.edit', $consultation) }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm">Modifier</a>
                    <form action="{{ route('consultations.destroy', $consultation) }}" method="POST" class="inline"
                          onsubmit="return confirm('Supprimer cette consultation ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-md text-sm">Supprimer</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>