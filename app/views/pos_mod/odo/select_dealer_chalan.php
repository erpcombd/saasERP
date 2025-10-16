<?php
require_once "../../../assets/template/layout.top.php";

$title='Select Undelivered Demand Order';

$table_master='sale_do_master';
$unique_master='do_no';

$table_detail='sale_do_details';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';

$$unique_master=$_SESSION[$unique_master];

if($_GET['del']==1&&$_GET['do_id']>0)
{
$do_no=$_GET['do_id'];
$vars['status']='COMPLETED';
db_update($table_chalan, $do_no, $vars, 'do_no');
db_update($table_detail, $do_no, $vars, 'do_no');
db_update($table_master, $do_no, $vars, 'do_no');
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
//
//$table='sale_do_master';
//$show='dealer_code';
//$id='do_no';
//$con='status="PROCESSING"';
//$text_field_id='do';
//
//if($con!='') $condition = " where ".$con;
//$query="Select ".$id.", ".$show." from ".$table.$condition;
//
//$led=mysql_query($query);
//	if(mysql_num_rows($led) > 0)
//	{
//		$ledger = '[';
//		while($ledg = mysql_fetch_row($led)){
//		  $ledger .= '{ name: "'.find_a_field('dealer_info','dealer_name_e','dealer_code='.$ledg[1]).'", id: "'.$ledg[0].'" },';
//		}
//		$ledger = substr($ledger, 0, -1);
//		$ledger .= ']';
//	}
//	else
//	{
//		$ledger = '[{ name: "empty", id: "" }]';
//	}
//
//echo '<script type="text/javascript">
//$(document).ready(function(){
//    var data = '.$ledger.';
//    $("#'.$text_field_id.'").autocomplete(data, {
//		matchContains: true,
//		minChars: 0,
//		scroll: true,
//		scrollHeight: 300,
//        formatItem: function(row, i, max, term) {
//            return row.name + " [" + row.id + "]";
//		},
//		formatResult: function(row) {
//			return row.id;
//		}
//	});
//  });
//</script>';

?>
<script language="javascript">
window.onload = function() {
  document.getElementById("do").focus();
}
</script>
<style type="text/css">
<!--
.style2 {font-size: 18px}
-->
</style>

<div class="form-container_large">
<form action="do_chalan.php" method="post" name="codz" id="codz">
<table width="70%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td><span class="style2">Other Depot Chalan </span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>DO NO : </strong></td>
    <td bgcolor="#FF9966"><strong>

<?
$from_date = date('Y-m-d',time()-(86400*30));

 $query = "select a.do_no,b.dealer_code,b.dealer_name_e,a.do_date
from sale_do_master a,dealer_info b 
where b.dealer_code=a.dealer_code

and (a.do_date>='".$from_date."') 
and a.status ='CHECKED' 
order by a.do_no";

// and a.other_deport_id = '".$_SESSION['user']['depot']."' 
?>
      <select name="do" id="do">
      <option></option>
<?
$que=mysql_query($query);
while($data=mysql_fetch_object($que)){
echo '<option value="'.$data->do_no.'">'.$data->do_no.'-'.$data->dealer_name_e.'-'.$data->do_date.'</option>';
}
?>    
      </select>
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Chalan DO" class="btn1 btn1-submit-input"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?
require_once "../../../assets/template/layout.bottom.php";
?>