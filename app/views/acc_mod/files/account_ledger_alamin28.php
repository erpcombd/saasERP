<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Account Ledger';
$input_page="account_ledger_input.php"; $add_button_bar = 'Mhafuz';
$proj_id=$_SESSION['proj_id'];
$now=time();
do_datatable('ac_ledger');
$separator	= $_SESSION['separator'];
function add_separator(){}
if(isset($_REQUEST['ledger_name'])||isset($_REQUEST['ledger_id']))
{
	//common part.............
	
	$ledger_id			= mysqli_real_escape_string($_REQUEST['ledger_id']);
	$ledger_name 		= mysqli_real_escape_string($_REQUEST['ledger_name']);
	$ledger_name		= str_replace("'","",$ledger_name);
	$ledger_name		= str_replace("&","",$ledger_name);
	$ledger_name		= str_replace('"','',$ledger_name);
	
	$ledger_group_id	= mysqli_real_escape_string($_REQUEST['ledger_group_id']);
	
	$group_for			= $_SESSION['user']['group'];
	$balance_type		= "Both";
	$depreciation_rate	= '';
	$credit_limit		= "";
	
	$budget_enable		= mysqli_real_escape_string($_REQUEST['budget_enable']);
	$master_ledger_id	= 0;
	$master_sub_ledger_id=0;
	$ledger_type		='';
	$ledger_layer		=1;

	if(isset($_POST['nledger']))
	{
		
	if(!ledger_redundancy($ledger_name))
	{
	$type=0;
	$msg='Given Name('.$ledger_name.') is already exists.';
	}
	else
	{
	$ledger_id=next_ledger_id($ledger_group_id);
	if(ledger_create($ledger_id, $ledger_name, $ledger_group_id, $group_for, $balance_type, $depreciation_rate, $credit_limit, $budget_enable,$master_ledger_id,$master_sub_ledger_id,$ledger_type,$ledger_layer))
		{
		$type=1;
		$msg='New Entry Successfully Inserted.';
		}
	}
}



//for Modify..................................

if(isset($_POST['mledger']))
{
if(ledger_redundancy($ledger_name,$ledger_id))
{
 $sql="UPDATE `accounts_ledger` SET 
		`ledger_name` 		= '$ledger_name',
		`opening_balance` 	= '$opening_balance',
		`ledger_group_id`	= '$ledger_group_id',
		`group_for`			= '$group_for',
		`balance_type` 		= '$balance_type',
		`depreciation_rate` = '$depreciation_rate',
		`credit_limit` 		= '$credit_limit',
		`budget_enable`		= '$budget_enable',
		`beneficiary_name` 	= '$beneficiary_name',
		`accounts_number` 	= '$accounts_number',
		`bank_name` 		= '$bank_name',
		`branch_name` 		= '$branch_name',
		`iban_no` 			= '$iban_no',
		`swift_code` 		= '$swift_code',
		`purpose`			= '$purpose',
		`address` 			= '$address',
		`opening_balance_on`= '$now'
	WHERE `ledger_id` 		= '$ledger_id' LIMIT 1";

		if(db_query($sql))
		{
		$type=1;
		$msg='Successfully Updated.';
		}
	}
	else
	{
	$type=0;
	$msg='Given Name('.$ledger_name.') is already exists.';
	}
}

//for Delete..................................

if(isset($_POST['dledger']))
{
$ledger_id = $_REQUEST['ledger_id'];
$sql="delete from `accounts_ledger` where `ledger_id`='$ledger_id' limit 1";
$query=db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
}


$ddd="select * from accounts_ledger where ledger_id='$ledger_id'";
$dddd=db_query($ddd);
if(mysqli_num_rows($dddd)>0)
$data = mysqli_fetch_row($dddd);
}
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>

 <table id="ac_ledger" class="table table-striped table-bordered" style="width:100%">
			<thead>
              <tr>
                <th width="200px" bgcolor="#45777B"><span class="style1">A/C Code</span></th>
			    <th bgcolor="#45777B"><span class="style1">Ledger Name</span></th>
			    <th bgcolor="#45777B"><span class="style1">Ledger Group</span></th>
		      </tr>
			  </thead><tbody>
  <?php
if($_POST['ladger_name']!="" && $_POST['ladger_group']==""){
		$con.= " AND l.ledger_name like '%".$_POST['ladger_name']."%' ";
		}
		
		if($_POST['ladger_group']!="" && $_POST['ladger_name']==""){
		$con.= " AND g.group_id = ".$_POST['ladger_group']." ";
		}
		if($_POST['ladger_group']!="" && $_POST['ladger_name']!=""){
			$con.= " AND l.ledger_name like '%".$_POST['ladger_name']."%' AND g.group_id = ".$_POST['ladger_group']." ";
			}

	if($_SESSION['user']['group']>1){

 $rrr = "select l.ledger_id, l.ledger_name, g.group_name from accounts_ledger l, ledger_group g WHERE   l.ledger_group_id=g.group_id and l.group_for= ".$_SESSION['user']['group'].$con." order by ledger_name asc";}

else{

  $rrr = "select l.ledger_id, l.ledger_name, g.group_name from accounts_ledger l, ledger_group g WHERE l.ledger_id like '%00000000' and  l.ledger_group_id=g.group_id ".$con." order by ledger_name asc";}
	$report=db_query($rrr);
	//echo $rrr;
	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
              
              <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
                <td><nobr><?=$rp[0];?></nobr></td>
			    <td><?=$rp[1];?></td>
		        <td><?=$rp[2];?></td>
		      </tr>
              <?php }?></tbody>
          </table>									</td>
		
<script type="text/javascript">

function DoNav(theUrl)



{



	document.location.href = 'account_ledger_input.php?ledger_id='+theUrl;



}



function popUp(URL) 



{



	day = new Date();



	id = day.getTime();



	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");



}



</script>


<? create_combobox('ledger_group_id'); ?>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>