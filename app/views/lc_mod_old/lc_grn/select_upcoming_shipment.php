<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Commercial Invoice';



do_calander('#fdate');

do_calander('#tdate');

 create_combobox('lc_no');

$table = 'lc_purchase_master';

$unique = 'po_no';

$status = 'CHECKED';

$target_url = '../lc_grn/lc_shipment_receive.php';

unset($_SESSION['pr_no']);

if($_REQUEST[$unique]>0)

{

$_SESSION[$unique] = $_REQUEST[$unique];

header('location:'.$target_url);

}



?>

<script language="javascript">

function custom(theUrl)

{

	//window.open('<?=$target_url?>?shipment_no='+theUrl);
	
	window.location.href = '<?=$target_url?>?payment_no='+theUrl;

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
		<select name="lc_no" id="lc_no" style="width:240px;" required >
          <option></option>
          <? foreign_relation('lc_number_setup','id','lc_number',$_POST['lc_no'], 'status="CHECKED"');?>
        </select></td>
        <td rowspan="2" bgcolor="#0099FF"><strong>

          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

        </strong></td>
      </tr>
      <?php /*?><tr>

        <td align="right" bgcolor="#0099FF"><strong>Date Interval:</strong></td>

        <td width="120" bgcolor="#0099FF"><strong>

          <input type="text" name="fdate" id="fdate" style="width:120px; height:30px;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" />

        </strong></td>

        <td width="108" align="center" bgcolor="#0099FF"><strong> -to- </strong></td>

        <td width="137" bgcolor="#0099FF"><strong>

          <input type="text" name="tdate" id="tdate" style="width:120px; height:30px;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />

        </strong></td>
      </tr><?php */?>
    </table>

  </form>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><div class="tabledesign2">

<? 

if(isset($_POST['submitit'])){





if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and b.lc_issue_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['group_for']!='') 
$con .= ' and m.group_for = "'.$_POST['group_for'].'"';

if($_POST['lc_no']!='') 
$con .= ' and b.lc_no = "'.$_POST['lc_no'].'"';



      $res='select p.id, p.payment_no, b.pi_no as pi_no,  b.bank_lc_no, b.lc_number as lc_number, p.lc_part,  v.vendor_name as Supplier_Name
  from user_activity_management c, vendor_foreign v, user_group u, lc_bank_entry b, lc_purchase_master m, lc_bank_payment p
  where b.po_no=m.po_no and m.group_for=u.id and b.entry_by=c.user_id and m.vendor_id=v.vendor_id and p.order_no=b.id
  '.$con.' group by p.id order by b.po_no desc ';

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