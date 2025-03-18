<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ $title ?? 'Welcome' }} - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css'])
</head>

<body>
    @yield('content')
    @yield('script')
</body>

</html>