@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-lime-50 via-emerald-50 to-white py-12 px-4 flex flex-col items-center">
    <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full mt-10 p-8 flex flex-col md:flex-row gap-8">
        <img src="https://placehold.co/400x600?text=Manga" alt="Manga Cover" class="w-64 h-96 object-cover rounded-xl shadow-md">
        <div class="flex-1 flex flex-col">
            <h2 class="text-3xl font-bold mb-4 text-gray-900">Manga Titel</h2>
            <p class="text-gray-700 mb-6">Hier steht eine ausführliche Beschreibung des Manga. Fesselnde Story, tolle Zeichnungen und ein Muss für jeden Fan!</p>
            <div class="text-2xl font-bold text-green-700 mb-4">€12,99</div>
            <button class="bg-green-600 hover:bg-lime-500 text-white px-6 py-3 rounded-lg font-semibold text-lg transition mb-2">In den Warenkorb</button>
            <span class="text-green-700 text-sm">Exklusiv für Abo-Mitglieder: <span class="font-bold">+1 Bonuskapitel</span></span>
        </div>
    </div>
</div>
@endsection
