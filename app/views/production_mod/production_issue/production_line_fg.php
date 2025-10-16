<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Production Line Finish Goods';

if(isset($_POST['line_id']))
$line_id=$_POST['line_id'];

if($_GET['del']>0)
{
		$line_id = find_a_field('production_line_fg','line_id','id='.$_GET['del']);
		$crud   = new crud('production_line_fg');
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		$type=1;
		$msg='Successfully Deleted.';
}

if(isset($_POST['add'])&&($_POST['line_id']>0))
{
		$table		='production_line_fg';
		$crud      	=new crud($table);
		$crud->insert();
}


?><div class="form-container_large">
<form action="" method="post" name="cloud" id="cloud">

<table width="49%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset>
      <div>
        <label>Production Line Name : </label>
        <input  name="line_id" type="hidden" id="line_id" value="<?=$line_id?>"/>
        <input  name="manual_wo_id" type="text" id="manual_wo_id" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>"/>
        </div>
      <div></div>
      <div></div>
      
      <div></div>
      </fieldset></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
</table>
<table  width="70%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Finish Goods </strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Hourly Produce</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Unit Name</strong></td>
                        <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC"><span id="inst_no">
<select name="fg_item_id" id="fg_item_id" required onchange="getData2('pl_ajax.php', 'pl',this.value,'');">
<option value=""></option>
<? 
foreign_relation('item_info','item_id','concat(finish_goods_code," : ",item_name)',$fg_item_id,'product_nature="Salable" order by finish_goods_code');?>
</select>
<input  name="wo_id" type="hidden" id="wo_id" value="<?=$wo_id?>"/>
</span></td>
<td bgcolor="#CCCCCC"><input name="hourly_production" type="text" class="input3" id="hourly_production" style="width:110px;"/></td>
<td bgcolor="#CCCCCC"><span id="pl"><input name="unit_name" type="text" class="input3" id="unit_name" style="width:100px;"/></span></td>
</tr>
    </table><br /><br /><br />

<? 
$res='select a.id,b.warehouse_id as id,c.item_name,a.hourly_production,a.unit_name,"X" from production_line_fg a,warehouse b,item_info c where b.warehouse_id=a.line_id and c.item_id=a.fg_item_id and b.warehouse_id='.$line_id;
?>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
//$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';
echo link_report_del($res);
		?>

      </div></td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>
</form>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>