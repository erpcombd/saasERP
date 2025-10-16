<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section ::::: 
$title='Motorcycle Installment';			// Page Name and Page Title
$page="motorcycle_install.php";		// PHP File Name
$input_page="motorcycle_install.php";
$root='payroll';

$table='motorcycle_install';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='advance_amt';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::
// ::::: End Edit Section :::::

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
$_REQUEST['current_mon'] = date('m',mktime(1,1,1,$smon,1,$syear));
$_REQUEST['current_year'] = date('Y',mktime(1,1,1,$smon,1,$syear));
$_REQUEST['installment_no'] = $i+1;
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
<script type="text/javascript"> function DoNav(lk){
	document.location.href = '<?=$page?>?<?=$unique?>='+lk;
	}
	
	
function install_amnt_auto_cal(){
var tot_amnt=document.getElementById('advance_amt').value;
var tot_istl=document.getElementById('total_installment').value;
var istl_amnt=tot_amnt/tot_istl;
document.getElementById('payable_amt').value = istl_amnt;
}	
</script>


<div class="oe_view_manager oe_view_manager_current">
      <form action="" method="post" enctype="multipart/form-data">  
    <? include('../common/title_bar.php');?>
    </form>
    <form action="" method="post" enctype="multipart/form-data">
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
                        <div class="oe_form_sheet oe_form_sheet_width" style="min-height:100px;">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Total Installment  Amount :</strong></td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="advance_amt" type="text" id="advance_amt" value="<?=$advance_amt?>" required />
                    <input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
                    <label for="textfield"></label>
                    <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" /></td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Total Install :</strong></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="total_installment" type="text" id="total_installment" onkeyup="install_amnt_auto_cal()" value="<?=$total_installment?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Start Month :</strong></td>
                  <td colspan="1" class="oe_form_group_cell">      <select name="start_mon" style="width:160px;" id="start_mon" required>
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
<select name="start_year" style="width:160px;" id="start_year" required>
<option <?=($start_year=='2016')?'selected':''?>>2016</option>
<option <?=($start_year=='2017')?'selected':''?>>2017</option>
<option <?=($start_year=='2018')?'selected':''?>>2018</option>
<option <?=($start_year=='2019')?'selected':''?>>2019</option>
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
<option <?=($current_year=='2013')?'selected':''?>>2013</option>
<option <?=($current_year=='2014')?'selected':''?>>2014</option>
<option <?=($current_year=='2015')?'selected':''?>>2015</option>
<option <?=($current_year=='2016')?'selected':''?>>2016</option>
</select>

</td>
</tr>
<? }?>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Monthly Payable Amt :</strong></td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input name="payable_amt" type="text" id="payable_amt" value="<?=$payable_amt?>" required /></td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Install Type:</strong></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><label for="advance_type"></label>
                    <select name="advance_type" id="advance_type" required>
                    <option></option>
                    <option <?=($advance_type=='Advance Cash')?'selected':'';?>>Advance Cash</option>
                    <option <?=($advance_type=='Other Advance')?'selected':'';?>>Other Advance</option>
                    </select></td>
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
          <? 	echo $res='select id, advance_type,payable_amt, installment_no,concat(current_mon,"-",current_year) as payable_month,total_installment ,	 concat(start_mon,"-",start_year) as start_month,advance_amt as total_advance_amt  from motorcycle_install where PBI_ID="'.$_SESSION['employee_selected'].'" order by id desc';
				echo $crud->link_report($res,$link);?>
          </div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
        </form>
    </div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>