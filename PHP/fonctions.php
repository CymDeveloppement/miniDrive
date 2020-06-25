<?php
	session_start();
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	if(isset($_POST['retour']))
	{
		$Shop = new shop();
		$retour = new emailer($_POST['retour'], $Shop->Infos);
		$retour->CreateMail();
	}
	
	if(isset($_POST['captcha']))
	{
		if($_POST['captcha']==$_SESSION['code'])
		{
			echo "Code correct";
			echo("<script type='text/javascript'>parent.AfficherBtnConfirmer();</script>");
		} 
		else 
		{
			echo "Code incorrect";
		}
	}
	
	class emailer
	{
		private $Host;
		private $Port;
		private $Username;
		private $Pass;
		private $Destinataire;
		private $Emplacement;
		private $commande = [];
		private $total;
		private $date;
		private $heure;
		private $prenomClient;
		private $nomClient;
		private $telClient;
		private $emailClient;
		
		function __construct($data, $infos)
		{
			$this->Host = $infos->SMTP;
			$this->Port = $infos->Port;
			$this->Username = $infos->Email_Server;
			$this->Pass = $infos->Mdp;
			$this->Destinataire = $infos->Email;
			$this->Emplacement = $infos->Emplacement_Mail_Html;
			
			foreach ($data as $key => $value) 
			{
				$this->{$key} = $value;
			}
		}
		
		public function CreateMail()
		{
			require 'vendor/autoload.php';

			$mail = new PHPMailer(TRUE);
			try {
				$mail->isSMTP();
				//$mail->SMTPDebug = 1;

				$mail->Host = $this->Host;
				
				$mail->Port = $this->Port;

				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

				$mail->SMTPAuth = true;
				$mail->Username   = $this->Username;
				$mail->Password   = $this->Pass;

				$mail->setFrom($this->Username);
				$mail->addAddress($this->Destinataire);
				
				if ($this->Emplacement != "" && file_exists($this->Emplacement))
				{
					$mail->isHTML(true);
					ob_start();
					include 'mailAff.php';
					$myvar = ob_get_clean();
					$mail->Body = $myvar;
				}
				else
				{
					$mail->Body = "Le fichier html n'existe pas ou le chemin n'est pas le bon";
				}
				$mail->Subject = 'Commande ';
				
				$mail->send();
				echo 'Message has been sent';
			} 
			catch (Exception $e) 
			{
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
		}
	}
	
	class generateur_de_vue
	{
		function __construct($page)
		{
			
		}
	}
	
	class captcha
	{
		private function hexargb($hex) 
		{
			return array("r"=>hexdec(substr($hex,0,2)),"g"=>hexdec(substr($hex,2,2)),"b"=>hexdec(substr($hex,4,2)));
		}
		
		public function CreateCaptcha()
		{
			$largeur=80;
			$hauteur=25;
			$lignes=10;
			$caracteres="ABCDEFGHIJKLMNOP123456789";
			$image = imagecreatetruecolor($largeur, $hauteur);
			imagefilledrectangle($image, 0, 0, $largeur, $hauteur, imagecolorallocate($image, 255, 255, 255));
				
			for($i=0;$i<=$lignes;$i++)
			{
				$rgb=$this->hexargb(substr(str_shuffle("ABCDEF0123456789"),0,6));
				imageline($image,rand(1,$largeur-25),rand(1,$hauteur),rand(1,$largeur+25),rand(1,$hauteur),imagecolorallocate($image, $rgb['r'], $rgb['g'], $rgb['b']));
			}
			$code1=substr(str_shuffle($caracteres),0,4);
			$_SESSION['code']=$code1;
			$code="";
			for($i=0;$i<=strlen($code1);$i++)
			{
				$code .=substr($code1,$i,1)." ";
			}
			imagestring($image, 5, 10, 5, $code, imagecolorallocate($image, 0, 0, 0));
			
			ob_start();
			imagepng($image);
			$imgData=ob_get_clean();
			imagedestroy($image);
			
			return($imgData);
		}
	}
	
	class produit
	{
		function __construct($data,$id)
		{
			$this->id = $id;
			foreach ($data as $key => $value) 
			{
				$this->{$key} = $value;
			}
		}
	}

	class horaire
	{
		function __construct($data)
		{
			$id = 0;
			foreach ($data as $key => $value) 
			{
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
		public $Intervalle;
		public $HeuresJours = [];
		
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
			
			// Appel la fonction pour transformer les horaires en minutes
			foreach ($this->Horaires as $keyHoraires => $listesHoraires)
			{
				foreach($listesHoraires as $keyListesHoraires => $horairesACalculer)
				{
					$this->Horaires[$keyHoraires]->$keyListesHoraires = $this->CalculeIntervalEnMinute($horairesACalculer);
				}
			}
			$this->CalculeHeuresJours($this->Horaires);
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
		
		private function CalculeHeuresJours($heures)
		{
			$count = 1;
			foreach ($this->Horaires as $jours)
			{
				$this->HeuresJours[$count] = [];
				for ($i = 0; $i < count(get_object_vars($jours)); $i+=2)
				{
					$id = "id"."$i";
					$idPlusUn = 'id'.($i+1);
										
					$heureCompt = ($jours->$id);
					
					while($heureCompt <= $jours->$idPlusUn)
					{
						if($heureCompt%60 == 0)
						{
							$heureAffiche = intdiv($heureCompt,60)."H00";
						}
						else
						{
							$heureAffiche = intdiv($heureCompt,60)."H".$heureCompt%60;
						}
						
						array_push($this->HeuresJours[$count],($heureAffiche));
						$heureCompt += $this->Infos->Intervalle;
					}
				}
				$count++;
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