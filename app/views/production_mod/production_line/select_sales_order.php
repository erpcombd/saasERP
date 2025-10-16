<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Select Sales Order';



$table='production_line_fg';

$unique='id';

$target_url = "../production_line/commercial_expense.php";

?>

<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>?do_no='+theUrl);

}

</script>

<div class="form-container_large">







<table width="80%" border="0" align="center">





  <tr>





    <td>&nbsp;</td>





    <td colspan="4">&nbsp;</td>





    <td>&nbsp;</td>
  </tr>
</table>










<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td>



<div class="tabledesign2" style="cursor:pointer">

<? 


$res="select m.do_no,m.do_no,m.manual_do_no as sales_contruct_no,m.do_date,d.dealer_name_e as dealer_name, m.status, m.mr_no from 
sale_do_master m,dealer_info d
where m.dealer_code=d.dealer_code  and m.status like 'Checked' order by m.do_no desc";



echo link_report($res,'other_issue_report.php');

?>

</div>



</td>

</tr>

</table>



</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>