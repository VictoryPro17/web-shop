@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-16 px-4">
    <div class="bg-gray-800 bg-opacity-90 rounded-2xl shadow-2xl p-10 max-w-lg w-full flex flex-col items-center">
        <h2 class="text-3xl font-bold text-white mb-6">Vielen Dank für deinen Einkauf!</h2>
        <p class="text-lg text-blue-200 mb-6 text-center">Deine Bestellung war erfolgreich. Du kannst die Rechnung als PDF herunterladen.</p>
        @if($pdf)
        <a href="{{ $pdf }}" class="bg-green-600 hover:bg-green-500 text-white px-8 py-3 rounded-full font-bold text-lg transition mb-4" download>Rechnung als PDF herunterladen</a>
        @endif
        <a href="/shop" class="mt-2 bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-full font-bold text-lg transition">Zurück zum Shop</a>
    </div>
</div>
@endsection
