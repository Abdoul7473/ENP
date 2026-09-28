<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rélevé  des notes</title>
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
            font-size: 9px;
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
             /* Limite la largeur des colonnes */
        }
        td {
            font-size: 8px;
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
             /* Limite la largeur des colonnes */
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
            <u>CYCLE DE FORMATION DES OFFICIERS DE POLICE</u><br>
            <u><b>RELEVE DES NOTES</b></u>
        </div>
        <div>
            <p>ANNEE ACADEMIQUE : {{ \Carbon\Carbon::parse($annee->date_debut)->format('Y')}}-{{ \Carbon\Carbon::parse($annee->date_fin)->format('Y')}}</p>
            <p>NOM ER PRENOM : {{$releve_devoir[0]->releve->eleve->prenom}} {{$releve_devoir[0]->releve->eleve->nom}} </p>
            <p>N°CARTE/Mle : {{$releve_devoir[0]->releve->eleve->matricule}}</p>
        </div>
        
        <br>       
    </div>
    <div>
         <table style="text-align: center; width: 50%;">
             <thead >
                <th colspan="4" style="text-align: center; font-size: 12;">
                   <b> NOTES DE CLASSE </b>
                </th>
             </thead>
            <thead >
                <th style="text-align: center;">MATIERES</th>
                <th style="text-align: center;">COEFF</th>
                <th style="background-color: yellow;text-align: center;">NOTE <br> / 20</th>
                <th style="text-align: center;">NOTE <br> COEFF</th>
            </thead>
            <tbody>
                @foreach($releve_devoir as $ligne)
                <tr>
                    <td>{{$ligne->matiere}}</td>
                    <td>{{$ligne->coefficient}}</td>
                    <td style="background-color: yellow;">{{$ligne->note}}</td>
                    <td>{{$ligne->note_coefficiente}} </td>
                </tr>
                @endforeach
            </tbody>
            <tr>
                <td style="font-size: 12;"><b>TOTAL</b> </td>
                <td><b>{{$releve_devoir[0]->releve->total_coefficient_classe}} </b> </td>
                <td><b>{{$releve_devoir[0]->releve->total_note_classe}} </b> </td>
                <td>{{$releve_devoir[0]->releve->total_note_coefficiente_classe}} </td>
            </tr>
             <tr>
                <td colspan="3" style="font-size: 12;"><b>MOYENNE DE CLASSE</b> </td>
                <td>{{$releve_devoir[0]->releve->moyenne_classe}} </td>
            </tr>
        </table>
    </div>
    <div style="width: 100%; height:auto; margin-top: -1020px;  text-align: center; margin-left: 52%;">

             <table style="text-align: center; width: 50%;">
                <th colspan="4" style="text-align: center; font-size: 12;">
                   <b>NOTES D'EXAMEN </b>
                </th>
            <thead>
                <th style="text-align: center;">MATIERES</th>
                <th style="text-align: center;">COEFF</th>
                <th style="background-color: yellow;text-align: center;">NOTE <br> / 20</th>
                <th style="text-align: center;">NOTE <br> COEFF</th>
            </thead>
            <tbody>
                @foreach($releve_examen as $ligne)
                <tr>
                    <td>{{$ligne->matiere}}</td>
                    <td>{{$ligne->coefficient}}</td>
                    <td style="background-color: yellow;">{{$ligne->note}}</td>
                    <td>{{$ligne->note_coefficiente}} </td>
                </tr>
                @endforeach
            </tbody>
            <tr>
                <td style="font-size: 12;"><b>TOTAL</b> </td>
                <td><b>{{$releve_examen[0]->releve->total_coefficient_examen}} </b> </td>
                <td><b>{{$releve_examen[0]->releve->total_note_examen}} </b> </td>
                <td>{{$releve_examen[0]->releve->total_note_coefficiente_examen}} </td>
            </tr>
             <tr>
                <td colspan="3" style="font-size: 12;"><b>MOYENNE D'EXAMEN</b> </td>
                <td>{{$releve_examen[0]->releve->moyenne_examen}} </td>
            </tr>
        </table>
        </div>
   
</body>

</html>