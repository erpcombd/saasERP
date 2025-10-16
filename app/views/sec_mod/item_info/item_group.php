<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title=' Create Product Group';
$proj_id=$_SESSION['proj_id'];


do_datatable('table_head');

$now=time();
$unique='group_id';
$unique_field='group_name';
$table='item_group';
$page="item_group.php";
$crud      =new crud($table);
$$unique = $_GET[$unique];
$tr_type="Show";
if(isset($_POST[$unique_field]))
{
$$unique = $_POST[$unique];
//for Record..................................

if(isset($_POST['record']))
{		
$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['ledger_group_id']=$inventory;



$min=number_format(($inventory*1000000000000)+100000000, 0, '.', '');
$max=number_format(($inventory*1000000000000)+1000000000000, 0, '.', '');
$_POST[$unique]=number_format(next_value('group_id','item_group','100000000',$min,$min,$max), 0, '.', '');

$crud->insert();

$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);
$tr_type="Add";
header("Location: item_group.php");

}





//for Modify..................................



if(isset($_POST['modify']))

{
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		$tr_type="Add";
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
$tr_from="Warehouse";
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
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>



<div class="container-fluid">
	<div class="row">
		<div class="col-sm-7">
			<div class="container">
				<form id="form1" class="n-form1 pt-0" name="form1"  method="post" action="">
				<h3 align="center" class="n-form-titel1 mb-3">Company</h3>

					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Company</label>
						<div class="col-sm-9 p-0">
							<select name="group_for" required id="group_for" tabindex="7">

								<? foreign_relation('user_group','id','group_name',$group_for,'
															  id="'.$_SESSION['user']['group'].'"');?>
							</select>
						</div>
					</div>

					<div class="n-form-btn-class">
						<input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
						<input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Clear" />
					</div>
				</form>
			</div>


			<div class="container n-form1">

				<table id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">
					<thead>
					<tr class="bgc-info">
						<th><span> Group ID </span></th>
						<th><span>Product Group</span></th>
						<th><span>Description</span></th>
					</tr>
					</thead>

					<tbody>

					<?php
					
         

					if($_POST['group_for']!="")

						$con .= 'and b.group_for="'.$_POST['group_for'].'"';



					 $rrr = "select b.group_id,  b.group_name, b.description from item_group b, user_group a where a.id=b.group_for and b.group_for='".$_SESSION['user']['group']."' ";

					$report = db_query($rrr);
					$i=0;
					while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
						<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
							<td><?=$rp[0];?></td>
							<td><?=$rp[1];?></td>
							<td><?=$rp[2];?></td>
						</tr>
					<?php }?>


					</tbody>
				</table>


			</div>

		</div>


		<div class="col-sm-5">
			<form id="form1" class="n-form" name="form1" method="post" action="" onsubmit="return check()">
				<h4 align="center" class="n-form-titel1"><?=$title?></h4>

				<div class="form-group row m-0 pl-3 pr-3">
					<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Group Name </label>
					<div class="col-sm-9 p-0">
						<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />
						<input name="group_name" type="text" id="group_name" value="<?php echo $group_name;?>" class="required" />
						<input name="group_for" type="hidden" id="group_for" value="<?php echo $_SESSION['user']['group'];?>" class="required" />
					</div>
				</div>

				<div class="form-group row m-0 pl-3 pr-3">
					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">Description</label>
					<div class="col-sm-9  p-0">
						<input name="description" type="text" id="description" value="<?php echo $description;?>" class="required" />
					</div>
				</div>

				<div class="n-form-btn-class">
					<? if($$unique<1){?>
						<input name="record" type="submit" class="btn1 btn1-bg-submit" id="record" value="Save" onclick="return checkUserName()" />
					<? }?>

					<? if($$unique>0){?>
						<input name="modify" type="submit" class="btn1 btn1-bg-update" id="modify" value="update" />
					<? }?>

					<input name="clear" type="button" class="btn1 btn1-bg-cancel" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/>
				

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