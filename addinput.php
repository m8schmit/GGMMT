<?php
	session_start();
// penser a verifier le titre de l'activité en amon et tranformer les heures.
	ini_set('display_errors', 1);
	$mysqli = new mysqli(/**/);
	if ($mysqli->connect_errno) {
		echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$request = "INSERT INTO  `multi-conn`.`".$_POST['gname']."` (
				`ID` ,
				`activity` ,
				`Hbegin` ,
				`Mbegin` ,
				`Sbegin` ,
				`Hend` ,
				`Mend` ,
				`Send`
				) ";
	$request .= "VALUES (
				NULL ,
				'".$_POST['activityTitle']."',
				'".substr($_POST['activityBegin'], 0, 2)."',
				'".substr($_POST['activityBegin'], 3, 2)."',
				'".substr($_POST['activityBegin'], 6, 2)."',
				'".substr($_POST['activityEnd'], 0, 2)."',
				'".substr($_POST['activityEnd'], 3, 2)."',
				'".substr($_POST['activityEnd'], 6, 2)."');";
	$res = $mysqli->query($request);
	$_SESSION["lastTab"] = $_POST["gname"];
	echo $res;
?>