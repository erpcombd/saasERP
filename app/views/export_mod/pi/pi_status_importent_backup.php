<?php
//
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Proforma Invoice Status';
do_calander('#fdate');
do_calander('#tdate');
$table_master='pi_master';
$unique_master='id';

create_combobox('pi_id');
create_combobox('do_no');
create_combobox('dealer_code');

$table_detail='pi_details';
$unique_detail='id';



$$unique_master=$_POST[$unique_master];

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
		$do_no=$_POST['do_no'];

		$_POST[$unique_master]=$$unique_master;
		$_POST['send_to_depot_at']=date('Y-m-d H:i:s');
		$_POST['do_date']=date('Y-m-d');
		$_POST['status']="CHECKED";
		
		
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
				unset($_POST);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


$table='pi_master';
$show='dealer_code';
$id='id';
$text_field_id='id';

$target_url = 'pi_print_view.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
</script>


<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 280px;
    height: 38px;
    border-radius: 0px !important;
}



</style>

<div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Customer Name:</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		<select name="dealer_code" id="dealer_code" style="width:280px;">
		
		<option></option>

        <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 order by dealer_code');?>
    </select>		</td>
        <td rowspan="5" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
      
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval:</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
		<!--<input type="text" name="fdate" id="fdate" style="width:120px;" value="<?=($_POST[fdate]!='')?$_POST[fdate]:date('Y-m-1')?>" />-->
          <input type="text" name="fdate" id="fdate" style="width:120px;" value="<?=$_POST['fdate']?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:120px;" value="<?=$_POST['tdate']?>" />
        </strong></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>PI No: </strong></td>
        <td colspan="3" bgcolor="#FF9966">
		
	
	<select name="pi_id" id="pi_id" style="width:280px;">
		
		<option></option>

        <?
		
		foreign_relation('pi_master','id','pi_no',$_POST['pi_id'],'1');

		?>
    </select>
		
		</td>
      </tr>
	  
	  <tr>
        <td align="right" bgcolor="#FF9966"><strong>Job No: </strong></td>
        <td colspan="3" bgcolor="#FF9966">

	<select name="do_no" id="do_no" style="width:280px;">
		
		<option></option>

        <? 	foreign_relation('pi_details','do_no','job_no',$_POST['do_no'],'1 group by do_no order by do_no'); ?>
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
  <th width="7%">PI No </th>
  <th width="7%">PI Date</th>
  <th width="10%">Job No </th>
  <th width="23%">Customer Name</th>
  <th width="15%">PI Type </th>
  <!--<th>Zone</th>-->
<th width="12%">Entry By </th>
  <th width="12%">Status</th>
</tr>


<? 

if(isset($_POST['submitit'])){

if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


		
		
		if($_POST['dealer_code']!='')
 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
		
		if($_POST['pi_id']!='') 
		$con .= ' and m.id in ('.$_POST['pi_id'].') ';
		
		if($_POST['do_no']!='') 
		$con .= ' and c.do_no in ('.$_POST['do_no'].') ';


    $res="select m.id, m.id, m.pi_no, m.status,  m.pi_date, m.dealer_code, m.pi_type, c.job_no, d.dealer_name_e, m.entry_by from 
pi_master m, pi_details c, dealer_info d
where 
m.id=c.pi_id and m.dealer_code=d.dealer_code ".$group_for_con.$con.$dealer_con."  group by m.id order by  m.pi_date, m.id ";
$query = db_query($res);

//$two_weeks = time() - 14*24*60*60;
while($data = mysqli_fetch_object($query))
{

?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->pi_no;?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?php echo date('d-m-Y',strtotime($data->pi_date));?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->job_no;?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->dealer_name_e;?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('pi_type','pi_type','id='.$data->pi_type);?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;
  <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->status;?></td>
</tr>
<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
}
}
?>


</tbody></table>
</div></td>
</tr>
</table>
</div>

<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>