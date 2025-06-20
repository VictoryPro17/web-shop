<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MangaController extends Controller
{
    // Zeigt die Shop-Seite mit Mangas von der API
    public function index()
    {
        $response = Http::get('https://api.mangadex.org/manga?limit=12&order[relevance]=desc&includes[]=cover_art&availableTranslatedLanguage[]=en&availableTranslatedLanguage[]=de');
        $mangas = $response->json('data') ?? [];
        return view('shop', compact('mangas'));
    }

    // Zeigt eine einzelne Manga-Detailseite
    public function show($id)
    {
        $response = Http::get("https://api.mangadex.org/manga/{$id}?includes[]=cover_art");
        $manga = $response->json('data');
        return view('product', compact('manga'));
    }
}
