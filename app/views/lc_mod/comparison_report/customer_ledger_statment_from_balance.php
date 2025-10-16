<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Customer Ledgers (Report)';
$proj_id=$_SESSION['proj_id'];
$active='transstle';
do_calander('#fdate');
do_calander('#tdate');



create_combobox('ledger_id');

create_combobox('cc_code');

if(isset($_REQUEST['show']))
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];

$ledger_id=$_REQUEST["ledger_id"];
	if(substr($ledger_id,8,8)=='00000000')
	$sledger_id = substr($ledger_id,0,8);
	elseif(substr($ledger_id,12,4)=='0000')
	$sledger_id = substr($ledger_id,0,12);
	else $sledger_id = $ledger_id;
$tr_from=$_REQUEST["tr_from"];

if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'];
if(isset($_REQUEST['ledger_id'])&&$_REQUEST['ledger_id']!=''&&$_REQUEST['ledger_id']!='%')
$report_detail.='<br>Ledger Name : '.find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST["ledger_id"].' ');
if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')
$report_detail.='<br>Cost Center: '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);

}
?>
<?php  $led=db_query("select ledger_id,ledger_name from accounts_ledger where 1 order by ledger_name");
      $data = '[';
      $data .= '{ name: "All", id: "%" },';
	  while($ledg = mysqli_fetch_row($led)){
          $data .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
	  }
      $data = substr($data, 0, -1);
      $data .= ']';
	
	
	$led1=db_query("SELECT id, center_name FROM cost_center WHERE 1 ORDER BY center_name");
	  if(mysqli_num_rows($led1) > 0)
	  {	
		  $data1 = '[';
		  while($ledg1 = mysqli_fetch_row($led1)){
			  $data1 .= '{ name: "'.$ledg1[1].'", id: "'.$ledg1[0].'" },';
		  }
		  $data1 = substr($data1, 0, -1);
		  $data1 .= ']';
	  }
	  else
	  {
		$data1 = '[{ name: "empty", id: "" }]';
	  }

?>









<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">
									<table width="100%" border="0" cellspacing="2" cellpadding="2">
                                      <tr>
                                        <td  align="right">
		                                        Period :   </td>
                                        <td  align="left"><input name="fdate"  type="text" id="fdate" size="12" style="max-width:250px;" value="<?php echo $_REQUEST['fdate'];?>" /> 								        </td>
										
                                            <td align="left"><input name="tdate" type="text" id="tdate" size="12" style="max-width:250px;" value="<?php echo $_REQUEST['tdate'];?>"/></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Ledger Head :</td>
                                        <td width="28%" align="left">
										
										<select name="ledger_id" id="ledger_id" class="form-control" style="float:left"  >

<option value="0"></option>

<?

foreign_relation('accounts_ledger','ledger_id','ledger_name',$ledger_id,"1  order by ledger_id");

?>
</select>										</td>
                                        <td width="50%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                      </tr>
									  
									  
								
                                       
                                      
                                      <tr>
                                        <td colspan="3" align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>
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
								<th width="3%" height="20" align="center">SL</th>
								<th width="7%" align="center">Voucher</th>
								<th width="9%" height="20" align="center">Tr Date</th>
								<th width="46%" align="center">Narration</th>
								<th width="10%" align="center">Type</th>
								<th width="6%" height="20" align="center">Debit</th>
								<th width="7%" align="center">Credit</th>
								<th width="12%" align="center">Balance</th>
								</tr>
<?php
if(isset($_REQUEST['show']))
{
	$cc_code = (int) $_REQUEST['cc_code'];
	$dealer_type = $_REQUEST['dealer_type'];
	if($dealer_type!='')
	{
	$d_table = ',dealer_info d';
	$d_where = ' and d.account_code=b.ledger_id and d.dealer_type="'.$dealer_type.'" ';
	}
		if($cc_code > 0)
		$cc_con = " AND a.cc_code=$cc_code";

		$total_sql = "select sum(a.dr_amt),sum(a.cr_amt) from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' and a.ledger_id like '$sledger_id%' ".$cc_con.$d_where;
		
		if($tr_from!='')
		 $total_sql.=" and a.tr_from='".$tr_from."'";
		 
		 if($_POST['user_name']!='')
		 $total_sql.=" and a.user_id='".$_POST['user_name']."'";
		
		$total=mysqli_fetch_row(db_query($total_sql));
		
		$c="select sum(a.dr_amt)-sum(a.cr_amt) from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date<'$fdate' and a.ledger_id like '$sledger_id%'  ".$cc_con.$d_where;

		 $p="select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_from,a.narration,a.jv_no,a.tr_no,a.jv_no,a.cheq_no,a.cheq_date,a.relavent_cash_head , a.cc_code
		 from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' ".$cc_con." and a.ledger_id like '$sledger_id%' ".$d_where;
		 
		 if($tr_from!='')
		 $p.=" and a.tr_from='".$tr_from."'";
		 
		 if($_POST['user_name']!='')
		 $p.=" and a.user_id='".$_POST['user_name']."'";
		 
		 $p.=" order by a.jv_date,a.id";

	

	if($total[0]>$total[1])
	{
		$t_type="(Dr)";
		$t_total=$total[0]-$total[1];
	}
	else
	{
		$t_type="(Cr)";
		$t_total=$total[1]-$total[0];
	}
	/* ===== Opening Balance =======*/
	
	$psql=db_query($c);
	$pl = mysqli_fetch_row($psql);
	$blance=$pl[0];
  ?>
  
  <tr>
    <td align="center" bgcolor="#FFCCFF">#</td>
    <td align="center" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="center" bgcolor="#FFCCFF"><?php echo date('d-m-Y',strtotime($_REQUEST["fdate"]));?></td>
    <td align="left" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="center" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="right" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="right" bgcolor="#FFCCFF">&nbsp;</td>
    <td align="right" bgcolor="#FFCCFF"><?php if($blance>0) echo '(Dr)'.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?></td>
    </tr>
  <?php
  $sql=db_query($p);
  while($data=mysqli_fetch_row($sql))
  {
  $pi++;
  ?>
  <tr <?=($xx%2==0)?' bgcolor="#EDEDF4"':'';$xx++;?>>
    <td align="center"><?php echo $pi;?></td>
    <td align="center" >
	<?php
	if($data[4]=='Receipt'||$data[4]=='Journal'||$data[4]=='Contra')
	{
	
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
		elseif($data[4]=='Sales')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
		elseif($data[4]=='COGS')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
		elseif($data[4]=='Sales Return')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
	
		elseif($data[4]=='Purchase')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
		elseif($data[4]=='Cash Purchase')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
		elseif($data[4]=='Store Sales')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[8]."</a>";
	}
	
		elseif($data[4]=='Inter Purchase')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[8]."</a>";
	}
	
	
		elseif($data[4]=='Inter Sales')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[8]."</a>";
	}
	
	
		elseif($data[4]=='Twisting Wages')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[8]."</a>";
	}
	
		elseif($data[4]=='Consumption')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[8]."</a>";
	}
	
	
	
		elseif($data[4]=='Collection')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
	
		elseif($data[4]=='Payment')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
		elseif($data[4]=='Inventory Journal')
	{
		$link="inventory_journal_print_view.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[8]."</a>";
	}
	
		elseif($data[4]=='FOC')
	{
		$link="foc_sec_print_view.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
		elseif($data[4]=='SCHEME')
	{
		$link="scheme_sec_print_view.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
		elseif($data[4]=='PROVISION')
	{
		$link="provision_jv_print_view.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	
	
	
	else {
		echo $data[6];
	}
	?>	</td>
    <td align="center"><?php echo date('d-m-Y',strtotime($data[0]));?></td>
    <td align="left">
	
	
	
	
	
	<? if($data[4]=='Sales') {?>
		<table id="grp"  class="tabledesign table-bordered table-condensed" width="100%" cellspacing="0" cellpadding="2" border="0" style="font-size:12px;">
		
			
			<?
				 $ch_sql = "select i.item_name, i.unit_name, sum(c.total_unit) as total_unit, c.unit_price, sum(c.total_amt) as total_amt from item_info i, sale_do_chalan c where i.item_id=c.item_id  and c.chalan_no='".$data[7]."' group by c.item_id, c.unit_price order by c.item_id ";
				$ch_query = db_query($ch_sql);
				while ($ch_data = mysqli_fetch_object ($ch_query)) {
			?>
			<tr>
				<td width="55%"><?=$ch_data->item_name; ?></td>
				<td width="15%"><?=number_format($ch_data->total_unit,2); ?> <?=$ch_data->unit_name; ?></td>
				<td width="15%"><?=$ch_data->unit_price; ?>/<?=$ch_data->unit_name; ?></td>
				<td width="15%"><?=number_format($ch_data->total_amt,2); ?></td>
			</tr>
			<? }?>
		</table>
	<? }?>	
	
	
	<? if($data[4]=='Receipt') {?>
		<table id="grp"  class="tabledesign table-bordered table-condensed" width="100%" cellspacing="0" cellpadding="2" border="0">
			
			
			<?
			$receipt_sql="SELECT a.ledger_name, j.cr_amt FROM accounts_ledger a, journal j   WHERE j.relavent_cash_head = a.ledger_id and j.tr_no = '".$data[7]."' and  j.ledger_id like '$sledger_id%'  ";
			$receipt_data = find_all_field_sql($receipt_sql);
			?>
			<tr>
				<td width="100%"><?=$receipt_data->ledger_name; ?></td>
			</tr>
		</table>
	<? }?>
	
	
		<? if($data[4]=='Journal') {?>
		<table id="grp"  class="tabledesign table-bordered table-condensed" width="100%" cellspacing="0" cellpadding="2" border="0">
			
			
			
			<tr>
				<td width="100%"><?=$data[5];?></td>
			</tr>
		</table>
	<? }?>
	
	
		
	<? if($data[4]=='Sales Return') {?>
		<table id="grp"  class="tabledesign table-bordered table-condensed" width="100%" cellspacing="0" cellpadding="2" border="0" style="font-size:12px;">
		
			
			<?
				 $sr_sql = "select i.item_name, i.unit_name, sum(c.total_unit) as total_unit, c.return_price, sum(c.return_amt) as return_amt from item_info i, sale_return_details c where i.item_id=c.item_id  and c.sr_invoice='".$data[7]."' group by c.item_id, c.return_price order by c.item_id";
				$sr_query = db_query($sr_sql);
				while ($sr_data = mysqli_fetch_object ($sr_query)) {
			?>
			<tr>
				<td width="55%"><?=$sr_data->item_name; ?></td>
				<td width="15%"><?=number_format($sr_data->total_unit,2); ?> <?=$sr_data->unit_name; ?></td>
				<td width="15%"><?=$sr_data->return_price; ?>/<?=$ch_data->unit_name; ?></td>
				<td width="15%"><?=number_format($sr_data->return_amt,2); ?></td>
			</tr>
			<? }?>
		</table>
	<? }?>	
	
	</td>
    <td align="center"><?php echo $data[4];?></td>
    <td align="right"><?php echo number_format($data[2],2);?></td>
    <td align="right"><?php echo number_format($data[3],2);?></td>
    <td align="right" bgcolor="#FFCCFF"><?php $blance = $blance+($data[2]-$data[3]); if($blance>0) echo '(Dr) '.number_format($blance,2); elseif($blance<0) echo '(Cr) '.number_format(((-1)*$blance),2);else echo "0.00"; ?></td>
    </tr>
  <?php } ?>
  <tr>
    <th colspan="4" align="center"></th>
    <th align="right"><strong>Total: </strong></th>
    <th align="right"><strong><?php echo number_format($total[0],2);?></strong></th>
    <th align="right"><strong><?php echo number_format($total[1],2);?></strong></th>
    <th align="right"></th>
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