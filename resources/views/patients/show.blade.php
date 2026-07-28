<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $patient->nom_complet }}</h2>
            <div class="space-x-2">
                <a href="{{ route('patients.edit', $patient) }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm">Modifier</a>
                <a href="{{ route('patients.index') }}"
                   class="text-gray-600 text-sm">← Retour à la liste</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Informations personnelles</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-500">Date de naissance</dt><dd>{{ $patient->date_naissance->format('d/m/Y') }}</dd></div>
                    <div><dt class="text-gray-500">Sexe</dt><dd>{{ $patient->sexe }}</dd></div>
                    <div><dt class="text-gray-500">Téléphone</dt><dd>{{ $patient->telephone ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Groupe sanguin</dt><dd>{{ $patient->groupe_sanguin ?? '—' }}</dd></div>
                    <div class="col-span-2"><dt class="text-gray-500">Adresse</dt><dd>{{ $patient->adresse ?? '—' }}</dd></div>
                    <div class="col-span-2"><dt class="text-gray-500">Antécédents</dt><dd>{{ $patient->antecedents ?? '—' }}</dd></div>
                </dl>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-700">Consultations</h3>
                    @can('gerer-consultations')
                        <a href="{{ route('consultations.create', $patient->dossierMedical) }}"
                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-md text-sm font-medium">
                            + Nouvelle consultation
                        </a>
                    @endcan
                </div>
                @forelse ($patient->dossierMedical->consultations ?? [] as $consultation)
                    <a href="{{ route('consultations.show', $consultation) }}"
                       class="block border-b py-2 text-sm hover:bg-gray-50 -mx-2 px-2 rounded">
                        {{ $consultation->date?->format('d/m/Y') }} — {{ $consultation->motif }}
                    </a>
                @empty
                    <p class="text-gray-400 text-sm">Aucune consultation enregistrée pour l'instant.</p>
                @endforelse
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-700">Rendez-vous</h3>
                    @can('gerer-rendezvous')
                        <a href="{{ route('rendezvous.create', $patient) }}"
                           class="bg-indigo-600 hover:bg-indigo-700 text-black px-3 py-1.5 rounded-md text-sm font-medium">
                            + Nouveau rendez-vous
                        </a>
                    @endcan
                </div>
                @forelse ($patient->rendezVous as $rdv)
                    <div class="flex justify-between items-center border-b py-2 text-sm">
                        <span>{{ $rdv->date_rendez_vous->format('d/m/Y H:i') }} — {{ $rdv->motif ?? 'Sans motif précisé' }}</span>
                        <span @class([
                            'px-2 py-1 rounded-full text-xs font-medium',
                            'bg-yellow-100 text-yellow-800' => $rdv->statut === 'en_attente',
                            'bg-green-100 text-green-800' => $rdv->statut === 'honore',
                            'bg-red-100 text-red-800' => $rdv->statut === 'annule',
                        ])>
                            {{ $rdv->statut }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Aucun rendez-vous planifié pour l'instant.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>