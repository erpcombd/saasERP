<?php
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='L/C Bank Entry';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='do_no';

//create_combobox('batch_no');
//create_combobox('dealer_code');

$table_details='sale_do_details';
//$unique_chalan='id';

$$unique=$_POST[$unique];

//if(isset($_POST['delete']))
//{
//		$crud   = new crud($table_master);
//		$condition=$unique_master."=".$$unique_master;		
//		$crud->delete($condition);
//		$crud   = new crud($table_detail);
//		$crud->delete_all($condition);
//		$crud   = new crud($table_chalan);
//		$crud->delete_all($condition);
//		unset($$unique_master);
//		unset($_SESSION[$unique_master]);
//		$type=1;
//		$msg='Successfully Deleted.';
//}
if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		//$_POST['do_date']=date('Y-m-d');
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

$target_url = '../lc/lc_bank_entry.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?pi_reference='+theUrl);
}
</script><div class="form-container_large">




<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 250px;
    height: 38px;
    border-radius: 0px !important;
}



</style>



  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <?php /*?><tr>
        <td width="153" align="right" bgcolor="#FF9966"><strong>Program No:</strong></td>
        <td bgcolor="#FF9966">
		<select name="batch_no" id="batch_no" style="width:250px;">
		
		<option></option>

        <?
		
		foreign_relation('production_batch','batch_no','batch_no_view',$_POST['batch_no'],'1 order by batch_no');

		?>
    </select>		</td>
        <td rowspan="3" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr><?php */?>
      <?php /*?><tr>
        <td align="right" bgcolor="#FF9966"><strong>LC No: </strong></td>
        <td bgcolor="#FF9966">
		<select name="do_no" id="do_no" style="width:250px;">
		
		<option></option>

        <? foreign_relation('sale_do_master','do_no','job_no',$_POST['do_no'],'1');?>
    </select>
		
		</td>
      </tr><?php */?>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="5%">ID</th>
  <th width="5%">PI No </th>
  <th width="31%"><strong>PI Referance No</strong></th>
  <th width="24%">Company</th>
  <th width="20%">Status</th>
</tr>


<? 

if(isset($_POST['submitit'])){

}

//if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['dealer_code']!='') 
$con .= ' and dealer_code in ('.$_POST['dealer_code'].') ';

if($_POST['batch_no']!='') 
$con .= ' and batch_no in ('.$_POST['batch_no'].') ';



 		    $sql = "select pi_reference_no, pi_reference_no as pi_reference_no  from lc_bank_entry where 1 group by pi_reference_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pi_reference_no[$info->pi_reference_no]=$info->pi_reference_no;
		}



       $res="select l.*, m.pi_no,m.po_no from lc_pi_reference_setup l, lc_purchase_master m,lc_purchase_invoice d where m.po_no=d.po_no and l.id=m.pi_reference and l.status='CHECKED' group by m.po_no  order by m.po_date, m.po_no";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
 
?>

<? if($pi_reference_no[$data->id]<1) {  ?>

<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->id;?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->po_no;?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->pi_number;?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('user_group','group_name','id="'.$data->group_for.'"');?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->status;?></td>
</tr>


<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;

} } ?>


</tbody></table>
</div></td>
</tr>
</table>
</div>

<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>