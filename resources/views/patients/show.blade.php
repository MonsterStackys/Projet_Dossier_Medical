<x-app-layout>
    <x-slot name="header">
        <nav class="flex items-center gap-1.5">
            <span>Accueil</span>
            <span class="text-gray-300">/</span>
            <a href="{{ route('patients.index') }}" class="hover:text-teal-700">Patients</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-700 font-medium">{{ $patient->nom_complet }}</span>
        </nav>
    </x-slot>

    <div class="p-4 sm:p-6">
        <div class="max-w-4xl mx-auto space-y-5">

            <div class="flex flex-wrap items-center justify-between gap-3">
                <h1 class="text-xl font-semibold text-gray-800">{{ $patient->nom_complet }}</h1>
                <div class="flex items-center gap-2">
                    <a href="{{ route('patients.toggle-archive', $patient) }}"
                       onclick="return confirm('Changer le statut d\'archivage de ce dossier ?');"
                       class="inline-flex items-center gap-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 px-3 py-2 rounded-md text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 01-2-2V4a2 2 0 012-2h14a2 2 0 012 2v2a2 2 0 01-2 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        {{ $patient->dossierMedical->statut === 'actif' ? 'Archiver' : 'Réactiver' }}
                    </a>
                    <a href="{{ route('patients.edit', $patient) }}"
                       class="inline-flex items-center gap-1.5 bg-sky-50 hover:bg-sky-100 text-sky-700 px-3 py-2 rounded-md text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="p-3 bg-green-50 border border-green-200 text-green-800 rounded-md text-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-teal-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Informations personnelles
                    <span @class([
                        'ml-auto px-2 py-0.5 rounded-full text-xs font-medium',
                        'bg-green-50 text-green-700' => $patient->dossierMedical->statut === 'actif',
                        'bg-amber-50 text-amber-700' => $patient->dossierMedical->statut === 'archive',
                    ])>
                        {{ $patient->dossierMedical->statut }}
                    </span>
                </h2>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-400 text-xs uppercase mb-0.5">Date de naissance</dt><dd class="text-gray-800">{{ $patient->date_naissance->format('d/m/Y') }} ({{ $patient->date_naissance->age }} ans)</dd></div>
                    <div><dt class="text-gray-400 text-xs uppercase mb-0.5">Sexe</dt><dd class="text-gray-800">{{ $patient->sexe }}</dd></div>
                    <div><dt class="text-gray-400 text-xs uppercase mb-0.5">Téléphone</dt><dd class="text-gray-800">{{ $patient->telephone ?? '—' }}</dd></div>
                    <div><dt class="text-gray-400 text-xs uppercase mb-0.5">Groupe sanguin</dt><dd class="text-gray-800">{{ $patient->groupe_sanguin ?? '—' }}</dd></div>
                    <div class="col-span-2"><dt class="text-gray-400 text-xs uppercase mb-0.5">Adresse</dt><dd class="text-gray-800">{{ $patient->adresse ?? '—' }}</dd></div>
                    <div class="col-span-2"><dt class="text-gray-400 text-xs uppercase mb-0.5">Antécédents</dt><dd class="text-gray-800">{{ $patient->antecedents ?? '—' }}</dd></div>
                </dl>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Consultations
                    </h2>
                    @can('gerer-consultations')
                        <a href="{{ route('consultations.create', $patient->dossierMedical) }}"
                           class="inline-flex items-center gap-1.5 bg-teal-700 hover:bg-teal-800 text-white px-3 py-1.5 rounded-md text-sm font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Nouvelle consultation
                        </a>
                    @endcan
                </div>
                @forelse ($patient->dossierMedical->consultations ?? [] as $consultation)
                    <a href="{{ route('consultations.show', $consultation) }}"
                       class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0 text-sm hover:bg-gray-50 -mx-2 px-2 rounded">
                        <span class="text-gray-800">{{ $consultation->date?->format('d/m/Y') }} — {{ $consultation->motif }}</span>
                        <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @empty
                    <p class="text-gray-400 text-sm">Aucune consultation enregistrée pour l'instant.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Rendez-vous
                    </h2>
                    @can('gerer-rendezvous')
                        <a href="{{ route('rendezvous.create', $patient) }}"
                           class="inline-flex items-center gap-1.5 bg-teal-700 hover:bg-teal-800 text-white px-3 py-1.5 rounded-md text-sm font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Nouveau rendez-vous
                        </a>
                    @endcan
                </div>
                @forelse ($patient->rendezVous as $rdv)
                    <div class="flex justify-between items-center py-2.5 border-b border-gray-50 last:border-0 text-sm">
                        <span class="text-gray-800">{{ $rdv->date_rendez_vous->format('d/m/Y H:i') }} — {{ $rdv->motif ?? 'Sans motif précisé' }}</span>
                        <span @class([
                            'px-2 py-1 rounded-full text-xs font-medium',
                            'bg-amber-50 text-amber-700' => $rdv->statut === 'en_attente',
                            'bg-green-50 text-green-700' => $rdv->statut === 'honore',
                            'bg-red-50 text-red-700' => $rdv->statut === 'annule',
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