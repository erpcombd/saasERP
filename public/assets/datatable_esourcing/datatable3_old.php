
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css">
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/2.0.4/css/colReorder.dataTables.css">
<link rel="stylesheet" type="text/css" href="../../../../public/assets/datatable_esourcing/buttons.dataTables.min.css">

<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.7.1.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/colreorder/2.0.4/js/dataTables.colReorder.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/colreorder/2.0.4/js/colReorder.dataTables.js"></script>
	<!-- DataTables CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="../../../../public/assets/datatable_esourcing/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/assets/datatable_esourcing/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/assets/datatable_esourcing/buttons.dataTables.min.css"> -->
	<!-- DataTables ColReorder CSS -->


	<!-- jQuery -->
	<!-- <script type="text/javascript" charset="utf8" src="../../../../public/assets/datatable_esourcing/js/jquery-3.5.1.js"></script> -->
	
	<!-- DataTables JS -->
	<!-- <script type="text/javascript" charset="utf8" src="../../../../public/assets/datatable_esourcing/jquery.dataTables.js"></script> -->
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
	<script type="text/javascript" charset="utf8" src="../../../../public/assets/js/select2.min.js"></script>

	<script>
		

		var table = $('#rfq_table_view').DataTable({
    colReorder: true,
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
    initComplete: function () {
        var api = this.api();

        api.columns().every(function (index) {
            let column = this;
			let title = column.footer().textContent;
            title=formatColumnName(title);
            let th = column.footer();
      
            // Create select element
            // let select = document.createElement('select');
            // select.add(new Option(''));
            // column.footer().replaceChildren(select);

            // // Apply listener for user change in value
            // select.addEventListener('change', function () {
            //     let searchTerm = select.value.trim();
			// 	let idx = [...th.parentNode.children].indexOf(th);

            //     // Use the index to apply search filter
            //     api.column(idx + ':visible').search(searchTerm ? searchTerm : '', false, true).draw();
            // });
            var select = $('<select id="' + title + '" class="select2" ></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                      //Get the "text" property from each selected data 
                      //regex escape the value and store in array
                      let idx = [...th.parentNode.children].indexOf(th);

                      var data = $.map( $(this).select2('data'), function( value, key ) {
                        return value.text ? value.text.trim() : null;
                                 });
                      
                      //if no data selected use ""
                      if (data.length === 0) {
                        data = [""];
                      }

                    //   console.log(data);
                      
                      //join array into string with regex or (|)
                      var val = data.join('|');
                      console.log('Search key value:', val);
                      //search for the option(s) selected
                      api.column(idx + ':visible').search( val ? val : '', true, false ) .draw();
                    } );

            // Add list of options
            // column.data().unique().sort().each(function (d, j) {
            //     const cleanValue = d.replace(/(<([^>]+)>)/gi, "").trim();
            //     select.add(new Option(cleanValue));
            // });
            column.data().unique().sort().each( function ( d, j ) {
                const cleanValue = d.replace(/(<([^>]+)>)/gi, "").trim();
                    select.append( '<option value="'+cleanValue+'">'+cleanValue+'</option>' );
                } );
              
              //use column title as selector and placeholder
              $('#' + title).select2({
                multiple: true,
                closeOnSelect: false,
                placeholder: "Select a " + title
              });




        // console.log(searchKeywords);
        // if(searchKeywords[index]){
		// 	if (searchKeywords[index] !='not_specified') {
				
        //             select.value = searchKeywords[index];
		// 			let idx = [...th.parentNode.children].indexOf(th);
		// 			api.column(idx + ':visible').search(searchKeywords[index], false, true).draw();
        //     }
        
        // }
        });
    }
});

$('tfoot').each(function () {
    $(this).insertAfter($(this).siblings('thead'));
});


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

  var uniqueReportName = $('#report_id').val();
  var stateAsString = state ? 'true' : 'false';

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

table.on('order.dt', function (e, settings) {
  var order = settings.aaSorting; // Get the current sorting state (array of [column index, direction])
  
  if (order.length > 0) {
	  var column = order[0][0]; // Index of the sorted column
	  var direction = order[0][1]; // 'asc' for ascending, 'desc' for descending

	  console.log('Sorted column index: ', column);
	  console.log('Sort direction: ', direction);

	  var columnHeader = table.column(column).header();
	  var columnName = $(columnHeader).text();

	  // Format the column name
	  var formattedHeader = formatColumnName(columnName);

	  var uniqueReportName = $('#report_id').val();


	  $.ajax({
		  url: '../api/report_api_ordering.php',
		  type: 'POST',
		  dataType: 'json',
		  contentType: 'application/json',
		  data: JSON.stringify({
			  column_header: formattedHeader,
			  unique_report_name: uniqueReportName,
			  sort_order: direction,
			  columnindex:column
		  }),
		  success: function(response) {
			  console.log('Sorting update success:', response);
		  },
		  error: function(xhr, status, error) {
			  console.error('Error:', error);
		  }
	  });
  }
});
// Event listener for column reordering
// table.on('column-reorder', function (e, settings, details) {
//     // The details object provides information about the reordering
//     console.log('Column reordered!');
//     console.log('Original column index: ', details.from);  // The original position of the reordered column
//     console.log('New column index: ', details.to);         // The new position of the reordered column

//     // You can access the new order of columns using:
//     var newOrder = table.colReorder.order();  // Returns the new order of column indexes
//     console.log('New column order: ', newOrder);

//     // Optionally, you can send the reordered column information to the server
//     var uniqueReportName = $('#report_id').val();
//     var formattedHeader = formatColumnName($(table.column(details.to).header()).text());

//     $.ajax({
//         url: '../api/report_api_column_ordering.php',
//         type: 'POST',
//         dataType: 'json',
//         contentType: 'application/json',
//         data: JSON.stringify({
//             column_header: formattedHeader,
//             unique_report_name: uniqueReportName,
//             from: details.from,
//             to: details.to,
//             new_order: newOrder
//         }),
//         success: function(response) {
//             console.log('Column reordering update success:', response);
//         },
//         error: function(xhr, status, error) {
//             console.error('Error during column reorder update:', error);
//         }
//     });
// });
table.on('column-reorder', function (e, settings, details) {
    console.log('Column reordered!');
    console.log('Original column index: ', details.from);  // The original position of the reordered column
    console.log('New column index: ', details.to);         // The new position of the reordered column

    var newOrder = table.colReorder.order();  // Returns the new order of column indexes
    console.log('New column order: ', newOrder);

    // Optionally, you can send the reordered column information to the server
    var uniqueReportName = $('#report_id').val();
    var formattedHeader = formatColumnName($(table.column(details.to).header()).text());

    $.ajax({
        url: '../api/report_api_column_ordering.php',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            column_header: formattedHeader,
            unique_report_name: uniqueReportName,
            from: details.from,
            to: details.to,
            new_order: newOrder
        }),
        success: function(response) {
            console.log('Column reordering update success:', response);
        },
        error: function(xhr, status, error) {
            console.error('Error during column reorder update:', error);
        }
    });

    // Reapply search filters after reordering

});
function applyOrdering(columnIndex, direction) {
    // Ensure columnIndex is a number and direction is either 'asc' or 'desc'
    if (!isNaN(columnIndex) && (direction === 'asc' || direction === 'desc')) {
        // Set the ordering for the specified column and direction
        table.order([ [columnIndex, direction] ]).draw();  // Properly structured as an array of arrays
    } else {
        console.error("Invalid columnIndex or direction:", columnIndex, direction);
    }
}
function setNewColumnOrder(newOrder) {
    table.colReorder.order(newOrder);  
}

setNewColumnOrder(column_RE_OrderingData);
function setnewindex(formattedHeader,uniqueReportName,visibility,column){
	$.ajax({
		  url: '../api/report_api_ordering.php',
		  type: 'POST',
		  dataType: 'json',
		  contentType: 'application/json',
		  data: JSON.stringify({
			  column_header: formattedHeader,
			  unique_report_name: uniqueReportName,
			  sort_order: direction,
			  columnindex:column
		  }),
		  success: function(response) {
			  console.log('Sorting update success:', response);
		  },
		  error: function(xhr, status, error) {
			  console.error('Error:', error);
		  }
	  });
}

    // Loop through columnOrderingData to apply ordering to each column
    for (var i = 0; i < columnOrderingData.length; i++) {
        var columnData = columnOrderingData[i];
        applyOrdering(columnData.columnIndex, columnData.sortOrder);
    }
</script>