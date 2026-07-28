<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Patients
            </h2>
            <a href="{{ route('patients.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                + Nouveau patient
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-4 mb-4">
                <form method="GET" action="{{ route('patients.index') }}" class="flex gap-2">
                    <input type="text" name="q" value="{{ $recherche }}"
                           placeholder="Rechercher par nom, prénom ou téléphone..."
                           class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit"
                            class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md text-sm">
                        Rechercher
                    </button>
                </form>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naissance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sexe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Téléphone</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($patients as $patient)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $patient->nom_complet }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $patient->date_naissance->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $patient->sexe }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $patient->telephone ?? '—' }}</td>
                                <td class="px-6 py-4 text-right text-sm space-x-2">
                                    <a href="{{ route('patients.show', $patient) }}" class="text-indigo-600 hover:underline">Voir</a>
                                    <a href="{{ route('patients.edit', $patient) }}" class="text-gray-600 hover:underline">Modifier</a>
                                    @role('admin')
                                        <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Supprimer définitivement ce patient et tout son dossier médical ? Cette action est irréversible.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                                        </form>
                                    @endrole
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Aucun patient trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $patients->links() }}
            </div>

        </div>
    </div>
</x-app-layout>