<!DOCTYPE html>
<?php
	include("PHP/fonctions.php");
	$Shop = new shop();
	$Captcha = new captcha();
	
?>
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
		<div class="row container-fluid">
			<div class="col">
				<span class="achat w-25" id="defaultDisableAchat" data-toggle="tooltip" data-placement="bottom" title='Veuillez prendre un article avant de commander.'>
					<input onclick='Commande(); AfficheTableau(<?php echo(json_encode($Shop->Infos->Monnaie)); ?>);' type='button' id='commandeBtn' class="btn btn-secondary text-white lx-auto h-75" style="pointer-events: none;" value='Commander' disabled></input>
				</span>
				
				<div class="commande">
					<input onclick='Retour()' type='button' class="btn btn-secondary text-white lx-auto h-75" value='Retour'></input>
				</div>
			</div>
				
			<div class="col justify-content-center mx-4">
				<!-- Nom de l'entreprise -->
				<div class="text-center">
					<a class="navbar-brand text-center mb-0 h1" href="#">
						
						<?php echo($Shop->Infos->Nom_Entreprise); ?>
					</a>
					</br>
				</div>
				
				<div class="achat dropdown text-center" >
				
					<!-- Bouton de la liste d'article -->
					<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="50,100">
						Liste des articles
					</button>
						
					<!-- Liste -->
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<?php
							foreach($Shop->Produits as $produit)
							{
								$id = $Shop->idProd[$produit->nom];
								echo("<button class='dropdown-item' data-toggle='modal' data-target='#article$id'>$produit->nom</button>");
							}
						?>
					</div>
				</div>
			</div>
			
			<!-- Logo -->
			<div class="col text-right">
				<a class="navbar-brand" href="#">
					<img class="logo" src="Logo.png" width="140" height="100" >
				</a>
			</div>
		</div>
	</div>
	
	<!-- Tableau d'articles -->
	<div class="achat">
		<div class='card-group d-flex flex-wrap justify-content-center mb-5'>
			<?php	
				//Affichage des articles dans les card
				foreach($Shop->Produits as $produit)
				{
					$id = $Shop->idProd[$produit->nom];
					$monnaie = $Shop->Infos->Monnaie;
					$prix = $Shop->prix[$id-1];
					$nomArticle[$id] = $Shop->EncoderJSON($produit->nom);
					
					echo("<div class='card border '>
							<div class='card-body' data-toggle='modal' data-target='#article$id'>
								<h5 class='card-title text-center'>$produit->nom</h5>
								<div class='d-flex'>
									<img class='img-thumbnail align-middle' src='$produit->img_path' alt='$produit->nom'>
									<div class='d-flex justify-content-center'>
										<p class='description pt-4 ml-2'>$produit->description</p>
									</div>
								</div>
							</div>
							<div class='card-footer'>
								<div class='mt-2 h6 float-left'>
									$prix$monnaie
								</div>
								<div class='float-right'>
									<input onclick='AcheterArticle(Acheterimg$id, $id, recap$id, $prix, $nomArticle[$id])' type='button' value='Acheter' class='btn btn-primary text-right' id='Acheterimg$id' style='display: block;'></input>
									<div class='countAchat$id' style='display: none;'>
										<div class='d-flex flex-row'>
											<input onclick='MoinsArticle(Acheterimg$id, $id, recap$id, $prix, $nomArticle[$id])' type='button' value='-' class='btn btn-primary text-right' id='btn-' style='display: block;'></input>
											<p class='h6 px-2 mt-2' id='recap$id'></p>
											<input onclick='PlusArticle($id, recap$id, $prix, $nomArticle[$id])' type='button' value='+' class='btn btn-primary text-right' id='btn+' style='display: block;'></input>
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
		//Affichage des modal pour la description des articles
		foreach($Shop->Produits as $produit)
		{
			$id = $Shop->idProd[$produit->nom];
			
			echo("<div class='modal fade' id='article$id' tabindex='-1' role='dialog' aria-labelledby='articleLabel' aria-hidden='true'>
					<div class='modal-dialog' role='document'>
						<div class='modal-content'>
							<div class='modal-header'>
								<h5 class='modal-title' id='articleLabel'>$produit->nom</h5>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
								</button>
							</div>
							<div class='modal-body'>
								$produit->description
							</div>
						</div>
					</div>
				</div>");
		}
	?>

	<div class="commande">
		<div class="d-flex flex-wrap bd-highlight flex-column mx-4 my-4 pb-4">
			<div class="row">
			
				<!-- Tableau de récapitulatif des articles choisis -->
				<div class="col-xl-4 flex-fill bd-highlight mb-5">
					<table id="Commande" class="table table-bordered table-dark" width="100%"></table>
				</div>
				
				<!-- Choix de la date et des horaires -->
				<div class="col-xl-4 flex-fill bd-highlight text-center mb-5">
					Choisisez une date puis une heure
					<div class="dropdown">
						
						<!-- Bouton du dropdown pour choisir le jour -->
						<button class="btn btn-secondary dropdown-toggle" id="dropdownDate" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Choisir le jour
						</button>
						
						<!-- Intérieur du dropdown -->
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<?php
								$nbJoursAffiche = $Shop->Infos->Nombre_Jour_Recup;
								$joursOuvertsKey = array_keys($Shop->Horaires);
								$nbJours = 0;
								$jourSaute = 0;
								$jourActuel = date('N');
								
								while ($nbJours <= $nbJoursAffiche-1)
								{
									if (!empty((array)$Shop->Horaires[$joursOuvertsKey[$jourActuel-1]]))
									{
										$dateJour = date('d-m-Y', strtotime('+'.$nbJours+$jourSaute.' day'));
										$dateJS = new DateTime($dateJour);
										$dateJS = $Shop->EncoderJSON($dateJS->format('d-m-Y'));
										echo("<button class='dropdown-item' onclick='DateSelect($dateJS,$nbJours);'>$dateJour</button>");
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
					<div class="btn-group btn-group-toggle btn-group-justified" id='BoutonsSelectHeure' data-toggle='buttons'>
						
						<!-- Affichage des horaires -->
						<div class="container">
							<?php
								$nbBouton = 1;
								foreach($Shop->HeuresJours as $heures)
								{
									echo("<div class='justify-content-center row row-cols-4 mt-3' id='lotBouton$nbBouton' style='display: none;'>");
									foreach($heures as $heure)
									{
										echo("<label class='btn btn-outline-secondary col-sm-2 mx-1 my-1'>
													<input type='radio' name='options' id='option1' autocomplete='off' onclick='ChoixHeure();' value='$heure'> $heure
												</label>");
									}
									$nbBouton++;
									echo("</div>");
								}
							?>
						</div>
					</div>
				</div>
				
				<!-- Formulaire -->
				<div class="col-xl-4 flex-fill bd-highlight">
					<div class="text-center border bg-warning mb-2">
						<u><p class="h3 text-decoration" id="PrixTotal"></p></u>
					</div>
					<form id="FormInfosClient" autocomplete="off" onsubmit="return RetourData()">
						<div class="form-group">
							<label for="Nom">Nom:</label>
							<input type="text" class="form-control" name="NomClient" required>
						</div>
						<div class="form-group">
							<label for="Prenom">Prénom:</label>
							<input type="text" class="form-control" name="PrenomClient" required>
						</div>
						<div class="form-group">
							<label for="Numero">Numéro de téléphone:</label>
							<input type="tel" pattern="[0-9]+" title="Numéro de téléphone." class="form-control" name="NumeroClient" required>
						</div>
						<div class="form-group">
							<label for="Email">Email:</label>
							<input type="email" class="form-control" name="EmailClient" required>
						</div>
						<div class="d-flex flex-row-reverse">
							<span id="defaultDisableConfirmer" data-toggle="tooltip" data-placement="top" title="Veuillez compléter le captcha avant.">
								<button type="submit" class="btn btn-primary" style="pointer-events: none;" id='BtnConfirmer' disabled>Confirmer</button>
							</span>
						</div>
					</form>
					
					<!-- Captcha -->
					<form class="mt-3" action="PHP/fonctions.php" id="FormCaptcha" autocomplete="off" method="post" target="captcha">
						<span id="defaultDisableCaptcha" data-toggle="tooltip" data-placement="top" title="Veuillez choisir une date avant.">
							<button type="submit" class="btn btn-primary" style="pointer-events: none;" id='BtnCaptcha' disabled>Captcha</button>
						</span>
						<input type="text" placeholder="Captcha" class='mx-3' name="captcha"/>
						<?php echo('<img src="data:image/png;base64,'.base64_encode($Captcha->CreateCaptcha()).'" alt="captcha" style="cursor:pointer;">'); ?>
					</form>
					
					<iframe name="captcha" frameborder="0" height="40vh" width="400vw"></iframe>
					<p id='retour'> </p>
					
				</div>
			</div>	
		</div>
	</div>
	<!-- Pied de page -->
	<footer class="footer">
		<div class="container ml-2">
			<span class="text-dark"><?php echo($Shop->Infos->Conditions); ?></span>
		</div>
		
		<script type="text/javascript" src="js/jquery-3.5.1.js"></script>
		<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
		<script type="text/javascript" src="DataTables/datatables.min.js"></script>
		<script type="text/javascript" src="js/Shop.js"></script>
	</footer>
</body>
</html>