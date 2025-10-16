<?php

//

//



//ini_set('display_errors', 1);

//ini_set('display_startup_errors', 1);

//error_reporting(E_ALL);



require "../../config/inc.all.php";



$title='Create Task';



$page = "project_budget.php";



$ajax_page = "project_budget_ajax.php";



$page_for = 'Project Budget';



do_calander('#wo_date');

do_calander('#wo_start_date');

do_calander('#wo_end_date');



$table_master='wo_master';



$table_details='wo_details';

$unique='wo_id';



if($_POST['wo_id']>0)

$$unique =$_POST[$unique] = $_SESSION[$unique];

elseif($_SESSION['wo_id']>0)

$$unique =$_POST[$unique]=$_SESSION[$unique];

elseif($_GET['wo_id']>0)

$$unique =$_POST[$unique]=$_SESSION[$unique];





if($_POST['customer'] !='')

$customer = $_POST['customer'];

$corporate_id=find_a_field('crm_customer_contacts','corporate_name','id='.$customer);



if(isset($_POST['new']))



{
		$crud   = new crud($table_master);

		if(!isset($_SESSION[$unique])) {

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['status']='Pending';

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');
		
		$$unique=$_SESSION[$unique]=$crud->insert();

		unset($$unique);

		$type=1;



		$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';

		

		 $_SESSION['details'] = "something";

         // test for invoice
	   
	   $time=date('Y-m-d h:s:i');
	   $sql="INSERT INTO `demo_invoice_master`(`wo_id`, `service_cat_id`, `invoice_name`, `invoice_date`, `customer`, `entry_by`, `entry_at`, `vat_rate`) 
		          values('".$_SESSION[$unique]."','".$_POST['service_cat_id']."','".$_POST['prj_id2']."','".$_POST['wo_date']."','".$_POST['customer']."','".$_SESSION['user']['id']."','".$time."','15')";
	   $query=db_query($sql);    
	   
	   //test
        $invoice_id=mysqli_insert_id($query);
		}



		else {

		$project_id=$_POST['project']=$_POST['prj_id'];

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);

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

		$crud   = new crud($table_details);

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

		$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$_GET['del']."'";

		db_query($sql);

		$type=1;

		$msg='Successfully Deleted.';


}





if($_GET['del_m_task']>0)



{



		$crud   = new crud('cons_budget_major_task');



		$condition="id=".$_GET['del_m_task'];		



		$crud->delete_all($condition);

		

		$sql = "delete from cons_budget_labour_details where major_task_id =".$_GET['bmid']." and budget_m_id=".$$unique;

		db_query($sql);

		$sql = "delete from wo_details where major_task_id =".$_GET['bmid']." and budget_m_id=".$$unique;

		db_query($sql);

		$sql = "delete from cons_budget_task_details where major_task_id =".$_GET['bmid']." and budget_m_id=".$$unique;

		db_query($sql);

		$type=1;

		$msg='Successfully Deleted.';


}
if(isset($_POST['confirm']))

{

unset($_SESSION['details']);

		unset($_POST);

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d H:s:i');

		$_POST['status']='PROCESSING';

		$crud   = new crud($table_master);

		$crud->update($unique_master);

		$crud   = new crud($table_detail);

		$crud->update($unique_master);

		unset($$unique_master);

		unset($_POST[$unique_master]);

		$type=1;

		$msg='Successfully Instructed to Depot.';

		echo '<script>window.location.href = "select_wo_project_new.php";</script>';

}



if(isset($_POST['confirmm']))



{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['status']='UNCHECKED';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded.';



}



if(isset($_POST['add1'])){ echo $_POST['cus_type']; echo $_POST['service_id'];
        //if($_POST['cus_type'] =='CORPORATE'){ echo 'hi';
//		echo $invoice_amt=find_a_field('crm_service_amount','invoice_amt','corporate_id="'.$corporate_id.'" and service_id='.$_POST['service_id']);
//        }else{ $invoice_amt=find_a_field('crm_service_amount','invoice_amt','customer_id="'.$customer.'" and service_id='.$_POST['service_id']);}
		
		//if($invoice_amt>0){
		$crud   = new crud('wo_details');
		
		 $inv_amt=(($_POST['qty']*$invoice_amt));
   
         $final_amt=($inv_amt+$_POST['govt_fee']);

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['status']='Pending';

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');
		
		$_POST['invoice_amt']=$final_amt;

		$xid = $crud->insert();
		
 
   
    $sql="INSERT INTO `demo_invoice_details`(`wo_id`,`invoice_id`, `service_cat_id`, `service_id`, `customer`, `qty`, `govt_fee`, `unit_price`, `amount`, `ll_id` ,`doc_name`)
		      values('".$$unique."','".$invoice_id."','".$service_cat_id."','".$_POST['service_id']."','".$_POST['customer']."','".$_POST['qty']."','".$_POST['govt_fee']."','".$_POST['unit_price']."','".$final_amt."','".$_POST['ll_id']."','".$_POST['doc_name']."') ";
			  
		$query=db_query($sql);

		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['oi_date'],0,$_POST['qty'],$page_for,$xid,$_POST['rate'],'',$$unique);
  

//$service_amt_vat=($service_amt*$inv_data->vat_rate)/100;		
//if($_POST['cus_type'] !='CORPORATE'){

//$customer_ledger=find_a_field('crm_customer_contacts','account_name','id='.$customer);
//
//$service_ledger=find_a_field('cons_project','acc_code','id='.$_POST['service_cat_id']);		
//
//$govt_fee_ledger=4014000100010001;	
//
//$vat_ledger=2015002500000000;	
//
//$jv_no = next_journal_voucher_id();
//
//$jv_date = strtotime($_POST['invoice_date']);
//
//$proj_id = 'pconnect';
//
//$tr_from = 'wo_sales';
//
//$narration = 'Invoice No-'.$_POST['wo_id'].' || C ID/LLID:'.$customer;
//
//add_to_sec_journal($proj_id, $jv_no, $jv_date, $customer_ledger, $narration, $final_amt, '0.00', $tr_from, $_POST['wo_id'],'','','',2);
//
//if($inv_amt>0) {
//
//add_to_sec_journal($proj_id, $jv_no, $jv_date, $service_ledger, $narration,  '0.00', $inv_amt, $tr_from, $_POST['wo_id'],'','','',2);}
//
////if($service_amt_vat>0) {
//
////add_to_sec_journal($proj_id, $jv_no, $jv_date, $vat_ledger, $narration,  '0.00', $service_amt_vat, $tr_from, $inv_data->invoice_id,'','','',2);}
//
//if($_POST['govt_fee']>0) {
//
//add_to_sec_journal($proj_id, $jv_no, $jv_date, $govt_fee_ledger, $narration,  '0.00', $_POST['govt_fee'], $tr_from, $_POST['wo_id'],'','','',2);}
//
//}

     

//}else{ echo "<strong style='color:red'>Please set invoice amount for this service from add service amount menu ...</strong>";}}

if($$unique>0)
{
		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}
}
if($$unique>0) $btn_name='Update Task Information'; else $btn_name='Initiate Task Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1','item_id');

?>

<script language="javascript">



function focuson(id) {



  if(document.getElementById('item_id').value=='')



  document.getElementById('item_id').focus();



  else



  document.getElementById(id).focus();



}



window.onload = function() {



if(document.getElementById("warehouse_id").value>0)



  document.getElementById("item_id").focus();



  else



  document.getElementById("req_date").focus();



}



</script>

<script language="javascript">



function count(id)



{



var num=((document.getElementById('task_qty'+id).value)*1)*((document.getElementById('length'+id).value)*1)*((document.getElementById('width'+id).value)*1)*((document.getElementById('thickness'+id).value)*1);



document.getElementById('total_volume'+id).value = num.toFixed(2);	



}



function count_mat(id)



{



var num=((document.getElementById('mat_total_volm'+id).value)*1)*((document.getElementById('mat_rate'+id).value)*1);



document.getElementById('mat_total_amnt'+id).value = num.toFixed(2);	



}



function count_lab(id)



{



var num=((document.getElementById('lab_amnt'+id).value)*1)*((document.getElementById('lab_rate'+id).value)*1);



document.getElementById('lab_total'+id).value = num.toFixed(2);	



}



</script>



<style type="text/css">

<!--

.style1 {

	color: #FFFFFF;

	font-weight: bold;

}



.sr{

margin-top: 20px;

margin-bottom: 20px;

}

.sr tr{

border: 1px solid black;

}

.sr td{

border: 1px solid black;

padding: 5px 2px;

}



.sr tr td a{

 color: red;

 text-align: center;

}

-->

</style>

	<div class="oe_view_manager oe_view_manager_current">

			

		<? include('../../common/title_bar.php');?>

			<div class="oe_view_manager_body">



					<div class="oe_view_manager_view_form">

                    <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">



			<div class="oe_form_container"><div class="oe_form">

			  <div class="">

		

	<div class="oe_form_sheetbg">

			<div class="oe_form_sheet oe_form_sheet_width">

	

			  <div  class="oe_view_manager_view_list">

              <div  class="oe_list oe_view">

  <form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <div class="" style="background: #EDFFEE; padding: 10px; color:black; font-size:14px; font-weight:bold">

    <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">

	

	  <tr>

	      <td style="">Workorder ID :</td>

		  <td><input type="text" name="wo_id" value="<?=$wo_id?>"/></td>

		  <td>customer Name :</td>

		  <td><input  name="customer" type="hidden" id="customer" value="<?=$customer?>" required/>

            <input  name="prj_id2" type="text" id="prj_id2" value="<?=find_a_field('crm_customer_contacts','fname','id='.$customer);?>" required/></td>
        <?php echo $cus_type=find_a_field('crm_customer_contacts','customer_type','id='.$customer);?>
	  </tr>

	  <tr style="">

	      <td>Workorder Date:</td>

		  <td><input type="text" name="wo_date" id="wo_date" value="<?=$wo_date?>" autocomplete="off"/></td>

		  <td>Supervisor :</td>

		  <td><input  name="sup_id" type="text" id="sup_id" value="<?=$sup_id;?>"/></td>

	  </tr>

	  <tr style="">

	      <td>Location:</td>

		  <td><select name="location_id">

              <? foreign_relation('cons_location','id','location',$location_id,'1 order by location asc');?>

            </select></td>

		  <td>Workorder Name :</td>

		  <td><input  name="wo_name" type="text" id="wo_name" value="<?=$wo_name?>" /></td>

	  </tr>

	 

	  </tr>

	 

	  <tr style="">

	      <td>Service Category ID:</td>

		  <td> <select name="service_cat_id" id="service_cat_id">

			  <option></option>

              <?

			   $qr = 'select p.id as service_cat_id,p.project_name from cons_project p,crm_customer_contacts c where p.id in (c.service1,c.service2,c.service3,c.service4,c.service5,c.service6,c.service7) and c.id="'.$customer.'"	';

				$ss = db_query($qr);

				while($c_data = mysqli_fetch_object($ss)){

			  ?>

			  

			  <option value="<?=$c_data->service_cat_id?>" <?=($service_cat_id == $c_data->service_cat_id)? 'Selected':' ' ?> ><?=$c_data->project_name?></option>

			    <? } ?>

			  

			 

            </select></td>

		  <td>Concern Govt Office </td>

		  <td><input  name="prj_id2" type="text" id="prj_id2" value="<?=$prj_id2;?>" required/></td></td>

	  </tr>

	   <tr style="">

	      <td>&nbsp;</td>

		  <td>&nbsp;</td>

		  <td>&nbsp;</td>

		  <td>&nbsp;</td>

	  </tr>

	  <tr style="" align="center">

	      <td colspan="3" align="center"><div align="center"> <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style=" background:#ff4542; width:250px; font-weight:bold; font-size:12px; margin-left:280px; color: white; padding: 5px;" /></div></td>

	  </tr>

	</table>

	</div>

    <? if($btn_name=='Update Task Information'){?>

    <? }?>

  </form>

  <br />

  <br />

  <? if($btn_name!='Initiate Task Information'){



?><br /><br />

  

   

  <? if($_SESSION['details']!=''){ ?>



  <div class="" style="background: #EDFFEE; padding: 10px; color:black; font-size:14px; font-weight:bold">

  <form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

  

  <? 

    if($service_cat_id == 2){

  ?>

  <span style=" margin-top: 20px; margin-bottom: 20px;">

    <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

      <tr bgcolor="#009999">

        <td colspan="9" align="center"  style="color:#FFFFFF;text-align:center;font-size:16px">Service Category Name : <?=find_a_field('cons_project','project_name','id='.$service_cat_id);?></td>

        

      </tr>

      <tr bgcolor="#009999">

        <td align="center" style="width:17%" >

		

		 <input type="hidden" name="wo_id" value="<?=$$unique;?>"  />

		<input type="hidden" name="customer" value="<?=$customer;?>"  />

		<input type="hidden" name="service_cat_id" id="service_cat_id" value="<?=$service_cat_id;?>"  />
		
		<input type="hidden" name="invoice_date" id="invoice_date" value="<?=$wo_date;?>"  />
		<input type="hidden" name="cus_type" id="cus_type" value="<?=$cus_type;?>"  />

		  

          <select name="service_id" id="service_id" style=" width:100px">

		  

            <option value="" disabled selected>Select Task Name</option>

            <? foreign_relation('cons_task','id','service_name',$service_id,'project_id=2 order by service_name asc');?>

          </select></td>

        

        <td width="20%" align="center" >

		<select  name="project_id" id="project_id" style="width:100%">

            <option value="" disabled selected>Select Project</option>

            <? foreign_relation('project_details','id','invoice_p_name',$project_id,' 1  order by invoice_p_name');?>

          </select>

		</td>
		
		 <td width="7%" align="center" >

		<select style="width:70px;" name="vendor">

            <option value="" disabled selected>Vendor</option>

            <? foreign_relation('crm_vendor_contacts','id','fname',$vendor,'1 order by fname asc');?>

          </select>

		</td>

        <td width="17%" align="center" >

		<select  name="incharge" style="width:100%">

            <option value="" disabled selected>Task Completed By</option>

            <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['employee'],'1 and PBI_JOB_STATUS="In Service" and PBI_DESIGNATION !=5 order by PBI_ID');?>

          </select>

		  

		  

		</td>
		
		

        <td width="6%" align="center" ><input  placeholder="Start Date" name="wo_start_date" type="text" class="input3" id="wo_start_date" style="width:72px;" autocomplete="off"/></td>

		

		<td width="6%" align="center" ><input autocomplete="off"  placeholder="End Date" name="wo_end_date" type="text" class="input3" id="wo_end_date" style="width:72px;"  autocomplete="off"/></td>

		

		<td align="center" ><input placeholder="Remarks"  name="details" type="text" class="input3" id="details" style="width:90px;"/></td>

        <td width="8%" align="center" ><input placeholder="Amount"  name="amount" type="text" class="input3" id="amount" style="width:90px;"/></td>

        <td width="9%" align="center" ><div class="button">

            <input name="add1" type="submit" id="add1" value="ADD" tabindex="5" class="update" style="width:102px;"/>

          </div></td>

      </tr>

    </table>

	</span>

	 <table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td><div class="tabledesign2 sr">

            <? 

     $res='SELECT d.id, t.service_name as task_name,(select invoice_p_name from project_details where id=d.project_id) as project_name,(select fname from crm_vendor_contacts where id=d.vendor) as Vendor,p.PBI_NAME as task_holder,d.wo_start_date as start_date,d.wo_end_date as expire_date,d.details,  d.amount, "X" from cons_task t , wo_details d, personnel_basic_info p where d.service_id=t.id and p.PBI_ID=d.incharge and  d.wo_id="'.$$unique.'"';



echo  link_report_add_del_auto($res,'',8,9);



?>

          </div></td>

      </tr>

    </table>
	
	<? }elseif($service_cat_id==5){?>
         
		 <span style=" margin-top: 20px; margin-bottom: 20px;">

    <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

      <tr bgcolor="#009999">

        <td colspan="12" align="center"  style="color:#FFFFFF;text-align:center;font-size:16px">Service Category Name : <?=find_a_field('cons_project','project_name','id='.$service_cat_id);?></td>

        

      </tr>

      <tr bgcolor="#009999">

        <td align="center" style="width:17%" >

		

		 <input type="hidden" name="wo_id" value="<?=$$unique;?>"  />

		<input type="hidden" name="customer" value="<?=$customer;?>"  />

		<input type="hidden" name="service_cat_id" id="service_cat_id" value="<?=$service_cat_id;?>"  />
		
		<input type="hidden" name="invoice_date" id="invoice_date" value="<?=$wo_date;?>"  />
		
		<input type="hidden" name="cus_type" id="cus_type" value="<?=$cus_type;?>"  />

		

          <select name="service_id" id="service_id" style=" width:100px">
            <option value="" disabled selected>Select Task Name</option>
            <? foreign_relation('cons_task','id','service_name',$service_id,'project_id=5 order by service_name asc');?>
          </select>
		  
		  </td>

        

        <td width="20%" align="center" >

		<select name="pro_type" id="pro_type">
		  <option value="" disabled selected>Select Promotion Type</option>
		  
		      <? foreign_relation('promotion_ad','id','promotion_name',$pro_type,'1 order by promotion_name asc');?>
		      
		  </select>

		</td>
		
		 <td width="17%" align="center" ><select name="advertiser" id="advertiser">
		         <option value="" disabled selected>Select Advertiser</option>
				 
		   <? foreign_relation('adverties_ad','id','advarties_name',$advertiser,'1 order by advarties_name asc');?>
		      
		  </select></td>

        <td width="17%" align="center" >

		<select  name="incharge" style="width:100%">

            <option value="" disabled selected>Task Completed By</option>

            <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['employee'],'1 and PBI_JOB_STATUS="In Service" and PBI_DESIGNATION !=5 order by PBI_ID');?>

          </select>

		  

		  

		</td>

        <td width="6%" align="center" ><input  placeholder="Publish Date" name="wo_start_date" type="date" class="input3" id="wo_start_date" style="width:72px;" autocomplete="off"/></td>

		

		<td width="6%" align="center" ><input autocomplete="off"  placeholder="Expire Date" name="wo_end_date" type="date" class="input3" id="wo_end_date" style="width:72px;" autocomplete="off"/></td>      
		
<td width="6%" align="center" ><input  placeholder="Voucher no" name="voucher_no" type="text" class="input3" id="voucher_no" style="width:72px;" autocomplete="off"/></td>

	
<td width="6%" align="center" ><input  placeholder="Cupon No" name="cupon_no" type="text" class="input3" id="cupon_no" style="width:72px;" autocomplete="off"/></td>

<td width="6%" align="center" ><input  placeholder="Project Name :PCL-S-1" name="project_name_in" type="text" class="input3" id="project_name_in" style="width:72px;" autocomplete="off"/></td>

		

		<td align="center" ><input placeholder="Remarks"  name="details" type="text" class="input3" id="details" style="width:90px;"/></td>

        <td width="8%" align="center" ><input placeholder="Amount"  name="amount" type="text" class="input3" id="amount" style="width:90px;"/></td>

        <td width="9%" align="center" ><div class="button">

            <input name="add1" type="submit" id="add1" value="ADD" tabindex="5" class="update" style="width:102px;"/>

          </div></td>

      </tr>

    </table>

	</span>

	 <table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td><div class="tabledesign2 sr">

            <? 

    $res='SELECT d.id, t.service_name as task_name,a.advarties_name,pr.promotion_name,p.PBI_NAME as task_holder,d.wo_start_date as start_date,d.wo_end_date as expire_date,d.details,  d.amount, "X" from cons_task t , wo_details d, personnel_basic_info p,adverties_ad a,promotion_ad pr where d.service_id=t.id and p.PBI_ID=d.incharge and pr.id=pro_type and a.id=advertiser and  d.wo_id="'.$$unique.'"';



echo  link_report_add_del_auto($res,'',8,9);



?>

          </div></td>

      </tr>

    </table>
	<? } else{?>

	 <span style=" margin-top: 20px; margin-bottom: 20px;">

	<table  width="96%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

      <tr bgcolor="#009999">

        <td colspan="13" align="center"  style="color:#FFFFFF;text-align:center;font-size:16px">Service Category Name : <?=find_a_field('cons_project','project_name','id='.$service_cat_id);?></td>

        

      </tr>

      <tr bgcolor="#009999">

        <td width="16%" align="center" >

		

		 <input type="hidden" name="wo_id" value="<?=$$unique;?>"  />

		<input type="hidden" name="customer" value="<?=$customer;?>"  />

		<input type="hidden" name="service_cat_id" id="service_cat_id" value="<?=$service_cat_id;?>"  />
		
		<input type="hidden" name="invoice_date" id="invoice_date" value="<?=$wo_date;?>"  />
		<input type="hidden" name="cus_type" id="cus_type" value="<?=$cus_type;?>"  />

		

          <select name="service_id" id="service_id" onchange="change_type()">

		  

            <option value="" style=" width:120px" disabled selected>Select Task Name</option>

            <? foreign_relation('cons_task','id','service_name',$service_id,'project_id='.$service_cat_id,'1 order by service_name asc');?>

          </select></td>

        

		<td width="7%" align="center" >

		<select style="width:70px;" name="doc_id">

            <option value="" disabled selected>Documents</option>

            <? foreign_relation('cons_document','id','doc_name',$doc_id,'doc_desc=12 order by doc_name asc');?>

          </select>

		</td>

		<td width="3%" align="center" ><input  placeholder="QTY" name="qty" type="text" class="input3" id="qty" style="width:10px;"/></td>

		

        <td width="7%" align="center" >

		<select style="width:70px;" name="vendor">

            <option value="" disabled selected>Vendor</option>

            <? foreign_relation('crm_vendor_contacts','id','fname',$vendor,'1 order by fname asc');?>

          </select>

		</td>

        <td width="9%" align="center" >

		<select style="width:100px;" name="incharge" required>

            <option value="" disabled selected>Completed By</option>

            <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$job_given_by,'PBI_JOB_STATUS="In Service" and PBI_DESIGNATION not in(2,5)');?>

          </select>

		  

		  

		</td>

        <td width="7%" align="center" ><input autocomplete="off"  placeholder="Start Date" name="wo_start_date" type="text" class="input3" id="wo_start_date" style="width:72px;"/></td>

		

		<td width="7%" align="center" ><input autocomplete="off" placeholder="End Date" name="wo_end_date" type="text" class="input3" id="wo_end_date" style="width:72px;" onchange="getData2('wo_ajax.php', 'leave',document.getElementById('wo_start_date').value,document.getElementById('wo_end_date').value)"/></td>

		

		<td width="5%"><input name="total_days" type="hidden" id="total_days"  value="" onfocus="focuson('total_days')" />

		<span style="color:#eeeeee;" id="leave"><? if($wo_start_date!=''){$diff = date_diff(date_create($wo_start_date),date_create($wo_end_date)); echo $diff->format("%a")+1;?></span>

                                          

                                          <? }?>

                                          &nbsp;&nbsp;<b id="total_leave">

                                          

										  

                            </b></td>

		<td width="10%" align="center" ><input placeholder="Govt.fee"  name="govt_fee" value="" id="govt_fee" type="text" class="input3" id="govt_fee" style="width:90px;" onkeyup="calculateRBN()"/></td>
		
		<td width="10%" align="center"  ><input placeholder="Miscellaneous Cost"  value="" name="msc_cost" id="msc_cost" type="text" class="input3" id="msc_cost" style="width:90px;" onkeyup="calculateRBN()"/></td>
		
        <td width="11%" align="center" ><input placeholder="Remarks"  name="details" type="text" class="input3" id="details" style="width:90px;"/></td>
		
        <td width="10%" align="center" ><input placeholder="Amount"  name="amount" type="text" class="input3" onkeyup="calculateRBN()" id="amount" value="" style="width:90px;"/></td>

        <td width="18%" align="center" ><div class="button">

            <input name="add1" type="submit" id="add1" value="ADD" tabindex="5" class="update" style="width:102px;"/>

          </div></td>

      </tr>

    </table>

	 </span>

	 

	  <table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td><div class="tabledesign2 sr">

            <? 

     $res='SELECT d.id, t.service_name as task_name,(SELECT doc_name from cons_document WHERE id=d.doc_id) as doc_name,(SELECT v.fname from crm_vendor_contacts v WHERE d.vendor=v.id) as vendor,d.qty,p.PBI_NAME as task_holder,d.wo_start_date as start_date,d.wo_end_date as expire_date,d.total_days,d.govt_fee,d.msc_cost as miscellaneous_cost,d.details as remarks,  d.amount, "X" from cons_task t , wo_details d, personnel_basic_info p where d.service_id=t.id and p.PBI_ID=d.incharge  and d.wo_id="'.$$unique.'"';



echo  link_report_add_del_auto($res,'',13,'');



?>

          </div></td>

      </tr>

    </table>

	<? } ?>

  

   

   

   

	

  </form> 

 

  <form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

    <table width="100%" border="0">

      <tr>

        <td align="center"><div align="center"></div></td>

        <td align="center"><div align="center">

            <input name="confirm" type="submit" class="btn1" value="CONFIRM AND FORWARD" style=" background:#00A4EF; width:250px; font-weight:bold; font-size:12px;  color: white; padding: 5px;" />

          </div></td>

      </tr>

    </table> 

  </form>

  

  <? }}?>

			  </div>

              </div>

			  </div>

		</div>

		

       </div>

      </div>

     </div>

    </div>

   </div>

  </div>

 </div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<script>


//auto calculation option for odc(msc and gov fee cost)


 function calculateRBN(){

var govt_fee = document.getElementById("govt_fee").value*1;

var msc_cost = document.getElementById("msc_cost").value*1;

//alert(govt_fee);

var amount = (document.getElementById("govt_fee").value*1)+(document.getElementById("msc_cost").value*1);

document.getElementById("amount").value = amount.toFixed(2);
}
window.onload = calculateRBN;
</script>

<?



//



//



require_once SERVER_CORE."routing/layout.bottom.php";



?>

