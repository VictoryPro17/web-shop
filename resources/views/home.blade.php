@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center w-full min-h-screen bg-gradient-to-br from-emerald-50 via-lime-100 to-white">
    <section class="w-full max-w-7xl mt-12 px-4">
        <h1 class="text-5xl md:text-7xl font-black text-center text-green-800 mb-8 leading-tight">Willkommen bei Victoryss Manga Store</h1>
        <p class="text-xl md:text-2xl text-center text-gray-700 mb-12">Dein moderner Manga-Shop für exklusive Titel, Sammlerstücke und mehr!</p>
        <!-- Top-Bücher Karussell -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-green-700 mb-4">Top Manga</h2>
            <div class="flex gap-6 overflow-x-auto pb-4 snap-x">
                @for ($i = 1; $i <= 6; $i++)
                <div class="min-w-[220px] max-w-xs bg-white rounded-2xl shadow-lg p-4 flex flex-col items-center snap-center">
                    <img src="https://placehold.co/200x300?text=Manga+{{$i}}" alt="Manga {{$i}}" class="rounded-xl mb-3 shadow-md">
                    <div class="font-bold text-lg text-gray-900 mb-1">Manga Titel {{$i}}</div>
                    <div class="text-green-700 font-semibold mb-2">€{{ 9.99 + $i }}</div>
                    <a href="/product/{{$i}}" class="bg-green-600 hover:bg-lime-500 text-white px-4 py-2 rounded-lg font-semibold transition">Details</a>
                </div>
                @endfor
            </div>
        </div>
        <!-- Abo-Bereich -->
        <div class="bg-gradient-to-r from-green-200 via-lime-100 to-white rounded-2xl shadow-xl p-10 flex flex-col md:flex-row items-center justify-between gap-8 mb-16">
            <div class="flex-1">
                <h3 class="text-2xl font-bold text-green-800 mb-2">Victoryss Abo</h3>
                <p class="text-lg text-gray-700 mb-4">Sichere dir exklusive Vorteile: Zugang zu limitierten Manga, Rabatte und mehr!</p>
                <ul class="list-disc ml-6 text-green-700 mb-4">
                    <li>Exklusive Manga kaufen</li>
                    <li>Rabatte auf Neuheiten</li>
                    <li>Früher Zugang zu Releases</li>
                </ul>
                <a href="/abo" class="bg-green-600 hover:bg-lime-500 text-white px-6 py-3 rounded-full font-bold text-lg transition">Abo sichern</a>
            </div>
            <img src="https://placehold.co/220x320?text=Abo+Manga" alt="Abo Manga" class="rounded-xl shadow-lg">
        </div>
    </section>
</div>
@endsection
