    
	<!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="../../../../public/assets/datatable_esourcing/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/assets/datatable_esourcing/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/assets/datatable_esourcing/buttons.dataTables.min.css">
	<!-- jQuery -->
	<script type="text/javascript" charset="utf8" src="../../../../public/assets/datatable_esourcing/js/jquery-3.5.1.js"></script>
	
	<!-- DataTables JS -->
	<script type="text/javascript" charset="utf8" src="../../../../public/assets/datatable_esourcing/jquery.dataTables.js"></script>
	<!-- <script type="text/javascript" charset="utf8" src="../../../../public/assets/datatable_esourcing/dataTables.responsive.min.js"></script>
	 -->
	<!-- DataTables Buttons JS -->
	<script type="text/javascript" charset="utf8" src="../../../../public/assets/datatable_esourcing/dataTables.buttons.min.js"></script>
	<script type="text/javascript" charset="utf8" src="../../../../public/assets/datatable_esourcing/jszip.min.js"></script>
	<script type="text/javascript" charset="utf8" src="../../../../public/assets/datatable_esourcing/pdfmake.min.js"></script>
	<script type="text/javascript" charset="utf8" src="../../../../public/assets/datatable_esourcing/vfs_fonts.js"></script>
	<script type="text/javascript" charset="utf8" src="../../../../public/assets/datatable_esourcing/buttons.html5.min.js"></script>
	<script type="text/javascript" charset="utf8" src="../../../../public/assets/datatable_esourcing/buttons.print.min.js"></script>
	<script type="text/javascript" charset="utf8" src="../../../../public/assets/datatable_esourcing/buttons.colVis.min.js"></script>
	<script>

var table = $('#rfq_table_view').DataTable({

	responsive: true,
        searching: true,
        dom: "Blfrtip",
        buttons: [
            "copy", "excel", "csv", "print",
        ],
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        pageLength: 10,
        language: {
            info: "Showing _START_ to _END_ of _TOTAL_ entries"
        }

});


function applyOrdering(columnIndex, direction) {
    // Set the ordering for the specified column and direction
    table.order([columnIndex, direction]).draw();  // .draw() updates the table with the new sorting
}

    // Loop through columnOrderingData to apply ordering to each column
    for (var i = 0; i < columnOrderingData.length; i++) {
        var columnData = columnOrderingData[i];
        applyOrdering(columnData.columnIndex, columnData.sortOrder);
    }
</script>