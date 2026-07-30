<x-app-layout>
    <x-slot name="header">
        <nav class="flex items-center gap-1.5">
            <span>Accueil</span>
            <span class="text-gray-300">/</span>
            <span class="text-gray-700 font-medium">Profil</span>
        </nav>
    </x-slot>

    <div class="p-4 sm:p-6">
        <div class="max-w-2xl mx-auto space-y-6">

            <h1 class="text-xl font-semibold text-gray-800">Mon profil</h1>

            @if (session('status') === 'photo-updated')
                <div class="p-3 bg-green-50 border border-green-200 text-green-800 rounded-md text-sm">Photo de profil mise à jour.</div>
            @elseif (session('status') === 'photo-removed')
                <div class="p-3 bg-green-50 border border-green-200 text-green-800 rounded-md text-sm">Photo de profil supprimée.</div>
            @endif

            {{-- PHOTO DE PROFIL --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Photo de profil</h2>

                <div class="flex items-center gap-5">
                    @if ($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                             class="w-16 h-16 rounded-full object-cover border border-gray-200">
                    @else
                        <span class="w-16 h-16 rounded-full bg-teal-700 text-white flex items-center justify-center text-xl font-semibold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    @endif

                    <div class="flex items-center gap-2">
                        <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                            @csrf
                            <label class="cursor-pointer bg-sky-50 hover:bg-sky-100 text-sky-700 px-3 py-2 rounded-md text-sm font-medium">
                                Changer la photo
                                <input type="file" name="photo" accept="image/*" class="hidden" onchange="this.form.submit()">
                            </label>
                        </form>

                        @if ($user->avatar_path)
                            <form action="{{ route('profile.photo.destroy') }}" method="POST"
                                  onsubmit="return confirm('Supprimer la photo de profil ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-700 px-3 py-2 rounded-md text-sm font-medium">
                                    Retirer
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @error('photo')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-400 mt-3">JPG, PNG — 2 Mo maximum.</p>
            </div>

            {{-- INFORMATIONS --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Informations personnelles</h2>
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- MOT DE PASSE --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Modifier le mot de passe</h2>
                @include('profile.partials.update-password-form')
            </div>

            {{-- SUPPRESSION DU COMPTE --}}
            <div class="bg-white rounded-lg shadow-sm border border-red-100 p-6">
                <h2 class="text-sm font-semibold text-red-700 mb-4">Zone sensible</h2>
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>