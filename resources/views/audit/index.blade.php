<x-app-layout>
    <x-slot name="header">
        <nav class="flex items-center gap-1.5">
            <span>Accueil</span>
            <span class="text-gray-300">/</span>
            <span class="text-gray-700 font-medium">Audit</span>
        </nav>
    </x-slot>

    <div class="p-4 sm:p-6">

        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <h1 class="text-xl font-semibold text-gray-800">Journal d'audit</h1>
        </div>

        @php
            $labels = [
                'consultation_dossier' => ['Consultation du dossier', 'bg-gray-100 text-gray-700'],
                'creation_patient' => ['Création patient', 'bg-green-50 text-green-700'],
                'modification_patient' => ['Modification patient', 'bg-sky-50 text-sky-700'],
                'suppression_patient' => ['Suppression patient', 'bg-red-50 text-red-700'],
                'archivage_dossier' => ['Archivage dossier', 'bg-amber-50 text-amber-700'],
                'creation_consultation' => ['Nouvelle consultation', 'bg-green-50 text-green-700'],
                'modification_consultation' => ['Modification consultation', 'bg-sky-50 text-sky-700'],
                'suppression_consultation' => ['Suppression consultation', 'bg-red-50 text-red-700'],
                'creation_rendezvous' => ['Nouveau rendez-vous', 'bg-green-50 text-green-700'],
                'modification_rendezvous' => ['Modification rendez-vous', 'bg-sky-50 text-sky-700'],
                'suppression_rendezvous' => ['Suppression rendez-vous', 'bg-red-50 text-red-700'],
            ];
        @endphp

        <div class="bg-white rounded-lg shadow-sm border border-gray-100">

            <div class="px-4 py-3 border-b border-gray-100 text-sm text-gray-500">
                {{ $entries->total() }} entrée(s)
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium">Date &amp; heure</th>
                            <th class="px-4 py-3 text-left font-medium">Agent</th>
                            <th class="px-4 py-3 text-left font-medium">Action</th>
                            <th class="px-4 py-3 text-left font-medium">Patient concerné</th>
                            <th class="px-4 py-3 text-left font-medium">Détail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($entries as $entry)
                            @php
                                [$label, $badgeClass] = $labels[$entry->action] ?? [$entry->action, 'bg-gray-100 text-gray-700'];
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-500">{{ $entry->created_at->format('d/m/Y H:i:s') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $entry->user->name ?? 'Système' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $entry->dossierMedical->patient->nom_complet ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $entry->description ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-gray-400">Aucune entrée pour l'instant.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-100">
                {{ $entries->links() }}
            </div>
        </div>
    </div>
</x-app-layout>