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
		public $intervalle;
		
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
			
			if (strpos($this->Horaires['Intervalle'], 'H'))
			{
				if (strpos($this->Horaires['Intervalle'], 'M'))
				{
					$minutes = substr($this->Horaires['Intervalle'], strpos($this->Horaires['Intervalle'], 'H')+1, 2);
					$heures = substr($this->Horaires['Intervalle'], 0, strpos($this->Horaires['Intervalle'], 'H')+1);
					$this->intervalle = $heures*60+$minutes;
				}
				else
				{
					$this->intervalle = substr_replace($this->Horaires['Intervalle'], '', -1, 1);
					$this->intervalle *= 60;
				}
			}
			else
			{
				if (strpos($this->Horaires['Intervalle'], 'M'))
				{
					$this->intervalle = substr_replace($this->Horaires['Intervalle'], '', -1, 1);
				}
				else
				{
					$this->intervalle = 60;
				}
			}
		}
		
		public function EncoderJSON($retour)
		{
			return(json_encode($retour));
		}
		
		public function GetKeys($retour)
		{
			return(array_keys($retour));
		}
		
		public function DateJour()
		{
			return(date('N'));
		}
		
	}
?>