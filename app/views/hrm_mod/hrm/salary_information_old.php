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
$shown='salary_type';				// For a New or Edit Data a must have data field


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






<form action="" method="post" enctype="multipart/form-data">
    <div class="form-container_large">
		 <? include('../common/title_bar.php'); do_calander('#comm_till_date');?>
		 <? include('../common/input_bar.php');?>
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1>
		    <div class="container-fluid bg-form-titel">
		
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
       
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Salary Type :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                          <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />
                            <select name="salary_type">
                            <option><?=$salary_type?></option>
                              <option>Consolidated</option>
                              <option>Non-Consolidated</option>
                              </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Basic :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="basic_salary" type="text" id="basic_salary" value="<?=$basic_salary?>" />
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Consolidated Salary :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="consolidated_salary" type="text" id="consolidated_salary" value="<?=$consolidated_salary?>" />
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">House Rent :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="house_rent" type="text" id="house_rent" value="<?=$house_rent?>" />
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Special Allowance :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="special_allowance" type="text" id="special_allowance" value="<?=$special_allowance?>" />
                            </div>
                      </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">TA :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                               <input name="ta" type="text" id="ta" value="<?=$ta?>" />
                            </div>
                      </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">DA :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="da" type="text" id="da" value="<?=$da?>" />
                            </div>
                      </div>
					  <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Others :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="others" type="text" id="others" value="<?=$others?>" />
                            </div>
                      </div>
					  
					  <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Food Allowance :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="food_allowance" type="text" id="food_allowance" value="<?=$food_allowance?>" />
                            </div>
                      </div>
					  
					  <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Mobile Allowance :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="mobile_allowance" type="text" id="mobile_allowance" value="<?=$mobile_allowance?>" />
                            </div>
                      </div>
					  
					  <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Medical Allowance :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="medical_allowance" type="text" id="medical_allowance" value="<?=$medical_allowance?>" />
                            </div>
                      </div>
						




                    </div>
                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                       

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bonus Applicable? :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="bonus_applicable">
                            <option selected="selected">
                              <?=$bonus_applicable?>
                              </option>
                            <option>YES</option>
                            <option>NO</option>
                          </select>
                            </div>
                      </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Overtime Applicable?</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="overtime_applicable">
                            <option selected="selected">
                              <?=$overtime_applicable?>
                              </option>
                            <option>YES</option>
                            <option>NO</option>
                          </select>
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PF :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="pf" type="text" id="pf" value="<?=$pf?>" />
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Income Tax :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                 <input name="income_tax" type="text" id="income_tax" value="<?=$income_tax?>" />
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Group Insurance :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="group_insurance" type="text" id="group_insurance" value="<?=$group_insurance?>" />
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">C/Fund :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="cfund" type="text" id="cfund" value="<?=$cfund?>" />                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cash/Bank :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="cash_bank" type="text" id="cash_bank" value="<?=$cash_bank?>" />
                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cash :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="cash">
                            <option selected="selected">
                              <?=$cash?>
                              </option>
                            <option>Cash</option>
                            <option>Bank</option>
                          </select>
                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Security Amount :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="security_amount" type="text" id="security_amount" value="<?=$security_amount?>" />
                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Mobile Ceiling :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input name="mobile_ceiling" type="text" id="mobile_ceiling" value="<?=$mobile_ceiling?>" />
                            </div>
                        </div>





                    </div>
                </div>


            </div>

        </div>
		

        
    </div>

</form>











<?php /*?><form action="" method="post" enctype="multipart/form-data">
<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
                      <? include('../common/input_bar.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1><table width="987" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
            <tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="858" height="364" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
                  <td class="oe_form_group_cell"><table width="100%" height="279" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                    <tbody>
                        <tr class="oe_form_group_row">
                          <td width="33%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Salary Type :</label></td>
                          <td width="33%" class="oe_form_group_cell">
                          <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                          <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />
                            <select name="salary_type">
                            <option><?=$salary_type?></option>
                              <option>Consolidated</option>
                              <option>Non-Consolidated</option>
                              </select></td>
                          <td width="34%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Bonus Applicable? :</span></td>
                          <td width="67%" class="oe_form_group_cell"><select name="bonus_applicable">
                            <option selected="selected">
                              <?=$bonus_applicable?>
                              </option>
                            <option>YES</option>
                            <option>NO</option>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Basic : </td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell">
                          <input name="basic_salary" type="text" id="basic_salary" value="<?=$basic_salary?>" /></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Overtime Applicable? :</span></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="overtime_applicable">
                            <option selected="selected">
                              <?=$overtime_applicable?>
                              </option>
                            <option>YES</option>
                            <option>NO</option>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Consolidated Salary :</td>
                          <td class="oe_form_group_cell"><input name="consolidated_salary" type="text" id="consolidated_salary" value="<?=$consolidated_salary?>" /></td>
                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">PF :</span></td>
                          <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                            <input name="pf" type="text" id="pf" value="<?=$pf?>" />
                          </span></td>
                        </tr>
                       <tr class="oe_form_group_row">
                        <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;House Rent :</td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="house_rent" type="text" id="house_rent" value="<?=$house_rent?>" /></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Income Tax :</span></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="income_tax" type="text" id="income_tax" value="<?=$income_tax?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Special Allowance :</td>
                          <td class="oe_form_group_cell"><input name="special_allowance" type="text" id="special_allowance" value="<?=$special_allowance?>" /></td>
                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Group Insurance :</span></td>
                          <td class="oe_form_group_cell"><input name="group_insurance" type="text" id="group_insurance" value="<?=$group_insurance?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;&nbsp;TA :</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="ta" type="text" id="ta" value="<?=$ta?>" /></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">C/Fund : </span></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="cfund" type="text" id="cfund" value="<?=$cfund?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;DA :</td>
                          <td class="oe_form_group_cell">
  <input name="da" type="text" id="da" value="<?=$da?>" />
                            </td>
                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> Cash/Bank :</span></td>
                          <td class="oe_form_group_cell"><input name="cash_bank" type="text" id="cash_bank" value="<?=$cash_bank?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Others :</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="others" type="text" id="others" value="<?=$others?>" /></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell">Cash :</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="cash">
                            <option selected="selected">
                              <?=$cash?>
                              </option>
                            <option>Cash</option>
                            <option>Bank</option>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Food Allowance :</td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="food_allowance" type="text" id="food_allowance" value="<?=$food_allowance?>" /></td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell">Security Amount :</td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="security_amount" type="text" id="security_amount" value="<?=$security_amount?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Mobile Allowance :</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="mobile_allowance" type="text" id="mobile_allowance" value="<?=$mobile_allowance?>" /></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Medical Allowance :</td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="medical_allowance" type="text" id="medical_allowance" value="<?=$medical_allowance?>" /></td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;</td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Mobile Ceiling :</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="mobile_ceiling" type="text" id="mobile_ceiling" value="<?=$mobile_ceiling?>" /></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                        </tr>
                      </tbody>
                  </table></td>
                  </tr>
              </tbody>
            </table>            </td>
            </tr></tbody></table>
                        </div>
                      </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
    </div>
</form><?php */?>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>