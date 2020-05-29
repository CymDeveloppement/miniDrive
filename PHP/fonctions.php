<?php
	function cardProduit()
	{
		// Récupère les informations du fichier produits.ini
		$prod = parse_ini_file("produits.ini", true);
		foreach ($prod as $row => $innerArray)
		{
			$c = sizeof($innerArray);
			switch ($row) {
				case "nom_produits":
					$nomProd = $innerArray;
					break;
				case "img_path":
					$imgPath = $innerArray;
					break;
				case "prix":
					$prix = $innerArray;
					break;
			}
		}
		for ($i = 1; $i <= $c; $i++)
		{
			$prod = 'prod'.$i;
			$img = 'img'.$i;
			$pri = 'prix'.$i;
			echo("<div class='card border'>
					<div class='card-body'>
						<h5 class='card-title text-center'>$nomProd[$prod]</h5>
						<img class='img-thumbnail align-middle' src='$imgPath[$img]'>
						</br>			
					</div>
					<div class='card-footer'>
						<div class='mt-2 float-left'>
							Prix: $prix[$pri]
						</div>
						<div class='float-right'>
							<input onclick='' type='button' value='Acheter' class='btn btn-primary text-right' id='myButton$img' style='display: block;'></input>
						</div>
					</div>
				</div>");
		}
	}
?>