<?php
	// ini_set('display_errors', 1);
	session_start();
	$mysqli = new mysqli(/**/);
	if ($mysqli->connect_errno) {
		echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$res = $mysqli->query("SELECT * 
							FROM information_schema.tables
							WHERE TABLE_TYPE =  'BASE TABLE'
							LIMIT 0 , 30");
	while ($row = $res->fetch_assoc()) {
		if ($row['TABLE_NAME'] != "defaultGraph")
		{
			if (!$_SESSION["lastTab"])
				$firstTab = $row['TABLE_NAME'];
			else
				$firstTab = $_SESSION["lastTab"];

			if ($row['TABLE_NAME'] == $firstTab)
				$option .= "<option selected>".$row['TABLE_NAME']."</option>\n";
			else
				$option .= "<option>".$row['TABLE_NAME']."</option>\n";
			$checkbox .= "<li><INPUT type=\"checkbox\" name=".$row['TABLE_NAME'].">".$row['TABLE_NAME']."</li>";
			
			if($row['TABLE_ROWS'] > 0)
					$optionAff .= "<option>".$row['TABLE_NAME'];
		}
	}

?>
<html>
	<head>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="import" href="http://www.polymer-project.org/components/font-roboto/roboto.html">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="headerdiv">
			<h1>Générateur de Graphiques montrant la Multitâche.(GGMMT)</h1>
		</div>
		<center>
		<div style="float:left;">
			<div class="primaryDiv">
				<h1>Sélectionner un tableau à afficher :</h1>
				<form action="showgraph.php" method="post">
					<?php 
						if ($optionAff)
							echo "<select name=\"graphName\">
										".$optionAff."
									</select>
									<input class=\"Button\" type=\"submit\" value=\"OK\">";
						else
							echo "Aucun graphique à afficher."
					?>
					<div id="showTableRes"></div>
				</form>
			</div>
			<div class="primaryDiv">
				<!-- CREATE TABLE -->
				<h1>Créer, supprimer un tableau  :</h1>
				<h2>Créer :</h2>
				<form action ="" id="createTable">
					<input type="text" id="newTabName" size="25" placeholder="nom du graphique" name="gName" pattern=".{2,}" required>
					<input type="submit" value="OK">
				</form>	
				<div id="createTableRes"></div>
			</div>
			<div class="primaryDiv">
				<!-- ERASE TABLE -->
				<h2>supprimer :</h2>
				<form action ="" id="eraseTable" style="text-align: left;">
					<?php
						if ($checkbox)
							echo "<ul>"
									.$checkbox.
								"</ul>
								<p>
									<input type=\"submit\" value=\"OK\" onclick=\"return(confirm('Etes-vous sûr de vouloir supprimer cette entrée?'));\">
								</p>";
						else
							echo "Aucun graphique à supprimer."
					?>
				</form>
				<div id="eraseTableRes"></div>
			</div>
		</div>
		<div class="primaryDiv" style="float: left;margin-left: 15px;">
			<!-- SELECT TABLE FOR MODIFICATION -->
			<h1>Sélectionner un tableau à modifier :</h1>
			<p>
					<?php 
						if ($option)
							echo "<select onchange=\"choiceTab(this.value)\">
									".$option."
								</select>";
						else
							echo "Aucun graphique à modifier."
					?>	
			</p>
			<!-- ERASE INPUT -->
			<form action="" id="eraseInput">
				<div id="modifTableResSuppr"></div>
			</form>
			<div id="eraseInputRes"></div>
			<!-- ADD INPUT -->
			<form action="" id="addInput">
				<div id="modifTableResAdd"></div>
			</form>
			<div id="addInputRes"></div>
		</div>
		<div id="tabToModifName" style="display: none;"></div>
		<div class="footerdiv">
			<h6>schmit.michel.fr@gmail.com - v1.0.2</h6>
		</div>
	</body>
	<footer>
		<script type="text/javascript" src="fct-graph.js"></script>
		<script>
			$( document ).ready(function() {
				choiceTab("<?php echo $firstTab ?>");
			});
		</script>
	</footer>
</html>