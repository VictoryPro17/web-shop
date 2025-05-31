@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-green-100 via-lime-100 to-white py-16 px-4">
    <div class="bg-white rounded-2xl shadow-2xl p-10 max-w-md w-full flex flex-col items-center">
        <h2 class="text-3xl font-bold text-green-800 mb-6">Login</h2>
        <form class="w-full flex flex-col gap-6">
            <input type="email" placeholder="E-Mail" class="w-full px-5 py-3 rounded-lg border border-lime-200 focus:border-green-600 focus:ring-2 focus:ring-green-200 outline-none text-lg">
            <input type="password" placeholder="Passwort" class="w-full px-5 py-3 rounded-lg border border-lime-200 focus:border-green-600 focus:ring-2 focus:ring-green-200 outline-none text-lg">
            <button class="bg-green-600 hover:bg-lime-500 text-white px-8 py-3 rounded-full font-bold text-lg transition">Login</button>
        </form>
        <div class="mt-6 text-gray-600 text-sm">Noch kein Konto? <a href="/register" class="text-green-700 hover:underline font-semibold">Jetzt registrieren</a></div>
    </div>
</div>
@endsection
