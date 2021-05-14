<?php

	$db=mysqli_connect("localhost","root","","library"); /*servername, username, password, db name*/

if(!$db)
{
	die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

?>