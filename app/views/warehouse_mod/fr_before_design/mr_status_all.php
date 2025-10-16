<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Requisition Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'requisition_fg_master';
$unique = 'req_no';
$status = 'UNCHECKED';
$target_url = '../fr/mr_print_view.php';

?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
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
    <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>
    <td width="150" bgcolor="#FF9966"><strong>
      <input type="text" name="fdate" id="fdate" style="width:150px;" value="<?=$_POST['fdate']?$_POST['fdate']:date('Y-m-01');?>" />
    </strong></td>
    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
    <td width="150" bgcolor="#FF9966"><strong>
      <input type="text" name="tdate" id="tdate" style="width:150px;" value="<?=$_POST['tdate']?$_POST['tdate']:date('Y-m-d');?>" />
    </strong></td>
    <td rowspan="3" bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>

  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Status: </strong></td>
    <td colspan="3" bgcolor="#FF9966"><strong>
    <select name="status" id="status" >
	  <? if($_POST['status']!=''){ ?><option value="<?=$_POST['status']?>"><?=$_POST['status']?></option> <? }?>
	  
	  <option>CHECKED</option>
	  <option>COMPLETE</option>
	  <option>PENDING</option>
	  <option></option>
	</select>
    </strong></td>
    </tr>

  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Request From: </strong></td>
    <td colspan="3" bgcolor="#FF9966"><strong>
    <select name="warehouse_id" id="warehouse_id" >
	  <? if($_POST['warehouse_id']!=''){ ?><option value="<?=$_POST['warehouse_id']?>"><?=find_a_field('warehouse','warehouse_name','warehouse_id="'.$_POST['warehouse_id'].'"');?></option> <? }?>
	  <option></option>
	  <? foreign_relation('warehouse w, warehouse_define d','w.warehouse_id','w.warehouse_name',$warehouse_id,'1 and d.user_id="'.$_SESSION['user']['id'].'" and w.warehouse_id=d.warehouse_id');?>
	</select>
    </strong></td>
    </tr>
</table>

</form>
</div>






<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['submitit'])){
    
if($_POST['status']!=''&&$_POST['status']!='ALL') $con .= 'and a.status="'.$_POST['status'].'"';

if($_POST['warehouse_id']>0) { $wcon= ' and a.warehouse_id="'.$_POST['warehouse_id'].'"'; }


if($_POST['fdate']!='' && $_POST['tdate']!='')
$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

$wh_sql="SELECT GROUP_CONCAT(DISTINCT w.warehouse_id) as defined_wh FROM `warehouse_define` w where w.user_id='".$_SESSION['user']['id']."'  ";
	 
	 $wh_conn=db_query($wh_sql);
	 
	 $data=mysqli_fetch_object($wh_conn);
	 
	 if($data->defined_wh !=''){
	 	$wh_con2 = ' and b.warehouse_id in ('.$data->defined_wh.','.$_SESSION['user']['depot'].') ';
	 }

 $res='select a.req_no,a.req_no, a.req_date,(select group_name from user_group where id=a.group_for) as company,
(select warehouse_name from warehouse where warehouse_id=a.warehouse_id) warehouse_from,
b.warehouse_name as warehouse_to, a.req_note as note, a.need_by, c.fname as entry_by, a.entry_at,a.status 

from requisition_fg_master a, warehouse b, user_activity_management c 

where  a.warehouse_to=b.warehouse_id and a.entry_by=c.user_id 
'.$con.$wcon.$wh_con.' 
and a.status not in ("MANUAL","UNCHECKED") order by a.req_no desc';


echo link_report($res,'mr_print_view.php');
}
?>
</div></td>
</tr>
</table>













<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>