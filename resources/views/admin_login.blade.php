@extends('layouts.app')
@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-16 px-4">
    <div class="bg-gray-800 bg-opacity-90 rounded-2xl shadow-2xl p-10 max-w-md w-full flex flex-col items-center">
        <h2 class="text-3xl font-bold text-white mb-6">Admin Login</h2>
        @if(isset($error))
            <div class="mb-4 text-red-400 font-bold">{{ $error }}</div>
        @endif
        <form method="POST" action="/admin" class="w-full flex flex-col gap-6">
            @csrf
            <input type="password" name="code" placeholder="Admin-Code" class="w-full px-5 py-3 rounded-lg border border-gray-700 bg-gray-900 text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none text-lg">
            <button class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-full font-bold text-lg transition">Login</button>
        </form>
    </div>
</div>
@endsection
