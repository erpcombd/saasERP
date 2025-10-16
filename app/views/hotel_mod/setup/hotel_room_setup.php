<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Hotel Room Setup';			// Page Name and Page Title
$page="hotel_room_setup.php";		// PHP File Name

$table='hms_hotel_room';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='room_name';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];
$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert']))
{		
$proj_id			= $_SESSION['proj_id'];
$now				= time();


$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
}


//for Modify..................................

if(isset($_POST['update']))
{

		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		$type=1;
		$msg='Successfully Deleted.';
}
}

if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
foreach($data as $key => $value)
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>

<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}

function popUp(URL) 
{
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}
</script>


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <div class="container n-form1">
	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

					
					
					<? 	$res='select '.$unique.',room_no,'.$shown.' from '.$table.' order by room_no';
											echo $crud->link_report($res,$link);?>

                    

                </form>
            </div>           

        </div>


        <div class="col-sm-6">
            
			
            <form class="n-form" action="" method="post" enctype="multipart/form-data" name="form1" id="form1" >
                <h4 align="center" class="n-form-titel1">Hotel Room Setup</h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Room Name : </label>
                    <div class="col-sm-9 p-0">
<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                          <input name="room_name" type="text" id="room_name" value="<?=$room_name?>">
										                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label "> Room No : </label>
                    <div class="col-sm-9 p-0">
<input name="room_no" type="text" id="room_no" value="<?=$room_no?>" />                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Floor Name : </label>
                    <div class="col-sm-9 p-0">
<select name="floor_id" id="floor_id">
                                          <? foreign_relation('hms_hotel_floor','id','floor_name',$floor_id);?></select>                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Room Type : </label>
                    <div class="col-sm-9 p-0">
<select name="room_type_id" id="room_type_id">
                                          <? foreign_relation('hms_room_type','id','room_type',$room_type_id);?></select>
                    </div>
                </div> 
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Room Status : </label>
                    <div class="col-sm-9 p-0">
<select name="status" id="status">
                                          <option value="0" <? if($status==0) echo 'selected';?>>Out Of Order</option>
										  <option value="1" <? if($status==1) echo 'selected';?>>Free for Rent</option>
                                          <option value="2" <? if($status==2) echo 'selected';?>>Dirty</option>
                                          <option value="9" <? if($status==9) echo 'selected';?>>Checked IN</option>
										  </select>
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Status Details :</label>
                    <div class="col-sm-9 p-0">
<input name="status_detail" type="text" id="status_detail" value="<?=$status_detail?>">
                    </div>
                </div>             
				
				  

                <div class="n-form-btn-class">
                      
					   <? if(!isset($_GET[$unique])){?>
										<input name="insert" type="submit" id="insert" value="Save" class="btn1 btn1-bg-submit"/>
										<? }?>
										
										<? if(isset($_GET[$unique])){?>
										<input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-update" />
										<? }?>
			 <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
			 	<input class="btn1 btn1-bg-cancel" name="delete" type="submit" id="delete" value="Delete"/>

	

                </div>


            </form>

        </div>

    </div>




</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>