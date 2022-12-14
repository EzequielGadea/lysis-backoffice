<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/output.css') }}">
    @livewireStyles
    <title>{{ $title ?? 'Lysis backoffice' }}</title>
</head>
<body class="flex flex-row justify-center">
    {{ $slot }}
    @livewireScripts
</body>
</html>