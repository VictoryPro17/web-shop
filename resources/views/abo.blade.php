@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-green-100 via-lime-100 to-white py-16 px-4">
    <div class="bg-white rounded-2xl shadow-2xl p-10 max-w-lg w-full flex flex-col items-center">
        <h2 class="text-3xl font-bold text-green-800 mb-6">Victoryss Abo</h2>
        <p class="text-lg text-gray-700 mb-6 text-center">Werde Mitglied und genieße exklusive Vorteile wie limitierte Manga, Rabatte und mehr!</p>
        <ul class="list-disc ml-6 text-green-700 mb-6 text-left w-full">
            <li>Exklusive Manga kaufen</li>
            <li>Rabatte auf Neuheiten</li>
            <li>Früher Zugang zu Releases</li>
        </ul>
        <button class="bg-green-600 hover:bg-lime-500 text-white px-8 py-3 rounded-full font-bold text-lg transition">Abo jetzt sichern</button>
    </div>
</div>
@endsection
