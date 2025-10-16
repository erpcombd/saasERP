<?php
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
include '../config/function.php';
//var_dump($_SESSION);
do_datatable('do_datatable');
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
$title='Region Setup';			// Page Name and Page Title

$today 			    = date('Y-m-d');
$company_id         = $_SESSION['user']['company_id'];
$menu 			    = 'Setup Location';
$sub_menu 		    = 'setup_region';




if(isset($_REQUEST['new']) && $_POST['randcheck']==$_SESSION['rand']){

  @insert('branch');
  $msg="New data insert successfully";
}


//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>1){	
//  $delid = $_REQUEST['delid'];
//  mysqli_query($conn, "delete from branch where BRANCH_ID='".$delid."'");
//  
//  $msg="Delete successfully";
//  redirect('setup_region.php');
//}
if (isset($_REQUEST['delid']) && $_REQUEST['delid'] > 1) {
    $delid = $_REQUEST['delid'];

    $stmt = $conn->prepare("DELETE FROM branch WHERE BRANCH_ID = ?");
    
    $stmt->bind_param("i", $delid); 

    if ($stmt->execute()) {
        $msg = "Delete successfully";
    } else {
        $msg = "Error deleting record: " . $stmt->error;
    }
    
    $stmt->close();

 	 redirect('setup_region.php');
    //header('Location: setup_region.php');
    exit();
}

if(isset($_POST['update'])){
  unset($_POST['update']); 
  unset($_POST['randcheck']);
  update('branch','BRANCH_ID="'.$_GET['edit_id'].'"');
  
  $msg= "Update successfully";
  redirect('setup_region.php');
}

if($_GET['edit_id']>0){
$ss="select * from branch where BRANCH_ID='".$_GET['edit_id']."'";
$show2 = findall($ss);
}
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-7">


            <div class="container n-form1">
				<table id="do_datatable" class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                      <th>Region ID</th>
                      <th>Region Name</th>
                      <th>Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?php 
$sql = "select * from branch where 1 order by BRANCH_NAME";
$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>                  	
                    <tr>
                      <td><?=$data->BRANCH_ID?></td>
                      <td><?=$data->BRANCH_NAME?></td>
                      <td>
	<a href="setup_region.php?edit_id=<?=$data->BRANCH_ID;?>" class="btn1 btn1-bg-update">Edit</a>  
	<!--<a href="setup_region.php?delid=<?=$data->BRANCH_ID;?>" onClick="return confirm('Do you want to delete')" class="btn1 btn1-bg-cancel">Delete</a>-->
					</td>
                    </tr>
<? } ?>   
					
					</tbody>
                </table>

            </div>

        </div>


        <div class="col-sm-5">
            <form action="" method="post" id="demo-form2" data-parsley-validate class="n-form">
			<?php $rand=rand(); $_SESSION['rand']=$rand; ?>
			<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
                <h4 align="center" class="n-form-titel1 text-uppercase"> Fill Up Below Information</h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label"> Region name</label>
                    <div class="col-sm-9 p-0">
                      <input type="text" name="BRANCH_NAME" required="required" value="<?=$show2->BRANCH_NAME?>" class="form-control">
                    </div>
                </div>


                <div class="n-form-btn-class">
					  <? if($_GET['edit_id']>0){?>
					  <input name="update" type="submit" value="Update" class="btn1 btn1-bg-update">  
					<? }else{ ?>
					<input name="new" type="submit" value="Create" class="btn1 btn1-bg-submit"> 
					<? } ?>
                      
                </div>


            </form>

        </div>

    </div>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?> 