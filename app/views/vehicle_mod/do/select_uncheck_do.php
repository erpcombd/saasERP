<?php
require_once "../../../assets/template/layout.top.php";
$title='Unapproved Sales Order';
do_calander('#fdate');
do_calander('#tdate');
do_datatable('grp');
$table_master='sale_do_master';
$unique_master='do_no';

$table_detail='sale_do_details';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';

 $$unique_master=$_POST[$unique_master];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		$crud   = new crud($table_chalan);
		$crud->delete_all($condition);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_POST['confirm']))
{
 $sql1="UPDATE sale_do_details SET status = 'CHECKED' WHERE do_no = '".$$unique_master."';";
 mysql_query($sql1);
  
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		//$_POST['do_date']=date('Y-m-d');
		$_POST['status']='CHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_details);
		
	 
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
		
	
		
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
		
		
		
}


$table='sale_do_master';
$show='dealer_code';
$id='do_no';
$text_field_id='old_do_no';

$target_url = '../do/do_check.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?do_no='+theUrl);
}
</script>
<div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>"/>
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />
        </strong></td>
        <td rowspan="2" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
      <?php /*?><tr>
        <td align="right" bgcolor="#FF9966">Product Group : </td>
        <td colspan="3" bgcolor="#FF9966"><label>
          <select name="product_group">
		  <option><?=$_POST['product_group']?></option>
		  <option>A</option>
		  <option>B</option>
		  <option>C</option>
		  <option>D</option>
		  <option>M</option>
		  <option>ABCD</option>
          </select>
        </label></td>
      </tr><?php */?>
    </table>
  </form>
  
  </div>
  
  <table style="cursor:pointer" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><thead>
<tr>
<th>SL No</th>
<th>SO  No</th>
<th>SO Date</th>
<th>Customer Name</th><th>Payment Details</th>

  <th>&nbsp;</th>
  </tr>
  </thead>
  <tbody>


<? 



if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


//if($_POST['product_group']=='ABCD') $con .= ' and d.product_group != "M"';
//elseif($_POST['product_group']!='') $con .= ' and d.product_group = "'.$_POST['product_group'].'"';

//$res="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e,'(',team_name,')') as dealer_name, a.AREA_NAME, concat(m.payment_by) as Payment_Details,m.rcv_amt, m.mr_no from 
//sale_do_master m,dealer_info d, area a
//where m.status in ('PROCESSING') and d.area_code=a.AREA_CODE  and m.dealer_code=d.dealer_code ".$con." and d.dealer_type='Distributor' order by m.do_date,d.dealer_name_e";




 $res="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e,'(',team_name,')') as dealer_name,  concat(m.payment_by) as Payment_Details,m.rcv_amt, m.mr_no from 
sale_do_master m,dealer_info d
where m.status in ('VERIFIED_SO')  and m.dealer_code=d.dealer_code ".$con." order by m.do_date DESC";
$query = mysql_query($res);
while($data = mysql_fetch_object($query))
{
?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td><?=++$i;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_no;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->do_date;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->dealer_name;?></td>
<td onClick="custom(<?=$data->do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->Payment_Details;?></td>

<td><? if($data->RCV_AMT>0&$data->do_date==date('Y-m-d')){?>
<form action="select_uncheck_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
      <input  name="do_no" type="hidden" id="do_no" value="<?=$data->do_no;?>"/>
      <input name="confirm" type="submit" value="SEND" style="width:40px; font-weight:bold; font-size:10px; height:30px; color:#090; float:right" />
</form><? }?>
</td>
</tr>
<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
}

?>
<?php /*?><tr class="alt"><td colspan="6"><span style="text-align:right;"> Total: </span></td><td colspan="0"><?=number_format($total_send_amt,2);?></td>
  <td colspan="1"><?=number_format($total_rcv_amt,2);?></td>
  <td>&nbsp;</td>
  </tr>
<?php */?>
</tbody></table>
</div></td>
</tr>
</table>


<?
require_once "../../../assets/template/layout.bottom.php";
?>