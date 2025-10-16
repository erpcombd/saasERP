<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Commercial Invoice';



do_calander('#fdate');

do_calander('#tdate');

 create_combobox('po_no');

$table = 'lc_purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = 'status.php';

unset($_SESSION['pr_no']);





?>

<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>?po_no='+theUrl);
	
	//window.location.href = '<?=$target_url?>?lc_no='+theUrl;
	
	

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
    width: 300px;
    height: 38px;
    border-radius: 0px !important;
}



</style>

<div class="form-container_large">

  <form action="" method="post" name="codz" id="codz">

    <table width="80%" border="0" align="center">

      <tr>

        <td width="230">&nbsp;</td>

        <td colspan="3">&nbsp;</td>

        <td width="294">&nbsp;</td>
      </tr>

      <tr>
        <td align="right" bgcolor="#0099FF"><strong>Rererence:</strong></td>
        <td colspan="3" bgcolor="#0099FF">
		<select name="po_no" id="po_no" style="width:240px;"  >
          <option></option>
          <? foreign_relation('lc_purchase_master','po_no','pi_no',$_POST['po_no'], '1');?>
        </select></td>
        <td rowspan="2" bgcolor="#0099FF"><strong>

          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

        </strong></td>
      </tr>
      <tr>

        <td align="right" bgcolor="#0099FF"><strong>Date Interval:</strong></td>

        <td width="120" bgcolor="#0099FF"><strong>

          <input type="text" name="fdate" id="fdate" style="width:120px; height:30px;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:'';?>" />

        </strong></td>

        <td width="108" align="center" bgcolor="#0099FF"><strong> -to- </strong></td>

        <td width="137" bgcolor="#0099FF"><strong>

          <input type="text" name="tdate" id="tdate" style="width:120px; height:30px;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:'';?>" />

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

$con .= ' and m.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['po_no']!=''){

$con.=' and m.po_no="'.$_POST['po_no'].'"';
}

   $res='select m.po_no,m.pi_no,m.po_date,v.vendor_name as Vendor_Name from lc_purchase_master m,vendor_foreign v where m.vendor_id=v.vendor_id'.$con;

echo link_report($res,'po_print_view.php');



}

?>



</div></td>

</tr>

</table>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>