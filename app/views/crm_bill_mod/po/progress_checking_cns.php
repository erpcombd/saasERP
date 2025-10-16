<?


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Progress Report Entry';




do_calander('#progress_date');

do_calander('#date');

//create_combobox('vendor_id');

$table_master='daily_progress_master';

$table_details='daily_progress_details';

$unique='d_id';
if($_GET['d_id']){
$_SESSION[$unique]=$_GET['d_id'];
}
if($_GET['mhafuz']>0) { $_SESSION[$unique] = '' ;  }
 
if(isset($_POST['new'])){ 

		$crud   = new crud($table_master);
		
		if($_SESSION[$unique] == '') { 
		

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$$unique=$_SESSION[$unique]=$crud->insert();
		
		
		
//			if($_POST['req_no']>0){
//			 $sql5='select * from requisition_order where req_status=0 and req_no='.$_POST['req_no'];
//			
//			$query = db_query($sql5);
//			while($row=mysqli_fetch_object($query)){
//			     $sql_nsert = 'insert into daily_progress_details (d_id, progress_date, vendor_id, item_id, req_id, warehouse_id, qty, unit_name)
//				values("'.$_POST[$unique].'", "'.$_POST['progress_date'].'", "'.$_POST['vendor_id'].'",  "'.$row->item_id.'",  "'.$row->id.'", "'.$_SESSION['user']['depot'].'", "'.$row->qty.'", "'.$row->unit_name.'" ) ';
//				
//				db_query($sql_nsert);
//				
//				
//				$sql3='update requisition_order  set req_status=1 where id='.$row->id;
//				db_query($sql3);
//			}
//			
//			}

		unset($$unique);

		$type=1;

		$msg='Purchase Order No Created. (PO No :-'.$_SESSION[$unique].')';
		
		header('Location:po_create.php');

		}else{ 

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);
		
		//if($_POST['req_no']>0){
//			 $sql5='select * from requisition_order where req_status=0 and req_no='.$_POST['req_no'];
//			
//			$query = db_query($sql5);
//			while($row=mysqli_fetch_object($query)){
//			     $sql_nsert = 'insert into daily_progress_details (d_id, progress_date, vendor_id, item_id, req_id, warehouse_id, qty, unit_name)
//				values("'.$_POST[$unique].'", "'.$_POST['progress_date'].'", "'.$_POST['vendor_id'].'",  "'.$row->item_id.'",  "'.$row->id.'", "'.$_POST['warehouse_id'].'", "'.$row->qty.'", "'.$row->unit_name.'" ) ';
//				
//				db_query($sql_nsert);
//				
//				
//				$sql3='update requisition_order  set req_status=1 where id='.$row->id;
//				db_query($sql3);
//			}
//			
//			}

		$type=1;

		$msg='Successfully Updated.';

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

}



if($_GET['del']>0)

{

$sql3='update requisition_order r, daily_progress_details p set r.req_status=0 where p.req_id=r.id and p.id='.$_GET['del'];
db_query($sql3);


		$crud   = new crud($table_details);

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

		$type=1;

		$msg='Successfully Deleted.';

}

if(isset($_POST['confirmm']))

{
if($_POST['progress_for']==1){
 $res='select a.id, a.customer_name as name, a.address as section, a.pet_type as action_plan, a.delivery as target_amount, a.gap_analysis as challenges, a.collection as progress, a.next_visit as follow_up, "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
 $customer_name=$_POST['customer_name'.$data->id];
 $address=$_POST['address'.$data->id];
 $pet_type=$_POST['pet_type'.$data->id];
 $delivery=$_POST['delivery'.$data->id];
 $gap_analysis=$_POST['gap_analysis'.$data->id];
 $collection=$_POST['collection'.$data->id];
 $next_visit=$_POST['next_visit'.$data->id];
  
   $update = 'update daily_progress_details set customer_name="'.$customer_name.'",address="'.$address.'",pet_type="'.$pet_type.'",delivery="'.$delivery.'",gap_analysis="'.$gap_analysis.'",collection="'.$collection.'",next_visit="'.$next_visit.'" where id="'.$data->id.'"';
  db_query($update);
 
 }
 } elseif($_POST['progress_for']==2){
 $res='select a.id, d.particulars,a.customer_name,a.amount, a.plan, a.progress, a.problem,a.requisition,"x" from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
 $particulars = $_POST['particular'.$data->id];
 $customer_name = $_POST['customer_name'.$data->id];
 $amount=$_POST['amount'.$data->id];
 $plan=$_POST['plan'.$data->id];
 $progress=$_POST['progress'.$data->id];
 $problem=$_POST['problem'.$data->id];
 $requisition=$_POST['requisition'.$data->id];
  
   $update = 'update daily_progress_details set particular="'.$particulars.'",customer_name="'.$customer_name.'",amount="'.$amount.'",plan="'.$plan.'",progress="'.$progress.'",problem="'.$problem.'",requisition="'.$requisition.'" where id="'.$data->id.'"';
  db_query($update);
 }
 } elseif($_POST['progress_for']==31){
 $res='select a.id, a.address as project, a.customer_name as section, a.plan as action_plan, a.man_power as challenges, a.service_type as departmental_step,a.collection as qty, a.progress, a.gap_analysis as recommendation, a.findings as suggestion, a.next_visit as time_line, "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
 $address=$_POST['address'.$data->id];
 $customer_name = $_POST['customer_name'.$data->id];
 $plan=$_POST['plan'.$data->id];
 $man_power=$_POST['man_power'.$data->id];
 $service_type=$_POST['service_type'.$data->id];
 $collection=$_POST['collection'.$data->id];
 $progress=$_POST['progress'.$data->id];
 $gap_analysis=$_POST['gap_analysis'.$data->id];
 $findings=$_POST['findings'.$data->id];
 $next_visit=$_POST['next_visit'.$data->id];
  
   $update = 'update daily_progress_details set address="'.$address.'",customer_name="'.$customer_name.'",plan="'.$plan.'",man_power="'.$man_power.'",service_type="'.$service_type.'",collection="'.$collection.'",progress="'.$progress.'",gap_analysis="'.$gap_analysis.'",findings="'.$findings.'",next_visit="'.$next_visit.'" where id="'.$data->id.'"';
  db_query($update);
 }
 }elseif($_POST['progress_for']==53){
 $res='select a.id, a.day, a.customer_name, a.plan, a.man_power, a.progress, a.requisition , "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 
$d_id=$_POST['d_id'];
 $progress_date=$_POST['progress_date'];
 $progress_for=$_POST['progress_for'];
   $insert ='INSERT INTO `daily_progress_master`( `progress_for`, `progress_date`, `entry_by`,  `status`) 
 VALUES 
 ("'.$progress_for.'","'.$progress_date.'","'.$_SESSION['user']['id'].'","PENDING")';
 $ins=db_query($insert);
 $insert_id=db_insert_id(); 
 

 while($data=mysqli_fetch_object($qry)){
 $day = $_POST['day'.$data->id];
 $customer_name = $_POST['customer_name'.$data->id];
 $plan=$_POST['plan'.$data->id];
 $man_power=$_POST['man_power'.$data->id];
 $progress=$_POST['progress'.$data->id];
 $requisition=$_POST['requisition'.$data->id];
 $d_id=$_POST['d_id'];
 $progress_date=$_POST['progress_date'];
 $progress_for=$_POST['progress_for'];
  
   //$update = 'update daily_progress_details set date="'.$date.'",day="'.$day.'",customer_name="'.$customer_name.'",plan="'.$plan.'",man_power="'.$man_power.'",progress="'.$progress.'",requisition="'.$requisition.'" where id="'.$data->id.'"';
  //db_query($update);
  
 $insert ='INSERT INTO `daily_progress_details`( d_id, progress_date, day,  `customer_name`,`plan`, `man_power`, `progress`, `requisition`) 
  VALUES 
 ("'.$insert_id.'","'.$progress_date.'","'.$day.'","'.$customer_name.'","'.$plan.'","'.$man_power.'","'.$progress.'","'.$requisition.'")';
 db_query($insert);
 }
 } elseif($_POST['progress_for']==52){
 $res='select a.id, a.date, a.customer_name, a.man_power, a.plan, a.amount, a.collection, a.outstanding, a.category, a.pet_type "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
 $date = $_POST['date'.$data->id];
 $customer_name = $_POST['customer_name'.$data->id];
 $man_power=$_POST['man_power'.$data->id];
 $plan=$_POST['plan'.$data->id];
 $amount=$_POST['amount'.$data->id];
 $collection=$_POST['collection'.$data->id];
 $outstanding=$_POST['outstanding'.$data->id];
 $category=$_POST['category'.$data->id];
 $pet_type=$_POST['pet_type'.$data->id];
  
   $update = 'update daily_progress_details set date="'.$date.'",customer_name="'.$customer_name.'",man_power="'.$man_power.'",plan="'.$plan.'",amount="'.$amount.'",collection="'.$collection.'",outstanding="'.$outstanding.'",category="'.$category.'",pet_type="'.$pet_type.'" where id="'.$data->id.'"';
  db_query($update);
 }
 } elseif($_POST['progress_for']==3){
 $res='select a.id, d.particulars , a.particular,  a.plan, a.amount, a.progress, a.problem, "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
 $particulars = $_POST['particular'.$data->id];
 $customer_name = $_POST['plan'.$data->id];
 $amount=$_POST['amount'.$data->id];
 $plan=$_POST['progress'.$data->id];
 $progress=$_POST['problem'.$data->id];
  
   $update = 'update daily_progress_details set particular="'.$particulars.'",plan="'.$customer_name.'",amount="'.$amount.'",progress="'.$plan.'",problem="'.$progress.'" where id="'.$data->id.'"';
  db_query($update);
 }
 } elseif($_POST['progress_for']==5){
 $res='select a.id, d.particulars, a.particular,  a.customer_name, a.project_name, a.man_power,a.target, a.plan, a.progress, a.problem, a.requisition, "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
 $particulars = $_POST['particular'.$data->id];
 $customer_name = $_POST['customer_name'.$data->id];
 $amount=$_POST['project_name'.$data->id];
 $plan=$_POST['man_power'.$data->id];
 $target=$_POST['target'.$data->id];
 $plan=$_POST['plan'.$data->id];
 $progress=$_POST['progress'.$data->id];
 $problem=$_POST['problem'.$data->id];
 $requisition=$_POST['requisition'.$data->id];
  
   $update = 'update daily_progress_details set particular="'.$particulars.'",customer_name="'.$customer_name.'",project_name="'.$amount.'",man_power="'.$plan.'",target="'.$target.'",plan="'.$plan.'",progress="'.$progress.'",problem="'.$problem.'",requisition="'.$requisition.'" where id="'.$data->id.'"';
  db_query($update);
 }
 } elseif($_POST['progress_for']==4){
 $res='select a.id, a.date, a.customer_name, a.amount, a.problem, "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
 $particulars = $_POST['date'.$data->id];
 $amount=$_POST['customer_name'.$data->id];
 $progress=$_POST['amount'.$data->id];
 $gap_analysis=$_POST['problem'.$data->id];
  
   $update = 'update daily_progress_details set date="'.$particulars.'",customer_name="'.$amount.'",amount="'.$progress.'",problem="'.$gap_analysis.'" where id="'.$data->id.'"';
  db_query($update);
 }
 }  elseif($_POST['progress_for']==32){
 $res='select a.id, a.customer_name as Owner,a.address,a.man_power as Pet_name,a.pet_type,a.pet_category,a.service_type,a.mobile,a.email,a.next_visit,a.amount,a.findings as remarks, "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
 $Owner = $_POST['customer_name'.$data->id];
 $address = $_POST['address'.$data->id];
 $man_power=$_POST['man_power'.$data->id];
 $plan=$_POST['pet_type'.$data->id];
 $target=$_POST['pet_category'.$data->id];
 $progress=$_POST['service_type'.$data->id];
 $gap_analysis=$_POST['mobile'.$data->id];
 $email=$_POST['email'.$data->id];
 $next_visit=$_POST['next_visit'.$data->id];
 $amount=$_POST['amount'.$data->id];
 $remarks=$_POST['findings'.$data->id];
  
   $update = 'update daily_progress_details set customer_name="'.$Owner.'",address="'.$address.'",man_power="'.$man_power.'",pet_type="'.$plan.'",pet_category="'.$target.'",service_type="'.$progress.'",mobile="'.$gap_analysis.'",email="'.$email.'",next_visit="'.$next_visit.'",amount="'.$amount.'",findings="'.$remarks.'" where id="'.$data->id.'"';
  db_query($update);
 }
 }  elseif($_POST['progress_for']==55){
 $res='select a.id, a.date, a.day, a.customer_name as section, a.plan as action_plan, a.man_power as challenges,a.collection as qty, a.progress, a.gap_analysis as follow_up,  "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
 $date = $_POST['date'.$data->id];
 $day = $_POST['day'.$data->id];
 $customer_name = $_POST['customer_name'.$data->id];
 $plan=$_POST['plan'.$data->id];
 $man_power=$_POST['man_power'.$data->id];
 $collection=$_POST['collection'.$data->id];
 $progress=$_POST['progress'.$data->id];
 $gap_analysis=$_POST['gap_analysis'.$data->id];
  
   $update = 'update daily_progress_details set date="'.$date.'",day="'.$day.'",customer_name="'.$customer_name.'",plan="'.$plan.'",collection="'.$collection.'",man_power="'.$man_power.'",progress="'.$progress.'",gap_analysis="'.$gap_analysis.'" where id="'.$data->id.'"';
  db_query($update);
 }
 }  elseif($_POST['progress_for']==35){
 $res='select a.id, d.particulars, a.particular,  a.head_office, a.showroom, a.ld_hospital,a.factory, "x" from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
 $particulars = $_POST['particular'.$data->id];
 $customer_name = $_POST['head_office'.$data->id];
 $amount=$_POST['showroom'.$data->id];
 $plan=$_POST['ld_hospital'.$data->id];
 $target=$_POST['factory'.$data->id];
  
   $update = 'update daily_progress_details set particular="'.$particulars.'",head_office="'.$customer_name.'",showroom="'.$amount.'",ld_hospital="'.$plan.'",factory="'.$target.'" where id="'.$data->id.'"';
  db_query($update);
 }
 }  elseif($_POST['progress_for']==51){
 $res='select a.id, a.address as project, a.customer_name as section, a.plan as action_plan, a.man_power as challenges, a.service_type as departmental_step,a.collection as qty, a.progress, a.gap_analysis as recommendation, a.findings as suggestion, a.next_visit as time_line, "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
 $address=$_POST['address'.$data->id];
 $customer_name = $_POST['customer_name'.$data->id];
 $plan=$_POST['plan'.$data->id];
 $man_power=$_POST['man_power'.$data->id];
 $service_type=$_POST['service_type'.$data->id];
 $collection=$_POST['collection'.$data->id];
 $progress=$_POST['progress'.$data->id];
 $gap_analysis=$_POST['gap_analysis'.$data->id];
 $findings=$_POST['findings'.$data->id];
 $next_visit=$_POST['next_visit'.$data->id];
  
   $update = 'update daily_progress_details set address="'.$address.'",customer_name="'.$customer_name.'",plan="'.$plan.'",man_power="'.$man_power.'",service_type="'.$service_type.'",collection="'.$collection.'",progress="'.$progress.'",gap_analysis="'.$gap_analysis.'",findings="'.$findings.'",next_visit="'.$next_visit.'" where id="'.$data->id.'"';
  db_query($update);
 }
 }

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');
        
		$_POST['status']='PENDING';
		

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded for Approval.';
		header('Location:progress_po.php');

}



if(isset($_POST['add'])&&($_POST[$unique]>0))

{
	

		$crud   = new crud($table_details);

		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[1];

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->insert();

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

auto_complete_from_db('item_info i, item_brand b','concat(i.item_name,"#>",i.item_id,"#>",b.brand_name)','concat(item_name,"#>",item_id)','1 and i.item_brand=b.id','item_id');
//auto_complete_start_from_db('item_info i, item_brand b','concat(i.finish_goods_code,"#>",i.item_name,"#>",b.brand_name)','i.finish_goods_code','1 and i.item_brand=b.id','item');

?>

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
/////-=============-------========-------------Ajax  Voucher Entry---------------===================-------/////////


</script>

<div class="form-container_large">

<form action="" method="post" name="cloud" id="cloud" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<div class="row ">
	     <div class="col-md-3 form-group">
		 <? $field='d_id';?>
            <label for="d_id" >ID: </label>
           <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>
  </div>
		  
		 <div class="col-md-3 form-group">
		 <? $field='progress_date'; if($progress_date=='') $progress_date =date('Y-m-d');?>
        <div>
        <label for="<?=$field?>"> Date:</label>
        <input class="form-control" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=($$field!='')? $$field : date('Y-m-d');?>" readonly  required/>
       </div>
	   </div>
	   
	   <div class="col-md-3 form-group">
      <p>
        <? $field='progress_for';?>
        <label for="<?=$field?>">Progress For: </label>
	<select name="progress_for" id="progress_for" class="form-control">
	 <? foreign_relation('daily_progress_setup','id','type',$$field,'tr_from ="progress for"');?>
	</select>
	

      </p>
	  </div>
	   
		
	</div>
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <!--<form action="<?=$page?>" method="post" name="codz2" id="codz2" class="font-weight-bold">-->
  
  
         
		  </div>
    

  <tr>

    <td colspan="2"><div class="buttonrow text-center" ><span class="buttonrow" >

      <? if($_SESSION[$unique]>0) {?>
         <!-- <input name="new" type="submit" class="btn1" value="Update Sales Return" style="width:200px; font-weight:bold; font-size:12px; tabindex="12>-->
		  <button type="submit" name="new" id="new" class="btn btn-success">Update Information</button>
          <input name="flag2" id="flag2" type="hidden" value="1" />
          <? }else{?>
          <!--<input name="new" type="submit" class="btn1" value="Initiate Sales Return" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />-->
		  <button type="submit" name="new" id="new" class="btn btn-primary">Initiate Information</button>
          <input name="flag2" id="flag2" type="hidden" value="0" />
          <? }?>
        </span></div>
		
		</td>

    </tr>
    

</table>

<!--</form>-->

<? if($_SESSION[$unique]>0){?>

<!--<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="codz" id="codz">-->



<? 

$group_for = find_a_field('warehouse','group_for','warehouse_id='.$warehouse_id.' ');

if($progress_for=='1'){
?>

			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Name</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Section</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Action Plan</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Target Amount</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Challenges</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Follow Up</strong></td>

                          <!--<td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <input name="add" type="button" onclick="insert_item()" id="add" value="ADD" tabindex="12" class="update"/>
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>-->
      </tr>
<?
 $res='select a.id,  a.customer_name as name, a.address as section, a.pet_type as action_plan, a.delivery as target_amount, a.gap_analysis as challenges, a.collection as progress, a.next_visit as follow_up, "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
?>
                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>

<input name="customer_name<?=$data->id?>" type="text" class="input3" id="customer_name<?=$data->id?>" style="width:98%;"  value="<?=$data->name?>" /></td>
	
   
    <td width="25%"><input name="address<?=$data->id?>" type="text" class="input3" id="address<?=$data->id?>" style="width:98%;" value="<?=$data->section?>"  /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="pet_type<?=$data->id?>" type="text" class="input3" id="pet_type<?=$data->id?>"  maxlength="100" style="width:98%;" value="<?=$data->action_plan?>"  /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="delivery<?=$data->id?>" type="text" class="input3" id="delivery<?=$data->id?>" style="width:98%;" value="<?=$data->target_amount?>" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="gap_analysis<?=$data->id?>" type="text" class="input3" id="gap_analysis<?=$data->id?>" style="width:98%;" value="<?=$data->challenges?>" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="collection<?=$data->id?>" type="text" class="input3" id="collection<?=$data->id?>" style="width:98%;" value="<?=$data->progress?>" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="next_visit<?=$data->id?>" type="text" class="input3" id="next_visit<?=$data->id?>" style="width:98%;" value="<?=$data->follow_up?>" /></td>
      </tr>
	  <? } ?>
    </table>

<!--</form>-->

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">
<? //echo link_report_add_del_auto($res,'',4,7);?>
<div class="tabledesign2">
<span id="codzList">
<!--<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">-->
	
	<?php

  //$res='select a.id, a.date, a.day, a.customer_name, a.sales_order as "order", a.sales, a.delivery, a.gap_analysis, a.collection, a.outstanding, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	//echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>
<? } elseif($progress_for=='2'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Particulars</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Customer Name</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Plan</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Problem</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Requisition</strong></td>
                        <!--<td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">  
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div></td>-->
						 </tr>
						 
			<?
 $res='select a.id, d.particulars, a.particular,a.customer_name,a.amount, a.plan, a.progress, a.problem,a.requisition,"x" from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
?>
						
                      <tr>
					<td align="center" bgcolor="#CCCCCC">
					
					<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
					<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
					<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"   />
					<select name="particular<?=$data->id?>" id="particular<?=$data->id?>" style="width:98%;" value="<?=$particular?>" required>
						<? foreign_relation('daily_progress_setup','id','particulars',$data->particular,' tr_from ="particular scm" ');?>
					</select>
					</td>
	<td width="25%"><input name="customer_name<?=$data->id?>" type="text" class="input3" id="customer_name<?=$data->id?>" value="<?=$data->customer_name?>" style="width:98%;" readonly="readonly" /></td>
    <td><input name="amount<?=$data->id?>" type="text" class="input3" id="amount<?=$data->id?>" value="<?=$data->amount?>" style="width:98%;" readonly="readonly" /></td>
    
	<td align="center" bgcolor="#CCCCCC"><input name="plan<?=$data->id?>" type="text" class="input3" id="plan<?=$data->id?>"  maxlength="100" value="<?=$data->plan?>" style="width:98%;" readonly="readonly" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="progress<?=$data->id?>" type="text" class="input3" id="progress<?=$data->id?>" value="<?=$data->progress?>" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="problem<?=$data->id?>" type="text" class="input3" id="problem<?=$data->id?>" value="<?=$data->problem?>" style="width:98%;" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="requisition<?=$data->id?>" type="text" class="input3" id="requisition<?=$data->id?>" value="<?=$data->requisition?>" style="width:98%;" /></td>
      </tr>
    
	<? } ?>
</table>
<!--</form>-->

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">
<? //echo link_report_add_del_auto($res,'',4,7);?>
<div class="tabledesign2">
<span id="codzList">
<!--<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">-->
	
	<?php

 //$res='select a.id, d.particulars,a.customer_name,a.amount, a.plan, a.progress, a.problem,a.requisition,"x" from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id; 
	//echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>


<? } elseif($progress_for=='31'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="30%" align="center" bgcolor="#0099FF"><strong>Project</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Section</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Action Plan</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Amount/Qty</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Challenges</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Departmental Step</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Recommendation</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Suggestion</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Time Line</strong></td>

                          <!--<td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <input name="add" type="button" onclick="insert_item()" id="add" value="ADD" tabindex="12" class="update"/> 
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>-->
      </tr>
	  
	  
	<?
 $res='select a.id, a.address as project, a.customer_name as section, a.plan as action_plan, a.man_power as challenges, a.service_type as departmental_step,a.collection as qty, a.progress, a.gap_analysis as recommendation, a.findings as suggestion, a.next_visit as time_line, "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
?> 
	 

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>
<input name="address" type="text" class="input3" id="address" style="width:98%;" value="<?=$data->project?>" />
</td>
    <td width="25%"><input name="customer_name<?=$data->id?>" type="text" class="input3" id="customer_name<?=$data->id?>" style="width:98%;" value="<?=$data->section?>"  /></td>
    <td width="25%"><input name="plan<?=$data->id?>" type="text" class="input3" id="plan<?=$data->id?>" style="width:98%;" value="<?=$data->action_plan?>"  /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="collection<?=$data->id?>" type="text" class="input3" id="collection<?=$data->id?>"  maxlength="100" style="width:98%;" value="<?=$data->qty?>" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="man_power<?=$data->id?>" type="text" class="input3" id="man_power<?=$data->id?>"  maxlength="100" style="width:98%;" value="<?=$data->challenges?>" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="service_type<?=$data->id?>" type="text" class="input3" id="service_type<?=$data->id?>"  maxlength="100" style="width:98%;" value="<?=$data->departmental_step?>" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="progress<?=$data->id?>" type="text" class="input3" id="progress<?=$data->id?>" style="width:98%;" value="<?=$data->progress?>" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="gap_analysis<?=$data->id?>" type="text" class="input3" id="gap_analysis<?=$data->id?>" style="width:98%;" value="<?=$data->recommendation?>" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="findings<?=$data->id?>" type="text" class="input3" id="findings<?=$data->id?>" style="width:98%;" value="<?=$data->suggestion?>" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="next_visit<?=$data->id?>" type="text" class="input3" id="next_visit<?=$data->id?>" style="width:98%;" value="<?=$data->time_line?>" /></td>
      </tr>
	  <? } ?>
    </table>

<!--</form>-->

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">
<? //echo link_report_add_del_auto($res,'',4,7);?>
<div class="tabledesign2">
<span id="codzList">
<!--<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">-->
	
	<?php

  //$res='select a.id, a.date, a.day, a.customer_name, a.plan, a.man_power as Assigned, a.progress, a.gap_analysis, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	//echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>



<? }elseif($progress_for=='53'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Project Name</strong></td>
                        <td width="8%" align="center" bgcolor="#0099FF"><strong>Component</strong></td>
                        <td width="5%" align="center" bgcolor="#0099FF"><strong>Target %</strong></td>
                        <td width="5%" align="center" bgcolor="#0099FF"><strong>Achieved %</strong></td>
                        <td width="30%" align="center" bgcolor="#0099FF"><strong>Problem encountered</strong></td>
						<td width="30%" align="center" bgcolor="#0099FF"><strong>Corrective action</strong></td>

                          <!--<td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <input name="add" type="button" onclick="insert_item()" id="add" value="ADD" tabindex="12" class="update"/> 
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>-->
      </tr>
	  
	  
	<?
 $res='select a.id, a.day, a.customer_name, a.plan, a.man_power, a.progress,a.requisition , "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
?> 
	 

                      <tr>

<td width="15%">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>
<input name="day<?=$data->id?>" type="day" class="input3" id="day<?=$data->id?>" style="width:98%;" value="<?=$data->day?>" /></td>
	
    <td width="8%"><input name="customer_name<?=$data->id?>" type="text" class="input3" id="customer_name<?=$data->id?>" style="width:98%;" value="<?=$data->customer_name?>" /></td>
    <td width="8%"><input name="plan<?=$data->id?>" type="text" class="input3" id="plan<?=$data->id?>" style="width:98%;" value="<?=$data->plan?>" /></td>
	<td width="8%"><input name="man_power<?=$data->id?>" type="text" class="input3" id="man_power<?=$data->id?>"  maxlength="100" style="width:98%;" value="<?=$data->man_power?>" /></td>
	<td width="30%"><input name="progress<?=$data->id?>" type="text" class="input3" id="progress<?=$data->id?>" style="width:98%;" value="<?=$data->progress?>" /></td>
	<td width="30%"><input name="requisition<?=$data->id?>" type="text" class="input3" id="requisition<?=$data->id?>" style="width:98%;" value="<?=$data->requisition?>" /></td>
      </tr>
	  <? } ?>
    </table>

<!--</form>-->

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">
<? //echo link_report_add_del_auto($res,'',4,7);?>
<div class="tabledesign2">
<span id="codzList">
<!--<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">-->
	
	<?php

  //$res='select a.id, a.date, a.day, a.customer_name, a.plan, a.man_power as Assigned, a.progress, a.gap_analysis, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	//echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>



<? } elseif($progress_for=='52'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Date</strong></td>
                        <td width="25%" align="center" bgcolor="#0099FF"><strong>Customer Name</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Lot No</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Product Name</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Unit Price</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Production Target</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Production Achieved</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Delivery Target</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Delivery Achieved</strong></td>

                          <!--<td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <input name="add" type="button" onclick="insert_item()" id="add" value="ADD" tabindex="12" class="update"/> 
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>-->
      </tr>
	  
	  
	<?
 $res='select a.id, a.date, a.customer_name, a.man_power, a.plan, a.amount, a.collection, a.outstanding, a.category, a.pet_type, "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
?> 
	 

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>

<input  name="date<?=$data->id?>" type="text" id="date<?=$data->id?>" value="<?=$data->date?>" style="width:98%;" readonly="readonly"  /></td>
    <td width="25%"><input name="customer_name<?=$data->id?>" type="text" class="input3" id="customer_name<?=$data->id?>" style="width:98%;" value="<?=$data->customer_name?>" readonly="readonly" /></td>
    <td width="25%"><input name="man_power<?=$data->id?>" type="text" class="input3" id="man_power<?=$data->id?>" style="width:98%;" value="<?=$data->man_power?>" readonly="readonly" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="plan<?=$data->id?>" type="text" class="input3" id="plan<?=$data->id?>"  maxlength="100" style="width:98%;" value="<?=$data->plan?>" readonly="readonly" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="amount<?=$data->id?>" type="text" class="input3" id="amount<?=$data->id?>" style="width:98%;" value="<?=$data->amount?>" readonly="readonly" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="collection<?=$data->id?>" type="text" class="input3" id="collection<?=$data->id?>" style="width:98%;" value="<?=$data->collection?>" readonly="readonly" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="outstanding<?=$data->id?>" type="text" class="input3" id="outstanding<?=$data->id?>" style="width:98%;" value="<?=$data->outstanding?>" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="category<?=$data->id?>" type="text" class="input3" id="category<?=$data->id?>" style="width:98%;" value="<?=$data->category?>" readonly="readonly" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="pet_type<?=$data->id?>" type="text" class="input3" id="pet_type<?=$data->id?>" style="width:98%;" value="<?=$data->pet_type?>" /></td>
      </tr>
	  <? } ?>
    </table>

<!--</form>-->

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">
<? //echo link_report_add_del_auto($res,'',4,7);?>
<div class="tabledesign2">
<span id="codzList">
<!--<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">-->
	
	<?php

  //$res='select a.id, a.date, a.day, a.customer_name, a.plan, a.man_power as Assigned, a.progress, a.gap_analysis, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	//echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>



<? } elseif($progress_for=='51'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="30%" align="center" bgcolor="#0099FF"><strong>Project</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Section</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Action Plan</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Amount/Qty</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Challenges</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Departmental Step</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Recommendation</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Suggestion</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Time Line</strong></td>

                          <!--<td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <input name="add" type="button" onclick="insert_item()" id="add" value="ADD" tabindex="12" class="update"/> 
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>-->
      </tr>
	  
	  
	<?
 $res='select a.id, a.address as project, a.customer_name as section, a.plan as action_plan, a.man_power as challenges, a.service_type as departmental_step,a.collection as qty, a.progress, a.gap_analysis as recommendation, a.findings as suggestion, a.next_visit as time_line, "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
?> 
	 

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>
<input name="address" type="text" class="input3" id="address" style="width:98%;" value="<?=$data->project?>" />
</td>
    <td width="25%"><input name="customer_name<?=$data->id?>" type="text" class="input3" id="customer_name<?=$data->id?>" style="width:98%;" value="<?=$data->section?>"  /></td>
    <td width="25%"><input name="plan<?=$data->id?>" type="text" class="input3" id="plan<?=$data->id?>" style="width:98%;" value="<?=$data->action_plan?>"  /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="collection<?=$data->id?>" type="text" class="input3" id="collection<?=$data->id?>"  maxlength="100" style="width:98%;" value="<?=$data->qty?>" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="man_power<?=$data->id?>" type="text" class="input3" id="man_power<?=$data->id?>"  maxlength="100" style="width:98%;" value="<?=$data->challenges?>" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="service_type<?=$data->id?>" type="text" class="input3" id="service_type<?=$data->id?>"  maxlength="100" style="width:98%;" value="<?=$data->departmental_step?>" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="progress<?=$data->id?>" type="text" class="input3" id="progress<?=$data->id?>" style="width:98%;" value="<?=$data->progress?>" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="gap_analysis<?=$data->id?>" type="text" class="input3" id="gap_analysis<?=$data->id?>" style="width:98%;" value="<?=$data->recommendation?>" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="findings<?=$data->id?>" type="text" class="input3" id="findings<?=$data->id?>" style="width:98%;" value="<?=$data->suggestion?>" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="next_visit<?=$data->id?>" type="text" class="input3" id="next_visit<?=$data->id?>" style="width:98%;" value="<?=$data->time_line?>" /></td>
      </tr>
	  <? } ?>
    </table>

<!--</form>-->

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">
<? //echo link_report_add_del_auto($res,'',4,7);?>
<div class="tabledesign2">
<span id="codzList">
<!--<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">-->
	
	<?php

  //$res='select a.id, a.date, a.day, a.customer_name, a.plan, a.man_power as Assigned, a.progress, a.gap_analysis, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	//echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>



<? } elseif($progress_for=='32'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="30%" align="center" bgcolor="#0099FF"><strong>Owner</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Address</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Pet Name</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Pet Type</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Patient Category</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Service type</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Mobile</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Email</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Next Visit</strong></td>
						  <td width="11%" align="center" bgcolor="#0099FF"><strong>Total</strong></td>
						  <td width="11%" align="center" bgcolor="#0099FF"><strong>Remarks</strong></td>

                          <!--<td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <input name="add" type="button" onclick="insert_item()" id="add" value="ADD" tabindex="12" class="update"/>
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>-->
      </tr>
	  
	  
	 <?
 $res='select a.id, a.customer_name as Owner,a.address,a.man_power as Pet_name,a.pet_type,a.pet_category,a.service_type,a.mobile,a.email,a.next_visit,a.amount,a.findings as remarks, "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
?>
	  

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>

	   <input name="customer_name<?=$data->id?>" type="text" class="input3" id="customer_name<?=$data->id?>" style="width:98%;" value="<?=$data->Owner?>" /></td>
	<td width="25%"><input name="address<?=$data->id?>" type="text" class="input3" id="address<?=$data->id?>" style="width:98%;" value="<?=$data->address?>"  /></td>
    <td width="25%"><input name="man_power<?=$data->id?>" type="text" class="input3" id="man_power<?=$data->id?>" style="width:98%;" value="<?=$data->Pet_name?>"  /></td>
    <td width="25%"><input name="pet_type<?=$data->id?>" type="text" class="input3" id="pet_type<?=$data->id?>" style="width:98%;" value="<?=$data->pet_type?>" /></td>
    <td width="25%"><input name="pet_category<?=$data->id?>" type="text" class="input3" id="pet_category<?=$data->id?>" style="width:98%;" value="<?=$data->pet_category?>" /></td>
    <td width="25%"><input name="service_type<?=$data->id?>" type="text" class="input3" id="service_type<?=$data->id?>" style="width:98%;" value="<?=$data->service_type?>"  /></td>
    <td width="25%"><input name="mobile<?=$data->id?>" type="text" class="input3" id="mobile<?=$data->id?>" style="width:98%;" value="<?=$data->mobile?>"  /></td>
    <td width="25%"><input name="email<?=$data->id?>" type="text" class="input3" id="email<?=$data->id?>" style="width:98%;" value="<?=$data->email?>"  /></td>
    <td width="25%"><input name="next_visit<?=$data->id?>" type="text" class="input3" id="next_visit<?=$data->id?>" style="width:98%;" value="<?=$data->next_visit?>"  /></td>
    <td width="25%"><input name="amount<?=$data->id?>" type="text" class="input3" id="amount<?=$data->id?>" style="width:98%;" value="<?=$data->amount?>"  /></td>
    <td width="25%"><input name="findings<?=$data->id?>" type="text" class="input3" id="findings<?=$data->id?>" style="width:98%;" value="<?=$data->remarks?>"/></td>
	
      </tr>
	  <? } ?>
    </table>

<!--</form>-->

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">
<? //echo link_report_add_del_auto($res,'',4,7);?>
<div class="tabledesign2">
<span id="codzList">
<!--<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">-->
	
	<?php

  //$res='select a.id, a.customer_name as Owner,a.address,a.man_power as Pet_name,a.pet_type,a.pet_category,a.service_type,a.mobile,a.email,a.next_visit,a.amount,a.findings as remarks, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	//echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>


<? }elseif($progress_for=='3'){  ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Particulars</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Plan</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Problem</strong></td>
                        <!--<td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">  
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div></td>-->
						 </tr>
						 
			<?
 $res='select a.id, d.particulars , a.particular,  a.plan, a.amount, a.progress, a.problem, "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
?>	 
					
                      <tr>
					<td align="center" bgcolor="#CCCCCC">
					
					<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
					<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
					<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"   />
					<select name="particular<?=$data->id?>" id="particular<?=$data->id?>" style="width:98%;" required>
						<? foreign_relation('daily_progress_setup','id','particulars',$data->particular,' tr_from ="particular acc" ');?>
					</select>
					</td>
	<td align="center" bgcolor="#CCCCCC"><input name="plan<?=$data->id?>" type="text" class="input3" id="plan<?=$data->id?>"  maxlength="100" style="width:98%;" value="<?=$data->plan?>" readonly="readonly"  /></td>				
    <td width="25%"><input name="amount<?=$data->id?>" type="text" class="input3" id="amount<?=$data->id?>" style="width:98%;" value="<?=$data->amount?>" /></td>
	
	<td align="center" bgcolor="#CCCCCC"><input name="progress<?=$data->id?>" type="text" class="input3" id="progress<?=$data->id?>" style="width:98%;" value="<?=$data->progress?>" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="problem<?=$data->id?>" type="text" class="input3" id="problem<?=$data->id?>" style="width:98%;" value="<?=$data->problem?>" /></td>
      </tr>
	  <? } ?>
    </table>

<!--</form>-->

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">
<? //echo link_report_add_del_auto($res,'',4,7);?>
<div class="tabledesign2">
<span id="codzList">
<!--<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">-->
	
	<?php

    //$res='select a.id, d.particulars as particular,  a.plan, a.amount, a.progress, a.problem, "x" from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id; 
	//echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>
<? } elseif($progress_for=='4'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="30%" align="center" bgcolor="#0099FF"><strong>Date</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Customer Name</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Problem</strong></td>

                          <!--<td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <input name="add" type="button" onclick="insert_item()" id="add" value="ADD" tabindex="12" class="update"/> 
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>-->
      </tr>
	  
	  
	<?
 $res='select a.id, a.date, a.customer_name, a.amount, a.problem, "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
?> 
	 

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>

<input  name="date<?=$data->id?>" type="text" id="date<?=$data->id?>" value="<?=$data->date?>" style="width:98%;" readonly="readonly"  /></td>
    <td width="25%"><input name="customer_name<?=$data->id?>" type="text" class="input3" id="customer_name<?=$data->id?>" style="width:98%;" value="<?=$data->customer_name?>" readonly="readonly" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="amount<?=$data->id?>" type="text" class="input3" id="progress<?=$data->id?>" style="width:98%;" value="<?=$data->amount?>" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="problem<?=$data->id?>" type="text" class="input3" id="gap_analysis<?=$data->id?>" style="width:98%;" value="<?=$data->problem?>" /></td>
      </tr>
	  <? } ?>
    </table>

<!--</form>-->

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">
<? //echo link_report_add_del_auto($res,'',4,7);?>
<div class="tabledesign2">
<span id="codzList">
<!--<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">-->
	
	<?php

  //$res='select a.id, a.date, a.day, a.customer_name, a.plan, a.man_power as Assigned, a.progress, a.gap_analysis, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	//echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>


<? } elseif($progress_for=='55'){ ?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td width="30%" align="center" bgcolor="#0099FF"><strong>Date</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Day</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Section</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Action Plan</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Challenges</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Amount/Qty</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Follow up</strong></td>

                          <!--<td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <input name="add" type="button" onclick="insert_item()" id="add" value="ADD" tabindex="12" class="update"/> 
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div>				        </td>-->
      </tr>
	  
	  
	<?
 $res='select a.id, a.date, a.day, a.customer_name as section, a.plan as action_plan, a.man_power as challenges,a.collection as qty, a.progress, a.gap_analysis as follow_up,  "x" from daily_progress_details a where  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
?> 
	 

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"/>

<input  name="date<?=$data->id?>" type="text" id="date<?=$data->id?>" value="<?=$data->date?>" style="width:98%;" readonly="readonly"  /></td>
	<td width="25%"><input name="day<?=$data->id?>" type="day" class="input3" id="day<?=$data->id?>" style="width:98%;" value="<?=$data->day?>" readonly="readonly" /></td>
    <td width="25%"><input name="customer_name<?=$data->id?>" type="text" class="input3" id="customer_name<?=$data->id?>" style="width:98%;" value="<?=$data->section?>" readonly="readonly" /></td>
    <td width="25%"><input name="plan<?=$data->id?>" type="text" class="input3" id="plan<?=$data->id?>" style="width:98%;" value="<?=$data->action_plan?>" readonly="readonly" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="man_power<?=$data->id?>" type="text" class="input3" id="man_power<?=$data->id?>"  maxlength="100" style="width:98%;" value="<?=$data->challenges?>" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="collection<?=$data->id?>" type="text" class="input3" id="collection<?=$data->id?>"  maxlength="100" style="width:98%;" value="<?=$data->qty?>" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="progress<?=$data->id?>" type="text" class="input3" id="progress<?=$data->id?>" style="width:98%;" value="<?=$data->progress?>" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="gap_analysis<?=$data->id?>" type="text" class="input3" id="gap_analysis<?=$data->id?>" style="width:98%;" value="<?=$data->follow_up?>" /></td>
      </tr>
	  <? } ?>
    </table>

<!--</form>-->

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">
<? //echo link_report_add_del_auto($res,'',4,7);?>
<div class="tabledesign2">
<span id="codzList">
<!--<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">-->
	
	<?php

  //$res='select a.id, a.date, a.day, a.customer_name, a.plan, a.man_power as Assigned, a.progress, a.gap_analysis, "x" from daily_progress_details a where  a.d_id='.$d_id; 
	//echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>



<? } elseif($progress_for=='5'){?>
	<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Particulars</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Customers</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Project Name</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Man power</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Target</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Plan</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Progress</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Problem</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Requisition</strong></td>
                        <!--<td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">  
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div></td>-->
						 </tr>
						 
	<?
 $res='select a.id, d.particulars, a.particular,  a.customer_name, a.project_name, a.man_power,a.target, a.plan, a.progress, a.problem, a.requisition, "x" 
  from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
?>	
						 
						 
                      <tr>
					<td align="center" bgcolor="#CCCCCC">
					
					<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
					<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
					<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"   />
					<select name="particular<?=$data->id?>" id="particular<?=$data->id?>" style="width:98%;" required>
						<? foreign_relation('daily_progress_setup','id','particulars',$data->particular,' tr_from ="production" ');?>
					</select>
					</td>
					 <td width="25%"><input name="customer_name<?=$data->id?>" type="text" class="input3" id="customer_name<?=$data->id?>" style="width:98%;" value="<?=$data->customer_name?>" readonly="readonly" /></td>
					 <td width="25%"><input name="project_name<?=$data->id?>" type="text" class="input3" id="project_name<?=$data->id?>" style="width:98%;" value="<?=$data->project_name?>" readonly="readonly" /></td>
					 <td width="25%"><input name="man_power<?=$data->id?>" type="text" class="input3" id="man_power<?=$data->id?>" style="width:98%;" value="<?=$data->man_power?>"
					 readonly="readonly" /></td>
					 <td width="25%"><input name="target<?=$data->id?>" type="text" class="input3" id="target<?=$data->id?>" style="width:98%;" value="<?=$data->target?>" readonly="readonly" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="plan<?=$data->id?>" type="text" class="input3" id="plan<?=$data->id?>"  maxlength="100" style="width:98%;" value="<?=$data->plan?>" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="progress<?=$data->id?>" type="text" class="input3" id="progress<?=$data->id?>" style="width:98%;" value="<?=$data->progress?>" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="problem<?=$data->id?>" type="text" class="input3" id="problem<?=$data->id?>" style="width:98%;" value="<?=$data->problem?>" /></td>
	<td align="center" bgcolor="#CCCCCC"><input name="requisition<?=$data->id?>" type="text" class="input3" id="requisition<?=$data->id?>" style="width:98%;" value="<?=$data->requisition?>" /></td>
      </tr>
	  <? } ?>
    </table>

<!--</form>-->

<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">
<? //echo link_report_add_del_auto($res,'',4,7);?>
<div class="tabledesign2">
<span id="codzList">
<!--<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">-->
	
	<?php
	
	//$res='select a.id, d.particulars as particular,  a.customer_name, a.project_name, a.man_power,a.target, a.plan, a.progress, a.problem, a.requisition, "x" from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
  
    
	//echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>

<? } elseif($progress_for=='35'){?>
	<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Particulars</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>H/O</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Showroom</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>LD Hospital</strong></td>
						<td width="11%" align="center" bgcolor="#0099FF"><strong>Factory</strong></td>
                        <!--<td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">  
						  <input name="add" type="submit"  id="add" value="ADD" tabindex="12" class="update"/>                   
					    </div></td>-->
						 </tr>
						 
			<?
 $res='select a.id, d.particulars, a.particular,  a.head_office, a.showroom, a.ld_hospital,a.factory, "x" from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
 $qry = db_query($res);
 while($data=mysqli_fetch_object($qry)){
?>
						 
						 
                      <tr>
					<td align="center" bgcolor="#CCCCCC">
					
					<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
					<input  name="progress_for" type="hidden" id="progress_for" value="<?=$progress_for?>"/>
					<input  name="progress_date" type="hidden" id="progress_date" value="<?=$progress_date?>"   />
					<select name="particular<?=$data->id?>" id="particular<?=$data->id?>" style="width:98%;" required>
						<? foreign_relation('daily_progress_setup','id','particulars',$data->particular,' tr_from ="particular hr" ');?>
					</select>
					</td>
					 <td width="25%"><input name="head_office<?=$data->id?>" type="text" class="input3" id="head_office<?=$data->id?>" style="width:98%;" value="<?=$data->head_office?>" /></td>
					 <td width="25%"><input name="showroom<?=$data->id?>" type="text" class="input3" id="showroom<?=$data->id?>" style="width:98%;" value="<?=$data->showroom?>" /></td>
					 <td width="25%"><input name="ld_hospital<?=$data->id?>" type="text" class="input3" id="ld_hospital<?=$data->id?>" style="width:98%;" value="<?=$data->ld_hospital?>" /></td>
					 <td width="25%"><input name="factory<?=$data->id?>" type="text" class="input3" id="factory<?=$data->id?>" style="width:98%;" value="<?=$data->factory?>" /></td>
      </tr>
	  <? } ?>
    </table>



<br /><br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>

      <td>

<div class="tabledesign2">
  <span id="codzList">
<? //echo link_report_add_del_auto($res,'',4,7);?>
<div class="tabledesign2">
<span id="codzList">
<!--<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">-->
	
	<?php
	
	//$res='select a.id, d.particulars as particular,  a.head_office, a.showroom, a.ld_hospital,a.factory, "x" from daily_progress_details a,daily_progress_setup d where a.particular=d.id and  a.d_id='.$d_id;
  
    
	//echo link_report_add_del_auto($res,'',0,0);
?>
		
</span>
</div>

<? }?>
	
	
	
	
	
</td>

    </tr>

    <tr>

     <td>



 </td>

    </tr>

  </table>




  <table width="100%" border="0">

    <tr>

      <td align="center">



      <input name="delete"  type="submit" class="btn btn-danger" value="DELETE" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" />



      </td>

      <td align="center">

<input type="hidden" name="req_no"  value="<?=$req_no?>"/>
  <? $d_d=find_a_field('daily_progress_details','count(d_id)','d_id='.$d_id);
   if($d_d>0){
  ?>
      <input name="confirmm" type="submit" class="btn btn-info" value="CONFIRM" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white" />
  <? } ?>


      </td>

    </tr>

  </table>



<? }?>
</form>
</div>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>