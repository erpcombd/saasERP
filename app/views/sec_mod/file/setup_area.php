<?php
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
include '../config/function.php';

do_datatable('do_datatable');
$today 			    = date('Y-m-d');
$company_id         = $_SESSION['company_id'];
$menu 			    = 'Setup Location';
$sub_menu 		    = 'setup_area';

$title='Area List';



if(isset($_REQUEST['new']) && $_POST['randcheck']==$_SESSION['rand']){

  @insert('area');
  $msg="New data insert successfully";
}


//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>1){	
//  $delid = $_REQUEST['delid'];
//  mysqli_query($conn, "delete from area where AREA_CODE='".$delid."'");
//  
//  $msg="Delete successfully";
//  redirect('setup_area.php');
//}

if (isset($_REQUEST['delid']) && $_REQUEST['delid'] > 1) {
    $delid = $_REQUEST['delid'];

    $stmt = $conn->prepare("DELETE FROM area WHERE AREA_CODE = ?");
    
    $stmt->bind_param("i", $delid); 
    
    if ($stmt->execute()) {
        $msg = "Delete successfully";
    } else {
        $msg = "Error deleting record: " . $stmt->error;
    }
    
    $stmt->close();
	
	redirect('setup_area.php');
    exit();
}


if(isset($_POST['update'])){
  unset($_POST['update']);
  unset($_POST['randcheck']);
  update('area','AREA_CODE="'.$_GET['edit_id'].'"');
  
  $msg= "Update successfully";
  redirect('setup_area.php');
}

if($_GET['edit_id']>0){
$ss="select * from area where AREA_CODE='".$_GET['edit_id']."'";
$show2 = findall($ss);

$region_id = find1('select REGION_ID from zon where ZONE_CODE="'.$show2->ZONE_ID.'"');

}
?>


 
		
	<!-- Main Body -->	
	
	<div class="container-fluid">
    <div class="row">
        <div class="col-sm-7">


            <div class="container n-form1">
                <table id="do_datatable" class="table1  table-striped table-bordered table-hover table-sm">
                  <thead class="thead1">
                    <tr class="bgc-info">
                  
                      <th>Area ID</th>
                      <th>Area Name</th>
                      <th>Territory</th>
                      <th>Zone</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
			<?php 
			$sql = "select area.*,zon.ZONE_NAME as zone_name,zon.REGION_ID from area 
			LEFT JOIN zon ON area.ZONE_ID=zon.ZONE_CODE
			where 1 order by ZONE_ID,AREA_NAME";
			
			$query=mysqli_query($conn, $sql);
			while($data=mysqli_fetch_object($query)){
			?>                  	
								<tr>
								  <td><?=$data->AREA_CODE?></td>
								  <td><?=$data->AREA_NAME?></td>
								  <td><?=$data->zone_name?></td>
								  <td><?=find1('select BRANCH_NAME from branch where BRANCH_ID="'.$data->REGION_ID.'"');?></td>
								  <td>
				<a href="setup_area.php?edit_id=<?=$data->AREA_CODE;?>" class="btn1 btn1-bg-update">Edit</a> 
				<!--<a href="setup_area.php?delid=<?=$data->AREA_CODE;?>" onClick="return confirm('Do you want to delete')" class="btn1 btn1-bg-cancel">Delete</a>-->
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
			<label class="control-label col-md-4" for="">Zone<span class="required"></span></label>
			<div class="col-md-8">
				<select class="form-control col-md-12" required id="region" onchange="FetchZone(this.value)">
				 <option value="">-- Select Zone --</option>
					<option value="<?=$region_id?>"><?=find1("select BRANCH_NAME from branch where BRANCH_ID='".$region_id."'");?></option>
			<? optionlist('select BRANCH_ID,BRANCH_NAME from branch where 1 order by BRANCH_NAME');?>
				</select>
			</div></div>
			
			
			<div class="form-group row m-0 pl-3 pr-3 p-1">
			<label class="control-label col-md-4" for="group_name">Territory<span class="required"></span></label>
			<div class="col-md-8">
				<select class="form-control col-md-12" name="ZONE_ID" required id="zone">
					<option value="<?=$show2->ZONE_ID?>"><?=find1("select ZONE_NAME from zon where ZONE_CODE='".$show2->ZONE_ID."'");?></option>
				</select>
			</div></div>
			
			
			<div class="form-group row m-0 pl-3 pr-3 p-1">
				<label class="control-label col-md-4" for="">Area name<span class="required"></span></label>
				<div class="col-md-8">
				<input type="text" name="AREA_NAME" required="required" value="<?=$show2->AREA_NAME?>" class="form-control col-md-12">
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
	

	<!-- Main Body end-->	




  
 


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?> 



<script type="text/javascript">
  function FetchZone(id){
    $('#zone').html('');
    $('#area').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { region_id : id},
      success : function(data){
         $('#zone').html(data);
      }

    })
  }

  function FetchArea(id){ 
    $('#area').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { zone_id : id},
      success : function(data){
         $('#area').html(data);
      }

    })
  }
</script>