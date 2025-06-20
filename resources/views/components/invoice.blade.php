<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Rechnung {{ $invoiceNumber }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #222; }
        .header { font-size: 1.5em; font-weight: bold; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #bbb; padding: 8px; text-align: left; }
        .table th { background: #eee; }
        .total { font-size: 1.2em; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">Victoryss Manga Store<br>Rechnung</div>
    <div>Rechnungsnummer: <b>{{ $invoiceNumber }}</b></div>
    <div>Datum: <b>{{ $date }}</b></div>
    <div>Kunde: <b>{{ $user->name ?? 'Gast' }}</b> ({{ $user->email ?? '' }})</div>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>Titel</th>
                <th>Preis</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $item)
                <tr>
                    <td>{{ $item['title'] }}</td>
                    <td>€{{ number_format($item['price'],2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="total">Gesamtbetrag: €{{ number_format($total,2) }}</div>
    <br>
    <div>Vielen Dank für deinen Einkauf!</div>
</body>
</html>
