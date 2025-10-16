<?php

session_start();

ob_start();

require_once "../../../assets/support/inc.all.php";

$title='Unapproved Purchase Order List';



$table = 'purchase_master';

$unique = 'po_no';

$status = 'UNCHECKED';

$target_url = '../po/po_checking.php';



if($_POST[$unique]>0)

{

$_SESSION[$unique] = $_POST[$unique];

header('location:'.$target_url);

}



?><div class="form-container_large">

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

        <? foreign_relation($table,$unique,$unique,$$unique,'status="'.$status.'"');?>

      </select>

    </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

</table>



</form>

</div>



<?

require_once "../../../assets/template/layout.bottom.php";

?>