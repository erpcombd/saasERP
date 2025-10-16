<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$now=time();

$title='Bin/Position Setup';

do_datatable("grp");

$unique='bin_position_id';

$unique_field='bin_position_name';

$table='item_bin_position';

$page="bin_position.php";



$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$unique_field]))

{

$$unique = $_POST[$unique];

//for Record..................................



if(isset($_POST['record']))



{		

$_POST['entry_at']=date('Y-m-d H:i:s');

$_POST['entry_by']=$_SESSION['user']['id'];

$crud->insert();



$type=1;



$msg='New Entry Successfully Inserted.';



unset($_POST);



unset($$unique);



}











//for Modify..................................







if(isset($_POST['modify']))



{

$_POST['edit_at']=time();

$_POST['edit_by']=$_SESSION['user']['id'];

		$crud->update($unique);



		$type=1;



		$msg='Successfully Updated.';



}



//for Delete..................................







if(isset($_POST['delete']))



{		$condition=$unique."=".$$unique;		



		$crud->delete($condition);



		unset($$unique);



		$type=1;



		$msg='Successfully Deleted.';



}







}



if(isset($$unique))



{



$condition=$unique."=".$$unique;	



$data=db_fetch_object($table,$condition);



 
foreach($data as $key=>$value)


{ $$key=$value;}



}



?>



<script type="text/javascript">



function nav(lkf){document.location.href = '<?=$page?>?<?=$unique?>='+lkf;}



</script>













  <div class="container-fluid p-0">

    

	<div class="row">
		<div class="col-md-3 p-0"></div>
	<div class="col-md-6 p-0">

        <form id="form1" name="form1" class="n-form" method="post" action="<?=$page?>?<?=$unique?>=<?=$$unique?>">

		

          <h4 align="center" class="n-form-titel1">BIN/Position</h4>

		  

	 <div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Warehouse Name:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

					 
						<select name="warehouse_id" id="warehouse_id">
							<option value="<?=$warehouse_id;?>"><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);?></option>
							<?php 
							$sql='select * from warehouse';
							$query=db_query($sql);
							while($srow=mysqli_fetch_object($query)){
							?>
							<option value="<?php echo $srow->warehouse_id;?>"><?php echo $srow->warehouse_name;?></option>
							<?php } ?>
						</select> 

                    </div>

                </div>

		  

		  <div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Zone/Location Name:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

					 
						<select name="zone_loc_id" id="zone_loc_id">
							<option value="<?=$zone_loc_id;?>"><?php echo find_a_field('item_zone_location','zone_loc_name','zone_loc_id='.$zone_loc_id);?></option>
							<?php 
							$sql='select * from item_zone_location';
							$query=db_query($sql);
							while($srow=mysqli_fetch_object($query)){
							?>
							<option value="<?php echo $srow->zone_loc_id;?>"><?php echo $srow->zone_loc_name;?></option>
							<?php } ?>
						</select> 

                    </div>

                </div>
				<div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Lane/Asile Name:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

					 
						<select name="lane_asile_id" id="lane_asile_id">
							<option value="<?=$lane_asile_id;?>"><?php echo find_a_field('item_lane_asile','lane_asile_name','lane_asile_id='.$lane_asile_id);?></option>
							<?php 
							$sql='select * from  item_lane_asile';
							$query=db_query($sql);
							while($srow=mysqli_fetch_object($query)){
							?>
							<option value="<?php echo $srow->lane_asile_id;?>"><?php echo $srow->lane_asile_name;?></option>
							<?php } ?>
						</select> 

                    </div>

                </div>
		  
		  <div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Rack/Bay Name:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

					 
						<select name="rack_bay_id" id="rack_bay_id">
							<option value="<?=$rack_bay_id;?>"><?php echo find_a_field('item_rack_bay','rack_bay_name','rack_bay_id='.$rack_bay_id);?></option>
							<?php 
							$sql='select * from  item_rack_bay';
							$query=db_query($sql);
							while($srow=mysqli_fetch_object($query)){
							?>
							<option value="<?php echo $srow->rack_bay_id;?>"><?php echo $srow->rack_bay_name;?></option>
							<?php } ?>
						</select> 

                    </div>

                </div>
				
				<div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Shelf/Level Name:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

					 
						<select name="shelf_level_id" id="shelf_level_id">
							<option value="<?=$shelf_level_id;?>"><?php echo find_a_field('item_shelf_level','shelf_level_name','shelf_level_id='.$shelf_level_id);?></option>
							<?php 
							$sql='select * from  item_shelf_level';
							$query=db_query($sql);
							while($srow=mysqli_fetch_object($query)){
							?>
							<option value="<?php echo $srow->shelf_level_id;?>"><?php echo $srow->shelf_level_name;?></option>
							<?php } ?>
						</select> 

                    </div>

                </div>
		  <div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Bin/Position Name:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

						 <input type="text" name="bin_position_name" class="form-control"  id="bin_position_name" value="<?=$bin_position_name;?>"/>
						 <input type="hidden" name="<?=$unique?>" class="form-control"  id="<?=$unique?>" value="<?=$$unique?>"/>

                    </div>

                </div>
<div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Description:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

						 <input type="text" name="bin_description" class="form-control"  id="bin_description" value="<?=$bin_description;?>"/>
					 

                    </div>

                </div>
				
				<!--<div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Item Name:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

					 
						<select name="item_id" id="item_id">
							<option value="<?=$item_id;?>"><?php echo find_a_field('item_info','itme_name','item_id='.$item_id);?></option>
							<?php 
							$sql='select * from  item_info';
							$query=db_query($sql);
							while($srow=mysqli_fetch_object($query)){
							?>
							<option value="<?php echo $srow->item_id;?>"><?php echo $srow->item_name;?></option>
							<?php } ?>
						</select> 

                    </div>

                </div>-->
		  
		  	<div class="n-form-btn-class">

		  

<? if(!isset($_POST[$unique])&&!isset($_GET[$unique])) {?>

<input name="record" type="submit" id="record" value="Record" onclick="return checkUserName()" class="btn1 btn1-bg-submit" />



<? }?>



<? if(isset($_POST[$unique])||isset($_GET[$unique])) {?>

<input name="modify" type="submit" id="modify" value="Modify" class="btn1 btn1-bg-update" />



<? }?>

<input name="clear" type="button" class="btn1 btn1-bg-help" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/>



          </div>
		  

            </div>
			<div class="col-md-3 p-0"></div>
	</div>



         <div class="row">

      <div class="col-md-12 pr-2 pl-0">

        



        <div class="container n-form1">

          <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">

            <thead class="thead1">

            <tr class="bgc-info">

              <th >ID</th>
   <th >Warehouse Name</th>
			  <th >Zone/Locaiton Name</th>

			  <th >Lane/Asile Name</th>
  <th >Rack/Bay Name</th>
  <th >Self/Level Name</th>
    <th >Bin/Position Name</th>
	  <th >Description</th>
	    <th >Action</th>
<!--	 <th >Item Name</th>-->
            </tr>

            </thead>



            <tbody class="tbody1">

            <?php
 $rrr = "select * from item_zone_location where 1";
	$report=db_query($rrr);
	while($row=mysqli_fetch_object($report)){
	$zone_loc_name_get[$row->zone_loc_id]=$row->zone_loc_name;
	}
 $rrr = "select * from  item_lane_asile where 1";
	$report=db_query($rrr);
	while($row=mysqli_fetch_object($report)){
	$lane_asile_name_get[$row->lane_asile_id]=$row->lane_asile_name;
	}

 $rrr = "select * from   item_rack_bay where 1";
	$report=db_query($rrr);
	while($row=mysqli_fetch_object($report)){
	$rack_bay_name_get[$row->rack_bay_id]=$row->rack_bay_name;
	}
	
	 $rrr = "select * from   item_shelf_level where 1";
	$report=db_query($rrr);
	while($row=mysqli_fetch_object($report)){
	$shelf_level_name_get[$row->shelf_level_id]=$row->shelf_level_name;
	}
	
		 $rrr = "select * from   item_info where 1";
	$report=db_query($rrr);
	while($row=mysqli_fetch_object($report)){
	$item_name_get[$row->item_id]=$row->item_name;
	}

 $wsql = "select * from warehouse where 1";
	$wquery=db_query($wsql);
	while($wrow=mysqli_fetch_object($wquery)){
	$warehouse_name_get[$wrow->warehouse_id]=$wrow->warehouse_name;
	}
	 $rrr = "select * from  item_bin_position where 1";
	$report=db_query($rrr);
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

            <tr<?=$cls?> >
			 <td><?=$rp[0];?></td>
			   <td><?=$warehouse_name_get[$rp[2]];?></td>
	<td><?=$zone_loc_name_get[$rp[3]];?></td>
              <td><?=$lane_asile_name_get[$rp[4]];?></td>
			  <td><?=$rack_bay_name_get[$rp[5]];?></td>
			  <td><?=$shelf_level_name_get[$rp[6]];?></td>
			  <td><?=$rp[1];?></td>
			   <td><?=$rp[8];?></td>
			  <!--  <td><?=$item_name_get[$rp[6]];?></td>-->

	  <td><button type="button" onclick="nav('<?php echo $rp[0];?>');" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button></td>

			  

			  

			 



            </tr>



            <?php }?>



            </tbody>

          </table>



        </div>



      </div>





      

          </div> 





        </form>



      </div>



    </div>









  </div>











<script type="text/javascript">



	document.onkeypress=function(e){



	var e=window.event || e



	var keyunicode=e.charCode || e.keyCode



	if (keyunicode==13)



	{



		return false;



	}



}



</script>



<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>