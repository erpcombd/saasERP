<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='L/C Expense Statement';
$proj_id=$_SESSION['proj_id'];
$active='transstle';
do_calander('#fdate');
do_calander('#tdate');

//auto_complete_from_db('accounts_ledger','ledger_id','ledger_id','1','ledger_id');

create_combobox('pay_id');

//create_combobox('cc_code');

if(isset($_REQUEST['show']))
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];


if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'];
//if(isset($_REQUEST['ledger_id'])&&$_REQUEST['ledger_id']!=''&&$_REQUEST['ledger_id']!='%')
//$report_detail.='<br>Ledger Name : '.find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST["ledger_id"].' ');
//if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')
//$report_detail.='<br>Cost Center: '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);

}
?>


<style>
.box_report{
	border:3px solid cadetblue;
	background:aliceblue;
}
.custom-combobox-input{
width:217px!important;
}
</style>






<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report" ><form id="form1" name="form1" method="post" action="">
									<table width="100%" border="0" cellspacing="2" cellpadding="2">
                                      <tr>
                                        <td width="33%"  align="right">Period:   </td>
                                        <td width="18%"  align="left"><input name="fdate"  type="text" id="fdate" size="12" class="form-control" style="width:150px;" value="<?php echo $_REQUEST['fdate'];?>" /></td>
										
                                        <td width="6%"  align="center">TO</td>
                                         <td width="43%" align="left"><input name="tdate" type="text" id="tdate" size="12" class="form-control" style="width:150px;" 
											value="<?=isset($_REQUEST['tdate'])?$_REQUEST['tdate']:date('Y-m-d');?>"/></td>
                                      </tr>
                                      <tr>
                                        <td  align="right">Expense Head: </td>
                                        <td colspan="2"  align="left">
										<select name="pay_id" id="pay_id" required class="form-control" style="float:left"  >

										<option></option>
										
										<?	foreign_relation('lc_bill_category','id','bill_category',$_REQUEST['pay_id'],"1  order by bill_type, id");?>
										
										</select>
										</td>
                                        <td align="left">&nbsp;</td>
                                      </tr>
                                     
                                      <tr>
                                        <td colspan="4" align="center" style="padding:13px;"><input class="btn btn-primary" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td align="right"><? include('PrintFormat.php');?></td>
								  </tr>
								  <tr>
									<td><div id="reporting">
									<table id="grp"  class="tabledesign table-bordered table-condensed" width="100%" cellspacing="0" cellpadding="2" border="0">
							  <tr>
								<th width="4%" height="20" align="center">SL</th>
								<th width="9%" align="center">TR No </th>
								<th width="10%" align="center">TR Date </th>
								<th width="24%" align="center">L/C No </th>
								<th width="30%" align="center">Expense Head</th>
								<th width="11%" height="20" align="center">Debit</th>
								<th width="12%" align="center">Credit</th>
								</tr>
<?php
if(isset($_REQUEST['show']))
{


	if($_REQUEST['fdate']!=''&&$_REQUEST['tdate']!='') $date_con .= ' and j.jv_date between "'.$_REQUEST['fdate'].'" and "'.$_REQUEST['tdate'].'"';


$sql = "select id, lc_number, ledger_id  from lc_number_setup where 1 group by id ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$lc_number[$data->id]=$data->lc_number;
$ledger_id[$data->id]=$data->ledger_id;

}
	

  ?>
  
  
  
	<?
	
	
		 if($_REQUEST['pay_id']!='')
		 $pay_id_con.=" and j.pay_id='".$_REQUEST['pay_id']."'";
	

	
	   $sql2="select l.bill_category, j.jv_no, j.jv_date, j.tr_no, j.dr_amt, j.cr_amt, j.tr_id from journal j, lc_bill_category l  where j.pay_id=l.id ".$date_con.$pay_id_con." order by j.jv_date, j.pay_id";

	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	
{
	
	?>
	
	<tr <?=($xx%2==0)?' bgcolor="#EDEDF4"':'';$xx++;?>>
    <td align="center"><?=++$sl2;?></td>
    <td align="left"><a href="../../../acc_mod/pages/files/general_voucher_print_view_from_journal.php?jv_no=<?=$data2->jv_no;?>" target="_blank"><?=$data2->tr_no;?></a></td>
    <td align="left"><?php echo date('d-m-Y',strtotime($data2->jv_date));?></td>
    <td align="left"><a href="transaction_listledger.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&ledger_id=<?=$ledger_id[$data2->tr_id]?>" target="_blank" style=" color:#000000; text-decoration:none; font-size:14px; text-transform:uppercase;"><?=$lc_number[$data2->tr_id];?></a></td>
    <td align="left"><?=$data2->bill_category;?></td>
    <td align="right"><?=number_format($data2->dr_amt,2); $total_dr_amt +=$data2->dr_amt; ?></td>
    <td align="right"><?=number_format($data2->cr_amt,2); $total_cr_amt +=$data2->cr_amt; ?></td>
    </tr>
	
	
	<? } 

	?>
 
  <tr>
    <td align="center" bgcolor="aliceblue">&nbsp;</td>
    <td align="center" bgcolor="aliceblue">&nbsp;</td>
    <td align="center" bgcolor="aliceblue">&nbsp;</td>
    <td align="center" bgcolor="aliceblue">&nbsp;</td>
    <td align="center" bgcolor="aliceblue"><strong> Total:</strong></td>
    <td align="right" bgcolor="aliceblue"><strong><?=number_format($total_dr_amt,2); ?></strong></td>
    <td align="right" bgcolor="aliceblue"><strong><?=number_format($total_cr_amt,2); ?></strong></td>
    </tr>
  
 
  
  
  
  
  <?php }?>
</table> 
									</div>
		<div id="pageNavPosition"></div>									
		</td>
		</tr>
		</table>
		</div></td>    
  </tr>
</table>

<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>