<?php
require_once "../../../assets/template/layout.top.php";
$title='Requisition Requirement';
do_calander('#req_date');
do_calander('#need_by_date');
$table='proc_raw_material_requisition';
$unique='id';


if(isset($_POST['new']))
{

$crud      =new crud($table);
$now				= time();

		if($_POST['id']==='NEW'){
		$crud->insert();
		//unset($_POST);
		unset($$unique);
		$req_id=$$unique = mysql_insert_id();
		$type=1;
		$msg='Requization Id Created. (REQ ID-'.$$unique.'.)';
		}
		else {
		$req_id=$$unique = $_POST[$unique];
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
		$table		='proc_raw_material_requisition_details';
		$crud      	=new crud($table);
		$crud->insert();
}


?><div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
			<fieldset>
			
			<div>
			<label>Requization ID: </label>
			<select name="id" id="id">
<? 
foreign_relation('proc_raw_material_requisition','id','id',$id,'status=1');?>
              <option value="NEW">New Order</option></select>
			  
			</div>
			
			<div class="buttonrow" style="margin-left:154px;"><input name="new" type="submit" class="btn1" value="Submit" /></div>
			</fieldset>	</td>
    <td>
			<fieldset>
			
			<div>
			<label>Request By: </label> 
			<input  name="requisition_by" type="text" id="requisition_by" value="<?=$requisition_by?>"/>
			</div>
			<div>
			<label for="email">Date of Requization: </label>
			<input  name="req_date" type="text" id="req_date" value="<?=$req_date?>"/>
			</div>
			<div>
			<label>Estimated Date : </label> 
			<input  name="need_by_date" type="text" id="need_by_date" value="<?=$need_by_date?>"/>
			<input  name="status" type="hidden" id="status" value="1"/>
			</div>
			</fieldset>	</td>
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
                        <td align="center" bgcolor="#0099FF"><strong>Req ID </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Material Name </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Qty Required </strong></td>
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
						  
                          <td bgcolor="#CCCCCC"> 
<span id="inst_date">                      
<input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:100px;"/>
</span>					    </td>

                          <td align="center" bgcolor="#CCCCCC">
<span id="inst_amt">
<input name="description" type="text" id="description"  tabindex="10" class="input3" style="width:100px;" /> 
</span>                        </td>
      </tr>
    </table>
					  <br /><br /><br /><br />
</form>
<? }?>
<? if($req_id>0){
$res='select a.req_id,a.req_id,b.material_name,a.qty,a.description from proc_raw_material_requisition_details a,proc_raw_material b where b.id=a.material_id and a.req_id='.$req_id;
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
<? }?>
</div>

<?
require_once "../../../assets/template/layout.bottom.php";
?>