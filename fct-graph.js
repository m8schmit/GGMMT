//CATCH NEW TABLE NAME
$("#createTable").submit(function(event) {
	event.preventDefault();
	var gname = $("#newTabName").val();
	$.ajax({
		url: "newgraph.php",
		data: "gname="+gname,
		method: "post",
		success: function(data) {
			console.log(data);
			if (data != 1)
				$("#createTableRes").html("Erreur !(catch)");
			else
			{
				$("#createTableRes").html("ok !");
				window.location.reload();
			}
		}
	});
	console.log(gname);
});

//CATCH TO ERASE TABLE NAME
$("#eraseTable").submit(function(event) {
	event.preventDefault();
	var selected = [];
	$("#eraseTable ul li input:checked").each(function() {
		selected.push($(this).attr('name'));
	});
	if(selected.length)
	{
		$.ajax({
			url: "erasegraph.php",
			data: {selected:selected},
			method: "post",
				success: function(data) {
					console.log(data);
					if (data != 1)
						$("#eraseTableRes").html("Erreur !");
					else
					{
						$("#eraseTableRes").html("ok !");
						window.location.reload();
					}
				}
		});
	}
	else
		$("#eraseTableRes").html("aucun graphique sélectionné !");
	console.log(selected);
});

//CATCH TO MODIFICATION TABLE NAME
function choiceTab(value) {
	console.log(value);
	if (value)
	{
		$.ajax({
		url: "catchgraph.php",
		data: "gname="+value,
		method: "post",
		success: function(data) {
				console.log(data);
				$("#tabToModifName").html(value);
				if (data)
					$("#modifTableResSuppr").html("<h2>Supprimer une entrée :</h2><ul>"+data+"</ul><p><input type=\"submit\" value=\"OK\" onclick=\"return(confirm('Etes-vous sûr de vouloir supprimer cette entrée?'))\"></p>");
				else
					$("#modifTableResSuppr").html("Pas d'entrée pour ce graphique");
				$("#modifTableResAdd").html("<h2>Ajouter une entrée :</h2><div>Titre activité : <input type=\"text\" name=\"activityTitle\" required/><br />Début : <input type=\"text\" name=\"activityBegin\" placeholder=\"00:00:00\" pattern=\"([01]?[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])\" style=\"margin-left: 61px;\" required><br />Fin activité : <input type=\"text\" name=\"activityEnd\"  placeholder=\"00:00:00\" pattern=\"([01]?[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])\" style=\"margin-left: 26px;\" required/><br /><input type=\"submit\" value=\"OK\">");
			}
		});
	}
}

//CATCH TO ERASE INPUT IN SELECTED TABLE
$("#eraseInput").submit(function(event) {
	event.preventDefault();
	var selected = [];
	var gname = $("#tabToModifName").text();
	$("#eraseInput ul li input:checked").each(function() {
		selected.push($(this).attr('name'));
	});
	if(selected.length)
	{
		$.ajax({
			url: "eraseinput.php",
			data: {selected:selected, gname:gname},
			method: "post",
			success: function(data) {
				console.log(data);
				if (data != 1)
					$("#eraseInputRes").html("Erreur !");
				else
				{
					$("#eraseInputRes").html("ok !");
					window.location.reload();
				}
			}
		});	
	}
	else
		$("#eraseInputRes").html("aucune entrée sélectionnée !");
	console.log(selected);
});

//CATCH TO ADD INPUT IN SELECTED TABLE
$("#addInput").submit(function(event) {
	event.preventDefault();
	var entries = $("#addInput").serialize();
	var gname = $("#tabToModifName").text();
	$.ajax({
		url: "addinput.php",
		data: entries+"&gname="+gname,
		method: "post",
		success: function(data) {
			console.log("DATA: "+data);
			if (data != 1)
				$("#addInputRes").html("Erreur !(add)");
			else
			{
				$("#addInputRes").html("ok !");
				window.location.reload();
			}
		}

	})
	console.log(entries);
});