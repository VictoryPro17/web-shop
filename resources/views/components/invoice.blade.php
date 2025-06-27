<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Rechnung {{ $invoiceNumber }}</title>
    <style>
        @page { size: A4; margin: 0; }
        html, body { height: 100%; margin: 0; padding: 0; }
        body { font-family: DejaVu Sans, sans-serif; color: #222; background: #fff; margin: 0; padding: 0; }
        .a4page {
            width: 210mm;
            height: 297mm;
            min-height: 297mm;
            margin: 0 auto;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
            padding: 18mm 10mm 18mm 10mm;
        }
        .header {
            display: flex; align-items: center; gap: 18px; font-size: 2.1em; font-weight: bold; margin-bottom: 12mm; color: #2563eb;
        }
        .header svg { width: 38px; height: 38px; }
        .company { margin-bottom: 7mm; color: #444; font-size: 1.08em; }
        .meta { margin-bottom: 6mm; }
        .meta div { margin-bottom: 4px; color: #222; font-size: 1.04em; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 7mm; }
        .table th, .table td { border: 1.2px solid #bbb; padding: 8px 7px; text-align: left; font-size: 1em; }
        .table th { background: #f3f3f3; color: #2563eb; font-size: 1.08em; }
        .table td { background: #fff; }
        .total {
            font-size: 1.5em;
            background: #fffbe6;
            color: #b45309;
            border-radius: 8px;
            padding: 12px 0;
            margin-top: 18px;
            margin-bottom: 18px;
            box-shadow: 0 2px 12px #facc1533;
            border: 2.5px solid #facc15;
            text-align: center;
            letter-spacing: 0.5px;
        }
        .total span { font-weight: bold; }
        .footer {
            width: 100%; text-align: center; color: #444; font-size: 1.04em; position: absolute; left: 0; bottom: 0; padding-bottom: 10mm;
        }
        .logo { margin-top: 0; width: 90px; }
        .powered { color: #2563eb; font-size: 0.98em; margin-top: 6px; }
    </style>
</head>
<body>
<div class="a4page" style="position:relative; min-height:297mm;">
    <div>
        <div class="header">
            <svg fill="none" stroke="#2563eb" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8L21 10h-8l1-8z" fill="#2563eb"/></svg>
            DarkStorm
        </div>
        <div class="company">
            DarkStorm Manga Store<br>
            Oberlaaer Straße 276, Obj 3, 1230 Wien · Österreich<br>
            UID: ATU12345678 · FN: 123456a · Firmenbuchgericht: Wien<br>
            E-Mail: office@darkstorm.at · Tel: +43 1 2345678
        </div>
        <div class="meta">
            <div>Rechnungsnummer: <b>{{ $invoiceNumber }}</b></div>
            <div>Rechnungsdatum: <b>{{ $date }}</b></div>
            <div>Kunde: <b>{{ $user->name ?? 'Gast' }}</b> ({{ $user->email ?? '' }})</div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Bezeichnung</th>
                    <th>Einzelpreis</th>
                    <th>Menge</th>
                    <th>Gesamt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                    <tr>
                        <td>{{ $item['title'] }}</td>
                        <td>€{{ number_format($item['price'],2) }}</td>
                        <td>{{ $item['quantity'] ?? 1 }}</td>
                        <td>€{{ number_format(($item['price'] * ($item['quantity'] ?? 1)),2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total" style="font-size:1.5em; background: #fffbe6; color: #b45309; border-radius: 8px; padding: 12px 0; margin-top: 18px; margin-bottom: 18px; box-shadow: 0 2px 12px #facc1533; border: 2.5px solid #facc15; text-align:center; letter-spacing:0.5px;">
            Gesamtbetrag (inkl. USt): <span style="font-weight: bold;">€{{ number_format(collect($cart)->sum(fn($item) => ($item['price'] * ($item['quantity'] ?? 1))),2) }}</span>
        </div>
    </div>
    <div class="footer">
        <img src="{{ public_path('logo.png') }}" class="logo" alt="DarkStorm Logo"><br>
        <span class="powered">powered by ibis acam</span>
        <div style="margin-top:8px; font-size:0.95em; color:#222;">Vielen Dank für Ihren Einkauf bei DarkStorm!</div>
    </div>
</div>
</body>
</html>
