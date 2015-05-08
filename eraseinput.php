<?php
	$mysqli = new mysqli(/**/);
	if ($mysqli->connect_errno) {
		echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$request = "DELETE FROM ".$_POST['gname']." WHERE ID in (";
	$i = 0;
	while ($_POST['selected'][$i])
	{
		if($_POST['selected'][$i+1])
			$request .= $_POST['selected'][$i].", ";
		else
			$request .= $_POST['selected'][$i].");";
		$i++;
	}
	$res = $mysqli->query($request);
	echo $res;

?>