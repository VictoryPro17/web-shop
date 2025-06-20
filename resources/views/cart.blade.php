@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12 px-4">
    <h2 class="text-4xl font-extrabold text-white mb-10 text-center">Warenkorb</h2>
    @if(count($cart) > 0)
        <div class="max-w-3xl mx-auto bg-gray-800 rounded-2xl shadow-xl p-8">
            <table class="w-full text-white mb-6">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="py-2">Cover</th>
                        <th class="py-2">Titel</th>
                        <th class="py-2">Preis</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $i => $item)
                    <tr class="border-b border-gray-700">
                        <td class="py-2"><img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-20 rounded shadow"></td>
                        <td class="py-2">{{ $item['title'] }}</td>
                        <td class="py-2">€{{ $item['price'] }}</td>
                        <td class="py-2">
                            <form method="POST" action="{{ route('cart.remove', $i) }}">
                                @csrf
                                <button class="text-red-400 hover:text-red-600">Entfernen</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-between items-center mb-8">
                <form method="POST" action="{{ route('cart.clear') }}">
                    @csrf
                    <button class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded">Warenkorb leeren</button>
                </form>
                <div class="text-xl text-blue-400 font-bold">Gesamt: €{{ number_format(collect($cart)->sum('price'), 2) }}</div>
            </div>
            <form method="POST" action="/cart/checkout" class="bg-gray-900 rounded-xl p-6 flex flex-col gap-4" id="checkout-form">
                @csrf
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <label class="text-white font-semibold">Zahlungsart:</label>
                    <select name="payment" class="rounded px-3 py-2 text-gray-900" id="payment-method" onchange="toggleCardFields()">
                        <option value="creditcard">Kreditkarte</option>
                    </select>
                </div>
                <div id="card-fields" class="flex flex-col gap-3 mt-2">
                    <input type="text" name="card_name" placeholder="Name auf der Karte" class="rounded px-3 py-2 text-gray-900" required>
                    <input type="text" name="card_number" placeholder="Kartennummer" maxlength="19" class="rounded px-3 py-2 text-gray-900" required>
                    <div class="flex gap-2">
                        <input type="text" name="card_expiry" placeholder="MM/YY" maxlength="5" class="rounded px-3 py-2 text-gray-900 w-1/2" required>
                        <input type="text" name="card_cvc" placeholder="CVC" maxlength="4" class="rounded px-3 py-2 text-gray-900 w-1/2" required>
                    </div>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-full font-bold text-lg transition">Jetzt kaufen</button>
            </form>
            @if(session('invoice_url'))
                <div class="mt-6 text-center">
                    <a href="{{ session('invoice_url') }}" target="_blank" class="bg-green-600 hover:bg-green-500 text-white px-6 py-2 rounded font-bold">Rechnung als PDF herunterladen</a>
                </div>
            @endif
        </div>
    @else
        <div class="text-gray-400 text-center text-xl">Dein Warenkorb ist leer.</div>
    @endif
</div>
@endsection
<script>
function toggleCardFields() {
    // Nur Kreditkarte verfügbar, Felder immer sichtbar
}
</script>
