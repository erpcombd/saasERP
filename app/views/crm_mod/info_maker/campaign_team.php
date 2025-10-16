<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Task Purpose Management";

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');


 $today = date('Y-m-d');

 $lastdays = date("Y-m-d", strtotime("-7 days", strtotime($today)));

 $cur = '&#x9f3;';
 
 
 
 
 $table1 = 'crm_task_purpose';
 
 $crud1 = new crud($table1);
 
 
 if(isset($_POST['insert'])){
     
     $_POST['entry_by'] = $_SESSION['employee_selected'];
     
     $crud1->insert();
 }
 
 if(isset($_POST['update'])){
     
     $_POST['update_by'] = $_SESSION['employee_selected'];
     $_POST['update_at'] = date('Y-m-d h:s:i');
     
     $crud1->update('id');
 }
 

 
 require "../include/custom.php";

?>
 <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>
  



<!-- Main Section Start -->


<!-- Main Section ENd -->








<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>


<?php if(isset($_GET['update'])){ ?>
    <script>
        $('.bd-example-modal-lg').modal('show');
    </script>
<?php } ?>
<script>
var table = $('#example').DataTable();
 
$('#all').on( 'click', function () {
    table.page.len( -1 ).draw();
} );
 
$('#_10').on( 'click', function () {
    table.page.len( 10 ).draw();
} );
</script>