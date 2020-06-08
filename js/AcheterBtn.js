
arrayCommande = {};
arrayPrix = {};
arrayProduit = {};
arrayId = {};

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

function SelectJour()
{
	
}

function DateSelect(date)
{
	 var elem = document.getElementById('dropdownDate');
	 elem.textContent = date;
}





