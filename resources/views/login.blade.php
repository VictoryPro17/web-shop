@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-16 px-4">
    <div class="bg-gray-800 bg-opacity-90 rounded-2xl shadow-2xl p-10 max-w-md w-full flex flex-col items-center">
        <h2 class="text-3xl font-bold text-white mb-6">Login</h2>
        <form class="w-full flex flex-col gap-6">
            <input type="email" placeholder="E-Mail" class="w-full px-5 py-3 rounded-lg border border-gray-700 bg-gray-900 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none text-lg">
            <input type="password" placeholder="Passwort" class="w-full px-5 py-3 rounded-lg border border-gray-700 bg-gray-900 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none text-lg">
            <button class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-full font-bold text-lg transition">Login</button>
        </form>
        <div class="mt-6 text-gray-400 text-sm">Noch kein Konto? <a href="/register" class="text-blue-400 hover:underline font-semibold">Jetzt registrieren</a></div>
    </div>
</div>
@endsection
