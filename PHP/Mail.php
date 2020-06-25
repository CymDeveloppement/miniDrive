<!DOCTYPE html>
<?php
	$Shop = new shop();
?>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<style>
		div.centered 
		{
			text-align: center;
		}

		div.centered table 
		{
			margin: 0 auto; 
			text-align: left;
		}
		.text_center
		{
			text-align: center;
		}
		.bg-dark
		{
			background-color: #343a40;
			color: #ffffff;
		}
		.bg-light
		{
			background-color: #f8f9fa;
			color: #000000;
		}
	</style>
</head>
<body>
	<div class="centered">
		<table>
			<tr class="text_center bg-dark">
				<td class="bg-dark">
					<h1> <?php echo($Shop->Infos->Nom_Entreprise); ?> </h1>
				</td>
			</tr>
			<tr>
				<td>
					<h3>Client: <?php echo("$this->nomClient $this->prenomClient"); ?> </h3>
					<h3>Tel: <?php echo("$this->telClient"); ?> </h3>
					<h3>E-mail: <?php echo("$this->emailClient"); ?> </h3>
					<h3>Pour le: <?php echo("$this->date à $this->heure"); ?> </h3>
					<h1>A commandé:</h1>
					<?php
						foreach($this->commande as $produit)
						{
							echo("<h2>".$produit['Qte']." ".$produit['Nom']." : ".$produit['PrixQte']."€ </h2>");
						}
					?>
					<h1 class="bg-dark centered">Total : <?php echo($this->total."€"); ?> </h1>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>

