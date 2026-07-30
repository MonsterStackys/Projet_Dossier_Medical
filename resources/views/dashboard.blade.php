<x-app-layout>
    <x-slot name="header">
        <nav class="flex items-center gap-1.5">
            <span class="text-gray-700 font-medium">Accueil</span>
        </nav>
    </x-slot>

    <div class="p-4 sm:p-6 space-y-6">

        <div>
            <h1 class="text-xl font-semibold text-gray-800">
                Bonjour, {{ explode(' ', Auth::user()->name)[0] }} 👋
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Voici un aperçu de l'activité du Poste de Santé de Khar Yalla.
            </p>
        </div>

        {{-- CARTES STATISTIQUES --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-400 uppercase">Patients</span>
                    <div class="w-9 h-9 rounded-md bg-teal-50 text-teal-700 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-semibold text-gray-800 mt-3">{{ $stats['total_patients'] }}</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-400 uppercase">Dossiers actifs</span>
                    <div class="w-9 h-9 rounded-md bg-green-50 text-green-700 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-semibold text-gray-800 mt-3">{{ $stats['dossiers_actifs'] }}</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-400 uppercase">Consultations (mois)</span>
                    <div class="w-9 h-9 rounded-md bg-sky-50 text-sky-700 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-semibold text-gray-800 mt-3">{{ $stats['consultations_mois'] }}</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-400 uppercase">RDV aujourd'hui</span>
                    <div class="w-9 h-9 rounded-md bg-amber-50 text-amber-700 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-semibold text-gray-800 mt-3">{{ $stats['rendezvous_aujourdhui'] }}</p>
            </div>
        </div>

        {{-- PROCHAINS RENDEZ-VOUS + ACCES RAPIDES --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Prochains rendez-vous</h2>
                @forelse ($prochainsRdv as $rdv)
                    <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0 text-sm">
                        <div>
                            <a href="{{ route('patients.show', $rdv->patient) }}" class="font-medium text-gray-800 hover:text-teal-700">
                                {{ $rdv->patient->nom_complet }}
                            </a>
                            <span class="text-gray-400 ml-2">{{ $rdv->motif ?? 'Sans motif précisé' }}</span>
                        </div>
                        <span class="text-gray-500">{{ $rdv->date_rendez_vous->format('d/m/Y H:i') }}</span>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Aucun rendez-vous à venir.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Accès rapides</h2>
                <div class="space-y-2">
                    @can('gerer-patients')
                        <a href="{{ route('patients.create') }}"
                           class="flex items-center gap-2 text-sm text-gray-700 hover:text-teal-700 hover:bg-teal-50 px-3 py-2 rounded-md">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Nouveau patient
                        </a>
                    @endcan
                    @can('gerer-rendezvous')
                        <a href="{{ route('rendezvous.index') }}"
                           class="flex items-center gap-2 text-sm text-gray-700 hover:text-teal-700 hover:bg-teal-50 px-3 py-2 rounded-md">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Voir les rendez-vous
                        </a>
                    @endcan
                    @can('consulter-audit')
                        <a href="{{ route('audit.index') }}"
                           class="flex items-center gap-2 text-sm text-gray-700 hover:text-teal-700 hover:bg-teal-50 px-3 py-2 rounded-md">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Journal d'audit
                        </a>
                    @endcan
                </div>
            </div>

        </div>
    </div>
</x-app-layout>