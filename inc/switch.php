<?php
	switch($_GET['page'])
	{
		case ('about') 				    		: require'about.php' ;break;
		case ('author') 						: require'author.php' ;break;
		case ('categories') 					: require'categories.php' ;break;
		case ('profile') 						: require'profile.php' ;break;
		case ('settings') 			    		: require'settings.php' ;break;
		case ('users') 							: require'users.php' ;break;
		case ('books') 							: require'books.php' ;break;				
	 default : require'main.php' ;break;
	 }
?>