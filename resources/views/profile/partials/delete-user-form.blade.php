<p class="text-sm text-gray-600 mb-4">
    Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
    Avant de continuer, téléchargez toute donnée que vous souhaitez conserver.
</p>

<button
    type="button"
    x-data
    @click="$dispatch('open-delete-modal')"
    class="bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-md text-sm font-medium"
>
    Supprimer mon compte
</button>

<div
    x-data="{ open: false }"
    x-on:open-delete-modal.window="open = true"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-40 flex items-center justify-center bg-black/40 p-4"
>
    <div @click.outside="open = false" class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-2">Êtes-vous sûr de vouloir supprimer votre compte ?</h3>
        <p class="text-sm text-gray-500 mb-4">Cette action est irréversible. Confirmez avec votre mot de passe.</p>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <x-input-label for="password_delete" value="Mot de passe" class="sr-only" />
            <x-text-input
                id="password_delete"
                name="password"
                type="password"
                class="mt-1 block w-full focus:border-red-500 focus:ring-red-500"
                placeholder="Mot de passe"
            />
            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="open = false" class="px-4 py-2 text-sm text-gray-600">Annuler</button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Supprimer définitivement
                </button>
            </div>
        </form>
    </div>
</div>