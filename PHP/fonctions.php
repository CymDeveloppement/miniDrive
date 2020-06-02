
<!-- Code JS pour afficher ou non les boutons d'ajout d'articles acheté -->
<script type="text/javascript" src="js/AcheterBtn.js"></script>

<?php
	class shop
	{
		function __construct() 
		{
			$all = file_get_contents("produits.json", true);
			$all = json_decode($all, true);
			foreach ($all as $row => $innerArray)
			{
				$this->{$row} = $innerArray; 
			}
			$countProds = sizeof($this->Produits);
			$countInfos = sizeof($this->Infos);
		}
		
		function getProduitsCard()
		{
			$countProds = sizeof($this->Produits);
			$i = 0;
			$retour = "";
			foreach($this->Produits as $row => $produit)
			{
				$i++;
				$img = 'img'.$i;
				
				$retour.=("<div class='card border'>
							<div class='card-body'>
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
			$retour.='<script type="text/javascript">CacherNb('."$countProds".');</script>';
			return($retour);
		}
		
		function getNomEntreprise()
		{
			return($this->Infos['Nom_Entreprise']);
		}
		
		function getInfo()
		{
			return($this->Infos);
		}
		
		function getProduitsNom()
		{
			$retour = "";
			
			foreach($this->Produits as $row => $produit)
			{
				$retour .= "<a class='dropdown-item' href='#'>$produit[nom]</a>";
			}
			return($retour);
		}
	}
?>