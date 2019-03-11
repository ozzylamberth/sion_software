<?php
	if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']))
	{
		// include Database connection file
		include("db_connection.php");

		// get values
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$clave = $_POST['clave'];

		$query = "INSERT INTO user(nombre, cuenta, id_perfil, clave) VALUES('$first_name', '$last_name', '$email','$clave')";
		if (!$result = mysql_query($query)) {
	        exit(mysql_error());
	    }
	    echo "1 Record Added!";
	}
?>
