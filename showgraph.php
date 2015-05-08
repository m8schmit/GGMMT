<?php
	// ini_set('display_errors', 1);
	$dataTable = NULL;
	$mysqli = new mysqli(/**/);
	if ($mysqli->connect_errno) {
		echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$res = $mysqli->query("	SELECT * 
							FROM ".$_POST['graphName']."
							LIMIT 0 , 100");
	while ($row = $res->fetch_assoc()) {
		$dataTable .= "dataTable.addRows([[ '".$row['activity']."', '', new Date(0,0,0,".$row['Hbegin'].",".$row['Mbegin'].",".$row['Sbegin']."),  new Date(0,0,0,".$row['Hend'].",".$row['Mend'].",".$row['Send'].") ]]);";
	}	
?>
<html>
	<head>
		<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['timeline']}]}"></script>
		<script type="text/javascript">
			google.setOnLoadCallback(drawChart);
			function drawChart() {
				var container = document.getElementById('multi-conn');
				var chart = new google.visualization.Timeline(container);
				var dataTable = new google.visualization.DataTable();
				dataTable.addColumn({ type: 'string', id: 'Room' });
				dataTable.addColumn({ type: 'string', id: 'Name' });
				dataTable.addColumn({ type: 'date', id: 'Start' });
				dataTable.addColumn({ type: 'date', id: 'End' });
		  
				<?php echo $dataTable ?>
				var options = {
					timeline: { colorByRowLabel: true },
					backgroundColor: '#fff',
					hAxis: { format: 'H:mm:ss' }
				};
						
				chart.draw(dataTable, options);
			}
		</script>
	</head>
	<body>
		<div id="multi-conn" style="width: 900px; height: 900px; margin: auto;margin-top: 50px;"></div>
	</body>
</html>

