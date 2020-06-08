<?php
	class shop
	{
		public $Produits;
		public $Infos;
		public $Horaires;
		public $idProd;
		public $prix;
		public $monnaie;
		public $Jours;
		
		private $i;
		
		function __construct() 
		{
			$all = file_get_contents("config.json", true);
			$all = json_decode($all, true);
			foreach ($all as $row => $innerArray)
			{
				$this->{$row} = $innerArray; 
			}
			$this->monnaie = $this->Infos['Monnaie'];
			$this->prix = [];
			$this->i = 1;
			foreach ($this->Produits as $produit)
			{
				$this->idProd[$produit['nom']] = $this->i++;
				array_push($this->prix, substr_replace($produit['prix'], '.', -2, 0));
			}
		}
		
		public function EncoderJSON($retour)
		{
			return(json_encode($retour));
		}
	}
?>