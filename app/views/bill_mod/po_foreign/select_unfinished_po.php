<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Foreign Unfinished Purchase Order List';



$table_master='purchase_master';

$unique_master='po_no';

do_calander('#fdate');
do_calander('#tdate');

$table_detail='purchase_invoice';

$unique_detail='id';



$table_chalan='sale_po_chalan';

$unique_chalan='id';

$po_no= $_GET['po_no'];



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





$table='purchase_master';

$show='dealer_code';

$id='po_no';

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
  

  <table style="cursor:pointer" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp">
<tbody>
<tr>

<th class="text-center">PO No</th>

<th class="text-center"> PO Date</th>
<th class="text-center"> Vendor Name</th>
<th class="text-center">Entry By</th>
<th class="text-center">Action</th>

 </tr>


 <? 
 if($_POST['fdate']!='') {
 $con=' and a.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

 }

 else{
 $con=' and a.po_date between "'.date('Y-m-o1').'" and "'.date('Y-m-d').'"';

 }

     echo  $res ='select a.po_no,a.entry_by,a.po_date,a.vendor_id,u.fname
 
  from purchase_master a,user_activity_management u
  
  where a.entry_by=u.user_id and a.warehouse_id="'.$_SESSION['user']['depot'].'"  and a.status="MANUAL" and a.po_for like "Foreign" '.$con.' order by a.po_no desc';
 
// $res= 'select p.po_no,p.entry_by,p.po_date,u.fname
// 
// from purchase_master p,vendor v,user_activity_management u
// 
// where p.vendor_id=v.vendor_id and p.status="MANUAL" and v.vendor_category=1 and p.entry_by=u.user_id and p.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
$query = db_query($res);
while($data = mysqli_fetch_object($query)){
?>
<tr>
<td class="text-center"><?=$data->po_no?></td>
<td class="text-center"><?=$data->po_date?></td>
<td class="text-center"><?=find_a_field('vendor','vendor_name','vendor_id="'.$data->vendor_id.'"');$data->vendor_id?></td>
<td class="text-center"><?=$data->fname?></td>
<td class="text-center"><a href="po_create.php?po_no=<?=$data->po_no?>"><button class="btn btn-success btn-sm">Complete PO</button></a></td>

</tr>
<?php } ?>

</tbody></table>
</div></td>
</tr>
</table>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>