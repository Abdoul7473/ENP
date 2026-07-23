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
            border-spacing: 12mm 6mm;
        }

        .card-cell {
            width: 60%;
            vertical-align: top;
            padding: -60px;
        }
        .watermark {
            position: absolute;
            top: -4mm;
            left: 10%;
            transform: translateX(-30%) rotate(-35deg);
            font-size: 12px;
            color: rgba(190,18,60,0.35);
        }
        .badge-card {
            position: relative;
            width: 57mm;
            height: 86mm;
            overflow: hidden;
            break-inside: avoid;
            page-break-inside: avoid;
            border-radius: 5mm;
            background: while;
            border: 1.4px solid #494e53;
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
            width: 40mm;
            height: 4mm;
            overflow: hidden;
            left:10mm;
            break-inside: avoid;
            page-break-inside: avoid;
            border: 2px solid #e93b0b;
            border-radius: 0mm;
            background: while;
            text-align: center;
            
        }

        .card-title {
            margin: 1mm 0 2mm;
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
            top: 8mm;
        }

        .photo-column { left: 3mm; width: 25mm; }
        .details-column { left: 8mm; width: 40mm; }

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
       
        .background {
            top: 100;
            left: 0;
            width: 100%;
            height: auto;
            opacity: 1; /* Opacité de l'arrière-plan */
            z-index: 0; /* Assurez-vous que l'arrière-plan est derrière le contenu */
            background-position: center;
            background-size: 500px;
        }
         .panche-gauche{
    transform: rotate(90deg);
   
}

.panche-droite{
    
    transform: rotate(-90deg);
     
}
    </style>
</head>

<body>


<table  class="cards-table">
    @foreach($rectos as $row)
        <tr style="margin-top: 100px;" >
            <td class="card-cell" >
                <section class=" badge-card  panche-gauche" >
                     <div style="text-align: center;" class="watermark">
                    <hr style="border:none;height: 25px;width: 250px; background-color:red;">
                    <hr style="margin-left : 100px; width: 15px; height: 15px; background-color: red; border-radius: 50%;" align="center">
                    <hr style="border:none;height: 25px; width: 250px;  background-color:green;">
                </div>
                    <div class="card-title">
                        <b> <strong style="font-family: 'Times New Roman', serif; font-size: 8px;">REPUBLIQUE DU NIGER</strong> </b> 
                        <br>
                        <i><strong style="font-family: 'Times New Roman', serif; font-size: 8px;">Fraternité-Travail-Progès</strong></i>
                    </div>
                    <h6 class="card-title">
                        <b><strong style="font-family: Arial black; color: black;">Ministère de l'Intérieur, de la Sécurité <br> Publique et  l'Administration du <br> Territoire</strong></b> 
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
                        </h6>
                        <h6 class="card-title">
                        @if($row->compagnie->corp->id == 4)
                            <strong class="cas" style="color: #F10909FF; margin-top: 80px;" >
                                élève {{ $row->compagnie->corp->nom }} de police
                            </strong>
                        @endif
                        @if($row->compagnie->corp->id == 3)
                            <strong class="cas" style="color: rgb(5, 5, 5); margin-top: 80px;">
                                élève {{ $row->compagnie->corp->nom }} de police
                            </strong>
                        @endif
                        @if($row->compagnie->corp->id == 2)
                            <strong class="cas" style="color: rgb(19, 203, 13); margin-top: 80px;">
                                élève {{ $row->compagnie->corp->nom }} de police
                            </strong>
                        @endif
                        @if($row->compagnie->corp->id == 1)
                            <strong class="cas" style="color: rgb(21, 205, 212); margin-top: 80px;">
                                élève {{ $row->compagnie->corp->nom }} de police
                            </strong>
                        @endif
                        </h6>
                        <strong class="cas" style=" font-family: 'Times New Roman', Times, serif; font-size: 9px; margin-top: 80px;">N°{{$row->ordre}}/{{$libelle}}/DGPN/DENP/FP</strong>
                    </section>
                    <div style=" text-align: center; margin-left: 40%; margin-top:70px">
                        @if($row->photo)
                            <img width="110"  src="eleves/{{$row->photo}}" alt=""/>
                        @endif
                    </div>
                </section>
            </td>
            <td class="card-cell" >
                <section class="badge-card panche-droite">   
                    <div class="card-title">
                        <section class="card-mat">  
                            <h6 class="card-title">
                            Matricule <strong style="color:red" > {{$row->matricule}}</strong>
                            </h6>               
                        </section>
                    </div>
                    <br>
                    
                    <div class="details-column ">
                        <p class="detail-line"><strong style="font-family: 'Times New Roman', Times, serif;font-size:10px;">Nom :</strong> <b  style="font-family: 'Times New Roman', Times, serif;font-size:9px;"> {{ $row->nom }}</b></p>
                        <p class="detail-line"><strong style="font-family: 'Times New Roman', Times, serif;font-size:10px;">Prénom :</strong> <b style="font-family: 'Times New Roman', Times, serif;font-size:9px;">{{ $row->prenom }}</b></p>
                        <p class="detail-line"><strong style="font-family: 'Times New Roman', Times, serif;font-size:10px;">Né(e) le :</strong><b style="font-family: 'Times New Roman', Times, serif;font-size:9px;"> {{ $row->date_naiss }}</b></p>
                        <p class="detail-line"><strong style="font-family: 'Times New Roman', Times, serif;font-size:10px;">A :</strong> <b>{{ $row->lieu_naiss  }} </b></p>
                        <p class="detail-line"><strong style="font-family: 'Times New Roman', Times, serif;font-size:10px;">GROUPE SANGUIN :</strong> <b style="font-family: 'Times New Roman', Times, serif;font-size:9px;"> {{ $row->groupe_sanguin }}</b></p>
                        <p class="detail-line"><strong style="font-family: 'Times New Roman', Times, serif;font-size:10px;">VALABLE DU :</strong> <b style="font-family: 'Times New Roman', Times, serif;font-size:9px;"> 20/12/2025</b></p>
                        <p class="detail-line"><strong style="font-family: 'Times New Roman', Times, serif;font-size:10px;">AU :</strong> <b style="font-family: 'Times New Roman', Times, serif;font-size:9px;"> 19/06/2027</b></p>
                        <div style=" text-align: center; margin-top:-100%">
                            <img src="armoirie.jpeg" width="90"; height="90";  class="background" style=" text-align: center;"> 
                            <h4> Fait à Niamey le {{$date}} </h4> 
                            <b >
                                Signature et Cachet
                            </b><br>
                            <img width="200"  src="signatures/{{$signature->libelle}}" alt=""/>
                        </div>
                    </div>
                </section>
            </td>
        </tr>
        
    @endforeach
</table>
</body>
</html>