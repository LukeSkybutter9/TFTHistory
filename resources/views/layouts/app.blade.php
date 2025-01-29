<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.1/tailwind.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mailtoharshit/San-Francisco-Font-/sanfrancisco.css">
        <link href="{{ asset('css/init.css') }}" rel="stylesheet">
        
        <title>Mi Historial De Partidas</title>
</head>
<body>
    <div id="app" class="supercontainer min-h-screen">
        <nav class="sticky">
            @yield("navegador")
        </nav>
        @yield("historial")
    </div>
    <script src="{{ asset('js/app.js') }}" ></script>
</body>
</html>
