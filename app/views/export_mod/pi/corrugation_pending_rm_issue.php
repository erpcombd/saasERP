<?php
//
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='RM Consumption';
do_calander('#fdate');
do_calander('#tdate');

create_combobox('cor_no');

$table_master='sale_do_master';
$unique='do_no';

do_calander('#fdate');
do_calander('#tdate');

create_combobox('old_do_no');


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
		$_POST['entry_at']=date('Y-m-d H:s:i');
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


$table='sale_do_master';
$do_no='do_no';
$text_field_id='do_no';

$target_url = '../bom/mr_create.php';



if(isset($_POST['approved'])){

		$_POST['checked_at']=date('Y-m-d H:s:i');

		$_POST['checked_by']=$_SESSION['user']['id'];


	$sql = "update sale_do_chalan set status='CHECKED', checked_by='".$_POST['checked_by']."', checked_at='".$_POST['checked_at']."' where chalan_no=".$_POST['chalan_no']."";
	db_query($sql);

	$type=1;

	$msg='Work Order Is Been Hold.';

}



?>

<style type="text/css">

<!--

.style1 {color: #FF0000}
.style2 {
	font-weight: bold;
	color: #000000;
	font-size: 14px;
}
.style3 {color: #FFFFFF}

-->





/*.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 280px;
    height: 37px;
    border-radius: 0px !important;
}


</style>



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
</script><div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        
        <td width="153" rowspan="4" bgcolor="#FF9966">&nbsp;</td>
      </tr>
      <tr>
        <td width="241" align="right" bgcolor="#FF9966"><strong>Corrugation Date: </strong></td>
        <td width="188" bgcolor="#FF9966"><strong>
          <!--<input type="text" name="fdate" id="fdate" style="width:120px;" value="<?=($_POST[fdate]!='')?$_POST[fdate]:date('Y-m-1')?>" />-->
          <input type="text" name="fdate" id="fdate" style="width:120px; height:30px;" value="<?=$_POST['fdate']?>" />
        </strong></td>
        <td width="78" align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="264" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:120px; height:30px;" value="<?=$_POST['tdate']?>" />
        </strong></td>
        <td width="240" bgcolor="#FF9966">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Corrugation No: </strong></td>
        <td colspan="3" bgcolor="#FF9966">
		<select name="cor_no" id="cor_no" style="width:250px;">
		
		<option></option>

        <?
		
		foreign_relation('corrugation_master','cor_no','cor_no_view',$_POST['cor_no'],'1');

		?>
    </select>		</td>
        <td bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="12%">Corrugation  No </th>
  <th width="16%">Corrugation Date </th>
  <th width="17%">Job No </th>
  <th width="13%">Status</th>
  <th width="16%">Entry By </th>
  <th width="26%">Entry At </th>
  </tr>


<? 

if(isset($_POST['submitit'])){}



if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.cor_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

//if($_POST['dealer_code']!='') 
//$con .= ' and m.dealer_code in ('.$_POST['dealer_code'].') ';

if($_POST['cor_no']!='') 
$con .= ' and m.cor_no in ('.$_POST['cor_no'].') ';

		echo $sql = "select   m.cor_do_no,  count(m.cor_do_no) as cor_do_no  from bom_requisition_master m, bom_requisition_order c where m.req_no=c.req_no group by m.cor_do_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $cor_do_no[$info->cor_do_no]=$info->cor_do_no;

		}


    $res="select m.cor_no as cor_no, m.cor_no_view,   m.cor_date,  m.status, m.entry_by, m.entry_at, d.job_no, d.cor_do_no from corrugation_master m, corrugation_details_bom d
  where m.cor_no=d.cor_no  ".$con." group by d.cor_do_no order by m.cor_no, d.cor_do_no  desc ";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{

?>

<? if($cor_do_no[$data->cor_do_no]==0) { ?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->cor_do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->cor_no_view;?></td>
<td onClick="custom(<?=$data->cor_do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?php echo date('d-m-Y',strtotime($data->cor_date));?></td>
<td onClick="custom(<?=$data->cor_do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->job_no;?></td>
<td onClick="custom(<?=$data->cor_do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->status;?></td>
<td onClick="custom(<?=$data->cor_do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');?></td>
<td onClick="custom(<?=$data->cor_do_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->entry_at;?></td>
</tr>
<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;

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