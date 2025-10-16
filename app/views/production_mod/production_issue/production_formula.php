<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Ingredent Formula';

if(isset($_POST['item_id'])) $item_id = $_POST['item_id'];
$ingredient_formula_code = find_all_field('production_ingredient_formula','ingredient_formula_code','fg_item_id='.$item_id);

if(isset($_POST['add'])&&($_POST['item_id']>0))
{
		$table		='production_ingredient_detail';
		$crud      	=new crud($table);
		$crud->insert();
}

if(isset($_POST['new'])&&($_POST['item_id']>0))
{
		$table		= 'production_ingredient_formula';
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:i:s');
		
		$_POST['fg_item_id'] = $_POST['item_id'];
		$_POST['introduce_date'] = date('Y-m-d');
		$crud      	= new crud($table);
		$crud->insert();
}

?><div class="form-container_large" >
<form action="" method="post" name="cloud" id="cloud">

<table width="60%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset style="width:500px;">
      <div>
        <label style="width:200px;">Finished Good Name : </label>
        <input  name="item_id" type="hidden" id="item_id" value="<?=$item_id?>"/>
        <input  name="manual_wo_id" type="text" id="manual_wo_id" value="<?=find_a_field('item_info','item_name','item_id='.$item_id)?>" style="width:250px;" readonly="readonly"/>
        </div>
      <div>
      <label style="width:200px;">Production Formula Code : </label>
      <input  name="ingredient_formula_code" type="text" id="ingredient_formula_code" value="<?=$ingredient_formula_code->ingredient_formula_code;?>" style="width:250px;" onchange="document.cloud.new.style.visibility = 'visible';"/>
      <input  name="formula_id" type="hidden" id="formula_id" value="<?=$ingredient_formula_code->id?>"/>
      </div><br />
      <div style="padding-left:220px;visibility:hidden;" id="ssub">
    <input type="submit" name="new" id="new" value="NEW" style="height:25px; width:100px; font-size:12px; font-weight:bold;" />
      </div>
    </fieldset></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<? if($ingredient_formula_code!=''){?>
<table  width="95%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Raw Material </strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Unit Name</strong></td>
                        <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC"><span id="inst_no">
<select name="raw_material_id" id="raw_material_id" required onchange="getData2('pl_ajax.php', 'pl',this.value,'');" style="width:400px;">
<option value=""></option>
<? 
foreign_relation('item_info','item_id','item_name',$fg_item_id,'product_nature!="Salable" order by item_name');?>
</select>
<input  name="wo_id" type="hidden" id="wo_id" value="<?=$wo_id?>"/>
</span></td>
<td bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty" style="width:110px;"/></td>
<td bgcolor="#CCCCCC"><span id="pl"><input name="unit_name" type="text" class="input3" id="unit_name" style="width:100px;"/></span></td>
</tr>
    </table><br /><br /><br />
<? 
$res='select a.id,c.item_name as ingredient_name,a.qty,a.unit_name from production_ingredient_detail a,item_info c where c.item_id=a.raw_material_id and  
 a.formula_id='.$ingredient_formula_code->id;
?>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
//$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';
echo link_report($res);
		?>

      </div></td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>
<? }?>
</form>
</div>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>