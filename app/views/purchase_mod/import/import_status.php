<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$c_id = $_SESSION['proj_id'];                
$title='Import List';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';
$target_url = '../import/import_report.php';

if($_REQUEST[$unique]>0)
{
$_SESSION[$unique] = $_REQUEST[$unique];
header('location:'.$target_url);
}

?>
<script language="javascript">
function custom(theUrl,c_id){
	window.open('<?=$target_url?>?c='+encodeURIComponent(c_id)+'&v='+ encodeURIComponent(theUrl));
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
          <input type="text" name="fdate" id="fdate" style="width:100px !important;" value="<? if($_POST['fdate']=='') echo date('Y-m-01'); else echo $_POST['fdate']?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:100px !important;" value="<? if($_POST['tdate']=='') echo date('Y-m-d'); else echo $_POST['tdate']?>" />
        </strong></td>
        <td bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['submitit'])){


if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.or_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

$res='select  a.or_no,a.or_no as import_no,a.or_date as import_date, a.vendor_name as import_from,a.requisition_from,sum(amount) as Total from warehouse_other_receive a,warehouse_other_receive_detail b where a.or_no=b.or_no and     a.warehouse_id = "'.$_SESSION['user']['depot'].'" and a.receive_type = "import" '.$con.' group by a.or_no order by a.or_no desc';
echo link_report2($res,'po_print_view.php',$c_id);

}
?>
</div></td>
</tr>
</table>
</div>


<?
$tr_from="Purchase";
require_once SERVER_CORE."routing/layout.bottom.php";

?>