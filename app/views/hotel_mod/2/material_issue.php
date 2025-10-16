<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Material Issue';
do_calander('#date');
$table='proc_raw_material_issue_details';
$unique='id';

if(isset($_POST['new']))
$po_id=$$unique = $_POST['id'];
elseif($_GET['po_id']>0)
$po_id=$$unique = $_GET['po_id'];


if(isset($_POST['add']))
{
		$table		='proc_raw_material_issue_details';
		$crud      	=new crud($table);
		$sql="update proc_raw_material set qoh=qoh-".$_POST['qty'].", qop=qop+".$_POST['qty']." where id=".$_POST['material_id']." limit 1";
		mysql_query($sql);
		$crud->insert();
}


?>
<script language="javascript">
function count()
{
document.getElementById('material_remening_qty').value=((document.getElementById('purchase_invoice_qty').value)*1)-((document.getElementById('material_receive_qty').value)*1);
}
</script>
<div class="form-container_large">

<form action="?po_id=<?=$po_id?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Material</strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Line ID </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Issue Qty </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Issue Date</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
                        <td align="center" bgcolor="#CCCCCC"><span id="inst_no">
                          <select name="material_id" id="material_id">
                            <? 
foreign_relation('proc_raw_material','id','material_name',$material_id);?>
                          </select>
                        </span> </td>
                          <td align="center" bgcolor="#CCCCCC"><select name="line_id" id="line_id">
                            <? 
foreign_relation('proc_production_by_line','id','line_name',$line_id);?>
                          </select></td>
                          <td align="center" bgcolor="#CCCCCC">
<input name="qty" type="text" id="qty" style="width:50px;"  tabindex="9" class="input3" value=""  onchange="count()"/>
						  </td>
                          <td align="center" bgcolor="#CCCCCC"><input  name="date" type="text" id="date" style="width:50px;"/></td>
      </tr>
    </table>
					  <br /><br /><br /><br />
</form>

<?
$today=date("Y-m-d");
$res="select a.id,a.id,b.material_name,a.date as issue_date,a.line_id as line,a.qty as issue_qty from proc_raw_material_issue_details a,proc_raw_material b where b.id=a.material_id and a.date='".$today."'";
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td>
	  <div class="tabledesign2">
        <? 
echo link_report($res);
		?>
      </div></td>
    </tr>
    <tr>
     <td>

 </td>
    </tr>
  </table>
</div>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>