<?php
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Transaction Detail Report';
$proj_id=$_SESSION['proj_id'];
$active='transstle';
do_calander('#fdate');
do_calander('#tdate');

//auto_complete_from_db('accounts_ledger','ledger_id','ledger_id','1','ledger_id');

create_combobox('ledger_id');
create_combobox('tr_id');

//create_combobox('cc_code');

if(isset($_REQUEST['show']))
{
//$tdate=$_REQUEST['tdate'];
//fdate-------------------
//$fdate=$_REQUEST["fdate"];




$fdate = $_REQUEST['fdate'];

$tdate = $_REQUEST['tdate'];



$ledger_id=$_REQUEST["ledger_id"];
	//if(substr($ledger_id,8,8)=='00000000')
//	$sledger_id = substr($ledger_id,0,8);
//	elseif(substr($ledger_id,12,4)=='0000')
//	$sledger_id = substr($ledger_id,0,12);
	//else $sledger_id = $ledger_id;
	
	$sledger_id = $ledger_id;
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
	//echo $data;
	
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


<style>
.box_report{
	border:3px solid cadetblue;
	background:aliceblue;
}
.custom-combobox-input{
width:250px!important;
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
                                        <td  align="right">
		                                        PERIOD:   </td>
                                        <td  align="left"><input name="fdate"  type="text" id="fdate" size="12" class="form-control" style="max-width:250px;" value="<?php echo $_REQUEST['fdate'];?>" /> </td>
										
                                            <td align="left"><input name="tdate" type="text" id="tdate" size="12" class="form-control" style="max-width:250px;" value="<?php echo $_REQUEST['tdate'];?>"/></td>
                                      </tr>
									  
                                      <tr>
                                        <td align="right">Ledger Head :</td>
                                        <td width="28%" align="left">
										
										<select name="ledger_id" id="ledger_id" required class="form-control" style="float:left"  >

										<option></option>
										
										<?	foreign_relation('lc_number_setup','ledger_id','lc_number',$ledger_id,"1  order by ledger_id");?>
										
										</select>
										
										</td>
                                        <td width="50%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? if($_REQUEST['ledger_id']>0) echo find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST['ledger_id']);?>&nbsp;</td>
                                      </tr>
									  
								
									  
									 
                                      <tr>
                                        <td align="right">REFERENCE NO: </td>
                                        <td colspan="2" align="left">
										<select name="tr_id" id="tr_id" style="width:250px;" class="form-control"  >
										<option></option>
											<?	foreign_relation('lc_number_setup','id','lc_number',$_POST['tr_id'],"1  order by id");?>
										</select></td>
                                      </tr>
                                      <tr>
                                        <td colspan="3" align="center" style="padding:13px;"><input class="btn btn-primary" name="show" type="submit" id="show" value="Show" /></td>
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
								<th width="10%" align="center">Voucher</th>
								<th width="7%" height="20" align="center">Tr Date</th>
								<th width="29%" align="center">Acc Name</th>
								<th width="23%" align="center">Particulars</th>
								<th width="7%" align="center">Type</th>
								<th width="5%" height="20" align="center">Debit</th>
								<th width="5%" align="center">Credit</th>
								</tr>
<?php
if(isset($_REQUEST['show']))
{
	$cc_code = $_REQUEST['cc_code'];
	
	$tr_id = $_REQUEST['tr_id'];
	
		if($cc_code > 0)
		$cc_con = " AND a.cc_code=$cc_code";
		
		if($tr_id > 0)
		$tr_id_con = " AND a.tr_id=$tr_id";
		
		 $aaa=$sledger_id;

		$total_sql = "select sum(a.dr_amt),sum(a.cr_amt) from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' and a.ledger_id like '$sledger_id%' ".$cc_con.$d_where;
		
		if($tr_from!='')
		 $total_sql.=" and a.tr_from='".$tr_from."'";
		 
		 if($_POST['user_name']!='')
		 $total_sql.=" and a.user_id='".$_POST['user_name']."'";
		
		$total=mysqli_fetch_row(db_query($total_sql));
		
		$c="select sum(a.dr_amt)-sum(a.cr_amt) from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date<'$fdate' and a.ledger_id like '$sledger_id%'  ".$cc_con.$d_where.$tr_id_con;

	 	 $p="select a.jv_date,b.ledger_name,sum(a.dr_amt) as dr_amt,sum(a.cr_amt) as cr_amt,a.tr_from,a.narration,a.jv_no,a.tr_no,a.jv_no,a.relavent_cash_head, a.cc_code
		 from journal a,accounts_ledger b".$d_table." where a.ledger_id=b.ledger_id and a.jv_date between '$fdate' AND '$tdate' ".$cc_con.$tr_id_con." and a.ledger_id like '$sledger_id%' ".$d_where;
		 
		 if($tr_from!='')
		 $p.=" and a.tr_from='".$tr_from."'";
		 
		 if($_POST['user_name']!='')
		 $p.=" and a.user_id='".$_POST['user_name']."'";
		 
		 $p.="group by a.jv_no order by a.jv_date,a.jv_no asc";

	

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
	echo $p;
  ?>
  
  
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
		//$link="voucher_print_receipt.php?v_type=".$data[4]."&v_date=".$data[0]."&view=1&vo_no=".$data[8];
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
	
	elseif($data[4]=='LC Journal')
	{
		$link="general_voucher_print_view_from_journal.php?jv_no=".$data[8];
		echo "<a href='$link' target='_blank'>".$data[7]."</a>";
	}
	
	else {
		echo $data[6];
	}
	?>	</td>
    <td align="center"><?=$data[0];?></td>
    <td align="left"><?=$data[1];?></td>
    <td align="left"><?=$data[5];?></td>
    <td align="center"><?php echo $data[4];?></td>
    <td align="right"><?php echo number_format($data[2],2);?></td>
    <td align="right"><?php echo number_format($data[3],2);?></td>
    </tr>
  <?php } ?>
  <tr>
    <th colspan="5" align="center">&nbsp;</th>
    <th align="right"><strong>Total: </strong></th>
    <th align="right"><strong><?php echo number_format($total[0],2);?></strong></th>
    <th align="right"><strong><?php echo number_format($total[1],2);?></strong></th>
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
require_once SERVER_CORE."routing/layout.bottom.php";
?>