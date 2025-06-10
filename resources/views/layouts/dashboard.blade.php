<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NC-WORSHIP - {{$title ?? 'Dashboard'}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap"
          rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body
    class="font-[var(--font-family-base)] text-[var(--color-text-primary)] bg-gradient-to-b from-[var(--color-primary-dark)] to-[var(--color-primary-light)] min-h-screen flex flex-col">
@include('partials.dashboard-header')
<main class="flex-1 p-[var(--spacing-lg)]">
    {{ $slot }}
</main>
@livewireScripts
</body>
</html>
