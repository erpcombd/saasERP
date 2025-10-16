<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Select Dealer for Demand Order';




?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<div class="form-container_large">
<form action="item_return.php" method="post" name="codz" id="codz">
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
    <td align="right" bgcolor="#FF9966"><strong>Unfinished SR  List: </strong></td>
    <td bgcolor="#FF9966"><strong>

     <select name="or_no" id="or_no" required>
	 <option></option>
	 	<? foreign_relation('warehouse_other_receive','or_no','or_no',$or_no,' status = "MANUAL" and receive_type = "Return"');?>
	  </select>
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Complete " style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>