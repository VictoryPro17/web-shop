@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12 px-4">
    <div class="bg-gray-800 rounded-2xl shadow-2xl p-8 w-full max-w-lg">
        <h2 class="text-3xl font-bold text-yellow-400 mb-8 text-center flex items-center justify-center gap-2">
            <svg class="w-8 h-8 animate-blitz" fill="none" stroke="#facc15" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#facc15"/></svg>
            Profil bearbeiten
        </h2>
        @if (session('status'))
            <div class="mb-4 text-green-400 font-semibold text-center">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('profile.update') }}" class="flex flex-col gap-6">
            @csrf
            @method('PATCH')
            <div>
                <label for="name" class="block text-gray-300 font-semibold mb-1">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required class="w-full px-4 py-2 rounded bg-gray-900 text-white border border-gray-700 focus:border-yellow-400 focus:outline-none">
                @error('name')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label for="email" class="block text-gray-300 font-semibold mb-1">E-Mail</label>
                <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full px-4 py-2 rounded bg-gray-900 text-white border border-gray-700 focus:border-yellow-400 focus:outline-none">
                @error('email')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label for="password" class="block text-gray-300 font-semibold mb-1">Neues Passwort <span class="text-gray-500 font-normal">(optional)</span></label>
                <input id="password" name="password" type="password" autocomplete="new-password" class="w-full px-4 py-2 rounded bg-gray-900 text-white border border-gray-700 focus:border-yellow-400 focus:outline-none">
                @error('password')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-gray-300 font-semibold mb-1">Passwort bestätigen</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="w-full px-4 py-2 rounded bg-gray-900 text-white border border-gray-700 focus:border-yellow-400 focus:outline-none">
            </div>
            <button type="submit" class="w-full py-3 mt-2 rounded bg-yellow-400 text-gray-900 font-bold text-lg shadow-lg hover:bg-yellow-300 transition">Profil speichern</button>
        </form>
    </div>
</div>
@endsection
<style>
@keyframes blitz {
    0%,100% { filter: drop-shadow(0 0 0 #facc15); opacity:1; }
    10% { filter: drop-shadow(0 0 16px #facc15); opacity:0.7; }
    20% { filter: drop-shadow(0 0 32px #facc15); opacity:1; }
    30% { filter: drop-shadow(0 0 8px #facc15); opacity:0.8; }
    40% { filter: drop-shadow(0 0 24px #facc15); opacity:1; }
    50% { filter: drop-shadow(0 0 0 #facc15); opacity:1; }
}
.animate-blitz { animation: blitz 2.2s infinite; }
</style>
