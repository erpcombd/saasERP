<?php
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Store Receive (Store)';
$msg=$_REQUEST['msg'];


do_calander('#fdate');

do_calander('#tdate');

do_datatable('grp');



$table = 'purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = '../pr/chalan_view2.php';



if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}



?>

<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>?v_no='+theUrl);

}

</script>

<div class="form-container_large">
<?=$msg?>
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

          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />

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

<td>

<div class="tabledesign2">


<table width="100%" cellspacing="0" cellpadding="0" id="grp" >

<thead>



	<tr>
		<th class="text-center" width="7%">SL No</th>
		<th class="text-center" width="7%">Po No</th>
		<th class="text-center" width="7%">Po Date</th>
		<th class="text-center" width="7%">PR No</th>
		<th class="text-center" width="7%">PR Date</th>
		<th class="text-center" width="7%">QC No</th>
		<th class="text-center" width="10%">QC Date</th>
		<th class="text-center" width="10%">Warehouse</th>
		<th class="text-center" width="22%">Supplier Name</th>
		<th class="text-center" width="10%">QC By</th>
		<th class="text-center" width="10%">Action</th>

	

		
	</tr>
	
	</thead>
	<tbody>

<? 



if($_POST['fdate']!=''&&$_POST['tdate']!='')
$date_con=' and rec_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'" ';
if($_POST['item_name']!=''){
$get_item_name=explode('#',$_POST['item_name']);
$item_id=$get_item_name[2];
$item_idcon='and item_id="'.$item_id.'"';
}
unset($_SESSION['pr_no']);
    $res='select * from qc_receive_purchase where status="QC_RECEIVE" and addi_status!="PURCHASE_RECEIVED" '.$date_con.$item_idcon.' group by qc_no order by qc_no desc';


$query = db_query($res);

while($data=mysqli_fetch_object($query))

{

$po_all=find_all_field('purchase_master','*','po_no="'.$data->po_no.'"');
$req_all=find_all_field('requisition_master','*','req_no="'.$po_all->req_no.'"');

?>


	<tr>
	 <td  class="text-center"><?php echo ++$i; ?></td>
 		<td  class="text-center"><?php echo $data->po_no; ?></td>
		<td  class="text-center"><?php echo $po_all->po_date; ?></td>
		<td  class="text-center"><?php echo $req_all->req_no; ?></td>
		<td  class="text-center"><?php echo $req_all->req_date; ?></td>
      <td  class="text-center"><?=$data->qc_no;?></td>

	  <td  class="text-center"><?=$data->rec_date;?></td>

	 	  <td  class="text-center"><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$data->warehouse_id);?></td>
	  <td  class="text-left"><?=find_a_field('vendor','vendor_name','vendor_id='.$data->vendor_id);?></td>
	
	<td class="text-center"><?=find_a_field('user_activity_management','fname','user_id='.$data->qc_by)?></td>
	
	<td class="text-center"><a href="po_receive_grn.php?qc_no=<?php echo $data->qc_no;?>&po_no=<?php echo $data->po_no; ?>" target="blank"><button type="submit" target="_blank" class="btn btn-success btn-sm">Receive</button></a></td>
	  
	</tr>

<? }?>
</tbody></table>


</div>

</td>

</tr>

</table>





<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>