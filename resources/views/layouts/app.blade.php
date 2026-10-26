<!DOCTYPE html>
<html lang="es" data-theme="gothic">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Notas')</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>&#9760;</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700&family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Cormorant+SC:wght@300;400;500;600;700&family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,400&family=Fredoka:wght@300;400;500;600;700&family=Grenze+Gotisch:wght@100;300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&family=Jost:wght@300;400;500;600;700&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Marcellus&family=Marcellus+SC&family=Metal+Mania&family=Oswald:wght@300;400;500;600;700&family=Pirata+One&family=UnifrakturCook:wght@700&family=UnifrakturMaguntia&display=swap" rel="stylesheet">
    <script>
        (function () {
            var themes = ['white', 'dark', 'gothic', 'hellsinger', 'rainbow'];
            try {
                var saved = localStorage.getItem('notas-theme');
                if (saved && themes.indexOf(saved) !== -1) {
                    document.documentElement.dataset.theme = saved;
                }
            } catch (e) { /* ignore */ }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative min-h-screen">
    <div class="aurora aurora-1"></div>
    <div class="aurora aurora-2"></div>
    <div class="aurora aurora-3"></div>

    @yield('content')

    @include('partials.theme-picker')
</body>

</html>
