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
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4">

        <div class="mb-8 flex flex-col items-center">
            <x-application-logo class="w-16 h-16" />
            <span class="mt-3 font-semibold text-gray-700 text-sm tracking-wide">
                {{ config('app.name', 'Gestion Dossiers Médicaux') }}
            </span>
        </div>

        <div class="w-full sm:max-w-md bg-white shadow-sm border border-gray-100 rounded-lg px-6 py-6">
            {{ $slot }}
        </div>

    </div>
</body>
</html>