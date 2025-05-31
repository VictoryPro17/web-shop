@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-lime-50 via-emerald-50 to-white py-12 px-4">
    <h2 class="text-4xl font-extrabold text-green-800 mb-10 text-center">Shop</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
        @for ($i = 1; $i <= 6; $i++)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col hover:scale-105 transition">
            <img src="https://placehold.co/400x600?text=Manga+{{$i}}" alt="Manga {{$i}}" class="w-full h-72 object-cover">
            <div class="p-6 flex-1 flex flex-col justify-between">
                <h3 class="text-2xl font-bold mb-2 text-gray-900">Manga Titel {{$i}}</h3>
                <p class="text-gray-600 mb-4">Kurze Beschreibung des Manga. Spannend, modern und einzigartig!</p>
                <div class="text-green-700 font-bold text-xl mb-2">€{{ 9.99 + $i }}</div>
                <button class="bg-green-600 hover:bg-lime-500 text-white px-4 py-2 rounded-lg font-semibold transition mb-2">In den Warenkorb</button>
                <a href="/product/{{$i}}" class="text-green-700 hover:underline text-center">Details ansehen</a>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection
