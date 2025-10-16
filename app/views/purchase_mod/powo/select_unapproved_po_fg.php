<?php
session_start();
ob_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Unapproved Purchase List ';
do_calander('#fdate');
do_calander('#tdate');
$table_master='purchase_master';
$unique='po_no';


$table_details='purchase_invoice';
//$unique_chalan='id';

$$unique=$_POST[$unique];

//if(isset($_POST['delete']))
//{
//		$crud   = new crud($table_master);
//		$condition=$unique_master."=".$$unique_master;		
//		$crud->delete($condition);
//		$crud   = new crud($table_detail);
//		$crud->delete_all($condition);
//		$crud   = new crud($table_chalan);
//		$crud->delete_all($condition);
//		unset($$unique_master);
//		unset($_SESSION[$unique_master]);
//		$type=1;
//		$msg='Successfully Deleted.';
//}
if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		//$_POST['do_date']=date('Y-m-d');
		$_POST['status']='COMPLETED';
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
		
		
		
		
		
		
		
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


$table='purchase_master';
$po_no='po_no';
$text_field_id='po_no';

$target_url = '../powo/po_checking.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?po_no='+theUrl);
}
</script><div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td width="153">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td width="141">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td width="107" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=$_POST['fdate']?>" />
        </strong></td>
        <td width="89" align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="158" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=$_POST['tdate']?>" />
        </strong></td>
        <td rowspan="2" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
      <!--<tr>
        <td align="right" bgcolor="#FF9966"><strong>PO No  : </strong></td>
        <td colspan="3" bgcolor="#FF9966"><input type="text" name="po_no" id="po_no" style="width:107px;" value="<?=$_POST['po_no']?>" /></td>
      </tr>-->
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th>PO No </th>
  <th>PO Date </th>
  <th>Vendor Name</th>
  <th>Purchase Amt </th>
  <th>Status</th>
  <th>Entry By </th>
  <th>Entry At </th>
  <th>&nbsp;</th>
  </tr>


<? 

if(isset($_POST['submitit'])){

}

if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['po_no']!='') 
$con .= ' and m.po_no in ('.$_POST['po_no'].') ';



  $res="select m.po_no, m.po_no, m.po_date, m.purchase_type,  concat(v.vendor_name) as vendor_name, sum(p.amount) as amount, m.status, u.fname, m.entry_at from purchase_master m, purchase_invoice p, vendor v, user_activity_management u where m.po_no=p.po_no and m.vendor_id=v.vendor_id and m.entry_by=u.user_id and m.status='CHECKED' ".$con." group by m.po_no order by m.po_no ";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
  <td onClick="custom(<?=$data->po_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->po_no;?></td>
<td onClick="custom(<?=$data->po_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?php echo date('d-m-Y',strtotime($data->po_date));?></td>
<td onClick="custom(<?=$data->po_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->vendor_name;?></td>
<td onClick="custom(<?=$data->po_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=number_format($data->amount,2); $tot_inv_amount +=$data->amount;?></td>
<td onClick="custom(<?=$data->po_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->status;?></td>
<td onClick="custom(<?=$data->po_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->fname;?></td>
<td onClick="custom(<?=$data->po_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->entry_at;?></td>
<td><? if($data->RCV_AMT>0&$data->do_date==date('Y-m-d')){?>
<form action="select_uncheck_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
      <input  name="do_no" type="hidden" id="do_no" value="<?=$data->do_no;?>"/>
      <input name="confirm" type="submit" value="SEND" style="width:40px; font-weight:bold; font-size:10px; height:30px; color:#090; float:right" />
</form><? }?></td>
</tr>
<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;

}
?>
<tr class="alt" ><td colspan="3"><span style="text-align:right;"><strong> Total: </strong></span></td>
  <td><strong> 
    <?=number_format($tot_inv_amount,2);?>
  </strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>

</tbody></table>
</div></td>
</tr>
</table>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>