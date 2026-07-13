<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport des dépôts</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .title { text-align: center; font-size: 16px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
        .filters { margin-bottom: 10px; font-size: 12px; }
        .total { margin-top: 10px; text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="title">Rapport des dépôts</div>
    <div class="filters">
        @if(!empty($filters['startDate']) || !empty($filters['endDate']))
            <div>Période :
                {{ $filters['startDate'] ?? '...' }} - {{ $filters['endDate'] ?? '...' }}
            </div>
        @endif
        @if(!empty($filters['user']))
            <div>Utilisateur : {{ $filters['user'] }}</div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Utilisateur</th>
                <th>Montant (FCFA)</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deposits as $index => $deposit)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ optional(optional($deposit->virtualAccount)->user)->email }}</td>
                    <td>{{ number_format($deposit->amount, 0, '', ' ') }}</td>
                    <td>{{ $deposit->created_at }}</td>
                    <td>{{ $deposit->status == 'pending' ? 'En attente' : 'Actif' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">Total : {{ number_format($total, 0, '', ' ') }} FCFA</div>
</body>
</html>
