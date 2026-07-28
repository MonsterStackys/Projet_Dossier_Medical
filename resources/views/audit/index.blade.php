<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Journal d'audit</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @php
                $labels = [
                    'consultation_dossier' => ['Consultation du dossier', 'bg-gray-100 text-gray-700'],
                    'creation_patient' => ['Création patient', 'bg-green-100 text-green-800'],
                    'modification_patient' => ['Modification patient', 'bg-blue-100 text-blue-800'],
                    'suppression_patient' => ['Suppression patient', 'bg-red-100 text-red-800'],
                    'archivage_dossier' => ['Archivage dossier', 'bg-yellow-100 text-yellow-800'],
                    'creation_consultation' => ['Nouvelle consultation', 'bg-green-100 text-green-800'],
                    'modification_consultation' => ['Modification consultation', 'bg-blue-100 text-blue-800'],
                    'suppression_consultation' => ['Suppression consultation', 'bg-red-100 text-red-800'],
                    'creation_rendezvous' => ['Nouveau rendez-vous', 'bg-green-100 text-green-800'],
                    'modification_rendezvous' => ['Modification rendez-vous', 'bg-blue-100 text-blue-800'],
                    'suppression_rendezvous' => ['Suppression rendez-vous', 'bg-red-100 text-red-800'],
                ];
            @endphp

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & heure</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient concerné</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Détail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($entries as $entry)
                            @php
                                [$label, $badgeClass] = $labels[$entry->action] ?? [$entry->action, 'bg-gray-100 text-gray-700'];
                            @endphp
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $entry->created_at->format('d/m/Y H:i:s') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $entry->user->name ?? 'Système' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $entry->dossierMedical->patient->nom_complet ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $entry->description ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Aucune entrée pour l'instant.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $entries->links() }}
            </div>

        </div>
    </div>
</x-app-layout>