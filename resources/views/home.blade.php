@extends('layouts.app')

@section('content')
@php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
$top = Http::get('https://api.jikan.moe/v4/top/manga', ['limit'=>6])->json('data') ?? [];
$popular = Http::get('https://api.jikan.moe/v4/top/manga', ['limit'=>30, 'page'=>2])->json('data') ?? [];
shuffle($popular);
$popular = array_slice($popular, 0, 3);
$showAbo = auth()->check() && (auth()->user()->is_abo ?? false);
$fixedPrice = 12.99;
$aboPrice = number_format($fixedPrice * 0.9, 2);
@endphp
<div class="flex flex-col items-center w-full min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
    <section class="w-full max-w-7xl mt-32 px-4">
        <h1 class="text-5xl md:text-7xl font-black text-center text-white mb-8 leading-tight">Willkommen bei Victoryss Manga Store</h1>
        <p class="text-xl md:text-2xl text-center text-gray-300 mb-12">Entdecke die besten Manga, sichere dir exklusive Vorteile und genieße modernes Shopping!</p>
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-white mb-4">Top Manga</h2>
            <div class="flex gap-6 overflow-x-auto pb-4 snap-x">
                @foreach($top as $manga)
                    <div class="min-w-[220px] max-w-xs bg-gray-800 rounded-2xl shadow-lg p-4 flex flex-col items-center snap-center">
                        <img src="{{ $manga['images']['jpg']['large_image_url'] ?? '' }}" alt="{{ $manga['title'] }}" class="rounded-xl mb-3 shadow-md" style="height:300px;width:200px;object-fit:cover;">
                        <div class="font-bold text-lg text-white mb-1">{{ $manga['title'] }}</div>
                        <div class="mb-2">
                            @if($showAbo)
                                <span class="text-gray-400 line-through mr-2">€{{ number_format($fixedPrice,2) }}</span>
                                <span class="text-blue-400 font-bold">€{{ $aboPrice }}</span>
                            @else
                                <span class="text-blue-400 font-bold">€{{ number_format($fixedPrice,2) }}</span>
                            @endif
                        </div>
                        <a href="{{ route('product.show', $manga['mal_id']) }}" class="text-blue-400 hover:underline text-sm">Details</a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mb-16">
            <h2 class="text-2xl font-bold text-white mb-4">Beliebte Manga</h2>
            <div class="flex gap-6 overflow-x-auto pb-4 snap-x">
                @foreach($popular as $manga)
                    <div class="min-w-[180px] max-w-xs bg-gray-800 rounded-2xl shadow-lg p-3 flex flex-col items-center snap-center">
                        <img src="{{ $manga['images']['jpg']['large_image_url'] ?? '' }}" alt="{{ $manga['title'] }}" class="rounded-xl mb-2 shadow-md" style="height:220px;width:150px;object-fit:cover;">
                        <div class="font-bold text-base text-white mb-1">{{ $manga['title'] }}</div>
                        <div class="mb-2">
                            @if($showAbo)
                                <span class="text-gray-400 line-through mr-2">€{{ number_format($fixedPrice,2) }}</span>
                                <span class="text-blue-400 font-bold">€{{ $aboPrice }}</span>
                            @else
                                <span class="text-blue-400 font-bold">€{{ number_format($fixedPrice,2) }}</span>
                            @endif
                        </div>
                        <a href="{{ route('product.show', $manga['mal_id']) }}" class="text-blue-400 hover:underline text-xs">Details</a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="max-w-2xl mx-auto mt-16 bg-blue-900 bg-opacity-80 rounded-2xl shadow-xl p-8 text-white text-center">
            <h3 class="text-2xl font-bold mb-2">Abo-Vorteil</h3>
            <p class="mb-4 text-blue-200">Mit Abo erhältst du 10% Rabatt auf alle Manga und exklusive Neuerscheinungen!</p>
            <a href="/abo" class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-full font-bold text-lg transition">Abo sichern</a>
        </div>
    </section>
</div>
@endsection
