<x-app-layout>
    <x-slot name="header">
        <nav class="flex items-center gap-1.5">
            <span>Accueil</span>
            <span class="text-gray-300">/</span>
            <a href="{{ route('patients.index') }}" class="hover:text-teal-700">Patients</a>
            <span class="text-gray-300">/</span>
            <a href="{{ route('patients.show', $patient) }}" class="hover:text-teal-700">{{ $patient->nom_complet }}</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-700 font-medium">Nouveau rendez-vous</span>
        </nav>
    </x-slot>

    <div class="p-4 sm:p-6">
        <div class="max-w-lg mx-auto">
            <h1 class="text-xl font-semibold text-gray-800 mb-5">
                Nouveau rendez-vous — {{ $patient->nom_complet }}
            </h1>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded-md text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('rendezvous.store', $patient) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date et heure</label>
                        <input type="datetime-local" name="date_rendez_vous" value="{{ old('date_rendez_vous') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-teal-600 focus:ring-teal-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Motif (optionnel)</label>
                        <textarea name="motif" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-teal-600 focus:ring-teal-600">{{ old('motif') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('patients.show', $patient) }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Annuler</a>
                        <button type="submit"
                                class="bg-teal-700 hover:bg-teal-800 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Planifier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>