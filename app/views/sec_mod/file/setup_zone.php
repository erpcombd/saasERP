<?php

  //  ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
include '../config/function.php';
do_datatable('do_datatable');

$today 			    = date('Y-m-d');
$company_id         = $_SESSION['company_id'];
$menu 			    = 'Setup Location';
$sub_menu 		    = 'setup_zone';
$title='Zone List';




if(isset($_REQUEST['new']) && $_POST['randcheck']==$_SESSION['rand']){

  @insert('zon');
  $msg="New data insert successfully";
}


//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>1){	
//  $delid = $_REQUEST['delid'];
//  mysqli_query($conn, "delete from zon where ZONE_CODE='".$delid."'");
//  
//  $msg="Delete successfully";
//  redirect('setup_zone.php');
//}

if (isset($_REQUEST['delid']) && $_REQUEST['delid'] > 1) {
    $delid = $_REQUEST['delid'];
    $stmt = $conn->prepare("DELETE FROM zon WHERE ZONE_CODE = ?");
    
    $stmt->bind_param("i", $delid); 

    if ($stmt->execute()) {
        $msg = "Delete successfully";
    } else {
        $msg = "Error deleting record: " . $stmt->error;
    }
     
    $stmt->close();


    header('Location: setup_zone.php');
    //exit();
}


if(isset($_POST['update'])){
  unset($_POST['update']);
  unset($_POST['randcheck']);
  update('zon','ZONE_CODE="'.$_GET['edit_id'].'"');
  
  $msg= "Update successfully";
  redirect('setup_zone.php');
}

if($_GET['edit_id']>0){
$ss="select * from zon where ZONE_CODE='".$_GET['edit_id']."'";
$show2 = findall($ss);
}
?>




  



<!---Main body -->

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-7">


            <div class="container n-form1">
				<table id="do_datatable" class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                      <th>Region</th>
                      <th>Zone ID</th>
                      <th>Zone Name</th>
                      <th>Action</th>
                    </tr>
                    </thead>

                     <tbody class="tbody1">
				<?php 
				$sql = "select zon.*,branch.BRANCH_NAME as region_name from zon LEFT JOIN branch ON zon.REGION_ID=branch.BRANCH_ID where 1 order by REGION_ID,ZONE_NAME";
				$query=mysqli_query($conn, $sql);
				while($data=mysqli_fetch_object($query)){
				?>                  	
									<tr>
									  <td><?=$data->region_name?></td>
									  <td><?=$data->ZONE_CODE?></td>
									  <td><?=$data->ZONE_NAME?></td>
									  <td>
					<a href="setup_zone.php?edit_id=<?=$data->ZONE_CODE;?>" class="btn1 btn1-bg-update">Edit</a>  
	<!--				<a href="setup_zone.php?delid=<?=$data->ZONE_CODE;?>" onClick="return confirm('Do you want to delete')" class="btn1 btn1-bg-cancel">Delete</a>-->
									</td>
									</tr>
				<? } ?>                    
								  </tbody>
                </table>

            </div>

        </div>


        <div class="col-sm-5">
            <form action="" method="post" id="demo-form2" data-parsley-validate class="n-form">
			
			<input type="hidden" value="" name="randcheck" />
                <h4 align="center" class="n-form-titel1 text-uppercase"> Fill Up Below Information</h4>

							<?php $rand=rand(); $_SESSION['rand']=$rand; ?>
			<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
			
			
			<div class="form-group row m-0 pl-3 pr-3 p-1">
			<label class="control-label col-md-4" for="">Region<span class="required"></span></label>
			<div class="col-md-8">
				<select class="form-control col-md-12" name="REGION_ID" required id="REGION_ID" >
				 <option value="">-- Select Region --</option>
					<option value="<?=$show2->REGION_ID?>"><?=find1("select BRANCH_NAME from branch where BRANCH_ID='".$show2->REGION_ID."'");?></option>
			<? optionlist('select BRANCH_ID,BRANCH_NAME from branch where 1 order by BRANCH_NAME');?>
				</select>
			</div></div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label class="control-label col-md-4" for="group_name">Zone name<span class="required"></span></label>
						<div class="col-md-8">
						
						<input type="text" name="ZONE_NAME" required="required" value="<?=$show2->ZONE_NAME?>" class="form-control col-md-12">
						</div>
					</div>
					
								
											
					
										  
					<div class="ln_solid "></div>
					<div class="form-group">
					<div class="n-form-btn-class">
					<!--<button class="btn btn-primary" type="reset">Reset</button>-->
					<? if($_GET['edit_id']>0){?>
					<button name="update" type="submit"  class="btn btn-success">Update</button>
					<? }else{ ?>
					<button name="new" type="submit"  class="btn btn-success">Create</button>
					<? } ?>
					</div>
					</div>


            </form>

        </div>

    </div>

</div>


<!---Main body end -->


    
 
<script type = "text/javascript" >
function preventBack() { window.history.forward(); }
setTimeout("preventBack()", 0);
window.onunload = function () { null };
</script>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?> 