<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Cartes d'identité</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 12mm 10mm 18mm;
        }

        * { 
            box-sizing: border-box; 
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            color: #1f2933;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
            background: #f5f5f5;
        }

        /* ===== SYSTEME DE GRILLE ===== */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 10px;
        }

        /* ===== CONTENEUR DES CARTES ===== */
        .card-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10mm;
            padding: 5mm 0;
        }

        /* ===== STYLES DES CARTES ===== */
        .card-face {
            width: 85mm;
            height: 54mm;
            flex-shrink: 0;
            border: 1.4px solid #494e53;
            border-radius: 5mm;
            background: white;
            overflow: hidden;
            position: relative;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Rotation des cartes */
        .card-face-verso {
            transform: rotate(90deg);
            transform-origin: center center;
        }

        .card-face-recto {
            transform: rotate(-90deg);
            transform-origin: center center;
        }

        /* Contenu interne des cartes */
        .card-inner {
            width: 54mm;
            height: 85mm;
            padding: 3mm 4mm;
            position: relative;
            transform: rotate(-90deg);
            transform-origin: center center;
        }

        .card-inner-verso {
            transform: rotate(90deg);
            transform-origin: center center;
        }

        /* ===== STYLES RECTO ===== */
        .recto-content {
            padding: 2mm 3mm;
            height: 100%;
            position: relative;
        }

        .recto-header {
            text-align: center;
            font-size: 6px;
            line-height: 1.3;
        }

        .recto-header .pays {
            font-size: 7px;
            font-weight: bold;
            color: #1a237e;
        }

        .recto-header .devise {
            font-size: 5px;
            color: #555;
        }

        .recto-banner {
            background: #c62828;
            color: white;
            padding: 0.5mm;
            text-align: center;
            font-size: 7px;
            font-weight: bold;
            border-radius: 1mm;
            margin: 0.5mm 0;
        }

        .recto-photo-area {
            float: left;
            width: 22mm;
            text-align: center;
            margin-right: 2mm;
        }

        .recto-photo-area img {
            width: 20mm;
            height: 20mm;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 2mm;
        }

        .recto-matricule {
            background: #c62828;
            color: white;
            font-size: 5px;
            padding: 0.3mm;
            border-radius: 1mm;
            margin-top: 0.5mm;
        }

        .recto-details {
            float: left;
            width: 24mm;
        }

        .recto-details p {
            margin: 0 0 0.6mm;
            font-size: 6.5px;
            line-height: 1.3;
        }

        .recto-details p strong {
            font-weight: 700;
        }

        .recto-footer {
            clear: both;
            text-align: center;
            font-size: 5px;
            border-top: 1px solid #eee;
            padding-top: 0.5mm;
            margin-top: 1mm;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        /* ===== STYLES VERSO ===== */
        .verso-content {
            padding: 3mm;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .verso-header {
            text-align: center;
            font-size: 7px;
            font-weight: bold;
            color: #1a237e;
            border-bottom: 2px solid #1a237e;
            padding-bottom: 1mm;
            margin-bottom: 2mm;
        }

        .verso-header small {
            font-weight: normal;
            font-size: 6px;
        }

        .verso-title {
            text-align: center;
            font-size: 8px;
            font-weight: bold;
            color: #c62828;
            margin: 1mm 0;
        }

        .verso-row {
            display: flex;
            justify-content: space-between;
            padding: 0.8mm 1mm;
            border-bottom: 1px dotted #ccc;
            font-size: 7px;
        }

        .verso-row .label {
            font-weight: bold;
            color: #333;
        }

        .verso-row .value {
            color: #1a237e;
            font-weight: 600;
        }

        .verso-signature {
            margin-top: auto;
            text-align: center;
            font-size: 6px;
            padding-top: 2mm;
            border-top: 1px solid #ddd;
        }

        .verso-signature img {
            max-width: 50mm;
            max-height: 8mm;
        }

        .cas {
            text-transform: uppercase;
        }

        /* ===== ÉTIQUETTES ===== */
        .face-label {
            position: absolute;
            bottom: -5mm;
            left: 50%;
            transform: translateX(-50%);
            font-size: 6px;
            color: #999;
            font-style: italic;
        }

        .card-title-label {
            text-align: center;
            font-size: 8px;
            font-weight: bold;
            color: #1a237e;
            margin-bottom: 2mm;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media print {
            .face-label { display: none; }
            .card-title-label { display: none; }
            body { background: white; }
            .card-face { box-shadow: none; }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .col-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
            .card-face {
                width: 70mm;
                height: 45mm;
            }
            .card-inner {
                width: 45mm;
                height: 70mm;
            }
        }
    </style>
</head>

<body>

<!-- ===== DISPOSITION EN GRILLE ===== -->
<div class="row">
    
    <!-- ===== COLONNE GAUCHE : RECTO ===== -->
    <div class="col-6">
        <div class="card-title-label">▼ RECTO</div>
        <div class="card-wrapper">
            @foreach($rectos as $row)
                <div class="card-face card-face-recto">
                    <div class="card-inner">
                        <div class="recto-content">
                            <!-- En-tête -->
                            <div class="recto-header">
                                <div class="pays">RÉPUBLIQUE DU NIGER</div>
                                <div class="devise">Fraternité-Travail-Progrès</div>
                                <div style="font-size:5px; margin:0.3mm 0;">
                                    Ministère de l'Intérieur, de la Sécurité Publique<br>
                                    et l'Administration du Territoire
                                </div>
                                <div style="font-size:5px; font-weight:bold;">
                                    DIRECTION GÉNÉRALE DE LA POLICE NATIONALE
                                </div>
                                <div style="font-size:4.5px;">
                                    DIRECTION DE L'ÉCOLE NATIONALE DE POLICE<br>
                                    ET DE LA FORMATION PERMANENTE
                                </div>
                            </div>

                            <!-- Bandeau rouge -->
                            <div class="recto-banner">CARTE D'IDENTITÉ PROVISOIRE</div>
                            <div style="text-align:center; font-size:5.5px; font-weight:bold;">
                                ÉLÈVE {{$row->compagnie->corp->nom}} DE POLICE
                            </div>
                            <div style="text-align:center; font-size:5px; color:#c62828; font-weight:bold; margin-bottom:0.5mm;">
                                N°{{$row->ordre}}/{{$libelle}}/DGPN/DENP/FP
                            </div>

                            <!-- Photo + infos -->
                            <div class="clearfix">
                                <div class="recto-photo-area">
                                    @if($row->photo)
                                        <img src="eleves/{{$row->photo}}" alt="Photo"/>
                                    @else
                                        <div style="width:20mm;height:20mm;border:1px solid #ddd;border-radius:2mm;background:#eee;display:flex;align-items:center;justify-content:center;font-size:6px;color:#999;margin:0 auto;">Photo</div>
                                    @endif
                                    <div class="recto-matricule">MATRICULE: {{$row->matricule}}</div>
                                </div>

                                <div class="recto-details">
                                    <p><strong>Nom :</strong> <b class="cas">{{$row->nom}}</b></p>
                                    <p><strong>Prénom :</strong> <b>{{$row->prenom}}</b></p>
                                    <p><strong>Né(e) le :</strong> <b>{{$row->date_naiss}}</b></p>
                                    <p><strong>À :</strong> <b>{{$row->lieu_naiss}}</b></p>
                                    <p><strong>Groupe sanguin :</strong> <b>{{$row->groupe_sanguin}}</b></p>
                                    <p><strong>Valable du :</strong> <b>20/12/2025</b></p>
                                    <p><strong>Au :</strong> <b>19/06/2027</b></p>
                                </div>
                            </div>

                            <div class="recto-footer">
                                Fait à Niamey le {{$date}}
                            </div>
                        </div>
                    </div>
                    <span class="face-label">RECTO</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- ===== COLONNE DROITE : VERSO ===== -->
    <div class="col-6">
        <div class="card-title-label">▼ VERSO</div>
        <div class="card-wrapper">
            @foreach($rectos as $row)
                <div class="card-face card-face-verso">
                    <div class="card-inner card-inner-verso">
                        <div class="verso-content">
                            <div class="verso-header">
                                RÉPUBLIQUE DU NIGER<br>
                                <small>Fraternité-Travail-Progrès</small>
                            </div>

                            <div class="verso-title">CARTE D'IDENTITÉ PROVISOIRE</div>
                            <div style="text-align:center; font-size:6px; margin-bottom:1mm;">
                                Élève {{$row->compagnie->corp->nom}} de police
                            </div>

                            <div class="verso-row">
                                <span class="label">N° carte :</span>
                                <span class="value">{{$row->ordre}}/{{$libelle}}/DGPN/DENP/FP</span>
                            </div>
                            <div class="verso-row">
                                <span class="label">Matricule :</span>
                                <span class="value">{{$row->matricule}}</span>
                            </div>
                            <div class="verso-row">
                                <span class="label">Nom :</span>
                                <span class="value cas">{{$row->nom}}</span>
                            </div>
                            <div class="verso-row">
                                <span class="label">Prénom :</span>
                                <span class="value">{{$row->prenom}}</span>
                            </div>
                            <div class="verso-row">
                                <span class="label">Né(e) le :</span>
                                <span class="value">{{$row->date_naiss}}</span>
                            </div>
                            <div class="verso-row">
                                <span class="label">À :</span>
                                <span class="value">{{$row->lieu_naiss}}</span>
                            </div>
                            <div class="verso-row">
                                <span class="label">Groupe sanguin :</span>
                                <span class="value">{{$row->groupe_sanguin}}</span>
                            </div>
                            <div class="verso-row">
                                <span class="label">Validité :</span>
                                <span class="value">20/12/2025 → 19/06/2027</span>
                            </div>

                            <div class="verso-signature">
                                <div style="font-weight:bold; color:#1a237e;">Signature et cachet</div>
                                @if(isset($signature))
                                    <img src="signatures/{{$signature->libelle}}" alt="Signature"/>
                                @endif
                                <div style="font-size:5px; color:#888;">Fait à Niamey le {{$date}}</div>
                            </div>
                        </div>
                    </div>
                    <span class="face-label">VERSO</span>
                </div>
            @endforeach
        </div>
    </div>

</div>

</body>
</html>