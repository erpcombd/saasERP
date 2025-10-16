<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$tr_type="Show";
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Advance Vendor Report'; 	

do_calander('#ijdb');

do_calander('#ijda');

do_calander('#ppjdb');

do_calander('#ppjda');

$tr_from="Purchase";
?>









<form action="../vendor/master_report_complex.php" target="_blank" method="post">

	
	<div class="form-container_large">
	    <h4 class="text-center bg-titel bold pt-2 pb-2"> Select Options </h4>
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vendor :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <? create_combobox("vendor_id");?>
						<select name="vendor_id" id="vendor_id">
						  <option></option>
						  <? foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],'1')?>
						  </select>
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vendor Type :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <span class="oe_form_group_cell">

						  <select name="vendor_cat" id="vendor_cat">
					
							  <option></option>
					
							<? foreign_relation('vendor_category','id','category_name',$vendor_cat, '1');?>
					
						  </select></span>

                        </div>
                    </div>
                </div>

                

            </div>
        </div>



        <div class="container-fluid pt-5 p-0 ">




                <h4 class="text-center bg-titel bold pt-2 pb-2">
                    Select Columns
                </h4>

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
					<tr class="bgc-info">
						<th  width="5%"></th>
                        <th class="text-left"></th>

                        <th width="5%"></th>
                        <th class="text-left"></th>
					</tr>
                    </thead>
                    <tbody class="tbody1">

                        <tr>
                            <td>
                                <input name="report" type="hidden" value="201" checked="checked" />
                                <input name="vendor_name" type="checkbox" id="vendor_name" value="1" />
                            </td>
                            <td style="text-align:left">Vendor Name</td>

						    <td><input name="beneficiary_name" type="checkbox" id="beneficiary_name" value="1" /></td>
                            <td style="text-align:left">Beneficiary Name</td>
                        </tr>




					<tr>
					    <td>
						    <span class="alt">
						        <input name="vendor_company" type="checkbox" id="vendor_company" value="1" />
					        </span>
					    </td>
                        <td style="text-align:left">Vendor Company</td>

                        <td><input name="beneficiary_bank" type="checkbox" id="beneficiary_bank" value="1" /></td>
                        <td style="text-align:left">Beneficiary Bank</td>
					</tr>

					<tr>
						<td><input name="vendor_category" type="checkbox" id="vendor_category" value="1" /></td>
                        <td style="text-align:left">Vendor Category</td>

                        <td><input name="beneficiary_bank_ac" type="checkbox" id="beneficiary_bank_ac" value="1" /></td>
                        <td style="text-align:left">Account No</td>
					</tr>

					<tr>
						<td><input name="contact_no" type="checkbox" id="contact_no" value="1" /></td>
                        <td style="text-align:left">Main Phone</td>

                        <td><input name="swift_code" type="checkbox" id="swift_code" value="1" /></td>
                        <td style="text-align:left">Swift Code</td>
					</tr>

					<tr>
						<td><input name="sms_mobile_no" type="checkbox" id="sms_mobile_no" value="1" /></td>
                        <td style="text-align:left">SMS Phone</td>

                        <td><input name="contact_person_name" type="checkbox" id="contact_person_name" value="1" /></td>
                        <td style="text-align:left">Contact Person</td>
					</tr>

					<tr>
						<td><input name="email" type="checkbox" id="v" value="1" /></td>
                        <td style="text-align:left">Main Email</td>

                        <td><input name="contact_person_designation" type="checkbox" id="contact_person_designation" value="1" /></td>
                        <td style="text-align:left">Job Title</td>
					</tr>

					<tr>
						<td><input name="cc_email" type="checkbox" id="cc_email" value="1" /></td>
                        <td for="cc_email" style="text-align:left">CC Email</td>

                        <td><input name="fax_no" type="checkbox" id="fax_no" value="1" /></td>
                        <td style="text-align:left">Fax No</td>
					</tr>

					<tr>
						<td><input name="address" type="checkbox" id="address" value="1" /></td>
                        <td style="text-align:left">Address</td>

                        <td><input name="contact_person_mobile" type="checkbox" id="contact_person_mobile" value="1" /></td>
                        <td style="text-align:left">Contact Person Phone</td>
					</tr>
			<tr>
						<td><input name="vendor_credit_days" type="checkbox" id="vendor_credit_days" value="1" /></td>
                        <td style="text-align:left">Vendor Credit Days</td>
 
					</tr>

                    </tbody>
                </table>


				

        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">
				<input name="submit" type="submit" id="submit" class="btn1 btn1-bg-submit" value="SHOW" />
            </div>

        </div>


        </div>

    </div>
    </form>





<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>