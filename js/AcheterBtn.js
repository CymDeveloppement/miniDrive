function AcheterArticle(button, num)
{
	var countAchats = document.querySelectorAll(".countAchat"+num);
	button.style.display = "none";
	for (var achatButton of countAchats)
	{
		achatButton.style.display = "block";
	}
	document.getElementById("counter"+num).textContent = 1;
}
		
function PlusArticle(num)
{
	var countNum = parseInt(document.getElementById("counter"+num).textContent, 10);
	var countAchats = document.querySelectorAll(".countAchat"+num);
	
	document.getElementById("counter"+num).textContent = countNum + 1;
}
		
function MoinsArticle(button, num)
{
	var countNum = parseInt(document.getElementById("counter"+num).textContent, 10);
	var countAchats = document.querySelectorAll(".countAchat"+num);
			
	if (document.getElementById("counter"+num).textContent == 1)
	{
		document.getElementById("counter"+num).textContent = 0;
		button.style.display = "block";
		for (var achatButton of countAchats)
		{
			achatButton.style.display = "none";
		}
	}
	else
	{
		document.getElementById("counter"+num).textContent = countNum - 1;
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

