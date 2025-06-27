@extends('layouts.app')

@section('content')
@php
$cart = session('cart', []);
$total = collect($cart)->sum(function($item) { return floatval($item['price']); });
@endphp
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-16 px-4">
    <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 bg-opacity-95 rounded-3xl shadow-2xl p-12 max-w-lg w-full flex flex-col items-center border-2 border-yellow-400">
        <h2 class="text-4xl font-extrabold text-yellow-400 mb-8 flex items-center gap-2 animate-blitz-glow">
            <svg class="w-8 h-8 animate-blitz" fill="none" stroke="#facc15" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
            Bezahlung
        </h2>
        @if(count($cart) === 0)
            <div class="text-gray-400 text-center text-xl">Dein Warenkorb ist leer.</div>
            <a href="/shop" class="mt-6 bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-8 py-3 rounded-full font-bold text-lg shadow-lg transition">Zurück zum Shop</a>
        @else
        @if(session('error'))
            <div class="bg-red-700 text-white rounded-lg px-4 py-2 mb-4 w-full text-center font-bold">{{ session('error') }}</div>
        @endif
        <div class="w-full mb-8">
            <table class="w-full text-yellow-100 mb-4 rounded-xl overflow-hidden">
                <thead>
                    <tr class="border-b-2 border-yellow-400">
                        <th class="py-3 text-left text-lg">Titel</th>
                        <th class="py-3 text-right text-lg">Preis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                    <tr class="border-b border-gray-700">
                        <td class="py-3 font-bold text-yellow-300">{{ $item['title'] }}</td>
                        <td class="py-3 text-right text-yellow-400 font-bold">€{{ $item['price'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-2xl font-extrabold bg-yellow-400 text-gray-900 px-8 py-3 rounded-xl shadow-lg border-2 border-yellow-400 text-right">Gesamt: €{{ number_format($total, 2) }}</div>
        </div>
        <form method="POST" action="/checkout/pay" class="w-full flex flex-col gap-6 bg-gray-900 rounded-2xl p-8 border border-yellow-400 shadow-lg">
            @csrf
            <label class="text-yellow-300 font-semibold">Zahlungsart:</label>
            <select name="payment" class="rounded px-3 py-2 text-gray-900 font-bold border-2 border-yellow-400" required>
                <option value="creditcard">Kreditkarte</option>
            </select>
            <input type="text" name="card_name" placeholder="Name auf der Karte" class="rounded px-4 py-3 text-gray-900 font-bold border-2 border-yellow-400" required>
            <input type="text" name="card_number" placeholder="Kartennummer" maxlength="19" pattern="^[0-9 ]{13,19}$" inputmode="numeric" class="rounded px-4 py-3 text-gray-900 font-bold border-2 border-yellow-400 tracking-widest" required title="Nur Zahlen, 13-19 Stellen">
            <div class="flex gap-4">
                <input type="text" name="card_expiry" placeholder="MM/YY" maxlength="5" pattern="^(0[1-9]|1[0-2])\/[0-9]{2}$" inputmode="numeric" class="rounded px-4 py-3 text-gray-900 font-bold border-2 border-yellow-400 w-1/2 text-center" required title="Format: MM/YY">
                <input type="text" name="card_cvc" placeholder="CVC" maxlength="3" pattern="^[0-9]{3}$" inputmode="numeric" class="rounded px-4 py-3 text-gray-900 font-bold border-2 border-yellow-400 w-1/2 text-center" required title="3-stellige CVC">
            </div>
            <button type="submit" class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-10 py-4 rounded-full font-extrabold text-xl shadow-lg transition flex items-center gap-2">
                <svg class="w-7 h-7 animate-blitz" fill="none" stroke="#facc15" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
                Jetzt bezahlen
            </button>
        </form>
        @endif
    </div>
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
