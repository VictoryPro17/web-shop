@extends('layouts.app')

@section('content')
@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
$search = request('q');
$page = (int) request('page', 1);
$sort = request('sort');
$mangas = [];
$totalPages = 20; // Jikan API hat viele Seiten, für Demo 20
$fixedPrice = 12.99;

if($search) {
    $response = Http::get('https://api.jikan.moe/v4/manga', ['q'=>$search, 'limit'=>12, 'page'=>$page]);
    $mangas = $response->json('data') ?? [];
} else if($sort === 'trending') {
    // Trending: Top Manga, sortiert nach Popularity
    $response = Http::get('https://api.jikan.moe/v4/top/manga', ['limit'=>12, 'page'=>1, 'filter'=>'bypopularity']);
    $mangas = $response->json('data') ?? [];
} else if($sort === 'new') {
    // Neuheiten: Sortiert nach Startdatum (neuste zuerst)
    $response = Http::get('https://api.jikan.moe/v4/manga', ['order_by'=>'start_date','sort'=>'desc','limit'=>12,'page'=>$page]);
    $mangas = $response->json('data') ?? [];
} else if($sort === 'top') {
    // Top bewertet: Top Manga nach Score
    $response = Http::get('https://api.jikan.moe/v4/top/manga', ['limit'=>12, 'page'=>$page, 'filter'=>'favorite']);
    $mangas = $response->json('data') ?? [];
} else if($sort === 'random') {
    // Zufall: Hole 100 Manga, mische, nimm 12
    $response = Http::get('https://api.jikan.moe/v4/top/manga', ['limit'=>100, 'page'=>rand(1,10)]);
    $all = $response->json('data') ?? [];
    shuffle($all);
    $mangas = array_slice($all, 0, 12);
} else {
    // Standard: Top Manga
    $response = Http::get('https://api.jikan.moe/v4/top/manga', ['limit'=>12, 'page'=>$page]);
    $mangas = $response->json('data') ?? [];
}
@endphp
<style>
/* Subtle animated background */
/* .shop-bg-animated {
  background: linear-gradient(120deg, #232946 0%, #1e293b 100%);
  position: relative;
  overflow: hidden;
}
.shop-bg-animated::before {
  content: '';
  position: absolute;
  top: -20%;
  left: -20%;
  width: 140%;
  height: 140%;
  background: radial-gradient(circle at 60% 40%, rgba(250,221,80,0.08) 0%, rgba(59,130,246,0.07) 100%);
  animation: bgmove 12s linear infinite alternate;
  z-index: 0;
}
@keyframes bgmove {
  0% { transform: scale(1) translate(0,0); }
  100% { transform: scale(1.1) translate(30px, 40px); }
} */
/* Floating lightning bolt */
.floating-bolt {
  position: absolute;
  top: 0.5rem;
  left: 1.5rem;
  z-index: 10;
  animation: floatbolt 3.5s ease-in-out infinite alternate;
}
@keyframes floatbolt {
  0% { transform: translateY(0) rotate(-8deg) scale(1); filter: drop-shadow(0 0 8px #facc15cc); }
  100% { transform: translateY(18px) rotate(8deg) scale(1.08); filter: drop-shadow(0 0 18px #facc15); }
}
/* Animated glowing star */
.animated-star {
  filter: drop-shadow(0 0 8px #facc15cc);
  animation: starpulse 1.8s infinite alternate;
}
@keyframes starpulse {
  0% { filter: drop-shadow(0 0 8px #facc15cc); }
  100% { filter: drop-shadow(0 0 18px #ffe066); }
}
/* Floating shapes for extra creativity */
.floating-shape {
  position: absolute;
  z-index: 1;
  opacity: 0.13;
  pointer-events: none;
  animation: floatshape 8s ease-in-out infinite alternate;
}
.floating-shape.shape1 { top: 10%; left: 8%; animation-delay: 0s; }
.floating-shape.shape2 { top: 60%; left: 80%; animation-delay: 2s; }
.floating-shape.shape3 { top: 80%; left: 20%; animation-delay: 4s; }
@keyframes floatshape {
  0% { transform: translateY(0) scale(1); }
  100% { transform: translateY(-30px) scale(1.08); }
}

/* --- NEW ANIMATIONS & MICRO-INTERACTIONS --- */
/* Live-Käufer Animation */
@keyframes slidein {
  0% { opacity: 0; transform: translateY(60px) scale(0.9); }
  100% { opacity: 1; transform: translateY(0) scale(1); }
}
.animate-slidein { animation: slidein 1.2s cubic-bezier(.6,-0.28,.74,.05) 1; }

/* Manga des Tages Glanz & Glow */
@keyframes gloss {
  0% { opacity: 0.2; left: -80%; }
  60% { opacity: 0.5; left: 110%; }
  100% { opacity: 0; left: 110%; }
}
.animate-gloss::after {
  content: '';
  position: absolute;
  top: 0; left: -80%;
  width: 60%; height: 100%;
  background: linear-gradient(120deg, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0.01) 100%);
  filter: blur(2px);
  pointer-events: none;
  animation: gloss 2.8s cubic-bezier(.4,.2,.6,1) infinite;
}
@keyframes glow {
  0% { box-shadow: 0 0 16px 4px #facc15cc, 0 0 0 0 #60a5fa44; }
  100% { box-shadow: 0 0 32px 8px #facc15cc, 0 0 24px 8px #60a5fa44; }
}
.animate-glow { animation: glow 2.5s alternate infinite; }

/* Blitz Hover Effekt für Buttons */
@keyframes blitzglow {
  0% { box-shadow: 0 0 0 0 #facc15cc; }
  60% { box-shadow: 0 0 16px 8px #facc15cc; }
  100% { box-shadow: 0 0 0 0 #facc15cc; }
}
.animate-blitzglow { animation: blitzglow 2.2s infinite; }

/* Blitz-Icon Animation */
@keyframes blitz {
  0% { filter: drop-shadow(0 0 8px #facc15cc); transform: rotate(-8deg) scale(1); }
  60% { filter: drop-shadow(0 0 18px #ffe066); transform: rotate(8deg) scale(1.08); }
  100% { filter: drop-shadow(0 0 8px #facc15cc); transform: rotate(-8deg) scale(1); }
}
.animate-blitz { animation: blitz 2.2s infinite; }

/* Card Pop Animation */
@keyframes cardpop {
  0% { transform: scale(0.97); opacity: 0.7; }
  100% { transform: scale(1); opacity: 1; }
}
.animate-cardpop { animation: cardpop 0.7s cubic-bezier(.4,.2,.6,1) 1; }

/* Glowtext for Titles */
@keyframes glowtext {
  0% { text-shadow: 0 0 8px #facc15cc, 0 0 0 #60a5fa; }
  100% { text-shadow: 0 0 18px #facc15cc, 0 0 8px #60a5fa; }
}
.animate-glowtext { animation: glowtext 2.5s alternate infinite; }

/* Particles Animation (for extra creativity) */
@keyframes particles {
  0% { opacity: 0.12; transform: translateY(0) scale(1); }
  100% { opacity: 0.22; transform: translateY(-12px) scale(1.04); }
}
.animate-particles::before {
  content: '';
  position: absolute;
  left: 10%; top: 10%; width: 12px; height: 12px;
  background: #facc15; border-radius: 50%; opacity: 0.13;
  animation: particles 2.5s infinite alternate;
}
.animate-particles::after {
  content: '';
  position: absolute;
  right: 12%; bottom: 18%; width: 8px; height: 8px;
  background: #60a5fa; border-radius: 50%; opacity: 0.13;
  animation: particles 3.2s 1s infinite alternate;
}

/* Star Pulse Animation (for SVG stars) */
@keyframes starpulse {
  0% { filter: drop-shadow(0 0 8px #facc15cc); }
  100% { filter: drop-shadow(0 0 18px #ffe066); }
}
.animate-starpulse { animation: starpulse 1.8s infinite alternate; }

/* --- END NEW ANIMATIONS --- */
</style>
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12 px-4">
    <!-- Floating Lightning Bolt for Branding -->
    <svg class="floating-bolt" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#facc15" stroke-width="2.5"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
    <!-- Floating creative shapes -->
    <svg class="floating-shape shape1" width="60" height="60" viewBox="0 0 60 60"><circle cx="30" cy="30" r="28" fill="#facc15"/></svg>
    <svg class="floating-shape shape2" width="80" height="80" viewBox="0 0 80 80"><rect x="10" y="10" width="60" height="60" rx="18" fill="#60a5fa"/></svg>
    <svg class="floating-shape shape3" width="50" height="50" viewBox="0 0 50 50"><polygon points="25,5 45,45 5,45" fill="#f472b6"/></svg>
    <!-- Kreativer Shop-Header mit neuen Funktionen -->
    <div class="flex flex-col items-center mb-10 animate-fadein relative z-10">
        <div class="flex items-center gap-3 mb-4">
            <svg class="w-10 h-10 animate-blitz" fill="none" stroke="#facc15" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
            <span class="text-3xl md:text-4xl font-black text-yellow-400 drop-shadow-lg">DarkStorm Manga Shop</span>
        </div>
        <div class="flex flex-wrap justify-center gap-3 mb-4">
            <a href="{{ url()->current() }}?sort=trending{{ request('q') ? '&q='.urlencode(request('q')) : '' }}" class="px-5 py-2 rounded-full bg-gradient-to-r from-yellow-400 via-yellow-300 to-blue-400 text-gray-900 font-extrabold shadow-lg hover:scale-105 hover:shadow-yellow-400/40 focus:ring-4 focus:ring-yellow-200 transition-all duration-200 flex items-center gap-2 animate-blitz active:scale-95 focus:outline-none @if(request('sort')==='trending') ring-4 ring-yellow-300 @endif">
                <svg class="w-5 h-5" fill="none" stroke="#facc15" stroke-width="2.2" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
                Trending
            </a>
            <a href="{{ url()->current() }}?sort=new{{ request('q') ? '&q='.urlencode(request('q')) : '' }}" class="px-5 py-2 rounded-full bg-gradient-to-r from-blue-500 via-blue-400 to-pink-400 text-white font-extrabold shadow-lg hover:scale-105 hover:shadow-blue-400/40 focus:ring-4 focus:ring-blue-200 transition-all duration-200 flex items-center gap-2 animate-fadein3 active:scale-95 focus:outline-none @if(request('sort')==='new') ring-4 ring-blue-300 @endif">
                <svg class="w-5 h-5" fill="none" stroke="#60a5fa" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#60a5fa"/><path d="M12 6v6l4 2" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Neuheiten
            </a>
            <a href="{{ url()->current() }}?sort=top{{ request('q') ? '&q='.urlencode(request('q')) : '' }}" class="px-5 py-2 rounded-full bg-gradient-to-r from-pink-500 via-yellow-400 to-green-400 text-white font-extrabold shadow-lg hover:scale-105 hover:shadow-pink-400/40 focus:ring-4 focus:ring-pink-200 transition-all duration-200 flex items-center gap-2 animate-fadein4 active:scale-95 focus:outline-none @if(request('sort')==='top') ring-4 ring-pink-300 @endif">
                <svg class="w-5 h-5" fill="none" stroke="#f472b6" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" fill="#f472b6"/></svg>
                Top bewertet
            </a>
        </div>
        <div class="flex flex-wrap justify-center gap-3 mt-2">
            <a href="/cart" class="px-5 py-2 rounded-full bg-gradient-to-r from-green-400 to-blue-500 text-white font-bold shadow hover:scale-105 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="#fff" stroke-width="2.2" viewBox="0 0 24 24"><path d="M6 6h15l-1.5 9h-11z" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="20" r="1.5" fill="#facc15"/><circle cx="17" cy="20" r="1.5" fill="#facc15"/><path d="M6 6L5 2H2" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Warenkorb
            </a>
            <a href="/profile" class="px-5 py-2 rounded-full bg-gradient-to-r from-blue-400 to-yellow-400 text-gray-900 font-bold shadow hover:scale-105 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="#3b82f6" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" fill="#3b82f6"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4" stroke="#3b82f6" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Mein Profil
            </a>
            <a href="/" class="px-5 py-2 rounded-full bg-gradient-to-r from-pink-400 to-blue-400 text-white font-bold shadow hover:scale-105 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="#fff" stroke-width="2.2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Zur Startseite
            </a>
        </div>
        <div class="mt-6 flex flex-wrap justify-center gap-4 text-sm text-blue-200">
            <span class="bg-blue-900/40 px-4 py-2 rounded-full">Kostenloser Versand ab 50€</span>
            <span class="bg-yellow-900/40 px-4 py-2 rounded-full">Sichere Zahlung</span>
            <span class="bg-green-900/40 px-4 py-2 rounded-full">Schneller Support</span>
            <span class="bg-pink-900/40 px-4 py-2 rounded-full">Exklusive Aktionen</span>
        </div>
    </div>
    <div class="flex flex-wrap justify-center gap-4 mb-8 animate-fadein2">
        <form method="GET" action="{{ url()->current() }}" class="flex gap-2 w-full max-w-lg">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Manga suchen..." class="w-full px-4 py-2 rounded bg-gray-800 text-white focus:outline-none focus:ring-4 focus:ring-blue-400 border-2 border-gray-700 focus:border-blue-400 transition" autocomplete="off">
            <input type="hidden" name="sort" value="{{ request('sort') }}">
            <button class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded font-bold shadow-lg focus:ring-4 focus:ring-blue-300 transition active:scale-95">Suchen</button>
        </form>
    </div>
    <!-- FILTER BUTTONS ENTFERNT -->
    <!-- Hier ist Platz für ein neues kreatives Element, z.B. ein animiertes Banner oder ein Info-Panel -->
    <div class="w-full flex justify-center mb-6">
        <div class="bg-gradient-to-r from-blue-900 via-gray-900 to-yellow-900 rounded-2xl px-8 py-4 shadow-xl text-center text-blue-200 font-bold text-lg animate-fadein">
            Entdecke die besten Manga – nutze die Suche oder scrolle durch die Highlights!
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto relative">
        <!-- Manga des Tages Panel (jetzt wie auf der Startseite, nicht immer sichtbar) -->
        @if(!empty($mangas) && isset($mangas[0]))
        <div class="flex justify-center w-full mb-12 z-30 animate-fadein2">
            <div class="w-full max-w-2xl bg-gradient-to-br from-yellow-400/90 via-blue-400/80 to-pink-400/80 rounded-3xl shadow-2xl p-8 flex flex-col md:flex-row items-center gap-6 border-4 border-yellow-300/60 relative overflow-hidden">
                <div class="flex-shrink-0 w-32 h-48 rounded-2xl overflow-hidden shadow-lg relative animate-glow">
                    <img src="{{ $mangas[0]['images']['jpg']['large_image_url'] ?? 'https://placehold.co/400x600?text=Manga' }}" alt="Manga des Tages" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-yellow-400/30 to-transparent pointer-events-none animate-gloss"></div>
                </div>
                <div class="flex flex-col justify-center flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-8 h-8 animate-blitz" fill="none" stroke="#facc15" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
                        <span class="text-2xl font-black text-gray-900 drop-shadow">Manga des Tages</span>
                    </div>
                    <div class="text-xl font-bold text-gray-900 mb-1">{{ $mangas[0]['title'] ?? 'Manga' }}</div>
                    <div class="text-sm text-gray-800 italic mb-2 line-clamp-3 max-h-16 overflow-hidden">{{ Str::limit($mangas[0]['synopsis'] ?? '', 120) }}</div>
                    <a href="{{ route('product.show', $mangas[0]['mal_id'] ?? 1) }}" class="mt-2 px-5 py-2 rounded-full bg-gradient-to-r from-yellow-400 to-blue-500 text-gray-900 font-bold shadow-lg hover:scale-105 hover:shadow-yellow-400/40 focus:ring-4 focus:ring-yellow-300 transition flex items-center gap-2 animate-blitz focus:outline-none">Jetzt entdecken</a>
                </div>
            </div>
        </div>
        @endif
        <!-- Live-Käufer Animation entfernt (JS-Fehler und Anzeigeproblem behoben) -->
        <!-- Hier ist jetzt Platz für ein anderes Feature oder bleibt leer -->
        <!-- Manga Karten -->
        @foreach ($mangas as $manga)
            @php
                $title = $manga['title'] ?? 'Manga';
                $id = $manga['mal_id'] ?? '';
                $img = $manga['images']['jpg']['large_image_url'] ?? 'https://placehold.co/400x600?text=Manga';
                $desc = $manga['synopsis'] ? Str::limit($manga['synopsis'], 60) : '';
                $score = $manga['score'] ?? 4.5;
                $fullStars = floor($score);
                $halfStar = ($score - $fullStars) >= 0.5;
            @endphp
            <div class='bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-3xl shadow-2xl overflow-hidden flex flex-col hover:scale-[1.04] hover:shadow-yellow-400/30 transition-all duration-300 border-2 border-gray-800 group relative animate-cardpop'>
                <div class="absolute top-3 right-3 z-10 flex gap-2">
                    <button onclick="toggleWishlist('{{ $id }}', '{{ addslashes($title) }}', '{{ $img }}')" data-wishlist-id="{{ $id }}" class="text-2xl hover:text-pink-400 transition" title="Zur Wunschliste">
                        <svg class="w-7 h-7" fill="none" stroke="#f472b6" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 21l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.18L12 21z"/></svg>
                    </button>
                </div>
                <div class="relative">
                    <img src='{{ $img }}' alt='{{ $title }}' class='w-full h-72 object-cover rounded-t-2xl group-hover:brightness-110 transition-all duration-300 animate-gloss'>
                    <div class="absolute inset-0 pointer-events-none animate-particles"></div>
                </div>
                <div class='p-6 flex-1 flex flex-col justify-between'>
                    <h3 class='text-2xl font-black mb-2 text-yellow-400 drop-shadow-lg group-hover:text-blue-400 transition animate-glowtext'>{{ $title }}</h3>
                    <p class='text-gray-300 mb-4 text-base italic'>{{ $desc }}</p>
                    <div class='mb-2 flex items-center gap-2'>
                        <span class="text-blue-400 font-bold text-lg">€{{ number_format($fixedPrice,2) }}</span>
                    </div>
                    <form method="POST" action="{{ route('cart.add') }}" class="mt-2">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <input type="hidden" name="title" value="{{ $title }}">
                        <input type="hidden" name="image" value="{{ $img }}">
                        <input type="hidden" name="price" value="{{ $fixedPrice }}">
                        <button type="submit" class='bg-gradient-to-r from-yellow-400 to-blue-500 text-gray-900 font-bold px-5 py-2 rounded-full shadow-lg hover:scale-105 hover:shadow-yellow-400/40 transition-all duration-200 flex items-center gap-2 animate-blitz relative overflow-hidden'>
                            <span class="absolute inset-0 pointer-events-none animate-blitzglow"></span>
                            <svg class="w-5 h-5" fill="none" stroke="#3b82f6" stroke-width="2.2" viewBox="0 0 24 24"><path d="M6 6h15l-1.5 9h-11z" stroke="#3b82f6" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="20" r="1.5" fill="#facc15"/><circle cx="17" cy="20" r="1.5" fill="#facc15"/><path d="M6 6L5 2H2" stroke="#3b82f6" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            In den Warenkorb
                        </button>
                    </form>
                    <a href='{{ route('product.show', $id) }}' class='text-blue-400 hover:underline text-center text-sm mt-3 block'>Details</a>
                    <div class='flex justify-center mt-2'>
                        <span class='flex gap-0.5'>
                            @for ($i = 0; $i < $fullStars; $i++)
                                <svg class='h-6 w-6 text-yellow-400 animate-starpulse' viewBox='0 0 24 24' fill='url(#starGradient)' stroke='none'>
                                    <defs>
                                        <radialGradient id='starGradient' cx='50%' cy='50%' r='80%'>
                                            <stop offset='0%' stop-color='#fffbe6'/>
                                            <stop offset='60%' stop-color='#facc15'/>
                                            <stop offset='100%' stop-color='#fbbf24'/>
                                        </radialGradient>
                                        <filter id='glow' x='-50%' y='-50%' width='200%' height='200%'>
                                            <feGaussianBlur stdDeviation='2.5' result='coloredBlur'/>
                                            <feMerge>
                                                <feMergeNode in='coloredBlur'/>
                                                <feMergeNode in='SourceGraphic'/>
                                            </feMerge>
                                        </filter>
                                    </defs>
                                    <polygon filter='url(#glow)' points='12,2 15,9 22,9.5 17,15 18.5,22 12,18.5 5.5,22 7,15 2,9.5 9,9'/>
                                </svg>
                            @endfor
                            @if($halfStar)
                                <svg class='h-6 w-6 text-yellow-400 animate-starpulse' viewBox='0 0 24 24' fill='url(#starGradient)' stroke='none'>
                                    <defs>
                                        <radialGradient id='starGradient' cx='50%' cy='50%' r='80%'>
                                            <stop offset='0%' stop-color='#fffbe6'/>
                                            <stop offset='60%' stop-color='#facc15'/>
                                            <stop offset='100%' stop-color='#fbbf24'/>
                                        </radialGradient>
                                        <filter id='glow' x='-50%' y='-50%' width='200%' height='200%'>
                                            <feGaussianBlur stdDeviation='2.5' result='coloredBlur'/>
                                            <feMerge>
                                                <feMergeNode in='coloredBlur'/>
                                                <feMergeNode in='SourceGraphic'/>
                                            </feMerge>
                                        </filter>
                                    </defs>
                                    <clipPath id='halfStar'>
                                        <rect x='0' y='0' width='12' height='24'/>
                                    </clipPath>
                                    <polygon filter='url(#glow)' points='12,2 15,9 22,9.5 17,15 18.5,22 12,18.5 5.5,22 7,15 2,9.5 9,9' clip-path='url(#halfStar)'/>
                                </svg>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if(isset($showAbo) && $showAbo && !empty($exclusive) && is_array($exclusive) && count($exclusive))
    <!-- Exklusive Abo-Manga entfernt -->
    @endif
    <!-- Kreativer Bereich statt Abo -->
    <div class="max-w-3xl mx-auto mt-16 bg-gradient-to-br from-blue-900/80 to-gray-900/80 rounded-3xl shadow-2xl p-10 text-white text-center flex flex-col items-center gap-6">
        <h3 class="text-3xl font-black mb-2 text-yellow-400 drop-shadow-lg animate-fadein">DarkStorm Tipp</h3>
        <p class="mb-4 text-blue-200 text-lg animate-fadein2">Entdecke jede Woche neue Manga-Highlights und unsere persönlichen Empfehlungen! Lass dich inspirieren und finde deinen nächsten Lieblingsmanga.</p>
        <div class="flex flex-wrap justify-center gap-4 mt-2 animate-fadein3">
            <span class="bg-yellow-400/20 text-yellow-300 font-bold px-4 py-2 rounded-full shadow">🔥 Top bewertet</span>
            <span class="bg-blue-400/20 text-blue-200 font-bold px-4 py-2 rounded-full shadow">🌟 Geheimtipp</span>
            <span class="bg-pink-400/20 text-pink-200 font-bold px-4 py-2 rounded-full shadow">💡 Neu im Shop</span>
            <span class="bg-green-400/20 text-green-200 font-bold px-4 py-2 rounded-full shadow">👑 Community-Favorit</span>
        </div>
        <a href="/" class="mt-6 px-8 py-3 bg-gradient-to-r from-yellow-400 to-blue-500 text-gray-900 font-bold rounded-full shadow-xl hover:scale-105 transition-transform duration-200 flex items-center gap-2 animate-fadein3">
            <svg class="w-6 h-6" fill="none" stroke="#3b82f6" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
            Zur Startseite
        </a>
    </div>
    <!-- Pagination Buttons ENTFERNT, stattdessen einfache Vor/Zurück-Navigation -->
    <div class="flex justify-center mt-8 gap-4 items-center">
        @if($page > 1)
            <a href="{{ url()->current() }}?page={{ $page-1 }}{{ request('q') ? '&q='.urlencode(request('q')) : '' }}{{ request('sort') ? '&sort='.urlencode(request('sort')) : '' }}" class="px-5 py-2 rounded-full bg-blue-700 text-white font-bold shadow hover:bg-blue-500 transition active:scale-95">&laquo; Zurück</a>
        @endif
        <span class="px-5 py-2 rounded-full bg-gray-800 text-blue-200 font-bold shadow">Seite {{ $page }}</span>
        @if($page < $totalPages)
            <a href="{{ url()->current() }}?page={{ $page+1 }}{{ request('q') ? '&q='.urlencode(request('q')) : '' }}{{ request('sort') ? '&sort='.urlencode(request('sort')) : '' }}" class="px-5 py-2 rounded-full bg-blue-700 text-white font-bold shadow hover:bg-blue-500 transition active:scale-95">Weiter &raquo;</a>
        @endif
    </div>
    <!-- Wunschliste-Panel -->
    <script>
// Wunschliste-Logik (localStorage)
function getWishlist() {
    return JSON.parse(localStorage.getItem('wishlist')||'[]');
}
function setWishlist(list) {
    localStorage.setItem('wishlist', JSON.stringify(list));
}
function toggleWishlist(id, title, img) {
    let list = getWishlist();
    const idx = list.findIndex(m => m.id === id);
    if(idx >= 0) { list.splice(idx,1); } else { list.push({id, title, img}); }
    setWishlist(list);
    renderWishlist();
    updateWishlistIcons();
}
function renderWishlist() {
    const list = getWishlist();
    let html = '';
    if(list.length === 0) html = '<div class="text-blue-200 text-sm">Noch keine Favoriten.</div>';
    else html = list.map(m => `<div class='flex items-center gap-2 mb-2'><img src='${m.img}' class='w-8 h-12 rounded shadow'/> <span class='text-blue-100 font-bold'>${m.title}</span> <button onclick='removeFromWishlist("${m.id}")' class='ml-auto text-pink-400 hover:text-pink-200 text-lg' title='Entfernen'>&times;</button></div>`).join('');
    document.getElementById('wishlist-panel').innerHTML = html;
}
function removeFromWishlist(id) {
    let list = getWishlist();
    setWishlist(list.filter(m => m.id !== id));
    renderWishlist();
    updateWishlistIcons();
}
function updateWishlistIcons() {
    const list = getWishlist();
    document.querySelectorAll('[data-wishlist-id]').forEach(btn => {
        const id = btn.getAttribute('data-wishlist-id');
        if(list.find(m => m.id === id)) btn.classList.add('text-pink-400');
        else btn.classList.remove('text-pink-400');
    });
}
document.addEventListener('DOMContentLoaded', () => {
    renderWishlist();
    updateWishlistIcons();
});
</script>
<div class="fixed bottom-4 right-4 z-40 bg-gray-900/95 border-2 border-yellow-400 rounded-2xl shadow-xl p-4 w-72 max-w-full">
    <div class="flex items-center gap-2 mb-2">
        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="#facc15" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 21l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.18L12 21z"/></svg>
        <span class="font-bold text-yellow-300">Wunschliste</span>
    </div>
    <div id="wishlist-panel"></div>
</div>
<!-- Countdown für Aktionen bei 3 Manga -->
@if(count($mangas) >= 3)
<div class="max-w-2xl mx-auto mt-10 mb-8 bg-gradient-to-r from-yellow-400/80 via-blue-400/80 to-pink-400/80 rounded-2xl shadow-xl p-6 text-center flex flex-col items-center gap-4 animate-fadein2">
    <h3 class="text-2xl font-black text-gray-900 drop-shadow">Aktion: 3 Manga zum Sonderpreis!</h3>
    <div class="text-lg text-blue-900 font-bold">Nur noch <span id="countdown" class="text-pink-600 font-extrabold">05:00</span> Minuten!</div>
    <div class="flex gap-4 mt-2">
        @for($i=0;$i<3;$i++)
            <div class="flex flex-col items-center">
                <img src="{{ $mangas[$i]['images']['jpg']['large_image_url'] ?? '' }}" class="w-20 h-32 rounded shadow-lg mb-2">
                <span class="text-blue-900 font-bold text-sm">{{ $mangas[$i]['title'] ?? '' }}</span>
            </div>
        @endfor
    </div>
    <div class="mt-4 flex flex-col items-center gap-2">
        <div class="text-base text-gray-900 font-bold mb-2">
            <span class="line-through text-pink-700/80 mr-2">{{ number_format(3 * $fixedPrice, 2) }} €</span>
            <span class="bg-pink-500 text-white px-3 py-1 rounded-full font-extrabold animate-blitz">5,00 €</span>
            <span class="ml-2 text-sm text-pink-700 font-bold">Sonderangebot</span>
        </div>
        <form id="special-offer-form" method="POST" action="{{ route('cart.add') }}">
            @csrf
            <input type="hidden" name="special_offer" value="1">
            @for($i=0;$i<3;$i++)
                <input type="hidden" name="ids[]" value="{{ $mangas[$i]['mal_id'] }}">
                <input type="hidden" name="titles[]" value="{{ $mangas[$i]['title'] }}">
                <input type="hidden" name="images[]" value="{{ $mangas[$i]['images']['jpg']['large_image_url'] }}">
            @endfor
            <input type="hidden" name="special_price" value="5.00">
            <button type="submit" class="px-6 py-2 rounded-full bg-pink-500 text-white font-bold shadow hover:bg-pink-400 transition">Alle 3 für 5 € in den Warenkorb</button>
        </form>
    </div>
</div>
<script>
// Countdown-Logik (5 Minuten)
let countdown = 300;
function updateCountdown() {
    let min = Math.floor(countdown/60);
    let sec = countdown%60;
    document.getElementById('countdown').textContent = `${min.toString().padStart(2,'0')}:${sec.toString().padStart(2,'0')}`;
    if(countdown > 0) { countdown--; setTimeout(updateCountdown, 1000); }
}
updateCountdown();
</script>
@endif
@endsection
