<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
 

// ::::: Edit This Section ::::: 
$title='Customer Information';			// Page Name and Page Title
$page="project_type.php";		// PHP File Name
$input_page="project_type_input.php";
$root='setup';

$table='crm_customer_info';		// Database Table Name Mainly related to this page
$unique='dealer_code';			// Primary Key of this Database table
$shown='dealer_name_e';				// For a New or Edit Data a must have data field
// ::::: End Edit Section :::::


$crud=new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$pre_check = find_a_field('crm_customer_info','dealer_code','dealer_name_e="'.$_POST['dealer_name_e'].'"');
if($pre_check==0 || $pre_check==''){
$now				= time();
$_POST['entry_by'] = $_SESSION['employee_selected'];
$_POST['join_date'] = date('Y-m-d');
$_POST['organization'] = $_POST['dealer_name_e'];
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
}else{
 echo '<span style="color:red;font-weight:bold">Duplicate Found!</span>';
}

}


//for Modify..................................

if(isset($_POST['update']))
{

//$duplicate = find_a_field('crm_project','PROJECT_ID','PROJECT_DESC="'.$_POST['PROJECT_DESC'].'"');

//if($duplicate>0){

//$_SESSION['flash']= " <b style='color: white; background-color: blue;'>'".$_POST['PROJECT_DESC']."'</b> company name already  Exist !! You can't update on this name again.";


//}else{
$_POST['update_at'] = date("Y-m-d h:i:s");
$_POST['update_by'] = $_SESSION['employee_selected'];
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
//}
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
foreach ($data as $key => $value)
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
<html style="height: 100%;"><head>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <link href="../../../assets/css/css.css" rel="stylesheet">
		
   <link rel="stylesheet" href="bootstrap-select.min.css">
		<link rel="stylesheet" href="bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		</head>
<body>
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */ left: 16px; top: 21px;" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
          <? include('../../common/title_bar_popup.php');?>
      <div style="display: block; max-height: 464px; overflow-y: auto; width: auto; min-height: 82px; height: auto;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">

            <div style="width:100%" class="oe_popup_form">
              <div class="oe_formview oe_view oe_form_editable" style="opacity: 1;">
                <div class="oe_form_buttons"></div>
                <div class="oe_form_sidebar" style="display: none;"></div>
                <div class="oe_form_container">
                  <div class="oe_form">
                    <div class="">
                      <? include('../../common/input_bar.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="261" height="198" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
               <!-- <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Customer Group </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
				  
				  <select name="group_id" id="group_id" class="selectpicker" data-live-search="true">
				  <option value=""></option>
				  <? foreign_relation('crm_company_group','id','group_name',$group_id,' 1 ')?>
				  </select>				  </td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Customer Category </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><select name="customer_category_id" id="customer_category_id"  class="selectpicker" data-live-search="true">
                    <option value=""></option>
                    <? foreign_relation('crm_company_category','id','category_name',$customer_category_id,' 1 ')?>
                  </select></td>
                </tr>-->
                <tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Customer Organization :</td>
                  <td bgcolor="#E8E8E8" width="82%" class="oe_form_group_cell oe_form_group_cell_label">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                  <input name="dealer_name_e" type="text" id="dealer_name_e" class="form-control" style="width:50%; height:40px;" value="<?=$dealer_name_e?>" /></td>
                </tr>
				
				<!--<tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Customer Name :</td>
                  <td bgcolor="#E8E8E8" width="82%" class="oe_form_group_cell oe_form_group_cell_label">
                  <input name="dealer_name_e" type="text" id="dealer_name_e" class="form-control" style="width:50%; height:40px;" value="<?=$dealer_name_e?>" /></td>
                </tr>-->
				  
				  
				  <tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Customer Address :</td>
                  <td bgcolor="#E8E8E8" width="82%" class="oe_form_group_cell oe_form_group_cell_label">
                  <input type="text" name="address_e" id="address_e"  class="form-control" style="width:50%; height:40px;" value="<?=$address_e?>"></td>
                </tr>
				
				<tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Contact Person :</td>
                  <td bgcolor="#E8E8E8" width="82%" class="oe_form_group_cell oe_form_group_cell_label">
                  <input type="text" name="contact_person" id="contact_person"  class="form-control" style="width:50%; height:40px;" value="<?=$contact_person?>"/></td>
                </tr>
				
				<tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Designation :</td>
                  <td bgcolor="#E8E8E8" width="82%" class="oe_form_group_cell oe_form_group_cell_label">
                  <input type="text" name="designation" id="designation"  class="form-control" style="width:50%; height:40px;" value="<?=$designation?>"/></td>
                </tr>
				
				<tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Mobile Number :</td>
                  <td bgcolor="#E8E8E8" width="82%" class="oe_form_group_cell oe_form_group_cell_label">
                  <input type="text" name="mobile_no" id="mobile_no"  class="form-control" style="width:50%; height:40px;" value="<?=$mobile_no?>"/></td>
                </tr>
				
				<tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Telephone Number :</td>
                  <td bgcolor="#E8E8E8" width="82%" class="oe_form_group_cell oe_form_group_cell_label">
                  <input type="text" name="tel_no" id="tel_no"  class="form-control" style="width:50%; height:40px;" value="<?=$tel_no?>"/></td>
                </tr>
				
				<tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Email :</td>
                  <td bgcolor="#E8E8E8" width="82%" class="oe_form_group_cell oe_form_group_cell_label">
                  <input type="text" name="email" id="email"  class="form-control" style="width:50%; height:40px;" value="<?=$email?>"/></td>
                </tr>
				  
				 
                </tbody></table>
              <p>&nbsp;</p></td>
            </tr></tbody></table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="ui-resizable-handle ui-resizable-n" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-e" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-s" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-w" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se ui-icon-grip-diagonal-se" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-sw" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-ne" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-nw" style="z-index: 1000;"></div>
          <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">

          </div>
        </div>
</form>
</body>



<script src="jquery.min.js"></script>
<script src="bootstraps.min.js"></script>
<script src="bootstrap-select.min.js"></script>
</html>
