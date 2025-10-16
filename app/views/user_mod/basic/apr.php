<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='APR Entry Management';			// Page Name and Page Title
$page="apr.php";		// PHP File Name
$input_page="apr_input.php";
$root='hrm';

$table='apr_detail';		// Database Table Name Mainly related to this page
$unique='APR_D_ID';			// Primary Key of this Database table
$shown='APR_YEAR';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::
// ::::: End Edit Section :::::

$personnel_basic_info=find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);

$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
	
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now				= time();

$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];
$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';

if(isset($_POST['insert']))
{
echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
}
unset($_POST);
unset($$unique);
}


//for Modify..................................

if(isset($_POST['update']))
{

		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
				echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
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
while (list($key, $value)=@each($data))
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

$$unique = $_GET[$unique];

?>
<script type="text/javascript"> function DoNav(lk){
	document.location.href = '<?=$page?>?<?=$unique?>='+lk;
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
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#00CC00" colspan="4" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;APR Achievement in Marks:</strong></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Name :</td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="APR_MARKS2" type="text" id="APR_MARKS2" value="<?=$personnel_basic_info->PBI_NAME?>" readonly /></td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Designation :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="APR_MARKS3" type="text" id="APR_MARKS3" value="<?=$personnel_basic_info->PBI_DESIGNATION?>" readonly /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Domain :</td>
                  <td colspan="1" class="oe_form_group_cell"><input name="APR_MARKS4" type="text" id="APR_MARKS4" value="<?=$personnel_basic_info->PBI_DOMAIN?>"  readonly/></td>
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Zone :</td>
                  <td class="oe_form_group_cell"><input name="APR_MARKS5" type="text" id="APR_MARKS5" readonly value="<?=$personnel_basic_info->PBI_ZONE?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Service Length of PP:</td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="APR_MARKS6" type="text" id="APR_MARKS6" value="<?=Date2age($personnel_basic_info->PBI_DOJ_PP)?>"  readonly/></td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Job Status :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="APR_MARKS7" type="text" id="APR_MARKS7" value="<?=$personnel_basic_info->PBI_JOB_STATUS?>"  readonly/></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;APR Year :</td>
                  <td colspan="1" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <select name="APR_YEAR">
                      <option selected><?=$APR_YEAR?></option>
                        <option>2000</option>
                        <option>2001</option>
                        <option>2002</option>
                        <option>2003</option>
                        <option>2004</option>
                        <option>2005</option>
                        <option>2006</option>
                        <option>2007</option>
                        <option>2008</option>
                        <option>2009</option>
                        <option>2010</option>
                        <option>2011</option>
                        <option>2012</option>
                        <option>2013</option>
                        <option>2014</option>
                        <option>2015</option>
                        <option>2016</option>
                    </select></td>
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Marks :</td>
                  <td class="oe_form_group_cell"><input name="APR_MARKS" type="text" id="APR_MARKS" value="<?=$APR_MARKS?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="4" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="4" bgcolor="#CCFF66" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Recommendation:</strong></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"> &nbsp;&nbsp;Department for Increment:</td>
                  <td class="oe_form_group_cell"><select name="d_r_increment">
                    <option selected="selected">
                      <?=$d_r_increment?>
                      </option>
                    <option>Yes</option>
                    <option>No</option>
                    <option>N/A</option>
                  </select></td>
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">HR-M for Increment:</td>
                  <td class="oe_form_group_cell"><select name="hr_r_increment">
                   <option selected><?=$hr_r_increment?></option>
                    <option>Yes</option>
                    <option>No</option>
                    <option>N/A</option>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Department for Promotion: :</td>
                  <td class="oe_form_group_cell"><select name="d_r_promotion">
                   <option selected><?=$d_r_promotion?></option>
                    <option>Yes</option>
                    <option>No</option>
                    <option>N/A</option>
                  </select></td>
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td class="oe_form_group_cell">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="4" class="oe_form_group_cell">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="4" bgcolor="#FF0000" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;</span>Decision:</strong> </td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Status :</td>
                  <td class="oe_form_group_cell"><select name="APR_STATUS">
                    <option selected="selected">
                      <?=$APR_STATUS?>
                      </option>
                    <option>Everything Ok</option>
                    <option>Below Service Length</option>
                    <option>Financial Objection</option>
                    <option>Below Marks</option>
                    <option>Over Age</option>
                    <option>Below Average Marks</option>
                    <option>Already Promoted</option>
                    <option>LPD</option>
                    <option>Already Get Increnent</option>
                    <option>Negetive Action</option>
                    <option>N/A</option>
                  </select></td>
                  <td class="oe_form_group_cell">Result : </td>
                  <td class="oe_form_group_cell"><select name="APR_RESULT">
                    <option selected="selected">
                      <?=$APR_RESULT?>
                      </option>
                    <option>Increment</option>
                    <option>Promotion</option>
                    <option>Both Increment and Promotion</option>
                    <option>Both Are Not</option>
                    <option>Special Promotion</option>
                  </select>
                    &nbsp;</td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td colspan="4" class="oe_form_group_cell">&nbsp;</td>
                </tr>
                </tbody></table>
</td>
          </tr></tbody></table>
                        </div>
                      </div>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
          <? 	$res='select '.$unique.',APR_YEAR as Year, APR_MARKS as marks, APR_STATUS as Status, APR_RESULT as Result from '.$table.' where PBI_ID='.$_SESSION['employee_selected'].' order by APR_YEAR desc';
											echo $crud->link_report($res,$link);?>
          </div></div>
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