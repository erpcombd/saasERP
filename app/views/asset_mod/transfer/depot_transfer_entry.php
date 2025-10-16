<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$title='Depot Transfer';



//do_calander('#pi_date','-15','0');

do_calander('#old_production_date');

$page = 'depot_transfer_entry.php';

if($_POST['line_id']>0) 

$line_id = $_SESSION['line_id']=$_POST['line_id'];

elseif($_SESSION['line_id']>0) 

$line_id = $_POST['line_id']=$_SESSION['line_id'];

$table_master='asset_transfer_master';

$unique_master='pi_no';

$table_detail='asset_transfer_details';

$unique_detail='id';


if($_SESSION[$unique_master]>0)

$$unique_master=$_SESSION[$unique_master];

elseif(isset($_GET['del']))

{

$$unique_master=find_a_field($table_detail,$unique_master,'id='.$_GET['del']); $del = $_GET['del'];

}

else

$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){

if(isset($_POST['new']))

{

		$crud   = new crud($table_master);

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['entry_by']=$_SESSION['user']['id'];

		if($_POST['flag']<1){

		$$unique_master=$crud->insert();

		unset($$unique);

		$type=1;

		$msg='Product Issued. (PI No-'.$$unique_master.')';

		}

		else {

		$crud->update($unique_master);

		$type=1;

		$msg='Successfully Updated.';

		}
//header("Location: depot_transfer_entry.php?pi_no=$_POST['pi_no']");
}



if(isset($_POST['add'])&&($_POST[$unique_master]>0))

{

		$table		=$table_detail;

		$crud      	=new crud($table);

		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[2];

		$_POST['unit_price']=$_POST['unit_price'];
		//$_POST['total_amt']= ($_POST['total_unit'] * $_POST['unit_price']);



		$xid = $crud->insert();

		
}

}

else

{

	$type=0;

	$msg='Data Re-Submit Error!';

}



if(isset($_GET['del']) && ($_GET['del']>0) )

{	
		$del=$_GET['del'];
		$crud   = new crud($table_detail);

		$condition=$unique_detail."=".$del;		

		$crud->delete_all($condition);

		//db_query($sql);

		$type=1;

		$msg='Successfully Deleted.';

}



if($$unique_master>0)

{

		$condition=$unique_master."=".$$unique_master;

		$data=db_fetch_object($table_master,$condition);

        foreach($data as $key =>$value)

        { $$key=$value;}

}



//auto_complete_from_db('item_info i,item_model m','concat(m.model_name,"#>",i.item_name,"#>",i.item_id)','concat(m.model_name,"#>",i.item_name,"#>",i.item_id)','i.model=m.id and i.status="Active"','item_id');?>
<script language="javascript">

function focuson(id) {

  if(document.getElementById('item_id').value=='')

  document.getElementById('item_id').focus();

  else

  document.getElementById(id).focus();

}



function total_amtt() {

document.getElementById('total_amt').value = (((document.getElementById('unit_price').value)*1)*((document.getElementById('total_pcs').value)*1));

}

</script>

<div class="form-container_large">
  <form action="<?=$page?>" method="post" name="codz2" id="codz2">
  <div class="row ">
    
	
	     <div class="col-md-3 form-group">
            <label for="do_no" >Transfer No : </label>
           <input   name="pi_no" type="text" id="pi_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" class="form-control" readonly/>
          </div>
		  
		 
		  
		  
		 <div class="col-md-3 form-group">
            <label for="wo_detail2"> Note: </label>
            <input type="text" name="remarks" id="remarks" value="<?=$remarks?>" class="form-control" />
          </div>
		  
		  
		   <div class="col-md-3 form-group">
            <label for="wo_detail">Transfer From: </label>
             <input name="warehouse_from" type="hidden" id="warehouse_from"  value="<?=$_SESSION['user']['depot']?>"  />

        <input name="warehouse_from3" type="text" id="warehouse_from3" class="form-control" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" readonly />
          </div>
		  
		  
		  
		  
		    <div class="col-md-3 form-group">
            <label for="wo_detail">Transfer Date: </label>
            <input class="form-control"  name="pi_date" type="text" id="pi_date" value="<? if($pi_date=='') echo date('Y-m-d');else echo $pi_date;?>" autocomplete="off" readonly  required/>
          </div>
		  
		  
          <!--<div class="col-md-3 form-group">
            <label for="depot_id">Manual TR No : </label>
        <input name="invoice_no" type="text" id="invoice_no" class="form-control" value="<?=$invoice_no?>" tabindex="105" required />
            <input style="width:155px;"  name="wo_detail" type="text" id="wo_detail" value="<?=$depot_id?>" readonly="readonly"/>
          </div>-->
		  
          <div class="col-md-3 form-group">
            <label for="rcv_amt">Receivable Branch: </label>
          <input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$line_id?>" />

        <input name="warehouse_from4" type="text" id="warehouse_from4" class="form-control" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>" readonly />
          </div>
	  
   </div>
    <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
	
      
      <tr>
        <td colspan="2"><div class="buttonrow text-center"><samp class="buttonrow">
            <? if($$unique_master>0) {?>
<!--            <input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
-->					  <button type="submit" name="new" id="new" class="btn btn-success">Update Asset Transfer</button>


            <input name="flag" id="flag" type="hidden" value="1" />
            <? }else{?>
            <!--<input name="new" type="submit" class="btn1" value="Initiate Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />-->
			  <button type="submit" name="new" id="new" class="btn btn-primary">Initite Asset Transfer</button>
            <input name="flag" id="flag" type="hidden" value="0" />
            <? }?>
        </samp>
		</div></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
    </table>
  </form>
  <form action="?<?=$unique_master?>=<?=$$unique_master?>" method="post" name="codz" id="codz" autocomplete="off">
    <? if($$unique_master>0){?>
    <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
      <tr>
        <td align="center" width="30%" bgcolor="#0099FF"><strong>Item Name</strong></td>
        <td align="center" width="11%" bgcolor="#0099FF"><span style="font-weight: bold">Unit</span></td>
        <td align="center" width="11%" bgcolor="#0099FF"><strong>Stock</strong> </td>
        <td align="center" width="15%" bgcolor="#0099FF"><strong>Serial No</strong></td>
        <td align="center" width="11%" bgcolor="#0099FF"><strong>Qty</strong></td>
        <td  rowspan="2" width="11%" align="center" bgcolor="#FF0000"><div class="button">
            <!--<input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update" onclick="recal();"/>-->
			<input name="add" type="button" id="add" value="ADD" onclick="insert_item()"  tabindex="12" class="update"/>   
          </div></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#CCCCCC"><div align="center">
            <input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>
            <input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>"/>
            <input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
            <input  name="pi_date" type="hidden" id="pr_date" value="<?=$pi_date?>"/>
            <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" list="item_list" style="width:98%;" required onblur="getData2('depot_transfer_ajax.php', 'pr', this.value, document.getElementById('warehouse_from').value);"/>
			<datalist id="item_list">
			 <? foreign_relation('item_info i,item_sub_group s, item_group g','concat(i.item_name," - ",s.sub_group_name,"->",i.item_id)','""',$item_id,'i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_name like "%Asset%" group by i.item_id');
			 ?>
			</datalist>
            <input name="remarks" type="hidden" id="remarks" style="width:105px;" value="<?=$remarks?>" tabindex="105" />
          </div></td>
        <td colspan="4" align="center" bgcolor="#CCCCCC"><div align="center"><span id="pr">
		
            <table style="width:100%;" border="1">
	        <tr>
            <td width="33%"><input name="total_unit2" type="text" class="input3" id="total_unit2"  maxlength="100" style="width:98%;" required/></td>
            <td width="33%"><input name="old_production_date" type="text" class="input3" id="stock2"  maxlength="100" style="width:98%;"/></td>
            <td width="33%"><input name="serial_no" type="text" class="input3" id="serial_no"  maxlength="100" style="width:170px;"/></td>
            <td align="center" bgcolor="#CCCCCC"><input name="total_pcs" type="text" class="input3" id="total_pcs"  style="width:115px;" required  onkeyup="total_amtt()"/></td>
			</tr></table>
            </span> </div></td>
         
        
      </tr>
    </table>
    <br />
    <br />
    <br />
    <br />
    <? 



//$res='select a.id,b.finish_goods_code as code,b.item_name,b.unit_name,FLOOR(a.total_unit/b.pack_size) as total_qty,a.total_unit%b.pack_size as pcs_qty,"X" from asset_transfer_details a,item_info b where b.item_id=a.item_id and a.pi_no='.$$unique_master.' order by a.id';


$res='select a.id,b.finish_goods_code as FG_code,b.item_name,b.unit_name,a.serial_no, a.total_unit as total_qty, "X" from asset_transfer_details a,item_info b where b.item_id=a.item_id and a.pi_no='.$$unique_master.' order by a.id';

?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="tabledesign2">
            <span id="codzList">
            <? 

echo link_report_add_del_auto($res,1,6);

		?>
          </span></div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
  </form>
  <form action="asset_transfer.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
    <table width="100%" border="0">
      <tr>
        <td align="center"><input  name="pi_no" type="hidden" id="pi_no" value="<?=$$unique_master?>"/></td>
        <td align="right" style="text-align:right">
		<input name="delete" type="submit" class="btn btn-danger" value="DELETE THIS TRANSFER" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white; float:left" />
		
		<input name="confirm" type="submit" class="btn btn-info" value="CONFIRM AND SEND" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white; float:right" />
        </td>
      </tr>
    </table>
    <? }?>
  </form>
</div>

<script>
function check_serial(){

$.ajax({
		url: "serial_check_ajax_transfer.php",
		method: "POST",
		dataType:"json",
		data:{
		serial_no: $("#serial_no").val(),
		pi_no: $("#pi_no").val(),
		item_id: $("#item_id").val()
		},
		success: function(data){

		$("#serial_check").html(data.msg);
		if(data.msg!=''){
		$("#serial_no").val('');
		}
		
		}
		})
}
</script>
<script>
function insert_item(){
var item1 = $("#item_id");
var dist_unit = $("#total_pcs");


if(item1.val()=="" || dist_unit.val()==""){
	 alert('Please check Item ID,Qty');
	  return false;
	}
	
var dist_unit2 = ((document.getElementById('total_unit').value)*1);
var in_stock2 = ((document.getElementById('stock2').value)*1);

if(dist_unit2>in_stock2){
alert('Stock Overflow!');
return false;
document.getElementById('total_pcs').value = '';
}


	
$.ajax({
url:"depot_input_ajax.php",
method:"POST",
dataType:"JSON",

data:$("#codz").serialize(),

success: function(result, msg){
var res = result;

$("#codzList").html(res[0]);	
$("#t_amount").val(res[1]);

$("#serial_no").val('');
//$("#item_id").val('');
//$("#qty").val('');
//$("#remarks").val('');
//$("#qoh").val('');

}
});	

  }
</script>
<script>$("#codz").validate();$("#cloud").validate();</script>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
