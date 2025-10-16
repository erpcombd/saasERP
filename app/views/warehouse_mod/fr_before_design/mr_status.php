<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='FG Requisition Status';


do_calander('#fdate');
do_calander('#tdate');


$table = 'requisition_fg_master';
$unique = 'req_no';
$status = 'UNCHECKED';
$target_url = 'fr_print_view.php';


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

    <td width="100px" bgcolor="#FF9966"><strong>

      <input type="text" name="fdate" id="fdate" value="<?=$_POST['fdate']?$_POST['fdate']:date('Y-m-01');?>" class="form-control" />

    </strong></td>

    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

    <td width="100px" bgcolor="#FF9966"><strong>

      <input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate']?$_POST['tdate']:date('Y-m-d');?>"  class="form-control"/>

    </strong></td>

    <td rowspan="3" bgcolor="#FF9966" align="center"><strong>

      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090" class="form-control"/>

    </strong></td>

  </tr>


  <tr>
<td align="right" bgcolor="#FF9966"><strong>Company To: </strong></td>
<td colspan="3" bgcolor="#FF9966"><strong>
<select name="group_for" id="group_for" >
<option value="<?=$_POST['group_for']?>"><?=find_a_field('user_group','group_name','id="'.$_POST['group_for'].'"');?></option>
<? 
foreign_relation('user_group','id','group_name','','1 ');
?>
<option></option>
</select>
</strong></td>
</tr>


  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Status: </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>
    <select name="status" id="status" >
    <option><?=$_POST['status']?></option>
    <option>CHECKED</option>
    <option>PENDING</option>
    <option>COMPLETE</option>
	</select>


    </strong></td>
</tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Warehouse To: </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>
    <select name="warehouse_id" id="warehouse_id" >
	  <? if($_POST['warehouse_id']!=''){ ?><option value="<?=$_POST['warehouse_id']?>"><?=find_a_field('warehouse','warehouse_id','warehouse_id="'.$_POST['warehouse_id'].'"');?></option> <? }?>
	  <option></option>
	  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','1 and warehouse_id!="'.$_SESSION['user']['depot'].'" and use_type="WH"');?>
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

if($_POST['status']!=''&&$_POST['status']!='ALL')
$con.= ' and a.status="'.$_POST['status'].'"';

if($_POST['group_for']>0) { $company_con= ' and a.group_for="'.$_POST['group_for'].'"'; }
if($_POST['warehouse_id']>0) { $wcon= ' and a.warehouse_to="'.$_POST['warehouse_id'].'"'; }


if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['status']!=''){ 
    $status_con='and a.status ="'.$_POST['status'].'" '; 
}else{
    $status_con='and a.status in ("CHECKED","COMPLETE","PENDING") '; 
}

if($_SESSION['user']['level']==5){

 $res='select a.req_no,a.req_no,a.req_date, b.warehouse_name as warehouse_from, 
(select warehouse_name from warehouse where warehouse_id=a.warehouse_to) as warehouse_to,
(select id from user_group where id=a.group_for) as company, a.is_reqno as req_no,a.req_note as note,a.status, a.need_by, c.fname as entry_by 

from requisition_fg_master a, warehouse b, user_activity_management c 

where a.warehouse_id=b.warehouse_id and a.entry_by=c.user_id '.$con.$wcon.$status_con.$company_con.' 
 
order by a.req_no desc';

    
}else{
    
$res='select a.req_no,a.req_no,a.req_date, b.warehouse_name as warehouse_from, 
(select warehouse_name from warehouse where warehouse_id=a.warehouse_to) as warehouse_to,
(select id from user_group where id=a.group_for) as company, a.is_reqno as req_no,a.req_note as note,a.status, a.need_by, c.fname as entry_by 

from requisition_fg_master a, warehouse b, user_activity_management c 

where a.warehouse_id=b.warehouse_id and a.entry_by=c.user_id 
and a.warehouse_id="'.$_SESSION['user']['depot'].'"
'.$con.$wcon.$status_con.$company_con.' 
 
order by a.req_no desc';

}
echo link_report($res,'fr_print_view.php');

?>

</div></td>

</tr>

</table>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>