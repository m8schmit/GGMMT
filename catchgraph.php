<?php
	// ini_set('display_errors', 1);
	$dataTable = NULL;
	$mysqli = new mysqli(/**/);
	if ($mysqli->connect_errno) {
		echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$res = $mysqli->query("	SELECT * 
							FROM ".$_POST['gname']."
							LIMIT 0 , 1000");
	$flag = 0;
	while ($row = $res->fetch_assoc()) {
		if ($flag == 0)  {
			$dataTable .= "<li style=\"background-color: lightgray;\"><INPUT type=\"checkbox\" name='".$row['ID']."' >Titre activité : '".$row['activity']."', Début : '".$row['Hbegin'].":".$row['Mbegin'].":".$row['Sbegin']."',  Fin : '".$row['Hend'].":".$row['Mend'].":".$row['Send']."'</li>";
			$flag = 1;
		}
		else {
			$dataTable .= "<li><INPUT type=\"checkbox\" name='".$row['ID']."' >Titre activité : '".$row['activity']."', Début : '".$row['Hbegin'].":".$row['Mbegin'].":".$row['Sbegin']."',  Fin : '".$row['Hend'].":".$row['Mend'].":".$row['Send']."'</li>";
			$flag = 0;
		}
	}	
	echo utf8_encode($dataTable);
?>