<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche de demande</title>
    <style>
        .header {
            position: fixed;
            top: 20;
            left: 20;
            right: 0;
            height: 5px;
            /* background-color: #f0f0f0; */
            padding: 10px;
            text-align: center;
        }
        .content {
            position: relative;
            z-index: 1; /* Assurez-vous que le contenu est au-dessus de l'arrière-plan */
            margin-left: 50px;
            margin-right: 50px;
            margin-bottom: 100px;
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
            margin-left: 50px;
            width: 100px; /* ajustez la largeur du logo selon votre besoin */
            height: auto;
        }
        .title {
            font-size: 20px;
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            font-size: 15px;
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            max-width: 100px; /* Limite la largeur des colonnes */
        }
        td {
            font-size: 12px;
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            max-width: 100px; /* Limite la largeur des colonnes */
            word-wrap: break-word; /* Permet le retour à la ligne */
            word-break: break-all; /* Permet de couper les mots s'ils sont trop longs */
        }
        @media print {
            table {
                page-break-inside: avoid;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }

        .footer {
            position: fixed;
            bottom: 0;
            /* width: 100%; */
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>
     <!-- Image de fond avec opacité 0.2 -->
     <img src="anac.png" class="background" alt="Background Image">

    <div class="content">
        <div><b>REPUBLIQUE DU NIGER</b><br><b style="font-size:10px; margin-left: 20px;">MINISTERE DES TRANSPORTS</b><br> <b style="font-size:10px; margin-left: 35px;">ET DE L'AVIATION CIVILE</b></div>
        <div class="header">
            <img src="anac.png" class="logo" alt="Logo">
            <div class="title"><b>AGENCE NATIONALE DE L'AVIATION CIVILE</b></div>
        </div>
        <div style="margin-top: 90px; text-align: left;"></div><br>
        <div style="margin-left: 10%;">
    <u><b>DEMANDE D’AUTORISATION DE SURVOL ET/OU D’ATTERRISSAGE</b></u>
    </div>
    <br>
    <u ><b>1. Nature de la demande</b> </u>
    <br>
    <br>
    <div style="position: relative;">
        <div style="display: flex;align-items: right;">
            <input type="checkbox" id="survol" name="survol" value="'{{$demande->type_demande->libelle}}'" checked >
            <label style="position: absolute; " for="survol">{{$demande->type_demande->libelle}}
                </label>
        </div>
    </div>
        <br>
        <u><b>2. Type et immatriculation de l'aéronef</b></u>
        <div style="margin-top: 30px; margin-left:-10%">
            <table style="border-collapse: collapse;" >
            <thead>
                    <th >Type</th>
                    <th >Immatriculation</th>
                    <th >Indicatif d'appel</th>
                    <th >Proprietaire </th>
                    <th >Nom Exploitant</th>
                    <th >Telephone Exploitant</th>
                    <th >E-mail Exploitant</th>
                    <th >Commandant de bord</th>
            </thead>
                <tbody>
                @foreach($demande->aeronefs as $aeronef)
                <tr>
                    <td  >{{$aeronef->type}}</td>
                    <td >{{$aeronef->imatriculation}}</td>
                    <td >{{$aeronef->indicatif_appel}} </td>
                    <td  >{{$aeronef->proprietaire_aeronef}}</td>
                    <td >{{$aeronef->nom_exploitant}}</td>
                    <td >{{$aeronef->tel_exploitant}} </td>
                    <td  >{{$aeronef->email_exploitant}}</td>
                    <td >{{$aeronef->commandant_bord}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <br>
       <u> <b>3. Itinéraire du/des vol(s) avec dates et heures en Temps Universel (TU)</b></u>

       <div style="margin-top: 30px;">
            <table style="border-collapse: collapse; width: 122%;margin-left:-10%;" >
                <thead>
                    <tr >
                        <th rowspan="2" style="border: 1px solid ;
                        padding: 7px;  "><center>DATE <br>(YYYY-MM-DD)</center></th>
                        <th colspan="2" style="border: 1px solid ;
                        padding: 7px;  "><center>ROUTE (ICAO CODE)</center></th>
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
                     @foreach($routes as $route)
                        <tr>
                            <td style="border: 1px solid ;
                            padding: 7px;  "><center>{{ \Carbon\Carbon::parse($route->date_route)->format('d/m/Y')}}</center></td>
                            <td style="border: 1px solid ;
                            padding: 7px;  "><center>{{$route->ville_depar->libelle}} </center></td>
                            <td style="border: 1px solid ;
                            padding: 7px;  "><center>{{$route->ville_arive->libelle}}</center></td>
                            <td style="border: 1px solid ;
                            padding: 7px;  "><center>{{\Carbon\Carbon::parse($route->heure_depart)->isoFormat('HH:mm')}} </center></td>
                            <td style="border: 1px solid ;
                            padding: 7px;  "><center>{{\Carbon\Carbon::parse($route->heure_arrive)->isoFormat('HH:mm')}} </center></td>
                            <td style="border: 1px solid ;
                            padding: 7px;  ">  @if($route->remarque != '')<center>{{$route->remarque}} </center></td>
                                @else
                                <p>RAS </p>
                                @endif
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <br>
        <u><b>4. Motif du vol</b></u>
    <br>
    <br>
    <div style="position: relative;">
            <input  type="checkbox"  value="'{{$demande->type_vol->libelle}}'" checked>
            <label style="position: absolute; " > {{$demande->type_vol->libelle}} </label>
    </div>
    &nbsp; &nbsp;
        @if($demande->type_vol->libelle == 'Autre')
            Précision: {{$demande->preciser}}
            @else

            @endif <br>


           <u><b> 5. Identité complète de la personne (physique ou morale) qui soumet la demande
           de survol/atterrissage :</b></u>

        <div style="margin-top:2%">
            <b> Nom Prénom ou Nom de la societé</b> : {{$demande->user->postulant->nom_raison_sociale}} <br>

            <b>Adresse</b>: {{$demande->user->postulant->adresse}} <br>
            <b>E-mail</b>  : {{$demande->user->email}}<br>
            <b>Telephones</b> &nbsp;:@if($demande->user->postulant->tel2)
            {{$demande->user->postulant->tel}}/{{$demande->user->postulant->tel2}}
            @else
            {{$demande->user->postulant->tel}}
            @endif
             <br>
        </div>
        <!-- <div style="margin-top: 70px;">
            <b>Mode de paiement des redevances :</b>
        </div> -->
        <div>
            <p><b>NB : Je certifie sur l'honneur être autorisé(e) par l'exploitant à remplir ce formulaire et
            déclare formellement que les informations qui y figurent sont exactes et
            complètes et que l'aéronef dispose de tous les documents réglementaires à
            jour.</b></p>
            <p><b>I hereby declare to be authorized by the operator to fill in this form and this
            informations are exact and complete and that the aircraft has all up-to-date regulatory
            documents.</b></p>
        </div>
        <div style="margin-top:73px;">
             <p>Fait à {{$demande->ville_fait}}, le {{  \Carbon\Carbon::parse($demande->date_demande)->locale('fr_FR')->isoFormat('LL') }}</p>
        </div>
        <div style=" text-align: center; margin-left: 75%;">
            <b>Signature et Cachet</b> <br>
            <img width="200"  src="signatures/postulant/{{$demande->user->postulant->signature_cachet}}" alt=""/>
            <!-- <b>Mme INSA LEILA</b> -->
        </div>

        <div style="text-align: center;" class="footer">
            <hr style="border:none;height: 3px; background-color:orange;">
            <div style="margin-left : 300px; width: 8px; height: 8px; background-color: orange; border-radius: 50%;"></div>
            <hr style="border:none;height: 3px; background-color:green;">
            <b style="font-size: 13px;">BP:727 Niamey / Tel : (+227) 20 72 32 67 / Fax : (+227) 20 73 80 56 / Email : anacniger@anac.ne</b>
            <!-- <b style="font-size: 13px;">BP:890 Niamey / Tel : (+227) 20 72 32 67 / Fax : (+227) 20 56 23 12 / Email : anacniger@anac.ne</b> -->
        </div>
    </div>
</body>
</html>
