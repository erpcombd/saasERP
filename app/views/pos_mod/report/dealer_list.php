<?php
require_once "../../../assets/template/layout.top.php";

$title='Dealer Information Report';



?>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td width="2" colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Depot Name : </strong></td>
    <td colspan="3" bgcolor="#FF9966"><strong>
<select name="depot" id="depot" style="width:200px;">

<? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,'1 and use_type="SD" and warehouse_id="'.$_SESSION['user']['depot'].'" order by warehouse_name');?>
</select>
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2"><? 
if(isset($_POST['submitit'])){
if($_POST['depot']!=''&&$_POST['depot']!='ALL')
$con .= 'and a.depot="'.$_POST['depot'].'"';



         $res="select a.dealer_code as code,a.dealer_code as code,concat(a.dealer_name_e,' (',a.product_group,')') as dealer_name ,a.propritor_name_e as propritor_name ,a.mobile_no ,w.warehouse_name as depot,b.AREA_NAME as area,(select PBI_NAME  from personnel_basic_info where PBI_DESIGNATION='ZI' and PBI_AREA=a.area_code limit 1)as zonal_incharge,(select PBI_MOBILE  from personnel_basic_info where PBI_DESIGNATION='ZI' and PBI_AREA=a.area_code limit 1)as zonal_mobile
		 
		  from dealer_info a,area b,warehouse w where a.dealer_type='Distributor' and a.area_code = b.AREA_CODE and w.warehouse_id=a.depot ".$con." and a.canceled='Yes' order by a.dealer_code desc";
		 
echo link_report($res,'print_view.php');}
?></div></td>
</tr>
</table>

<?
require_once "../../../assets/template/layout.bottom.php";
?>