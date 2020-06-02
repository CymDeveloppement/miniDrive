<?php
	include("PHP/fonctions.php");
	$Shop = new shop();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, shrink-to-fit=no">
	<title>Produits</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
	
	<!-- Code JS pour afficher ou non les boutons d'ajout d'articles acheté -->
	<script type="text/javascript" src="js/AcheterBtn.js"></script>
</head>

<body>
	<!-- Navbar -->
	<div class="navbar navbar-expand-md navbar-dark bg-dark">
		
		<!-- Bouton de commande -->
		<button class="btn btn-secondary text-light lx-auto h-75" type="button">
			<strong>Commander</strong>
		</button>
		
		<div class="dropdown mx-auto">
		
			<!-- Nom de l'entreprise -->
			<div class="text-center">
				<a class="navbar-brand mb-0 h1" href="#">
					<?php
						echo($Shop->getNomEntreprise());
					?>
				</a>
				</br>
			</div>
			
			<!-- Bouton de la liste -->
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Liste des articles
			</button>
			
			<!-- Liste -->
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<?php
					echo($Shop->getProduitsNom());
				?>
			</div>
		</div>
		
		<!-- Logo -->
		<a class="navbar-brand" href="#">
			<img src="Logo.png" width="140" height="100" >
		</a>
	</div>
	
	<!-- Tableau d'articles POUR PC -->
	<div class="PC">
		<div class='card-group d-flex flex-wrap justify-content-center'>
			<?php
				// Appel de la fonction qui retourne les articles.
				echo($Shop->getProduitsCard());
				//cardProduit();
			?>
		</div>
		</br>
	</div>
	
	<!-- Pied de page -->
	<footer class="footer">
		<div class="container ml-2">
			<span class="text-dark">Conditions d'utilisations et textes légaux...</span>
		</div>
	</footer>
</body>
</html>