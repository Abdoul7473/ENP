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

        .background {
            top: 150;
            left: 0;
            width: 80%;
            height: auto;
            opacity: 0.2; 
            z-index: 0; 
            background-position: center;
            background-size: 400px;
        }
        .card-mat {
            position: absolute;
            width: 35mm;
            height: 8mm;
            overflow: hidden;
            left:10mm;
            break-inside: avoid;
            page-break-inside: avoid;
            border: 2px solid #e93b0b;
            border-radius: 0mm;
            background: while;
            text-align: center;
            
        }
        .badge-card {
            position: relative;
            width: 100%;
            height: 85mm;
            left: 300px;
            
            border-radius: 5mm;
            background: while;
        }
        .panche-gauche{
            transform: translateX(-30%) rotate(90deg);
        }
         .panche-droite{
            transform: translateX(-30%) rotate(-90deg);
        }
    </style>
</head>

<body>


<table >
    @foreach($rectos as $row)
        <tr>
            
                <td >
                    <section class="badge-card panche-gauche"> 
                    <div style="text-align: center;"  class="watermark">
                        <hr style="border:none;height: 25px; background-color:red;">
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
                           <strong class="cas">élève {{$row->compagnie->corp->nom}} de police</strong>
                           <br>
                           <strong class="cas">N°{{$row->ordre}}/{{$libelle}}/DGPN/DENP/FP</strong>
                        </h6>               
                        </section>
                        
                        <div style=" text-align: center; margin-left: 40%; margin-top:70px">
                            @if($row->photo)
                                <img width="100" panche-gauche" src="eleves/{{$row->photo}}" alt=""/>
                            @endif
                        </div>
                        
                            <div class="card-title">
                            <section class="card-mat">  
                                <h6 class="card-title">
                               Matricule <strong style="color:red" > {{$row->matricule}}</strong>
                                </h6>               
                            </section>
                        </div>
                        <br>
                        <br>
                        <br>
                         <div class="details-column">
                            <p class="detail-line"><strong>Nom :</strong> <b class="cas"> {{ $row->nom }}</b></p>
                            <p class="detail-line"><strong>Prénom :</strong> <b>{{ $row->prenom }}</b></p>
                            <p class="detail-line"><strong>Né(e) le :</strong><b> {{ $row->date_naiss }}</b></p>
                            <p class="detail-line"><strong>A :</strong> <b>{{ $row->lieu_naiss  }} </b></p>
                            <p class="detail-line"><strong>GROUPE SANGUIN :</strong> <b> {{ $row->groupe_sanguin }}</b></p>
                            <p class="detail-line"><strong>VALABLE DU :</strong> <b> 20/12/2025</b></p>
                            <p class="detail-line"><strong>AU :</strong> <b> 19/06/2027</b></p>
                        </div>
                            <div style=" text-align: center; margin-top:10px">
                                <img src="armoirie.jpeg" width="80"; height="80"; class="background" style=" text-align: center;"> 
                               <h2> Fait à Niamey le {{$date}} </h2> 
                               <b>Signature et Cachet</b> <br>
                                <img width="200"  src="signatures/{{$signature->libelle}}" alt=""/>
                            </div>
                        </div>
                    </section>
                </td>
                @endforeach
            </tr>
    </table>



</body>
</html>