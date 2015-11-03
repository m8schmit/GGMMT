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
							AND TABLE_SCHEMA = 'multi-conn'
							LIMIT 0 , 1000");
	$flag = 0;
	while ($row = $res->fetch_assoc()) {
		if ($row['TABLE_NAME'] != "defaultGraph")
		{
			if (!$_SESSION["lastTab"]) {
				$firstTab = $row['TABLE_NAME'];
				echo ">> ".$firstTab;
			}
			else 
				$firstTab = $_SESSION["lastTab"];

			if ($row['TABLE_NAME'] == $firstTab)
				$option .= "<option selected>".$row['TABLE_NAME']."</option>\n";
			else
				$option .= "<option>".$row['TABLE_NAME']."</option>\n";
			if ($flag == 0) {
				$checkbox .= "<li style=\"background-color: lightgray;\"><INPUT type=\"checkbox\" name=".$row['TABLE_NAME'].">".$row['TABLE_NAME']."</li>";
				$flag = 1;
			}
			else {
				$checkbox .= "<li><INPUT type=\"checkbox\" name=".$row['TABLE_NAME'].">".$row['TABLE_NAME']."</li>";
				$flag = 0;
			}
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
				<h1>Créer, importer, supprimer un tableau  :</h1>
				<h2>Créer :</h2>
				<form action ="" id="createTable">
					<input type="text" id="newTabName" size="25" placeholder="nom du graphique" name="gName" pattern=".{2,}" required>
					<input type="submit" value="OK">
				</form>	
				<div id="createTableRes"></div>
			</div>
							<div class="primaryDiv">
				<!-- IMPORT CSV -->
					<h1>Importer un CSV :</h1>
					<form name="import" method="post" enctype="multipart/form-data">
						<input type="text" id="newTabName" size="25" placeholder="nom du graphique" name="gName" pattern=".{2,}" required><br />
    					<input type="file" name="file" /><br />
       					<input type="submit" name="submit" value="OK" />
					</form>
					<?php
						include ("connection.php");						
						if(isset($_POST["submit"]))
						{
							$file = $_FILES['file']['tmp_name'];
							$Tabname = $_POST['gName'];
							$handle = fopen($file, "r");
							$c = 0;
							while(($filesop = fgetcsv($handle, 1000, ';', ' ')) !== false)
							{
								$name = $filesop[0];
								$begin = $filesop[1];
								$end = $filesop[2];
								$request = "INSERT INTO `$database`.`$Tabname` (
													`ID` ,
													`activity` ,
													`Hbegin` ,
													`Mbegin` ,
													`Sbegin` ,
													`Hend` ,
													`Mend` ,
													`Send`
													)
													VALUES (
													NULL,
													'$name',
													'".substr($begin, 0, 2)."',
													'".substr($begin, 3, 2)."',
													'".substr($begin, 6, 2)."',
													'".substr($end, 0, 2)."',
													'".substr($end, 3, 2)."',
													'".substr($end, 6, 2)."')";
								$sql = mysql_query($request);
								$c = $c + 1;
							}
							if($sql){
								echo "You database has imported successfully. You have inserted ". $c ." recoreds";
								$_SESSION["lastTab"] = $Tabname;
							}else{
								
								echo "Sorry! There is some problem.";
							}
							header(/**/);
						}
					?>
					<!--  -->
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
			<h6>schmit.michel.fr@gmail.com - v1.0.6</h6>
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