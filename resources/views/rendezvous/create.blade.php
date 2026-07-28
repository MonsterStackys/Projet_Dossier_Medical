<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nouveau rendez-vous — {{ $patient->nom_complet }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md">
                        <ul class="list-disc list-inside text-sm">
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
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Motif (optionnel)</label>
                        <textarea name="motif" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('motif') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('patients.show', $patient) }}" class="px-4 py-2 text-sm text-gray-600">Annuler</a>
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-black px-4 py-2 rounded-md text-sm font-medium">
                            Planifier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>