<?php
session_start();
ob_start();
//require "../../support/inc.all.php";

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Vendor Information';
do_datatable('vendor_table');
$proj_id=$_SESSION['proj_id'];
//echo $proj_id;
$input_page="vendor_category_input.php"; $add_button_bar = 'Mhafuz';


$title='Vendor Category';			// Page Name and Page Title
$page="vendor_category.php";		// PHP File Name

$table='vendor_category';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='category_name';	

$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert']))
{		
$proj_id			= $_SESSION['proj_id'];
$now				= time();

		$_POST['entry_at']=date('Y-m-d h:i:s');
		$_POST['entry_by']=$_SESSION['user']['id'];
$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
}


//for Modify..................................

if(isset($_POST['update']))
{
		$_POST['edit_at']=date('Y-m-d h:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
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

<script type="text/javascript">
function DoNav(theUrl)
{
	document.location.href = 'vendor_info.php?vendor_id='+theUrl;
}

</script>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
<!--input button-->

<!--input button-->
	
									<table id="vendor_table" class="table table-bordered" cellspacing="0">
									<thead>
							  <tr>
								<th width="83" bgcolor="#45777B"><span class="style1">Category ID</span></th>
								<th width="85" bgcolor="#45777B"><span class="style1">Category Name </span></th>
							  </tr>
							  </thead>
							  
							  <tbody>
<?php
	 $res='select '.$unique.','.$unique.','.$shown.' from '.$table;
	

	$report = db_query($res);
	$i=0;
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[0];?></td>
								<td><?=$rp[2];?></td>
							   </tr>
							   
	<?php }?></tbody>
							</table>									</td>
							
							
					
<script type="text/javascript">

function DoNav(theUrl)



{



	document.location.href = 'vendor_category_input.php?id='+theUrl;



}



function popUp(URL) 



{



	day = new Date();



	id = day.getTime();



	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");



}



</script>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>