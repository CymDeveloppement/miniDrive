
arrayCommande = {};
arrayPrix = {};
arrayProduit = {};
var selectedDate;
var selectedHeure;

function AcheterArticle(button, num, idProduit, prix, nom)
{
	var countAchats = document.querySelectorAll(".countAchat"+num);
	button.style.display = "none";
	for (var achatButton of countAchats)
	{
		achatButton.style.display = "block";
	}
	idProduit.textContent = 1;
	arrayCommande[idProduit.id] = 1;
	arrayPrix[idProduit.id] = (Math.round(prix * 100) / 100).toFixed(2);
	arrayProduit[idProduit.id] = nom;
	if(Object.keys(arrayProduit).length !== 0)
	{
		$('#commandeBtn').prop('disabled', false);
		$('#commandeBtn').attr('title', "");
	}
}
			
function PlusArticle(num, idProduit, prix, nom)
{
	var countNum = parseInt(idProduit.textContent, 10);
	var countAchats = document.querySelectorAll(".countAchat"+num);
		
	idProduit.textContent = countNum + 1;
	arrayCommande[idProduit.id] = countNum + 1;
	arrayPrix[idProduit.id] = (Math.round(prix * 100) / 100).toFixed(2);
	arrayProduit[idProduit.id] = nom;
}
			
function MoinsArticle(button, num, idProduit, prix, nom)
{
	var countNum = parseInt(idProduit.textContent, 10);
	var countAchats = document.querySelectorAll(".countAchat"+num);
				
	if (idProduit.textContent == 1)
	{
		idProduit.textContent = 0;
		button.style.display = "block";
		for (var achatButton of countAchats)
		{
			achatButton.style.display = "none";
		}
		
		delete arrayCommande[idProduit.id];
		delete arrayPrix[idProduit.id];
		delete arrayProduit[idProduit.id];
		if(Object.keys(arrayProduit).length === 0)
		{
			$('#commandeBtn').prop('disabled', true);
			$('#commandeBtn').attr('title', "Veuillez prendre un article avant de commander.");
		}
	}
	else
	{
		idProduit.textContent = countNum - 1;
		
		arrayCommande[idProduit.id] = countNum - 1;
		arrayPrix[idProduit.id] = (Math.round(prix * 100) / 100).toFixed(2);
		arrayProduit[idProduit.id] = nom;
	}
}

function CacherNb(num)
{
	var nb = parseInt(num);
	for (var i = 1; i <= nb; i++)
	{
		var countAchats = document.querySelector(".countAchat"+i);
		countAchats.style.display = "none";
	}
}
	
function CountCommande()
{
	return(arrayCommande);
}
	
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

function AfficheTableau(monnaie)
{
	var dataSet = [];
	var total = 0;
	for (var objet of Object.keys(arrayCommande))
	{
		total += arrayPrix[objet]*arrayCommande[objet];
		dataSet.push([ arrayProduit[objet], String(arrayPrix[objet])+monnaie, arrayCommande[objet], String((Math.round(arrayPrix[objet]*arrayCommande[objet]* 100) / 100).toFixed(2))+monnaie ]);
	}
	dataSet.push([ "/", "/", "/", String((Math.round(total* 100) / 100).toFixed(2))+ monnaie ]);
	
	$(document).ready(function() {
		$('#Commande').DataTable( {
		"order": [[ 3, "asc" ]],
		data: dataSet,
			columns: [
				{ title: "Produits" },
				{ title: "Prix" },
				{ title: "Quantité" },
				{ title: "Total" },
			]
		} );
	} );
	document.getElementById("PrixTotal").innerHTML = "Total a payer: "+String((Math.round(total* 100) / 100).toFixed(2))+ monnaie;
}

function DateSelect(date)
{
	var elem = document.getElementById('dropdownDate');
	elem.textContent = date;
	selectedDate = date;
	
	date = new Date(date.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")); 
	AfficherBtnHeures(date.getDay());
}

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

function CacherBtnHeure()
{
	for(var lotBoutons of document.querySelectorAll('*[id^="lotBouton"]'))
	{
		lotBoutons.style.display = "none";
	}
}

function ChoixHeure()
{
	selectedHeure = $('#BoutonsSelectHeure input:radio:checked').val();
	$('#BtnCaptcha').prop('disabled', false);
	$('#BtnCaptcha').tooltip('disable');
}

function RetourData()
{
	var retour = {}
	retour.prix = Object.values(arrayPrix);
	retour.quantite = Object.values(arrayCommande);
	retour.nom = Object.values(arrayProduit);
	retour.date = selectedDate;
	retour.heure = selectedHeure;
	
	var FormInfosClient = document.getElementById('FormInfosClient');
	var data = new FormData(FormInfosClient);
	
	retour.prenomClient = data.get("PrenomClient");
	retour.nomClient = data.get("NomClient");
	retour.numeroClient = data.get("NumeroClient");
	retour.emailClient = data.get("EmailClient");
	
	$(document).ready(function(){
		$.ajax({
			url : "PHP/Retour.php",
			type: "POST",
			data : {"retour" : retour},
			success: function(response){
                    document.getElementById("retour").innerHTML = response;
                }
		});
	});
	return false;
}

function AfficherBtnConfirmer()
{
	document.getElementById("FormCaptcha").style.display = "none";
	$('#BtnConfirmer').prop('disabled', false);
	$('#BtnConfirmer').tooltip('disable');
}


