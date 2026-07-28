<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport</title>
    <style>
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
        <div>
            <p>{{$rapport->description}}</p>
        </div>

        <table style="text-align: center;">

            <thead>
                <th>Compagnies</th>
                <th>effectif théorique</th>
                <th>Nombre present</th>
                <th>Nombre d'absent</th>
                <th>Nombre de malade </th>
                <th>Nombre de permissionnaire</th>
            </thead>
            <tbody>
                @foreach($rapport->situations as $situation)
                <tr>
                    <td>{{$situation->compagnie->nom}}</td>
                    <td>{{$situation->compagnie->effectif}}</td>
                    <td>{{$situation->nombre_present}}</td>
                    <td>{{$situation->nombre_absent}} </td>
                    <td>{{$situation->nombre_malade}}</td>
                    <td>{{$situation->nombre_permissionnaire}}</td>
                </tr>
                @endforeach
            </tbody>
            <tr>
                <td><b>TOTAL:</b> </td>
                <td style="font-size: 13px;"><b>{{$total_effectif}}<b></td>
                <td style="font-size: 13px;"><b>{{$total_present}}<b></td>
                <td style="font-size: 13px;"><b>{{$total_absent}}<b></td>
                <td style="font-size: 13px;"><b>{{$total_malade}}<b></td>
                <td style="font-size: 13px;"><b>{{$total_permissionnaire}}<b></td>
            </tr>
        </table>
        <br>
        <table>
            <thead>
                <tr>
                    <th>MALADES</th>
                    <th>Compagnies</th>
                </tr>
            </thead>

            <tbody>
                @foreach($malades as $malade)

                <tr>
                    <td> {{$malade->eleve->matricule}} {{$malade->eleve->nom}} {{$malade->eleve->prenom}} </td>
                    <td> {{$malade->situation->compagnie->nom}} </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <table>
            <thead>
                <tr>
                    <th>Permissionnaires</th>
                    <th>Compagnies</th>
                </tr>
            </thead>

            <tbody>
                @foreach($permissionnaires as $permissionnaire)

                <tr>
                    <td> {{$permissionnaire->eleve->matricule}} {{$permissionnaire->eleve->nom}} {{$permissionnaire->eleve->prenom}} </td>
                    <td> {{$permissionnaire->situation->compagnie->nom}} </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <table>
            <thead>
                <tr>
                    <th>Absents</th>
                    <th>Compagnies</th>
                </tr>
            </thead>

            <tbody>
                @foreach($absents as $absent)

                <tr>
                    <td> {{$absent->eleve->matricule}} {{$absent->eleve->nom}} {{$absent->eleve->prenom}} </td>
                    <td> {{$absent->situation->compagnie->nom}} </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div style="text-align: center;">
            <p>Officier du jour :{{$rapport->encadreur->grade->libelle}} {{$rapport->encadreur->nom}} {{$rapport->encadreur->prenom}}</p>
        </div>
    </div>
</body>

</html>