
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
		
		function getProduits()
		{
			return($this->Produits);
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
			$i = 0;
			$retour = "";
			
			foreach($this->Produits as $row => $produit)
			{
				$i++;
				$newString[$i] = str_replace(" ","",$produit['nom']);
				$retour .= "<a class='dropdown-item' data-toggle='modal' data-target='#exampleModal$newString[$i]'>$produit[nom]</a>";
			}
			return($retour);
		}
		
		function getConditions()
		{
			return($this->Infos['Conditions']);
		}
		
		function getHorraire()
		{
			return($this->Horaires);
		}
	}
?>