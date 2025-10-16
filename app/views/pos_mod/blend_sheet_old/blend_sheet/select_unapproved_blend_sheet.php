<?php
require_once "../../../assets/template/layout.top.php";
$title='Unapproved Blend Sheet';

$table = 'blend_sheet_master';
$unique = 'blend_id';
$status = 'UNCHECKED';
$target_url = '../blend_sheet/blend_sheet_checking.php';

if($_POST[$unique]>0)
{
$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url);
}

?><div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
  <tr>
    <td width="50%">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="38%">&nbsp;</td>
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
		$sql = "select b.blend_id,concat(w.warehouse_name,' :: ',b.blend_id) from blend_sheet_master b,warehouse w 
where b.line_id=w.warehouse_id and b.status='UNCHECKED' and w.use_type='PL'";
		foreign_relation_sql($sql);?>
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