<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, shrink-to-fit=no">
	<title>Création de config.json</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
</head>
<body>
	<div class="mx-5 my-3">
		<?php
			if(isset($_POST['nom']))
			{
				echo("<h4>Fichier créé sous le nom de config.json.</h4>");
			}
		?>
		<form id="FormInfosClient" autocomplete="off" action='createconfigjson.php' method="post">
			<div class="form-group">
				</br>
				<h4>Articles (séparer chaque articles par deux slashs entouré d'espaces // )</h4>
				</br>
				<label>Nom des produits:</label>
				<input type="text" class="form-control" name="nom" required>
			</div>
			<div class="form-group">
				<label>Description des produits:</label>
				<input type="text" class="form-control" name="description" required>
			</div>
			<div class="form-group">
				<label>Chemin de l'image de chaque produit:</label>
				<input type="text" class="form-control" name="img_path" required>
			</div>
			<div class="form-group">
				<label>Prix des produits (tout en centime):</label>
				<input type="text" class="form-control" name="prix" required>
			</div>
			<div class="form-group">
				</br>
				<h4>Infos</h4>
				</br>
				<label>Nom de l'entreprise:</label>
				<input type="text" class="form-control" name="Nom_Entreprise" required>
			</div>
			<div class="form-group">
				<label>Numéro de téléphone:</label>
				<input type="tel" pattern="[0-9]+" title="Numéro de téléphone." class="form-control" name="Telephone" required>
			</div>
			<div class="form-group">
				<label>Email pour recevoir les commandes:</label>
				<input type="email" class="form-control" name="Email" required>
			</div>
			<div class="form-group">
				<label>Serveur SMTP:</label>
				<input type="text" class="form-control" name="SMTP" required>
			</div>
			<div class="form-group">
				<label>Port du serveur SMTP:</label>
				<input type="text" class="form-control" name="Port" required>
			</div>
			<div class="form-group">
				<label>Adresse e-mail du serveur SMTP:</label>
				<input type="email" class="form-control" name="Email_Server" required>
			</div>
			<div class="form-group">
				<label>Mot de passe du serveur SMTP:</label>
				<input type="password" class="form-control" name="Mdp" required>
			</div>
			<div class="form-group">
				<label>Emplacement du fichier contenant le mail (chemin par rapport au fichier de config):</label>
				<input type="text" class="form-control" name="Emplacement_Mail_Html" required>
			</div>
			<div class="form-group">
				<label>Conditions d'utilisations du site:</label>
				<input type="text" class="form-control" name="Conditions" required>
			</div>
			<div class="form-group">
				<label>Symbole monnétaire:</label>
				<input type="text" class="form-control" name="Monnaie" required>
			</div>
			<div class="form-group">
				<label>Nombre de jours d'avances à afficher pour récupérer une commande:</label>
				<input type="text" class="form-control" name="Nombre_Jour_Recup" required>
			</div>
			<div class="form-group">
				<label>Intervalle entre chaque récupération (format: xxHyyM ou xxH ou yyM):</label>
				<input type="text" class="form-control" name="Intervalle" required>
			</div>
			<div class="form-group">
				</br>
				<h4>Horaires par jours (format: xxHyyM ou xxH ou yyM)</h4>
				<h4>(vide si pas d'horaires sinon au moins une heure de début et une heure de fin, chaque horaires est séparé par deux slashs entouré d'espaces // ) </h4>
				</br>
				<h5>Exemple: 8H // 12H // 15H // 17H : ouvre à 8h ferme à 12h, ouvre à nouveau à 15H et ferme à 17H</h5>
				</br>
				<label>Lundi:</label>
				<input type="text" class="form-control" name="Lundi">
			</div>
			<div class="form-group">
				<label>Mardi:</label>
				<input type="text" class="form-control" name="Mardi">
			</div>
			<div class="form-group">
				<label>Mercredi:</label>
				<input type="text" class="form-control" name="Mercredi">
			</div>
			<div class="form-group">
				<label>Jeudi:</label>
				<input type="text" class="form-control" name="Jeudi">
			</div>
			<div class="form-group">
				<label>Vendredi:</label>
				<input type="text" class="form-control" name="Vendredi">
			</div>
			<div class="form-group">
				<label>Samedi:</label>
				<input type="text" class="form-control" name="Samedi">
			</div>
			<div class="form-group">
				<label>Dimanche:</label>
				<input type="text" class="form-control" name="Dimanche">
			</div>
			<div class="d-flex flex-row-reverse">
				<button type="submit" class="btn btn-primary" id='BtnConfirmer'>Créer le fichier</button>
			</div>
		</form>
		<?php
			if(isset($_POST['nom']))
			{
				$All = [];
				$Produits = [];
				$Infos = [];
				$Horaires = [];
				
				// PRODUITS
				$noms = explode(" // ", $_POST['nom']);
				$descriptions = explode(" // ", $_POST['description']);
				$chemins = explode(" // ", $_POST['img_path']);
				$prix = explode(" // ", $_POST['prix']);
				
				if(count($noms) == count($descriptions) && count($chemins) == count($prix) && count($descriptions) == count($chemins))
				{
					for($i = 0; $i < count($noms); $i++)
					{
						$Produits[] = array("nom" => $noms[$i], "description" => $descriptions[$i], "img_path" => $chemins[$i], "prix" => $prix[$i]);
					}
				}
				
				// INFOS
				$Infos['Nom_Entreprise'] = $_POST['Nom_Entreprise'];
				$Infos['Telephone'] = $_POST['Telephone'];
				$Infos['Email'] = $_POST['Email'];
				$Infos['SMTP'] = $_POST['SMTP'];
				$Infos['Port'] = $_POST['Port'];
				$Infos['Email_Server'] = $_POST['Email_Server'];
				$Infos['Mdp'] = $_POST['Mdp'];
				$Infos['Emplacement_Mail_Html'] = $_POST['Emplacement_Mail_Html'];
				$Infos['Conditions'] = $_POST['Conditions'];
				$Infos['Monnaie'] = $_POST['Monnaie'];
				$Infos['Nombre_Jour_Recup'] = $_POST['Nombre_Jour_Recup'];
				$Infos['Intervalle'] = $_POST['Intervalle'];
				
				// HORAIRES
				$Lundi = explode(" // ", $_POST['Lundi']);
				$Mardi = explode(" // ", $_POST['Mardi']);
				$Mercredi = explode(" // ", $_POST['Mercredi']);
				$Jeudi = explode(" // ", $_POST['Jeudi']);
				$Vendredi = explode(" // ", $_POST['Vendredi']);
				$Samedi = explode(" // ", $_POST['Samedi']);
				$Dimanche = explode(" // ", $_POST['Dimanche']);
				
				$Horaires['Lundi'] = [];
				$Horaires['Mardi'] = [];
				$Horaires['Mercredi'] = [];
				$Horaires['Jeudi'] = [];
				$Horaires['Vendredi'] = [];
				$Horaires['Samedi'] = [];
				$Horaires['Dimanche'] = [];
				
				foreach($Lundi as $lundiH)
				{
					if($lundiH != "")
					{
						array_push($Horaires['Lundi'], $lundiH);
					}
				}
				foreach($Mardi as $mardiH)
				{
					if($mardiH != "")
					{
						array_push($Horaires['Mardi'], $mardiH);
					}
				}
				foreach($Mercredi as $mercrediH)
				{
					if($mercrediH != "")
					{
						array_push($Horaires['Mercredi'], $mercrediH);
					}
				}
				foreach($Jeudi as $jeudiH)
				{
					if($jeudiH != "")
					{
						array_push($Horaires['Jeudi'], $jeudiH);
					}
				}
				foreach($Vendredi as $vendrediH)
				{
					if($vendrediH != "")
					{
						array_push($Horaires['Vendredi'], $vendrediH);				
					}
				}
				foreach($Samedi as $samediH)
				{
					if($samediH != "")
					{
						array_push($Horaires['Samedi'], $samediH);
					}
				}
				foreach($Dimanche as $dimancheH)
				{
					if($dimancheH != "")
					{
					array_push($Horaires['Dimanche'], $dimancheH);
					}
				}
				
				// Création du fichier
				$All['Produits'] = $Produits;
				$All['Infos'] = $Infos;
				$All['Horaires'] = $Horaires;
				
				$json_data = json_encode($All);
				file_put_contents('PHP/config.json', $json_data);
				echo('<meta http-equiv="refresh" content="2">');
			}
		?>
	</div>
	<!-- Pied de page -->
	<footer class="footer">
		<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
		<script type="text/javascript" src="DataTables/datatables.min.js"></script>
	</footer>
</body>
</html>

