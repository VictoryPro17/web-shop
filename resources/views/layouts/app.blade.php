<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark Storm</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-neutral-950 via-gray-900 to-gray-800 min-h-screen">
    <header class="w-full fixed top-0 left-0 z-30 bg-gray-900 bg-opacity-90 backdrop-blur-md flex items-center justify-between px-8 py-4 shadow-lg">
        <a href="/" class="flex items-center gap-2 group text-2xl md:text-3xl font-extrabold tracking-tight text-yellow-400 drop-shadow-lg hover:scale-105 transition-transform">
            <svg class="w-8 h-8 animate-blitz" fill="none" stroke="#facc15" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
            DarkStorm
        </a>
        <nav class="flex items-center gap-8">
            <a href="/shop" class="text-gray-200 hover:text-yellow-400 font-semibold transition-colors">Shop</a>
            <a href="/cart" class="relative text-white hover:text-yellow-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke="#facc15" stroke-width="2.2">
                  <path d="M6 6h15l-1.5 9h-11z" stroke="#facc15" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                  <circle cx="9" cy="20" r="1.5" fill="#facc15"/>
                  <circle cx="17" cy="20" r="1.5" fill="#facc15"/>
                  <path d="M6 6L5 2H2" stroke="#facc15" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                @php $cartCount = session('cart') ? collect(session('cart'))->sum('quantity') : 0; @endphp
                @if($cartCount > 0)
                <span class="absolute -top-2 -right-2 bg-yellow-400 text-gray-900 text-xs font-bold rounded-full px-2 py-0.5 shadow-lg animate-bounce-slow border-2 border-gray-900">{{ $cartCount }}</span>
                @endif
            </a>
            <a href="/admin" class="text-gray-200 hover:text-yellow-400 font-semibold transition-colors">Admin</a>
            @auth
            <div class="relative group" x-data="{ open: false }" @keydown.escape="open = false">
                <button class="flex items-center gap-2 text-white hover:text-yellow-400 focus:outline-none transition-colors" id="profileMenuBtn" @click="open = !open" @focus="open = true" @blur="setTimeout(() => open = false, 150)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 rounded-full bg-gray-700 p-1 border-2 border-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    <span class="hidden md:inline font-semibold">Profil</span>
                </button>
                <div class="absolute right-0 mt-2 w-44 bg-gray-800 rounded-lg shadow-lg py-2 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition z-50"
                     :class="{ 'opacity-100 pointer-events-auto': open }"
                     @mouseenter="open = true" @mouseleave="open = false">
                    <a href="/profile" class="block px-4 py-2 text-gray-200 hover:bg-gray-700">Profil anzeigen</a>
                    <form method="POST" action="/logout">@csrf<button type="submit" class="w-full text-left px-4 py-2 text-gray-200 hover:bg-gray-700">Logout</button></form>
                </div>
            </div>
            @else
            <a href="/login" class="text-gray-300 hover:text-yellow-400 font-semibold transition-colors">Login</a>
            <a href="/register" class="text-gray-300 hover:text-yellow-400 font-semibold transition-colors">Registrieren</a>
            @endauth
        </nav>
    </header>
    <main class="pt-28 min-h-[80vh]">
        @yield('content')
    </main>
    <footer class="w-full bg-gray-950 text-gray-500 py-4 mt-12 border-t border-gray-800 text-xs">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-4 gap-2">
            <div class="text-xs">© {{ date('Y') }} DarkStorm</div>
            <div class="flex gap-4 text-xs">
                <a href="/" class="hover:text-yellow-400 transition-colors">Home</a>
                <a href="/shop" class="hover:text-yellow-400 transition-colors">Shop</a>
                <a href="#" class="hover:text-yellow-400 transition-colors">Kontakt</a>
            </div>
        </div>
    </footer>
    <style>
        @keyframes blitz {
            0%,100% { filter: drop-shadow(0 0 0 #facc15); opacity:1; }
            10% { filter: drop-shadow(0 0 16px #facc15); opacity:0.7; }
            20% { filter: drop-shadow(0 0 32px #facc15); opacity:1; }
            30% { filter: drop-shadow(0 0 8px #facc15); opacity:0.8; }
            40% { filter: drop-shadow(0 0 24px #facc15); opacity:1; }
            50% { filter: drop-shadow(0 0 0 #facc15); opacity:1; }
        }
        .animate-blitz { animation: blitz 2.2s infinite; }
        .animate-bounce-slow { animation: bounce-slow 2.5s infinite; }
        @keyframes bounce-slow { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-7px);} }
    </style>
</body>
</html>
