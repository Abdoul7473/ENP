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
        .bordered {
            position: absolute;
            width: 95%;
            height: 23%;
            overflow: hidden;
            left:6mm;
            break-inside: avoid;
            page-break-inside: avoid;
            border: 1px solid #0f0f0f;
            border-radius: 0mm;
            background: while;
            
        }
    </style>
</head>

<body>
    <h2 style="text-align: right;" > Niamey, le {{$date}}</h2>
    <h2 style="text-align: center;"><u>Autorisation de sortie</u></h2>
<div class="bordered background">


<p style="font-size: 20px;"> <b>N° {{$permission->numero}}</b></p>
<p style="font-size: 20px;">Une Autorisation de Sortie d'une Durée de <b> {{$permission->nombre_jour}}</b> jour, du 
   <b> {{ \Carbon\Carbon::parse($permission->date_debut)->format('d/m/Y') }} </b> Au <b> {{ \Carbon\Carbon::parse($permission->date_fin)->format('d/m/Y') }} </b> </p>
<p style="font-size: 20px;">Est Accordée A L' @if($permission->eleve->compagnie->corp->id == 4)
                            E/CP
                        @endif
                        @if($permission->eleve->compagnie->corp->id == 3)
                            E/OP
                        @endif
                        @if($permission->eleve->compagnie->corp->id == 2)
                            E/IP
                        @endif
                        @if($permission->eleve->compagnie->corp->id == 1)
                            E/GPX
                        @endif 
                        <b> {{$permission->eleve->prenom}} {{$permission->eleve->nom}}</b></p>
<p style="font-size: 20px;">Pour se rendre A <b> {{$permission->lieu}} , Motif {{$permission->motif}} </b></p>
<p style="font-size: 20px;">L'intéressé (e) doit se rejoindre son unité à <b>{{$permission->heure_arrive}} </b></p>
</div>
</body>

</html>