@extends('layouts.app')

@section('content')
@php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
$id = request()->route('id');
$response = Http::get('https://api.jikan.moe/v4/manga/' . $id);
$manga = $response->json('data') ?? null;
@endphp
@if($manga)
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12 px-4 flex flex-col items-center">
    <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-3xl shadow-2xl max-w-3xl w-full mt-10 p-10 flex flex-col md:flex-row gap-10 border-2 border-yellow-400 relative group">
        <div class="relative flex-shrink-0">
            <img src="{{ $manga['images']['jpg']['large_image_url'] ?? 'https://placehold.co/400x600?text=Manga' }}" alt="Manga Cover" class="w-72 h-96 object-cover rounded-2xl shadow-xl border-4 border-yellow-400 group-hover:scale-105 group-hover:shadow-yellow-400/40 transition-all duration-300">
            <div class="absolute top-3 right-3 bg-yellow-400 text-gray-900 px-4 py-1 rounded-full font-bold text-base shadow animate-bounce">NEU</div>
        </div>
        <div class="flex-1 flex flex-col justify-between">
            <h2 class="text-4xl font-extrabold mb-4 text-yellow-300 drop-shadow-lg flex items-center gap-2">
                <svg class="w-8 h-8 animate-blitz" fill="none" stroke="#facc15" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
                {{ $manga['title'] }}
            </h2>
            <div class="mb-6 text-gray-300 text-lg italic leading-relaxed line-clamp-5">{{ $manga['synopsis'] ?? '' }}</div>
            <div class="mb-6 flex flex-wrap gap-3 items-center">
                @if(!empty($manga['genres']))
                    @foreach($manga['genres'] as $genre)
                        <span class="bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-sm font-bold shadow">{{ $genre['name'] }}</span>
                    @endforeach
                @endif
                @if(!empty($manga['status']))
                    <span class="bg-gray-700 text-yellow-300 px-3 py-1 rounded-full text-sm font-semibold">{{ $manga['status'] }}</span>
                @endif
            </div>
            <div class="mb-6 flex items-center gap-4">
                <span class="text-yellow-400 font-bold text-2xl">€{{ number_format(12.99,2) }}</span>
                <span class="text-gray-400 text-base">Band: <b>{{ $manga['volumes'] ?? '?' }}</b></span>
                <span class="text-gray-400 text-base">Kapitel: <b>{{ $manga['chapters'] ?? '?' }}</b></span>
            </div>
            <form method="POST" action="{{ route('cart.add') }}" class="flex flex-col gap-4">
                @csrf
                <input type="hidden" name="id" value="{{ $manga['mal_id'] }}">
                <input type="hidden" name="title" value="{{ $manga['title'] }}">
                <input type="hidden" name="image" value="{{ $manga['images']['jpg']['large_image_url'] ?? '' }}">
                <input type="hidden" name="price" value="{{ 12.99 }}">
                <div class="flex items-center gap-3 mb-2">
                    <label for="quantity" class="text-yellow-300 font-semibold">Menge:</label>
                    <button type="button" onclick="let q=document.getElementById('quantity');if(q.value>1)q.value--" class="bg-yellow-400 text-gray-900 px-3 rounded-full font-bold text-lg hover:bg-yellow-300 transition">-</button>
                    <input id="quantity" name="quantity" type="number" value="1" min="1" max="99" class="w-16 text-center rounded bg-gray-900 text-yellow-300 border-2 border-yellow-400 focus:border-yellow-400 focus:outline-none text-lg">
                    <button type="button" onclick="let q=document.getElementById('quantity');if(q.value<99)q.value++" class="bg-yellow-400 text-gray-900 px-3 rounded-full font-bold text-lg hover:bg-yellow-300 transition">+</button>
                </div>
                <button type="submit" class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-8 py-3 rounded-xl font-bold text-lg shadow-lg transition">In den Warenkorb</button>
            </form>
        </div>
    </div>
</div>
@else
<div class="text-gray-400 text-center text-xl py-20">Manga nicht gefunden.</div>
@endif
<style>
@keyframes blitz { 0%,100% { filter: drop-shadow(0 0 0 #facc15); opacity:1; } 10% { filter: drop-shadow(0 0 16px #facc15); opacity:0.7; } 20% { filter: drop-shadow(0 0 32px #facc15); opacity:1; } 30% { filter: drop-shadow(0 0 8px #facc15); opacity:0.8; } 40% { filter: drop-shadow(0 0 24px #facc15); opacity:1; } 50% { filter: drop-shadow(0 0 0 #facc15); opacity:1; } }
.animate-blitz { animation: blitz 2.2s infinite; }
.line-clamp-5 { display: -webkit-box; -webkit-line-clamp: 5; -webkit-box-orient: vertical; overflow: hidden; }
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type=number] {
  -moz-appearance: textfield;
  appearance: textfield;
}
</style>
@endsection
