<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Owner Information';			// Page Name and Page Title
$page="owner_detail.php";		// PHP File Name

$table='hms_owner_detail';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='name';				// For a New or Edit Data a must have data field

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

					
					
				<? 	$res='select '.$unique.','.$unique.','.$shown.' from '.$table;
											echo $crud->link_report($res,$link);?>
                    

                </form>
            </div>           

        </div>


        <div class="col-sm-6">
            
			
            <form class="n-form" action="" method="post" enctype="multipart/form-data" name="form1" id="form1" >
                <h4 align="center" class="n-form-titel1">Owner Information</h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Owner Name :</label>
                    <div class="col-sm-9 p-0">
					<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                          <input name="name" type="text" id="name" value="<?=$name?>">							                   
					</div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Address:</label>
                    <div class="col-sm-9 p-0">
             <input name="address" type="text" id="address" value="<?=$address?>" />                   
                   
				   </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Owner Type :</label>
                    <div class="col-sm-9 p-0">
<input name="owner_type" type="text" id="owner_type" value="<?=$owner_type?>" />
                    </div>
                </div>

<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Share No:</label>
                    <div class="col-sm-9 p-0">
                <input name="share_no" type="text" id="share_no" value="<?=$share_no?>" />
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Invested Amount:</label>
                    <div class="col-sm-9 p-0">
                 <input name="invested_amount" type="text" id="invested_amount" value="<?=$invested_amount?>" />                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Profit Ratio:</label>
                    <div class="col-sm-9 p-0">
                 <input name="ratio" type="text" id="ratio" value="<?=$ratio?>" />
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Username:</label>
                    <div class="col-sm-9 p-0">
                 <input name="username" type="text" id="username" value="<?=$username?>" />
                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Password:</label>
                    <div class="col-sm-9 p-0">
                 <input name="password" type="text" id="password" value="<?=$password?>" />
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