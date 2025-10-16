<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section ::::: 
$title='Salary and Allowance Information';			// Page Name and Page Title
$page="salary_information.php";		// PHP File Name
$input_page="employee_essential_information_input.php";
$root='hrm';

$table='salary_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='basic_salary';				// For a New or Edit Data a must have data field


//do_calander('#ESSENTIAL_ISSUE_DATE');


// ::::: End Edit Section :::::


$crud      =new crud($table);


$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected'],' order by id desc limit 1');
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;


if(isset($_POST[$shown]))
{	if(isset($_POST['insert']))
		{		
				$_POST['PBI_ID']=$_SESSION['employee_selected'];
				$crud->insert();
				$type=1;
				$msg='New Entry Successfully Inserted.';
				unset($_POST);
				unset($$unique);
$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected'],' order by id desc limit 1');
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
		}
		
	//for Modify..................................
	if(isset($_POST['update']))
	{
				$crud->update($unique);
				$type=1;
	}
	//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
		$type=1;
		$msg='Successfully Deleted.';
}
}


if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
foreach($data as $key => $value)
{ $$key=$value;}
}



?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>
<script>
/*$(document).ready(function(){

   $('#mobile_allowance_rules').click(function(){

     var rBtnVal = $(this).val();

     if(rBtnVal == "Fixed"){
         $("#mobile_allowance").attr("readonly", false); 
     }
     else{ 
         $("#mobile_allowance").attr("readonly", true);
		 $("#mobile_allowance").val("0.00"); 
     }
   });
});*/




$(document).ready(function(){

   $('#vehicle_allowance_rules').click(function(){

     var rBtnVal = $(this).val();

     if(rBtnVal == "Fixed"){
         $("#vehicle_allowance").attr("readonly", false); 
     }
     else{ 
         $("#vehicle_allowance").attr("readonly", true); 
		 $("#vehicle_allowance").val("0.00");
     }
   });
});






function fixed_comm(){
     var rBtnVal = document.getElementById('commission_type').value;

     if(rBtnVal == "Conditional"){
         document.getElementById('view').style.display = 'block'; 
     }
     else{ 
         document.getElementById('view').style.display = 'none'; 
		 
		 
     }

}

</script>
<style>

label {font-weight: bold;
}
    </style>
<? do_calander('#security_amnt_till_date');
   //do_calander('#action_complete_date');?>
<form action="" method="post" enctype="multipart/form-data">
  <div class="oe_view_manager oe_view_manager_current">
    <? include('../common/title_bar.php'); do_calander('#comm_till_date');?>
    <div class="oe_view_manager_body">
      <div  class="oe_view_manager_view_list"></div>
      <div class="oe_view_manager_view_form">
        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
          <div class="oe_form_buttons"></div>
          <div class="oe_form_sidebar"></div>
          <div class="oe_form_pager"></div>
          <div class="oe_form_container">
            <div class="oe_form">
              <div class="">
                <? include('../common/input_bar.php');?>
                <div class="oe_form_sheetbg">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <h1>
                      <label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right"> <a href="home2.php" rel = "gb_page_center[940, 600]">
                      <?=$title?>
                      </a> </label>
                    </h1>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                      <tbody>
                        <tr class="oe_form_group_row">
                          <td class="oe_form_group_cell"><table width="100%" height="364" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
						  
                <div class="row ">
	         <div class="col-md-3 form-group">
            <label for="rcv_amt">Basic : </label>
            <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  
		  <div class="col-md-3 form-group">
            <label for="dealer_code">House Rent: </label>
           <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  
		  
		 <div class="col-md-3 form-group">
            <label for="wo_detail2">Madical Allowance: </label>
			 <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  
		  
		   <div class="col-md-3 form-group">
            <label for="wo_detail">Conveyance Allowance  : </label>
            <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  
		  
		  
		  
		    <div class="col-md-3 form-group">
            <label for="wo_detail">Food  Allowance : </label>
           <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  
		  
          <div class="col-md-3 form-group">
            <label for="depot_id">Mobile allowance : </label>
			 <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
            
            <!--<input style="width:155px;"  name="wo_detail" type="text" id="wo_detail" value="<?=$depot_id?>" readonly="readonly"/>-->
          </div>
		  
          <div class="col-md-3 form-group">
            <label for="rcv_amt">Entertainment Allowance: </label>
            <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  
		  
        <div class="col-md-3 form-group">
            <label for="remarks">Gross Salary : </label>
             <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  
		   <div class="col-md-3 form-group">
            <label for="remarks">PF(%): </label>
            <input name="remarks" type="text" id="remarks"  value="<?=$remarks?>" class="form-control"  tabindex="101"/>
          </div>
		  
		   <div class="col-md-3 form-group">
            <label for="remarks">Income Tax: </label>
            <input name="remarks" type="text" id="remarks"  value="<?=$remarks?>" class="form-control"  required/>
          </div>
		  
		   <div class="col-md-3 form-group">
            <label for="remarks">Salary Given by : </label>
            <input name="remarks" type="text" id="remarks"  value="<?=$remarks?>" class="form-control"  required/>
          </div> 
		  
		  <div class="col-md-3 form-group">
            <label for="remarks">Totale Payable: </label>
            <input name="remarks" type="text" id="remarks"  value="<?=$remarks?>" class="form-control"  required/>
          </div> 
		 
            <?
             ?>
            <input   name="wo_subject" type="text" class="form-control"  id="wo_subject" value="<? echo $av_amt=(find_a_field_sql('select sum(total_amt) from sale_do_details where   dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"')-find_a_field_sql('select sum(total_amt) from sale_do_chalan where    dealer_code='.$dealer->dealer_code.' and status!="COMPLETED"'))?>" readonly/>
          </div>
		  
		    
		  
   
                 </table></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="oe_chatter">
                  <div class="oe_followers oe_form_invisible">
                    <div class="oe_follower_list"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
 function pf_cal(){
  var basic = document.getElementById('basic_salary').value;
  var house = document.getElementById('house_rent').value;
  var conveyance = document.getElementById('ta').value;
  var medical = document.getElementById('medical_allowance').value;
  var food = document.getElementById('food_allowance').value;
  var entertainment = document.getElementById('entertainment').value;
  var mobile = document.getElementById('mobile_allowance').value;
  
  var gross = (+basic)+(+house)+(+conveyance)+(+medical)+(+food)+(+entertainment)+(+mobile);
  
  document.getElementById('gross_salary').value = gross;
  var mcpf = (gross*2)/100;
  var ecpf = (gross*5)/100;
  
  
  document.getElementById('pf').value = ecpf;

  var net_pay = gross-ecpf;
  document.getElementById('total_payable').value = net_pay;
  
  
  
 }
</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
























