<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
include '../config/function.php';


$today 			    = date('Y-m-d');
$company_id         = $_SESSION['company_id'];
$menu 			    = 'Setup';
$sub_menu 		    = 'so_area';
$title='Route List';




if(isset($_REQUEST['new'])){

//&& $_POST['randcheck']==$_SESSION['rand']

  @insert('ss_user_route');
  $msg="New data insert successfully";
}


//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>0){	
//  $delid = $_REQUEST['delid'];
//  mysqli_query($conn, "delete from ss_user_route where id='".$delid."'");
//  
//  $msg="Delete successfully";
//  redirect('setup_route.php');
//}

if (isset($_REQUEST['delid']) && $_REQUEST['delid'] > 0) {
    $delid = $_REQUEST['delid'];

    $stmt = $conn->prepare("DELETE FROM ss_user_route WHERE id = ?");
    
    $stmt->bind_param("i", $delid); 
    
    if ($stmt->execute()) {
        $msg = "Delete successfully";
    } else {
        $msg = "Error deleting record: " . $stmt->error;
    }
    
    $stmt->close();

    header('Location: so_area.php');
   // exit();
}



if(isset($_POST['update'])){
  unset($_POST['update']);
  unset($_POST['randcheck']);
  
  update('ss_user_route','id="'.$_GET['edit_id'].'"');
  
  $msg= "Update successfully";
  //redirect('setup_route.php');
}

if($_GET['edit_id']>0){
$ss="select * from ss_user_route where id='".$_GET['edit_id']."'";
$show2 = findall($ss);

$zone_id    =find1('select ZONE_ID from area where AREA_CODE="'.$show2->area_id.'"');
$region_id = find1('select REGION_ID from zon where ZONE_CODE="'.$zone_id.'"');

}
?>



	<!-- Main body -->
	<div class="container-fluid">
    <div class="row">
        <div class="col-sm-8">


            <div class="container n-form1">
				<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                      <th>S/L</th>
                      <th>User Name</th>
					  <th>Route Points</th>
                      <th>Route Name</th>
                      <th>Zone</th>
                      <th>Region</th>
                      <th>Action</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?php 
			echo $sql = "select ss_user_route.*,area.AREA_NAME as area_name,area.AREA_CODE, zon.ZONE_CODE,zon.ZONE_NAME as zon_name, branch.BRANCH_ID, branch.BRANCH_NAME as Region
			from ss_user_route LEFT JOIN area ON ss_user_route.area_id=area.AREA_CODE LEFT JOIN zon ON area.ZONE_ID=zon.ZONE_CODE LEFT JOIN branch ON zon.REGION_ID=branch.BRANCH_ID
			where 1 order by area_id,user_id";
			
			$query=mysqli_query($conn, $sql);
			while($data=mysqli_fetch_object($query)){
			?>                  	
								<tr>
								  <td><?=$data->id?></td>
								  <td><?=find_a_field('ss_user','fname','user_id="'.$data->user_id.'"');?></td> 
								  <td><?=find_a_field('ss_route','route_name','route_id="'.$data->route_points.'"');?></td>
								  <td><?=$data->area_name?></td>
								  <td><?=$data->zon_name?></td>
								  <td><?=$data->Region?></td>
								  <td>
				<a href="so_area.php?edit_id=<?=$data->id;?>" class="btn1 btn1-bg-update">Edit</a>  
				<a href="so_area.php?delid=<?=$data->id;?>" onClick="return confirm('Do you want to delete')" class="btn1 btn1-bg-cancel">Delete</a>
								</td>
								</tr>
			<? } ?>                    
							</table>

            </div>

        </div>


        <div class="col-sm-4">
            <form action="" method="post" id="demo-form2" data-parsley-validate enctype="multipart/form-data" class="n-form">
                <h4 align="center" class="n-form-titel1 text-uppercase"> Fill Up Below Information</h4>
				<?php $rand=rand(); $_SESSION['rand']=$rand; ?>
				<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label"> Zone</label>
                    <div class="col-sm-9 p-0">
                       <select class="form-control col-md-12" required id="region" onchange="FetchZone(this.value)">
        <option value="<?=$region_id?>"><?=find1("select BRANCH_NAME from branch where BRANCH_ID='".$region_id."'");?></option>
<? optionlist('select BRANCH_ID,BRANCH_NAME from branch where 1 order by BRANCH_NAME');?>
    </select>

                    </div>
                </div>
<div class="form-group row m-0 pl-3 pr-3 p-1">
<label class="col-sm-3 pl-0 pr-0 col-form-label" for="zone_id">Territory<span class="required"></span></label>
<div class="col-sm-9 p-0">
    <select class="form-control col-md-12" required id="zone" onchange="FetchArea(this.value)">
        <option value="<?=$zone_id?>"><?=find1("select ZONE_NAME from zon where ZONE_CODE='".$zone_id."'");?></option>
    </select>
</div></div>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Route Name</label>
                    <div class="col-sm-9 p-0">
                        <select class="form-control col-md-12" name="area_id" required id="area" onchange="FetchRoute(this.value)">
        <option value="<?=$show2->area_id?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$show2->area_id."'");?></option>
    </select>

                    </div>
                </div>
				
				
				<div class="row mb-10 form-group">
					<label class="control-label col-md-3" for="area_id">Route Points<span class="required"></span></label>
						<div class="col-md-8">
    						<select class="form-control col-md-12" name="route_points" required id="route_id" >
        				<?php /*?><option value="<?=$show2->area_id?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$show2->area_id."'");?></option><?php */?>
		
        					<option value="<?=$show2->route_points?>"><?=find1("select route_name from ss_route where route_id='".$show2->route_points."'");?></option>
		
    						</select>
						</div>
				</div>
				
				
				
				                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Sales Person</label>
                    <div class="col-sm-9 p-0">
							
							  <select class="form-control col-md-12" name="user_id"  id="user_id">
							  	
									<option></option>
							  		<? foreign_relation('ss_user','user_id','fname',$show2->user_id,'1') ?>
        							
									
								</select>
					
					<!--<input type="text" name="user_id" required="required" value="<?=$show2->user_id?>" class="form-control col-md-12" />-->
					
                        	  

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
	
	
	<!-- Main body end-->

   


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
   function FetchRoute(id){ 
    $('#route_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { area_id : id},
      success : function(data){
         $('#route_id').html(data);
      }

    })
  }  
</script>