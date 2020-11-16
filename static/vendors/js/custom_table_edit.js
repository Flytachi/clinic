$(document).ready(function(){
	$('#data_table').Tabledit({
		deleteButton: false,
		editButton: false,
		columns: {
		  identifier: [0, 'id'],
		  editable: [[1, 'date'], [2, 'description']]
		},
		hideIdentifier: true,
		url: 'live_edit.php'
	});
});
