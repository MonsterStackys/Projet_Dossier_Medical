<x-app-layout>
    <x-slot name="header">
        <nav class="flex items-center gap-1.5">
            <span>Accueil</span>
            <span class="text-gray-300">/</span>
            <a href="{{ route('patients.index') }}" class="hover:text-teal-700">Patients</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-700 font-medium">Modifier consultation</span>
        </nav>
    </x-slot>

    <div class="p-4 sm:p-6">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-xl font-semibold text-gray-800 mb-5">Modifier la consultation</h1>

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

                <form method="POST" action="{{ route('consultations.update', $consultation) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date de la consultation</label>
                        <input type="date" name="date" value="{{ old('date', $consultation->date?->format('Y-m-d')) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-teal-600 focus:ring-teal-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Motif</label>
                        <input type="text" name="motif" value="{{ old('motif', $consultation->motif) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-teal-600 focus:ring-teal-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Diagnostic</label>
                        <textarea name="diagnostic" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-teal-600 focus:ring-teal-600">{{ old('diagnostic', $consultation->diagnostic) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Traitement prescrit</label>
                        <textarea name="traitement" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-teal-600 focus:ring-teal-600">{{ old('traitement', $consultation->traitement) }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('consultations.show', $consultation) }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Annuler</a>
                        <button type="submit"
                                class="bg-teal-700 hover:bg-teal-800 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>