<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Master Invoice List';
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
        <td  bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>"/>
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td  bgcolor="#FF9966"><strong>
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
						<th class="text-center">Action</th>
						
</tr>

</thead>
<tbody>
<?php


$con_date= 'and s.chalan_date between "'.date('Y-m-01').'" and "'.date('Y-m-d').'"';
if($_POST['fdate']!=''&&$_POST['tdate']!=''){

$con_date= 'and s.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

}
 
 $sql="SELECT s.chalan_no,s.do_no,s.item_id,s.dealer_code,s.unit_price,sum(s.total_unit) as total_unit,s.total_amt,s.chalan_date,s.dealer_code,i.item_name,i.unit_name,d.dealer_code,d.dealer_name_e

from sale_do_chalan s,item_info i,dealer_info d 

where s.item_id=i.item_id and s.dealer_code=d.dealer_code ".$con_date." group by s.do_no order by s.do_no DESC";

$query=db_query($sql);

while($data = mysqli_fetch_object($query)){



?>
<tr>
<td class="text-left"><?=++$i?></td>
<td class="text-left"><?=$data->do_no?></td>
<td class="text-left"><?=$data->chalan_no?></td>
<td class="text-left"><?=$data->chalan_date?></td>
<td class="text-right"><?=$data->dealer_code?></td>
<td class="text-left"><?=$data->dealer_name_e?></td>
<td class="text-right"><?=$data->total_unit?></td>




<td class="text-center">
<!--<a target="_blank" href="chalan_bill_corporate1.php?v_no=<?=$data->chalan_no ?>" style="color:#FFFFFF;"><button  class="btn btn-info btn-sm active">Challan</button></a> -->

<a target="_blank" href="master_invoice.php?v_no=<?=$data->chalan_no?>&& do_no=<?=$data->do_no?>" style="color:#FFFFFF;"><button class="btn btn-success btn-sm">Invoice</button></a>

<!--<a target="_blank"href="gatepass.php?v_no=<?=$data->chalan_no ?>" style="color:#FFFFFF;"><button class="btn btn-warning btn-sm ">Gate Pass</button></a>-->
</td> 

</tr>

<?php } ?>




</tbody></table>
</div></td>
</tr>
</table>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>