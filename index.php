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
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
</head>

<body>
	<!-- Navbar -->
	<div class="navbar navbar-expand-md navbar-dark bg-dark">
		
		<div class="achat">
			<input onclick='Commande(); AfficheTableau(<?php echo(json_encode($Shop->Infos['Monnaie'])); ?>);' type='button' class="btn btn-secondary text-light lx-auto h-75" value='Commander'></input>
		</div>
		
		<div class="commande">
			<input onclick='Retour()' type='button' class="btn btn-secondary text-light lx-auto h-75" value='Retour'></input>
		</div>
		
		<div class="dropdown mx-auto">
		
			<!-- Nom de l'entreprise -->
			<div class="text-center">
				<a class="navbar-brand mb-0 h1" href="#">
					<?php echo($Shop->Infos['Nom_Entreprise']); ?>
				</a>
				</br>
			</div>
			
			<!-- Bouton de la liste -->
			<button class="btn btn-secondary dropdown-toggle achat" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Liste des articles
			</button>
			
			<!-- Liste -->
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<?php
					foreach($Shop->Produits as $produit)
					{
						$id = $Shop->idProd[$produit['nom']];
						echo("<button class='dropdown-item' data-toggle='modal' data-target='#article$id'>$produit[nom]</button>");
					}
				?>
			</div>
		</div>
		
		<!-- Logo -->
		<a class="navbar-brand" href="#">
			<img src="Logo.png" width="140" height="100" >
		</a>
	</div>
	
	<!-- Tableau d'articles -->
	<div class="achat">
		<div class='card-group d-flex flex-wrap justify-content-center mb-5'>
		<?php	
			//Affichage des articles dans les card
			foreach($Shop->Produits as $produit)
			{
				$id = $Shop->idProd[$produit['nom']];
				$monnaie = $Shop->Infos['Monnaie'];
				$prix = $Shop->prix[$id-1];
				
				$img = 'img'.$id;
				
				$nomArticle[$id] = $Shop->EncoderJSON($produit['nom']);
				$prixSend = $Shop->EncoderJSON($Shop->prix[$id-1]);
				
				echo("<div class='card border '>
						<div class='card-body' data-toggle='modal' data-target='#article$id'>
							<h5 class='card-title text-center'>$produit[nom]</h5>
							<div class='d-flex'>
								<img class='img-thumbnail align-middle' src='$produit[img_path]'>
								<div class='d-flex justify-content-center'>
									<p class='description pt-4 ml-2'>$produit[description]</p>
								</div>
							</div>
						</div>
						<div class='card-footer'>
							<div class='mt-2 h6 float-left'>
								$prix$monnaie
							</div>
							<div class='float-right'>
								<input onclick='AcheterArticle(Acheter$img, $id, recap$id, $prixSend, $nomArticle[$id])' type='button' value='Acheter' class='btn btn-primary text-right' id='Acheter$img' style='display: block;'></input>
								<div class='countAchat$id' style='display: block;'>
									<div class='d-flex flex-row'>
										<input onclick='MoinsArticle(Acheter$img, $id, recap$id, $prixSend, $nomArticle[$id])' type='button' value='-' class='btn btn-primary text-right' id='btn-' style='display: block;'></input>
										<p class='h6 px-2 mt-2' id='recap$id'></p>
										<input onclick='PlusArticle($id, recap$id, $prixSend, $nomArticle[$id])' type='button' value='+' class='btn btn-primary text-right' id='btn+' style='display: block;'></input>
									</div>
								</div>
							</div>
						</div>
					</div>");
								
			}
			$NbCard = $id;
		?>
		</div>
	</div>
		
	<?php
		foreach($Shop->Produits as $produit)
		{
			$id = $Shop->idProd[$produit['nom']];
			
			echo("<div class='modal fade' id='article$id' tabindex='-1' role='dialog' aria-labelledby='articleLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
						<div class='modal-content'>
							<div class='modal-header'>
								<h5 class='modal-title' id='articleLabel'>$produit[nom]</h5>
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
	
	<div class="commande">
		<div class="d-flex flex-wrap bd-highlight flex-column mx-4 my-4">
			<div class="row">
			
				<div class="col-xl-4 flex-fill bd-highlight">
					<table id="Commande" class="table table-bordered table-dark" width="100%"></table>
				</div>
				
				<div class="col-xl-4 flex-fill bd-highlight text-center">
					Choix de date et heure de livraison
					<div class="dropdown">
					
						<button class="btn btn-secondary dropdown-toggle" id="dropdownDate" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Choisir le jour
						</button>
						
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<?php
							$nbJoursAffiche = $Shop->Horaires['Nombre_Jour_Recup'];
							$joursOuvertsKey = $Shop->GetKeys($Shop->Jours);
							$nbJours = 0;
							$jourSaute = 0;
							$jourActuel = $Shop->DateJour();
							
							while ($nbJours <= $nbJoursAffiche-1)
							{
								if (!empty($Shop->Jours[$joursOuvertsKey[$jourActuel-1]]))
								{
									$dateJour = date('d-m-Y', strtotime('+'.$nbJours+$jourSaute.' day'));
									$dateJS = new DateTime($dateJour);
									$dateJS = $Shop->EncoderJSON($dateJS->format('d-m-Y'));
									echo("<button class='dropdown-item' onclick='DateSelect($dateJS);'>$dateJour</button>");
									$nbJours++;
								}
								else
								{
									$jourSaute++;
								}
								$jourActuel++;
								if ($jourActuel >= 8)
								{
									$jourActuel = 1;
								}
							}
						?>
						</div>
					</div>
					
					<div class="container">
						<?php
							$intervalle = $Shop->intervalle;
							$nbBoutton = 1;
							foreach ($Shop->Jours as $jours)
							{
								echo("<div class='justify-content-center btn-group btn-group-toggle btn-group-justified row row-cols-4 mt-3' id='lotBoutton$nbBoutton' data-toggle='buttons'>");
								
								for ($i = 0; $i < count($jours); $i+=2)
								{
									$heureCompt = $jours[$i]*60;
									
									while($heureCompt <= $jours[$i+1]*60)
									{
										$heureAffiche = intdiv($heureCompt,60)."H".$heureCompt%60;
										echo("<label class='btn btn-outline-secondary col-sm-2 mx-1 my-1'>
												<input type='radio' name='options' id='option1' autocomplete='off'> $heureAffiche
											</label>");
										$heureCompt += $intervalle;
									}
								}
								$nbBoutton++;
								echo("</div>");
							}
						?>
						
					
					
					</div>
				</div>
				
				<!-- Gestion via PHP à faire -->
				<div class="col-xl-4 flex-fill bd-highlight">
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
	</div>
	
	<!-- Pied de page -->
	<footer class="footer">
		<div class="container ml-2">
			<span class="text-dark"><?php echo($Shop->Infos['Conditions']); ?></span>
		</div>
		
		<script type="text/javascript" src="js/jquery-3.5.1.js"></script>
		<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
		<script type="text/javascript" src="DataTables/datatables.min.js"></script>
		<script type="text/javascript" src="js/AcheterBtn.js"></script>
		<script type="text/javascript">CacherNb(<?php echo($NbCard); ?>); CacherBtnHeure(<?php echo($Shop->DateJour()); ?>);</script>
	</footer>
</body>
</html>