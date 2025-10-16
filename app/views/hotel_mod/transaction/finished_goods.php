<?php
require_once "../../../assets/template/layout.top.php";
$title='Finished Goods Receive';
do_calander('#date');
$table='proc_production';
$unique='id';


if(isset($_POST['new']))
{
$crud      =new crud($table);
$now				= time();

		if($_POST['id']==='NEW'){
		
		
		$sql="update proc_product_info set qop=qop+".($_POST['qty'])." where id=".$_POST['product_id']." limit 1";
		mysql_query($sql);
		$crud->insert();
		//unset($_POST);
		unset($$unique);
		$req_id=$$unique = mysql_insert_id();
		$type=1;
		$msg='Successfully Created';
		}
		else {
		$req_id = $$unique = $_POST[$unique];
		}
}

if($req_id>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table,$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
		
}
elseif($_GET['req_id']>0)
{
		$req_id= $$unique=$_GET['req_id'];
		
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table,$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
		
}


if(isset($_POST['add'])&&isset($_POST['req_id'])&&($_POST['req_id']>0))
{
		$_POST['production_id'] = $_POST['req_id'];
		$table		='proc_production_details';
		$crud      	=new crud($table);
		$sql="update proc_raw_material set qop=qop-".($_POST['qty_consumed']+$_POST['qty_wasted'])." where id=".$_POST['material_id']." limit 1";
		mysql_query($sql);
		
		$crud->insert();
}


?><div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
			<fieldset>
			
			<div>
			<label>Product Receive  ID: </label>
			<select name="id" id="id">
				<? foreign_relation('proc_production','id','id',$id,'status=1');?>
              	<option value="NEW">New Product Receive</option>
			</select>
			</div>
			<div>
			<label>Date: </label> 
			<input  name="date" type="text" id="date" value="<?=$date?>"/>
			<input  name="status" type="hidden" id="status" value="1"/>
			</div>
			<div>
			<label>Product Qty: </label> 
			<input  name="qty" type="text" id="qty" value="<?=$qty?>"/>
			<input  name="status" type="hidden" id="status" value="1"/>
			</div>
			<div class="buttonrow" style="margin-left:154px;"><input name="new" type="submit" class="btn1" value="Submit" /></div>
			</fieldset>
		</td>
    <td>
			<fieldset>
			
			<div>
			<label>Factory : </label>
				<select name="factory_id" id="factory_id">
				<? foreign_relation('proc_factory_info','id','factory_name',$factory_id);?>
				</select>
			</div>
			<div>
			<label for="email">Line : </label>
				<select name="line_id" id="line_id">
				<? foreign_relation('proc_production_by_line','id','line_name',$line_id);?>
				</select>
			</div>
			<div>
			<label>Product Name  : </label>
				<select name="product_id" id="product_id">
				<? foreign_relation('proc_product_info','id','product_name',$product_id);?>
				</select>
			</div>
			<div>
			<label>Consumed Time  : </label> 
			<input  name="time_consumed" type="text" id="time_consumed" value="<?=$time_consumed?>"/>
			</div>
			
			</fieldset>
			
		</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>


<? if($req_id>0){?>
<form action="?req_id=<?=$req_id?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Prod ID </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Material Name </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Consumed Qty </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Wasted Qty </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Note</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
                        <td align="center" bgcolor="#CCCCCC"><input name="req_id" type="text" id="req_id" style="width:50px;"  tabindex="9" class="input3" value="<?=$req_id?>"/>										    </td>
                          <td align="center" bgcolor="#CCCCCC">
                            <span id="inst_no">
                            <select name="material_id" id="material_id">
<? 
foreign_relation('proc_raw_material','id','material_name',$material_id);?>
</select>
                        </span>						</td>
						  
                          <td bgcolor="#CCCCCC"><input name="qty_consumed" type="text" id="qty_consumed" style="width:50px;"  tabindex="9" class="input3" value="<?=$qty_consumed?>"/></td>

                          <td align="center" bgcolor="#CCCCCC"><input name="qty_wasted" type="text" id="qty_wasted" style="width:50px;"  tabindex="9" class="input3" value="<?=$qty_wasted?>"/></td>
                          <td align="center" bgcolor="#CCCCCC"><input name="note" type="text" id="note"  tabindex="10" class="input3" style="width:100px;" /></td>
      </tr>
    </table>
					  <br /><br /><br /><br />
</form>

<? }?>
<? if($req_id>0){
$res='select a.id,a.production_id,b.material_name,a.qty_consumed,a.qty_wasted,a.note from proc_production_details a,proc_raw_material b where b.id=a.material_id and a.production_id='.$req_id;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="tabledesign2">
        <? 
echo link_report($res);
		?>
      </div></td>
    </tr><tr>
     <td>

 </td>
    </tr>
  </table>
<? }?>
</div>
<?
require_once "../../../assets/template/layout.bottom.php";
?>