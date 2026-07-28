<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier la consultation</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
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

                <form method="POST" action="{{ route('consultations.update', $consultation) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date de la consultation</label>
                        <input type="date" name="date" value="{{ old('date', $consultation->date?->format('Y-m-d')) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Motif</label>
                        <input type="text" name="motif" value="{{ old('motif', $consultation->motif) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Diagnostic</label>
                        <textarea name="diagnostic" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('diagnostic', $consultation->diagnostic) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Traitement prescrit</label>
                        <textarea name="traitement" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('traitement', $consultation->traitement) }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('consultations.show', $consultation) }}" class="px-4 py-2 text-sm text-gray-600">Annuler</a>
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-black px-4 py-2 rounded-md text-sm font-medium">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>