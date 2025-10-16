<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Work Order Create';
do_calander('#wo_date');
$table='lc_workorder';
$unique='id';

unset($_SESSION['wo_id']);
?><div class="form-container_large">
<form action="workorder_edit.php" method="post" name="codz" id="codz">
<table width="70%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong> Work Order No: </strong></td>
    <td bgcolor="#FF9966"><strong>
<input name="wo_id" type="text" />
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="go" id="go" value="VIEW WORK ORDER" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>