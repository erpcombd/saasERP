<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Price Installment';
$proj_id=$_SESSION['proj_id'];
$user_id=$_SESSION['user']['id'];
if(isset($_POST['search']))
{
$flat=$_POST['flat'];
$sql="select * from tbl_flat_info where fid=".$flat." limit 1";
$q=mysql_query($sql);
if(mysql_num_rows($q)>0)
$data=mysql_fetch_object($q);
}
elseif(($_POST['count']>0)&&($_POST['flat']>0))
{
$c 			=$_REQUEST['count'];
$proj_code	=$_REQUEST['proj_code'];
$building	=$_REQUEST['building'];
$flat		=$_REQUEST['flat'];
$flat_no	=$_REQUEST['flat_no'];
$flat_size	=$_REQUEST['flat_size'];
$floor_no	=$_REQUEST['floor_no'];
$garag_no	=$_REQUEST['garag_no'];
$facing		=$_REQUEST['facing'];
$sqft_price	=$_REQUEST['sqft_price'];
$unit_price	=$_REQUEST['unit_price'];
$disc_price	=$_REQUEST['disc_price'];
$payable_price	=$_REQUEST['payable_price'];
$park_price	=$_REQUEST['park_price'];
$total_price	=$_REQUEST['total_price'];
$party_code	=$_REQUEST['party_code'];
$entry_date = date('Y-m-d');

$update_res="UPDATE `tbl_flat_info` SET 
`floor_no` = '$floor_no', 
`garag_no` = '$garag_no', 
`facing` = '$facing', 
`flat_size` = '$flat_size', 
`sqft_price` = '$sqft_price', 
`unit_price` = '$unit_price', 
`disc_price` = '$disc_price', 
`park_price` = '$park_price', 
`party_code` = '$party_code', 
`total_price` = '$total_price' 
WHERE `fid` = ".$flat." LIMIT 1";
$update = mysql_query($update_res);
$delete_res="delete from tbl_flat_cost_installment where proj_code='$proj_code' and build_code='$building' and flat_no='$flat_no'";
$delete = mysql_query($delete_res);
	for($j=1; $j <= $c; $j++)  //data insert loop
	{
		if($_REQUEST['deleted'.$j] == 'no')
		{
		
			$pay_code 	= $_REQUEST['a'.$j];		
			$total_amt	= $_REQUEST['b'.$j];
			$duration 	= $_REQUEST['c'.$j];		
			$no_inst	= $_REQUEST['d'.$j];
			$inst_amt 	= $_REQUEST['e'.$j];		
			$inst_date	= $_REQUEST['f'.$j];

for($i=0;$i<$no_inst;$i++)
{
$dur=($duration*$i);
$stamp_inst_date=date_2_stamp_add_mon_duration($inst_date,$dur);
$final_inst_date=date('Y-m-d',$stamp_inst_date);
$inst_month=date('F',$stamp_inst_date);
$int_year=date('Y',$stamp_inst_date);
$inst_no=$i+1;
$insert_res="INSERT INTO `tbl_flat_cost_installment` 
(`proj_code`, 
`build_code`, 
`flat_no`, 
`pay_code`, 
`inst_no`, 
`inst_amount`, 
`inst_date`, 
`inst_month`, 
`int_year`, 
`rcv_status`, 
`rcv_amount`, 
`entry_by`, 
`entry_date`) 
VALUES ('$proj_code', '$building', '$flat_no', '$pay_code', '$inst_no', '$inst_amt', '$final_inst_date', '$inst_month', '$int_year',0,0, '1', '$entry_date')";
$insert = mysql_query($insert_res);

	}
}
}
	if($total_price>0)
	{
	$now=time();
	
$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$build_type=find_a_field('tbl_building_info','category','bid='.$building);
$ledger_name=$flat_no.'('.$build_type.')'.'('.$project_name.')';
$cr_ledger_id=find_a_field('tbl_flat_info','ledger_id',"proj_code='".$proj_code."' AND build_code='".$building."' AND 	flat_no='".$flat_no."'");
$jv=next_journal_voucher_id();
$narration='Paid for Flat'.$ledger_name;
//$dr_ledger_id=find_a_field('tbl_party_info','ledger_id',"party_code='".$party_code."'");
//pay_invoice_amount($proj_id, $jv, $now, $cr_ledger_id,$dr_ledger_id, $narration, $total_price, 'Extended', $jv);
		//pay_invoice_amount($proj_id, $jv_no, $jv_date, $cr_ledger_id,$dr_ledger_id, $narration, $amount, $tr_from, $jv)
	}
}
?>
<script type="text/javascript" src="../../js/price_install.js"></script>
<style>
.datagtable
{
border-bottom:1px solid #CCC;
}
.datagtable td
{
border-left:1px solid #CCC;
}
.datagtable input
{
border:0;	
}

.deleted, .deleted input
{
background:#F00;
color:#FFF;
}
img
{
border:0px;
}
.style2 {
font-size: 12px;
color: #000000;
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td>
								 <div class="form-container">
                                <form id="form" name="form" method="post" action="">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td valign="top"><fieldset>
                                        <legend>Project Details</legend>
                                        <div>
                                          <label>Project : </label>
                                          <select name="proj_code" id="proj_code">
                                            <? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
                                          </select>
                                        </div>
                                        <div>
                                          <label for="email">Category : </label>
											<span id="bld">
											<select name="building" id="building" onchange="getData2('../../common/flat_option_mhafuz.php', 'fid', document.getElementById('proj_code').value,this.value);">
											<? 
											foreign_relation('tbl_building_info','bid','category',$_REQUEST['building']);
											?>
											</select>
											</span>                                        </div>
                                        <div>
                                          <label for="fname">Allotment no. : </label>
											<span id="fid">
											<select name="flat" id="flat">
											<? foreign_relation('tbl_flat_info','fid','flat_no',$flat,$con);?>
											</select>
											</span>                                        </div>
										<div class="buttonrow"><input name="search" type="submit" id="search" value="Search details " /></div>
                                        </fieldset>
										
										<fieldset>
                                        <legend>Client Details</legend>
                                        <div><span id="bld">

<?
if(isset($data->party_code)&&$data->party_code!=''){
$sql="select a.* from tbl_party_info a where a.party_code=".$data->party_code." limit 1";
$i=mysql_query($sql);
if(mysql_num_rows($i)>0){
$info=mysql_fetch_object($i);
echo $client_info=$info->party_name.'<br />'.$info->per_add;}
}
?>   
<input name="party_code" type="hidden" id="party_code" value="<?=$data->party_code?>" />
										</span>                                        </div>
                                        </fieldset>
										</td>
                                        <td valign="top"><fieldset>
                                        <legend>Project Details</legend>







<div>
                                          <label for="fname">Allotment No.:</label>
                                          <input  name="flat_no" type="text" id="flat_no" readonly value="<?=$data->flat_no?>"/>
                                        </div>
                                        <div>
                                          <label for="fname">Floor No.:</label>
                                          <input  name="" type="text" id="" value=""/>
                                        </div>
										<div>
                                          <label for="fname">Grage No.: </label>
                                          <input  name="garag_no" type="text" id="garag_no" value="<?=$data->garag_no?>"/>
										</div>
										<div>
                                          <label for="fname">Facing:</label>
                                          <input  name="facing" type="text" id="facing" value="<?=$data->facing?>"/>
										</div>
										<div>
                                          <label for="fname">Status:</label>
                                          <input  name="status" type="text" id="status" value="<?=$data->status?>"/>
										</div>
										
                                        </fieldset>
										<br />
										<fieldset>
                                        <legend>Project Details</legend>
                                        <div>
                                          <label for="fname">Total Price : </label>
                                          <input readonly="readonly"  name="total_price" type="text" id="total_price" value="<?=$data->total_price?>"/>
										</div>
										<div>
                                          <label for="fname">Config. Amnt. :  </label>
                                          <input  name="conf_amt" type="text" id="conf_amt" readonly="readonly"/>
										</div>
										
                                        </fieldset>
										</td>
                                        <td valign="top"><fieldset>
                                        <legend>Price Details</legend>
										
										
										
                                        <div>
                                          <label for="email">Flat size: </label>
                                          <input  name="flat_size" type="text" id="flat_size" value="<?=$data->flat_size?>" onchange="calculate_unitprice();calculate_payable();total_price_count();"/>
                                        </div>
										<div>
                                          <label for="fname">Rate/Sqft: </label>
                                          <input  name="sqft_price" type="text" id="sqft_price" value="<?=$data->sqft_price?>" onchange="calculate_unitprice();calculate_payable();total_price_count();"/>
										</div>
										
										
										
                                        <div>
                                          <label for="fname">Unit Price:  </label>
                                          <input  name="unit_price" type="text" id="unit_price" value="<?=$data->unit_price?>" onchange="calculate_payable();total_price_count();"/>
                                        </div>
										<div>
                                          <label for="fname">Disct. Amount:  </label>
                                          <input  name="disc_price" type="text" id="disc_price" value="<?=$data->disc_price?>"onchange="calculate_payable();total_price_count();"/>
										</div>
										<div>
                                          <label for="fname">Payable Unit Price:  </label>
                                          <input  name="payable_price" type="text" id="payable_price" value="<?=($data->unit_price-$data->disc_price)?>" readonly="readonly" onchange="total_price_count();"/>
										</div>
										<div>
                                          <label for="fname">Utility Charge: </label>
                                          <input  name="utility_price" type="text" id="utility_price" value="<?=$data->utility_charge?>" onchange="total_price_count();"/>
										</div>
										<div>
                                          <label for="fname">Reserve Fund: </label>
                                          <input  name="oth_price" type="text" id="oth_price" value="<?=$data->reserve_fund?>" onchange="total_price_count();"/>
										</div>
										<div>
                                          <label for="fname">Parking Price:  </label>
                                          <input  name="park_price" type="text" id="park_price" value="<?=$data->park_price?>" onchange="total_price_count();"/>
										</div>
										
                                        </fieldset></td>
                                      </tr>
										<tr>
										  <td>&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td>&nbsp;</td>
										</tr>
                                        <tr>
                                          <td colspan="3">
		 <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
          <tr>
            <td align="center">Payment Head </td>
            <td align="center">Amount</td>
            <td align="center">Duration</td>
            <td align="center">Total Inst. </td>
            <td align="center">Inst. Amount</td>
            <td align="center">On or Before </td>
            <td width="7%" rowspan="2" align="center">
			
			<div class="button">
			<input name="add" type="button" id="add" value="ADD" tabindex="12" onclick="check();" style="width:60px;"/>
			</div>			</td>
          </tr>
          <tr>
            <td align="center">  
			<select name="pay_code" id="pay_code" class="input3" style="width:155px;" onchange="set_from_conf()">
			<? foreign_relation('tbl_payment_head','pay_code','pay_desc','');?>
			</select>   </td>
            <td align="center"><span id="cur">
              <input name="amt" type="text" id="amt" class="input3" maxlength="100" onchange="set_inst_amt()"/>
            </span> </td>
            <td align="center"><input name="duration" type="text" id="duration"  tabindex="9" class="input3"/></td>
            <td align="center">
              <input name="no_inst" type="text" id="no_inst"  tabindex="10" class="input3"  onchange="set_inst_amt()" />            </td>
            <td align="center"><input name="inst_amt" type="text" id="inst_amt" tabindex="11" class="input3" readonly/></td>
            <td align="center"><input name="b_date" type="text" id="b_date" tabindex="11" class="input3"/></td>
          </tr>
          <tr>
            <td colspan="7" align="left"><span id="tbl">
              <?php 
			if(isset($flat)&&$flat!='')
			{
$sql="select count(b.pay_code) as no_inst,b.* from tbl_flat_cost_installment b,tbl_flat_info a where a.flat_no=b.flat_no and a.proj_code=b.proj_code and a.build_code=b.build_code and a.fid=".$flat." group by b.pay_code";
$query=mysql_query($sql);
if(mysql_num_rows($query)>0)
{
$i=0;

while($info=mysql_fetch_array($query))
{
$data = array();
$i++;

	$data['a'] = $info['pay_code'];
	$data['b'] = $info['no_inst']*$info['inst_amount'];
	$data['c'] = 1;
	$data['d'] = $info['no_inst'];
	$data['e'] = $info['inst_amount'];
	$data['f'] = $info['inst_date'];
	$count 	   = $i;

?>
              <table id="rowid<?=$count;?>" class="table_normal1" width="97%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #C1DAD7;" cellpadding="2" cellspacing="2">
                <tr align="left" id="rowid<?=$count;?>" height="30">
                  <td><input name="a<?=$count;?>" id="a<?=$count;?>" type="text" readonly="true" class="input3" value="<?=$data['a'] ?>"/>
                  </td>
                  <td><input name="b<?=$count;?>" id="b<?=$count;?>" type="text" readonly="true"  class="input3" value="<?=$data['b'] ?>" size="10"/>
                  </td>
                  <td><input name="c<?=$count;?>" id="c<?=$count;?>" type="text" readonly="true"  class="input3" value="<?=$data['c'] ?>" size="10"/>
                  </td>
                  <td><input name="d<?=$count;?>" id="d<?=$count;?>" type="text" readonly="true"  class="input3" value="<?=$data['d'] ?>"/>
                  </td>
                  <td><input name="e<?=$count;?>" id="e<?=$count;?>" type="text" readonly="true"  class="input3" value="<?=$data['e'] ?>" size="10"/>
                  </td>
                  <td><input name="f<?=$count;?>" id="f<?=$count;?>" type="text" readonly="true"  class="input3" value="<?=$data['f'] ?>" size="10"/>
                  </td>
                  <td width="200"><a href="#" onclick="deletethis<?=$count;?>();"> <img src="../../images/delete.png" width="16" height="16" /> </a> </td>
                </tr>
              </table>
              <input name="deleted<?=$count;?>" id="deleted<?=$count;?>" type="hidden" value="no" />
              <script type="text/javascript">

function deletethis<?=$count;?>()
{
	document.getElementById('rowid<?=$count;?>').className='deleted';
document.getElementById("conf_amt").value = ((document.getElementById("conf_amt").value)*1)-((document.getElementById("b<?=$count;?>").value)*1);
	document.getElementById('deleted<?=$count;?>').value='yes';
	document.getElementById('rowid<?=$count;?>').style.display='none';
}
          </script>
              <? 
$total_inst_amt=$data['b']+$total_inst_amt;
}
echo "<script>document.getElementById('conf_amt').value=".$total_inst_amt."</script>";
}}?>
            </span> </td>
          </tr>
						</table></td>
						</tr>

						<tr>
						<td colspan="3" align="center">
						
						<table width="1" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
						<td align="center">
						<div class="button">
						  <input name="save" type="button" id="save" value="Update All Information" onclick="check_ability()" style="width:150px;" />
						</div>						</td>      
						</tr>
						</table>						</td>
						</tr>
						</table>
						<input name="count" id="count" type="hidden" value="<? if(isset($count)&&$count>0) echo $count;?>" /></form>
						</div>
						</td>
						</tr>
						</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>