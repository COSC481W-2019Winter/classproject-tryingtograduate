<?php

function confirmPassword($password, $passwordCnf)
{
	if (!strcmp($password, $passwordCnf) == 0)
	{
		echo '<script language="javascript">';
		echo 'alert("Password confirmation does not match.")';
		echo '</script>';
		returnToHomepage();
	}
}

function passwordValidation($password) 
{
	//check if password is proper format
	$lowercase = preg_match('@[a-z]@', $password);
	$uppercase = preg_match('@[A-Z]@', $password);
	$number = preg_match('@[0-9]@', $password);
	
	//if bad password display appropriate message
	if (!(strlen($password)>7))
	{
		echo '<script language="javascript">';
		echo 'alert("Invalid password. Password must have at least 8 characters.")';
		echo '</script>';
	}
	elseif(!$uppercase)
	{
		echo '<script language="javascript">';
		echo 'alert("Invalid password. Password must have at least 1 capital letter.")';
		echo '</script>';
	}
	elseif(!$number)
	{
		echo '<script language="javascript">';
		echo 'alert("Invalid password. Password must have least 1 number.")';
		echo '</script>';
	}
	elseif(!$lowercase)
	{
		echo '<script language="javascript">';
		echo 'alert("Invalid password. Password must have at least 1 lowercase letter.")';
		echo '</script>';
	}
	
	if (!(strlen($password)>7) || !$uppercase || !$number || !$lowercase)
	{
		returnToHomepage();
	}
}

//rerout the user from this php file back to homepage to try again
function returnToHomepage()
{
		echo '<script language="javascript">';
		echo 'window.location.href ="../home"' ;
		echo '</script>';
}

?>