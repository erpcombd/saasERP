<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

function auto_dropdown($sql){
$res=db_query($sql);
while($data=mysqli_fetch_row($res)){
if($value==$data[0])
echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
else
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}}

?>

<form action="../report/detail_report.php" target="_blank" method="post">
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
<table width="100%" class="oe_list_content"><thead><tr class="oe_list_header_columns">
  <th colspan="5">Staff Detail Information Selection</th>
  </tr>
</thead><tfoot>
</tfoot><tbody>
  <tr style="background-color:#9999cc;">
    <td colspan="5" style="text-align:center"><strong>Staff Identification Number : 
      <label for="employee_selected"></label>
      <select name="employee_selected" id="employee_selected" required="required">
        <option>
        <? if(isset($_POST['employee_selected'])){ echo $_POST['employee_selected']; }else{echo''; } ?>
        </option>
        <?php 
	auto_dropdown("select PBI_ID,concat(PBI_ID,'-',PBI_NAME) from personnel_basic_info 
	where PBI_ORG='".$_SESSION['user']['group']."' and PBI_JOB_STATUS='In Service' 
	and JOB_LOCATION not in(1,16,87)"); ?>
      </select>
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
    <td align="center"><input type="checkbox" name="point[]" id="point" value="5" /></td>
    <td><strong>Transfer Information</strong></td>
  </tr>
  <tr >
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="7" /></td>
    <td align="left"><strong> Increment Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox"  name="point[]" id="point" value="6" /></td>
    <td><strong>Promotion Information</strong></td>
  </tr>
  <tr >
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="8" /></td>
    <td align="left"><strong>Membership/Donor Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox"  name="point[]" id="point" value="9" /></td>
    <td><strong>ED Action  Information</strong></td>
  </tr>
  <tr >
    <td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="10" /></td>
    <td align="left"><strong>Department Action  Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="11" /></td>
    <td><strong>Administrative Action  Information</strong></td>
  </tr>
  <tr >
    <td align="center"><input type="checkbox" name="point[]" id="point" value="12" /></td>
    <td align="left"><strong>Quarter/Dormitory/Hostel  Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox"  name="point[]" id="point" value="13" /></td>
    <td><strong>APR Information</strong></td>
  </tr>
  <tr >
    <td align="center"><input type="checkbox" name="point[]" id="point" value="14" /></td>
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
  </tbody></table><div style="text-align:center"><input name="submit" type="submit" id="submit" value="SHOW" />
          </div></div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
    </div>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>