@extends('layouts.app')

@section('content')
@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
$search = request('q');
$page = (int) request('page', 1);
$mangas = [];
$exclusive = [];
$showAbo = auth()->check() && (auth()->user()->is_abo ?? false);
$totalPages = 20; // Jikan API hat viele Seiten, für Demo 20
$fixedPrice = 12.99;
$aboPrice = number_format($fixedPrice * 0.9, 2);
if($search) {
    $response = Http::get('https://api.jikan.moe/v4/manga', ['q'=>$search, 'limit'=>12, 'page'=>$page]);
    $mangas = $response->json('data') ?? [];
} else {
    $response = Http::get('https://api.jikan.moe/v4/top/manga', ['limit'=>12, 'page'=>$page]);
    $mangas = $response->json('data') ?? [];
    if($showAbo) {
        $ex = Http::get('https://api.jikan.moe/v4/top/manga', ['limit'=>100, 'page'=>2]);
        $all = $ex->json('data') ?? [];
        shuffle($all);
        $exclusive = array_slice($all, 0, 3);
    }
}
@endphp
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12 px-4">
    <h2 class="text-4xl font-extrabold text-white mb-10 text-center">@if($search) Suchergebnis @else Top Manga @endif</h2>
    <form method="GET" action="" class="flex justify-center mb-8">
        <input type="text" name="q" value="{{ $search }}" placeholder="Manga suchen..." class="w-96 px-4 py-2 rounded-l bg-gray-800 text-white focus:outline-none" autocomplete="off">
        <button class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-r font-bold">Suchen</button>
    </form>
    <!-- Swipebare Pagination: Mobile = swipe, Desktop = Buttons -->
    <div class="flex justify-center mb-8 gap-2 items-center">
        <!-- Mobile: swipebar -->
        <div class="flex gap-2 overflow-x-auto scrollbar-hide md:hidden w-full max-w-xs" style="-webkit-overflow-scrolling: touch;">
            @for ($p = max(1, $page-2); $p <= min($totalPages, $page+2); $p++)
                <a href="?q={{ urlencode($search) }}&page={{ $p }}" class="px-3 py-1 rounded @if($page==$p) bg-blue-600 text-white @else bg-gray-700 text-gray-300 hover:bg-blue-500 hover:text-white @endif whitespace-nowrap mx-0.5">{{ $p }}</a>
            @endfor
        </div>
        <!-- Desktop: klassische Buttons -->
        <div class="hidden md:flex gap-2">
            <a href="?q={{ urlencode($search) }}&page={{ max(1, $page-1) }}" class="px-3 py-1 rounded bg-gray-700 text-gray-300 hover:bg-blue-500 hover:text-white @if($page==1) opacity-50 pointer-events-none @endif">&laquo;</a>
            @for ($p = max(1, $page-2); $p <= min($totalPages, $page+2); $p++)
                <a href="?q={{ urlencode($search) }}&page={{ $p }}" class="px-3 py-1 rounded @if($page==$p) bg-blue-600 text-white @else bg-gray-700 text-gray-300 hover:bg-blue-500 hover:text-white @endif">{{ $p }}</a>
            @endfor
            <a href="?q={{ urlencode($search) }}&page={{ min($totalPages, $page+1) }}" class="px-3 py-1 rounded bg-gray-700 text-gray-300 hover:bg-blue-500 hover:text-white @if($page==$totalPages) opacity-50 pointer-events-none @endif">&raquo;</a>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
        @forelse ($mangas as $manga)
            @php
                $title = $manga['title'] ?? 'Manga';
                $id = $manga['mal_id'] ?? '';
                $img = $manga['images']['jpg']['large_image_url'] ?? 'https://placehold.co/400x600?text=Manga';
                $desc = $manga['synopsis'] ? Str::limit($manga['synopsis'], 60) : '';
            @endphp
            <div class='bg-gray-800 rounded-2xl shadow-xl overflow-hidden flex flex-col hover:scale-105 transition'>
                <img src='{{ $img }}' alt='{{ $title }}' class='w-full h-72 object-cover'>
                <div class='p-6 flex-1 flex flex-col justify-between'>
                    <h3 class='text-xl font-bold mb-2 text-white'>{{ $title }}</h3>
                    <p class='text-gray-400 mb-4 text-sm'>{{ $desc }}</p>
                    <div class='mb-2'>
                        @if($showAbo)
                            <span class="text-gray-400 line-through mr-2">€{{ number_format($fixedPrice,2) }}</span>
                            <span class="text-blue-400 font-bold">€{{ $aboPrice }}</span>
                        @else
                            <span class="text-blue-400 font-bold">€{{ number_format($fixedPrice,2) }}</span>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <input type="hidden" name="title" value="{{ $title }}">
                        <input type="hidden" name="image" value="{{ $img }}">
                        <input type="hidden" name="price" value="{{ $showAbo ? $aboPrice : $fixedPrice }}">
                        <button type="submit" class='bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold transition mb-2'>In den Warenkorb</button>
                    </form>
                    <a href='{{ route('product.show', $id) }}' class='text-blue-400 hover:underline text-center text-sm'>Details</a>
                    <div class='flex justify-center mt-2'>
                        <span class='flex'>
                            <svg class='h-5 w-5 text-yellow-400' fill='currentColor' viewBox='0 0 20 20'><path d='M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.175 0l-3.38 2.454c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.05 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z'/></svg>
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-gray-400 col-span-3">Keine Manga gefunden.</div>
        @endforelse
    </div>
    @if($showAbo && count($exclusive))
    <div class="max-w-2xl mx-auto mt-16 bg-blue-900 bg-opacity-80 rounded-2xl shadow-xl p-8 text-white text-center">
        <h3 class="text-2xl font-bold mb-2">Exklusive Abo-Manga</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            @foreach($exclusive as $manga)
                <div class="bg-gray-700 rounded-xl p-4 flex flex-col items-center">
                    <img src="{{ $manga['images']['jpg']['large_image_url'] ?? '' }}" class="h-40 mb-2 rounded shadow">
                    <div class="font-bold text-white text-base mb-1">{{ $manga['title'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
    <div class="flex justify-center mt-8 gap-2 items-center">
        <a href="?q={{ urlencode($search) }}&page={{ max(1, $page-1) }}" class="px-3 py-1 rounded bg-gray-700 text-gray-300 hover:bg-blue-500 hover:text-white @if($page==1) opacity-50 pointer-events-none @endif">&laquo;</a>
        @for ($p = max(1, $page-2); $p <= min($totalPages, $page+2); $p++)
            <a href="?q={{ urlencode($search) }}&page={{ $p }}" class="px-3 py-1 rounded @if($page==$p) bg-blue-600 text-white @else bg-gray-700 text-gray-300 hover:bg-blue-500 hover:text-white @endif">{{ $p }}</a>
        @endfor
        <a href="?q={{ urlencode($search) }}&page={{ min($totalPages, $page+1) }}" class="px-3 py-1 rounded bg-gray-700 text-gray-300 hover:bg-blue-500 hover:text-white @if($page==$totalPages) opacity-50 pointer-events-none @endif">&raquo;</a>
    </div>
    <div class="max-w-2xl mx-auto mt-16 bg-blue-900 bg-opacity-80 rounded-2xl shadow-xl p-8 text-white text-center">
        <h3 class="text-2xl font-bold mb-2">Abo-Vorteil</h3>
        <p class="mb-4 text-blue-200">Mit Abo erhältst du 10% Rabatt auf alle Manga und exklusive Neuerscheinungen!</p>
        @if(!$showAbo)
        <form method="POST" action="/abo/buy">
            @csrf
            <div class="mb-4">
                <select name="payment" class="rounded px-3 py-2 text-gray-900">
                    <option value="paypal">PayPal</option>
                    <option value="creditcard">Kreditkarte</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-full font-bold text-lg transition">Abo kaufen</button>
        </form>
        @else
        <div class="text-green-400 font-bold">Du bist Abo-Mitglied!</div>
        @endif
    </div>
</div>
@endsection
