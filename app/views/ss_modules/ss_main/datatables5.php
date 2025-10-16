<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" >
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet" >

<style>
    .sr-main-content-heading {
      margin: 0;
      padding: 0;
      font-size: 18px;
      font-weight: 500;
      color: #48465b;
      margin-bottom: 20px;
      text-align: center;
    }
</style>
<!-- <p>
    <a href="/usermatrix/adduser"><button class="btn btn-success text-center"><i class="fa-regular fa-users"></i> Add New User </button></a> 
</p> -->
<div class="sr-main-content-heading">
    <i class="fa fa-server" style="padding-right: 10px"></i>All User
  </div>
<table id="example" class="table table-striped ">
    <thead>
        <tr>
                
                <th>User Id</th>
                <th>UserName</th>
                <th>Fname</th>
                <th>Designation</th>
                <th>Level</th>
                <th>Status</th>
                <th>Action</th>

        </tr>
    </thead>
    <tbody >
        
        <tr>
		        <td>User Id</td>
                <td>UserName</td>
                <td>Fname</td>
                <td>Designation</td>
                <td>Level</td>
                <td>Status</td>
                <td>Action</td>
		</tr>



 
    </tbody>
    <tfoot>
        <tr>
            <th>User Id</th>
            <th>UserName</th>
            <th>Fname</th>
            <th>Designation</th>
            <th>Level</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>
<script src='https://code.jquery.com/jquery-3.7.0.js'></script>
<script src='https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js'></script>
<script src='https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js'></script>
<script src='https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
<script src='https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js'></script>
<script src='https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js'></script>
<script src='https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js'></script>


<script>
    $(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );


</script>