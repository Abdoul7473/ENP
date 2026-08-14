<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visiteurs</title>
    <style>
        @page {
            size: landscape;
        }
        .background {
            position: fixed;
            top: 150;
            left: 0;
            width: 100%;
            height: auto;
            opacity: 0.2;
            /* Opacité de l'arrière-plan */
            z-index: 0;
            /* Assurez-vous que l'arrière-plan est derrière le contenu */
            background-position: center;
            background-size: 500px;
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
            max-width: 100px;
            /* Limite la largeur des colonnes */
        }

        td {
            font-size: 12px;
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            max-width: 100px;
            /* Limite la largeur des colonnes */
            word-wrap: break-word;
            /* Permet le retour à la ligne */
            word-break: break-all;
            /* Permet de couper les mots s'ils sont trop longs */
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
    @if($type == 2)
    <div style="display: flex;flex-wrap: wrap; margin: 0 -10px;">
        <div>
            <img src="logo_pn.jpg" style="width: 100px; height:auto;">
        </div>
        <div style="width: 100%; height:auto; margin-top: -120px;  text-align: center;">

            <b> <strong>REPUBLIQUE DU NIGER</strong> </b>
            <br>
            <i><strong>Fraternité-Travail-Progès</strong></i>
            <h5>
                <b><strong>Ministère de l'Intérieur, de la Sécurité <br> Publique et l'Administration du <br> Territoire</strong></b>
            </h5>
            <h5>
                <b><strong>DIRECTION GENERALE <br> DE LA POLICE NATIONALE</strong></b>
            </h5>
            <h5>
                <b><strong>DIRECTION DE L'ECOLE NATIONALE DE <br> POLICE ET DE LA FORMATION PERMANENTE</strong></b>
            </h5>
            <div>
                <img src="logo_enp.png" style="width: 100px; height:auto; margin-top: -240px; margin-left: 85%;" alt="Logo">
            </div>
            <br>
        </div>
    </div>
    @endif
    <table>
        <thead>
            <tr>
                <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">N° carte d'identité</th>
                <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">Matricule du vehicule</th>
                <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">Nom</th>
                <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">Prénom</th>
                <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">Date de la visite </th>
                <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">Date de naissance</th>
                <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">Lieu</th>
                <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">Heure d'arrivéé</th>
                <th colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">Heure de depart</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $data)
            <tr>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">{{$data->num_carte}}</td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">{{$data->mat_vehicule}}</td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">{{$data->nom}}</td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">{{$data->prenom}} </td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">{{\Carbon\Carbon::parse($data->date)->format('d/m/Y')}}</td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">{{\Carbon\Carbon::parse($data->date_naiss)->format('d/m/Y')}}</td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">{{$data->localite}} </td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">{{$data->heure_arrive}}</td>
                <td colspan="2" style="border: 1px solid ;padding: 7px; text-align:center;">{{$data->heure_depart}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>