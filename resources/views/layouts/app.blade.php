<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gestion Dossiers Médicaux') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="fixed inset-y-0 left-0 z-30 w-64 bg-teal-950 text-teal-100 transform transition-transform duration-200 lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div class="flex items-center gap-3 px-5 h-16 border-b border-teal-900">
                <x-application-logo class="w-9 h-9 shrink-0" />
                <span class="font-semibold text-white leading-tight text-sm">
                    {{ config('app.name', 'Gestion Dossiers Médicaux') }}
                </span>
            </div>

            <nav class="px-3 py-4 space-y-1 text-sm">

                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md transition {{ request()->routeIs('dashboard') ? 'bg-teal-800 text-white' : 'text-teal-200 hover:bg-teal-900 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h4a1 1 0 001-1V10" />
                    </svg>
                    Accueil
                </a>

                <a href="{{ route('patients.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md transition {{ request()->routeIs('patients.*') ? 'bg-teal-800 text-white' : 'text-teal-200 hover:bg-teal-900 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Patients
                </a>

                <a href="{{ route('rendezvous.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md transition {{ request()->routeIs('rendezvous.*') ? 'bg-teal-800 text-white' : 'text-teal-200 hover:bg-teal-900 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Rendez-vous
                </a>

                @can('gerer-utilisateurs')
                    <a href="{{ route('users.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-md transition {{ request()->routeIs('users.*') ? 'bg-teal-800 text-white' : 'text-teal-200 hover:bg-teal-900 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-1a4 4 0 00-4-4h-1M9 20H4v-1a4 4 0 014-4h1m0-4a3 3 0 100-6 3 3 0 000 6zm7 0a3 3 0 100-6 3 3 0 000 6z" />
                        </svg>
                        Utilisateurs
                    </a>
                @endcan

                @can('consulter-audit')
                    <a href="{{ route('audit.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-md transition {{ request()->routeIs('audit.*') ? 'bg-teal-800 text-white' : 'text-teal-200 hover:bg-teal-900 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Audit
                    </a>
                @endcan

            </nav>
        </aside>

        {{-- Overlay mobile --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
             class="fixed inset-0 z-20 bg-black/40 lg:hidden"></div>

        {{-- CONTENU --}}
        <div class="flex-1 flex flex-col lg:pl-64">

            {{-- BARRE DU HAUT --}}
            <header class="sticky top-0 z-10 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6">

                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="text-sm text-gray-500 hidden sm:block">
                        {{ $header ?? '' }}
                    </div>

                    <div x-data="{ open: false }" class="relative ml-auto">
                        <button @click="open = !open" @click.outside="open = false"
                                class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                            @if (Auth::user()->avatar_url)
                                <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}"
                                     class="w-8 h-8 rounded-full object-cover">
                            @else
                                <span class="w-8 h-8 rounded-full bg-teal-700 text-white flex items-center justify-center text-xs font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            @endif
                            {{ Auth::user()->name }}
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" x-cloak x-transition
                             class="absolute right-0 mt-2 w-44 bg-white rounded-md shadow-lg border border-gray-100 py-1">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- TITRE DE PAGE (mobile) --}}
            @isset($header)
                <div class="sm:hidden bg-white border-b border-gray-200 px-4 py-3 text-sm text-gray-600">
                    {{ $header }}
                </div>
            @endisset

            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>

</body>
</html>