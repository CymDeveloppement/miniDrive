<?php
	class shop
	{
		public $Produits;
		public $Infos;
		public $Horaires;
		public $idProd;
		public $countProds;
		public $countInfos;
		private $i;
		
		function __construct() 
		{
			$all = file_get_contents("config.json", true);
			$all = json_decode($all, true);
			foreach ($all as $row => $innerArray)
			{
				$this->{$row} = $innerArray; 
			}
			$this->countProds = sizeof($this->Produits);
			$this->countInfos = sizeof($this->Infos);
			$this->idProd = array();
			$this->i = 1;
			foreach ($this->Produits as $produit)
			{
				$this->idProd[$produit['nom']] = $this->i++;
			}
		}
	}
?>