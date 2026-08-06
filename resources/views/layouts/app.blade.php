<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="min-h-screen md:flex">

    @include('layouts.sidebar')

    <div class="flex min-w-0 flex-1 flex-col">

        @include('layouts.navbar')

        <main class="flex-1 p-4 md:p-6">

            @include('layouts.flash')

            @yield('content')

        </main>

    </div>

</div>

@include('layouts.mobile-sidebar')

</body>
</html>