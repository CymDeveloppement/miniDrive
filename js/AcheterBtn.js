
arrayCommande = {};
arrayPrix = {};
function AcheterArticle(button, num, nom, prix)
{
	var countAchats = document.querySelectorAll(".countAchat"+num);
	button.style.display = "none";
	for (var achatButton of countAchats)
	{
		achatButton.style.display = "block";
	}
	nom.textContent = 1;
	arrayCommande[nom.id] = 1;
	arrayPrix[nom.id] = prix;
}
			
function PlusArticle(num, nom, prix)
{
	var countNum = parseInt(nom.textContent, 10);
	var countAchats = document.querySelectorAll(".countAchat"+num);
		
	nom.textContent = countNum + 1;
	arrayCommande[nom.id] = countNum + 1;
	arrayPrix[nom.id] = prix;
}
			
function MoinsArticle(button, num, nom, prix)
{
	var countNum = parseInt(nom.textContent, 10);
	var countAchats = document.querySelectorAll(".countAchat"+num);
				
	if (nom.textContent == 1)
	{
		nom.textContent = 0;
		button.style.display = "block";
		for (var achatButton of countAchats)
		{
			achatButton.style.display = "none";
		}
		
		delete arrayCommande[nom.id];
		delete arrayPrix[nom.id];
	}
	else
	{
		nom.textContent = countNum - 1;
		arrayCommande[nom.id] = countNum - 1;
		arrayPrix[nom.id] = prix;
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

function AfficheTableau()
{
	var dataSet = [];
	var total = 0;
	for (var objet of Object.keys(arrayCommande))
	{
		total += arrayPrix[objet]*arrayCommande[objet];
		dataSet.push([ objet.replace(/___/g, " "), String(arrayPrix[objet])+"€", arrayCommande[objet], String(arrayPrix[objet]*arrayCommande[objet])+"€" ]);
	}
	dataSet.push([ "/", "/", "/", String(total)+"€" ]);
	
	$(document).ready(function() {
		$('#Commande').DataTable( {
		"pageLength": 5,
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
}

function DateSelect(date)
{
	 var elem = document.getElementById('dropdownDate');
	 elem.textContent = date;
}





