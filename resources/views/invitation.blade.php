<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cartes d'invitation</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .invitation-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
        }

        .invitation-card {
            width: 794px;
            min-height: 450px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            page-break-after: always;
            padding: 30px;
            position: relative;
        }

        /* Bordure décorative */
        .invitation-card::before {
            content: '';
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            pointer-events: none;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            position: relative;
        }

        .logo-container {
            flex-shrink: 0;
        }

        .logo-container img {
            width: 70px;
            height: auto;
            display: block;
            border-radius: 4px;
        }

        .header-center {
            text-align: center;
            flex: 1;
            padding: 0 20px;
        }

        .header-center .ministere {
            font-size: 14px;
            font-weight: normal;
            color: #333;
            letter-spacing: 1px;
        }

        .header-center .direction {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin: 5px 0;
            letter-spacing: 0.5px;
        }

        .header-center .ecole {
            font-size: 14px;
            font-weight: normal;
            color: #444;
            margin: 5px 0;
        }

        .header-center .title {
            font-size: 28px;
            font-weight: bold;
            color: #00bfff;
            margin: 10px 0;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .content {
            padding: 10px 0;
            text-align: center;
            position: relative;
        }

        .content .patronage {
            font-size: 13px;
            color: #333;
            line-height: 1.6;
            margin-bottom: 15px;
            font-style: italic;
        }

        .content .invitation-text {
            font-size: 15px;
            color: #222;
            line-height: 1.8;
            margin: 15px 0;
            font-weight: 500;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding: 0 20px;
        }

        .info-col {
            flex: 1;
            text-align: center;
        }

        .info-col .date-time {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #1a237e;
        }

        .info-col .date-time .icon {
            font-size: 28px;
        }

        .qr-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            background: #fafafa;
            border-radius: 12px;
            border: 2px dashed #e0e0e0;
        }

        .qr-wrapper svg {
            width: 100px !important;
            height: 100px !important;
            display: block;
        }

        .qr-wrapper img {
            width: 100px;
            height: 100px;
            display: block;
        }

        .numero-info {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #999;
            text-align: center;
        }

        /* Media Print */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .invitation-container {
                gap: 0;
            }

            .invitation-card {
                box-shadow: none;
                border-radius: 0;
                page-break-after: always;
                margin: 0;
                padding: 20px;
                width: 100%;
                min-height: 100vh;
            }

            .invitation-card::before {
                display: none;
            }

            .qr-wrapper {
                border: none;
                background: none;
            }
        }

        /* Responsive */
        @media screen and (max-width: 820px) {
            .invitation-card {
                width: 100%;
                padding: 20px;
            }

            .header {
                flex-wrap: wrap;
                justify-content: center;
            }

            .header-center {
                order: -1;
                width: 100%;
                padding: 0 0 10px;
            }

            .info-row {
                flex-wrap: wrap;
                gap: 20px;
            }

            .info-col {
                flex: 0 0 100%;
            }
        }
    </style>
</head>

<body>
    <div class="invitation-container">
        @forelse($cartes as $carte)
            <div class="invitation-card">
                <!-- En-tête -->
                <div class="header">
                    <div class="logo-container">
                        <img src="{{ asset('storage/logo_pn.jpg') }}" alt="Logo Police Nationale" />
                    </div>
                    <div class="header-center">
                        <div class="ministere">MINISTERE DE L'INTERIEUR</div>
                        <div class="direction">DIRECTION GENERALE DE LA POLICE NATIONALE</div>
                        <div class="ecole">ECOLE NATIONALE DE POLICE ET DE FORMATION PERMANENTE</div>
                        <div class="title">INVITATION</div>
                    </div>
                    <div class="logo-container">
                        <img src="{{ asset('storage/logo_enp.png') }}" alt="Logo ENP" />
                    </div>
                </div>

                <!-- Contenu -->
                <div class="content">
                    <p class="patronage">
                        SOUS LE HAUT PATRONAGE DE SON EXCELLENCE, MONSIEUR LE MINISTRE D'ETAT,<br />
                        MINISTRE DE L'INTERIEUR DE LA SECURITE PUBLIQUE ET DE L'ADMINISTRATION DU TERRITOIRE
                    </p>

                    <p class="invitation-text">
                        Le Directeur Général de la Police Nationale, vous prie de bien vouloir honorer<br />
                        de votre présence à la cérémonie de présentation au drapeau des élèves policiers,<br />
                        promotion 2025
                    </p>

                    <!-- Date, QR Code, Heure -->
                    <div class="info-row">
                        <div class="info-col">
                            <div class="date-time">
                                <span class="icon">📅</span>
                                <span>19/09/2026</span>
                            </div>
                        </div>
                        <div class="info-col">
                            <div class="qr-wrapper">
                                {!! $carte['qr'] !!}
                            </div>
                        </div>
                        <div class="info-col">
                            <div class="date-time">
                                <span>08h:00</span>
                                <span class="icon">🕐</span>
                            </div>
                        </div>
                    </div>

                    <div class="numero-info">
                        N° {{ $carte['numero'] ?? '---' }}
                    </div>
                </div>
            </div>
        @empty
            <p>Aucune carte disponible.</p>
        @endforelse
    </div>
</body>
</html>