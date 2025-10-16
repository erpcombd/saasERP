<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

// ::::: Edit This Section ::::: 
$title='Company Concerns ';	// Page Name and Page Title
do_datatable('table_head');
$page="user_group.php";	// PHP File Name
$table='user_group';	// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='group_name';	// For a New or Edit Data a must have data field
// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);
$$unique = $_GET[$unique];

if(isset($_POST[$shown])){
$$unique = $_POST[$unique];

//for Insert..................................
if(isset($_POST['insert'])){
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = $now=date('Y-m-d H:i:s');
 	$proj_id			= $_SESSION['proj_id'];
	$now				= time();
	$entry_by = $_SESSION['user'];

	$folder = 'company_logo';
	$field = 'company_logo';
	//$file_name = rand(1000, 9999);
	$file_name = find_a_field('user_group','MAX(id) as id','1')+1;
	if (!empty($_FILES[$field]['tmp_name'])) {
		$_POST[$field] = logo_upload($folder, $field, $file_name);
		$crud->insert();
	}

	$type=1;
	$msg='New Entry Successfully Inserted.';
	unset($_POST);
	unset($$unique);

}

//for Modify..................................
if(isset($_POST['update'])){
	$_POST['edit_by'] = $_SESSION['user']['id'];
 	$_POST['edit_at'] = $now=date('Y-m-d H:i:s');
	$id = $_POST['id'];
		
    $folder='company_logo';
    $field = 'company_logo';
    //$file_name =  rand(1000, 9999);
	$file_name = $id;

	//verify old logo
    $existing_file = $data->company_logo ?? ''; //Replace old logo with db new company_logo logo
	
    if (!empty($_FILES[$field]['tmp_name'])) {
        $_POST[$field] = logo_upload($folder, $field, $file_name); //upload new logo
		// remove old logo
        if (!empty($existing_file)) {
            $old_file_path = "../../../../public/uploads/" . $folder . "/" . $_SESSION['proj_id'] . "/" . $existing_file; // this is the path of old logo
            if (file_exists($old_file_path)) {
                unlink($old_file_path);
            }
        }
    }
	
    $crud->update($unique);
	$type=1;
	$msg='Successfully Updated.';
}

//for Delete..................................
if(isset($_POST['delete'])){		
	$condition=$unique."=".$$unique;		$crud->delete($condition);
	unset($$unique);
	$type=1;
	$msg='Successfully Deleted.';

}

}

if(isset($$unique)){
	$condition=$unique."=".$$unique;
	$data=db_fetch_object($table,$condition);
	foreach ($data as $key => $value){ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

?>

<script type="text/javascript">

$(function() {

		$("#fdate").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'yy-mm-dd'

		});

});

function Do_Nav()

{

	var URL = 'pop_ledger_selecting_list.php';

	popUp(URL);

}




function DoNav(theUrl)

{

	document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;

}

function popUp(URL) 

{

	day = new Date();

	id = day.getTime();

	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>


<div class="container-fluid p-0">
    <div class="row">
        <div class="col-sm-7 p-0 pr-2">

            <div class="container n-form1">
                <table  id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">
					<thead>
						<tr class="bgc-info">
							  <th><span> ID</span></th>
							
							  <th><span>Logo</span></th>
							  <th><span>Concern Name </span></th>
							   <th><span>Concern Address </span></th>
						</tr>
					</thead>
					
					<tbody>
					
						<?php
						if($_POST['group_for']!="")
						$con .= 'and a.group_for="'.$_POST['group_for'].'"';
						if($_POST['warehouse_id']!="")
						$con .= 'and a.warehouse_id="'.$_POST['warehouse_id'].'"';

						if($_POST['username']!="")

						$con .='and a.username like "%'.$_POST['username'].'%" ';
						$td='select a.'.$unique.',  a.'.$shown.' ,  a.address,a.company_logo  from '.$table.' a where 1 order by a.id  ';
						$report=db_query($td);
						while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
						
						<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
						  <td><?=$rp[0];?></td>
      					  <td><img src="<?=SERVER_UPLOAD?>company_logo/<?=$_SESSION['proj_id']?>/<?=$rp[3]?>" style="width:80px;" /></td>
						  <td><?=$rp[1];?></td>
						  <td><?=$rp[2];?></td>
						</tr>
						
						<?php }?>
					</tbody>
					</table>
					
					
					
					<div id="pageNavPosition"></div>	
					
				</div>

        </div>


        <div class="col-sm-5 p-0  pl-2">
            
            <form id="form1" name="form1" class="n-form  setup-fixed" method="post" action="" enctype="multipart/form-data">
                <h4 align="center" class="n-form-titel1"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input"> Concern Name</label>
                    <div class="col-sm-9 p-0">
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       	<input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        <input name="group_name" required type="text" id="group_name" tabindex="1" value="<?=$group_name?>" >	


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Concern Description </label>
                    <div class="col-sm-9 p-0">
                        <input name="description"  type="text" id="description" tabindex="1" value="<?=$description?>" >

                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Concern Address  </label>
                    <div class="col-sm-9 p-0">

                        <input name="address" type="text" id="address" tabindex="2" value="<?=$address?>">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Concern Phone  </label>
                    <div class="col-sm-9 p-0">

                       <input name="phone" type="text" id="phone" tabindex="2" value="<?=$phone?>">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Mobile  </label>
                    <div class="col-sm-9 p-0">

                       <input name="mobile" type="text" id="mobile" tabindex="8" value="<?=$mobile?>"/>

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Email  </label>
                    <div class="col-sm-9 p-0">

                        <input name="email" type="text" id="email" tabindex="8" value="<?=$email?>">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Website  </label>
                    <div class="col-sm-9 p-0">

                        <input name="website" type="text" id="website" tabindex="8" value="<?=$website?>"/>

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Company Logo  </label>
                    <div class="col-sm-9 p-0">

                        <input name="company_logo" type="file" id="company_logo" value="<?=$company_logo?>" />

                    </div>
                </div>

                <div class="n-form-btn-class">
                   <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-submit" />
                      <? }?>
                    
                 
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />
                      <? }?>
                  
                 
                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />

                </div>


            </form>

        </div>

    </div>




</div>







<script type="text/javascript"><!--

    var pager = new Pager('grp', 10000);

    pager.init();

    pager.showPageNav('pager', 'pageNavPosition');

    pager.showPage(1);

//-->

	document.onkeypress=function(e){

	var e=window.event || e

	var keyunicode=e.charCode || e.keyCode

	if (keyunicode==13)

	{

		return false;

	}

}

</script>




<script>


function duplicate(){

var dealer_code_2 = ((document.getElementById('dealer_code_2').value)*1);

var customer_id = ((document.getElementById('customer_id').value)*1);



   if(dealer_code_2>0)
  {
  
alert('This customer code already exists.');
document.getElementById('customer_id').value='';


document.getElementById('customer_id').focus();

  } 



}

</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>