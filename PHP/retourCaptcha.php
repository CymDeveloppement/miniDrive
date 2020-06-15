<?php
	session_start();
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
?>