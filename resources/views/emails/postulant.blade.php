<!DOCTYPE html>
<html>
<head>
    <title>Création de compte</title>
</head>
<body>
   
<p>Bonjour</p>
<p>{{ $data['contenu'] }}.</p>
@if(isset($data['lien']))
<p><a href="{{ $data['lien'] }}">Cliquez ici</a></p>
@endif
@if(isset($data['fichier']))
<p><a href="{{ $data['fichier'] }}" download>Télécharger</a></p>
@endif
<strong>Merci</strong>
  
</body>
</html>