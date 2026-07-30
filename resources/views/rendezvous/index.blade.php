<x-app-layout>
    <x-slot name="header">
        <nav class="flex items-center gap-1.5">
            <span>Accueil</span>
            <span class="text-gray-300">/</span>
            <span class="text-gray-700 font-medium">Rendez-vous</span>
        </nav>
    </x-slot>

    <div class="p-4 sm:p-6">

        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <h1 class="text-xl font-semibold text-gray-800">Rendez-vous</h1>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-800 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-gray-100">

            <div class="px-4 py-3 border-b border-gray-100 text-sm text-gray-500">
                {{ $rendezVous->total() }} rendez-vous
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium">Patient</th>
                            <th class="px-4 py-3 text-left font-medium">Date &amp; heure</th>
                            <th class="px-4 py-3 text-left font-medium">Motif</th>
                            <th class="px-4 py-3 text-left font-medium">Statut</th>
                            <th class="px-4 py-3 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($rendezVous as $rdv)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="{{ route('patients.show', $rdv->patient) }}" class="font-medium text-teal-700 hover:underline">
                                        {{ $rdv->patient->nom_complet }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $rdv->date_rendez_vous->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $rdv->motif ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    <span @class([
                                        'px-2 py-1 rounded-full text-xs font-medium',
                                        'bg-amber-50 text-amber-700' => $rdv->statut === 'en_attente',
                                        'bg-green-50 text-green-700' => $rdv->statut === 'honore',
                                        'bg-red-50 text-red-700' => $rdv->statut === 'annule',
                                    ])>
                                        {{ $rdv->statut }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if ($rdv->statut === 'en_attente')
                                            <form action="{{ route('rendezvous.update', $rdv) }}" method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="statut" value="honore">
                                                <button type="submit" title="Marquer comme honoré"
                                                        class="w-8 h-8 flex items-center justify-center rounded-md bg-green-50 text-green-600 hover:bg-green-100">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('rendezvous.update', $rdv) }}" method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="statut" value="annule">
                                                <button type="submit" title="Annuler"
                                                        class="w-8 h-8 flex items-center justify-center rounded-md bg-red-50 text-red-600 hover:bg-red-100">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-gray-400">Aucun rendez-vous planifié.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-100">
                {{ $rendezVous->links() }}
            </div>
        </div>
    </div>
</x-app-layout>