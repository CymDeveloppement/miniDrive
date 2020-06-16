<?php
	class produit
	{
		function __construct($data,$id)
		{
			$this->id = $id;
			foreach ($data as $key => $value) {
				$this->{$key} = $value;
			}
		}
	}

	class horaire
	{
		function __construct($data)
		{
			$id = 0;
			foreach ($data as $key => $value) {
				$this->{'id'.$id} = $value;
				$id++;
			}
		}
	}
	
	class info
	{
		function __construct($data)
		{
			foreach($data as $key => $info)
			{
				$this->{$key} = $info;
			}
		}
	}
	
	class shop
	{
		public $Produits = [];
		public $Infos;
		public $Horaires = [];
		public $idProd;
		public $prix = [];
		public $monnaie;
		public $Jours;
		public $intervalle;
		
		function __construct() 
		{
			$all = file_get_contents("config.json", true);
			$all = json_decode($all, true);

			foreach ($all['Produits'] as $key => $produit) 
			{
				$this->Produits[] = new produit($produit, $key);
			}
			
			foreach ($all['Horaires'] as $horaire)
			{
				$this->Horaires[] = new horaire($horaire);
			}
			
			$this->Infos = new info($all['Infos']);
			
			$this->FormatagePrix();
			$this->CalculeIntervalEnMinute();
			$this->Infos->Nom_Entreprise;
			
			$this->monnaie = $this->Infos->Monnaie;
		}
		
		//Fonction qui transforme l'intervalle en minutes.
		private function CalculeIntervalEnMinute()
		{
			if (strpos($this->Infos->Intervalle, 'H'))
			{
				if (strpos($this->Infos->Intervalle, 'M'))
				{
					$minutes = substr($this->Infos->Intervalle, strpos($this->Infos->Intervalle, 'H')+1, 2);
					$heures = substr($this->Infos->Intervalle, 0, strpos($this->Infos->Intervalle, 'H')+1);
					$this->intervalle = $heures*60+$minutes;
				}
				else
				{
					$this->intervalle = substr_replace($this->Infos->Intervalle, '', -1, 1);
					$this->intervalle *= 60;
				}
			}
			else
			{
				if (strpos($this->Infos->Intervalle, 'M'))
				{
					$this->intervalle = substr_replace($this->Infos->Intervalle, '', -1, 1);
				}
				else
				{
					$this->intervalle = 60;
				}
			}
		}
		
		//Fonction qui formate le prix pour séparer les euros et les centimes.
		private function FormatagePrix()
		{
			$i = 1;
			foreach ($this->Produits as $produit)
			{
				$this->idProd[$produit->nom] = $i++;
				array_push($this->prix, substr_replace($produit->prix, '.', -2, 0));
			}
		}
		
		//Fonction qui transforme les variables pour les envoyer au javascript.
		public function EncoderJSON($retour)
		{
			if(is_string($retour))
			{
				$envoie = '"'. $retour .'"';
			}
			else
			{
				$envoie = json_encode($retour);
			}
			return($envoie);
		}
	}
?>