<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Ingredients Formula';
$line_id = $_REQUEST['line_id'];
if(isset($_REQUEST['item_id'])) $item_id = $_REQUEST['item_id'];

$sql = 'select w.warehouse_name,p.line_id from warehouse w,production_line_fg p where w.warehouse_id=p.line_id and p.line_id= '.$line_id.'  and w.use_type="PL" and  p.fg_item_id='.$item_id;
$line = find_all_field_sql($sql);

$old_data = find_all_field('production_ingredient_detail','','item_id="'.$item_id.'"');

if(isset($_POST['update'])&&($_POST['item_id']>0))
{
$table		= 'production_ingredient_detail';
		
$crud      	= new crud($table);


$del_sql1 = 'update production_ingredient_detail set unit_batch_size = "'.$_POST['unit_batch_size'].'" where item_id="'.$item_id.'" ';
db_query($del_sql1);


if($old_data->unit_batch_qty>0 && $_POST['unit_batch_qty']!=$old_data->unit_batch_qty)
{
 $del_sql = 'update production_ingredient_detail set unit_batch_qty = "'.$_POST['unit_batch_qty'].'" and unit_batch_size = "'.$_POST['unit_batch_size'].'" where item_id="'.$item_id.'" ';
db_query($del_sql);
unset($_POST['unit_batch_qty']);
}

$unit_batch_size = $_POST['unit_batch_size'];
$sql = 'select i.* from item_info i,production_line_raw r where  i.item_id =r.fg_item_id and r.line_id="'.$line->line_id.'" order by item_name' ;
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
$_POST['raw_item_id'] = $data->item_id;
$_POST['unit_batch_qty'] = $_POST['total_unit_'.$data->item_id];
$_POST['process_loss_percentage'] = $_POST['ps_per_'.$data->item_id];
$_POST['system_loss_percentage'] = $_POST['ss_per_'.$data->item_id];
$_POST['unit_qty'] = @($_POST['unit_batch_qty']/$unit_batch_size);
$_POST['unit_name'] = $data->unit_name;
$old_data = find_all_field('production_ingredient_detail','','raw_item_id="'.$data->item_id.'" and item_id="'.$item_id.'"');

	if($old_data->id>0)
	{

		$_POST['edit_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['id'] = $id = $old_data->id;
		$crud->update('id');
	}
	else
	{
	if($_POST['unit_batch_qty']>0){
	unset($_POST['id']);
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['entry_by']=$_SESSION['user']['id'];
		$crud->insert();
		}
	}
}
}
$old_data = find_all_field('production_ingredient_detail','','item_id="'.$item_id.'"');
?><div class="form-container_large" >
<form action="" method="post" name="cloud" id="cloud">
<fieldset style="width:100%;">
      <div>
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
        <label >Finished Good Name: </label>
        <input  name="item_id" type="hidden" id="item_id" value="<?=$item_id?>"/>
		<input  name="line_id" type="hidden" id="line_id" value="<?=$line_id?>"/>
        <input  name="manual_wo_id" type="text" id="manual_wo_id" value="<?=find_a_field('item_info','item_name','item_id='.$item_id)?>" style="width:350px;" readonly="readonly"/>
        </td>
    </tr>
  <tr>
    <td><div>
      <label >Production Line: </label>
      <input  name="manual_wo_id2" type="text" id="manual_wo_id2" value="<?=$line->warehouse_name?>" style="width:350px;" readonly="readonly"/>
    </div></td>
  </tr>
    <tr>
    <td><div>
      <label >Batch For KG/Pcs: </label>
      <input  name="unit_batch_size" type="text" id="unit_batch_size" value="<?=$old_data->unit_batch_size?>" style="width:350px;"/>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table></div>
    </fieldset>

<? $sqlSub = 'select s.sub_group_name,i.sub_group_id from item_info i, item_sub_group s, production_line_raw r where i.sub_group_id=s.sub_group_id and  i.item_id =r.fg_item_id  and r.line_id="'.$line->line_id.'" and s.sub_group_id !=10000000 group by i.sub_group_id order by item_name';
$querySub = db_query($sqlSub);
while($dataSub = mysqli_fetch_object($querySub)){	 ?>
	
<table  width="80%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
    <td width="70%" align="center" bgcolor="#33CCFF"><strong><?=$dataSub->sub_group_name; ?></strong></td>
    <td width="10%" align="center" bgcolor="#33CCFF"><span style="font-weight: bold">Unit</span></td>
    <td width="10%" align="center" bgcolor="#33CCFF"><strong>Qty</strong></td>
    <td width="10%" align="center" bgcolor="#33CCFF"><strong>PS%</strong></td>
    <td width="10%" align="center" bgcolor="#33CCFF"><strong> SS%</strong></td>
    </tr>
<? 

 $sql = 'select i.* from item_info i, production_line_raw r where  i.item_id =r.fg_item_id and i.sub_group_id = "'.$dataSub->sub_group_id.'" and r.line_id="'.$line->line_id.'" order by item_name';
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
$info = find_all_field('production_ingredient_detail','','raw_item_id="'.$data->item_id.'" and item_id="'.$item_id.'"');

?>
  <tr>
    <td  bgcolor="#CCCCCC"><div align="left">
      <?=$data->item_name?></div></td>
    <td align="center" bgcolor="#CCCCCC"><?=$data->unit_name?></td>
    <td align="center" bgcolor="#CCCCCC"><input name="total_unit_<?=$data->item_id?>" type="text" class="input3" id="total_unit_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=$info->unit_batch_qty?>"/></td>
    <td align="center" bgcolor="#CCCCCC"><input name="ps_per_<?=$data->item_id?>" type="text" class="input3" id="ps_per_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=$info->process_loss_percentage?>"/></td>
    <td align="center" bgcolor="#CCCCCC">
<input name="ss_per_<?=$data->item_id?>" type="text" class="input3" id="ss_per_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=$info->system_loss_percentage?>"/></td>
    </tr>
<? }?>
</table>
<? } ?>

<!--<table  width="80%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
    <td width="70%" align="center" bgcolor="#FF9999"><strong>CHEMICAL MATERIAL</strong></td>
    <td width="10%" align="center" bgcolor="#FF9999"><span style="font-weight: bold">Unit</span></td>
    <td width="10%" align="center" bgcolor="#FF9999"><strong>Qty</strong></td>
    <td width="10%" align="center" bgcolor="#FF9999"><strong>PS%</strong></td>
    <td width="10%" align="center" bgcolor="#FF9999"><strong>SS%</strong></td>
  </tr>
  <? 
$sql = 'select i.* from item_info i, production_line_raw r where  i.item_id =r.fg_item_id  and i.sub_group_id like "1005000100110000%" and r.line_id="'.$line->line_id.'" order by item_name';
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
$info = find_all_field('production_ingredient_detail','','raw_item_id="'.$data->item_id.'" and item_id="'.$item_id.'"');
?>
  <tr>
    <td  bgcolor="#CCCCCC"><div align="left">
      <?=$data->item_name?></div></td>
    <td align="center" bgcolor="#CCCCCC"><?=$data->unit_name?></td>
    <td align="center" bgcolor="#CCCCCC"><input name="total_unit_<?=$data->item_id?>" type="text" class="input3" id="total_unit_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=$info->unit_batch_qty?>"/></td>
    <td align="center" bgcolor="#CCCCCC"><input name="ps_per_<?=$data->item_id?>" type="text" class="input3" id="ps_per_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=$info->process_loss_percentage?>"/></td>
    <td align="center" bgcolor="#CCCCCC"><input name="ss_per_<?=$data->item_id?>" type="text" class="input3" id="ss_per_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=$info->system_loss_percentage?>"/></td>
  </tr>
  <? }?>
</table>
<table  width="80%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
    <td width="70%" align="center" bgcolor="#999999"><strong>PACKING MATERIAL </strong></td>
    <td width="10%" align="center" bgcolor="#999999"><span style="font-weight: bold">Unit</span></td>
    <td width="10%" align="center" bgcolor="#999999"><strong>Qty</strong></td>
    <td width="10%" align="center" bgcolor="#999999"><strong>PS%</strong></td>
    <td width="10%" align="center" bgcolor="#999999"><strong>SS%</strong></td>
  </tr>
  <? 
 $sql = 'select i.* from item_info i,production_line_raw r where  i.item_id =r.fg_item_id  and (i.sub_group_id like "1005000100120000%" OR i.sub_group_id like "12%") and r.line_id="'.$line->line_id.'" order by item_name';
 
 
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
$info = find_all_field('production_ingredient_detail','','raw_item_id="'.$data->item_id.'" and item_id="'.$item_id.'"');
?>
  <tr>
    <td  bgcolor="#CCCCCC"><div align="left">
      <?=$data->item_name?></div></td>
    <td align="center" bgcolor="#CCCCCC"><?=$data->unit_name?></td>
    <td align="center" bgcolor="#CCCCCC"><input name="total_unit_<?=$data->item_id?>" type="text" class="input3" id="total_unit_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=$info->unit_batch_qty?>"/></td>
    <td align="center" bgcolor="#CCCCCC"><input name="ps_per_<?=$data->item_id?>" type="text" class="input3" id="ps_per_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=$info->process_loss_percentage?>"/></td>
    <td align="center" bgcolor="#CCCCCC"><input name="ss_per_<?=$data->item_id?>" type="text" class="input3" id="ss_per_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=$info->system_loss_percentage?>"/></td>
  </tr>
  <? }?>
</table>-->
<div align="center"><br />
    <br />
    <table width="1%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div align="center">
          <input name="update" type="submit" id="update" style="width:250px; height:35px; background-color:#66CC66; font-size:16px; font-weight:bold; color:#FF0000" value="Update Formula" />
        </div></td>
      </tr>
    </table>

</div>
<label>
<div align="center"></div>
</label>
<div align="center"><br />
  
</div>
</form>
</div>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>