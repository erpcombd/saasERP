<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once(SERVER_CORE.'core/init.php');

$title='Expense Ledger Create';
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
	$group_for			= mysqli_real_escape_string($_REQUEST['group_for']);
	$opening_balance	= mysqli_real_escape_string($_REQUEST['balance']);
	$balance_type		= mysqli_real_escape_string($_REQUEST['b_type']);
	$depreciation_rate	= mysqli_real_escape_string($_REQUEST['d_rate']);
	$credit_limit		= mysqli_real_escape_string($_REQUEST['cr_limit']);
	$date				= mysqli_real_escape_string($_REQUEST['open_date']);
	$now				= date_value($date);
	$budget_enable		= mysqli_real_escape_string($_REQUEST['budget_enable']);
	$beneficiary_name	= mysqli_real_escape_string($_REQUEST['beneficiary_name']);
	$accounts_number	= mysqli_real_escape_string($_REQUEST['accounts_number']);
	$bank_name			= mysqli_real_escape_string($_REQUEST['bank_name']);
	$branch_name		= mysqli_real_escape_string($_REQUEST['branch_name']);
	$iban_no		= mysqli_real_escape_string($_REQUEST['iban_no']);
	$swift_code		= mysqli_real_escape_string($_REQUEST['swift_code']);
	$purpose		= mysqli_real_escape_string($_REQUEST['purpose']);
	$address		= mysqli_real_escape_string($_REQUEST['address']);
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
		$ledger_layer=1;
		if(ledger_create($ledger_id,$ledger_name,$ledger_group_id,$group_for,$opening_balance,$balance_type,$depreciation_rate,$credit_limit, $now,$ledger_layer,$budget_enable,$beneficiary_name,$accounts_number,$bank_name,$branch_name,$iban_no,$swift_code,$purpose,$address))
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


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="65%" style="padding-right:3%">      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
		  
									
									
								
		  <div class="box">
            <form id="form1" name="form1" method="post" action="">
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <tr>
                  <td width="40%" align="right">Ledger Name : </td>
                    <td width="60%" align="right"><input name="ladger_name" type="text" id="ladger_name" value="<?=$_REQUEST['ladger_name']; ?>" /></td>
                  </tr>
                <tr>
                  <td align="right">Ledger Group :                                         </td>
                    <td align="right">
                      <select name="ladger_group" id="ladger_group">
                          <option></option>
  <? 
if($_SESSION['user']['group']>1)
$sql="SELECT group_id ,group_name FROM ledger_group where group_for=".$_SESSION['user']['group']." and group_id=4001 order by group_id";
else
$sql="SELECT group_id ,group_name FROM ledger_group where  group_id=4001 order by group_id";
$led=db_query($sql);
if(mysqli_num_rows($led) > 0)
{
while($ledg = mysqli_fetch_row($led)){?>
  <option value="<?=$ledg[0]?>" <?php if($_POST['ladger_group']==$ledg[0]) echo " Selected "?>> <?=$ledg[0].':'.$ledg[1]?>
  </option>
  <? }}?>									</select> 
  
  
                     </td>
                  </tr>
                <tr>
                  <td colspan="2"><input class="btn" name="search" type="submit" id="search" value="Show" /></td>
                  </tr>
                </table>
	      </form></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
		    </tr>
        <tr>
          <td>
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

 $rrr = "select l.ledger_id, l.ledger_name, g.group_name from accounts_ledger l, ledger_group g WHERE   l.ledger_group_id=g.group_id and  l.ledger_group_id=4001 and l.group_for= ".$_SESSION['user']['group'].$con." order by ledger_name asc";}

else{

  $rrr = "select l.ledger_id, l.ledger_name, g.group_name from accounts_ledger l, ledger_group g WHERE l.ledger_id like '%00000000' and l.ledger_group_id=4001 and l.ledger_group_id=g.group_id ".$con." order by ledger_name asc";}
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
		    </tr>
      </table></td><td width="35%" valign="top"><form id="form2" name="form2" method="post" action="account_ledger.php?ledger_id=<?php echo $ledger_id;?>">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  
							  <tr>
								
								
								

                                  <td width="100%" ><div class="box style2" >

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

									  


                                      <tr>

                                        <th style="font-size:16px; padding:5px; color:#FFFFFF" bgcolor="#45777B"> <div align="center">
                                          <?=$title?>
                                        </div></th>
                                      </tr></table>

                                  </div></td>
                                </tr>
							  
							  
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Ledger  Name:</td>
                                        <td><input name="ledger_name" type="text" id="ledger_name" value="<?php echo $data[1];?>" class="required" style="width:250px" /></td>
									  </tr>

                                      <tr>
                                        <td>Ledger Group:</td>
                                        <td>
			<select name="ledger_group_id" id="ledger_group_id" required  style="width:250px">
		
			<? 
			if($_SESSION['user']['group']>1)
			$sql="SELECT group_id ,group_name FROM ledger_group where group_for=".$_SESSION['user']['group']." and  group_id=4001 order by group_id";
			else
			$sql="SELECT group_id ,group_name FROM ledger_group where group_id=4001 order by group_id";
			$led=db_query($sql);
			if(mysqli_num_rows($led) > 0)
			{
			while($ledg = mysqli_fetch_row($led)){?>
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
			
			
			</td>
									  </tr>
									  
									  
									  
									  
									  
									  <tr>
                                        <td>Company:</td>
                                        <td>
			<select name="group_for" id="group_for"  style="width:250px">
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
			

			
			</td>
									  </tr>
									  
									  
									  
                                      <!--<tr>
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
									  -->
									  
									  <!--<tr>
                                        <td>Beneficiary Name: </td>
                                        <td>
						<input name="beneficiary_name" type="text" id="beneficiary_name" value="<?php echo $data[16];?>"  />
										</td>
                                      </tr>
									  
									  <tr>
                                        <td>Beneficiary Bank:</td>
                                        <td>
										<input name="bank_name" type="text" id="bank_name" value="<?php echo $data[18];?>" />
										</td>
                                      </tr>
									  
									  <tr>
                                        <td>Branch Name:</td>
                                        <td>
										<input name="branch_name" type="text" id="branch_name" value="<?php echo $data[19];?>" />
										</td>
                                      </tr>
                                      
									  
									  <tr>
                                        <td>Account No: </td>
                                        <td>
										<input name="accounts_number" type="text" id="accounts_number" value="<?php echo $data[17];?>"  />
										</td>
                                      </tr>
									  
									  <tr>
                                        <td>IBAN No:</td>
                                        <td>
							<input name="iban_no" type="text" id="iban_no" value="<?php echo $data[20];?>" />
										</td>
                                      </tr>
									  
									   <tr>
                                        <td>Swift Code:</td>
                                        <td>
										<input name="swift_code" type="text" id="swift_code" value="<?php echo $data[21];?>" />
										</td>
                                      </tr>-->
									  <!--<tr>
                                        <td>Purpose:</td>
                                        <td>
										<input name="purpose" type="text" id="purpose" value="<?php echo $data[20];?>" />
										</td>
                                      </tr>
									  <tr>
                                        <td>Address:</td>
                                        <td>
										<input name="address" type="text" id="address" value="<?php echo $data[23];?>" />
										</td>
                                      </tr>-->
                                    </table>
                                  </div></td>
                                </tr>
                                
                                
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>
								  <div class="box1">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td>
									  <? if($data[0]==""){?>
									  <input name="nledger" type="submit" id="nledger" value="Record" onclick="return checkUserName()" class="btn" /><? }?></td>
                                      <td>
									  <? if($data[0]!=""){?><input name="mledger" type="submit" id="mledger" value="Modify" class="btn" /><? }?></td>
                                      <td><input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='account_ledger.php'"/></td>
                                      <td><? if($_SESSION['user']['level']==10){?><input class="btn" name="dledger" type="submit" id="dledger" value="Delete"/><? }?></td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</td>
  </tr>
</table>
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




<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>