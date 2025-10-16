<?php
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Maintain Quotation';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='req_no';



$table_details='sale_do_details';


$$unique=$_POST[$unique];


if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['status']='COMPLETED';
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


$table='lc_number_setup';
$lc_no='id';
$text_field_id='id';

$target_url = 'invoice_entry_saas.php';
$target_url2 = '../../warehouse_mod/mr/mr_print_view.php';

?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?req_no='+theUrl);
}

function custom2(theUrl)
{
	window.open('<?=$target_url2?>?req_no='+theUrl);
}
</script><div class="form-container_large">




<style>



div.form-container_large input {
    width: 250px;
    height: 38px;
    border-radius: 0px !important;
}



</style>



  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
        <tr>
          <td width="320" align="right" bgcolor="#FF9966"><strong> Date: </strong></td>
          <td width="203" bgcolor="#FF9966"><input type="text" name="fdate" id="fdate" value="<? if($_POST['fdate']!=''){ echo $_POST['fdate'];} else{ echo date('Y-m-d');}?>" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/></td>
          <td width="58" bgcolor="#FF9966" align="center"><strong> TO </strong></td>
          <td width="243" bgcolor="#FF9966"><input type="text" name="tdate" id="tdate" value="<? if($_POST['tdate']!=''){ echo $_POST['tdate'];} else{ echo date('Y-m-d');}?>" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/></td>
          <td width="344" rowspan="5" bgcolor="#FF9966" align="center"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
          </strong></td>
        </tr>
        <tr>
          <td align="right" bgcolor="#FF9966"><strong> REQ. No: </strong></td>
          <td colspan="3" bgcolor="#FF9966">
		  <input type="text" list="req" name="req_no" id="req_no" value="<?=$_POST['req_no']?>" />
		<datalist id="req">

        <option value=""></option>

		<? foreign_relation('requisition_master','req_no','req_no',$_POST['req_no'],'1 and status="CHECKED" group by req_no');?>

      </datalist>
		  </td>
        </tr>
        
        <tr>
          <td align="right" bgcolor="#FF9966"><strong> Company Name: </strong></td>
          <td colspan="3" bgcolor="#FF9966">
    		  <select name="company" id="company">
    		    <option value=""></option>
    	    	<? foreign_relation('user_group','id','company_name',$_POST['company'],'1');?>
              </select>
		  </td>
        </tr>

    </table>
  </form>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="14%"><strong>REQ</strong> No </th>
  <th width="19%"><strong>REQ Date</strong></th>
  <th width="23%"><strong>Warehouse</strong></th>
  <th width="24%">Entry By </th>
  <th width="10%">REQ View </th>
  </tr>


<? 

if(isset($_POST['submitit'])){





if($_POST['fdate']!=''&&$_POST['tdate']!=''){ $con .= ' and m.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}

if($_POST['dealer_code']!=''){ 
$con .= ' and dealer_code in ('.$_POST['dealer_code'].') ';
}
if($_POST['invoice_no']!=''){ 
$con .= ' and m.req_no in ('.$_POST['invoice_no'].') ';
}
if($_POST['req_no']!=''){
$req_no_con=" and m.req_no='".$_POST['req_no']."'";
}
if($_POST['company']!=''){
$group_con=" and m.group_for='".$_POST['company']."'";
}
?>

<?  } ?>
<?
	 if($_POST['fdate']==''&&$_POST['tdate']==''){ $con .= ' and m.req_date = CURDATE()';}
     $res="select  m.* from  requisition_master m, requisition_order d where m.req_no=d.req_no and  m.status='CHECKED'  ".$con.$req_no_con.$group_con." group by m.req_no order by m.req_no desc";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>



<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->req_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->req_no;?></td>
<td onClick="custom(<?=$data->req_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?= date("d-M-Y",strtotime($data->req_date));?></td>
<td onClick="custom(<?=$data->req_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('warehouse','warehouse_name','warehouse_id="'.$data->warehouse_id.'"');?></td>
<td onClick="custom(<?=$data->req_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');?></td>


                 <td><button type="button" onclick="custom2(<?=$data->req_no?>)" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button></td>
</tr>

<? } ?>

</tbody></table>
</div></td>
</tr>
</table>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>