<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{!! url('assets/tinymce/js/tinymce/tinymce.min.js') !!}" referrerpolicy="origin"></script>

        <!-- Styles -->
        @livewireStyles

        <!-- Dark Mode Stuff -->
        <script>
            if (
              localStorage.getItem('color-theme') === 'dark' ||
              (!('color-theme' in localStorage) &&
                window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
              document.documentElement.classList.add('dark');
            } else {
              document.documentElement.classList.remove('dark');
            }
          </script>
    </head>
    @if(session()->has('success'))
    <x-flash/>
    @endif
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-slate-800">
            @livewire('navigation-menu')
            <!-- Page Heading -->
            @if (isset($header))
                <header class="shadow-none sm:shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="h-full">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        <script src="assets/flowbite/js/flowbite.js"></script>
    </body>
</html>
