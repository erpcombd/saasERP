<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Unfinished Progress Report List';



$table_master='daily_progress_master';

$unique_master='d_id';

do_calander('#fdate');
do_calander('#tdate');

$table_detail='daily_progress_details';

$unique_detail='id';



$table_chalan='sale_po_chalan';

$unique_chalan='id';

$d_id= $_GET['d_id'];



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

    $_POST['status']='PENDING';

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





$table='daily_progress_master';

$show='dealer_code';

$id='d_id';

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

<th class="text-center">ID</th>

<th class="text-center"> Progress Date</th>
<th class="text-center"> Progress For</th>
<th class="text-center">Entry By</th>
<th class="text-center">Action</th>

 </tr>


 <? 
 if($_POST['fdate']!='') {
 $con=' and a.progress_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

 }

 else{
 $con=' and a.progress_date between "'.date('Y-m-o1').'" and "'.date('Y-m-d').'"';

 }

      $res ='select a.d_id,a.entry_by,a.progress_date,u.fname,p.type
 
  from daily_progress_master a,user_activity_management u,daily_progress_setup p
  
  where a.entry_by=u.user_id and p.id=a.progress_for   and a.status="PENDING" '.$con.'  order by a.d_id desc';
 
// $res= 'select p.d_id,p.entry_by,p.progress_date,u.fname
// 
// from daily_progress_master p,vendor v,user_activity_management u
// 
// where p.vendor_id=v.vendor_id and p.status="MANUAL" and v.vendor_category=1 and p.entry_by=u.user_id and p.progress_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
$query = db_query($res);
while($data = mysqli_fetch_object($query)){
?>
<tr>
<td class="text-center"><?=$data->d_id?></td>
<td class="text-center"><?=$data->progress_date?></td>
<td class="text-center"><?=$data->type?></td>
<td class="text-center"><?=$data->fname?></td>
<td class="text-center"><a href="plan_create.php?master_id=<?=$data->d_id?>"><button class="btn btn-success btn-sm">Complete</button></a></td>

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