<x-app-layout>
    <x-slot name="header">
        <nav class="flex items-center gap-1.5">
            <span>Accueil</span>
            <span class="text-gray-300">/</span>
            <a href="{{ route('users.index') }}" class="hover:text-teal-700">Utilisateurs</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-700 font-medium">Nouveau</span>
        </nav>
    </x-slot>

    <div class="p-4 sm:p-6">
        <div class="max-w-lg mx-auto">
            <h1 class="text-xl font-semibold text-gray-800 mb-5">Nouvel utilisateur</h1>

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

                <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-teal-600 focus:ring-teal-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-teal-600 focus:ring-teal-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        <input type="password" name="password" required
                               class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-teal-600 focus:ring-teal-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" required
                               class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-teal-600 focus:ring-teal-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rôle</label>
                        <select name="role" required class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-teal-600 focus:ring-teal-600">
                            <option value="">-- Sélectionner --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('users.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Annuler</a>
                        <button type="submit"
                                class="bg-teal-700 hover:bg-teal-800 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Créer le compte
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>