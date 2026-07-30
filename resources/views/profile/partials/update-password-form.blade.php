<form method="POST" action="{{ route('password.update') }}" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <x-input-label for="current_password" :value="__('Mot de passe actuel')" />
        <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full focus:border-teal-600 focus:ring-teal-600" autocomplete="current-password" />
        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="password" :value="__('Nouveau mot de passe')" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full focus:border-teal-600 focus:ring-teal-600" autocomplete="new-password" />
        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full focus:border-teal-600 focus:ring-teal-600" autocomplete="new-password" />
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white px-4 py-2 rounded-md text-sm font-medium">
            {{ __('Mettre à jour') }}
        </button>

        @if (session('status') === 'password-updated')
            <p class="text-sm text-green-600">{{ __('Mot de passe mis à jour.') }}</p>
        @endif
    </div>
</form>