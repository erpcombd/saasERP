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

$res='select b.inst_no from tbl_flat_cost_installment b,tbl_flat_info c where b.proj_code=c.proj_code and b.build_code=c.build_code and b.flat_no=c.flat_no and c.fid='.$fid.' and b.pay_code='.$pcode.' and b.rcv_status!=1 order by b.inst_no';
$sql=mysql_query($res);
if(mysql_num_rows($sql))
{
echo '<select id="installment_no" name="installment_no" onchange="set_install_amt('.$fid.')">';
echo '<option></option>';
while($data=mysql_fetch_row($sql)){
echo '<option value="'.$data[0].'">'.$data[0].'</option>';
}
echo '</select>';
}
else
echo 'All Paid.<input id="installment_no" name="installment_no" type="hidden" value="" />';
?>
