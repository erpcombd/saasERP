<?

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='New Task Assign';

do_calander('#service_date');

do_calander('#schedule_date');

create_combobox('vendor_id');

$table_master='task_assign_master';

$table_details='service_details';

$unique = 'task_no';

if($_REQUEST['task_no']>0){
$$unique=$_SESSION[$unique]=$_REQUEST['task_no'];
}

if($_GET['mhafuz']>0) { $_SESSION[$unique] = '' ;  }
 
if(isset($_POST['new'])){ 

        echo $pbi_id = $_POST['PBI_ID'];

		$crud   = new crud($table_master);
		
		if($_SESSION[$unique] == '') { 
		

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$$unique=$_SESSION[$unique]=$crud->insert();

		unset($$unique);

		$type=1;

		$msg='New Task Assigned (Task No :-'.$_SESSION[$unique].')';
		
		unset($_SESSION[$unique]);
		
		header('Location:my_task_list.php');

		}else{ 

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);

		$type=1;
		unset($_SESSION[$unique]);

		$msg='Successfully Updated.';
		header('Location:my_task_list.php');

		}
  
}



$$unique=$_SESSION[$unique];



if(isset($_POST['delete']))

{

		$crud   = new crud($table_master);

		$condition=$unique."=".$$unique;		

		$crud->delete($condition);

		$crud   = new crud($table_details);

		$condition=$unique."=".$$unique;		

		$crud->delete_all($condition);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Deleted.';
		header('location:product_history.php');

}



if($_GET['del']>0)

{

$sql3='update requisition_order r, service_details p set r.req_status=0 where p.req_id=r.id and p.id='.$_GET['del'];
db_query($sql3);


		$crud   = new crud($table_details);

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

		$type=1;

		$msg='Successfully Deleted.';

}


if(isset($_POST['confirmm'])&&($_POST[$unique]>0))

{
	
        $delete_old = 'delete from service_details where service_no="'.$$unique.'" and serial_no="'.$_POST['serial_no'].'"';
		db_query($delete_old);
		$crud   = new crud($table_details);
		
		$eng = explode("#",$_POST['engineer']);
		
		$_POST['engineer'] = $eng[1]; 

		$_POST['item_id']=$_POST['item_id'];

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['update_by']=$_SESSION['user']['id'];

		$_POST['update_at']=date('Y-m-d h:s:i');
		
		$_POST['status'] = 'UNCHECKED';

		$crud->insert();
		
		$master_update = 'update service_master set status="UNCHECKED" where service_no="'.$$unique.'"';
		db_query($master_update);
		$_SESSION['smsgs'] = '<a href="service_received_print_view.php?service_no='.$$unique.'" target="_blank" style="color:green; font-size:14px; font-weight:bold;">New Service Order Created. Service No. '.$$unique.'</a>';
		unset($_SESSION[$unique]);
		header('location:product_history.php');

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

if($$unique>0) $btn_name='Update PO Information'; else $btn_name='Initiate PO Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);



//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

auto_complete_from_db('personnel_basic_info i','PBI_NAME','concat(PBI_NAME,"#",PBI_ID)','1','assign_person');
//auto_complete_start_from_db('item_info i, item_brand b','concat(i.finish_goods_code,"#>",i.item_name,"#>",b.brand_name)','i.finish_goods_code','1 and i.item_brand=b.id','item');

?>

<style>
.selectbox { width:100%; display:inline-block;}
.selectbox-title.form-control { padding-left: 16px;}
.selectbox-content { border:1px solid #d5d5d5; max-height:205px; overflow:auto; display:none; border-top: none;}
.selectbox-content ul { list-style:none; margin:0px; padding:0px; cursor: pointer;  position: relative; }
.selectbox-content ul li { padding-top:10px; width:100%; display:inline-block;}
.selectbox-content ul li:last-child { border-bottom:none;}
.selectbox-content ul li:first-child { border-top:none;}
.selectbox-content .input-group {padding: 5px;}
.loadbutton {
    padding: 10px;
}
.loadbutton .btn-primary {
    padding-top: 8px;
    padding-bottom: 8px;
}
.ul-list label {
    padding-left: 20px;
}
#box {
    height: 34px;
}
/***** INPUT FORM STYLES *****/
.form-horizontal .control-label {
  text-align: left; }

.control-label-pad .control-label {
  padding-top: 0px; }

.form-control {
  border-radius: 0;
  border: 1px solid #d5d5d5;
  background-color: white;
  height: 38px;
  color: #555555;
  -webkit-box-shadow: inset 0 0px 0px rgba(0, 0, 0, 0);
  box-shadow: inset 0 0px 0px rgba(0, 0, 0, 0); }
  .form-control:focus {
    border-color: #fbc52d;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(251, 197, 45, 0.6);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(251, 197, 45, 0.6); }

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
  background-color: #dddddd; }
  .form-control[disabled]:focus, .form-control[readonly]:focus, fieldset[disabled] .form-control:focus {
    border: none;
    box-shadow: none; }

.input-group-addon {
  border-radius: 0;
  padding: 6px 12px;
  font-size: 14px;
  font-weight: normal;
  line-height: 1;
  color: #091d3a;
  background-color: #e6e6e6;
  border: 1px solid #d5d5d5; }

.form-group .control-label {
  color: #535353; }

/*select style*/
.selectwrap {
  position: relative;
  float: left;
  width: 100%; }
  .selectwrap:after {
    content: "\f0d7";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    text-align: center;
    line-height: 36px;
    position: absolute;
    width: 26px;
    height: 36px;
    background: white;
    right: 1px;
    top: 1px;
    pointer-events: none; }

/***** CUSTOM 


STYLES *****/
.custom-checkbox-label .checkbox-pad {
  padding-top: 7px; }

.custom-checkbox label {
  font-weight: normal; }

.checkbox-custom {
  opacity: 0;
  position: absolute;
  display: inline-block;
  vertical-align: middle;
  margin: 0px;
  cursor: pointer; }

.checkbox-custom-label {
  display: inline-block;
  vertical-align: middle;
  margin: 0px;
  cursor: pointer;
  position: relative; }

.checkbox-custom + .checkbox-custom-label:before {
  content: '';
  background: white;
  display: inline-block;
  vertical-align: middle;
  width: 18px;
  height: 18px;
  padding: 0px;
  text-align: center;
  border: 1px solid #fbc52d;
  border-radius: 0px;
  margin-bottom: 4px;
  margin-right: 10px; }
.checkbox-custom:checked + .checkbox-custom-label:before {
  content: "\f00c";
  font-family: 'FontAwesome';
  color: #fbc52d;
  font-size: 12px;
  font-weight: 100;
  line-height: 5px;
  padding-top: 6px; }
.checkbox-custom:focus + .checkbox-custom-label {
  outline: 0px solid #dddddd; }
</style>

<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>


<script language="javascript">


function count()

{

var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);

document.getElementById('amount').value = num.toFixed(2);	

}

function count_1(id)

{

var num_1=((document.getElementById('qty'+id).value)*1)*((document.getElementById('unit_price'+id).value)*1);

document.getElementById('amount'+id).value = num_1.toFixed(2);	

}

</script>

<script>

/////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////

function insert_item(){
var item1 = $("#item_id");
var dist_unit = $("#qty");


if(item1.val()=="" || dist_unit.val()==""){
	 alert('Please check Item ID,Qty');
	  return false;
	}


	
$.ajax({
url:"po_input_ajax.php",
method:"POST",
dataType:"JSON",

data:$("#codz").serialize(),

success: function(result, msg){
var res = result;

$("#codzList").html(res[0]);	
$("#t_amount").val(res[1]);


$("#item_id").val('');
$("#qty").val('');
$("#remarks").val('');
$("#qoh").val('');

}
});	

//}else{ alert('Please Enter Debit Ledger'); }
//}else{ alert('Please check Ledger,amount and Date'); }

  }
/////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////


</script>

<script>

/////-=============-------========-------------Ajax  update Entry---------------===================-------/////////

function update_item(id){
var qty = $("#qty"+id).val();
var rate = $("#unit_price"+id).val();
var amount = $("#amount"+id).val();

if(qty>0 && rate>0 && amount>0){

	
$.ajax({
url:"po_update_ajax.php",
method:"POST",
dataType:"JSON",

data: {qty:qty, rate:rate, amount:amount,id:id} ,

success: function(result, msg){
var res = result;




}
});	
}

  }

</script>

<div class="form-container_large">

<form action="" method="post" name="cloud" id="cloud" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<div class="row ">
	     
	    <div class="col-md-12 form-group">
        <label for="<?=$field?>">Task Title:</label>
		<input class="form-control" name="task_no" type="hidden" id="task_no" value="<?=$task_no?>" readonly/>
		<input class="form-control" name="task_date" type="hidden" id="task_date" value="<?=($task_date!='')? $task_date : date('Y-m-d');?>" required/>
        <input class="form-control" name="task_title" type="text" id="task_title" value="<?=$task_title?>" />
        </div>
		
		<div class="col-md-12 form-group">
        <label for="<?=$field?>">Description:</label>
        <textarea class="form-control" name="description" id="description"><?=$description?></textarea>
        </div>
		
		<div class="col-md-3 form-group">
        <label for="<?=$field?>">Schedule:</label>
		<input type="text" name="schedule_date" id="schedule_date" class="form-control" value="<?=$schedule_date?>" style="background:darkcyan; color:#fff;">
        </div>
		
		<div class="col-md-3 form-group">
        <label for="<?=$field?>">Project:</label>
		<select name="project" id="project" class="form-control" style="background:darkcyan; color:#fff;">
		  <option></option>
		  <? foreign_relation('task_project','project_id','project_name',$project)?>
		</select>
        </div>
		
		<div class="col-md-3 form-group">
        <label for="<?=$field?>">Assign Person:</label>
		<select name="assign_person" id="assign_person" class="form-control" style="background:darkcyan; color:#fff;">
		  <option></option>
		 <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$assign_person);?>
		</select>
		</div>
		
		<div class="col-md-3 form-group">
        <label for="<?=$field?>">Priority:</label>
		<select name="priority" id="priority" class="form-control" style="background:darkcyan; color:#fff;">
		  <option></option>
		  <option <?=($priority==1)?'selected':''?> value="1">Priority 1</option>
		  <option <?=($priority==2)?'selected':''?> value="2">Priority 2</option>
		  <option <?=($priority==3)?'selected':''?> value="3">Priority 3</option>
		  <option <?=($priority==4)?'selected':''?> value="4">Priority 4</option>
		</select>
        </div>
		
		
		
		
	</div>
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <form action="<?=$page?>" method="post" name="codz2" id="codz2" class="font-weight-bold">
  
  
         
		  </div>
    

  <tr>

    <td colspan="2"><div class="buttonrow text-center" ><span class="buttonrow" >

      <? if($_SESSION[$unique]>0) {?>
         <!-- <input name="new" type="submit" class="btn1" value="Update Sales Return" style="width:200px; font-weight:bold; font-size:12px; tabindex="12>-->
		  <button type="submit" name="new" id="new" class="btn btn-success">Update Task</button>
          <input name="flag2" id="flag2" type="hidden" value="1" />
          <? }else{?>
          <!--<input name="new" type="submit" class="btn1" value="Initiate Sales Return" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />-->
		  <button type="submit" name="new" id="new" class="btn btn-primary">ASSIGN TASK</button>
          <input name="flag2" id="flag2" type="hidden" value="0" />
          <? }?>
        </span></div>
		
	</td>

    </tr>
    <? if($return_remarks!=''){?>
    
    <tr>

    <td colspan="2"><div class="buttonrow text-center" ><span class="buttonrow" >
      <table border="1" cellpadding="0" cellspacing="0" width="70%">
        <thead>
        <tr>
          <th>Return By</th>
          <th>Return At</th>
          <th>Return Reason</th>
          </tr>
          </thead>
          <tbody>
          <tr>
          <td><?=find_a_field('user_activity_management','fname','user_id="'.$checked_by.'"');?></td>
          <td><?=$checked_at?></td>
          <td><?=$return_remarks?></td>
          </tr>
         </tbody>
      </table>
    </div></td>

    </tr>
    <? } ?>

</table>

</form>

</div>
<script type="text/javascript">
    $('#example-multiple-selected').multiselect();
</script>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>