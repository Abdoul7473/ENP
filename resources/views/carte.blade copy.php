<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Cartes d'assurance sociale</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 12mm 10mm 18mm;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: #1f2933;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
        }

        .cards-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 7mm 6mm;
        }

        .card-cell {
            width: 50%;
            vertical-align: top;
        }
        .watermark {
            position: absolute;
            top: -15mm;
            left: 20%;
            transform: translateX(-30%) rotate(-35deg);
            font-size: 12px;
            color: rgba(190,18,60,0.35);
        }
        .badge-card {
            position: relative;
            width: 55mm;
            height: 85mm;
            overflow: hidden;
            break-inside: avoid;
            page-break-inside: avoid;
            border: 1.4px solid #494e53;
            border-radius: 5mm;
            background: while;
        }
         .carde {
            position: absolute;
            width: 45mm;
            height: 15mm;
            overflow: hidden;
            left:4mm;
            break-inside: avoid;
            page-break-inside: avoid;
            border: 1.4px solid #494e53;
            border-radius: 5mm;
            background: while;
            text-align: center;
            
        }

        .card-title {
            margin: 2.2mm 0 2mm;
            color: #22272e;
            font-size: 9px;
            font-weight: 400;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .cas{
            text-transform: uppercase;

        }

        .photo-column, .details-column {
            position: absolute;
            top: 12.6mm;
        }

        .photo-column { left: 3mm; width: 25mm; }
        .details-column { left: 5mm; width: 37mm; }

        .profile-img {
            width: 21.5mm;
            height: 21.5mm;
            object-fit: cover;
            background: #fff;
        }

        .detail-line {
            margin: 0 0 1.05mm;
            font-size: 8px;
        }

        .detail-line strong { font-weight: 700; }

        .logo {
            position: absolute;
            top: 10mm;
            right: 4mm;
            width: 16mm;
        }

        .qr-code {
            position: absolute;
            right: 5mm;
            top: 30.5mm;
            width: 13.7mm;
        }

        .background {
            position: fixed;
            top: 150;
            left: 0;
            width: 100%;
            height: auto;
            opacity: 0.2; /* Opacité de l'arrière-plan */
            z-index: 0; /* Assurez-vous que l'arrière-plan est derrière le contenu */
            background-position: center;
            background-size: 500px;
        }
    </style>
</head>

<body>
<img src="anac.png" class="background" alt="Background Image">
@if(count($eleves) > 0)

<table class="cards-table">
    @foreach($eleves as $row)
        <tr>
            @foreach($row as $insuree)
                <td class="card-cell">
                    <section class="badge-card">                     
                        <h6 class="card-title">
                    <div style="text-align: center;"  class="watermark">
                        <hr style="border:none;height: 25px; background-color:orange;">
                        <div style="margin-left : 300px; width: 30px; height: 30px; background-color: orange; border-radius: 50%;"></div>
                        <hr style="border:none;height: 25px; background-color:green;">
                    </div>
                    <div class="card-title">
                           <b> <strong>REPUBLIQUE DU NIGER</strong> </b> 
                            <br>
                             <i><strong>Fraternité-Travail-Progès</strong></i>
                             </div>
                        <h6 class="card-title">
                           <b><strong>Ministère de l'Intérieur, de la Sécurité <br> Publique et  l'Administration du <br> Territoire</strong></b> 
                        </h6>
                        <h6 class="card-title">
                           <b><strong>DIRECTION GENERALE <br> DE LA POLICE NATIONALE</strong></b> 
                        </h6>
                        
                        <h6 class="card-title">
                           <b><strong>DIRECTION DE L'ECOLE NATIONALE DE <br> POLICE ET DE LA FORMATION PERMANENTE</strong></b> 
                        </h6>
                        <section class="carde">  
                        <h6 class="card-title">
                           <strong>CARTE D'IDENTITE PROVISOIRE</strong>
                           <br>
                           <strong class="cas">élève {{$insuree->compagnie->corp->nom}} de police</strong>
                           <br>
                           <strong class="cas">N°{{$insuree->ordre}}/2026/DGPN/DENP/FP</strong>
                        </h6>               
                        </section>
                        
                        <div style=" text-align: center; margin-left: 40%; margin-top:70px">
                            @if($insuree->photo)
                                <img width="100"  src="eleves/{{$insuree->photo}}" alt=""/>
                            @endif
                        </div>
                    </section>
                </td>
            @endforeach
        </tr>
    @endforeach
</table>

@else
    <p class="empty-message">Aucune donnée disponible</p>
@endif



</body>
</html>