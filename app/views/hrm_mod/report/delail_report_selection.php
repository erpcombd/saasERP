<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Staff Detail Information Selection';

?>


<style>
  tr:nth-child(odd){
  background-color: white !important;
  }

  tr:nth-child(even){
    background-color: whitesmoke!important;
  }
</style>

<div class="form-container_large">

		<form  action="../report/detail_report.php" target="_blank" method="post">
			

			<div class="container-fluid pt-5 p-0 ">

				<h4 class="text-center bg-titel bold pt-2 pb-2">
					Staff Identification Number
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

   
						<td><input type="checkbox" checked="checked" name="point[]14" id="point[]13" value="1" /></td>
		
						<td align="left"> <label for="employee_selected">Basic and Essential Information</label></td>
						

						<td align="center" class="alt"><input type="checkbox" checked="checked" name="point[]" id="point" value="3" /></td>
						<td align="left"><label for="1">Education Information</label></td>

					</tr>

					<tr >

						<td align="center"><input type="checkbox" checked="checked" name="point[]2" id="point[]" value="4" /></td>

						<td align="left"><label for="2">Nominee  Information</label></td>

						<td align="center"><input type="checkbox" checked="checked" name="point[]3" id="point[]2" value="5" /></td>

						<td align="left"><label for="3">Transfer Information </label></td>

					</tr>

					<tr >

						
						<td align="center"><input type="checkbox" checked="checked" name="point[]4" id="point[]3" value="2" /></td>

						<td align="left"><label for="4">Guardian Information </label></td>

						<td align="center" class="alt"><input type="checkbox" checked="checked" name="point[]5" id="point[]4" value="6" /></td>

						<td align="left"><label for="5">Promotion Information</label></td>

					</tr>

					<tr >
							
							
						<td align="center" class="alt"><input type="checkbox" checked="checked" name="point[]6" id="point[]5" value="7" /></td>

						<td align="left"><label for="6">Increment Information</label></td>

						<td align="center" class="alt"><input type="checkbox" checked="checked" name="point[]7" id="point[]6" value="9" /></td>

						<td align="left"><label for="7"> ED Action  Information</label></td>

					</tr>

					<tr >

						<td align="center" class="alt"><input type="checkbox" checked="checked" name="point[]8" id="point[]7" value="8" /></td>

						<td align="left"><label for="8">Membership/Donor Information </label></td>

						<td align="center" class="alt"><input type="checkbox" checked="checked" name="point[]9" id="point[]8" value="11" /></td>

						<td align="left"><label for="9">Administrative Action Information</label></td>

					</tr>

					<tr>
					
				

						<td align="center" class="alt"><input type="checkbox" checked="checked" name="point[]10" id="point[]9" value="12" /></td>

						<td align="left"><label for="10"> Quarter/Dormitory/Hostel Information</label></td>

						<td align="center" class="alt"><input type="checkbox" checked="checked" name="point[]11" id="point[]10" value="13" /></td>

						<td align="left"><label for="11">APR Information</label></td>

					</tr>
					<tr>
						
						<td align="center" class="alt"><input type="checkbox" checked="checked" name="point[]12" id="point[]11" value="14" /></td>

						<td align="left"><label for="10"> Motor Cycle Information </label></td>

						<td align="center" class="alt"><input type="checkbox" checked="checked" name="point[]13" id="point[]12" value="15" /></td>

						<td align="left"><label for="11">Personal File Check List  Information</label></td>

					</tr>
					<tr>
			
						<td align="center" class="alt"><input type="checkbox" checked="checked" name="point[]15" id="point[]14" value="10" /></td>

						<td align="left"><label for="10"> Department Action Information</label></td>

						<td align="center" class="alt">&nbsp;</td>

						<td align="center"><label for="10"> &nbsp;</label></td>

					</tr>
					<tr>
			

						<td align="center" class="alt">&nbsp;</td>

						<td align="center"><label for="10"> &nbsp;</label></td>

						<td align="center" class="alt">&nbsp;</td>

						<td align="center"><label for="11">&nbsp;</label></td>

					</tr>
					<tr>
			
						<td align="center" class="alt"><input type="checkbox" name="point[]16" id="point[]15" value="16" /></td>

						<td align="left"><label for="10"> Family and Spouse Information </label></td>

						<td align="center" class="alt"><input type="checkbox" name="point[]17" id="point[]16" value="17" /></td>

						<td align="left"><label for="11">Child Information</label></td>

					</tr>
					<tr>
				

						<td align="center" class="alt"><input type="checkbox" name="point[]18" id="point[]17" value="18" /></td>

						<td align="left"><label for="10"> Brother and Sister Information</label></td>

						<td align="center" class="alt"><input type="checkbox" name="point[]19" id="point[]18" value="19" /></td>

						<td align="left"><label for="11">Reference Person</label></td>

					</tr>
					<tr>
					
		

						<td align="center" class="alt"><input type="checkbox" name="point[]20" id="point[]19" value="20" /></td>

						<td align="left"><label for="10"> Course/Diploma Information</label></td>

						<td align="center" class="alt"><input type="checkbox" name="point[]21" id="point[]20" value="21" /></td>

						<td align="left"><label for="11">Experience Information</label></td>

					</tr>
					<tr>
			

						<td align="center" class="alt"><input type="checkbox" name="point[]22" id="point[]21" value="22" /></td>

						<td align="left"><label for="10">Leave Information</label></td>

						<td align="center" class="alt"><input type="checkbox" name="point[]23" id="point[]22" value="23" /></td>

						<td align="left"><label for="11">Training Information</label></td>

					</tr>
					<tr>
					
			
						<td align="center" class="alt"><input type="checkbox" name="point[]26" id="point[]25" value="26" /></td>

						<td align="left"><label for="10"> Relative Information</label></td>

						<td align="center" class="alt"><input type="checkbox" name="point[]24" id="point[]23" value="25" /></td>

						<td align="left"><label for="11">Demotion Information </label></td>

					</tr>
					<tr>
					
			
						<td align="center" class="alt"><input type="checkbox" name="point[]27" id="point[]26" value="28" /></td>

						<td align="left"><label for="10"> Financial Objection</label></td>
						<td align="center" class="alt"><input name="JOB_STATUS" type="checkbox" id="JOB_STATUS" value="1" /></td>

						<td align="left"><label for="11">Job Status</label></td>
						

					</tr>
					
					</tbody>

				</table>


				<div class="n-form-btn-class">
					<input name="submit" type="submit" id="submit" class="btn1 btn1-bg-submit" value="SHOW" />
				</div>

			</div>

		</form>


	</div>



<?php /*?><form action="../report/detail_report.php" target="_blank" method="post">
<div class="oe_view_manager oe_view_manager_current">
        
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
<table width="100%" class="oe_list_content">

<thead>
<!--<tr class="oe_list_header_columns">
  <th colspan="5">Staff Detail Information Selection</th>
  </tr>-->
  
</thead>
<tfoot>
</tfoot><tbody>
  <tr style="background-color:#9999cc;">
    <td colspan="5" style="text-align:center"><strong>Staff Identification Number : 
      <label for="employee_selected"></label>
      <input type="text" name="employee_selected" id="employee_selected" />
    </strong></td>
    </tr>
  <tr>
    <td width="4%" align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="1" /></td>
    <td colspan="4" align="left"><strong>Basic and Essential Information</strong></td>
    </tr>
  <tr><td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="4" />
      </td>
<td width="44%" align="left"><strong>Nominee  Information</strong></td>
    <td width="4%">&nbsp;</td>
    <td width="4%" align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="3" /></td>
    <td width="44%"><strong>Education</strong> <strong>Information</strong></td>
    </tr>

  <tr  class="alt"><td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="2" /></td><td align="left"><strong>Guardian Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="5" /></td>
    <td><strong>Transfer Information</strong></td>
  </tr>
  <tr >
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="7" /></td>
    <td align="left"><strong> Increment Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="6" /></td>
    <td><strong>Promotion Information</strong></td>
  </tr>
  <tr >
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="8" /></td>
    <td align="left"><strong>Membership/Donor Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="9" /></td>
    <td><strong>ED Action  Information</strong></td>
  </tr>
  <tr >
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="10" /></td>
    <td align="left"><strong>Department Action  Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="11" /></td>
    <td><strong>Administrative Action  Information</strong></td>
  </tr>
  <tr >
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="12" /></td>
    <td align="left"><strong>Quarter/Dormitory/Hostel  Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="13" /></td>
    <td><strong>APR Information</strong></td>
  </tr>
  <tr >
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="14" /></td>
    <td align="left"><strong>Motor Cycle  Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="15" /></td>
    <td><strong>Personal File Check List  Information</strong></td>
  </tr>
  <tr  class="alt">
    <td align="center">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr  class="alt">
    <td align="center">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr  class="alt">
    <td align="center"><input type="checkbox" name="point[]" id="point" value="16" /></td>
    <td align="left"><strong>Family and Spouse Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="17" /></td>
    <td><strong>Child Information</strong></td>
  </tr>
  <tr  class="alt">
    <td align="center"><input type="checkbox" name="point[]" id="point" value="18" /></td>
    <td align="left"><strong>Brother and Sister Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="19" /></td>
    <td><strong>Reference Person</strong></td>
  </tr>
  <tr  class="alt">
    <td align="center"><input type="checkbox" name="point[]" id="point" value="20" /></td>
    <td align="left"><strong>Course/Diploma Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="21" /></td>
    <td><strong>Experience Information</strong></td>
  </tr>
  <tr  class="alt">
    <td align="center"><input type="checkbox" name="point[]" id="point" value="22" /></td>
    <td align="left"><strong>Leave Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="23" /></td>
    <td><strong>Training Information</strong></td>
  </tr>
    <tr  class="alt">
    <td align="center">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="25" /></td>
    <td><strong>Demotion Information</strong></td>
  </tr>
  <tr  class="alt">
    <td align="center"><input type="checkbox" name="point[]" id="point" value="26" /></td>
    <td align="left"><strong>Relative Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="27" /></td>
    <td><strong>Posting Information</strong></td>
  </tr>
    <tr  class="alt">
    <td align="center"><input type="checkbox" name="point[]" id="point" value="28" /></td>
    <td align="left"><strong>Financial Objection</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="29" /></td>
    <td><strong>Project Information</strong></td>
  </tr>
  </tbody></table><div style="text-align:center"><input name="submit" type="submit" id="submit" class="btn1 btn1-bg-submit" value="SHOW" />
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