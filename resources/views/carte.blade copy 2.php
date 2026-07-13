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
        .card-mat {
            position: absolute;
            width: 35mm;
            height: 8mm;
            overflow: hidden;
            left:10mm;
            break-inside: avoid;
            page-break-inside: avoid;
            border: 3px solid #e93b0b;
            border-radius: 0mm;
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
            font-size: 10px;
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

        .watermark-container {
            position: relative;
            width: 100%;
            height: 400px; /* Ajustez la hauteur selon vos besoins */
            font-family: 'Helvetica', sans-serif;
        }
        .watermark {
            position: absolute;
            top: 80%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px; /* Ajustez la taille de la police selon vos besoins */
            color: red; /* La transparence du filigrane */
            white-space: nowrap; /* Évite les retours à la ligne */
            pointer-events: none; /* Évite les interactions avec le filigrane */
        }
        .background {
            /* position: fixed; */
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
<table class="cards-table">
    @foreach($eleves as $row)
        <tr>
            @foreach($row as $insuree)
                <td class="card-cell">
                    
                    <section class="badge-card">   
                        <div class="card-title">
                            <section class="card-mat">  
                                <h6 class="card-title">
                               Matricule <strong style="color:red" > {{$insuree->matricule}}</strong>
                                </h6>               
                            </section>
                        </div>
                        <br>
                        <br>
                        <br>
                         <div class="details-column">
                            <p class="detail-line"><strong>Nom :</strong> <b class="cas"> {{ $insuree->nom }}</b></p>
                            <p class="detail-line"><strong>Prénom :</strong> <b>{{ $insuree->prenom }}</b></p>
                            <p class="detail-line"><strong>Né(e) le :</strong><b> {{ $insuree->date_naiss }}</b></p>
                            <p class="detail-line"><strong>A :</strong> <b>{{ $insuree->lieu_naiss  }} </b></p>
                            <p class="detail-line"><strong>GROUPE SANGUIN :</strong> <b> {{ $insuree->groupe_sanguin }}</b></p>
                            <p class="detail-line"><strong>VALABLE DU :</strong> <b> 20/12/2025</b></p>
                            <p class="detail-line"><strong>AU :</strong> <b> 19/06/2027</b></p>
                        </div>
                            <div style=" text-align: center; margin-top:10px">
                                <img src="armoirie.jpeg" width="80"; height="80"; class="background" style=" text-align: center;"> 
                               <h2> Fait à Niamey le {{$date}} </h2> 
                               <b>Signature et Cachet</b> <br>
                                <img width="200"  src="signatures/{{$signature->libelle}}" alt=""/>
                            </div>
                    </section>
                    
                </td>
            @endforeach
        </tr>
    @endforeach
</table>
</body>
</html>