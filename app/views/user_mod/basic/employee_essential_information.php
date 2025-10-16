<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Employee Essential Information';			// Page Name and Page Title
$page="employee_essential_information.php";		// PHP File Name
$input_page="employee_essential_information_input.php";
$root='hrm';

$table='essential_info';		// Database Table Name Mainly related to this page
$unique='ESSENTIAL_ID';			// Primary Key of this Database table
$shown='ESSENTIAL_BANK_NAME';				// For a New or Edit Data a must have data field


do_calander('#ESSENTIAL_ISSUE_DATE');


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
          </h1><table width="987" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
            <tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="858" height="364" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
                  <td class="oe_form_group_cell"><table width="100%" height="279" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                    <tbody>
                        <tr class="oe_form_group_row">
                          <td width="33%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Bank Name :</label></td>
                          <td width="33%" class="oe_form_group_cell">
                          <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                          <input name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" type="hidden" />
                            <select name="ESSENTIAL_BANK_NAME">
                              <? foreign_relation('bank','BANK_NAME','BANK_NAME',$ESSENTIAL_BANK_NAME);?>
                              </select></td>
                          <td width="34%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Bank List :</span></td>
                          <td width="67%" class="oe_form_group_cell"><input name="bank" type="text" id="bank" value="<?=$bank?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Branch : </td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell">
                          <input name="ESSENTIAL_BRANCH" type="text" id="ESSENTIAL_BRANCH" value="<?=$ESSENTIAL_BRANCH?>" /></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Blood Group:</span></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="ESSENTIAL_BLOOD_GROUP">
                            <option selected="selected">
                            <?=$ESSENTIAL_BLOOD_GROUP?>
                            </option>
                            <option>A(+ve)</option>
                            <option>A(-ve)</option>
                            <option>AB(+ve)</option>
                            <option>AB(-ve)</option>
                            <option>B(+ve)</option>
                            <option>B(-ve)</option>
                            <option>O(+ve)</option>
                            <option>O(-ve)</option>
                            <option>N/I</option>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Account # :</td>
                          <td class="oe_form_group_cell"><input name="ESSENTIAL_ACC_NO" type="text" id="ESSENTIAL_ACC_NO" value="<?=$ESSENTIAL_ACC_NO?>" /></td>
                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Passport # :</span></td>
                          <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                            <input name="ESSENTIAL_PASSPORT_NO" type="text" id="ESSENTIAL_PASSPORT_NO" value="<?=$ESSENTIAL_PASSPORT_NO?>" />
                          </span></td>
                        </tr>
                       <tr class="oe_form_group_row">
                        <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Address # :</td>
                        <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="ESSENTIAL_BANK_ADDRESS" type="text" id="ESSENTIAL_BANK_ADDRESS" value="<?=$ESSENTIAL_BANK_ADDRESS?>" /></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Type of passport :</span></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="ESSENTIAL_TYPE_OF_PASSPORT">
                            <option selected="selected">
                            <?=$ESSENTIAL_TYPE_OF_PASSPORT?>
                            </option>
                            <option>National </option>
                            <option>International </option>
                            <option>Red Colour </option>
                            <option>Green Colour </option>
                            <option>Country Wise </option>
                            <option>N/A </option>
                            <option>N/I </option>
                          </select></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;&nbsp;Type of License :</td>
                          <td bgcolor="#FFFFFF" class="oe_form_group_cell"><select name="ESSENTIAL_TYPE_OF_LICENSE">
                              <option selected="selected">
                              <?=$ESSENTIAL_TYPE_OF_LICENSE?>
                              </option>
                              <option>Motor Cycle</option>
                              <option>Professional</option>
                              <option>Non Professional</option>
                              <option>N/I</option>
                              <option>N/A</option>
                              <option>Heavy</option>
                              <option>Mediam</option>
                              <option>Light</option>
                          </select></td>
                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">TIN # :</span></td>
                          <td class="oe_form_group_cell"><input name="ESSENTIAL_TIN_NO" type="text" id="ESSENTIAL_TIN_NO" value="<?=$ESSENTIAL_TIN_NO?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Driving License # :</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="ESSENTIAL_DRIVING_LICENSE_NO" type="text" id="ESSENTIAL_DRIVING_LICENSE_NO" value="<?=$ESSENTIAL_DRIVING_LICENSE_NO?>" />
                          </td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Visited Country: </span></td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="ESSENTIAL_VISITED_COUNTRY" type="text" id="ESSENTIAL_VISITED_COUNTRY" value="<?=$ESSENTIAL_VISITED_COUNTRY?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                          <td class="oe_form_group_cell">&nbsp;</td>
                          <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> Passport Issue Date :</span></td>
                          <td class="oe_form_group_cell"><input name="ESSENTIAL_ISSUE_DATE" type="text" id="ESSENTIAL_ISSUE_DATE" value="<?=$ESSENTIAL_ISSUE_DATE?>" /></td>
                        </tr>
                        <tr class="oe_form_group_row">
                          <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                          <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
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
</form>
<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>