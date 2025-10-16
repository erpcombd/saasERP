<?php

require_once "../../../assets/template/layout.top.php";

$title='Rejected Sales Order';

do_calander('#fdate');

do_calander('#tdate');

do_datatable('grp');

$table_master='sale_do_master';

$unique_master='do_no';



$table_detail='sale_do_details';

$unique_detail='id';



$table_chalan='sale_do_chalan';

$unique_chalan='id';



$$unique_master=$_SESSION[$unique_master];



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

		unset($_POST);

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['status']='PROCESSING';

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





$table='sale_do_master';

$show='dealer_code';

$id='do_no';

$con='status="MANUAL"';



?>

<script language="javascript">

window.onload = function() {

  document.getElementById("dealer").focus();

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
  
    </table>
  </form>
  </div>
  
  <table style="cursor:pointer" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp">
<thead>
<tr>
<th class="text-center">SL No</th>
<th class="text-center">SO No</th>
<th class="text-center">Customer Name</th>
<th class="text-center">SO Date</th>
<th class="text-center">SO Amount</th>
<th class="text-center">Rejection Note</th>
<th class="text-center">Rejected By</th>
<th class="text-center">Action</th>

 </tr>
 
 </thead>
 <tbody>


<? 
if($_POST['fdate']!='') {$con=' and a.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}else{$con=' and a.do_date between "'.date('Y-m-o1').'" 
and "'.date('Y-m-d').'"';}

  $res ='select a.do_no,a.entry_by,a.do_date,a.dealer_code,d.team_name,d.dealer_name_e,a.rejection_note,a.acc_check
 
  from sale_do_master a,dealer_info d
  
  where a.dealer_code=d.dealer_code and a.status="MANUAL" and additional_status="REJECTED" '.$con.' group by a.do_no DESC';
 
// $res= 'select p.po_no,p.entry_by,p.po_date,u.fname
// 
// from purchase_master p,vendor v,user_activity_management u
// 
// where p.vendor_id=v.vendor_id and p.status="MANUAL" and v.vendor_category=1 and p.entry_by=u.user_id and p.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
$query = mysql_query($res);
while($data = mysql_fetch_object($query)){
?>
<tr>
<td class="text-center"><?=++$i?></td>
<td class="text-center"><?=$data->do_no?></td>
<td class="text-center"><?=$data->dealer_name_e?></td>
<td class="text-center"><?=$data->do_date?></td>
<td class="text-center"><?=find_a_field('sale_do_details','sum(total_amt)','do_no="'.$data->do_no.'"')?></td>
<td class="text-center"><?=$data->rejection_note?></td>
<td class="text-center"><?=find_a_field('user_activity_management','fname','user_id='.$data->acc_check);?></td>
<td class="text-center"><a href="do.php?old_do_no=<?=$data->do_no?>"><button class="btn btn-success btn-sm">Complete SO</button></a></td>

</tr>
<?php } ?>

</tbody></table>
</div></td>
</tr>
</table>




<?

require_once "../../../assets/template/layout.bottom.php";

?>