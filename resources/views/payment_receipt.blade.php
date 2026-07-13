<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de paiement</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { display: flex; align-items: center; justify-content: space-between; }
        .logo { width: 90px; }
        .title { text-align: center; font-weight: bold; font-size: 16px; }
        .box { border: 1px solid #333; padding: 10px; margin-top: 10px; }
        .row { display: flex; justify-content: space-between; }
        .label { font-weight: bold; }
        .footer { margin-top: 20px; font-size: 11px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <img src="anac.png" class="logo" alt="Logo">
        <div class="title">
            REPUBLIQUE DU NIGER<br>
            MINISTERE DES TRANSPORTS<br>
            ET DE L'AVIATION CIVILE<br>
            AGENCE NATIONALE DE L'AVIATION CIVILE
        </div>
        <div style="width:90px;"></div>
    </div>

    <div class="box">
        <div class="row">
            <div><span class="label">Reçu N° :</span> {{ $payment->receipt_no_format }}</div>
            <div><span class="label">Date :</span> {{ $payment->created_at }}</div>
        </div>
        <div class="row" style="margin-top:6px;">
            <div><span class="label">Mode :</span> {{ strtoupper($payment->mode) }}</div>
            <div><span class="label">Montant :</span> {{ number_format($payment->amount, 0, '', ' ') }} FCFA</div>
        </div>
    </div>

    <div class="box">
        <div><span class="label">Demande :</span> #{{ $payment->demande->id }}</div>
        <div><span class="label">Postulant :</span> {{ $payment->demande->user->postulant->nom_raison_sociale ?? 'N/A' }}</div>
        <div><span class="label">Type de demande :</span> {{ $payment->demande->type_demande->libelle ?? '' }}</div>
        <div><span class="label">Type de vol :</span> {{ $payment->demande->type_vol->libelle ?? '' }}</div>
        @if(!empty($payment->motif))
            <div><span class="label">Motif :</span> {{ $payment->motif }}</div>
        @endif
    </div>

    <div class="footer">
        BP:727 Niamey / Tel : (+227) 20 72 32 67 / Email : anacniger@anac.ne
    </div>
</body>
</html>
