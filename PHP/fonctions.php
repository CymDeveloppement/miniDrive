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
			$this->Infos->Intervalle = $this->CalculeIntervalEnMinute($this->Infos->Intervalle);
			
			// Transforme tous les horaires d'ouvertures en minutes.
			foreach ($this->Horaires as $keyHoraires => $listesHoraires)
			{
				foreach($listesHoraires as $keyListesHoraires => $horairesACalculer)
				{
					$this->Horaires[$keyHoraires]->$keyListesHoraires = $this->CalculeIntervalEnMinute($horairesACalculer);
				}
			}
			
			$this->Infos->Nom_Entreprise;
			
			$this->monnaie = $this->Infos->Monnaie;
		}
		
		//Fonction qui transforme les heures donées en minutes.
		private function CalculeIntervalEnMinute($heure)
		{
			if (strpos($heure, 'H'))
			{
				if (strpos($heure, 'M'))
				{
					$minutes = substr($heure, strpos($heure, 'H')+1, 2);
					$heures = substr($heure, 0, strpos($heure, 'H')+1);
					$heure = $heures*60+$minutes;
				}
				else
				{
					$heure = substr_replace($heure, '', -1, 1);
					$heure *= 60;
				}
			}
			else
			{
				if (strpos($heure, 'M'))
				{
					$heure = substr_replace($heure, '', -1, 1);
				}
				else
				{
					$heure *= 60;
				}
			}
			return($heure);
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