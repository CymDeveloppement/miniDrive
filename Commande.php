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
		
		<!-- Bouton de retour -->
		<a href="Index.php" class="btn btn-secondary text-light lx-auto h-75" type="button">
			<strong>Retour</strong>
		</a>
		
		<!-- Nom de l'entreprise -->
		<div class="text-center mx-auto">
			<a class="navbar-brand mb-0 h1" href="#">
				<?php echo($Shop->getNomEntreprise()); ?>
			</a>
			</br>
		</div>
		
		<!-- Logo -->
		<a class="navbar-brand" href="#">
			<img src="Logo.png" width="140" height="100" >
		</a>
	</div>
			<div class="jumbotron mx-5 my-4 d-block">
				<div class="row">
					<div class="col-md-4">
					
						<!-- Gestion via PHP et JS a faire -->
						<table class="table table-bordered">
							<thead class="thead-dark">
								<tr>
									<th scope="col">Produits</th>
									<th scope="col">Prix</th>
									<th scope="col">Quantité:</th>
									<th scope="col">Total:</th>
								</tr>
							</thead>
							<tbody class="table-active">
								<tr>
									<th scope="row">s</th>
									<td>Mark</td>
									<td>Otto</td>
								</tr>
								<tr>
									<th scope="row">2</th>
									<td>Jacob</td>
									<td>Thornton</td>
								</tr>
								<tr>
									<th scope="row">3</th>
									<td>Larry the Bird</td>
									<td>@twitter</td>
								</tr>
							</tbody>
						</table>

					</div>
					
					<div class="col-md-4 text-center">
						Choix de date et heure de livraison
						<div class="dropdown">
							<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Choisir le jour
							</button>
							
							<!-- Gestion via PHP a faire -->
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item" href="#">Lundi 01/06/2020</a>
								<a class="dropdown-item" href="#">Mardi 02/06/2020</a>
								<a class="dropdown-item" href="#">...</a>
							</div>
						</div>
					</div>
					
					<!-- Gestion via PHP a faire -->
					<div class="col-md-4">
						<form>
							<div class="form-group">
								<label for="Nom">Nom:</label>
								<input type="text" class="form-control" id="Nom">
							</div>
							<div class="form-group">
								<label for="Prenom">Prénom:</label>
								<input type="text" class="form-control" id="Prenom">
							</div>
							<div class="form-group">
								<label for="Numero">Numéro de téléphone:</label>
								<input type="numero" class="form-control" id="Numero">
							</div>
							<div class="form-group">
								<label for="Email">Email:</label>
								<input type="email" class="form-control" id="Email">
							</div>
							<div>
								CAPTCHA
							</div>
							<div class="d-flex flex-row-reverse">
								<button type="submit" class="btn btn-primary">Confirmer</button>
							</div>
						</form>
					</div>
				</div>
			</div>
	<!-- Pied de page -->
	<footer class="footer">
		<div class="container ml-2">
			<span class="text-dark"><?php echo($Shop->getConditions()); ?></span>
		</div>
	</footer>
</body>
</html>