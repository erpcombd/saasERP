<?php
session_start();

ob_start();

 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



//::::: Edit This Section::::: 

$title = 'Lead Information';  // Page Name and Page Title

$page = "lead_create.php";  // PHP File Name

$input_page = "lead_create.php";

$root = 'lead';

$table = 'crm_lead_master';  // Database Table Name Mainly related to this page
$unique = 'lead_no';   // Primary Key of this Database table
$shown = 'lead_no';



do_calander('#lead_date');
do_calander('#maturity_date');
do_calander('#priority_date');
do_calander('#permanent_date');

//::::: End Edit Section:::::

$crud = new crud($table);


$required_id = find_a_field($table, $unique, $unique . '=' . $_SESSION['dealer_selected']);
if ($required_id > 0)
    $$unique = $_GET[$unique] = $required_id;



if (isset($_POST[$shown])) {
    if (isset($_POST['insert'])) {
	
			$_POST['entry_by'] = $_SESSION['employee_selected'];

        	$id = $_POST['lead_no'];
            $crud->insert();
            $type = 1;
            $msg = 'New Entry Successfully Inserted.';
            unset($_POST);
            unset($$unique);
            $required_id = find_a_field($table, $unique, $unique . '=' . $_SESSION['lead_selected']);
            if ($required_id > 0)
                $$unique = $_GET[$unique] = $required_id;
    }
    //for Modify..................................
    if (isset($_POST['update'])) {
	$_POST['update_by'] = $_SESSION['employee_selected'];
	$_POST['update_at'] = date('Y-m-d H:i:s');
	
        $crud->update($unique);
        $type = 1;
    }
}


if ($_POST['lead_selected']>0) {
    if ($_POST['button'] == 'Find') {
        $_SESSION['lead_selected'] = $_POST['lead_selected'];
    }
    if ($_POST['button'] == 'cancel') {
        unset($_SESSION['lead_selected']);
    }
}
if ($_SESSION['lead_selected'] > 0 && $required_id < 1)
    $$unique = $_SESSION['lead_selected'];
	
	
if (isset($$unique)) {
    $condition = $unique . "=" . $$unique;
    $data = db_fetch_object($table, $condition);
    while (list($key, $value) = @each($data)) {
        $$key = $value;
    }
}

?>
<script type="text/javascript"> function DoNav(lk) {

        return GB_show('ggg', '../pages/<?= $root ?>/<?= $input_page ?>?<?= $unique ?>=' + lk, 600, 940)

    }

    function add_date(cd)

    {

        var arr = cd.split('-');

        var mon = (arr[1] * 1) + 6;

        var day = (arr[2] * 1);

        var yr = (arr[0] * 1);

        if (mon > 12)

        {

            mon = mon - 12;

            yr = yr + 1;

        }

        var con_date = yr + '-' + mon + '-' + day;

        document.getElementById('PBI_DOC').value = con_date;

    }

</script>

<div class="oe_view_manager oe_view_manager_current">

    
        <? include('../../common/title_bar_l.php'); ?>
		<form action="" method="post" enctype="multipart/form-data">
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
                                <? include('../../common/input_bar_l.php'); ?>
                                <div class="oe_form_sheetbg">
                                    <div class="oe_form_sheet oe_form_sheet_width">
                                        
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                                            <tbody>
                                                <tr class="oe_form_group_row">
                                                    <td colspan="1" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;" width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                                                            <tbody>
                                                                <tr class="oe_form_group_row">
                                                                    <td colspan="4" bgcolor="#00CCFF" class="oe_form_group_cell_label oe_form_group_cell"><div align="center"><strong>Lead INFORMATION </strong></div></td>
                                                                </tr>
                                                                <tr class="oe_form_group_row">
                                                                  <td width="21%"  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                                                  <td width="32%"  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">&nbsp;</td>
                                                                  <td width="15%"  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">&nbsp;</td>
                                                                  <td width="32%"  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">&nbsp;</td>
                                                                </tr>
                                                                <tr class="oe_form_group_row">
                                                                    <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Lead Code: </span></td>
                                                                    <td  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><input  name="lead_no" type="text" id="lead_no" value="<?= ($$unique == 0) ? (find_a_field('crm_lead_master', 'max(lead_no)', '1') + 1) : $$unique; ?>" readonly="" required  class="form-control" style="width: 200px;"/></td>
                                                                    <td  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Project</span></td>
                                                                    <td  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><select name="project_id" id="project_id"   class="form-control" style="width: 200px;">
									<option value=""></option>
                                     <? foreign_relation('crm_project','PROJECT_ID','PROJECT_DESC',$project_id,'1')?>
                                    </select></td>
                                                                </tr>
                                                                <tr class="oe_form_group_row">
                                                                  <td  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Type Of Lead </span></td>
                                                                  <td  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><select name="lead_type" id="lead_type"   class="form-control" style="width: 200px;">
																  <option value=""></option>
                                                                     <? foreign_relation('crm_type_of_lead','id','type',$lead_type,' 1 ')?>
                                                                  </select></td>
                                                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><span class="oe_form_group_cell" style="padding: 2px 0 2px 0px;">Value Of lead </span> </td>
                                                                    <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                                                                      <input  name="lead_value" type="text" id="lead_value" value="<?=$lead_value?>"   class="form-control" style="width: 200px;"/>                                                                    </td>
                                                                </tr>
                                                            <tr>
                                                              <td  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Lead Status </span></td>
                                                              <td  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><select name="lead_status" id="lead_status"   class="form-control" style="width: 200px;">
                                                                  <option value=""></option>
																  <? foreign_relation('crm_lead_status','id','status',$lead_status,' 1 ')?>
																  
                                                              </select></td>
                                                              <td  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Service/Product</span></td>
                                                              <td  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><select name="service_id" id="service_id"   class="form-control" style="width: 200px;">
                                                                  <option></option>
																  <? foreign_relation('crm_service','service_id','service_name',$service_id,'1')?>
																  
																  
                                                              </select></td>
                                                            <tr class="oe_form_group_row">
                                                                <td  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                                                <td colspan="3"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                                            </tr>

                                                            <tr class="oe_form_group_row">

                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                                                <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">&nbsp;</td>
                                                            </tr>


                                                            <tr class="oe_form_group_row">
                                                                <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                                                <td  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">&nbsp;</td>

                                                                <td colspan="2" align="center"  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">&nbsp;</td>
                                                            </tr>
                                                            <tr bgcolor="#FFFFFF" class="oe_form_group_row">
                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                                                <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">&nbsp;</td>
                                                                <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">&nbsp;</td>
                                                                <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">&nbsp;</td>
                                                            </tr>
                                                            <tr class="oe_form_group_row">
                                                                <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                                                <td  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">&nbsp;</td>



                                                                <td  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">&nbsp;</td>
                                                                <td  class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">&nbsp;</td>
                                                            </tr>
                                                            
                                                            <tr class="oe_form_group_row">
                                                                <td bgcolor="#FFFFFF" colspan="4" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                                            </tr>
                                            </tbody>
                                        </table></td>
                                        </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="oe_chatter">
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
    </form>
</div>
<?
$main_content = ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";
?>
