<?php
session_start();
//
require "../../config/inc.all.php";

?>


<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->
          <div class="">
		  
		  
           
        <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?=$title?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  
				  	 <div class="openerp openerp_webclient_container">
                    <table class="oe_webclient">
                    <tbody>
   
                      <tr>
			
				  
				  
                  <div class="x_content">
				  
				  
<form action="../report/detail_report.php" target="_blank" method="post">
           <div class="oe_view_manager oe_view_manager_current">
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
                <div class="">
                  
                    <div  class="oe_view_manager_view_list">
                      <div  class="oe_list oe_view">
					  
  <table width="100%" class="oe_list_content"><thead><tr class="oe_list_header_columns">
  <th colspan="5">Staff Detail Information Selection</th>
  </tr>
  </thead><tfoot>
  </tfoot><tbody>
  <tr style="background-color:#1ABB9C;">
    <td colspan="5" style="text-align:center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="27%" valign="middle">&nbsp;</td>
        <td width="19%" valign="middle"><div align="right"><strong class="padding-top-10px">Staff Identification Number :</strong></div></td>
        <td width="29%"><strong>
          <input type="text" name="employee_selected" id="employee_selected"  class="form-control" placeholder="Type Staff Identification Number " />
        </strong></td>
        <td width="25%"><div align="left"></div></td>
      </tr>
    </table>      </td>
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

  <tr  ><td align="center"><input type="checkbox" checked="checked" name="point[]" id="point" value="2" /></td><td align="left"><strong>Guardian Information</strong></td>
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
  <tr  >
    <td align="center">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr  >
    <td align="center">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr  >
    <td align="center"><input type="checkbox" name="point[]" id="point" value="16" /></td>
    <td align="left"><strong>Family and Spouse Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="17" /></td>
    <td><strong>Child Information</strong></td>
  </tr>
  <tr  >
    <td align="center"><input type="checkbox" name="point[]" id="point" value="18" /></td>
    <td align="left"><strong>Brother and Sister Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="19" /></td>
    <td><strong>Reference Person</strong></td>
  </tr>
  <tr  >
    <td align="center"><input type="checkbox" name="point[]" id="point" value="20" /></td>
    <td align="left"><strong>Course/Diploma Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="21" /></td>
    <td><strong>Experience Information</strong></td>
  </tr>
  <tr  >
    <td align="center"><input type="checkbox" name="point[]" id="point" value="22" /></td>
    <td align="left"><strong>Leave Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="23" /></td>
    <td><strong>Training Information</strong></td>
  </tr>
    <tr  >
    <td align="center">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="25" /></td>
    <td><strong>Demotion Information</strong></td>
  </tr>
  <tr  >
    <td align="center"><input type="checkbox" name="point[]" id="point" value="26" /></td>
    <td align="left"><strong>Relative Information</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="27" /></td>
    <td><strong>Posting Information</strong></td>
  </tr>
    <tr  >
    <td align="center"><input type="checkbox" name="point[]" id="point" value="28" /></td>
    <td align="left"><strong>Financial Objection</strong></td>
    <td>&nbsp;</td>
    <td align="center"><input type="checkbox" name="point[]" id="point" value="29" /></td>
    <td><strong>Project Information</strong></td>
  </tr>
  </tbody></table><div style="text-align:center">
  <br /><br />
  <input name="submit" type="submit" id="submit" value="SHOW" class="btn btn-info" />
         
                      </div>
                    </div>
                
                </div>
                <div class="oe_chatter" style="padding:0px;">
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


</div>



 </tr>
         </tbody>
          </table> 
		   </div>
		   
		   
		   </div>
		    </div>
            </div>
			</div>
			</div>
			

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";

include_once("../../template/footer.php");
?>