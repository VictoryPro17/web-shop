@extends('layouts.app')

@section('content')
@php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
$id = request()->route('id');
$response = Http::get('https://api.jikan.moe/v4/manga/' . $id);
$manga = $response->json('data') ?? null;
$showAbo = auth()->check() && (auth()->user()->is_abo ?? false);
$fixedPrice = 12.99;
$aboPrice = number_format($fixedPrice * 0.9, 2);
@endphp
@if($manga)
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12 px-4 flex flex-col items-center">
    <div class="bg-gray-800 rounded-2xl shadow-xl max-w-2xl w-full mt-10 p-8 flex flex-col md:flex-row gap-8">
        <img src="{{ $manga['images']['jpg']['large_image_url'] ?? 'https://placehold.co/400x600?text=Manga' }}" alt="Manga Cover" class="w-64 h-96 object-cover rounded-xl shadow-md">
        <div class="flex-1 flex flex-col">
            <h2 class="text-3xl font-bold mb-4 text-white">{{ $manga['title'] }}</h2>
            <p class="text-gray-300 mb-6">{{ Str::limit($manga['synopsis'] ?? '', 120) }}</p>
            <div class="mb-4">
                @if($showAbo)
                    <span class="text-gray-400 line-through mr-2">€{{ number_format($fixedPrice,2) }}</span>
                    <span class="text-blue-400 font-bold">€{{ $aboPrice }}</span>
                @else
                    <span class="text-blue-400 font-bold">€{{ number_format($fixedPrice,2) }}</span>
                @endif
            </div>
            <form method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $manga['mal_id'] }}">
                <input type="hidden" name="title" value="{{ $manga['title'] }}">
                <input type="hidden" name="image" value="{{ $manga['images']['jpg']['large_image_url'] ?? '' }}">
                <input type="hidden" name="price" value="{{ $showAbo ? $aboPrice : $fixedPrice }}">
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold text-lg transition mb-2">In den Warenkorb</button>
            </form>
            <span class="text-blue-400 text-sm">@if($showAbo) Exklusiv für Abo-Mitglieder: <span class="font-bold">+1 Bonuskapitel</span> @endif</span>
        </div>
    </div>
</div>
@else
<div class="text-gray-400 text-center text-xl py-20">Manga nicht gefunden.</div>
@endif
@endsection
