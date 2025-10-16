<?php
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Commercial Statement Status';
do_calander('#fdate');
do_calander('#tdate');
$table_master='pi_master';
$unique_master='id';

create_combobox('pi_no');
create_combobox('dealer_code');

$table_detail='pi_details';
$unique_detail='id';



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
		$do_no=$_POST['do_no'];

		$_POST[$unique_master]=$$unique_master;
		$_POST['send_to_depot_at']=date('Y-m-d H:i:s');
		$_POST['do_date']=date('Y-m-d');
		$_POST['status']="CHECKED";
		
		
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
				unset($_POST);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


$table='sales_contract';
$show='dealer_code';
$id='invoice_no';
$text_field_id='invoice_no';

$target_url = 'bill_of_exchange.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
</script>


<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 280px;
    height: 38px;
    border-radius: 0px !important;
}



</style>

<div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Customer Name:</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		<select name="dealer_code" id="dealer_code" style="width:280px;">
		
		<option></option>

        <? foreign_relation('dealer_info_foreign','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 order by dealer_name_e');?>
    </select>		</td>
        <td rowspan="5" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
      
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval:</strong></td>
        <td   bgcolor="#FF9966"><strong>
 
          <input type="text" name="fdate" id="fdate" style="width:120px;" value="<?=$_POST['fdate']?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td   bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:120px;" value="<?=$_POST['tdate']?>" />
        </strong></td>
      </tr>
      <?php /*?><tr>
        <td align="right" bgcolor="#FF9966"><strong>PI No: </strong></td>
        <td colspan="3" bgcolor="#FF9966">
		
	
	<select name="pi_no" id="pi_no" style="width:280px;">
		
		<option></option>

        <?
		
		foreign_relation('sales_contract','pi_id','pi_no',$_POST['pi_no'],'1');

		?>
    </select>
		
		</td>
      </tr><?php */?>
    </table>
  </form>
  
  <style>
  table {
  text-align: left;
  position: relative;
 
}
th {
  background: white;
  position: sticky;
  top: 0; /* Don't forget this, required for the stickiness */
  box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
}
  </style>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp" class="content">

<thead  class="sticky">
<tr>
  <th width="8%">Export LC NO </th>
  <th width="7%"> Date</th>
  <th width="19%">Customer Name</th>
  <th width="10%">BILL OF EXCHANGE</th>
  <th width="12%">COMMERCIAL INVOICE</th>
  <th width="10%">PACKING LIST</th>
  <th width="17%">DELIVERY CHALLAN</th>
  <th width="17%">BANK COPY </th>
  <th width="17%">TRUCK RECEIPT</th>
  <th width="17%">CERTIFICATE OF ORIGIN</th>
  <th width="17%">BENEFICIARY'S CERTIFICATE</th>
   <th width="17%">APPLICANT CERTIFICATE</th>
    <th width="17%">INSPECTION CERTIFICATE</th>
	 <th width="17%">BANK DOCUMENT</th>
  <!--<th>Zone</th>-->
</tr>

</thead>
<tbody>
<? 

if(isset($_POST['submitit'])){

if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and a.lc_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


		
		
		if($_POST['dealer_code']!='')
 		$dealer_con=" and a.dealer_code='".$_POST['dealer_code']."'";
		
		if($_POST['pi_no']!='') 
		$con .= ' and a.pi_id in ('.$_POST['pi_no'].') ';




      $res="select a.lc_no, a.lc_no_view, a.lc_date,  a.export_lc_no, a.dealer_code,   a.entry_by from 
lc_master a, lc_receive b, pi_details c
where  a.lc_no=b.lc_no and b.pi_id=c.pi_id and a.status='CHECKED' ".$group_for_con.$con.$dealer_con."  group by a.lc_no order by  a.lc_date, a.lc_no ";
$query = db_query($res);

//$two_weeks = time() - 14*24*60*60;
while($data = mysqli_fetch_object($query))
{

?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td>&nbsp;
  <?=$data->export_lc_no;?></td>
<td>&nbsp;<?php echo date('d-m-Y',strtotime($data->lc_date));?></td>
<td>&nbsp;<?= find_a_field('dealer_info_foreign','dealer_name_e','dealer_code="'.$data->dealer_code.'"');?></td>
<td ><a href="bill_of_exchange.php?v_no=<?=$data->lc_no;?>" target="_blank" style="color:#000000; font-weight:700;"><?=$data->lc_no_view;?></a></td>
<td><a href="commercial_invoice.php?v_no=<?=$data->lc_no;?>" target="_blank" style="color:#000000; font-weight:700;">
  <?=$data->lc_no_view;?>
</a></td>
<td><a href="packing_list.php?v_no=<?=$data->lc_no;?>" target="_blank" style="color:#000000; font-weight:700;">
  <?=$data->lc_no_view;?>
</a></td>
<td><a href="delivery_challan.php?v_no=<?=$data->lc_no;?>" target="_blank" style="color:#000000; font-weight:700;">
  <?=$data->lc_no_view;?>
</a></td>
<td><a href="bank_copy.php?v_no=<?=$data->lc_no;?>" target="_blank" style="color:#000000; font-weight:700;">
  <?=$data->lc_no_view;?>
</a></td>
<td><a href="truck_receipt.php?v_no=<?=$data->lc_no;?>" target="_blank" style="color:#000000; font-weight:700;">
  <?=$data->lc_no_view;?>
</a></td>
<td><a href="certificate_origin.php?v_no=<?=$data->lc_no;?>" target="_blank" style="color:#000000; font-weight:700;">
  <?=$data->lc_no_view;?>
</a></td>
<td><a href="beneficiary_certificate.php?v_no=<?=$data->lc_no;?>" target="_blank" style="color:#000000; font-weight:700;">
  <?=$data->lc_no_view;?>
</a></td>
<td><a href="applicant_certificate.php?v_no=<?=$data->lc_no;?>" target="_blank" style="color:#000000; font-weight:700;">
  <?=$data->lc_no_view;?>
</a></td>
<td><a href="inspection_certificate.php?v_no=<?=$data->lc_no;?>" target="_blank" style="color:#000000; font-weight:700;">
  <?=$data->lc_no_view;?>
</a></td>
<td><a href="bank_document.php?v_no=<?=$data->lc_no;?>" target="_blank" style="color:#000000; font-weight:700;">
  <?=$data->lc_no_view;?>
</a></td>
</tr>
<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
}
}
?>


</tbody></table>
</div></td>
</tr>
</table>
</div>
<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>
<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>