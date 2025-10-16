<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Account Ledger';
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
	//end 
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
		header('Location:account_ledger.php');
		}
	}
}



//for Modify..................................  `depreciation_rate` = '$depreciation_rate',
	//	`credit_limit` 		= '$credit_limit',
	//	`budget_enable`		= '$budget_enable',
	//	`beneficiary_name` 	= '$beneficiary_name',
	//	`accounts_number` 	= '$accounts_number',
	//	`bank_name` 		= '$bank_name',
	//	`branch_name` 		= '$branch_name',
	//	`iban_no` 			= '$iban_no',
	//	`swift_code` 		= '$swift_code',
	//	`purpose`			= '$purpose',
	//	`address` 			= '$address',

if(isset($_POST['mledger']))
{  
if(ledger_redundancy($ledger_name,$ledger_id))
{
echo $sql="UPDATE `accounts_ledger` SET 
		`ledger_name` 		= '$ledger_name',
		`opening_balance` 	= '$opening_balance',
		`ledger_group_id`	= '$ledger_group_id',
		`group_for`			= '$group_for',
		`balance_type` 		= '$balance_type',
		
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


<form id="form2" name="form2" method="post" action="account_ledger_input.php?ledger_id=<?php echo $ledger_id;?>">
							 
									
									
									
	<div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Ledger  Name:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input name="ledger_name" type="text" id="ledger_name" value="<?php echo $data[1];?>" class="required" />
      </div>
    </div>
  </div>	
  
  
  
  <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Ledger Group:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<select name="ledger_group_id" id="ledger_group_id">
			<? 
			
			if($_SESSION['user']['group']>1)
			$sql="SELECT group_id ,group_name FROM ledger_group where group_for=".$_SESSION['user']['group']." order by group_id";
			else
			$sql="SELECT group_id ,group_name FROM ledger_group order by group_id";
			$led=db_query($sql);
			if(mysqli_num_rows($led) > 0)
			{
			while($ledg = mysqli_fetch_row($led)){?>
			<option></option>
			<option value="<?=$ledg[0]?>" <?php if($data[2]==$ledg[0]) echo " Selected "?>><?=$ledg[0].':'.$ledg[1]?></option>
			<? }}?>
			</select>
			
			
			<input name="b_type" type="hidden" id="b_type" value="Both"/>
										
				<input name="budget_enable" type="hidden" id="budget_enable" value="NO"/>
										
										
										<?php 
		if(isset($data[7]))
		{
		?>
          <input name="open_date" type="hidden" id="open_date" value="<?php echo date("d-m-Y",$data[7]);?>"/>
          <?php	}else	{
		?>
          <input name="open_date" type="hidden" id="open_date" value="<?php echo date("d-m-Y",time());?>"/>
          <?php
		}
		?>		
      </div>
    </div>
  </div>
  
  
  
  
  <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Company:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<select name="group_for" id="group_for">
			<? 
			if($_SESSION['user']['group']>1)
			$sql="SELECT id ,group_name FROM user_group where id=".$_SESSION['user']['group']." order by id";
			else
			$sql="SELECT id ,group_name FROM user_group order by id";
			$led=db_query($sql);
			if(mysqli_num_rows($led) > 0)
			{
			while($ledg = mysqli_fetch_row($led)){?>
	<option value="<?=$ledg[0]?>" <?php if($data[10]==$ledg[0]) echo " Selected "?>><?=$ledg[0].':'.$ledg[1]?>
	</option>
			<? }}?>
			</select>
      </div>
    </div>
  </div>				
									

	
	
<!--	<div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Beneficiary Name:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input name="beneficiary_name" type="text" id="beneficiary_name" value="<?php echo $data[10];?>"  />
      </div>
    </div>
  </div>								  
									  

                                      
									  
									  

									  
									  
									  
                                      <tr>
                                        <td>Opening Balance   :</td>
                                        <td><input name="balance" type="text" id="balance" value="<?php echo $data[3];?>"/></td>
									  </tr>-->
                                      <!--<tr>
                                        <td>Transaction Type: </td>
                                        <td><select name="b_type" id="b_type">
                                          <option value="Debit"<?php if($data[4]=='Debit') echo " Selected "?>>Debit</option>
                                          <option value="Credit"<?php if($data[4]=='Credit') echo " Selected "?>>Credit</option>
                                          <option value="Both"<?php if($data[4]=='Both') echo " Selected "?>>Both</option>
                                        </select>
										
										
										
										</td>
                                      </tr>-->
                                      <!--<tr>
                                        <td>Depreciation Rate : </td>
                                        <td><input name="d_rate" type="text" id="d_rate" value="<?php echo $data[5];?>"/></td>
                                      </tr>-->
                                      <!--<tr>
                                        <td>Credit Limit :</td>
                                        <td><input name="cr_limit" type="text" id="cr_limit" value="<?php echo $data[6];?>"/></td>
                                      </tr>-->
									  
									  
									  
                                    <!--  <tr>
                                        <td>Budget Enable: </td>
                                        <td>
										<select name="budget_enable" id="budget_enable">
										<option value="NO"<?php if($data[9]=='NO') echo " Selected "?>>NO</option>
                                          <option value="YES"<?php if($data[9]=='YES') echo " Selected "?>>YES</option>
                                          
                                        </select>
										
										
										</td>
                                      </tr>
									 
									  
	<div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Beneficiary Bank:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input name="bank_name" type="text" id="bank_name" value="<?php echo $data[16];?>" />
      </div>
    </div>
  </div>
  
  
  <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Branch Name:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input name="branch_name" type="text" id="branch_name" value="<?php echo $data[19];?>" />
      </div>
    </div>
  </div>
  
   <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Account No:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input name="accounts_number" type="text" id="accounts_number" value="<?php echo $data[14];?>"  />	
      </div>
    </div>
  </div>
  
  
    <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">IBAN No:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input name="iban_no" type="text" id="iban_no" value="<?php echo $data[20];?>" />	
      </div>
    </div>
  </div>
  
    <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Swift Code:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input name="swift_code" type="text" id="swift_code" value="<?php echo $data[15];?>" />		
      </div>
    </div>
  </div>
  
   <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Purpose:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input name="purpose" type="text" id="purpose" value="<?php echo $data[16];?>" />	
      </div>
    </div>
  </div>
  
   <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Address:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input name="address" type="text" id="address" value="<?php echo $data[17];?>" />	
      </div>
    </div>
  </div> -->
  
  
  <div class="form-group row">
    <label for="inputEmail3MD" class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
  <? if($data[0]==""){?>
 <input name="nledger" type="submit" id="nledger" value="Record" onclick="return checkUserName()" class="btn" /><? }?>
 <? if($data[0]!=""){?><input name="mledger" type="submit" id="mledger" value="Modify" class="btn" /><? }?>
 <input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='account_ledger.php'"/>
 <? if($_SESSION['user']['level']==10){?><input class="btn" name="dledger" type="submit" id="dledger" value="Delete"/><? }?>
 
      </div>
    </div>
  </div>
									  

    </form>
	
<script type="text/javascript">

function DoNav(theUrl)



{



	document.location.href = 'account_ledger.php?ledger_id='+theUrl;



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