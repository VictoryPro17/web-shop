@extends('layouts.app')

@section('content')
@php
$showAbo = auth()->check() && auth()->user()->is_abo ?? false;
@endphp
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-16 px-4">
    <div class="bg-gray-800 bg-opacity-90 rounded-2xl shadow-2xl p-10 max-w-lg w-full flex flex-col items-center">
        <h2 class="text-3xl font-bold text-white mb-6">Victoryss Abo</h2>
        <p class="text-lg text-blue-200 mb-6 text-center">Werde Mitglied und genieße exklusive Vorteile wie limitierte Manga, Rabatte und mehr!</p>
        <ul class="list-disc ml-6 text-blue-400 mb-6 text-left w-full">
            <li>Exklusive Manga kaufen</li>
            <li>10% Rabatt auf alle Manga</li>
            <li>Früher Zugang zu Releases</li>
        </ul>
        @if(!$showAbo)
        <form method="POST" action="/abo/buy" class="w-full flex flex-col gap-4">
            @csrf
            <select name="payment" class="rounded px-3 py-2 text-gray-900">
                <option value="paypal">PayPal</option>
                <option value="creditcard">Kreditkarte</option>
            </select>
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-full font-bold text-lg transition">Abo jetzt sichern</button>
        </form>
        @else
        <div class="text-green-400 font-bold mt-4">Du bist bereits Abo-Mitglied!</div>
        @endif
    </div>
</div>
@endsection
