<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
/////////////////////////////////////////////////////////////////
/////////////////////  COMMON FUNCTIONS  ////////////////////////
/////////////////////////////////////////////////////////////////


// ::::: Edit This Section ::::: 

$title='Module Management';			// Page Name and Page Title

$page="module_manage.php";		// PHP File Name

$input_page="module_manage_input.php";

$root='user_management';

$link = $input_page;

$table='user_module_manage';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='module_name';				// For a New or Edit Data a must have data field

$add_button_bar = 'Mhafuz';
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

             <?  $res='select id,id as module_id,module_name,dev_status, status as active from user_module_manage';
		  
		echo link_report1($res,$link);?>

        </div>



    </form>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>