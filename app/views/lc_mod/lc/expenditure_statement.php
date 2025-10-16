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

create_combobox('ledger_id');

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
                                        <td width="38%"  align="right">
		                                        Period :   </td>
                                        <td width="12%"  align="left"><input name="fdate"  type="text" id="fdate" size="12" class="form-control" style="width:150px;" value="<?php echo $_REQUEST['fdate'];?>" /> </td>
										
                                        <td width="13%"  align="center">TO</td>
                                        <td width="37%" align="left"><input name="tdate" type="text" id="tdate" size="12" class="form-control" style="width:150px;" 
											value="<?=isset($_REQUEST['tdate'])?$_REQUEST['tdate']:date('Y-m-d');?>"/></td>
                                      </tr>
                                      <?php /*?><tr>
                                        <td align="right">Ledger Head :</td>
                                        <td width="28%" align="left"><!--<input type="text" class="form-control" style="max-width:250px;" name="ledger_id" id="ledger_id" value="<?php echo $_REQUEST['ledger_id'];?>" size="50" />-->
										
										<select name="ledger_id" id="ledger_id"  class="form-control" style="float:left"  >

										<option></option>
										
										<?	foreign_relation('lc_number_setup','ledger_id','lc_number',$ledger_id,"1  order by ledger_id");?>
										
										</select>
										
										</td>
                                        <td width="50%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? if($_REQUEST['ledger_id']>0) echo find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST['ledger_id']);?>&nbsp;</td>
                                      </tr><?php */?>
									  
									 
                                       
                                      <?php /*?><tr>
                                        <td align="right">Cost Center : </td>
                                        <td colspan="2" align="left"><select name="cc_code" id="cc_code" style="width:250px;" class="form-control" >
										<option value="<?php echo $_REQUEST['cc_code'];?>"></option>
											<? foreign_relation('cost_center cc, cost_category c','cc.id','cc.center_name',$_POST['cc_code'],"cc.category_id=c.id and c.group_for='".$_SESSION['user']['group']."' ORDER BY id ASC");?>
										</select></td>
                                      </tr><?php */?>
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
								<th width="10%" height="20" align="center">SL</th>
								<th width="50%" align="center">Acc Name</th>
								<th width="20%" height="20" align="center">Debit</th>
								<th width="20%" align="center">Credit</th>
								</tr>
<?php
if(isset($_REQUEST['show']))
{


	if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and payment_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


 $sql = "select bill_category, sum(pay_amt_in) as dr_amt, sum(pay_amt_out) as cr_amt  from lc_bill_payment where 1 ".$date_con." group by bill_category ";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$dr_amt[$data->bill_category]=$data->dr_amt;
$cr_amt[$data->bill_category]=$data->cr_amt;
}
	

	 $sql1="select id, bill_type from lc_bill_type where 1  order by ordering";

	$query1 = db_query($sql1);
	while($data1 = mysqli_fetch_object($query1))
	
{
  ?>
  
  
  <tr>
    <td colspan="2" align="left" bgcolor="aliceblue"><strong>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->bill_type;?>
    </strong></td>
    <td align="right" bgcolor="aliceblue">&nbsp;</td>
    <td align="right" bgcolor="aliceblue">&nbsp;</td>
    </tr>
	<?
	
	

	
	 $sql2="select id, bill_category from lc_bill_category where bill_type='".$data1->id."' order by bill_type, ordering";

	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	
{
	
	?>
	
	<tr <?=($xx%2==0)?' bgcolor="#EDEDF4"':'';$xx++;?>>
    <td align="center"><?=++$sl2;?></td>
    <td align="left"><a href="lc_expense_details.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&pay_id=<?=$data2->id?>" target="_blank" style=" color:#000000; text-decoration:none; font-size:14px; text-transform:uppercase;"><?=$data2->bill_category;?></a></td>
    <td align="right"><?=number_format($dr_amt[$data2->id],2); $total_dr_amt +=$dr_amt[$data2->id]; ?></td>
    <td align="right"><?=number_format($cr_amt[$data2->id],2); $total_cr_amt +=$cr_amt[$data2->id]; ?></td>
    </tr>
	
	
	<? } 

	?>
 
  <tr>
    <td align="center" bgcolor="aliceblue">&nbsp;</td>
    <td align="center" bgcolor="aliceblue"><strong>Sub Total:</strong></td>
    <td align="right" bgcolor="aliceblue"><strong><?=number_format($total_dr_amt,2); $grand_total_dr_amt +=$total_dr_amt; ?></strong></td>
    <td align="right" bgcolor="aliceblue"><strong><?=number_format($total_cr_amt,2); $grand_total_cr_amt +=$total_cr_amt; ?></strong></td>
    </tr>
  
  <? 
  $total_dr_amt=0;
  $total_cr_amt=0;
  } ?>
  
  <tr>
    <td align="center" bgcolor="aliceblue">&nbsp;</td>
    <td align="center" bgcolor="aliceblue"><strong>Total:</strong></td>
    <td align="right" bgcolor="aliceblue"><strong><?=number_format($grand_total_dr_amt,2);?></strong></td>
    <td align="right" bgcolor="aliceblue"><strong><?=number_format($grand_total_cr_amt,2);?></strong></td>
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