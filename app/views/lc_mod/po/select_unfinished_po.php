<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='PI List';

$table = 'lc_purchase_master';
$unique = 'po_no';
$status = 'MANUAL';
$target_url = '../po/po_create.php';

// create_combobox('po_no');

if($_POST[$unique]>0)
{
$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url);
}

?>


<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 200px;
    height: 38px;
    border-radius: 0px !important;
}


/*table thead  {
  / Important /
  background-color: red;
  position: sticky;
  z-index: 100;
  top: 0;
}*/


</style>


<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
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
    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>
    <td bgcolor="#FF9966"><strong>
      <select name="<?=$unique?>" id="<?=$unique?>">
	  
	  <option></option>
                <? 
		   $sql = "select p.po_no,l.pi_number from lc_purchase_master p,vendor_foreign v, lc_pi_reference_setup l
where p.vendor_id=v.vendor_id and p.lc_no=l.id and p.status in ('MANUAL','CHECKED') ";
		foreign_relation_sql($sql);?>
      </select>
	  <?php //echo $sql;?>
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>