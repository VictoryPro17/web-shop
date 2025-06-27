@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12 px-4">
    <h2 class="text-5xl font-extrabold text-yellow-400 mb-12 text-center flex items-center justify-center gap-3 animate-blitz-glow">
        <svg class="w-10 h-10 animate-blitz" fill="none" stroke="#facc15" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
        Dein Warenkorb
    </h2>
    @if(count($cart) > 0)
        <div class="max-w-3xl mx-auto bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-3xl shadow-2xl p-10 border-2 border-yellow-400">
            <table class="w-full text-yellow-100 mb-8 rounded-xl overflow-hidden">
                <thead>
                    <tr class="border-b-2 border-yellow-400">
                        <th class="py-3 text-lg">Cover</th>
                        <th class="py-3 text-lg">Titel</th>
                        <th class="py-3 text-lg">Preis</th>
                        <th class="py-3 text-lg">Menge</th>
                        <th class="py-3 text-lg">Gesamt</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $i => $item)
                    <tr class="border-b border-gray-700 hover:bg-gray-800/60 transition">
                        <td class="py-3"><img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-20 rounded-xl shadow-lg border-2 border-yellow-400"></td>
                        <td class="py-3 font-bold text-yellow-300">{{ $item['title'] }}</td>
                        <td class="py-3 text-yellow-300 font-bold text-lg">€{{ $item['price'] }}</td>
                        <td class="py-3">
                            <span class="inline-block bg-yellow-400 text-gray-900 px-3 py-1 rounded-full font-bold">{{ $item['quantity'] ?? 1 }}</span>
                        </td>
                        <td class="py-3 font-extrabold text-yellow-300 text-lg">€{{ number_format(($item['price'] * ($item['quantity'] ?? 1)), 2) }}</td>
                        <td class="py-3">
                            <form method="POST" action="{{ route('cart.remove', $i) }}">
                                @csrf
                                <button class="text-red-400 hover:text-red-600 font-bold transition">Entfernen</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
                <form method="POST" action="{{ route('cart.clear') }}">
                    @csrf
                    <button class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-6 py-2 rounded-full font-bold shadow transition">Warenkorb leeren</button>
                </form>
                <div class="text-2xl font-extrabold bg-yellow-300 text-gray-900 px-8 py-3 rounded-xl shadow-lg border-2 border-yellow-300">Gesamt: €{{ number_format(collect($cart)->sum(fn($item) => ($item['price'] * ($item['quantity'] ?? 1))), 2) }}</div>
            </div>
            <div class="flex justify-end mt-4">
                <a href="{{ route('checkout') }}" class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-10 py-4 rounded-full font-extrabold text-xl shadow-lg transition flex items-center gap-2">
                    <svg class="w-7 h-7 animate-blitz" fill="none" stroke="#facc15" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
                    Zur Kasse
                </a>
            </div>
        </div>
    @else
        <div class="text-gray-400 text-center text-2xl py-32">Dein Warenkorb ist leer.</div>
    @endif
</div>
<style>
@keyframes blitz-glow {
    0%,100% { text-shadow: 0 0 0 #facc15, 0 0 0 #fff; }
    10% { text-shadow: 0 0 16px #facc15, 0 0 8px #fff; }
    20% { text-shadow: 0 0 32px #facc15, 0 0 16px #fff; }
    30% { text-shadow: 0 0 8px #facc15, 0 0 4px #fff; }
    40% { text-shadow: 0 0 24px #facc15, 0 0 12px #fff; }
    50% { text-shadow: 0 0 0 #facc15, 0 0 0 #fff; }
}
.animate-blitz-glow { animation: blitz-glow 2.2s infinite; }
@keyframes blitz { 0%,100% { filter: drop-shadow(0 0 0 #facc15); opacity:1; } 10% { filter: drop-shadow(0 0 16px #facc15); opacity:0.7; } 20% { filter: drop-shadow(0 0 32px #facc15); opacity:1; } 30% { filter: drop-shadow(0 0 8px #facc15); opacity:0.8; } 40% { filter: drop-shadow(0 0 24px #facc15); opacity:1; } 50% { filter: drop-shadow(0 0 0 #facc15); opacity:1; } }
.animate-blitz { animation: blitz 2.2s infinite; }
</style>
@endsection
