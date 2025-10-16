<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Work Order Create';
do_calander('#wo_date');
do_calander('#chalan_date');
$table='lc_workorder';
$unique='id';

$wo_id=$_SESSION['wo_id']=$_POST['wo_id'];

if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST['id']=$wo_id;
		$_POST['status']='DONE';
		$crud   = new crud('lc_workorder');
		$crud->update('id');
		unset($wo_id);
		unset($_SESSION['wo_id']);
		$type=1;
		$msg='Successfully Send to Factory.';
}

if($wo_id>0)
{
		$condition=$unique."=".$wo_id;
		$data=db_fetch_object($table,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}

if(isset($_POST['add'])&&($_POST['wo_id']>0))
{
		$table		='lc_workorder_chalan';
		$crud      	=new crud($table);
		$crud->insert();
}


?><div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset>
      <div>
        <label>Work Order No : </label>
        <input  name="id" type="hidden" id="id" value="<?=$_SESSION['wo_id']?>"/>
        <input  name="manual_wo_id" type="text" id="manual_wo_id" value="<?=$manual_wo_id?>"/>
      </div>
      <div>
        <label for="email">Work Order Date : </label>
        <input  name="wo_date" type="text" id="wo_date" value="<?=$wo_date?>"/>
      </div>
      <div>
        <label for="email">Party Name : </label>
        <select id="buyer_id" name="buyer_id">
        <? foreign_relation('lc_buyer','id','buyer_name',$buyer_id);?>
        </select>
      </div>
      
      <div>
        <label for="email">Buyer Name : </label>
        <input  name="buyer" type="text" id="buyer" value="<?=$buyer?>" />
      </div>
      <div>
        <label for="email">Prepared By : </label>
        <input  name="prepared_bys" type="text" id="prepared_bys" value="<?=$_SESSION['user']['fname']?>" readonly="readonly"/>
        <input  name="prepared_by" type="hidden" id="prepared_by" value="<?=$_SESSION['user']['id']?>" readonly="readonly" />
      </div>
    </fieldset></td>
    <td>
			<fieldset>
			
			<div>
			<label>Work Order For : </label> 
			<input  name="wo_subject" type="text" id="wo_subject" value="<?=$wo_subject?>"/>
			</div>
			<div>
			<label for="email">Details : </label>
            <textarea name="wo_detail" style="height:65px; width:140px" id="wo_detail"><?=$wo_detail ?></textarea>
			</div>
			</fieldset>	</td>
  </tr>
  <tr>
    <td colspan="2">

    <table width="30%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006600" style="color:#CCC">
      <tr>
        <td align="center" bgcolor="#339900" style="height:30px; color:#FFF; font-size:18px;"><strong><?=$status?></strong></td>
      </tr>
    </table></td>
    </tr>
</table>
</form>
<? if($wo_id>0){?>
<? 
$res='select a.id,b.item_name,a.style_no,a.specification,a.meassurment,a.qty,(select sum(b.qty) as sqty from lc_workorder_chalan b where a.id=b.specification_id) as chalan_qty from lc_workorder_details a,lc_product_item b where b.id=a.item_id and a.wo_id='.$wo_id;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <p>
          <? 
echo link_report($res);
		?>
        </p>
      </div></td>
    </tr>
	
    <tr>
     <td>

 </td>
    </tr>
  </table>
<form action="?req_id=<?=$req_id?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                            <td colspan="4" align="center" bgcolor="#CCCCFF"><strong>CHALAN DELIVER</strong></td>
      </tr>
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Item Specification</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Chalan Date</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Chalan Qty</strong></td>
                        <td rowspan="2" align="center" bgcolor="#FF0000"><div class="button">
                          <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>
                        </div></td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC"><span id="inst_no">
  <select name="specification_id" id="specification_id" style="width:300px">
  <? $sql="select c.id,concat(b.category_name,'-',a.item_name,' (',c.style_no,'::',',c.specification,'::',c.meassurment,')') from lc_product_item a,lc_product_category b,lc_workorder_details c where c.item_id=a.id and a.product_category_id=b.id and c.wo_id=".$wo_id;
advance_foreign_relation($sql,$value='');
?>
  </select>
  <input  name="wo_id" type="hidden" id="wo_id" value="<?=$wo_id?>"/>
</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="chalan_date" type="text" class="input3" id="chalan_date"  maxlength="400" style="width:100px;"/></td>
<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:100px;"/></td>
</tr>
    </table>
					  <br /><br /><br /><br />

<?
$res="select d.id,concat(b.category_name,'-',a.item_name,' (',c.specification,'::',c.meassurment,')') as item,d.chalan_date,d.qty from lc_product_item a,lc_product_category b,lc_workorder_details c,lc_workorder_chalan d where c.item_id=a.id and a.product_category_id=b.id and c.id=d.specification_id  and c.wo_id=".$wo_id;


?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

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
<table width="100%" border="0">
  <tr>
      <td align="center"><p>&nbsp;</p>
        <table width="1%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><input name="confirm" type="submit" class="btn1" value="ALL CHALAN COMPLETE FOR THIS WORKORDER" style="width:370px; font-weight:bold; font-size:12px; height:30px; color:#090" /></td>
        </tr>
    </table></td>
      
    </tr>
</table>
</form>
<? }?>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>