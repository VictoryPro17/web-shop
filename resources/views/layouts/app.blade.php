<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Victoryss Manga Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-neutral-950 via-gray-900 to-gray-800 min-h-screen">
    <header class="w-full fixed top-0 left-0 z-30 bg-gray-900 bg-opacity-90 backdrop-blur-md flex items-center justify-between px-8 py-4 shadow-lg">
        <a href="/" class="text-2xl md:text-3xl font-extrabold tracking-tight text-white drop-shadow-lg">Victoryss Manga</a>
        <nav class="flex items-center gap-8">
            <a href="/shop" class="text-gray-200 hover:text-blue-400 font-semibold">Shop</a>
            <a href="/abo" class="text-gray-200 hover:text-blue-400 font-semibold">Abo</a>
            <a href="/cart" class="relative text-white hover:text-blue-400"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m13-9l2 9m-5-9V6a2 2 0 10-4 0v3" /></svg></a>
            @auth
            <div class="relative group">
                <button class="flex items-center gap-2 text-white hover:text-blue-400 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 rounded-full bg-gray-700 p-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </button>
                <div class="absolute right-0 mt-2 w-40 bg-gray-800 rounded-lg shadow-lg py-2 opacity-0 group-hover:opacity-100 transition pointer-events-none group-hover:pointer-events-auto">
                    <a href="/profile" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">Profil</a>
                    <form method="POST" action="/logout">@csrf<button type="submit" class="w-full text-left px-4 py-2 text-gray-200 hover:bg-gray-700">Logout</button></form>
                </div>
            </div>
            @else
            <a href="/login" class="text-gray-300 hover:text-blue-400 font-semibold">Login</a>
            <a href="/register" class="text-gray-300 hover:text-blue-400 font-semibold">Registrieren</a>
            @endauth
        </nav>
    </header>
    <main class="pt-28 min-h-[80vh]">
        @yield('content')
    </main>
    <footer class="w-full bg-gray-950 text-gray-400 py-8 mt-16 border-t border-gray-800">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-6 gap-4">
            <div class="text-base">© {{ date('Y') }} Victoryss Manga Store</div>
            <div class="flex gap-6 text-sm">
                <a href="/" class="hover:text-blue-400">Home</a>
                <a href="/shop" class="hover:text-blue-400">Shop</a>
                <a href="/abo" class="hover:text-blue-400">Abo</a>
                <a href="#" class="hover:text-blue-400">Kontakt</a>
            </div>
        </div>
    </footer>
</body>
</html>
