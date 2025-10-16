<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Commercial Expense';
$line_id = $_REQUEST['line_id'];
if(isset($_REQUEST['item_id'])) $item_id = $_REQUEST['item_id'];

$sql = 'select w.warehouse_name,p.line_id from warehouse w,production_line_fg p where w.warehouse_id=p.line_id and p.line_id= '.$line_id.'  and w.use_type="PL" and  p.fg_item_id='.$item_id;
$line = find_all_field_sql($sql);

$old_data = find_all_field('production_ingredient_detail','','item_id="'.$item_id.'"');

if(isset($_POST['update'])&&($_GET['do_no']>0))
{
$table		= 'production_floor_issue_commercial';
		
$crud      	= new crud($table);


 $sqlSub = 'select i.item_name,i.item_id as fg_item_id, s.sub_group_name,i.sub_group_id from item_info i, item_sub_group s, sale_do_details r where i.sub_group_id=s.sub_group_id and  i.item_id =r.item_id  and r.do_no='.$_GET['do_no'].'  group by i.item_id order by i.item_id';
$querySub = db_query($sqlSub);
while($dataSub = mysqli_fetch_object($querySub)){


 $sql = 'select i.* from item_info i  where   i.sub_group_id = 60000000 order by i.item_name' ;


$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
$_POST['total_amt'] = $_POST['total_unit_'.$data->item_id.'_'.$dataSub->fg_item_id];
$_POST['item_id'] = $data->item_id;
$_POST['so_no'] = $_GET['do_no'];
$_POST['fg_item_id'] = $dataSub->fg_item_id;
$old_data = find_all_field('production_floor_issue_commercial','','item_id="'.$data->item_id.'" and fg_item_id="'.$dataSub->fg_item_id.'" and so_no="'.$_GET['do_no'].'" ');

	if($old_data->id>0)
	{

		$_POST['edit_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['id'] = $id = $old_data->id;
		$crud->update('id');
	}
	else
	{
	if($_POST['total_amt']>0){
	unset($_POST['id']);
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['entry_by']=$_SESSION['user']['id'];
		$crud->insert();
		}
	}
}

}

}

?><div class="form-container_large" >
<form action="" method="post" name="cloud" id="cloud">
<fieldset style="width:100%;">
      <div>
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <!--<tr>
    <td><label >Finished Good Name: </label></td>
    </tr>
  <tr>
    <td><div><label >Production Line: </label> </div></td>
  </tr>
  
  <tr>
    <td><div><label >Batch For KG/Pcs: </label></div></td>
  </tr>-->
  <tr>
    <td>&nbsp;</td>
  </tr>
</table></div>
    </fieldset>

<?   $sqlSub = 'select i.item_name,i.item_id as fg_item_id, s.sub_group_name,i.sub_group_id from item_info i, item_sub_group s, sale_do_details r where i.sub_group_id=s.sub_group_id and  i.item_id =r.item_id  and r.do_no='.$_GET['do_no'].'  group by i.item_id order by i.item_id';
$querySub = db_query($sqlSub);
while($dataSub = mysqli_fetch_object($querySub)){	 ?>
	
<table  width="80%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
    <td width="70%" align="center" bgcolor="#33CCFF"><strong><?=$dataSub->item_name; ?></strong></td>
    <td width="10%" align="center" bgcolor="#33CCFF"><span style="font-weight: bold">Unit</span></td>
    <td width="10%" align="center" bgcolor="#33CCFF"><strong>Amount</strong></td>
    </tr>
<? 

$sql = 'select i.* from item_info i  where   i.sub_group_id = 60000000 order by i.item_name';
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){ 
$info = find_all_field('production_floor_issue_commercial','','item_id="'.$data->item_id.'" and fg_item_id = "'.$dataSub->fg_item_id.'" and so_no = "'.$_GET['do_no'].'" ');

?>
  <tr>
    <td  bgcolor="#CCCCCC"><div align="left">
      <?=$data->item_name?></div></td>
    <td align="center" bgcolor="#CCCCCC"><?=$data->unit_name?></td>
    <td align="center" bgcolor="#CCCCCC"><input name="total_unit_<?=$data->item_id?>_<?=$dataSub->fg_item_id; ?>" type="text" class="input3" id="total_unit_<?=$data->item_id?>"  maxlength="100" style="width:67px;" value="<?=$info->total_amt?>"/></td>
    </tr>
<? }?>
</table>
<? } ?>


<div align="center"><br />
    <br />
    <table width="1%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div align="center">
          <input name="update" type="submit" id="update" style="width:250px; height:35px; background-color:#66CC66; font-size:16px; font-weight:bold; color:#FF0000" value="Save" />
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