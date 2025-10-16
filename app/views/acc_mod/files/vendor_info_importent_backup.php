<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Vendor Information';
$proj_id=$_SESSION['proj_id'];
//echo $proj_id;
$payable=find_a_field('config_group_class','payable',"1");
$vendor_id		= $_REQUEST['vendor_id'];
$vendor_name	= $_REQUEST['vendor_name'];
$vendor_name	= str_replace("'","",$vendor_name);
$vendor_name	= str_replace("&","",$vendor_name);
$vendor_name	= str_replace('"','',$vendor_name);
$vendor_company	= $_REQUEST['vendor_company'];
$address		= $_REQUEST['address'];
$contact		= $_REQUEST['contact'];
$vendor_type	= $_REQUEST['vendor_type'];
$contact_person_designation	= $_REQUEST['contact_person_designation'];
$now			= time();
//end 
if(isset($_POST['nvendor']))
{
	$check="select vendor_id from vendor where vendor_name='$vendor_name' limit 1";
	if(mysqli_num_rows(db_query($check))>0)
	{
		$aaa=mysqli_num_rows(db_query($check));
		$vendor_id=$aaa[0];
			$type=0;
			$msg='Given Name('.$vendor_name.') is already exists.';
	}
	else
	{
		$vendor_id=number_format(next_sub_ledger_id($payable), 0, '.', '');
		sub_ledger_create($vendor_id,$vendor_name, $payable, '0.00', $now, $proj_id);
		ledger_create($vendor_id,$vendor_name,$payable,'0.00','Both','','', time(),$proj_id,'NO');
		$sql="INSERT INTO `vendor` (
		vendor_id,
		`vendor_name`,
		`vendor_company`,
		`address`,
		`contact_no`,
		`vendor_type`,
		contact_person_designation
		)
		VALUES ('$vendor_id','$vendor_name', '$vendor_company', '$address', '$contact', '$vendor_type','$contact_person_designation')";
		//echo $sql;
		$query=db_query($sql);
		$type=1;
		$msg='New Entry Successfully Inserted.';
	}
}


if(isset($_POST['mvendor']))
{
$search_sql="select 1 from vendor where `vendor_id`!='$vendor_id' and `vendor_name` = '$vendor_name' limit 1";
if(mysqli_num_rows(db_query($search_sql))==0)
	{
		$sql="UPDATE `vendor` SET
							`vendor_name`		= '$vendor_name', 
							`vendor_company` 	= '$vendor_company',
							`address` 			= '$address',
							`contact_no` 		= '$contact',
							`vendor_type` 		= '$vendor_type',
							`contact_person_designation`='$contact_person_designation'
							 WHERE 
							 `vendor_id` 		= $vendor_id LIMIT 1";
		$qry=db_query($sql);
$sql2="UPDATE `accounts_ledger` SET 
`ledger_name` 		= '$vendor_name'	
WHERE `ledger_id` 		='$vendor_id' LIMIT 1";
$sql="UPDATE `sub_ledger` SET
`sub_ledger` = '$vendor_name'
WHERE `sub_ledger_id` =$vendor_id LIMIT 1";
$query=db_query($sql);
$query=db_query($sql2);
		$type=1;
		$msg='Successfully Updated.';
	}
		else
	{
	$type=0;
	$msg='Given Name('.$vendor_name.') is already exists.';
	}
}
if(isset($_POST['dvendor']))
{

$sql="delete from `vendor` where `vendor_id`='$vendor_id' limit 1";
$query=db_query($sql);
$sql="delete from `sub_ledger` where `sub_ledger_id`='$vendor_id' limit 1";
$query=db_query($sql);
$sql="delete from `accounts_ledger` where `ledger_id`='$vendor_id' limit 1";
$query=db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_REQUEST['vendor_id']))
{
	$vendor_id	= $_REQUEST['vendor_id'];
	$ddd		= "SELECT * FROM vendor WHERE vendor_id='$vendor_id' AND 1";
	$data		= mysqli_fetch_row(db_query($ddd));
}
?><script type="text/javascript">
function DoNav(theUrl)
{
	document.location.href = 'vendor_info.php?vendor_id='+theUrl;
}

</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    <td width="66%" style="padding-right:5%">
	<div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td width="40%" align="right">Vendor Name</td>
                                        <td width="60%" align="right"><input name="vendor" type="text" id="vendor" value="<?php echo $_REQUEST['vendor']; ?>" size="20" /></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Company Name</td>
                                        <td align="right"><input name="com_name" type="text" id="com_name" value="<?php echo $_REQUEST['com_name']; ?>" size="20" /></td>
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
									<table id="grp" class="tabledesign" cellspacing="0">
							  <tr>
								<th>Vendor Company</th>
								<th>Contact Person</th>
								<th>Type</th>
							  </tr>
	<?php
	$rrr="select vendor_id, vendor_name, vendor_company, address, contact_no, vendor_type from vendor where 1";
	if(isset($_REQUEST['search']))
	{
		$vendor		= mysqli_real_escape_string($_REQUEST['vendor']);
		$com_name	= mysqli_real_escape_string($_REQUEST['com_name']);
		$vtype		= mysqli_real_escape_string($_REQUEST['vtype']);
		
		$rrr .= " AND vendor_name LIKE '%$vendor%'";
		$rrr .= " AND vendor_company LIKE '%$com_name%'";
		$rrr .= " AND vendor_type LIKE '%$vtype%'";
				
	} 
	$rrr .= " order by vendor_name";
	$report=db_query($rrr);
	while($rp = mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><?=$rp[1];?></td>
								<td><?=$rp[2];?></td>
								<td><?=$rp[5];?></td>
							  </tr>
	<?php }?>
							</table>									</td>
								  </tr>
								</table>

							</div></td>
    <td><div class="right">  <form id="form2" name="form2" method="post" action="vendor_info.php?vendor_id=<?php echo $vendor_id;?>" onsubmit="return check()">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td><div class="box">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
									
									<tr>
                                        <td>Vendor  ID: </td>
                                        <td><input name="vendor_id" type="text" id="vendor_id" value="<?php echo $data[0];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>Vendor Name: </td>
                                        <td><input name="vendor_name" type="text" id="vendor_name" value="<?php echo $data[4];?>" size="30" maxlength="100" /></td>
									  </tr>
									
                                      <tr>
                                        <td>Beneficiary Name: </td>
                                        <td><input name="vendor_company" type="text" id="vendor_company" value="<?php echo $data[6];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>Beneficiary Bank: </td>
                                        <td><input name="vendor_bank" type="text" id="vendor_bank" value="<?php echo $data[7];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>Account No: </td>
                                        <td><input name="vendor_bank_ac" type="text" id="vendor_bank_ac" value="<?php echo $data[9];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>Branch Name: </td>
                                        <td><input name="branch_name" type="text" id="branch_name" value="<?php echo $data[8];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>IBAN: </td>
                                        <td><input name="iban_no" type="text" id="iban_no" value="<?php echo $data[10];?>" size="30" maxlength="100" /></td>
									  </tr>
									  
									  <tr>
                                        <td>Swift Code: </td>
                                        <td><input name="swift_code" type="text" id="swift_code" value="<?php echo $data[11];?>" size="30" maxlength="100" /></td>
									  </tr>

                                      <tr>
                                        <td>Company:</td>
                                        <td>
										
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
	<option value="<?=$ledg[0]?>" <?php if($data[2]==$ledg[0]) echo " Selected "?>><?=$ledg[0].':'.$ledg[1]?>
	</option>
			<? }}?>
			</select>
										
										</td>
									  </tr>
                                                                            <tr>
                                        <td>Contact Person Designation:</td>
                                        <td><input name="contact_person_designation" type="text" id="contact_person_designation" value="<?php echo $data[7];?>" size="30" maxlength="100" /></td>
									  </tr>
                                      <tr>
                                        <td>Vendor Address   :</td>
                                        <td><textarea name="address" cols="30" rows="10" id="address"><?php echo $data[3];?></textarea></td>
                                      </tr>
                                      <tr>
                                        <td>Contact No:</td>
                                        <td><input name="contact" type="text" id="contact" size="15" maxlength="15" value="<?php echo $data[5];?>"/></td>
                                      </tr>
                                      <tr>
                                        <td>Vendor Type: </td>
                                        <td><select name="vendor_type">
                                          <?php echo (!empty($data[6]))?'<option value="'.$data[6].'">'.$data[6].'</option>':'<option value="">---- Select One ---</option>'; ?>
                                          <option value="Local">Local</option>
                                          <option value="Foreign">Foreign</option>
                                        </select></td>
									  </tr>
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
                                      <td><input name="nvendor" type="submit" id="nvendor" value="Record" class="btn"/></td>
                                      <td><input name="mvendor" type="submit" id="mvendor" value="Modify" class="btn"/></td>
                                      <td><input name="Button" type="button" class="btn" value="Clear" onClick="parent.location='vendor_info.php'"/></td>
                                      <td><input class="btn" name="dvendor" type="submit" id="dvendor" value="Delete"/></td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>9
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
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>