<?php
require_once "../../../assets/template/layout.top.php";
$title='Invoice List';
do_calander('#fdate');
do_calander('#tdate');
do_datatable('grp');

?>


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
     
    </table>
  </form>
  </div>
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><thead>
<tr >
<th class="text-center">SL No</th>
						<th class="text-center">SO No</th>
						<th class="text-center">Challan No</th>
						<th class="text-center">Challan Date</th>
						<th class="text-center">Customer Code</th>
						<th class="text-center">Customer Name</th>
						<th class="text-center">Total Unit</th>
						<th class="text-center">Entry By</th>
						<th class="text-center">Checked Status</th>
						<th class="text-center">Approved Status</th>
						<th class="text-center">Action</th>
						
</tr>
</thead>
<tbody>
<?php

$con_date= 'and s.chalan_date between "'.date('Y-m-01').'" and "'.date('Y-m-d').'"';
if($_POST['fdate']!=''&&$_POST['tdate']!=''){

$con_date= 'and s.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

}


 $sql="SELECT s.chalan_no,s.do_no,s.item_id,s.dealer_code,s.unit_price,sum(s.total_unit) as total_unit,s.total_amt,s.chalan_date,s.dealer_code,i.item_name,i.unit_name,d.dealer_code,d.dealer_name_e,s.invoice_check,s.approve_status,s.chalan_no_another,(select fname from user_activity_management where user_id=s.entry_by) as entry_by

from sale_do_chalan s,item_info i,dealer_info d 

where s.item_id=i.item_id and s.dealer_code=d.dealer_code ".$con_date." group by s.chalan_no order by s.chalan_no DESC";

$query=mysql_query($sql);

while($data = mysql_fetch_object($query)){



?>
<tr>
<td class="text-left"><?=++$i?></td>
<td class="text-left"><?=$data->do_no?></td>
<td class="text-left"><?=$data->chalan_no_another?></td>
<td class="text-left"><?=$data->chalan_date?></td>
<td class="text-right"><?=$data->dealer_code?></td>
<td class="text-left"><?=$data->dealer_name_e?></td>
<td class="text-right"><?=$data->total_unit?></td>
<td class="text-right"><?=$data->entry_by?></td>
<td class="text-right"><?php if($data->invoice_check!=''){ echo "<span style='color:green;font-weight:bold;'>Checked</span>";}else{ echo "<span style='color:red;font-weight:bold;'>Not Checked Yet</span>";} ?></td>
<td class="text-right"><?php if($data->approve_status !=''){ echo "<span style='color:green;font-weight:bold;'>Approved</span>";}else{ echo "<span style='color:red;font-weight:bold;'>Not Approved Yet</span>";}?></td>


<td class="text-center">
<!--<a target="_blank" href="chalan_bill_corporate1.php?v_no=<?=$data->chalan_no ?>" style="color:#FFFFFF;"><button  class="btn btn-info btn-sm active">Challan</button></a> -->

<a target="_blank" href="invoice.php?v_no=<?=$data->chalan_no ?>" style="color:#FFFFFF;"><button class="btn btn-success btn-sm">Invoice</button></a>

<!--<a target="_blank"href="gatepass.php?v_no=<?=$data->chalan_no ?>" style="color:#FFFFFF;"><button class="btn btn-warning btn-sm ">Gate Pass</button></a>-->
</td> 

</tr>

<?php } ?>




</tbody></table>
</div></td>
</tr>
</table>


<?
require_once "../../../assets/template/layout.bottom.php";
?>