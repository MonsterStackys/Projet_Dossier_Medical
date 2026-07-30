<form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
    @csrf
    @method('PATCH')

    <div>
        <x-input-label for="name" :value="__('Nom')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full focus:border-teal-600 focus:ring-teal-600" :value="old('name', $user->name)" required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full focus:border-teal-600 focus:ring-teal-600" :value="old('email', $user->email)" required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <p class="text-sm mt-2 text-gray-600">
                {{ __('Your email address is unverified.') }}
            </p>
        @endif
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white px-4 py-2 rounded-md text-sm font-medium">
            {{ __('Enregistrer') }}
        </button>

        @if (session('status') === 'profile-updated')
            <p class="text-sm text-green-600">{{ __('Enregistré.') }}</p>
        @endif
    </div>
</form>