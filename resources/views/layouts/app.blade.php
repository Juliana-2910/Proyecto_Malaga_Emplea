<!DOCTYPE html>

<html lang="es">

<head>

```
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title', 'Málaga Emplea')</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])
```

</head>

<body class="min-h-screen bg-gray-100 text-gray-800">

```
{{-- Encabezado principal --}}
<header class="bg-[#333333] px-6 py-4 shadow">

    <div class="mx-auto max-w-6xl">

        <h1 class="text-2xl font-bold text-white">
            Málaga Emplea
        </h1>

    </div>

</header>


{{-- Contenido de cada vista --}}
@yield('content')
```

</body>

</html>
