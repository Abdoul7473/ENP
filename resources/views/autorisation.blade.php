<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche d'autorisation</title>
    <style>
        .header {
            position: fixed;
            top: 20;
            left: 10;
            right: 0;
            /*font-size: 15px;*/
            height: 5px;
            /* background-color: #f0f0f0; */
            font-family: 'Helvetica', sans-serif;
            padding: 10px;
            text-align: center;
        }
        .content {
            position: relative;
            z-index: 1; /* Assurez-vous que le contenu est au-dessus de l'arrière-plan */
            margin-left: 50px;
            margin-right: 50px;
            margin-bottom: 50px;
            font-family: 'Helvetica', sans-serif;
            font-size: 15px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px 0;
            font-family: 'Helvetica', sans-serif;
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
        .logo {
            float: left;
            margin-left: 10px;
            width: 100px; /* ajustez la largeur du logo selon votre besoin */
            height: auto;
        }
        .title {
            font-size: 20px;
            margin-top: 30px;
        }
        tr {
            text-align: center;
        }
        td,
        th {
            border: 1px solid black;

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
    </style>
</head>
<body>
    <div class="watermark-container">
        <div class="watermark">@if($demande->motif_annuler != "")ANNULE @endif</div>
     <img src="anac.png" class="background" alt="Background Image">
<div><b>REPUBLIQUE DU NIGER</b><br><b style="font-size:10px; margin-left: 20px;">MINISTERE DES TRANSPORTS</b><br> <b style="font-size:10px; margin-left: 35px;">ET DE L'AVIATION CIVILE</b></div>
        <div class="header">
            <img src="anac.png" class="logo" alt="Logo">
            <div class="title"><b>AGENCE NATIONALE DE L'AVIATION CIVILE</b></div>
        </div>
    <div class="content">
    
        <!-- <div style="margin-top: 90px; text-align: left;"><b>ANAC/DG/DTA/DTARE/SSA</b></div> -->
        <div style="margin-top: 70px; 
       margin-left: {{
           ($demande->type_vol_id == 4 && $demande->type_demande_id == 1) ? '170px' : 
           (($demande->type_vol_id == 4 && $demande->type_demande_id == 2) ? '130px' : 
           (($demande->type_demande_id == 1) ? '230px' : 
           (($demande->type_demande_id == 2) ? '170px' : '230px')))
       }};">
            <b><u>AUTORISATION @if($demande->type_vol_id == 4) DIPLOMATIQUE @endif DE {{ strtoupper($demande->type_demande->libelle) }}</u></b>
        </div>
        <div style="margin-top: 30px; text-align: right; position:absolute">@if($autorisation)<img src="qr_code/{{$autorisation->qr_code}}.svg" style="width: 50;" alt="Logo">@endif</div>
        <!-- <div style="margin-top: 50px; text-align: right; font-size:13px;">@if($demande->preciser !== 'VIP') @if($demande->nbre_mois == null)<b>Période : (VALIDE 72 HEURES/ VALID FOR 72 HOURS)</b>@else<b>Période : DU {{\Carbon\Carbon::parse($demande->date_autorisation)->format('d/m/Y')}} au {{\Carbon\Carbon::parse($demande->date_autorisation)->copy()->addMonths(strtoupper($demande->nbre_mois))
            ->format('d/m/Y')}}</b>@endif @else <br> @endif</div> -->
            <div style="margin-top: 20px; margin-left: 230px;">
                @foreach($numeros as $num => $numero)
                    <b>{{$numero}}</b><br>
                @endforeach
            </div>
            <!-- <div style="margin-top: 30px; margin-left: {{ ($demande->nbre_mois == null ) ? '160px' : '280px' }}; font-size:13px;">@if($demande->type_vol_id !== 4) @if($demande->nbre_mois == null)<b>Période : (VALIDE 72 HEURES/ VALID FOR 72 HOURS)</b>@else<b>Période : {{$demande->nbre_mois }} Mois</b>@endif @else <br> @endif</div> -->
            <!-- <div style="margin-top: 30px; margin-left: {{ ($demande->nbre_mois == null ) ? '160px' : '280px' }}; font-size:13px;">@if($demande->type_vol_id !== 4) @if($demande->nbre_mois == null)<b>Période : (VALIDE 72 HEURES/ VALID FOR 72 HOURS)</b>@else<b>Période : DU {{\Carbon\Carbon::parse($demande->date_autorisation)->format('d/m/Y')}} au {{\Carbon\Carbon::parse($demande->date_autorisation)->copy()->addMonths(strtoupper($demande->nbre_mois))->format('d/m/Y')}}</b>@endif @else <br> @endif</div> -->
            <!-- <div style="margin-top: 30px; margin-left: {{ ($demande->nbre_mois == null ) ? '160px' : '280px' }}; font-size:13px;">@if($demande->type_vol_id !== 4) @if($demande->nbre_mois == null)<b>Période : (VALIDE 72 HEURES/ VALID FOR 72 HOURS)</b>@else<b>Période : DU {{\Carbon\Carbon::parse($date_route_debut->date_route)->format('d/m/Y')}} au {{\Carbon\Carbon::parse($date_route_fin->date_route)->format('d/m/Y')}}</b>@endif @else <br> @endif</div> -->
            <div style="margin-top: 30px; margin-left: {{ ($demande->nbre_mois == null ) ? '160px' : '280px' }}; font-size:13px;">@if($demande->type_vol_id !== 4) @if($demande->nbre_mois == null)<b>Période : (VALIDE 72 HEURES/ VALID FOR 72 HOURS)</b>@else<b>Période : DU {{\Carbon\Carbon::parse($date_route_debut->date_route)->format('d/m/Y')}} au {{\Carbon\Carbon::parse($date_route_debut->date_route)->copy()->addMonths(strtoupper($demande->nbre_mois))->format('d/m/Y')}}</b>@endif @else <br> @endif</div>
            <div style="margin-top: 40px;">
            <b>REQUERANT/ APPLICANT : </b>{{strtoupper($demande->user->postulant->nom_raison_sociale)}} <br>
            <b>TYPE AERONEF/ TYPE OF AIRCRAFT :</b> {{strtoupper($aeronef->type)}} <br>
            <b>IMMATRICULATION/ REGISTRATION :</b> {{strtoupper($aeronef->imatriculation)}} <br> 
            <b>INDICATIF/ CALL SIGN : </b> {{strtoupper($aeronef->indicatif_appel)}}<br>
            <b>PROPRIETAIRE/ AIRCRAFT OWNER :</b> {{strtoupper($aeronef->proprietaire_aeronef)}}<br> 
            <b>MOTIF/ PURPOSE :</b> {{strtoupper($demande->type_vol->libelle)}} <br>
            @if($demande->type_vol_id == 4 || $demande->type_vol_id == 5)<b>PRECISER/ PRECISE :</b> {{strtoupper($demande->preciser)}}<br>@endif
        </div>
        <div style="margin-top: 30px;font-size:14px">
            <table style="border-collapse: collapse; width: 100%;" >
            <thead>
                    <tr >
                        <th rowspan="2" style="border: 1px solid ;
                        padding: 7px; width: 120px; "><center>DATE <br>(DD-MM-YYYY)</center></th>
                        <th colspan="2" style="border: 1px solid ;
                        padding: 5px;  "><center>ROUTE (ICAO CODE)</center></th>
                        <th colspan="2" style="border: 1px solid ;
                        padding: 5px;  "><center>TIME <br>(UTC/Z)</center></th>
                    </tr>

                    <tr >
                        <th style="border: 1px solid ;
                        padding: 5px;  ">
                            <div>DEP</div>
                        </th>
                        <th style="border: 1px solid ;
                        padding: 5px;  ">
                            <div>ARR</div>
                        </th>
                        <th style="border: 1px solid ;
                        padding: 5px;  ">
                            <div>ETD</div>
                        </th>
                        <th style="border: 1px solid ;
                        padding: 5px;  ">
                            <div>ETA</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($routes as $route)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($route->date_route)->format('d/m/Y')}}</td>
                        <td>{{$route->ville_depar?->libelle}}</td>
                        <td>{{$route->ville_arive?->libelle}}</td>
                        <td>{{\Carbon\Carbon::parse($route->heure_depart)->isoFormat('HH:mm')}}</td>
                        <td>{{\Carbon\Carbon::parse($route->heure_arrive)->isoFormat('HH:mm')}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- <div style="margin-top: 70px;">
            <b>Mode de paiement des redevances :</b>
        </div> -->
        
        <div style="margin-top:30px; text-align: center; margin-left: 60%; position:absolute; width: 300px;">
            <b>Pour le Directeur Général</b> <br>
            <b>P.D le Directeur du Transport Aérien</b> <br>
        </div>
        <div style="margin-top:30px; text-align: center; margin-left: 10%; position:absolute">
            <b>Délivrée le {{\Carbon\Carbon::parse($demande->date_autorisation)->format('d/m/Y')}}</b>
        </div>
        <div style="margin-top:70px; text-align: center; margin-left: 70%;">
            @if ($signature && $signature->exists())
                <img width="150" src="signatures/dg/{{ $signature->libelle }}" alt=""/><br>
            @endif
            <!-- <b>Mme INSA LEILA</b> -->
        </div>
        

    </div>
    <div style="text-align: center;" class="footer">
            <hr style="border:none;height: 3px; background-color:orange;">
            <div style="margin-left : 350px; width: 8px; height: 8px; background-color: orange; border-radius: 50%;"></div>
            <hr style="border:none;height: 3px; background-color:green;">
            <b style="font-size: 13px;">BP:727 Niamey / Tel : (+227) 20 72 32 67 / Fax : (+227) 20 73 80 56 / Email : anacniger@anac.ne</b>
            <!-- <b style="font-size: 13px;">BP:890 Niamey / Tel : (+227) 20 72 32 67 / Fax : (+227) 20 56 23 12 / Email : anacniger@anac.ne</b> -->
        </div>
        </div>
</body>
</html>
