<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Stripe\Stripe;
use Stripe\Token;

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
        // Sonderaktion: 3 Manga für 5 € als Bundle
        if ($request->input('special_offer') == 1 && is_array($request->input('ids'))) {
            $ids = $request->input('ids');
            $titles = $request->input('titles');
            $images = $request->input('images');
            $specialPrice = floatval($request->input('special_price', 5.00));
            $bundleTitle = 'Sonderaktion: 3 Manga-Set';
            $bundleDesc = implode(' + ', array_map(function($t){return $t;}, $titles));
            $cart[] = [
                'id' => implode('-', $ids),
                'title' => $bundleTitle,
                'image' => $images[0] ?? '',
                'price' => $specialPrice,
                'quantity' => 1,
                'bundle' => true,
                'bundle_titles' => $titles,
                'bundle_images' => $images,
                'bundle_ids' => $ids,
                'bundle_desc' => $bundleDesc,
            ];
            session(['cart' => $cart]);
            return redirect()->route('shop')->with('success', 'Sonderaktion: 3 Manga für 5 € zum Warenkorb hinzugefügt!');
        }
        // Standard: Einzel-Manga
        $quantity = max(1, intval($request->input('quantity', 1)));
        $cart[] = [
            'id' => $request->input('id'),
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'price' => $request->input('price'),
            'quantity' => $quantity,
        ];
        session(['cart' => $cart]);
        return redirect()->route('shop')->with('success', 'Manga zum Warenkorb hinzugefügt!');
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

        $user = Auth::user();
        $total = collect($cart)->sum(function($item) { return floatval($item['price']); });

        // Stripe-Integration direkt (ohne Cashier)
        try {
            $stripeSecret = config('cashier.secret') ?: env('STRIPE_SECRET');
            if (!$stripeSecret) {
                return redirect('/checkout')->with('error', 'Stripe-API-Key fehlt!');
            }
            $stripe = new \Stripe\StripeClient($stripeSecret);
            [$exp_month, $exp_year] = explode('/', $request->card_expiry);
            $exp_month = trim($exp_month);
            $exp_year = strlen(trim($exp_year)) === 2 ? '20'.trim($exp_year) : trim($exp_year);

            // Token erstellen
            $token = $stripe->tokens->create([
                'card' => [
                    'number' => str_replace(' ', '', $request->card_number),
                    'exp_month' => $exp_month,
                    'exp_year' => $exp_year,
                    'cvc' => $request->card_cvc,
                    'name' => $request->card_name,
                ]
            ]);

            // Zahlung durchführen
            $charge = $stripe->charges->create([
                'amount' => intval($total * 100),
                'currency' => 'eur',
                'source' => $token->id,
                'description' => 'Victoryss Manga Store Bestellung',
                'receipt_email' => $user ? $user->email : null,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Zahlung fehlgeschlagen: ' . $e->getMessage());
        }

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
        Storage::disk('public')->put($pdfPath, $pdf->output());
        $invoiceUrl = asset('storage/invoices/' . $invoiceNumber . '.pdf');

        session()->forget('cart');
        return redirect()->route('checkout.thankyou', ['pdf' => $invoiceUrl]);
    }

    public function checkoutPay(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Dein Warenkorb ist leer.');
        }

        $request->validate([
            'payment' => 'required|in:creditcard',
            'card_name' => 'required|string',
            'card_number' => 'required|string|min:4|max:19',
            'card_expiry' => 'required|string|min:4|max:5',
            'card_cvc' => 'required|string|min:3|max:4',
        ]);

        $user = Auth::user();
        $total = collect($cart)->sum(function($item) { return floatval($item['price']); });

        // FAKE PAYMENT: Immer erfolgreich, keine Stripe-API!
        // Bestellung speichern für Admin
        \DB::table('orders')->insert([
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : $request->card_name,
            'user_email' => $user ? $user->email : null,
            'cart_json' => json_encode($cart),
            'total' => $total,
            'created_at' => now(),
        ]);

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
        $invoiceUrl = asset('storage/invoices/' . $invoiceNumber . '.pdf');

        session()->forget('cart');
        return redirect()->route('checkout.thankyou', ['pdf' => $invoiceUrl]);
    }
}
