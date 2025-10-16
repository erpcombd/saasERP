<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$now=time();

$title='Lane/Asile Setup';



$unique='lane_asile_id';

$unique_field='lane_asile_name';

$table='item_lane_asile';

$page="lane_asile.php";



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

      <div class="col-md-8 pr-2 pl-0">

        



        <div class="container n-form1">

          <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">

            <thead class="thead1">

            <tr class="bgc-info">

              <th >ID</th>
<th >Warehouse Name</th>
			  <th >Zone/Locaiton Name</th>

			  <th >Lane/Asile Name</th>
   <th >Description</th>
	  <th >Action</th>
            </tr>

            </thead>



            <tbody class="tbody1">

            <?php
 $rrr = "select * from item_zone_location where 1";
	$report=db_query($rrr);
	while($row=mysqli_fetch_object($report)){
	$zone_loc_name_get[$row->zone_loc_id]=$row->zone_loc_name;
	}

 $wsql = "select * from warehouse where 1";
	$wquery=db_query($wsql);
	while($wrow=mysqli_fetch_object($wquery)){
	$warehouse_name_get[$wrow->warehouse_id]=$wrow->warehouse_name;
	}



	 $rrr = "select * from item_lane_asile where 1";
	$report=db_query($rrr);
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

            <tr<?=$cls?> >

              <td><?=$rp[0];?></td>
			    <td><?=$warehouse_name_get[$rp[2]];?></td>
				
		<td><?=$zone_loc_name_get[$rp[3]];?></td>
			  <td><?=$rp[1];?></td>


			  <td><?=$rp[4];?></td> 
  <td><button type="button" onclick="nav('<?php echo $rp[0];?>');" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button></td>
			  

			 



            </tr>



            <?php }?>



            </tbody>

          </table>



        </div>



      </div>





      <div class="col-md-4 p-0">

        <form id="form1" name="form1" class="n-form" method="post" action="<?=$page?>?<?=$unique?>=<?=$$unique?>">

		

          <h4 align="center" class="n-form-titel1">Lane/Asile</h4>

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

						 <input type="text" name="lane_asile_name" class="form-control"  id="lane_asile_name" value="<?=$lane_asile_name;?>"/>
						 <input type="hidden" name="<?=$unique?>" class="form-control"  id="<?=$unique?>" value="<?=$$unique?>"/>

                    </div>

                </div>

	 
<div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Description:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

						 <input type="text" name="lane_description" class="form-control"  id="lane_description" value="<?=$lane_description;?>"/>
					 

                    </div>

                </div>
		  

		  
		  
		  
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