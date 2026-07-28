<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouveau patient</h2>
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

                <form method="POST" action="{{ route('patients.store') }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" name="nom" value="{{ old('nom') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Prénom</label>
                            <input type="text" name="prenom" value="{{ old('prenom') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
                            <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sexe</label>
                            <select name="sexe" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">--</option>
                                <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="text" name="telephone" value="{{ old('telephone') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Groupe sanguin</label>
                            <input type="text" name="groupe_sanguin" value="{{ old('groupe_sanguin') }}" placeholder="ex: O+"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Adresse</label>
                        <input type="text" name="adresse" value="{{ old('adresse') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Antécédents médicaux</label>
                        <textarea name="antecedents" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('antecedents') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('patients.index') }}" class="px-4 py-2 text-sm text-gray-600">Annuler</a>
                        <button type="submit"
                                class="bg-black-600 hover:bg-black-700 text-black px-4 py-2 rounded-md text-sm font-medium">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>