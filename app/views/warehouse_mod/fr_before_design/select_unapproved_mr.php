<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Unapproved FG Requisition List';

$table = 'requisition_fg_master';
$unique = 'req_no';
$status = 'UNCHECKED';
$target_url = 'mr_checking.php';

$wids=find_a_field('warehouse_define','group_concat(warehouse_id)','user_id="'.$_SESSION['user']['id'].'" ');

if($_POST[$unique]>0)
{
//$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url.'?'.$unique.'='.$_POST[$unique]);
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
        <? 
       // echo $wids = user_wid_list($_SESSION['user']['id']);   
        foreign_relation($table,$unique,$unique,$$unique,'warehouse_id in ('.$wids.')  and status="'.$status.'"');?>
        
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



require_once SERVER_CORE."routing/layout.bottom.php";



?>