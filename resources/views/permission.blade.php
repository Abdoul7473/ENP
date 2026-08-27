<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permission</title>
    <style>
         @page {
            size: A4 portrait;
            margin: 12mm 10mm 18mm;
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
        .bordered {
            position: absolute;
            width: 95%;
            height: 23%;
            overflow: hidden;
            left:6mm;
            break-inside: avoid;
            page-break-inside: avoid;
            border: 2px solid #0f0f0f;
            border-radius: 0mm;
            background: while;
            
        }
    </style>
</head>

<body>
    <h2 style="text-align: right;" > Niamey le {{$date}}</h2>
    <h2 style="text-align: center;"><u>Autorisation de sortie</u></h2>
<div class="bordered">


<h3>N° {{$permission->numero}}</h3>
<h3>Une Autorisation de Sortie d'une Durée de {{$permission->nombre_jour}} jour /du 
    {{ \Carbon\Carbon::parse($permission->date_debut)->format('d/m/Y') }} Au {{ \Carbon\Carbon::parse($permission->date_fin)->format('d/m/Y') }} </h3>
<h3>Est Accordée A {{$permission->eleve->matricule}}  {{$permission->eleve->prenom}} {{$permission->eleve->nom}}</h3>
<h3>Pour se rendre A {{$permission->lieu}} .. Motif {{$permission->motif}} </h3>
<h3>L'intéressé (e) doit se rejoindreson unité à {{$permission->heure_arrive}} </h3>
</div>
</body>

</html>