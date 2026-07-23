<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport</title>
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
    <div class="content">
        <table  >
            @foreach($rapport->situations as $situation)
            <p>{{$situation->compagnie->nom}}</p>
            <thead>
                    <th >effectif théorique</th>
                    <th >Nombre present</th>
                    <th >Nombre d'absent</th>
                    <th >Nombre de malade </th>
                    <th >Nombre de permissionnaire</th>
            </thead>
                <tbody>
                
                
                <tr>
                    <td  >{{$situation->compagnie->effectif}}</td>
                    <td >{{$situation->nombre_present}}</td>
                    <td >{{$situation->nombre_absent}} </td>
                    <td  >{{$situation->nombre_malade}}</td>
                    <td >{{$situation->nombre_permissionnaire}}</td>
                </tr>
                
                </tbody>
            @endforeach
        </table>
    </div>

</body>
</html>
