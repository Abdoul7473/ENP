<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page avec arrière-plan d'image</title>
    <!-- <style>
        body {
            /* Définissez la taille de l'image et la manière dont elle se répète ou non */
            background-image: url('C:Users/Abdoul/workspace/ANAC/public/anac.png');
            background-size: cover; /* pour couvrir l'ensemble du corps */
            background-repeat: no-repeat; /* pour ne pas répéter l'image */
            /* Vous pouvez également spécifier d'autres styles comme la couleur de fond en cas d'échec du chargement de l'image */
            background-color: #f2f2f2; /* couleur de secours */
        }
    </style> -->
    <style>
         body {
            /* Définissez la taille de l'image et la manière dont elle se répète ou non */
            background-image: url('anac.png');
            background-repeat: no-repeat; /* pour ne pas répéter l'image */
            background-size: 80% 70%;
            /* Vous pouvez également spécifier d'autres styles comme la couleur de fond en cas d'échec du chargement de l'image */
            /* background-color: #f:2f2f2; couleur de secours */
            margin: 0;
            filter: blur(100px);
            padding: 0;
            background-position: center;
        }
        .table1 {
            float: left;
            font-weight: normal;
            font-size: 14px;
            border-collapse: collapse;
        }
        .table2 {

            margin-left: 530px;
            font-weight: normal;
            font-size: 14px;
            border-collapse: collapse;
        }
        tr {
            text-align: center;
        }
        td,
        th {
            border: 0.5px solid black;

        }
        .container {
            width: 95%;
            height: 70%;
            margin: 20px auto;
            background-color: #fff;
            border: 2px solid #333;
            border-radius: 15px;
            padding: 20px; /* Assure que le conteneur entoure les tableaux */
        }
        .justify {
            margin-top: 30px;
        }
        .middle {
            text-align: center;
        }
        .row {
            display: flex;
            justify-content: space-between;
            padding: 10px; /* Ajout d'un padding pour une meilleure lisibilité */
        }
    </style>
</head>
<body>
    <!-- Contenu de votre page va ici -->
    <div style="margin-left: 60px;">
    <h3>REPUBLIQUE DU NIGER</h3>
    <p>MINISTERE DES TRANSPORTS <br> &nbsp; ET DE L'EQUIPEMENT</p>
    <img width="200" height="200" src="../../ANAC/public/anac.png" alt=""/>
    </div>
    <div style="margin-left: 15%;">
    <u>DEMANDE D’AUTORISATION DE SURVOL ET/OU D’ATTERRISSAGE</u>
    </div>
    <br>
    <u >1. Nature de la demande </u>
    <br>
    <br>

    <input type="checkbox" id="survol" name="survol" value="'{{$demande->type_demande->libelle}}'" checked>
    <label for="survol">{{$demande->type_demande->libelle}}
        </label>
        <br>
        2. Type et immatriculation de l'aérone
        <br>
        <br>
        <div >
        <table class="table1">
            <thead>
                <tr >
                    <th width="25">Type</th>
                    <th width="25">Imatriculation</th>
                    <th width="25">Indicatif d'appel</th>
                    <th width="25">Proprietaire </th>
                    <th width="25">Nom Exploitant</th>
                    <th width="25">Telephone Exploitant</th>
                    <th width="25">E-mail Exploitant</th>
                    <th width="25">Commandant de bord</th>
                </tr>
            </thead>
            <tbody>
                <thead>
            @foreach($demande->aeronefs as $aeronef)
                <tr>
                    <td width="90" height="20">{{$aeronef->type}}</td>
                    <td width="25">{{$aeronef->imatriculation}}</td>
                    <td width="10">{{$aeronef->indicatif_appel}} </td>
                    <td width="90" height="20">{{$aeronef->proprietaire_aeronef}}</td>
                    <td width="25">{{$aeronef->nom_exploitant}}</td>
                    <td width="10">{{$aeronef->tel_exploitant}} </td>
                    <td width="90" height="20">{{$aeronef->email_exploitant}}</td>
                    <td width="25">{{$aeronef->commandant_bord}}</td>
                </tr>
                @endforeach
                </thead>
            </tbody>
        </table>
        </div>
        <br>
       <u> 3.Itinéraire du/des vol(s) avec dates et heures en Temps Universel (TU)</u>
       <br>
       <br>
<div>
<table  style="border-collapse: collapse;
            width: 100%; ">
    <thead>
    <tr >
        <th rowspan="2" style="border: 1px solid ;
        padding: 7px;  ">DATE <br>(DD/MM/YY)</th>
        <th colspan="2" style="border: 1px solid ;
        padding: 7px;  "><center>ROUTE(ICAO <br> CODE)</center></th>
        <th colspan="2" style="border: 1px solid ;
        padding: 7px;  "><center>TIME <br>(UTC/Z)</center></th>
        <th rowspan="2" style="border: 1px solid ;
        padding: 7px;  "><center>REMARKS</center></th>
    </tr>

    <tr >
        <th style="border: 1px solid ;
        padding: 7px;  ">
            <div>DEP</div>
        </th>
        <th style="border: 1px solid ;
        padding: 7px;  ">
            <div>ARR</div>
        </th>
        <th style="border: 1px solid ;
        padding: 7px;  ">
            <div>ETD</div>
        </th>
        <th style="border: 1px solid ;
        padding: 7px;  ">
            <div>ETA</div>
        </th>
    </tr>
    </thead>
    <tbody>
    <thead>
            @foreach($routes as $route)
                <tr>
        <td style="border: 1px solid ;
        padding: 7px;  "><center>{{$route->date_route}}</center></td>
        <td style="border: 1px solid ;
        padding: 7px;  "><center>{{$route->ville_depar->libelle}} / {{$route->ville_depar->code}}</center></td>
        <td style="border: 1px solid ;
        padding: 7px;  "><center>{{$route->ville_arive->libelle}} / {{$route->ville_arive->code}}</center></td>
        <td style="border: 1px solid ;
        padding: 7px;  "><center>{{$route->heure_depart}} </center></td>
        <td style="border: 1px solid ;
        padding: 7px;  "><center>{{$route->heure_arrive}} </center></td>
        <td style="border: 1px solid ;
        padding: 7px;  ">  @if($route->remarque != '')<center>{{$route->remarque}} </center></td>
            @else
            <p>RAS </p>
            @endif
    </tr>
    </thead>
    @endforeach
    </tbody>
</table>
<br>
<br>
</div>
4.Motif du vol
<br>
    <br>

    <input type="checkbox"  value="'{{$demande->type_vol->libelle}}'" checked>
   <label > {{$demande->type_vol->libelle}}
        </label>
    &nbsp; &nbsp;
        @if($demande->type_vol->libelle == 'Autre')
            Précision: {{$demande->preciser}}
            @else

            @endif

        <br>
    5. Identité complète de la personne (physique ou morale) qui soumet la demande
de survol/atterrissage :
<br>
<div style="margin-left: 10%;">
<li><u> Nom Prénom ou Nom de la societé</u> : <b>{{$demande->user->postulant->nom_raison_sociale}}</b> </li><br>

<li><u>Adresse</u>: <b>{{$demande->user->postulant->adresse}}</b></li> <br>
<li><u>E-mail</u>  : <b>{{$demande->user->email}}</b></li><br>
<li><u>Telephones</u> &nbsp;:@foreach($demande->user->postulant->tel as $tel)</li>
{{$tel}}
@endforeach <br>
</div>
<p>Fait à {{$demande->ville_fait}} le {{$demande->date_demande}}</p>

<div style="margin-left: 60%;">
<p> &nbsp; Signature et Cacher</p>
<img width="200" height="200" src="signatures/{{$demande->user->postulant->signature_cachet}}" alt=""/>
</div>
</body>
</html>
