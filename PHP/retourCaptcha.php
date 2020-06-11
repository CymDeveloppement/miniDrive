<?php
	session_start();
	if(isset($_POST['captcha']))
	{
		if($_POST['captcha']==$_SESSION['code'])
		{
			echo "Code correct";
		} 
		else 
		{
			echo "Code incorrect";
		}
	}
?>