<?php
require_once "../../../assets/template/layout.top.php";
$proj_id=$_SESSION['proj_id'];
$user_id=$_SESSION['user']['id'];
$title='Money Receipt';
if(isset($_POST['search']))
{
$flat=$_POST['flat'];
$sql="select * from tbl_flat_info where fid=".$flat." limit 1";
$q=mysql_query($sql);
if(mysql_num_rows($q)>0)
$data=mysql_fetch_object($q);
$flat_no=$data->flat_no;
}
do_calander('#c_date');
if(isset($_POST['save']))
{
$c 			=$_REQUEST['count'];
$proj_code	=$_REQUEST['proj_code'];
$building	=$_REQUEST['building'];
$flat		=$_REQUEST['flat'];
$flat_no	=$_REQUEST['flat_no'];
$rec_date	=$_REQUEST['rec_date'];
$total_amount=$_REQUEST['total_amount'];
$rec_date=$_REQUEST['rec_date'];
$party_code=$_REQUEST['party_code'];
$pay_mode=$_REQUEST['pay_mode'];
$cheq_no=$_REQUEST['c_no'];
$cheq_date=$_REQUEST['c_date'];
$bank_name=$_REQUEST['bank'];
$branch=$_REQUEST['branch'];
$rec_no=next_value('rec_no','tbl_receipt');
for($j=1; $j <= $c; $j++)  //data insert loop
	{
		if($_REQUEST['deleted'.$j] == 'no')
		{
		
			$pay_code 	= $_REQUEST['a'.$j];		
			$desc	= $_REQUEST['b'.$j];	
			$no_inst	= $_REQUEST['c'.$j];
			$inst_amt 	= $_REQUEST['d'.$j];		
			$rec_amount	= $_REQUEST['e'.$j];
			$fid	= $_REQUEST['f'.$j];
			
$sql2="INSERT INTO `tbl_receipt_details` (`rec_no`, 
`pay_code`, 
`inst_no`, 
`inst_amount`, 
`rec_amount`) VALUES 
('$rec_no','$pay_code', '$no_inst', '$inst_amt', '$rec_amount')";
mysql_query($sql2);


if($inst_amt==$rec_amount) 
{$add_sql=", `rcv_status` = 1 ";
$f1="select inst_amount from tbl_flat_cost_installment where `proj_code` = ".$proj_code." AND `build_code` = ".$building." AND `flat_no` = '$flat_no' AND `pay_code` = ".$pay_code." AND `inst_no` = ".$no_inst." LIMIT 1";
$f2=mysql_query($f1);
$f3=mysql_fetch_row($f2);
$rec_amount=$f3[0];
} else 
{$add_sql=", `rcv_status` = 0 ";
$f1="select rcv_amount from tbl_flat_cost_installment where `proj_code` = ".$proj_code." AND `build_code` = ".$building." AND `flat_no` = '$flat_no' AND `pay_code` = ".$pay_code." AND `inst_no` = ".$no_inst." LIMIT 1";
$f2=mysql_query($f1);
$f3=mysql_fetch_row($f2);
$rec_amount=$f3[0]+$rec_amount;
}
$sql3="UPDATE `tbl_flat_cost_installment` SET `rec_no` = '$rec_no',`rcv_date` = '$rec_date', rcv_amount = ".$rec_amount.$add_sql." 
WHERE `proj_code` = ".$proj_code." AND `build_code` = ".$building." AND `flat_no` = '$flat_no' AND `pay_code` = ".$pay_code." AND `inst_no` = ".$no_inst." LIMIT 1";
mysql_query($sql3);
}

}
$sql="INSERT INTO `tbl_receipt` 
(`rec_no`, 
`rec_date`, 
`party_code`, 
`proj_code`, 
`build_code`, 
`flat_no`, 
`narration`, 
`pay_mode`, 
`cheq_no`, 
`cheq_date`, 
`bank_name`, 
`branch`, 
`rec_amount`) VALUES 
('$rec_no', '$rec_date', '$party_code', '$proj_code', '$building', '$flat_no', '$desc', '$pay_mode', '$cheq_no', '$cheq_date', '$bank_name', '$branch', '$total_amount')";
mysql_query($sql);
	$now=time();

}
?>
<script type="text/javascript" src="../../js/receipt_install.js"></script>

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
</style>

 <div class="form-container">
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="top">
						<fieldset>
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
						<select name="building" id="building" onchange="getflatData();">
						<? if(isset($_REQUEST['building'])&&isset($_REQUEST['proj_code'])) $building=$_REQUEST['building'];
						$sql='select bid,category from tbl_building_info';
						join_relation($sql,$_REQUEST['building']);?>
						</select>
						</div>
						<div>
						<label for="fname">Allot no.: </label>
						<span id="fid">
						<select name="flat" id="flat">
						<? 
						foreign_relation('tbl_flat_info','fid','flat_no',$flat);?>
						</select>
						</span>										 </div>
						<div class="buttonrow">
						<input name="search" type="submit" class="btn1" id="search" value="Search details " />
						<input  name="flat_no" type="hidden" id="flat_no" readonly="readonly" value="<?=$flat_no?>"/>
						</div>
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
echo $client_info=$info->party_name.'<br />'.$info->per_house.', '.$info->per_road.', '.$info->per_village.', '.$info->per_postcode.', '.$info->per_postoffice.', '.$info->per_district;}
}
?>   
<input name="party_code" type="hidden" id="party_code" value="<?=$data->party_code?>" />
										</span>                                        </div>
                                        </fieldset>					  </td>
                      <td valign="top">
						<fieldset>
						<legend>Receipt Details</legend>
						<div>
						<label>Receipt No. : </label>
						<input  name="receipt_no" type="text" id="receipt_no" value="<?=next_value('rec_no','tbl_receipt')?>"/>
						</div>
						<div>
						<label for="email">Receipt Date :  </label>
						<input  name="rec_date" type="text" id="rec_date" value="<?=date('Y-m-d')?>"/>
						</div>
						</fieldset>
					  <br />
						<fieldset>
						<legend>Receipt Details</legend>
						
						<div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
						<td align="right">Payment Mode: </td>
						<td><select name="pay_mode" id="pay_mode">
						<option value="0">Cash</option>
						<option value="1">Cheque</option>
						</select>                                </td>
						</tr>
						<tr>
						<td><div align="right">Cheque No. :</div></td>
						<td><input  name="c_no" type="text" id="c_no" value=""/></td>
						</tr>
						<tr>
						<td><div align="right">Cheque Date :</div></td>
						<td><input  name="c_date" type="text" id="c_date" value=""/></td>
						</tr>
						<tr>
						<td><div align="right">Bank Name :</div></td>
						<td>
						<select name="bank" id="bank">
						<?
						foreign_relation('tbl_bank','bank','bank','bank');
						?>
						</select>								</td>
						</tr>
						<tr>
						<td><div align="right">Branch :</div></td>
						<td><input  name="branch" type="text" id="branch" value=""/></td>
						</tr>
						<tr>
						<td><div align="right">Total Amount : </div></td>
						<td><input  name="total_amount" type="text" id="total_amount" value="" readonly/></td>
						</tr>
						</table>
						</div>
						</fieldset>					  </td>
                      <td valign="top">
					  <div class="tabledesign1">
						                               <table cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                  <th>Last 3 Receipt No</th>
                                  <th>Rec Amount</th>
                                  <th>Print</th>
                                </tr> <?
						  if(isset($flat)){
$sql1="select b.rec_no,sum(b.rec_amount),b.rec_date from tbl_receipt b,tbl_flat_info c where  b.proj_code=c.proj_code and b.build_code=c.build_code and b.flat_no=c.flat_no and c.fid=".$flat." group by rec_no order by rec_no desc limit 3";
$query1=mysql_query($sql1);
						  if(mysql_num_rows($query1)>0)
						  {
while($payable=mysql_fetch_row($query1)){
						  ?>
                               
                                <tr class="alt">
                                  <td><?=$payable[0]?></td>
                                  <td><?=$payable[1]?></td>
                                  <td><a href="../../common/voucher_print.php?rec_no=<?= $payable[0];?>&fid=<?=$flat?>&rec_date=<?=$payable[2]?>" target="_blank"><img src="../../images/print.png" width="16" height="16" border="0"></a></td>
                                </tr>

							 <? }}}?>
                              </table>
						 <?
						  if(isset($flat)){
$sql1="select sum(b.inst_amount),sum(b.rcv_amount) from tbl_flat_cost_installment b,tbl_flat_info c where  b.proj_code=c.proj_code and b.build_code=c.build_code and b.flat_no=c.flat_no and c.fid=".$flat;
$query1=mysql_query($sql1);
						  if(mysql_num_rows($query1)>0)
						  {
$payable=mysql_fetch_row($query1);
						  ?>
						   <table cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                  <th width="114">Descriprion</th>
                                  <th>Amount</th>
                                </tr>
                                <tr class="alt">
                                  <td>Total Payable </td>
                                  <td><?=$payable[0]?></td>
                                </tr>
                                <tr>
                                  <td>Total Paid </td>
                                  <td><?=$payable[1]?></td>
                                </tr>
                                <tr class="alt">
                                  <td>Total Due </td>
                                  <td><?=($payable[0]-$payable[1])?></td>
                                </tr>
                          </table>
							 <? }}?>
                          </div>					  </td>
                    </tr>
                    <tr>
                      <td valign="top">					  					  </td>
                      <td valign="top">					  					  </td>
                      <td valign="top">					  					  </td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>  
				  <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center">Payment Head </td>
                          <td align="center">Installment No. </td>
                          <td align="center">Installment Date </td>
                          <td align="center">Installment Amount</td>
                          <td align="center">Receive Amount</td>
                          <td  rowspan="2" align="center">
						  <div class="button">
						  <input name="add" type="button" id="add" value="ADD" tabindex="12" class="update" onclick="check();"/>                       
						  </div>
					      </td>
                        </tr>
                      <tr>
                        <td align="center"><select name="pay_code" id="pay_code" class="input3" style="width:200px;" onchange="set_install(<?=$flat?>,this.value);">
                          
  <? $sql='select distinct a.pay_code,a.pay_desc from tbl_payment_head a, tbl_flat_cost_installment b,tbl_flat_info c where a.pay_code=b.pay_code and b.proj_code=c.proj_code and b.build_code=c.build_code and b.flat_no=c.flat_no and c.fid='.$flat;
							join_relation($sql,'');?>
                          </select>                        
						  </td>
                          <td align="center">
                            <span id="inst_no">
<input name="installment_no" type="text" id="installment_no" style="width:100px;"  tabindex="9" class="input3"/>
                          </span>						</td>
						  
                          <td> 
<span id="inst_date">                      
<input name="desc" type="text" class="input3" id="desc"  maxlength="100" style="width:100px;" readonly="readonly"/>
</span>
						  </td>

                          <td align="center">
<span id="inst_amt">
<input name="installment_amt" type="text" id="installment_amt"  tabindex="10" class="input3" style="width:100px;" readonly /> 
</span>
                          </td>
						 
						  
                          <td align="center"><input name="receive_amt" type="text" id="receive_amt" tabindex="11" class="input3" style="width:100px;"/></td>
                        </tr>
                      <tr>
                        <td colspan="6" align="left"><span id="tbl">
<table id="rowid<?=$count;?>" class="table_normal1" width="97%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #C1DAD7;" cellpadding="2" cellspacing="2">
<tr align="left" id="rowid<?=$count;?>" height="30">
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td width="100">
</tr>		
</table>
                          </span> </td>
                        </tr>
                    </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>
				  <table width="200" border="0" cellspacing="0" cellpadding="0" align="center">
					  <tr>
						<td>
						<div class="button">
<input name="count" id="count" type="hidden" value="<? if(isset($count)&&$count>0) echo $count;?>" />
<input name="save" type="submit" class="btn" id="save" value="Update All Information" onclick="check_ability()" />
					</div>
						</td>
					  </tr>
					</table>

				  </td>
                </tr>
            </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</div>
<?
require_once "../../../assets/template/layout.bottom.php";
?>
