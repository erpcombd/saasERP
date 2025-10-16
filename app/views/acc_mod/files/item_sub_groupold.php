<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Product Sub Group';
$proj_id=$_SESSION['proj_id'];

$now=time();
$unique='sub_group_id';
$unique_field='sub_group_name';
$table='item_sub_group';
$page="item_sub_group_add.php";
$crud      =new crud($table);
$$unique = $_GET[$unique];
$active='productsub';

if(isset($_POST[$unique_field]))
{
$$unique = $_POST[$unique];
//for Record..................................

if(isset($_POST['record']))
{
$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];



$min=number_format($_POST['group_id']+10000, 0, '.', '');
$max=number_format($_POST['group_id']+100000000, 0, '.', '');
echo $_POST[$unique]=number_format(next_value('sub_group_id','item_sub_group','10000',$min,$min,$max), 0, '.', '');
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

{		

		$condition=$unique."=".$$unique;		
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
foreach ($data as $key => $value)
{ $$key=$value;}
}


?>

<script type="text/javascript">
function Do_Nav()
{
	var URL = 'pop_ledger_selecting_list.php';
	popUp(URL);
}
$(document).ready(function(){
	
	$("#form1").validate();	
});	
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


<table class="table table-bordered" border="0" cellspacing="0" cellpadding="0" id="data_table_inner" class="display" >

							<thead >	
							  <tr>
								<th>Sub Group ID</th>
								<th>Sub Group Name</th>
								<th>Group Name</th>
							  </tr>
							  </thead>
							  <tbody>
<?php
	$rrr = "select b.sub_group_id,b.sub_group_id,a.group_name, b.sub_group_name from item_sub_group b,item_group a where a.group_id=b.group_id";

	$report = db_query($rrr);
	$i=0;
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[1];?></td>
								<td><?=$rp[3];?></td>
								<td><?=$rp[2];?></td>
							  </tr>
	<?php }?>
	</tbody>
		</table>
		
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout2.php");
?>