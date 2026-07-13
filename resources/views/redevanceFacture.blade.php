<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>facture redevance</title>
    <style>
        .header {
            position: fixed;
            top: 30;
            left: 0;
            right: 0;
            height: 0px;
            /* background-color: #f0f0f0; */
            padding: 10px;
            text-align: center;
        }
        .content {
            position: relative;
            z-index: 1; /* Assurez-vous que le contenu est au-dessus de l'arrière-plan */
            margin-left: 50px;
            margin-right: 50px;
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

        .footer {
            position: fixed;
            bottom: 0;
            width: 90%;
            text-align: center;
            padding: 20px 0;
            text-align: center;
        }
        .logo {
            float: left;
            margin-left: 40px;
            width: 100px; /* ajustez la largeur du logo selon votre besoin */
            height: auto;
        }
        .title {
            font-size: 20px;
            margin-top: 10px;
            text-align: center;
        }
        tr {
            text-align: center;
        }
        td,
        th {
            border: 1px solid black;

        }
    </style>
</head>
<body>
     <!-- Image de fond avec opacité 0.2 -->
     <img src="anac.png" class="background" alt="Background Image">

    <div class="content">
        <div style="font-size: 14px;float: left; width: 30%;"><b>Agence Nationale<br>de l'Aviation Civile<br> BP: 727 Niamey</b></div><div class="title"><b>REDEVANCES D'AERODROME</b> </div> <br><br><div class="title" style="font-size: 18px; margin-left:10%"><b> @if ($number!='')FACTURE N° : {{$number}}@endif</b> </div> <br><br>
        <div class="header">
            <img src="anac.png" class="logo" alt="Logo"> <br><br><br><br><b style="font-size: 14px; margin-left:-93%">ANAC-NIGER</b> <br><b style=" font-size: 13px; margin-left:-93%">Agence Comptable</b>
        </div>
        <!-- <div style="font-size: 15px;margin-top: 40px; text-align: left; margin-left:10px"><b>ANAC-NIGER</b></div>
        <div style="font-size: 15px;margin-top: 5px; text-align: left; margin-left:5px">Agence Comptable</div> -->
        @if ($redevance_id!='')
        <div style="font-size: 15px;margin-top: 50px; text-align: left;"><b>Aérodrome:</b> {{$redevences_impayees[0]->aerodrome}}</div>
        <div style=" font-size: 15px;margin-top: 5px; text-align: left;"><b>Exploitant/Représentant de l'aéronef:</b> {{$route->demande->aeronefs[0]->nom_exploitant}}</div>
        <div style=" font-size: 15px;margin-top: 5px; text-align: left;"><b>Nom du Commandant de Bord:</b> {{$route->demande->aeronefs[0]->commandant_bord}}</div>
        <div style=" font-size: 15px;margin-top: 5px;text-align: left;">
            <div style="font-size: 15px; float: left; width: 50%;">
                <b>Type d'Aéronef:</b> {{$route->demande->aeronefs[0]->type}}
            </div>
            <div style="font-size: 15px; float: right; width: 50%; text-align: right;">
                <b>Immatriculation:</b> {{$route->demande->aeronefs[0]->imatriculation}}
            </div>
        </div>
        <div style=" font-size: 15px; margin-top: 5px; text-align: left;"><b>Poids de l'Aéronef(Tonne arrondie):</b> {{$redevences_impayees[0]->poids_aeronef}}</div>
        <!-- <div style="margin-top: 20px;">
             <br> <b>LES REDEVANCES IMPAYEES POUR LA COMPAGNIE: {{ strtoupper($exploitant) }}</b> <br>
        </div> -->
        <div style="margin-top: 20px;">
            <table style="border-collapse: collapse; width: 105%;" >
            <thead >
                <tr>
                <th style="font-size: 15px;" colspan="4"><br> ATTERRISSAGE<br> <br></th>
                    <th style="font-size: 15px;"colspan="4"><br> DECOLLAGE<br> <br></th>
                </tr>
                <tr>
                    <th style="font-size: 14px;">Date <br><br> {{ \Carbon\Carbon::parse($route->date_route)->format('d/m/Y') }}<br><br></th>
                    <th style="font-size: 14px;">Heure<br><br> {{\Carbon\Carbon::parse($route->heure_arrive)->isoFormat('HH:mm')}}<br><br></th>
                    <th style="font-size: 14px;">N° vol<br><br><br><br></th>
                    <th style="font-size: 14px;">Provenance<br><br>{{$route->ville_arive->code_icao}}<br><br></th>
                    <th style="font-size: 14px;">Date <br> <br>{{ \Carbon\Carbon::parse($route->date_route)->format('d/m/Y') }}<br><br></th>
                    <th style="font-size: 14px;">Heure<br> <br>{{\Carbon\Carbon::parse($route->heure_depart)->isoFormat('HH:mm')}}<br><br></th>
                    <th style="font-size: 14px;">N° vol<br><br><br><br></th>
                    <th style="font-size: 14px;">Provenance<br><br>{{$route->ville_depar->code_icao}}<br><br></th>
                </tr>

                <tr>
                    <th style="font-size: 14px;" colspan="5">Décompte de:</th>
                    <th style="font-size: 14px;">Quantité</th>
                    <th style="font-size: 14px;">Taux Redevance</th>
                    <th style="font-size: 14px;">Montant</th>
                </tr>

                </thead>
                <tbody>
                @foreach($frais as $frai)
                    @if ($nbre_passagers_dep_i!=0)
                        @if ($frai->type=='RSAPID')
                            <tr>
                                <td style="font-size: 14px;" colspan="5">{{$frai->libelle}}</td>
                                <td style="font-size: 14px;">{{$nbre_passagers_dep_i}}</td>
                                <td style="font-size: 14px;">{{number_format($frai->montant, 0, '', ' ')}}</td>
                                <td style="font-size: 14px;">{{number_format($nbre_passagers_dep_i*$frai->montant, 0, '', ' ')}}</td>
                            </tr>
                        @endif
                        @if ($frai->type=='RSPID')
                            <tr>
                            <td style="font-size: 14px;" colspan="5">{{$frai->libelle}}</td>
                            <td style="font-size: 14px;">{{$nbre_passagers_dep_i}}</td>
                            <td style="font-size: 14px;">{{number_format($frai->montant, 0, '', ' ')}}</td>
                            <td style="font-size: 14px;">{{number_format($nbre_passagers_dep_i*$frai->montant, 0, '', ' ')}}</td>
                            </tr>
                        @endif
                        @if ($frai->type=='RIT')
                            <tr>
                            <td style="font-size: 14px;" colspan="5">{{$frai->libelle}}</td>
                            <td style="font-size: 14px;">{{$nbre_passagers_dep_i}}</td>
                            <td style="font-size: 14px;">{{number_format($frai->montant, 0, '', ' ')}}</td>
                            <td style="font-size: 14px;">{{number_format($nbre_passagers_dep_i*$frai->montant, 0, '', ' ')}}</td>
                            </tr>
                        @endif
                        @if ($frai->type=='RAVC')
                            <tr>
                            <td style="font-size: 14px;" colspan="5">{{$frai->libelle}}</td>
                            <td style="font-size: 14px;">{{$nbre_passagers_dep_i}}</td>
                            <td style="font-size: 14px;">{{number_format($frai->montant, 0, '', ' ')}}</td>
                            <td style="font-size: 14px;">{{number_format($nbre_passagers_dep_i*$frai->montant, 0, '', ' ')}}</td>
                            </tr>
                        @endif
                    @endif

                     @if ($nbre_passagers_dep_d!=0)
                        @if ($frai->type=='RSAPDD')
                            <tr>
                                <td style="font-size: 14px;" colspan="5">{{$frai->libelle}}</td>
                                <td style="font-size: 14px;">{{$nbre_passagers_dep_d}}</td>
                                <td style="font-size: 14px;">{{number_format($frai->montant, 0, '', ' ')}}</td>
                                <td style="font-size: 14px;">{{number_format($nbre_passagers_dep_d*$frai->montant, 0, '', ' ')}}</td>
                            </tr>
                        @endif
                        @if ($frai->type=='RSPDD')
                            <tr>
                            <td style="font-size: 14px;" colspan="5">{{$frai->libelle}}</td>
                            <td style="font-size: 14px;">{{$nbre_passagers_dep_d}}</td>
                            <td style="font-size: 14px;">{{number_format($frai->montant, 0, '', ' ')}}</td>
                            <td style="font-size: 14px;">{{number_format($nbre_passagers_dep_d*$frai->montant, 0, '', ' ')}}</td>
                            </tr>
                        @endif
                        @if ($frai->type=='RIT')
                            <tr>
                            <td style="font-size: 14px;" colspan="5">{{$frai->libelle}}</td>
                            <td style="font-size: 14px;">{{$nbre_passagers_dep_d}}</td>
                            <td style="font-size: 14px;">{{number_format($frai->montant, 0, '', ' ')}}</td>
                            <td style="font-size: 14px;">{{number_format($nbre_passagers_dep_d*$frai->montant, 0, '', ' ')}}</td>
                            </tr>
                        @endif
                        @if ($frai->type=='RAVC')
                            <tr>
                            <td style="font-size: 14px;" colspan="5">{{$frai->libelle}}</td>
                            <td style="font-size: 14px;">{{$nbre_passagers_dep_d}}</td>
                            <td style="font-size: 14px;">{{number_format($frai->montant, 0, '', ' ')}}</td>
                            <td style="font-size: 14px;">{{number_format($nbre_passagers_dep_d*$frai->montant, 0, '', ' ')}}</td>
                            </tr>
                        @endif
                    @endif

                    @if ($autre_que_marchand_valeur!=0)
                        @if ($frai->type=='RFM')
                            <tr>
                                <td style="font-size: 14px;" colspan="5">{{$frai->libelle}}</td>
                                <td style="font-size: 14px;">{{$autre_que_marchand_valeur}}</td>
                                <td style="font-size: 14px;">{{number_format($frai->montant, 0, '', ' ')}}</td>
                                <td style="font-size: 14px;">{{number_format($autre_que_marchand_valeur*$frai->montant, 0, '', ' ')}}</td>
                            </tr>
                        @endif
                    @endif
                    @if ($marchand_valeur!=0)
                        @if ($frai->type=='RFMV')
                            <tr>
                                <td style="font-size: 14px;" colspan="5">{{$frai->libelle}}</td>
                                <td style="font-size: 14px;">{{$marchand_valeur}}</td>
                                <td style="font-size: 14px;">{{number_format($frai->montant, 0, '', ' ')}}</td>
                                <td style="font-size: 14px;">{{number_format($marchand_valeur*$frai->montant, 0, '', ' ')}}</td>
                            </tr>
                        @endif
                    @endif

                    @if ($nbre_passager_aut_excep!=0)
                        @if ($frai->type=='AETP')
                            <tr>
                                <td style="font-size: 14px;" colspan="5">{{$frai->libelle}}</td>
                                <td style="font-size: 14px;">{{$nbre_passager_aut_excep}}</td>
                                <td style="font-size: 14px;">{{number_format($frai->montant, 0, '', ' ')}}</td>
                                <td style="font-size: 14px;">{{number_format($nbre_passager_aut_excep*$frai->montant, 0, '', ' ')}}</td>
                            </tr>
                        @endif
                    @endif
                    @if ($nbre_fret_aut_excep!=0)
                        @if ($frai->type=='AETFT')
                            <tr>
                                <td style="font-size: 14px;" colspan="5">{{$frai->libelle}}</td>
                                <td style="font-size: 14px;">{{$nbre_fret_aut_excep}}</td>
                                <td style="font-size: 14px;">{{number_format($frai->montant, 0, '', ' ')}}</td>
                                <td style="font-size: 14px;">{{number_format($nbre_fret_aut_excep*$frai->montant, 0, '', ' ')}}</td>
                            </tr>
                        @endif
                    @endif
                    @endforeach     
                    <tr >
                    <td style="font-size: 14px;" colspan="6"><b>TOTAL:</b></td>
                     <td style="font-size: 14px;" colspan="2"><b>{{number_format($total, 0, '', ' ')}} FCFA </b></td>
                    </tr>
                </tbody>
            </table>

            <div style="font-size: 16px; margin-top: 20px;">
                <b>Somme en lettres: {{ asLetters($total) }} franc cfa</b>
            </div>
        <!-- <div style="margin-top: 60px;">
             <br> <b>LES ETATS DES FACTURES POUR LES AUTORISATIONS IMPAYEES :</b> <br>
        </div>
        <div style="margin-top: 5px;">
            <table style="border-collapse: collapse; width: 100%;" >
            <thead style="background-color:darkgreen; color:white">
                    <th>Postulant</th>
                    <th>Télephone</th>
                    <th>Type demande</th>
                    <th>Montant en FCFA</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div> -->

        <div style=" font-size: 15px;margin-top:40px;">
                 <b >L'Agent Chargé de l'Exploitation</b> <b style="margin-left:36%">Le Client Nom et Prénom</b><br>
                <p style=" margin-left:5%">{{Auth::user()->name}}</p>
        </div>
        @else
        <br>
        <div style=" font-size: 15px;margin-top: 50px; text-align: left;"><b>Exploitant/Représentant de l'aéronef:</b> {{ strtoupper($aeronefs->nom_exploitant) }}</div>
        <div style="font-size: 15px;margin-top: 5px; text-align: left;"><b>Email : </b>{{ $aeronefs->email_exploitant }} </div>
        <div style=" font-size: 15px;margin-top: 5px; text-align: left;"><b>Téléphone : </b>{{ $aeronefs->tel_exploitant}} </div>
        <div style="margin-top: 20px;">

        <table style="border-collapse: collapse; width: 105%; font-size: 14px;" >
            <thead >
                    <th style="font-size: 14px;" > Date</th>
                    <th style="font-size: 14px;"> Type Vol</th>
                    <th style="font-size: 14px;"> Autorisation exceptionnelle</th>
                    <th style="font-size: 14px;"> Montant en Fcfa</th>
                </thead>
                <tbody>
                @foreach($redevences_impayees as $impayee)
                        <tr>
                            <td style="font-size: 13px;">{{$impayee->created_at}}</td>
                            @if ($impayee->type_vol=='1')
                                <td style="font-size: 13px;">Vol domestique</td>
                            @else
                                <td style="font-size: 13px;">Vol international</td>
                            @endif
                            @if ($impayee->autorisation_excep=='1')
                                <td style="font-size: 13px;">OUI</td>
                            @else
                                <td style="font-size: 13px;">NON</td>
                            @endif
                            <!-- <td style="font-size: 14px;" ><b>TOTAL:</b></td> -->
                            <td style="font-size: 13px;">{{number_format($impayee->montant, 0, '', ' ')}}</td>
                        </tr>
                    @endforeach
                <tr >

                    <td colspan="3"><b>TOTAL:</b> </td>

                    <td style="font-size: 13px;"><b>{{number_format($montant_impaye, 0, '', ' ')}} FCFA<b></td>
                    </tr>
                </tbody>
            </table>

            <div style="font-size: 16px; margin-top: 20px;">
                <b>Somme en lettres: {{ asLetters($montant_impaye) }} franc cfa</b>
            </div>
        </div>
        <div style="margin-top:63px; text-align: center; margin-left: 75%; font-size: 15px" >
            <b >Pour le Comptable</b> <br>
            @if ($signature && $signature->exists())
                <img width="200"  src="signatures/comptable/{{ $signature->libelle }}" alt=""/><br>
            @endif
            <!-- <b>Mme INSA LEILA</b> -->
        </div>
        @endif
        <!-- <div style="margin-top:73px; text-align: right;">
            <b>L'Agent Chargé de l'Exploitation</b> <br>
            <img width="150" src="signatures/dg/signe.jpg" alt=""/><br>
             <b>Mme INSA LEILA</b>
        </div> -->
        <div style="text-align: center;" class="footer">
            <hr style="border:none;height: 3px; background-color:orange;">
            <div style="margin-left : 350px; width: 8px; height: 8px; background-color: orange; border-radius: 50%;"></div>
            <hr style="border:none;height: 3px; background-color:green;">
            <b style="font-size: 14px;">BP:727 Niamey / Tel : (+227) 20 72 32 67 / Fax : (+227) 20 73 80 56 / Email : anacniger@anac.ne</b>
            <!-- <b style="font-size: 14px;">BP:890 Niamey / Tel : (+227) 20 72 32 67 / Fax : (+227) 20 56 23 12 / Email : anacniger@anac.ne</b> -->
    </div>
    </div>

</body>
</html>
