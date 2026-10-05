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
            width: 1%;
            height: 40%;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
             border: 2px solid #e93b0b;
            
        }

        /* Bordure décorative */
       

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

        /* .qr-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            background: #fafafa;
            border-radius: 12px;
            border: 2px dashed #e0e0e0;
        } */

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

           

            .qr-wrapper {
                border: none;
                background: none;
            }
        }

        /* Responsive */
        @media screen and (max-width: 820px) {
            .invitation-card {
                width: 95%;
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
    <div>
     @forelse($cartes as $carte)
            <div class="invitation-card">
                <div style="display: flex;flex-wrap: wrap; margin: 0 -10px;">
                    <div>
                        <img src="logo_pn.jpg" style="width: 100px; height:auto;">
                    </div>
                    <div style="width: 100%; height:auto; margin-top: -120px;  text-align: center;">

                        <b> <strong>REPUBLIQUE DU NIGER</strong> </b>
                        <br>
                        <i><strong>Fraternité-Travail-Progès</strong></i>
                        <h5>
                            <b><strong>Ministère de l'Intérieur, de la Sécurité <br> Publique et l'Administration du <br> Territoire</strong></b>
                        </h5>
                        <h5>
                            <b><strong>DIRECTION GENERALE <br> DE LA POLICE NATIONALE</strong></b>
                        </h5>
                        <h5>
                            <b><strong>DIRECTION DE L'ECOLE NATIONALE DE <br> POLICE ET DE LA FORMATION PERMANENTE</strong></b>
                        </h5>
                        <div>
                            <img src="logo_enp.png" style="width: 100px; height:auto; margin-top: -160px; margin-left: 80%;" alt="Logo">
                        </div>
                        <br>
                    </div>
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
                   
                            <div  style=" gap: 10px; font-size: 20px; font-weight: bold;color: #1a237e;display: flex;flex-wrap: wrap; margin: 0 -10px;margin-top: 30px;">
                                <div class="date-time">
                                <span>19/09/2026</span>
                            </div>
                        <div class="info-col" style="display: flex;flex-wrap: wrap; margin: 0 -10px;margin-top: -90px;">
                            <div class="qr-wrapper">
                               
                            <img  src="data:image/png;base64,{{ DNS2D::getBarcodePNG($carte['numero'], 'QRCODE', 6, 6, [0,0,0], [255,255,255]) }}">
                            </div>
                        </div>
                        <div class="info-col" style="width: 100px; height:auto; margin-top: -160px; margin-left: 80%;">
                            <div class="date-time">
                                <span>08h:00</span>
                               
                            </div>
                        </div>
                </div>
                 @empty
            <p>Aucune carte disponible.</p>
        @endforelse
            </div>
            <br>
        
</body>
</html>