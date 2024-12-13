<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black:wght@400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .h1 {
            font-family: "Archivo Black", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
    </style>
</head>

<body class="antialiased font-sans text-black/50 bg-gradient-to-b from-[#79c077] to-[#244e22]">
    <div class="min-h-screen grid items-center justify-center">
        <div>
            <h1 class="text-white items-center justify-center flex text-4xl text-center mb-0 ">CAMINHO LIMPO</h1>
        </div>

        <div class="grid justify-items-top">
            <img src="icone.png" alt="Icon" class="mx-auto mt-0 mb-4 lg:h-60 lg:text-[#FF2D20]" />
            @if (Route::has('login'))
                <livewire:welcome.navigation />
            @endif

        </div>
    </div>
</body>

</html>
