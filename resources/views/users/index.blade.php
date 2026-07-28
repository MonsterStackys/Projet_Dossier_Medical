<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Utilisateurs</h2>
            <a href="{{ route('users.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-black px-4 py-2 rounded-md text-sm font-medium">
                + Nouvel utilisateur
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rôle</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $user->roles->pluck('name')->join(', ') ?: '—' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm space-x-2">
                                    <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:underline">Modifier</a>
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</x-app-layout>