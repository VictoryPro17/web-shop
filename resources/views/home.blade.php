@extends('layouts.app')

@section('content')
@php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
$top = Http::get('https://api.jikan.moe/v4/top/manga', ['limit'=>6])->json('data') ?? [];
$popular = Http::get('https://api.jikan.moe/v4/top/manga', ['limit'=>30, 'page'=>2])->json('data') ?? [];
shuffle($popular);
$popular = array_slice($popular, 0, 3);
@endphp
<div class="flex flex-col items-center w-full min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 relative overflow-hidden">
    <!-- Animated Lightning Bolt Background -->
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none z-0">
        <svg class="absolute animate-bolt-float opacity-30" style="left:10%;top:12%;width:90px;height:90px;" viewBox="0 0 60 60"><g filter="url(#glow)"><path d="M32 4L12 34H28L24 56L48 22H32L32 4Z" fill="#facc15" stroke="#facc15" stroke-width="3"/></g></svg>
        <svg class="absolute animate-bolt-float2 opacity-20" style="right:8%;top:30%;width:60px;height:60px;" viewBox="0 0 60 60"><g filter="url(#glow)"><path d="M32 4L12 34H28L24 56L48 22H32L32 4Z" fill="#2563eb" stroke="#2563eb" stroke-width="3"/></g></svg>
        <svg class="absolute animate-bolt-float3 opacity-20" style="left:20%;bottom:10%;width:70px;height:70px;" viewBox="0 0 60 60"><g filter="url(#glow)"><path d="M32 4L12 34H28L24 56L48 22H32L32 4Z" fill="#facc15" stroke="#facc15" stroke-width="3"/></g></svg>
    </div>
    <!-- Glow-Background + Blitz-Glow -->
    <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[700px] h-[700px] bg-blue-700/20 rounded-full blur-3xl z-0 animate-pulse"></div>
    <section class="w-full max-w-7xl mt-32 px-4 z-10">
        <h1 class="text-5xl md:text-7xl font-black text-center bg-gradient-to-r from-yellow-400 via-blue-500 to-gray-900 bg-clip-text text-transparent mb-8 leading-tight animate-fadein drop-shadow-lg flex items-center justify-center gap-4">
            <span class="relative flex items-center">
                <svg class="inline-block animate-blitz mr-2" width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g filter="url(#glow)">
                        <path d="M32 4L12 34H28L24 56L48 22H32L32 4Z" fill="#facc15" stroke="#facc15" stroke-width="3"/>
                    </g>
                    <defs>
                        <filter id="glow" x="-10" y="-10" width="80" height="80" filterUnits="userSpaceOnUse">
                            <feGaussianBlur stdDeviation="4" result="coloredBlur"/>
                            <feMerge>
                                <feMergeNode in="coloredBlur"/>
                                <feMergeNode in="SourceGraphic"/>
                            </feMerge>
                        </filter>
                    </defs>
                </svg>
                DarkStorm
            </span>
        </h1>
        <p class="text-xl md:text-2xl text-center text-gray-300 mb-12 animate-fadein2">Entdecke die besten Manga, sichere dir exklusive Vorteile und genieße modernes Shopping!</p>
        <div class="flex justify-center mb-12">
            <a href="{{ route('shop') }}" class="px-10 py-4 rounded-full bg-gradient-to-r from-yellow-400 to-blue-600 text-gray-900 text-2xl font-bold shadow-xl hover:scale-105 hover:shadow-2xl transition-all duration-300 animate-bounce-slow flex items-center gap-2">
                <svg class="w-7 h-7 animate-blitz" fill="none" stroke="#facc15" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
                Jetzt Manga entdecken
            </a>
        </div>
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-white mb-4 animate-fadein3">Top Manga</h2>
            <div class="flex gap-6 overflow-x-auto pb-4 snap-x parallax-slider">
                @foreach($top as $i => $manga)
                    <div class="min-w-[220px] max-w-xs bg-gray-800 rounded-2xl shadow-lg p-4 flex flex-col items-center snap-center transition-all duration-300 opacity-0 translate-y-8 animate-manga-fadein parallax-card" style="animation-delay:{{ 0.1 + $i*0.12 }}s; animation-fill-mode:forwards;">
                        <img src="{{ $manga['images']['jpg']['large_image_url'] ?? '' }}" alt="{{ $manga['title'] }}" class="rounded-xl mb-3 shadow-md h-[300px] w-[200px] object-cover transition-transform duration-300 hover:scale-105 hover:shadow-2xl">
                        <div class="font-bold text-lg text-white mb-1">{{ $manga['title'] }}</div>
                        <div class="mb-2">
                            <span class="text-yellow-400 font-bold">€{{ number_format(12.99,2) }}</span>
                        </div>
                        <a href="{{ route('product.show', $manga['mal_id']) }}" class="text-yellow-400 hover:underline text-sm transition-colors">Details</a>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Scroll Down Indicator -->
        <div class="flex flex-col items-center mb-8">
            <div class="scroll-indicator animate-scroll-indicator"></div>
            <span class="text-gray-400 text-xs mt-2 tracking-widest">SCROLL</span>
        </div>
        <div class="mb-16"></div>
    </section>
    <!-- Section 1: Hero-Panel (ohne Buch & Logo, erweitert) -->
    <section class="w-full flex flex-col items-center justify-center py-32 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 relative overflow-visible min-h-[420px]">
        <!-- Animated Lightning Background (optional, falls schon vorhanden) -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <!-- Hier kann ein SVG- oder Canvas-Element für animierte Blitze/Sparkles stehen -->
        </div>
        <div class="relative z-10 flex flex-col items-center gap-6">
            <h1 class="text-5xl md:text-6xl font-black text-yellow-400 drop-shadow-lg tracking-tight animate-fadein">DarkStorm</h1>
            <p class="text-xl md:text-2xl text-blue-200 font-semibold max-w-2xl text-center animate-fadein2">Dein moderner Manga- & Anime-Shop mit Power, Style und Community.<br>Entdecke die besten Stories, sichere dir exklusive Bände und werde Teil der DarkStorm-Community!</p>
            <a href="/shop" class="mt-6 px-8 py-3 bg-gradient-to-r from-yellow-400 to-blue-500 text-gray-900 font-bold rounded-full shadow-xl hover:scale-105 transition-transform duration-200 animate-fadein3 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="#3b82f6" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
                Jetzt Manga entdecken
            </a>
        </div>
    </section>
    <!-- Section 2: Partner & Team -->
    <section class="w-full flex flex-col items-center justify-center py-24 bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800">
        <div class="w-full max-w-3xl mx-auto bg-gray-800/80 rounded-2xl shadow-xl p-10 flex flex-col items-center animated-partner-panel">
            <div class="flex items-center gap-4 mb-4">
                <img src="/logo.png" class="h-12" alt="ibis acam Logo">
                <span class="text-white text-xl font-bold">ibis acam</span>
                <span class="text-gray-400">&</span>
                <span class="text-white text-xl font-bold">Victory</span>
            </div>
            <div class="text-gray-300 mb-4">Entwicklung, Planung &amp; Coding: Victory</div>
            <!-- Testimonial Carousel -->
            <div class="flex flex-col gap-2 w-full mt-4 testimonial-carousel">
                <div class="bg-gray-900/80 rounded-lg px-6 py-4 text-white text-base italic testimonial-item">"Super Shop, alles sehr modern und schnell!" <span class="text-yellow-400 font-bold">– Anna</span></div>
                <div class="bg-gray-900/80 rounded-lg px-6 py-4 text-white text-base italic testimonial-item hidden">"Tolle Auswahl und stylisches Design, 5 Sterne!" <span class="text-yellow-400 font-bold">– Max</span></div>
                <div class="bg-gray-900/80 rounded-lg px-6 py-4 text-white text-base italic testimonial-item hidden">"Endlich ein Manga-Shop, der Spaß macht!" <span class="text-yellow-400 font-bold">– Lisa</span></div>
            </div>
        </div>
    </section>
    <!-- Section: DarkStorm Stats & Community (voll hübsch, kreativ, ohne Buch/Logo) -->
    <section class="w-full flex flex-col items-center justify-center py-24 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 relative overflow-visible">
        <!-- Lightning/Sparkle Background (optional) -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <!-- Optional: SVG/Canvas für animierte Blitze/Sparkles -->
        </div>
        <div class="relative z-10 flex flex-col items-center gap-10 w-full max-w-5xl">
            <h2 class="text-4xl md:text-5xl font-black text-center text-yellow-400 drop-shadow-lg tracking-tight animate-fadein mb-2">DarkStorm Community & Stats</h2>
            <p class="text-lg md:text-xl text-blue-200 font-semibold max-w-2xl text-center animate-fadein2 mb-6">
                Willkommen bei einer kleinen, aber wachsenden Manga-Community aus Österreich!<br>
                Hier findest du alles rund um Manga, Anime, Fandom und mehr.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 w-full animate-fadein3">
                <div class="flex flex-col items-center bg-gray-800/80 rounded-2xl shadow-lg p-6 border-t-4 border-yellow-400 hover:scale-105 transition-transform">
                    <div class="font-black text-3xl text-yellow-400 animated-counter" data-count="36">0</div>
                    <div class="font-bold text-sm mt-1 text-white">Manga im Sortiment</div>
                </div>
                <div class="flex flex-col items-center bg-gray-800/80 rounded-2xl shadow-lg p-6 border-t-4 border-blue-400 hover:scale-105 transition-transform">
                    <div class="font-black text-3xl text-blue-400 animated-counter" data-count="100">0</div>
                    <div class="font-bold text-sm mt-1 text-white">Aktive Leser</div>
                </div>
                <div class="flex flex-col items-center bg-gray-800/80 rounded-2xl shadow-lg p-6 border-t-4 border-green-400 hover:scale-105 transition-transform">
                    <div class="flex items-center gap-1">
                        <span class="text-yellow-400 text-xl">★★★★★</span>
                        <span class="font-black text-xl animated-counter" data-count="5">0</span><span class="font-black text-xl">,0</span>
                    </div>
                    <div class="font-bold text-sm mt-1 text-white">Bewertung</div>
                </div>
                <div class="flex flex-col items-center bg-gray-800/80 rounded-2xl shadow-lg p-6 border-t-4 border-pink-400 hover:scale-105 transition-transform">
                    <div class="font-black text-3xl text-pink-400 animated-counter" data-count="2025">0</div>
                    <div class="font-bold text-sm mt-1 text-white">Seit</div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-8 w-full mt-10 animate-fadein4">
                <div class="flex-1 bg-gradient-to-br from-blue-900/60 to-gray-800/80 rounded-2xl p-8 shadow-xl flex flex-col items-center">
                    <h3 class="text-2xl font-bold text-yellow-300 mb-2">⚡️ Events & Aktionen</h3>
                    <p class="text-gray-200 text-center">Regelmäßige Gewinnspiele, Community-Events und exklusive Manga-Releases warten auf dich!</p>
                </div>
                <div class="flex-1 bg-gradient-to-br from-yellow-900/40 to-gray-800/80 rounded-2xl p-8 shadow-xl flex flex-col items-center">
                    <h3 class="text-2xl font-bold text-blue-300 mb-2">🌟 Community-Forum</h3>
                    <p class="text-gray-200 text-center">Tausche dich mit anderen Fans aus, teile Reviews und entdecke neue Lieblingsmanga!</p>
                </div>
            </div>
            <div class="mt-10 flex flex-col items-center">
                <a href="/register" class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-blue-500 text-gray-900 font-bold rounded-full shadow-xl flex items-center gap-2 opacity-60 cursor-not-allowed pointer-events-none" tabindex="-1" aria-disabled="true">
                    <svg class="w-6 h-6" fill="none" stroke="#3b82f6" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
                    Jetzt kostenlos Mitglied werden
                </a>
                <span class="text-blue-300 text-sm mt-2 animate-fadein2">Werde Teil der DarkStorm-Familie!</span>
            </div>
        </div>
    </section>
</div>
<style>
@keyframes fadein { from { opacity:0; transform:translateY(40px);} to { opacity:1; transform:none; } }
@keyframes fadein2 { from { opacity:0; transform:translateY(20px);} to { opacity:1; transform:none; } }
@keyframes manga-fadein { from { opacity:0; transform:translateY(32px);} to { opacity:1; transform:none; } }
@keyframes bounce-slow { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-10px);} }
@keyframes blitz {
    0%,100% { filter: drop-shadow(0 0 0 #facc15); opacity:1; }
    10% { filter: drop-shadow(0 0 16px #facc15); opacity:0.7; }
    20% { filter: drop-shadow(0 0 32px #facc15); opacity:1; }
    30% { filter: drop-shadow(0 0 8px #facc15); opacity:0.8; }
    40% { filter: drop-shadow(0 0 24px #facc15); opacity:1; }
    50% { filter: drop-shadow(0 0 0 #facc15); opacity:1; }
}
@keyframes simpleBookOpen {
    0% { transform: rotate(-6deg) scale(0.97); box-shadow:0 8px 32px #2563eb44; }
    40% { transform: rotate(0deg) scale(1.04); box-shadow:0 16px 48px #facc1544; }
    60% { transform: rotate(2deg) scale(1.07); box-shadow:0 24px 64px #facc1544; }
    100% { transform: rotate(-6deg) scale(0.97); box-shadow:0 8px 32px #2563eb44; }
}
@keyframes bolt-float { 0%,100%{transform:translateY(0) rotate(-8deg);} 50%{transform:translateY(-18px) rotate(8deg);} }
@keyframes bolt-float2 { 0%,100%{transform:translateY(0) rotate(6deg);} 50%{transform:translateY(12px) rotate(-6deg);} }
@keyframes bolt-float3 { 0%,100%{transform:translateY(0) rotate(0deg);} 50%{transform:translateY(-10px) rotate(12deg);} }
@keyframes scroll-indicator { 0%{opacity:0;transform:translateY(0);} 30%{opacity:1;} 60%{transform:translateY(18px);} 100%{opacity:0;transform:translateY(0);} }
@keyframes pageGlow { 0%{box-shadow:0 2px 16px #facc1533,0 0 0 #facc15cc;} 100%{box-shadow:0 2px 16px #facc1533,0 0 24px #facc15cc;} }
@keyframes partnerGlow { 0%{box-shadow:0 0 0 0 #facc15,0 0 0 0 #2563eb;} 100%{box-shadow:0 0 32px 0 #facc15cc,0 0 24px 0 #2563eb99;} }
@keyframes glow-badge { 0%,100%{box-shadow:0 0 0 #facc15;} 50%{box-shadow:0 0 32px #facc15;} }
@keyframes glow-book { 0%,100%{box-shadow:0 0 0 #3b82f6;} 50%{box-shadow:0 0 32px #3b82f6;} }
@keyframes pulse-glow { 0%,100%{opacity:0.7;} 50%{opacity:1;} }
@keyframes tagline { 0%{opacity:0;transform:translateY(20px);} 100%{opacity:1;transform:none;} }

.scroll-indicator { width:24px; height:36px; border:2px solid #facc15; border-radius:16px; position:relative; }
.scroll-indicator:after { content:''; display:block; width:8px; height:8px; background:#facc15; border-radius:50%; position:absolute; left:50%; top:8px; transform:translateX(-50%); animation:scroll-indicator 1.8s infinite; }

.manga-book-anim {
    width: 160px; height: 200px; position: relative; margin: 0 auto;
    animation: mangaBookOpen 3.5s infinite cubic-bezier(.7,.2,.3,1.1);
}
.book-cover {
    width: 100%; height: 100%; background: linear-gradient(120deg,#2563eb 60%,#facc15 100%);
    border-radius: 18px 18px 12px 12px; box-shadow: 0 8px 32px #2563eb44;
    position: absolute; left: 0; top: 0; z-index: 2;
}
.book-pages {
    width: 92%; height: 92%; background: #fff; border-radius: 14px 14px 10px 10px;
    position: absolute; left: 4%; top: 4%; z-index: 1;
    box-shadow: 0 2px 16px #facc1533;
}
.simple-manga-book {
    width: 120px; height: 150px; position: relative; margin: 0 auto 12px auto;
    animation: simpleBookOpen 3.5s infinite cubic-bezier(.7,.2,.3,1.1);
}
.simple-book-cover {
    width: 100%; height: 100%; background: linear-gradient(120deg,#2563eb 60%,#facc15 100%);
    border-radius: 14px 14px 10px 10px; box-shadow: 0 8px 32px #2563eb44;
    position: absolute; left: 0; top: 0; z-index: 2;
}
.simple-book-pages {
    width: 92%; height: 92%; background: #fff; border-radius: 10px 10px 8px 8px;
    position: absolute; left: 4%; top: 4%; z-index: 1;
    box-shadow: 0 2px 16px #facc1533;
}
.animate-fadein { animation: fadein 1.1s cubic-bezier(.4,0,.2,1) both; }
.animate-fadein2 { animation: fadein2 1.3s .2s cubic-bezier(.4,0,.2,1) both; }
.animate-fadein3 { animation: fadein2 1.3s .4s cubic-bezier(.4,0,.2,1) both; }
.animate-manga-fadein { animation: manga-fadein 0.8s cubic-bezier(.4,0,.2,1) both; }
.animate-bounce-slow { animation: bounce-slow 2.5s infinite; }
.animate-blitz { animation: blitz 2.2s infinite; }
.animate-bolt-float { animation: bolt-float 5s infinite ease-in-out; }
.animate-bolt-float2 { animation: bolt-float2 7s infinite ease-in-out; }
.animate-bolt-float3 { animation: bolt-float3 6s infinite ease-in-out; }
.animate-glow-badge { animation: glow-badge 2.2s infinite; }
.animate-glow-book { animation: glow-book 2.8s infinite; }
.animate-pulse-glow { animation: pulse-glow 2.2s infinite; }
.animate-tagline { animation: tagline 1.2s 1.2s cubic-bezier(.4,0,.2,1) both; }
</style>
<script>
// Animated Counter
function animateCounters() {
    document.querySelectorAll('.animated-counter').forEach(function(el) {
        const target = parseFloat(el.getAttribute('data-count'));
        let current = 0;
        let decimals = (target % 1 !== 0) ? 1 : 0;
        let step = target > 10 ? Math.ceil(target/40) : 0.1;
        function update() {
            current += step;
            if(current >= target) current = target;
            el.textContent = decimals ? current.toFixed(1) : Math.floor(current);
            if(current < target) requestAnimationFrame(update);
            else if(el.getAttribute('data-count')==='5') el.textContent = '5,0 Bewertung';
        }
        update();
    });
}
// Testimonial Carousel
function startTestimonialCarousel() {
    const items = document.querySelectorAll('.testimonial-item');
    let idx = 0;
    setInterval(()=>{
        items.forEach((el,i)=>el.classList.toggle('hidden',i!==idx));
        idx = (idx+1)%items.length;
    }, 3400);
}
window.addEventListener('DOMContentLoaded',()=>{
    animateCounters();
    startTestimonialCarousel();
});
// Sparkle/Particle Effect
(function sparkle() {
    const canvas = document.getElementById('sparkle-canvas');
    if(!canvas) return;
    const ctx = canvas.getContext('2d');
    let particles = Array.from({length: 18}, () => ({
        x: Math.random()*canvas.width,
        y: Math.random()*canvas.height,
        r: 1+Math.random()*2,
        a: Math.random()*2*Math.PI,
        speed: 0.2+Math.random()*0.4,
        color: Math.random() > 0.5 ? '#facc15' : '#3b82f6'
    }));
    function draw() {
        ctx.clearRect(0,0,canvas.width,canvas.height);
        for(const p of particles) {
            ctx.save();
            ctx.globalAlpha = 0.7;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, 2*Math.PI);
            ctx.fillStyle = p.color;
            ctx.shadowColor = p.color;
            ctx.shadowBlur = 8;
            ctx.fill();
            ctx.restore();
            p.x += Math.cos(p.a)*p.speed;
            p.y += Math.sin(p.a)*p.speed;
            if(p.x < 0 || p.x > canvas.width || p.y < 0 || p.y > canvas.height) {
                p.x = Math.random()*canvas.width;
                p.y = Math.random()*canvas.height;
            }
        }
        requestAnimationFrame(draw);
    }
    draw();
})();
</script>
@endsection
