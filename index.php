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
		<a href="Commande.php" class="btn btn-secondary text-light lx-auto h-75" type="button">
			<strong>Commander</strong>
		</a>
		
		<div class="dropdown mx-auto">
		
			<!-- Nom de l'entreprise -->
			<div class="text-center">
				<a class="navbar-brand mb-0 h1" href="#">
					<?php echo($Shop->getNomEntreprise()); ?>
				</a>
				</br>
			</div>
			
			<!-- Bouton de la liste -->
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Liste des articles
			</button>
			
			<!-- Liste -->
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<?php echo($Shop->getProduitsNom()); ?>
			</div>
		</div>
		
		<!-- Logo -->
		<a class="navbar-brand" href="#">
			<img src="Logo.png" width="140" height="100" >
		</a>
	</div>
	
	<!-- Tableau d'articles -->
	<div class='card-group d-flex flex-wrap justify-content-center mb-5'>
	<?php
		// Appel de la fonction qui retourne les articles.
		$produits = $Shop->getProduits();
				
		//Affichage des articles dans les card
		$countProds = sizeof($produits);
		$i = 0;
		foreach($produits as $row => $produit)
		{
			$i++;
			$img = 'img'.$i;
			$newString[$i] = str_replace(" ","",$produit['nom']);
			echo("<div class='card border '>
					<div class='card-body' data-toggle='modal' data-target='#exampleModal$newString[$i]'>
						<h5 class='card-title text-center'>$produit[nom]</h5>
						<div class='d-flex'>
							<img class='img-thumbnail align-middle' src='$produit[img_path]'>
							<div class='d-flex justify-content-center'>
								<p class='description pt-4 ml-2'>$produit[description]</p>
							</div>
						</div>
					</div>
					<div class='card-footer'>
						<div class='mt-2 float-left'>
							Prix: $produit[prix]
						</div>
						<div class='float-right'>
							<input onclick='AcheterArticle(Acheter$img, $i)' type='button' value='Acheter' class='btn btn-primary text-right' id='Acheter$img' style='display: block;'></input>
							<div class='countAchat$i' id='' style='display: block;'>
								<div class='d-flex flex-row'>
									<input onclick='MoinsArticle(Acheter$img, $i)' type='button' value='-' class='btn btn-primary text-right' id='btn-' style='display: block;'></input>
									<p class='h6 px-2 mt-2' id='counter$i'></p>
									<input onclick='PlusArticle($i)' type='button' value='+' class='btn btn-primary text-right' id='btn+' style='display: block;'></input>
								</div>
							</div>
						</div>
					</div>
				</div>");
							
		}
		echo'<script type="text/javascript">CacherNb('."$countProds".');</script>';
	?>
	</div>
	<?php
		$produits = $Shop->getProduits();
		$i = 0;
		foreach($produits as $row => $produit)
		{
			$i++;
			$newString[$i] = str_replace(" ","",$produit['nom']);
			echo("<div class='modal fade' id='exampleModal$newString[$i]' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
						<div class='modal-content'>
							<div class='modal-header'>
								<h5 class='modal-title' id='exampleModalLabel'>$produit[nom]</h5>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
								</button>
							</div>
							<div class='modal-body'>
								$produit[description]
							</div>
						</div>
					</div>
				</div>");
		}
	?>
	
	<!-- Pied de page -->
	<footer class="footer">
		<div class="container ml-2">
			<span class="text-dark"><?php echo($Shop->getConditions()); ?></span>
		</div>
	</footer>
</body>
</html>