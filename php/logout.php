<?php

session_start();

if(isset($_SESSION['id']))
{
	unset($_SESSION['id']);

}

header("Location: /guvi2/login.html");
die;