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
        .watermark-container {
            position: relative;
            width: 100%;
            height: 400px; /* Ajustez la hauteur selon vos besoins */
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 48px; /* Ajustez la taille de la police selon vos besoins */
            color: red; /* La transparence du filigrane */
            white-space: nowrap; /* Évite les retours à la ligne */
            pointer-events: none; /* Évite les interactions avec le filigrane */
        }
    </style>
</head>
<body>
<!-- <div class="watermark-container">
        <div class="watermark">ANNULER</div> -->
        <!-- <p>Votre contenu principal ici.</p>
        <p>Encore du contenu principal ici.</p> -->
    
<h2 style="color: blue;margin-left:8%; " colspan="18" >&nbsp;{{ $data->item->data->item->libelle }} ({{ \Carbon\Carbon::parse($data->item->data->date[0])->locale('fr')->isoFormat('dddd, D MMMM YYYY') }} - {{ \Carbon\Carbon::parse($data->item->data->date[1])->locale('fr')->isoFormat('dddd, D MMMM YYYY') }})</h2>
    <table style="border: 2px solid ;padding: 7px; border-collapse: collapse; width: 105%;margin-left:-3%;">
        <tbody>
        <td style="text-align:center;" colspan="21"><h2 style="text-align:center;">&nbsp; NB: Dans la case routes, vous avez code (Aéroport de depart - Aéroport d'arrivé)</h2></td>
        </tbody>
    </table>
<table style="border: 2px solid ;padding: 7px; border-collapse: collapse; width: 105%;margin-left:-3%;" >
    <thead>
    <tr style="background-color: green;">
        <th  style="border: 1px solid ;padding: 7px; text-align:center; " colspan="2">Date de demande</th>
        <th  style="border: 1px solid ;padding: 7px; text-align:center; "colspan="2">Date du vol</th>
        <th  style="border: 1px solid ;padding: 7px; text-align:center; "colspan="2">Type demande</th>
        <th  style="border: 1px solid ;padding: 7px; text-align:center; " colspan="2">Motif de vol</th>
        <th  style="border: 1px solid ;padding: 7px; text-align:center; "colspan="2">Postulant</th>
        <th  style="border: 1px solid ;padding: 7px; text-align:center; "colspan="2">Immatriculation</th>
        <th  style="border: 1px solid ;padding: 7px; text-align:center; " colspan="2">Indicatif d'appel</th>
        <th  style="border: 1px solid ;padding: 7px; text-align:center; " colspan="2">Nature de demande</th>
        <th  style="border: 1px solid ;padding: 7px; text-align:center; " colspan="2">Statut</th>
        <!-- <th  style="border: 1px solid ;padding: 7px; text-align:center; " colspan="2">Statut</th> -->
        <th  style="border: 1px solid ;padding: 7px; text-align:center; " colspan="5">Les routes</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data->resultat as $item)
        <tr>
            <td  colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">{{\Carbon\Carbon::parse($item->date_demande)->locale('fr')->isoFormat('D MMMM YYYY') }}</td>
            <td  colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">{{\Carbon\Carbon::parse($item->date_prevu_vol)->locale('fr')->isoFormat('D MMMM YYYY') }}</td>
            <td  colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">@if( $item->type_demande_id == 2) Survol/Atterrissage @else Survol @endif </td>
            <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; " > @if ($item->type_vol_id == 4){{ $item->preciser }}@else {{$item->type_vol ? $item->type_vol->libelle : ''}}@endif</td>
            <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; " >{{ $item->user->postulant->nom_raison_sociale }}</td>
            <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; " >
                @foreach($item->aeronefs as $index => $aeronef)
                    {{ $aeronef->imatriculation }}
                @endforeach
            </td>
            <td  colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">
                @foreach($item->aeronefs as $index => $aeronef)
                    {{ $aeronef->indicatif_appel }}
                @endforeach
            </td>
            <td  colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">@if( $item->permanant == 1)
                    Bloc de {{$item->nbre_mois}} mois
                    @else
                    Demande simple
                @endif</td>
            <td  colspan="2" style="border: 1px solid ;padding: 7px; text-align:center; ">{{ $item->statut ? $item->statut->libelle : 'non soumis' }}</td>
            
            <td colspan="5" style="border: 1px solid ;padding: 7px; text-align:center; ">
            @foreach($item->routes as $index => $route)
                 {{ $route->ville_depar->code_icao }} - {{ $route->ville_arrive?->code_icao }} 
                @if($index < count($item->routes) - 1)
                    /
                @endif
            @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<!-- </div> -->
</body>
</html>
