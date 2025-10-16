    
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

var table = $('#rfq_table').DataTable({

	responsive: true,
        searching: true,
        dom: "Blfrtip",
        buttons: [
            "copy", "excel", "csv", "print", "colvis"
        ],
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        pageLength: 10,
        language: {
            info: "Showing _START_ to _END_ of _TOTAL_ entries"
        },
        columnDefs: columnDefs

});

// table.on('column-visibility.dt', function (e, settings, column, state) {
// 	alert('hi i am fine');

//     console.log('Column index: ', column);
//     console.log('Column visibility state: ', state);

// 	var columnHeader = table.column(column).header();

//     var columnName = $(columnHeader).text();
    
//     console.log('Column name: ', columnName);
// 	var formattedHeader = columnName.toLowerCase().replace(/\s+/g, '_');
//     var uniqueReportName = $('#unique_report_id').val();
//     // var rfqNo = $('#rfq_no').val();
//     var stateAsString = state ? 'true' : 'false';

//     $.ajax({
//         url: '../api/report_api.php',
//         type: 'POST',
//         dataType: 'json',
//         contentType: 'application/json',
//         data: JSON.stringify({
//             column_header: formattedHeader,
//             unique_report_name: uniqueReportName,
//             visibility: stateAsString
//         }),
//         success: function(response) {
//             console.log('Success:', response);
//         },
//         error: function(xhr, status, error) {
//             console.error('Error:', error);
//         }
//     });

// });
function formatColumnName(name) {
        return name
            .toLowerCase()                   // Convert to lowercase
            .replace(/\s+/g, '_')            // Replace spaces with underscores
            .replace(/[^a-z0-9_]/g, '');     // Remove special characters
    }
table.on('column-visibility.dt', function (e, settings, column, state) {
  

    console.log('Column index: ', column);
    console.log('Column visibility state: ', state);

    var columnHeader = table.column(column).header();
    var columnName = $(columnHeader).text();

    // Function to format column names


    // Format the column name
    var formattedHeader = formatColumnName(columnName);

    var uniqueReportName = $('#unique_report_id').val();
    var stateAsString = state ? 'true' : 'false';
    // var stateAsString = 'true';

    $.ajax({
        url: '../api/report_api.php',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            column_header: formattedHeader,
            unique_report_name: uniqueReportName,
            visibility: stateAsString,
            columnindex:column
        }),
        success: function(response) {
            console.log('Success:', response);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
});

// table.on('order.dt', function (e, settings) {
//     var order = settings.aaSorting; // Get the current sorting state (array of [column index, direction])
    
//     if (order.length > 0) {
//         var column = order[0][0]; // Index of the sorted column
//         var direction = order[0][1]; // 'asc' for ascending, 'desc' for descending

//         console.log('Sorted column index: ', column);
//         console.log('Sort direction: ', direction);

//         var columnHeader = table.column(column).header();
//         var columnName = $(columnHeader).text();

//         // Format the column name
//         var formattedHeader = formatColumnName(columnName);

//         var uniqueReportName = $('#unique_report_id').val();


//         $.ajax({
//             url: '../api/report_api_ordering.php',
//             type: 'POST',
//             dataType: 'json',
//             contentType: 'application/json',
//             data: JSON.stringify({
//                 column_header: formattedHeader,
//                 unique_report_name: uniqueReportName,
//                 sort_order: direction,
//                 columnindex:column
//             }),
//             success: function(response) {
//                 console.log('Sorting update success:', response);
//             },
//             error: function(xhr, status, error) {
//                 console.error('Error:', error);
//             }
//         });
//     }
// });


</script>

<!-- <script>
$(document).ready(function() {
    // DataTable initialization
    var table = $("#rfq_table").DataTable({
        responsive: true,
        searching: true,
        dom: "Blfrtip",
        buttons: [
            "copy", "excel", "csv", "print", "colvis"
        ],
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        pageLength: 10,
        language: {
            info: "Showing _START_ to _END_ of _TOTAL_ entries"
        }
    });

    // Apply the search for each column
    $("'.$data.' thead tr:eq(1) th").each(function (i) {
        $("input", this).on("keyup change", function () {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

 console.log('ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd');
 console.log(table);
 console.log('ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd');
});
</script> -->