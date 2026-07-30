<x-app-layout>
    <x-slot name="header">
        <nav class="flex items-center gap-1.5">
            <span>Accueil</span>
            <span class="text-gray-300">/</span>
            <span class="text-gray-700 font-medium">Patients</span>
        </nav>
    </x-slot>

    <div class="p-4 sm:p-6">

        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <h1 class="text-xl font-semibold text-gray-800">Patients</h1>
            <a href="{{ route('patients.create') }}"
               class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white px-4 py-2 rounded-md text-sm font-medium shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un patient
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-gray-100">

            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <div class="text-sm text-gray-500">
                    {{ $patients->total() }} patient(s)
                </div>
                <form method="GET" action="{{ route('patients.index') }}">
                    <input type="text" name="q" value="{{ $recherche }}"
                           placeholder="Rechercher..."
                           class="text-sm rounded-md border-gray-300 focus:border-teal-600 focus:ring-teal-600">
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium">N° dossier</th>
                            <th class="px-4 py-3 text-left font-medium">Nom</th>
                            <th class="px-4 py-3 text-left font-medium">Prénom</th>
                            <th class="px-4 py-3 text-left font-medium">Âge</th>
                            <th class="px-4 py-3 text-left font-medium">Sexe</th>
                            <th class="px-4 py-3 text-left font-medium">Téléphone</th>
                            <th class="px-4 py-3 text-left font-medium">Adresse</th>
                            <th class="px-4 py-3 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($patients as $patient)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-500 font-mono text-xs">
                                    {{ str_pad($patient->id, 3, '0', STR_PAD_LEFT) }}/{{ $patient->created_at->format('y') }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $patient->nom }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $patient->prenom }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $patient->date_naissance->age }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $patient->sexe }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $patient->telephone ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $patient->adresse ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1.5">

                                        @can('gerer-rendezvous')
                                            <a href="{{ route('rendezvous.create', $patient) }}" title="Nouveau rendez-vous"
                                               class="w-8 h-8 flex items-center justify-center rounded-md bg-teal-50 text-teal-700 hover:bg-teal-100">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </a>
                                        @endcan

                                        <a href="{{ route('patients.show', $patient) }}" title="Voir le dossier"
                                           class="w-8 h-8 flex items-center justify-center rounded-md bg-amber-50 text-amber-600 hover:bg-amber-100">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('patients.edit', $patient) }}" title="Modifier"
                                           class="w-8 h-8 flex items-center justify-center rounded-md bg-sky-50 text-sky-600 hover:bg-sky-100">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        @role('admin')
                                            <form action="{{ route('patients.destroy', $patient) }}" method="POST"
                                                  onsubmit="return confirm('Supprimer définitivement ce patient et tout son dossier médical ? Cette action est irréversible.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Supprimer"
                                                        class="w-8 h-8 flex items-center justify-center rounded-md bg-red-50 text-red-600 hover:bg-red-100">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endrole

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-gray-400">Aucun patient trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-100">
                {{ $patients->links() }}
            </div>
        </div>
    </div>
</x-app-layout>