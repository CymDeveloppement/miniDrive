<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=0.7, shrink-to-fit=no">
	<title>Produits</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
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
					Nom Entreprise
				</a>
				</br>
			</div>
			
			<!-- Bouton de la liste -->
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Liste des articles
			</button>
			
			<!-- Liste -->
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="#">Action</a>
				<a class="dropdown-item" href="#">Another action</a>
				<a class="dropdown-item" href="#">Something else here</a>
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
				include("PHP/fonctions.php");
				cardProduit();
			?>
		</div>
		</br>
	</div>
	
	<!-- Class d'affichage pour les terminaux non mobiles -->
	<div class="PC">
		
	</div>
	
	<!-- Class d'affichage pour les terminaux mobiles -->
	<div class="mobile">
		
	</div>
	
	<!-- Pied de page -->
	<footer class="footer">
		<div class="container ml-2">
			<span class="text-dark">Conditions d'utilisations et textes légaux...</span>
		</div>
	</footer>
	
	<!-- Script pour tester les terminaux mobiles -->
	<script type="text/javascript">
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
		{
			document.getElementsByClassName("PC")[0].style.display ="none";
		}
		else
		{
			document.getElementsByClassName("mobile")[0].style.display ="none";
		}
	</script>
</body>
</html>