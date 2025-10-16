<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Report Management';			// Page Name and Page Title
$page="report_manage.php";		// PHP File Name
$input_page="report_manage_input.php";
$link = $input_page;
$add_button_bar = 'Mhafuz';
$root='setup';

$table='report_manage';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='page_name';				// For a New or Edit Data a must have data field
do_datatable('grp');
// ::::: End Edit Section :::::

//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];
$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert']))
{		
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
foreach ($data as $key => $value)
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>

<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '<?=SERVER_ROOT?>app/views/mis_mod/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>
	
<form  action="" method="post">
        <div class="container-fluid pt-5 p-0 ">

             <? 	$res='select p.id,p.id,m.module_name,f.feature_name,p.page_name,p.report_name, p.status
from report_manage p, user_feature_manage f, user_module_manage m 
where m.id=f.module_id and f.id=p.feature_id order by module_name,feature_name,page_name';
		echo link_report1($res,$link);?>

        </div>



    </form>
<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>