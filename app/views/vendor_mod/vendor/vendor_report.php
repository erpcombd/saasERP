<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Advance Vendor Report'; 	

do_calander('#ijdb');

do_calander('#ijda');

do_calander('#ppjdb');

do_calander('#ppjda');
$user_to_vendor = find_a_field('user_activity_management','vendor_code','user_id="'.$_SESSION['user']['id'].'"');

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
						
						
						<? if ($vendor_id<1) {?>
										<select  name="vendor_id" id="vendor_id"  required>
											<? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id,'vendor_id="'.$user_to_vendor.'"');?>
										</select>

									<? }?>


									<? if ($dealer_code>0) {?>
										<select  id="vendor_id" name="vendor_id" class="form-control"  required >

											<? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id,'vendor_id="'.$user_to_vendor.'"');?>

										</select>

									<? }?>
						
						
                        </div>
                    </div>

                </div>
                <!--<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
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
                </div>-->

                

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






<?php /*?><div class="oe_view_manager oe_view_manager_current">

        

        <div class="oe_view_manager_body">

            

                <div  class="oe_view_manager_view_list"></div>

            

                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

        <div class="oe_form_buttons"></div>

        <div class="oe_form_sidebar"></div>

        <div class="oe_form_pager"></div>

        <div class="oe_form_container"><div class="oe_form">

          <div class="">

<div class="oe_form_sheetbg">

        <div class="oe_form_sheet oe_form_sheet_width">



          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">

<table width="100%" border="0" class="table table-bordered table-sm"><thead>



<tr class="oe_list_header_columns">

  <th colspan="4"><span style="text-align:center; font-size:16px; color:#C00">Select Options</span></th>

  </tr>

</thead><tfoot>

</tfoot><tbody>

  <tr>

    <td width="40%" align="right"><strong>Vendor :</strong></td>
<? create_combobox("vendor_id");?>
  <td width="10%" align="left"><select name="vendor_id" id="vendor_id" style="width:200px;">
  <option></option>
  <? foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],'1')?>
  </select></td>

  <td width="40%" align="right" class="alt"><strong>Vendor Type :</strong></td>

    <td width="10%"><span class="oe_form_group_cell">

      <select name="vendor_cat" style="width:160px;" id="vendor_cat">

          <option></option>

        <? foreign_relation('vendor_category','id','category_name',$vendor_cat, '1');?>

      </select></span></td>

  </tr>

  </tbody></table>

<div style="text-align:center">

<table width="100%" class="table table-bordered table-sm">

  <thead>

<tr class="oe_list_header_columns">

  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Columns</span></th>
  </tr>
  </thead>

  <tfoot>
  </tfoot>

  <tbody>

    <tr>

      <td align="center" class="alt"><input name="report" type="hidden" value="201" checked="checked" />

        <input name="vendor_name" type="checkbox" id="vendor_name" value="1" /></td>

      <td class="alt">Vendor Name</td>

      <td width="4%" align="center"><input name="beneficiary_name" type="checkbox" id="beneficiary_name" value="1" /></td>

      <td width="44%">Beneficiary Name</td>
      </tr>

    <tr>

      <td align="center"><span class="alt">

        <input name="vendor_company" type="checkbox" id="vendor_company" value="1" />

      </span></td>

      <td>Vendor Company</td>

      <td align="center" class="alt"><input name="beneficiary_bank" type="checkbox" id="beneficiary_bank" value="1" /></td>

      <td class="alt">Beneficiary Bank</td>
    </tr>

    <tr>

      <td width="4%" align="center"><input name="vendor_category" type="checkbox" id="vendor_category" value="1" /></td>

      <td width="44%">Vendor Category</td>

      <td align="center" class="alt"><input name="beneficiary_bank_ac" type="checkbox" id="beneficiary_bank_ac" value="1" /></td>

      <td class="alt">Account No</td>
    </tr>

    <tr >

      <td align="center" class="alt"><input name="contact_no" type="checkbox" id="contact_no" value="1" /></td>

      <td class="alt">Main Phone</td>

      <td align="center"><input name="swift_code" type="checkbox" id="swift_code" value="1" /></td>

      <td>Swift Code</td>
    </tr>

    <tr >

      <td align="center" class="alt"><input name="sms_mobile_no" type="checkbox" id="sms_mobile_no" value="1" /></td>

      <td class="alt">SMS Phone</td>

      <td align="center"><input name="contact_person_name" type="checkbox" id="contact_person_name" value="1" /></td>

      <td>Contact Person</td>
      </tr>

    <tr >

      <td align="center" class="alt"><input name="email" type="checkbox" id="v" value="1" /></td>

      <td class="alt">Main Email</td>

      <td align="center"><input name="contact_person_designation" type="checkbox" id="contact_person_designation" value="1" /></td>

      <td>Job Title</td>
      </tr>

    <tr >

      <td align="center"><input name="cc_email" type="checkbox" id="cc_email" value="1" /></td>

      <td>CC Email</td>

      <td align="center"><input name="fax_no" type="checkbox" id="fax_no" value="1" /></td>

      <td>Fax No</td>
    </tr>

    <tr >

      <td align="center"><input name="address" type="checkbox" id="address" value="1" /></td>

      <td>Address</td>

      <td align="center"><input name="contact_person_mobile" type="checkbox" id="contact_person_mobile" value="1" /></td>

      <td>Contact Person Phone</td>
    </tr>

    



<tr >

  <td align="center">&nbsp;</td>

  <td>&nbsp;</td>

  <td align="center">&nbsp;</td>

  <td>&nbsp;</td>
</tr>
  </tbody>
</table>

<input name="submit" type="submit" id="submit" class="btn1 btn1-bg-submit" value="SHOW" />

          </div></div></div>

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