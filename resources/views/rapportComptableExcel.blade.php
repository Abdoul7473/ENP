<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>liste des factures</title>
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

    <div class="content">
        <table style="border-collapse: collapse; width: 105%;" >
            <tbody>
            <tr style="background-color:darkgreen; color:white">
                @if ($postulant!='')
                    <td style="text-align:center;font-size: 14px;" colspan="6"><b>REPUBLIQUE DU NIGER</b></td>
                @else
                    <td style="text-align:center;font-size: 14px;" colspan="7"><b>REPUBLIQUE DU NIGER</b></td>
                @endif
            </tr>
            <tr style="background-color:darkgreen; color:white">
                @if ($postulant!='')
                    <td style="text-align:center;font-size: 14px;" colspan="6"><b>MINISTERE DES TRANSPORTS ET DE L'AVIATION CIVILE</b></td>
                @else
                    <td style="text-align:center;font-size: 14px;" colspan="7"><b>MINISTERE DES TRANSPORTS ET DE L'AVIATION CIVILE</b></td>
                @endif
            </tr>
            <tr style="background-color:darkgreen; color:white">
                @if ($postulant!='')
                    <td style="text-align:center; font-size: 14px;" colspan="6"><b>AGENCE NATIONALE DE L'AVIATION CIVILE</b></td>
                @else
                    <td style="text-align:center;font-size: 14px;" colspan="7"><b>AGENCE NATIONALE DE L'AVIATION CIVILE</b></td>
                @endif
            </tr>
            <tr style="background-color:darkgreen; color:white">
                @if ($postulant!='')
                <tr style="background-color:darkgreen; color:white">
                    <td style="text-align:center;font-size: 13px;" colspan="6"><b>ANAC-NIGER</b></td>
                </tr>
                <tr style="background-color:darkgreen; color:white">
                    <td style="text-align:center;font-size: 13px;" colspan="6"><b>Agence Comptable</b></td>
                </tr>
                @else
                <tr style="background-color:darkgreen; color:white">
                    <td style="text-align:center;font-size: 13px;" colspan="7"><b>ANAC-NIGER</b></td>
                </tr>
                <tr style="background-color:darkgreen; color:white">
                    <td style="text-align:center;font-size: 13px;" colspan="7"><b>Agence Comptable</b></td>
                </tr>
                @endif           
            </tbody>
        </table>

        @if ($montant_paye!=0)
        <div style="margin-top: 10px;">
            <table style="border-collapse: collapse; width: 105%;" >
                <tbody>
                    @if ($postulant!='')
                    <tr style="background-color:darkgreen; color:white">
                        <td style="text-align:center; font-size: 14px;" colspan="6"> <b>AUTORISATIONS PAYEES</b></td>
                    </tr>
                    <tr style="background-color:darkgreen; color:white">
                        <td style=" text-align: left;font-size: 13px;" colspan="6"><b>Nom ou Raison sociale postulant:</b> {{ strtoupper($autorisations_payees[0]->postulant->nom_raison_sociale) }}</td>
                    </tr>
                    <tr style="background-color:darkgreen; color:white">
                        <td style=" text-align: left;font-size: 13px;" colspan="6"><b>Email : </b>{{ $autorisations_payees[0]->demande->user->email }} </td>
                    </tr>
                    <tr style="background-color:darkgreen; color:white">   
                        <td style=" text-align: left;font-size: 13px;" colspan="6"><b>Téléphone : </b>{{ $autorisations_payees[0]->postulant->tel}} </td>
                    </tr>
                    @else
                    <tr style="background-color:darkgreen; color:white">
                    <td style="text-align:center;font-size: 14px;" colspan="7"><b>LES ETATS DES AUTORISATIONS PAYEES :</b></td>
                    </tr>
                    @endif
                
                </tbody>
            </table>
                <br>
        </div>
        <div style="margin-top: 5px;">
            <table style="border-collapse: collapse; width: 105%;" >
                <tbody>
                <tr style="background-color:darkgreen; color:white">
                    @if ($postulant!='')
                    <td style="text-align:center;font-size: 13px;"><b>Nom postulant</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Email postulant</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Téléphone postulant</b></td>
                    @endif
                    <!-- -->
                    <td style="text-align:center;font-size: 13px;"><b>Nom exploitant</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Email exploitant</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Téléphone exploitant</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Propriétaire d'aéronef</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Commandant de bord</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>date d'autorisation</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Date prévu vol</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Type Aéronef</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Immatriculation</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Type demande</b></td>
                    <td style="font-size: 13px; text-align:center;"><b>Numéros d'autorisation</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Montant en FCFA</b></td>
                </tr>
                @foreach($auto_payees as $orderData)
                @if(isset($orderData[0]) && $orderData[0] instanceof \App\Models\Order)
                    @php
                        $order = $orderData[0];
                    @endphp
                    <tr>
                    @if ($postulant=='')
                    <td style="text-align:center;">{{$order->postulant->nom_raison_sociale}}</td>
                    <td style="text-align:center;">{{$order->demande->user->email}}</td>
                    <td style="text-align:center;">{{$order->postulant->tel}}</td>
                    @endif
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->nom_exploitant}}</td>
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->email_exploitant}}</td>
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->tel_exploitant}}</td>
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->proprietaire_aeronef}}</td>
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->commandant_bord}}</td>
                    <td style="text-align:center;">{{ \Carbon\Carbon::parse($order->demande->date_autorisation)->locale('fr')->translatedFormat('j F Y') }}</td>
                    <td style="text-align:center;">{{ \Carbon\Carbon::parse($order->demande->date_prevu_vol)->locale('fr')->translatedFormat('j F Y') }}</td>
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->type}}</td>
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->imatriculation}}</td>
                    <td style="text-align:center;">{{$order->demande->type_demande->libelle}}</td>
                    <td style="text-align:center;"> 
                        
                    @if(isset($orderData['numero']))
                        @foreach($orderData['numero'] as $numero)
                            <br>{{ $numero }}
                        @endforeach
                    @endif
                            
                    </td>
                    <td style="text-align:center;">{{number_format($order->prix_total, 0, '', ' ')}}</td>
                    </tr>
                @endif
            @endforeach
                    <tr >
                    @if ($postulant!='')
                    <td style="text-align:center;font-size: 13px;"colspan="11" ><b>TOTAL:</b></td>
                    @else
                    <td style="text-align:center;font-size: 13px;"colspan="14" ><b>TOTAL:</b></td>
                    @endif
                     <td style="text-align:center;"><b>{{number_format($montant_paye, 0, '', ' ')}} FCFA </b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
        @if ($montant_impaye!=0)
        <div style="margin-top: 60px;">
        <table style="border-collapse: collapse; width: 105%;" >
                <tbody>
                    @if ($postulant!='')
                        <tr style="background-color:darkgreen; color:white">
                            <td style="text-align:center; font-size: 14px;" colspan="7"> <b> AUTORISATIONS IMPAYEES </b></td>
                        </tr>
                        <tr style="background-color:darkgreen; color:white">
                            <td style=" text-align: left;font-size: 13px;"><b>Nom ou Raison sociale postulant:</b> {{ strtoupper($autorisations_impayees[0]->postulant->nom_raison_sociale) }}</td>
                        </tr>
                        <tr style="background-color:darkgreen; color:white">
                            <td style=" text-align: left;font-size: 13px;"><b>Email : </b>{{ $autorisations_impayees[0]->demande->user->email }} </td>
                        </tr>
                        <tr style="background-color:darkgreen; color:white">   
                            <td style=" text-align: left;font-size: 13px;"><b>Téléphone : </b>{{$autorisations_impayees[0]->postulant->tel}}</td>
                        </tr>
                    @else
                        <tr style="background-color:darkgreen; color:white">
                            <td style="text-align:center;font-size: 14px;" colspan="8"><b>LES ETATS DES AUTORISATIONS IMPAYEES :</b></td>
                        </tr>
                    @endif
                

                </tbody>
            </table>
        </div>
        <div style="margin-top: 5px;">
            <table style="border-collapse: collapse; width: 105%;" >
                <tbody>
                <b>
                <tr style="background-color:darkgreen; color:white">
                    @if ($postulant=='')
                    <td style="text-align:center;font-size: 13px;"><b>Nom postulant</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Email postulant</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Téléphone postulant</b></td>
                    @endif
                    <td style="text-align:center;font-size: 13px;"><b>Nom exploitant</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Email exploitant</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Téléphone exploitant</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Propriétaire d'aéronef</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Commandant de bord</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>date d'autorisation</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Date prévu vol</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Type Aéronef</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Immatriculation</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Type demande</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Numéros d'autorisation</b></td>
                    <td style="text-align:center;font-size: 13px;"><b>Montant en FCFA</b></td>
                </tr>
                </b>
                <!-- @foreach($auto_impayees as $orderData)
                    @if(isset($orderData[0]) && $orderData[0] instanceof \App\Models\Order)
                        @php
                            $order = $orderData[0];
                        @endphp

                        <div>
                            <h2>Commande {{ $loop->iteration }}</h2>
                            <p>Nom/Raison Sociale: {{ $order->postulant->nom_raison_sociale }}</p>
                            <p>Prix Total: {{ $order->prix_total }}</p>
                        </div>
                    @endif

                    @if(isset($orderData['numero']))
                        <div>
                            <h3>Numéros associés</h3>
                            <ul>
                                @foreach($orderData['numero'] as $numero)
                                    <li>{{ $numero }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach -->


            @foreach($auto_impayees as $orderData)
                @if(isset($orderData[0]) && $orderData[0] instanceof \App\Models\Order)
                    @php
                        $order = $orderData[0];
                    @endphp
                    <tr>
                    @if ($postulant=='')
                    <td style="text-align:center;">{{$order->postulant->nom_raison_sociale}}</td>
                    <td style="text-align:center;">{{$order->demande->user ? $order->demande->user->email : ''}}</td>
                    <td style="text-align:center;">{{$order->postulant->tel}}</td>
                    @endif
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->nom_exploitant}}</td>
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->email_exploitant}}</td>
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->tel_exploitant}}</td>
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->proprietaire_aeronef}}</td>
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->commandant_bord}}</td>
                    <td style="text-align:center;">{{ \Carbon\Carbon::parse($order->demande->date_autorisation)->locale('fr')->translatedFormat('j F Y') }}</td>
                    <td style="text-align:center;">{{ \Carbon\Carbon::parse($order->demande->date_prevu_vol)->locale('fr')->translatedFormat('j F Y') }}</td>
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->type}}</td>
                    <td style="text-align:center;">{{$order->demande->aeronefs[0]->imatriculation}}</td>
                    <td style="text-align:center;">{{$order->demande->type_demande->libelle}}</td>
                    <td style="text-align:center;"> 
                        
                    @if(isset($orderData['numero']))
                        @foreach($orderData['numero'] as $numero)
                            <br>{{ $numero }}
                        @endforeach
                    @endif
                            
                    </td>
                    <td style="text-align:center;">{{number_format($order->prix_total, 0, '', ' ')}}</td>
                    </tr>
                @endif
            @endforeach
                <tr >
                    @if ($postulant!='')
                    <td style="text-align:center;font-size: 13px;"colspan="11" ><b>TOTAL:</b></td>
                    @else
                    <td style="text-align:center;font-size: 13px;"colspan="14" ><b>TOTAL:</b></td>
                    @endif
                     <td style="text-align:center;"><b>{{number_format($montant_impaye, 0, '', ' ')}} FCFA </b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
    </div>
</body>
</html>
