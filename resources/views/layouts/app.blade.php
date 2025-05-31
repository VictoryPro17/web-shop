<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Victoryss Manga Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-neutral-950 via-gray-900 to-gray-800 min-h-screen">
    <header class="w-full bg-gradient-to-r from-green-700 via-emerald-600 to-lime-500 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center py-6 px-6">
            <div class="text-3xl md:text-4xl font-extrabold tracking-tight text-white drop-shadow-lg">Victoryss Manga Store</div>
            <nav>
                <ul class="flex gap-8 text-lg font-semibold text-white">
                    <li><a href="/" class="hover:text-lime-200 transition">Home</a></li>
                    <li><a href="/shop" class="hover:text-lime-200 transition">Shop</a></li>
                    <li><a href="/abo" class="hover:text-lime-200 transition">Abo</a></li>
                    <li><a href="/login" class="hover:text-lime-200 transition">Login</a></li>
                    <li><a href="/register" class="hover:text-lime-200 transition">Registrieren</a></li>
                </ul>
            </nav>
        </div>
    </header>
    @yield('content')
    <footer class="w-full bg-gray-900 text-gray-300 py-10 mt-16">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-6 gap-6">
            <div class="text-xl font-bold">Victoryss Manga Store</div>
            <div class="flex gap-8 text-lg">
                <a href="/" class="hover:text-lime-400">Home</a>
                <a href="/shop" class="hover:text-lime-400">Shop</a>
                <a href="/abo" class="hover:text-lime-400">Abo</a>
                <a href="#" class="hover:text-lime-400">Kontakt</a>
            </div>
            <div class="text-sm">© 2025 Victoryss Manga Store</div>
        </div>
    </footer>
</body>
</html>
