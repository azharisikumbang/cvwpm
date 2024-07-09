<!-- resources/views/app.blade.php -->

<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Halo' }} - {{ env('APP_NAME') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="global">
    @include('components.top-navbar')

    <div class="flex pt-14 overflow-hidden">
        @include('components.sidebar')

        <div id="main" class="p-4 relative w-full h-full overflow-y-auto lg:ml-64 ml:0 transition-all">
            @yield('breadcrumb')
            @yield('alert')

            <main class="py-4">
                @yield('content')
            </main>
        </div>

    </div>

    <div class="bg-red-200 bg-green-200 bg-yellow-200" style="display:none"></div>
    @yield('script')

</body>

</html>