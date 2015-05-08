<?php
	session_start();
	// ini_set('display_errors', 1);
	$mysqli = new mysqli(/**/);
	if ($mysqli->connect_errno) {
		echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$res = $mysqli->query("CREATE TABLE ".$_POST["gname"]."
							AS
							SELECT *
							FROM defaultGraph
							WHERE 1 = 0;");
							
	if ($res == 1)
	{
		$res = $mysqli->query("ALTER TABLE  ".$_POST["gname"]." ADD PRIMARY KEY (  `ID` ) ;");
		$res = $mysqli->query("ALTER TABLE  ".$_POST["gname"]." CHANGE  ID  ID INT( 11 ) NOT NULL AUTO_INCREMENT;");
	}
	$_SESSION["lastTab"] = $_POST["gname"];
	echo $res;
?>