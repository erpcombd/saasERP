<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





//Use this to search id

if(isset($_POST['button'])){

$pbi_new_code=find_a_field('personnel_basic_info','PBI_ID','PBI_CODE='.$_POST['employee_selected']);

$_SESSION['employee_selected'] = $pbi_new_code;

}





do_datatable('grp');

// ::::: Edit This Section ::::: 



$title='HR Action';			// Page Name and Page Title



$page="hr_action_new.php";		// PHP File Name



//$input_page="advance_payment.php";



$root='payroll';







$table='admin_action_detail_new';		// Database Table Name Mainly related to this page



$unique='id';			// Primary Key of this Database table



$shown='deduction_amt';				// For a New or Edit Data a must have data field







// ::::: End Edit Section :::::



// ::::: End Edit Section :::::


  
if($_POST['start_mon']!=''){

$start_mon=$_POST['start_mon'];}

else{

$start_mon=date('n');

}



if($_POST['start_year']!=''){

$start_year=$_POST['start_year'];}

else{

$start_year=date('Y');

}




$crud      =new crud($table);







$$unique = $_GET[$unique];



if(isset($_POST[$shown]))



{



	



$$unique = $_POST[$unique];







if(isset($_POST['insert'])||isset($_POST['insertn']))



{		



$now				= time();







$_POST['PBI_ID']=$_SESSION['employee_selected'];



for($i=0;$i<$_POST['total_installment'];$i++)



{



$smon=$_POST['start_mon']+$i;



$syear=$_POST['start_year'];



$_POST['current_mon'] = date('m',mktime(1,1,1,$smon,1,$syear));



$_POST['current_year'] = date('Y',mktime(1,1,1,$smon,1,$syear));



$_POST['installment_no'] = $i+1;



$crud->insert();



}







$type=1;



$msg='New Entry Successfully Inserted.';







unset($_POST);



unset($$unique);



}











//for Modify..................................







if(isset($_POST['update']))



{







		$crud->update($unique);



		$type=1;



		$msg='Successfully Updated.';







}



//for Delete..................................







if(isset($_POST['delete']))



{		$condition=$unique."=".$$unique;		$crud->delete($condition);



		unset($$unique);







		$type=1;



		$msg='Successfully Deleted.';



}



}







if(isset($$unique))



{



$condition=$unique."=".$$unique;



$data=db_fetch_object($table,$condition);



while (list($key, $value)=@each($data))



{ $$key=$value;}



}



if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);







$$unique = $_GET[$unique];







?>



<script type="text/javascript"> 

function DoNav(lk){



	document.location.href = '<?=$page?>?<?=$unique?>='+lk;



	}

	

function perMonAmount(){

var totlAmt=document.getElementById('deduction_amt').value;

var totInst=document.getElementById('total_installment').value;

var perMonth=totlAmt/totInst;

document.getElementById('payable_amt').value=perMonth;

}	

	</script>







      <form action="" method="post" enctype="multipart/form-data">  



    <? include('../common/title_bar.php');?>



    </form>



    <form action="" method="post" enctype="multipart/form-data">



    



    <? include('../common/input_bar.php');?>







		<form action="" method="post" name="codz" id="codz">
			<!--        top form start hear-->
			<div class="container-fluid bg-form-titel">
				<div class="row">
					<!--left form-->
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<div class="container n-form2">
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Deduction Amount</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<input name="deduction_amt" type="text" id="deduction_amt" value="<?=$deduction_amt?>" required />
								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Start Month</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="start_mon"  id="start_mon" required>



										<option value="1" <?=($start_mon=='1')?'selected':''?>>January</option>
								
								
								
										<option value="2" <?=($start_mon=='2')?'selected':''?>>February</option>
								
								
								
										<option value="3" <?=($start_mon=='3')?'selected':''?>>March</option>
								
								
								
										<option value="4" <?=($start_mon=='4')?'selected':''?>>April</option>
								
								
								
										<option value="5" <?=($start_mon=='5')?'selected':''?>>May</option>
								
								
								
										<option value="6" <?=($start_mon=='6')?'selected':''?>>June</option>
								
								
								
										<option value="7" <?=($start_mon=='7')?'selected':''?>>July</option>
								
								
								
										<option value="8" <?=($start_mon=='8')?'selected':''?>>August</option>
								
								
								
										<option value="9" <?=($start_mon=='9')?'selected':''?>>September</option>
								
								
								
										<option value="10" <?=($start_mon=='10')?'selected':''?>>October</option>
								
								
								
										<option value="11" <?=($start_mon=='11')?'selected':''?>>November</option>
								
								
								
										<option value="12" <?=($start_mon=='12')?'selected':''?>>December</option>
								
								
								
									  </select>
								</div>
							</div>
							<? if($$unique>0){?>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Current Month</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="current_mon"  id="current_mon" required>


								
										<option value="1" <?=($current_mon=='1')?'selected':''?>>January</option>
								
								
								
										<option value="2" <?=($current_mon=='2')?'selected':''?>>February</option>
								
								
								
										<option value="3" <?=($current_mon=='3')?'selected':''?>>March</option>
								
								
								
										<option value="4" <?=($current_mon=='4')?'selected':''?>>April</option>
								
								
								
										<option value="5" <?=($current_mon=='5')?'selected':''?>>May</option>
								
								
								
										<option value="6" <?=($current_mon=='6')?'selected':''?>>June</option>
								
								
								
										<option value="7" <?=($current_mon=='7')?'selected':''?>>July</option>
								
								
								
										<option value="8" <?=($current_mon=='8')?'selected':''?>>August</option>
								
								
								
										<option value="9" <?=($current_mon=='9')?'selected':''?>>September</option>
								
								
								
										<option value="10" <?=($current_mon=='10')?'selected':''?>>October</option>
								
								
								
										<option value="11" <?=($current_mon=='11')?'selected':''?>>November</option>
								
								
								
										<option value="12" <?=($current_mon=='12')?'selected':''?>>December</option>
								
								
								
									  </select>

								</div>
							</div>
							
							<? } ?>
							
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Action Remarks</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									
									<textarea name="deduction_remarks" id="deduction_remarks" ><?=$deduction_remarks?></textarea>
								</div>
							</div>

						</div>



					</div>

					<!--Right form-->
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<div class="container n-form2">
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Monthly Payable Amt</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<input name="payable_amt" type="text" id="payable_amt" value="<?=$payable_amt?>" required />
								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Total Install</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input name="total_installment" type="text" id="total_installment" value="<?=$total_installment?>" onkeyup="perMonAmount()" />
								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Start Year</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="start_year"  id="start_year" required>

										<? for($i=(date('Y')-1); $i<=(date('Y')+10); $i+=1){?>
										
										<option <?=($start_year==$i)?'selected':''?>><?=$i?></option>
										
										<? }?>
									
									</select>

								</div>
							</div>
							
							<? if($$unique>0){?>
							
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Current Year</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="current_year" style="width:160px;" id="current_year" required>
										
										<? for($i=(date('Y')-1); $i<=(date('Y')+10); $i+=1){?>
										
										<option <?=($start_year==$i)?'selected':''?>><?=$i?></option>
										
										<? }?>
									
									</select>

								</div>
							</div>
							
							<? } ?>
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Action Type</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="deduction_type" id="deduction_type" required>

									  <option <?=($deduction_type=='Monetary Punishment')?'selected':'';?>>Monetary Punishment</option>
									  <option <?=($deduction_type=='Non Monetary Punishment')?'selected':'';?>>Non Monetary Punishment</option>
									</select>

								</div>
							</div>

						</div>



					</div>


				</div>

				

			</div>

			<!--return Table design start-->
			
		</form>




<?php /*?><table class="table table-bordered table-sm " border="0" cellpadding="0" cellspacing="0">



              <tbody>



                <tr class="oe_form_group_row">



                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Deduction Amount :</strong></td>



                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="deduction_amt" type="text" id="deduction_amt" value="<?=$deduction_amt?>" required />



                    <input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />



                    <label for="textfield"></label>



                    <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" /></td>



                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Total Install :</strong></td>



                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="total_installment" type="text" id="total_installment" value="<?=$total_installment?>" onkeyup="perMonAmount()" /></td>



                </tr>



                <tr class="oe_form_group_row">



                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Start Month :</strong></td>



                  <td colspan="1" class="oe_form_group_cell">      <select name="start_mon"  id="start_mon" required>



        <option value="1" <?=($start_mon=='1')?'selected':''?>>Jan</option>



        <option value="2" <?=($start_mon=='2')?'selected':''?>>Feb</option>



        <option value="3" <?=($start_mon=='3')?'selected':''?>>Mar</option>



        <option value="4" <?=($start_mon=='4')?'selected':''?>>Apr</option>



        <option value="5" <?=($start_mon=='5')?'selected':''?>>May</option>



        <option value="6" <?=($start_mon=='6')?'selected':''?>>Jun</option>



        <option value="7" <?=($start_mon=='7')?'selected':''?>>Jul</option>



        <option value="8" <?=($start_mon=='8')?'selected':''?>>Aug</option>



        <option value="9" <?=($start_mon=='9')?'selected':''?>>Sep</option>



        <option value="10" <?=($start_mon=='10')?'selected':''?>>Oct</option>



        <option value="11" <?=($start_mon=='11')?'selected':''?>>Nov</option>



        <option value="12" <?=($start_mon=='12')?'selected':''?>>Dec</option>



      </select></td>



                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Start Year :</strong></td>



                  <td class="oe_form_group_cell">



<select name="start_year"  id="start_year" required>

<? for($i=(date('Y')-1); $i<=(date('Y')+10); $i+=1){?>

<option <?=($start_year==$i)?'selected':''?>><?=$i?></option>

<? }?>

</select>



                  </td>



                </tr>



<? if($$unique>0){?>



<tr class="oe_form_group_row">



<td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Current Month :</strong></td>



<td colspan="1" class="oe_form_group_cell">      <select name="current_mon" style="width:160px;" id="current_mon" required>



        <option value="1" <?=($current_mon=='1')?'selected':''?>>Jan</option>



        <option value="2" <?=($current_mon=='2')?'selected':''?>>Feb</option>



        <option value="3" <?=($current_mon=='3')?'selected':''?>>Mar</option>



        <option value="4" <?=($current_mon=='4')?'selected':''?>>Apr</option>



        <option value="5" <?=($current_mon=='5')?'selected':''?>>May</option>



        <option value="6" <?=($current_mon=='6')?'selected':''?>>Jun</option>



        <option value="7" <?=($current_mon=='7')?'selected':''?>>Jul</option>



        <option value="8" <?=($current_mon=='8')?'selected':''?>>Aug</option>



        <option value="9" <?=($current_mon=='9')?'selected':''?>>Sep</option>



        <option value="10" <?=($current_mon=='10')?'selected':''?>>Oct</option>



        <option value="11" <?=($current_mon=='11')?'selected':''?>>Nov</option>



        <option value="12" <?=($current_mon=='12')?'selected':''?>>Dec</option>



      </select></td>



<td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Current Year :</strong></td>



<td class="oe_form_group_cell">







<select name="current_year" style="width:160px;" id="current_year" required>

<? for($i=(date('Y')-1); $i<=(date('Y')+10); $i+=1){?>

<option <?=($start_year==$i)?'selected':''?>><?=$i?></option>

<? }?>

</select>







</td>



</tr>



<? }?>



                <tr class="oe_form_group_row">



                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Monthly Payable Amt :</strong></td>



                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="payable_amt" type="text" id="payable_amt" value="<?=$payable_amt?>" required /></td>



                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Action Type:</strong></td>



                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><label for="deduction_type"></label>



                    <select name="deduction_type" id="deduction_type" required>

                  <option <?=($deduction_type=='Monetary Punishment')?'selected':'';?>>Monetary Punishment</option>
				  <option <?=($deduction_type=='Non Monetary Punishment')?'selected':'';?>>Non Monetary Punishment</option>
                 </select></td>



                </tr>

				

				 <tr class="oe_form_group_row">



                  <td class="oe_form_group_cell"><strong>&nbsp;&nbsp;Action Remarks</strong></td>

				   <td colspan="3" class="oe_form_group_cell"><textarea name="deduction_remarks" id="deduction_remarks" style="width:93%;"><?=$deduction_remarks?></textarea></td>



                </tr>



                <tr class="oe_form_group_row">



                  <td colspan="4" class="oe_form_group_cell">&nbsp;</td>



                </tr>



                </tbody></table><?php */?>


          
		  
		  
		  
		  


    <form  action="" method="post" enctype="multipart/form-data">
        
        <div class="container-fluid pt-5 p-0 ">

            <? 	$res='select id, deduction_type,payable_amt, installment_no,concat(current_mon,"-",current_year) as payable_month,total_installment ,	 concat(start_mon,"-",start_year) as start_month,deduction_amt as total_deduction_amt  from '.$table.' where PBI_ID="'.$_SESSION['employee_selected'].'" order by id desc';



				echo link_report1($res,$link);?>

        </div>

    </form>      


<?php /*?><div class="oe_form_sheetbg">



        <div class="oe_form_sheet oe_form_sheet_width">







          <div  class="oe_view_manager_view_list">
		  <div  class="oe_list oe_view">



          



          </div></div>



          </div>



    </div><?php */?>



 



        </form>





<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>