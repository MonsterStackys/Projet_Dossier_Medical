<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rendez-vous</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & heure</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motif</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($rendezVous as $rdv)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <a href="{{ route('patients.show', $rdv->patient) }}" class="hover:underline">
                                        {{ $rdv->patient->nom_complet }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $rdv->date_rendez_vous->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $rdv->motif ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span @class([
                                        'px-2 py-1 rounded-full text-xs font-medium',
                                        'bg-yellow-100 text-yellow-800' => $rdv->statut === 'en_attente',
                                        'bg-green-100 text-green-800' => $rdv->statut === 'honore',
                                        'bg-red-100 text-red-800' => $rdv->statut === 'annule',
                                    ])>
                                        {{ $rdv->statut }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm space-x-2">
                                    @if ($rdv->statut === 'en_attente')
                                        <form action="{{ route('rendezvous.update', $rdv) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="statut" value="honore">
                                            <button type="submit" class="text-green-600 hover:underline">Honorer</button>
                                        </form>
                                        <form action="{{ route('rendezvous.update', $rdv) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="statut" value="annule">
                                            <button type="submit" class="text-red-600 hover:underline">Annuler</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Aucun rendez-vous planifié.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $rendezVous->links() }}
            </div>

        </div>
    </div>
</x-app-layout>