<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $cart = session('cart', []);
        $cart[] = [
            'id' => $request->input('id'),
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'price' => $request->input('price'),
        ];
        session(['cart' => $cart]);
        return redirect()->back()->with('success', 'Manga zum Warenkorb hinzugefügt!');
    }

    public function remove($index)
    {
        $cart = session('cart', []);
        if (isset($cart[$index])) {
            unset($cart[$index]);
            session(['cart' => array_values($cart)]);
        }
        return redirect()->back();
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back();
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Dein Warenkorb ist leer.');
        }

        $request->validate([
            'payment' => 'required|in:creditcard',
            'card_name' => 'required|string',
            'card_number' => 'required|string|min:12|max:19',
            'card_expiry' => 'required|string|min:4|max:5',
            'card_cvc' => 'required|string|min:3|max:4',
        ]);

        $user = auth()->user();
        $total = collect($cart)->sum(function($item) { return floatval($item['price']); });

        // Zahlung simulieren (hier immer erfolgreich)
        $paymentSuccess = true;

        if ($paymentSuccess) {
            // PDF-Rechnung generieren
            $invoiceNumber = 'INV-' . now()->format('YmdHis') . '-' . rand(1000,9999);
            $pdfContent = view('components.invoice', [
                'user' => $user,
                'cart' => $cart,
                'total' => $total,
                'invoiceNumber' => $invoiceNumber,
                'date' => now()->format('d.m.Y'),
            ])->render();
            $pdf = app()->make('dompdf.wrapper');
            $pdf->loadHTML($pdfContent);
            $pdfPath = 'invoices/' . $invoiceNumber . '.pdf';
            \Storage::disk('public')->put($pdfPath, $pdf->output());
            $invoiceUrl = \Storage::disk('public')->url($pdfPath);

            session()->forget('cart');
            return redirect()->route('cart.index')->with(['success' => 'Zahlung erfolgreich! Deine Bestellung wurde abgeschlossen.', 'invoice_url' => $invoiceUrl]);
        } else {
            return redirect()->back()->with('error', 'Zahlung fehlgeschlagen. Bitte versuche es erneut.');
        }
    }
}
