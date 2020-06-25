
Produits = {};

var selectedDate; // Variable contenant la date choisie par le client.
var selectedHeure; // Variable contenant l'heure choisie par le client.
var montantTotal; // Variable contenant le montant de la commande

// Activation des tooltips de bootstrap.
$(function () 
{
	$('[data-toggle="tooltip"]').tooltip()
});


// Fonction du bouton "Acheter" sous chaque article.
function AcheterArticle(button, num, produit, prix, nom)
{
	var countAchats = document.querySelectorAll(".countAchat"+num);
	
	button.style.display = "none";
	for (var achatButton of countAchats)
	{
		achatButton.style.display = "block";
	}
	produit.textContent = 1;
	
	Produits[produit.id] = {"Nom":nom, "Qte":1, "Prix":(Math.round(prix * 100) / 100).toFixed(2)};
	
	if(Object.keys(Produits).length !== 0)
	{
		$('#defaultDisableAchat').tooltip('disable');
		$('#commandeBtn').prop('disabled', false);
		document.getElementById("commandeBtn").style.pointerEvents = "all";
	}
}
		
// Fonction du bouton "+" sous chaque article.
function PlusArticle(num, produit, prix, nom)
{
	var countNum = parseInt(produit.textContent, 10);
	var countAchats = document.querySelectorAll(".countAchat"+num);
	
	produit.textContent = countNum + 1;
	
	Produits[produit.id] = {"Nom":nom, "Qte":countNum + 1, "Prix":(Math.round(prix * 100) / 100).toFixed(2)};
}
			
// Fonction du bouton "-" sous chaque article.
function MoinsArticle(button, num, produit, prix, nom)
{
	var countNum = parseInt(produit.textContent, 10);
	var countAchats = document.querySelectorAll(".countAchat"+num);
				
	if (produit.textContent == 1)
	{
		produit.textContent = 0;
		button.style.display = "block";
		for (var achatButton of countAchats)
		{
			achatButton.style.display = "none";
		}
		
		delete Produits[produit.id];
		if(Object.keys(Produits).length === 0)
		{
			$('#defaultDisableAchat').tooltip('enable');
			$('#commandeBtn').prop('disabled', true);
			document.getElementById("commandeBtn").style.pointerEvents = "none";
		}
	}
	else
	{
		produit.textContent = countNum - 1;
		
		Produits[produit.id] = {"Nom":nom, "Qte":countNum - 1, "Prix":(Math.round(prix * 100) / 100).toFixed(2)};
	}
}
	
// Fonction qui cache le bouton qui redirige vers le récapitulatif de la commande.
function Commande()
{
	var DesacAchats = document.querySelectorAll(".achat");
	for (var DesacAchat of DesacAchats)
	{
		DesacAchat.style.display = "none";
	}
	
	var ActCommandes = document.querySelectorAll(".commande");
	for (var ActCommande of ActCommandes)
	{
		ActCommande.style.display = "block";
	}
}

// Fonction qui cache le bouton qui redirige vers la page d'achat.
function Retour()
{
	var table = $('#Commande').DataTable();
	var ActCommandes = document.querySelectorAll(".commande");
	for (var ActCommande of ActCommandes)
	{
		ActCommande.style.display = "none";
	}
	
	var DesacAchats = document.querySelectorAll(".achat");
	for (var DesacAchat of DesacAchats)
	{
		DesacAchat.style.display = "block";
	}
	table.destroy();
}

// Fonction qui affiche le tableau d'articles commandé.
function AfficheTableau(monnaie)
{
	var dataSet = [];
	montantTotal = 0;
	var totalQte = 0;
	
	for (var id in Produits)
	{
		montantTotal += Produits[id].Prix*Produits[id].Qte;
		totalQte += Produits[id].Qte;
		Produits[id].PrixQte = (Math.round(Produits[id].Prix*Produits[id].Qte* 100) / 100).toFixed(2);
		dataSet.push([ Produits[id].Nom, String(Produits[id].Prix)+monnaie, Produits[id].Qte, String((Math.round(Produits[id].Prix*Produits[id].Qte* 100) / 100).toFixed(2))+monnaie ]);
	}
	dataSet.push([ "Total à payer", "/", "Total articles: "+totalQte, String((Math.round(montantTotal* 100) / 100).toFixed(2))+ monnaie ]);
	
	$(document).ready(function() {
		$('#Commande').DataTable( {
			"createdRow": function(row, data, dataIndex){
			if(data[0] == "Total à payer"){
				$(row).addClass('text-dark font-weight-bold h5 bg-warning');
			}
		},
		"order": [[ 3, "desc" ]],
		data: dataSet,
			columns: [
				{ title: "Produits" },
				{ title: "Prix" },
				{ title: "Quantité" },
				{ title: "Total" },
			]
		} );
	} );
	document.getElementById("PrixTotal").innerHTML = "Total à payer: "+String((Math.round(montantTotal* 100) / 100).toFixed(2))+ monnaie;
}

// Fonction qui gère le choix de la date.
function DateSelect(date)
{
	var elem = document.getElementById('dropdownDate');
	elem.textContent = date;
	selectedDate = date;
	
	date = new Date(date.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")); 
	AfficherBtnHeures(date.getDay());
}

// Fonction qui affiche les heures correspondantes à la date choisie.
function AfficherBtnHeures(nb)
{
	var i = 1;
	while (i < nb)
	{
		var lotBouton = document.getElementById("lotBouton"+i);
		lotBouton.style.display = "none";
		i++;
	}
	lotBouton = document.getElementById("lotBouton"+i);
	lotBouton.style.display = "block";
	i++;
	while (i > nb && i < 7)
	{
		lotBouton = document.getElementById("lotBouton"+i);
		lotBouton.style.display = "none";
		i++;
	}
}

// Fonction qui s'occupe du choix de l'heure.
function ChoixHeure()
{
	selectedHeure = $('#BoutonsSelectHeure input:radio:checked').val();
	$('#BtnCaptcha').prop('disabled', false);
	$('#defaultDisableCaptcha').tooltip('disable');
	document.getElementById("BtnCaptcha").style.pointerEvents = "all";
}

// Fonction qui récupère les valeurs entrées par le client et les produits choisis pour les envoyer au php.
function RetourData()
{
	var retour = {}
	
	retour.commande = Produits;
	
	retour.date = selectedDate;
	retour.heure = selectedHeure;
	retour.total = montantTotal.toFixed(2);
	
	var FormInfosClient = document.getElementById('FormInfosClient');
	var data = new FormData(FormInfosClient);
	
	retour.prenomClient = data.get("PrenomClient");
	retour.nomClient = data.get("NomClient");
	retour.telClient = data.get("NumeroClient");
	retour.emailClient = data.get("EmailClient");
	
	$(document).ready(function(){
		$.ajax({
			url : "PHP/fonctions.php",
			type: "POST",
			data : {"retour" : retour},
			success: function(response){
                    document.getElementById("retour").innerHTML = response;
                }
		});
	});
	return false;
}

// Fonction qui cache le captcha quand il est validé et qui active le boutton confirmé.
function AfficherBtnConfirmer()
{
	document.getElementById("FormCaptcha").style.display = "none";
	$('#BtnConfirmer').prop('disabled', false);
	$('#defaultDisableConfirmer').tooltip('disable');
	document.getElementById("BtnConfirmer").style.pointerEvents = "all";
}



