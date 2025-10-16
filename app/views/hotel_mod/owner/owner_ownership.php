<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Ownership Details';			// Page Name and Page Title
$page="owner_ownership.php";		// PHP File Name

$table='hms_ownership';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='room_id';
// ::::: End Edit Section :::::

//var_dump($_POST);
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

					
					
				<? 	$res='select d.id,b.name,a.room_name,c.session from hms_hotel_room a, hms_owner_detail b, hms_owner_session c, hms_ownership d where a.id=d.room_id and b.id=d.owner_id and c.id=d.session_id';
											echo $crud->link_report($res,$link);?>
                    

                </form>
            </div>           

        </div>


        <div class="col-sm-6">
            
			
            <form class="n-form" action="" method="post" enctype="multipart/form-data" name="form1" id="form1" >
                <h4 align="center" class="n-form-titel1">Ownership Details</h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Room Name :</label>
                    <div class="col-sm-9 p-0">
					<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
<select name="room_id" id="room_id">
<? 
$sql="SELECT a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b WHERE b.id=a.room_type_id order by b.room_type";
advance_foreign_relation($sql,$room_id);	  
?>
</select>					                   
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Owner Name:</label>
                    <div class="col-sm-9 p-0">
             <select name="owner_id" id="owner_id">
<? 
foreign_relation('hms_owner_detail','id','name',$owner_id);?>
</select>                   
                   
				   </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Session Name :</label>
                    <div class="col-sm-9 p-0">
<select name="session_id" id="session_id">
<? 
foreign_relation('hms_owner_session','id','session',$session_id);?>
</select>
                    </div>
                </div>

<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Ownership Detail :</label>
                    <div class="col-sm-9 p-0">
                <input name="detail" type="text" id="detail" value="<?=$detail?>" />
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