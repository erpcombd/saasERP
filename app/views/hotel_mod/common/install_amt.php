<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$fid = $_REQUEST['fid'];
$pcode = $_REQUEST['pcode'];
$in_no = $_REQUEST['in_no'];

$res='select b.inst_amount,b.rcv_amount,b.inst_date from tbl_flat_cost_installment b,tbl_flat_info c where b.proj_code=c.proj_code and b.build_code=c.build_code and b.flat_no=c.flat_no and c.fid='.$fid.' and b.pay_code='.$pcode.' and b.rcv_status!=1 and b.inst_no='.$in_no;
$sql=mysql_query($res);
if(mysql_num_rows($sql)>0)
{
while($data=mysql_fetch_row($sql)){
$amt=$data[0]-$data[1];
echo '                       
<input name="installment_amt" type="text" id="installment_amt"  tabindex="10" class="input3" style="width:100px;" value="'.$amt.'" readonly />
</td>';

}
}
?>

