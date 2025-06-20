@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-16 px-4">
    <div class="bg-gray-800 bg-opacity-90 rounded-2xl shadow-2xl p-10 max-w-md w-full flex flex-col items-center">
        <h2 class="text-3xl font-bold text-white mb-6">Registrieren</h2>
        <form method="POST" action="{{ route('register') }}" class="w-full flex flex-col gap-6">
            @csrf
            <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required autofocus class="w-full px-5 py-3 rounded-lg border border-gray-700 bg-gray-900 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none text-lg">
            <input type="email" name="email" placeholder="E-Mail" value="{{ old('email') }}" required class="w-full px-5 py-3 rounded-lg border border-gray-700 bg-gray-900 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none text-lg">
            <input type="password" name="password" placeholder="Passwort" required class="w-full px-5 py-3 rounded-lg border border-gray-700 bg-gray-900 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none text-lg">
            <input type="password" name="password_confirmation" placeholder="Passwort bestätigen" required class="w-full px-5 py-3 rounded-lg border border-gray-700 bg-gray-900 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none text-lg">
            @if ($errors->any())
                <div class="bg-red-700 bg-opacity-80 text-white rounded-lg px-4 py-2 text-sm">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-full font-bold text-lg transition">Registrieren</button>
        </form>
        <div class="mt-6 text-gray-400 text-sm">Schon ein Konto? <a href="/login" class="text-blue-400 hover:underline font-semibold">Jetzt einloggen</a></div>
    </div>
</div>
@endsection
