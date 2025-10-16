<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Personal File Check Status';			// Page Name and Page Title
$page="pf_status.php";		// PHP File Name
$input_page="pf_status_input.php";
$root='hrm';

$table='pf_status';		// Database Table Name Mainly related to this page
$unique='PF_STATUS_ID';			// Primary Key of this Database table
$shown='PF_STATUS_CV';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);


$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
if(isset($_POST[$shown]))
{	if(isset($_POST['insert']))
		{		
				$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];
				$crud->insert();
				$type=1;
				$msg='New Entry Successfully Inserted.';
				unset($_POST);
				unset($$unique);
$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
		}
	//for Modify..................................
	if(isset($_POST['update']))
	{
				$crud->update($unique);
				$type=1;
	}
}

if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}
?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>

<form action="" method="post" enctype="multipart/form-data">
<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
                      <? include('../../common/input_bar.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1><table width="801" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
            <tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell" width="100%">&nbsp;</td>
                </tr>
              </tbody>
            </table>            
              <table width="100%" height="184" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                <tbody>
                  <tr class="oe_form_group_row">
                    <td width="21%" height="24" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;CV :</td>
                    <td bgcolor="#E8E8E8" width="27%" colspan="1" class="oe_form_group_cell">
                    <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
					<input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />
                        <select name="PF_STATUS_CV" id="PF_STATUS_CV">
                         <option selected="selected"><?=$PF_STATUS_CV?></option>
                          <option>Yes</option>
                          <option>No</option>
                      </select></td>
                    <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> Medical Certificate :</span></td>
                    <td bgcolor="#E8E8E8" width="29%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                      <select name="EPF_STATUS_MC" id="EPF_STATUS_MC">
                        <option selected="selected"><?=$EPF_STATUS_MC?></option>
                        <option>Yes</option>
                        <option>No</option>
                      </select>
                    </span></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td height="22" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Appointment Letter :</label></td>
                    <td class="oe_form_group_cell"><select name="PF_STATUS_APPOINTMENT_LETTER" id="PF_STATUS_APPOINTMENT_LETTER">
                        <option selected="selected"><?=$PF_STATUS_APPOINTMENT_LETTER?> </option>
                        <option>Yes</option>
                        <option>No</option>
                    </select></td>
                    <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Security Money Receipt :</span></td>
                    <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                      <select name="PF_STATUS_SM_RECITE" id="PF_STATUS_SM_RECITE">
                        <option selected="selected"><?=$PF_STATUS_SM_RECITE?></option>
                        <option>Yes</option>
                        <option>No</option>
                      </select>
                    </span></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td height="22" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Joining Letter:</td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PF_STATUS_JOINING_LETTER" id="PF_STATUS_JOINING_LETTER">
                        <option selected="selected">
                        <?=$PF_STATUS_JOINING_LETTER?>
                        </option>
                        <option>Yes</option>
                        <option>No</option>
                    </select></td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> Received Aya Allowance :</span></td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                      <select name="PF_STATUS_R_AYA_A" id="PF_STATUS_R_AYA_A">
                        <option selected="selected">
                        <?=$PF_STATUS_R_AYA_A?>
                        </option>
                        <option>Yes</option>
                        <option>No</option>
                      </select>
                    </span></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td height="28" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Employee's Affidavit :</td>
                    <td class="oe_form_group_cell"><select name="PF_STATUS_E_AFFIDAVIT" id="PF_STATUS_E_AFFIDAVIT">
                        <option selected="selected">
                        <?=$PF_STATUS_E_AFFIDAVIT?>
                        </option>
                        <option>Yes</option>
                        <option>No</option>
                    </select></td>
                    <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Posting Letter :</span></td>
                    <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                      <select name="PF_STATUS_POSTING_LETTER" id="PF_STATUS_POSTING_LETTER">
                        <option selected="selected">
                        <?=$PF_STATUS_POSTING_LETTER?>
                        </option>
                        <option>Yes</option>
                        <option>No</option>
                      </select>
                    </span></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td height="22" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Affidavit of Guardian  :</td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="PF_STATUS_G_AFFIDAVIT" id="PF_STATUS_G_AFFIDAVIT">
                        <option selected="selected">
                        <?=$PF_STATUS_G_AFFIDAVIT?>
                        </option>
                        <option>Yes</option>
                        <option>No</option>
                    </select></td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Clearance Certificate :</span></td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                      <select name="PF_STATUS_C_CERTIFICATE" id="PF_STATUS_C_CERTIFICATE">
                        <option selected="selected">
                        <?=$PF_STATUS_C_CERTIFICATE?>
                        </option>
                        <option>Yes</option>
                        <option>No</option>
                      </select>
                    </span></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td height="22" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Guardian Certify Letter :</td>
                    <td class="oe_form_group_cell oe_form_group_cell_label"><select name="PF_STATUS_G_CERTIFY_LETTER" id="PF_STATUS_G_CERTIFY_LETTER">
                      <option selected="selected">
                        <?=$PF_STATUS_G_CERTIFY_LETTER?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                      </select></td>
                    <td class="oe_form_group_cell oe_form_group_cell_label"> Nominee :</td>
                    <td class="oe_form_group_cell oe_form_group_cell_label"><select name="PF_STATUS_NOMINEE" id="PF_STATUS_NOMINEE">
                      <option selected="selected">
                        <?=$PF_STATUS_NOMINEE?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                      </select></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td height="22" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Guardian's Photo :</td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><select name="PF_STATUS_G_PHOTO" id="PF_STATUS_G_PHOTO">
                      <option selected="selected">
                        <?=$PF_STATUS_G_PHOTO?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                      </select></td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Nominee Photo :</td>
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><select name="PF_STATUS_NOMINEE_PHOTO" id="PF_STATUS_NOMINEE_PHOTO">
                      <option selected="selected">
                        <?=$PF_STATUS_NOMINEE_PHOTO?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                      </select></td>
                  </tr>
                  <tr class="oe_form_group_row">
                    <td height="22" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Received Certificate :</td>
                    <td bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label"><select name="RECEIVED_CERTIFICATE" id="RECEIVED_CERTIFICATE">
                      <option selected="selected">
                        <?=$RECEIVED_CERTIFICATE?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                    </select></td>
                    <td bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label">Employee Varification Form :</td>
                    <td bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label"><select name="EMPLOYEE_VARIFICATION_FORM" id="EMPLOYEE_VARIFICATION_FORM">
                      <option selected="selected">
                        <?=$EMPLOYEE_VARIFICATION_FORM?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                    </select></td>
                  </tr>
                </tbody>
              </table></td>
            </tr></tbody></table>
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
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>