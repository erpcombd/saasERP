<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$now=time();
$title='Vehicle Manage';

$unique='vehicle_id';
$unique_field='vech_reg_no';
$table='vehicle_info';
$page="vehicle.php";

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
$_POST['edit_at']=date('Y-m-d H:i:s');
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
            <div class="col-sm-7 pr-2 pl-0">
                <div class="container n-form1">



                    <table  id="table_head" class="table1  table-striped table-bordered table-hover table-sm" cellspacing="0">
                        <thead class="thead1">
                        <tr class="bgc-info" >
                            <th><span class="style3">Vehicle ID</span></th>
							
							<th ><span class="style3">Warehouse Name </span></th>

                            <th ><span class="style3">Vehicle Name </span></th>

                            <!--<th ><span class="style3">Ledger</span></th>-->
                        </tr>
                        </thead>

                        <tbody class="tbody1">

                        <?php

                        $rrr = "select * from vehicle_info order by vehicle_id ";
                        $report=db_query($rrr);

                        while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
                            <tr<?=$cls?> onclick="nav('<?php echo $rp[0];?>');">
                                <td><?=$rp[0];?></td>
								
								<td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$rp[7]);?></td>

                                <td><?=$rp[1];?></td>

                                

                            </tr>

                        <?php }?>

                        </tbody>
                    </table>


                </div>

            </div>


            <div class="col-sm-5 p-0">


                <form class="n-form"  id="form1" name="form1" method="post" action="<?=$page?>?<?=$unique?>=<?=$$unique?>">
                    <h4 align="center" class="n-form-titel1"> <?=$title?></h4>
					
					
					<div class="form-group row m-0 pl-3 pr-3 pt-1">
					<? $field='depot_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name'; if($$field=='') $$field=$req_all->warehouse_id;?>
                        <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 pl-0 pr-0 d-flex justify-content-end align-items-center pr-1 req-input"> Depot Name</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						<input type="hidden" id="<?=$unique?>" name="<?=$unique?>" value="<? if($$unique>0) echo $$unique?>"/>
						<select id="depot_id" name="depot_id" required style="width:220px;"    >
								<option></option>
								<? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'1');?>
									
							</select>



                        </div>
                    </div>

                    <div class="form-group row m-0 pl-3 pr-3 pt-1">
                        <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 pl-0 pr-0 d-flex justify-content-end align-items-center pr-1  ">Vehicle Reg. No.</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input name="vech_reg_no" type="text" id="vech_reg_no" value="<?=$vech_reg_no?>"/>
                        </div>
                    </div>


                    

                    <div class="form-group row m-0 pl-3 pr-3 pt-1">
                        <label for="group_name" class=" col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 pl-0 pr-0 d-flex justify-content-end align-items-center pr-1 "> Vehicle Type</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <textarea name="vehicle_name" type="text" id="vehicle_name"><?=$vehicle_name;?></textarea>
                        </div>
                    </div>

                    <div class="form-group row m-0 pl-3 pr-3 pt-1">
                        <label for="group_name" class=" col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 pl-0 pr-0 d-flex justify-content-end align-items-center pr-1 ">Driver Name
</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input name="driver_name" type="text" id="driver_name" value="<?=$driver_name?>" />
                        </div>
                    </div>

                    <div class="form-group row m-0 pl-3 pr-3 pt-1">
                        <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 pl-0 pr-0 d-flex justify-content-end align-items-center pr-1 ">Driver ID
</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input name="driver_id" type="text" id="driver_id" value="<?=$driver_id?>" />
                        </div>
                    </div>

                    <div class="form-group row m-0 pl-3 pr-3 pt-1">
                        <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 pl-0 pr-0 d-flex justify-content-end align-items-center pr-1 ">Driver Designation
</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input name="driver_desig" type="text" id="driver_desig" value="<?=$driver_desig?>" />
                        </div>
                    </div>




                    <div class="form-group row m-0 pl-3 pr-3 pt-1">
                        <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 pl-0 pr-0 d-flex justify-content-end align-items-center pr-1 ">Driver Contact Number
</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input name="driver_num" type="text" id="driver_num" value="<?=$driver_num?>"/>
                        </div>
                    </div>



                    <div class="n-form-btn-class">

                        <? if(!isset($_POST[$unique])&&!isset($_GET[$unique])) {?>
                            <input name="record" type="submit" id="record" value="Record" onclick="return checkUserName()" class="btn1 btn1-bg-submit" />
                        <? }?>

                            <? if(isset($_POST[$unique])||isset($_GET[$unique])) {?>
                                <input name="modify" type="submit" id="modify" value="Modify" class="btn1 btn1-bg-update" />

                            <? }?>

                        <input name="clear" type="button" class="btn1 btn1-bg-update" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/>

                            <? if($_SESSION['user']['level']==5){?>
                                <!--<input class="btn1 btn1-bg-cancel" name="delete" type="submit" id="delete" value="Delete"/>-->

                            <? }?>


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


function getMasterWh(data_no){
//alert(data_no);
		 $.ajax({
		url:'getWhAjax.php',
		method:'POST', 
		dataType:"json",
		data:{
		data_no:data_no	
			},
		success: function(datas,msg){
		 $( function() {
    var availableTags = datas;
    $( "#getWh").html(availableTags);
  } );	
			}
			 }) ;
		  }
		  
		  
		  
		  /*function getMasterWh(data_no){

		 $.ajax({
		url:'getWhAjax.php',
		method:'POST', 
		dataType:"json",
		data:{
		data_no:data_no	
			},
		success: function(datas,msg){
		 $( function() {
	
    var availableTags = datas;
    $( "#master_warehouse_id").autocomplete({
      source: availableTags
    });
  } );	
			}
			 }) ;
		  }*/
		  

</script>


<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>