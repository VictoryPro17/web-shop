@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12 px-4">
    <div class="max-w-6xl mx-auto bg-gray-800 rounded-2xl shadow-2xl p-8">
        <h2 class="text-4xl font-extrabold text-white mb-10 text-center tracking-tight">Admin Dashboard</h2>
        @if(session('success'))
            <div class="bg-green-700 text-white rounded-lg px-4 py-2 mb-4 w-full text-center font-bold">{{ session('success') }}</div>
        @endif
        <div class="mb-8 flex flex-col md:flex-row gap-8 justify-between">
            <div class="bg-gray-900 rounded-xl p-6 flex-1 shadow-lg">
                <div class="text-2xl text-blue-400 font-bold mb-2">Gesamteinnahmen</div>
                <div class="text-3xl text-white font-black">€{{ number_format($total,2) }}</div>
            </div>
            <div class="bg-gray-900 rounded-xl p-6 flex-1 shadow-lg">
                <div class="text-2xl text-blue-400 font-bold mb-2">Bestellungen</div>
                <div class="text-3xl text-white font-black">{{ $orders->count() }}</div>
            </div>
            <div class="bg-gray-900 rounded-xl p-6 flex-1 shadow-lg">
                <div class="text-2xl text-blue-400 font-bold mb-2">Meistverkauftes Buch</div>
                <div class="text-xl text-white font-bold">{{ $topBook }}</div>
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-4 mb-6 items-center justify-between">
            <form method="GET" class="flex flex-wrap gap-2 w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Suche nach Kunde, E-Mail, Buch..." class="px-3 py-2 rounded bg-gray-900 text-white border border-gray-700 focus:outline-none w-64">
                <input type="date" name="from" value="{{ request('from') }}" class="px-3 py-2 rounded bg-gray-900 text-white border border-gray-700">
                <input type="date" name="to" value="{{ request('to') }}" class="px-3 py-2 rounded bg-gray-900 text-white border border-gray-700">
                <button class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded font-bold">Filtern</button>
                <a href="{{ route('admin') }}" class="ml-2 text-gray-400 hover:text-white underline">Reset</a>
            </form>
            <div class="text-gray-400 text-sm mt-2 md:mt-0">{{ $orders->count() }} Ergebnisse</div>
        </div>
        <div class="overflow-x-auto rounded-xl shadow-lg">
            <table class="w-full text-white mb-6 text-sm md:text-base">
                <thead class="bg-gray-900 sticky top-0 z-10">
                    <tr class="border-b border-gray-700">
                        <th class="py-2 cursor-pointer">Datum</th>
                        <th class="py-2 cursor-pointer">Kunde</th>
                        <th class="py-2 cursor-pointer">E-Mail</th>
                        <th class="py-2 cursor-pointer">Bücher</th>
                        <th class="py-2 cursor-pointer">Summe</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    @php
                        $filtered = $orders->filter(function($order) {
                            $search = strtolower(request('search', ''));
                            $from = request('from');
                            $to = request('to');
                            $date = $order->created_at->format('Y-m-d');
                            $cart = json_decode($order->cart_json, true);
                            $bookTitles = collect($cart)->pluck('title')->implode(' ');
                            $match = true;
                            if($search) {
                                $match = str_contains(strtolower($order->user_name.' '.$order->user_email.' '.$bookTitles), $search);
                            }
                            if($from && $date < $from) $match = false;
                            if($to && $date > $to) $match = false;
                            return $match;
                        });
                    @endphp
                    @forelse($filtered as $order)
                    <tr class="border-b border-gray-700 hover:bg-gray-700/30 transition">
                        <td class="py-2">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td class="py-2">{{ $order->user_name }}</td>
                        <td class="py-2">{{ $order->user_email }}</td>
                        <td class="py-2">
                            @foreach(json_decode($order->cart_json, true) as $item)
                                <div class="text-gray-200 bg-gray-900 rounded px-2 py-1 mb-1 inline-block">{{ $item['title'] }} <span class="text-xs text-blue-400 font-bold">x{{ $item['quantity'] ?? 1 }}</span></div>
                            @endforeach
                        </td>
                        <td class="py-2">
                            <span class="px-2 py-1 rounded font-bold @if($order->total > 50) bg-green-700 text-white @elseif($order->total > 25) bg-yellow-700 text-white @else bg-gray-700 text-gray-200 @endif">€{{ number_format($order->total,2) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-gray-400 py-8">Keine Bestellungen gefunden.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
// Sortierbare Tabelle (nur Frontend, für Demo)
document.querySelectorAll('th.cursor-pointer').forEach((th, idx) => {
    th.addEventListener('click', () => {
        const tbody = document.getElementById('orderTableBody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const asc = th.classList.toggle('asc');
        rows.sort((a, b) => {
            let ta = a.children[idx].innerText.toLowerCase();
            let tb = b.children[idx].innerText.toLowerCase();
            if(!isNaN(Date.parse(ta)) && !isNaN(Date.parse(tb))) {
                ta = Date.parse(ta); tb = Date.parse(tb);
            } else if(!isNaN(parseFloat(ta)) && !isNaN(parseFloat(tb))) {
                ta = parseFloat(ta); tb = parseFloat(tb);
            }
            return asc ? (ta > tb ? 1 : -1) : (ta < tb ? 1 : -1);
        });
        rows.forEach(r => tbody.appendChild(r));
    });
});
</script>
@endsection
