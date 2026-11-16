<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bildverwaltung</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="app-background h-dvh overflow-hidden p-3 text-stone-100 antialiased sm:p-4">
    {{ $slot }}
</body>

</html>
