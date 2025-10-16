<?php
require_once "../../../assets/template/layout.top.php";
$title='Sales Order Verify';
do_calander('#fdate');
do_calander('#tdate');
$msg=$_REQUEST['msg'];

?>

<?=$msg?>
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
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr >
						<th class="text-center">SL No</th>
						<th class="text-center">SO No</th>
						<th class="text-center">SO Date</th>						
						<th class="text-center">Customer Name</th>
						<th class="text-center">Total Unit</th>
						<th class="text-center">Total Amount</th>
						<th class="text-center">Action</th>
						
</tr>
<?php
if(isset($_POST['submitit'])) {

 $from_date=$_POST['fdate'];
 $to_date=$_POST['tdate'];
 $date_con=" and m.do_date between '".$from_date."' and '".$to_date."'";
 }
    $sql=" select d.do_no,d.item_id,sum(d.total_unit) as total_unit,sum(d.total_amt) as total_amt,m.do_date, (select dealer_name_e from dealer_info where dealer_code=d.dealer_code) as name

from sale_do_details d,sale_do_master m, dealer_info b

where m.do_no=d.do_no and d.dealer_code=b.dealer_code and m.status='ACC_APPROVE' ".$date_con." group by m.do_no DESC";

$query=mysql_query($sql);

while($data = mysql_fetch_object($query)){



?>
<tr>
<td class="text-center"><?=++$i?></td>
<td class="text-center"><?=$data->do_no?></td>
<td class="text-center"><?=$data->do_date?></td>
<td class="text-center"><?=$data->name?></td>
<td class="text-center"><?=$data->total_unit?></td>
<td class="text-center"><?=$data->total_amt?></td>




<td class="text-center">
<a target="_blank" href="do_print_view.php?do_no=<?=$data->do_no ?>" style="color:#FFFFFF;"><button  class="btn btn-success btn-sm ">Verify</button></a> 
<!--<a target="_blank" href="approve_sales_challan.php?do_no=<?=$data->do_no ?>" style="color:#FFFFFF;"><button  class="btn btn-success btn-sm ">Approve</button></a> -->

</td> 

</tr>

<?php }?>




</tbody></table>
</div></td>
</tr>
</table>
</div>

<?
require_once "../../../assets/template/layout.bottom.php";
?>