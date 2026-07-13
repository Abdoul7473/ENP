<!DOCTYPE html>
<html>
<head>
    <style>
        /* Ajoutez vos styles CSS ici */
        
        @page {
            size: landscape;
        }
        table {
            border-collapse: collapse;
            border: 2px solid rgb(200,200,200);
            letter-spacing: 1px;
            font-size: 0.8rem;
        }

        th {
            font-size: 15px;
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            max-width: 100px; 
        }

        td {
            font-size: 12px;
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            max-width: 100px; /* Limite la largeur des colonnes */
            word-wrap: break-word; /* Permet le retour à la ligne */
            word-break: break-all;
        }

        caption {
        padding: 10px;
        }
    </style>
</head>
<body>
<h2 style="color: blue;margin-left:8%; " colspan="18" >&nbsp;{{ $data->item->data->item->libelle }} ({{ \Carbon\Carbon::parse($data->item->data->date[0])->locale('fr')->isoFormat('dddd, D MMMM YYYY') }} - {{ \Carbon\Carbon::parse($data->item->data->date[1])->locale('fr')->isoFormat('dddd, D MMMM YYYY') }})</h2>
    <table style="border: 2px solid ;padding: 7px; border-collapse: collapse; width: 105%;margin-left:-3%;">
        <tbody>
        <td style="text-align:center;" colspan="21"><h2 style="text-align:center;">&nbsp; NB: Dans la case routes, vous avez code (Aéroport de depart - Aéroport d'arrivé)</h2></td>
        </tbody>
    </table>
<table style="border: 2px solid ;padding: 7px; border-collapse: collapse; width: 105%;margin-left:-3%;">
    <thead>
    <tr>
        <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">Date d'autorisation</th>
        <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">Montant total</th>
        <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">Nombre de route</th>
        <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">Type d'autorisation</th>
        <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">Immatriculation</th>
        <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">Indicatif d'appel</th>
        <th colspan="8" style="border: 1px solid ;padding: 7px; text-align:center; ">Postulant</th>
        <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">Date de vol</th>
        <th colspan="8" style="border: 1px solid ;padding: 7px; text-align:center; ">Routes</th>
        <th colspan="8" style="border: 1px solid ;padding: 7px; text-align:center; ">Numeros d'autorisation</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data->resultat as $item)
        @if(isset($item))
            <tr>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">{{ $item->date_autorisation ? \Carbon\Carbon::parse($item->date_autorisation)->locale('fr')->isoFormat('D MMMM YYYY') : '' }}</td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">{{ $item->montant_total ? number_format($item->montant_total, 0, '', ' ') : '' }}</td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">{{ $item->nombre_route ? $item->nombre_route : '' }}</td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">{{ $item->type_autorisation ? $item->type_autorisation->libelle : '' }}</td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">{{ $item->num_autorisations[0] ? $item->num_autorisations[0]->route->demande->aeronefs[0]->imatriculation : ''}}</td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">{{ $item->num_autorisations[0] ? $item->num_autorisations[0]->route->demande->aeronefs[0]->indicatif_appel : '' }}</td>
                <td colspan="8" style="border: 1px solid ;padding: 7px; text-align:center; ">{{ $item->num_autorisations[0] ? $item->num_autorisations[0]->route->demande->user->postulant->nom_raison_sociale : ''}}</td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">{{ $item->num_autorisations[0] ? \Carbon\Carbon::parse($item->num_autorisations[0]->route->demande->date_prevu_vol)->locale('fr')->isoFormat('D MMMM YYYY') : ''}}</td>
                <td colspan="8" style="border: 1px solid ;padding: 7px; text-align:center; ">
                @foreach($item->num_autorisations as $index => $num)
                    <li>{{ $num->route->ville_depar? $num->route->ville_depar->libelle : '' }} - {{ $num->route->ville_arive ? $num->route->ville_arive->libelle : '' }} </li> 
                    @if($index < count($item->num_autorisations) - 1)
                        <br>
                    @endif
                @endforeach
                </td>
                <td colspan="8" style="border: 1px solid ;padding: 7px; text-align:center; ">
                @foreach($item->nums as $index => $num)
                    <li>{{ $num->num }} </li> 
                    <!-- @if($index < count($item->nums) - 1)
                        <br>
                    @endif -->
                @endforeach
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>

</body>
</html>
