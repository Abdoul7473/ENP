<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture d'autorisation</title>
    <style>
         .header {
            position: fixed;
            top: 25;
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
            margin-left: 10px;
            margin-right: 50px;
            margin-bottom: 100px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px 0;
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
            margin-left: 5px;
            width: 100px; /* ajustez la largeur du logo selon votre besoin */
            height: auto;
        }
        .title {
            font-size: 19px;
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
    <div style="font-size: 14px;float: left; width: 30%;"><b>Agence Nationale<br>de l'Aviation Civile<br>
    BP: 727 Niamey</b></div>
    <div class="title"> <b> @if ($postulant!=''&& $montant_impaye!=0) FACTURE DES AUTORISATIONS
        @elseif ($postulant==''&& $montant_impaye!=0)LES ETATS DES AUTORISATIONS IMPAYEES
        @elseif ($postulant!=''&& $montant_paye!=0)RECU DES AUTORISATIONS
        @elseif ($postulant==''&& $montant_paye!=0)LES ETATS DES AUTORISATIONS PAYEES @endif </b></div> <br><br><div class="title" style="font-size: 18px; margin-left:10%"><b> @if ($number!='')Facture N° : {{$number}}@endif</b></div> <br><br>
        <div class="header">
            <img src="anac.png" class="logo" alt="Logo"> <br><br><br><br><b style="font-size: 14px; margin-left:-100%">ANAC-NIGER</b> <br><b style=" font-size: 13px; margin-left:-100%">Agence Comptable</b>
        </div>
        @if ($postulant!=''&& $montant_impaye!=0)
        <div style=" font-size:13px;margin-top: 50px; text-align: left;"><b>Nom ou Raison sociale postulant:</b> {{ strtoupper($autorisations_impayees[0]->postulant->nom_raison_sociale) }}</div>
        <div style="font-size:13px;margin-top: 5px; text-align: left;"><b>Email : </b>{{ $autorisations_impayees[0]->demande->user->email }} </div>
        <div style=" font-size:13px;margin-top: 5px; text-align: left;"><b>Téléphone : </b>{{$autorisations_impayees[0]->postulant->tel}}
        </div>
        @elseif($postulant!=''&& $montant_paye!=0)
        <div style=" font-size:13px;margin-top: 50px; text-align: left;"><b>Nom ou Raison sociale postulant:</b> {{ strtoupper($autorisations_payees[0]->postulant->nom_raison_sociale) }}</div>
        <div style="font-size:13px;margin-top: 5px; text-align: left;"><b>Email : </b>{{ $autorisations_payees[0]->demande->user->email }} </div>
        <div style=" font-size:13px;margin-top: 5px; text-align: left;"><b>Téléphone : </b>{{ $autorisations_payees[0]->postulant->tel}} </div>@else
        <div style="font-size:13px;margin-top: 50px; text-align: left;"></div>
        @endif
        <!-- <div><b>REPUBLIQUE DU NIGER</b><br><b style="font-size:10px; margin-left: 20px;">MINISTERE DES TRANSPORTS</b><br> <b style="font-size:10px; margin-left: 35px;">ET DE L'EQUIPEMENT</b></div>
        <div class="header">
            <img src="anac.png" class="logo" alt="Logo">
            <div class="title"><b>AGENCE NATIONALE DE L'AVIATION CIVILE</b></div>
        </div>
            <div style="margin-top: 90px; text-align: left; margin-left:40px"><b>ANAC-NIGER</b></div>
            <div style="margin-top: 5px; text-align: left; margin-left:30px"><b>Agence Comptable</b></div> -->
        @if ($montant_paye!=0)
            <!-- @if ($postulant!='')
                <div style="margin-top: 40px; text-align:center;">
                    <br> <b> RECU DES AUTORISATIONS POUR {{ strtoupper($autorisations_payees[0]->postulant->nom_raison_sociale) }}</b> <br>
                </div>
            @else
                <div style="margin-top: 20px;">
                    <br> <b>LES ETATS DES AUTORISATIONS PAYEES </b> <br>
                </div>
            @endif -->
        <div style="margin-top: 20px;">
            <table style="border-collapse: collapse; width: 100%; font-size: 10px;" >
                <thead style="background-color:darkgreen; color:white">
                    @if ($postulant=='')
                    <th style="text-align:center;">Postulant</th>
                    @endif
                    <th style="text-align:center;">Exploitant</th>
                    <th style="text-align:center;">Commandant de bord</th>
                    <th style="text-align:center;">Date d'autorisation</th>
                    <th style="text-align:center;">Date prévu vol</th>
                    <th style="text-align:center;">Type Aéronef</th>
                    <th style="text-align:center;">Immatriculation</th>
                    <th style="text-align:center;">Type demande</th>
                    <th style="text-align:center;">Numéros d'autorisation</th>
                    <th style="text-align:center;">Montant en FCFA</th>
                </thead>
                <tbody>
                @foreach($auto_payees as $payees)
                    @if(isset($payees[0]) && $payees[0] instanceof \App\Models\Order)
                    @php
                        $order = $payees[0];
                    @endphp
                    <tr style="font-size: 9px">
                    @if ($postulant=='')
                    <td >{{$order->postulant->nom_raison_sociale}}</td>
                    @endif
                    <td >{{$order->demande->aeronefs[0]->nom_exploitant}}</td>
                    <td >{{$order->demande->aeronefs[0]->commandant_bord}}</td>
                    <td >{{ \Carbon\Carbon::parse($order->demande->date_autorisation)->locale('fr')->translatedFormat('j F Y') }}</td>
                    <td >{{ \Carbon\Carbon::parse($order->demande->date_prevu_vol)->locale('fr')->translatedFormat('j F Y') }}</td>
                    <td >{{$order->demande->aeronefs[0]->type}}</td>
                    <td >{{$order->demande->aeronefs[0]->imatriculation}}</td>
                    <td >{{$order->demande->type_demande->libelle}}</td>
                    <td >  @if(isset($payees['numero']))
                            @foreach($payees['numero'] as $numero) 
                        {{$numero}}<br> @endforeach @endif</td>
                    <td >{{number_format($order->prix_total, 0, '', ' ')}}</td>
                    </tr>
                    @endif
                @endforeach
                    <tr >
                    @if ($postulant=='')
                    <td colspan="8"><b>TOTAL:</b> </td>
                    @else
                    <td colspan="7"><b>TOTAL:</b> </td>
                    @endif
                    <td  colspan="2"><b>{{number_format($montant_paye, 0, '', ' ')}} FCFA</b> </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
        @if ($montant_impaye!=0)
            <!-- @if ($postulant!='')
            <div style="margin-top: 60px; text-align:center;">
                <br> </b> <br>
            </div>
            @else
            <div style="margin-top: 20px;">
                <br> <b>LES ETATS DES FACTURES POUR LES AUTORISATIONS IMPAYEES </b> <br>
            </div>
            @endif -->
        <div style="margin-top: 20px;">
            <table style="border-collapse: collapse; width: 100%; font-size: 10px;" >
            <thead style="background-color:darkgreen; color:white">
                    @if ($postulant=='')
                    <th style="text-align:center;">Postulant</th>
                    @endif
                    <th style="text-align:center;">Exploitant</th>
                    <th style="text-align:center;">Commandant de bord</th>
                    <th style="text-align:center;">Date d'autorisation</th>
                    <th style="text-align:center;">Date prévu vol</th>
                    <th style="text-align:center;">Type Aéronef</th>
                    <th style="text-align:center;">Immatriculation</th>
                    <th style="text-align:center;">Type demande</th>
                    <th style="text-align:center;">Numéros d'autorisation</th>
                    <th style="text-align:center;">Montant en FCFA</th>
                </thead>


                <tbody>
                @foreach($auto_impayees as $impayees)
                    @if(isset($impayees[0]) && $impayees[0] instanceof \App\Models\Order)
                    @php
                        $order = $impayees[0];
                    @endphp
                    <tr style="font-size: 9px">
                    @if ($postulant=='')
                    <td >{{$order->postulant->nom_raison_sociale}}</td>
                    @endif
                    <td >{{$order->demande->aeronefs[0]->nom_exploitant}}</td>
                    <td >{{$order->demande->aeronefs[0]->commandant_bord}}</td>
                    <td >{{ \Carbon\Carbon::parse($order->demande->date_autorisation)->locale('fr')->translatedFormat('j F Y') }}</td>
                    <td >{{ \Carbon\Carbon::parse($order->demande->date_prevu_vol)->locale('fr')->translatedFormat('j F Y') }}</td>
                    <td >{{$order->demande->aeronefs[0]->type}}</td>
                    <td >{{$order->demande->aeronefs[0]->imatriculation}}</td>
                    <td >{{$order->demande->type_demande->libelle}}</td>
                    <td >  @if(isset($impayees['numero']))
                            @foreach($impayees['numero'] as $numero) 
                        {{$numero}}<br> @endforeach @endif</td>
                    <td >{{number_format($order->prix_total, 0, '', ' ')}}</td>
                    </tr>
                    @endif
                @endforeach
                <tr >
                    @if ($postulant=='')
                    <td colspan="8"><b>TOTAL:</b> </td>
                    @else
                    <td colspan="7"><b>TOTAL:</b> </td>
                    @endif
                    <td  colspan="2"><b>{{number_format($montant_impaye, 0, '', ' ')}} FCFA<b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
        <div style="margin-top:63px; text-align: center; margin-left: 75%; font-size: 15px" >
            <b >Pour le Comptable</b> <br>
            @if ($signature && $signature->exists())
                <img width="200"  src="signatures/comptable/{{ $signature->libelle }}" alt=""/><br>
            @endif
            <!-- <b>Mme INSA LEILA</b> -->
        </div>
        <div style="text-align: center; font-size: 15px; " class="footer" >
            <hr style="border:none;height: 3px; background-color:orange;">
            <!-- <div style="margin-left : 350px; width: 8px; height: 8px; background-color: orange; border-radius: 50%;"></div> -->
            <hr style="border:none;height: 3px; background-color:green;">
            <b style="font-size: 13px;">BP:727 Niamey / Tel : (+227) 20 72 32 67 / Fax : (+227) 20 73 80 56 / Email : anacniger@anac.ne</b>
            <!-- <b style="font-size: 13px;">BP:890 Niamey / Tel : (+227) 20 72 32 67 / Fax : (+227) 20 56 23 12 / Email : anacniger@anac.ne</b> -->
        </div>
    </div>
</body>
</html>
