<?php
session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
// ::::: Edit This Section ::::: 
$title='Personal File Type Information';			// Page Name and Page Title
$page="hrm_pf_type.php";		// PHP File Name
$input_page="pf_type_input.php";
$root='setup';

$table='hrm_pf_type_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='file_type';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now				= time();
$_POST['group_name'] = $_POST['group_name'];
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
$_POST['group_name'] = $_POST['group_name'];
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
foreach($data as $key => $value)
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
<html style="height: 100%;"><head>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <link href="../css/css.css" rel="stylesheet"></head>
<body>
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: 458px; width: 453px; display: block; /* [disabled]left: 217.5px; */ left: 251px; top: 51px;" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
          <? include('../common/title_bar_popup.php');?>
      <div style="display: block; max-height: 464px; overflow-y: auto; width: auto; min-height: 82px; height: auto;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">

            <div style="width:100%" class="oe_popup_form">
              <div class="oe_formview oe_view oe_form_editable" style="opacity: 1;">
                <div class="oe_form_buttons"></div>
                <div class="oe_form_sidebar" style="display: none;"></div>
                <div class="oe_form_container">
                  <div class="oe_form">
                    <div class="">
                      <? include('../common/input_bar.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
      
    </label>
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td width="448" class="oe_form_group_cell"><table width="450" height="184" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
			  
			  
			  
			  
                <tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="21%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; File Type Name :</td>
                  <td bgcolor="#E8E8E8" width="79%" class="oe_form_group_cell oe_form_group_cell_label">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                  <input name="file_type" type="text" id="file_type" value="<?=$file_type?>" required /></td>
                  
                </tr>
				
				
				<tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="21%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; File Path Name (Use Underscore) :</td>
                  <td bgcolor="#E8E8E8" width="79%" class="oe_form_group_cell oe_form_group_cell_label">
               
                  <input name="file_path" type="text" id="file_path" value="<?=$file_path?>" required /></td>
                  
                </tr>
				
 <tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="21%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Required :</td>
                  <td bgcolor="#E8E8E8" width="79%" class="oe_form_group_cell oe_form_group_cell_label">
                
      
				  
				        <select name="required_status" id="required_status">

                                  <option value="Yes" >Yes</option>

                                  <option value="No" >No</option>

                      

                      

                                </select>
				  
				  
				  
				  
				  </td>
                  
                </tr>
				
				     <tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="21%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; File Format :</td>
                  <td bgcolor="#E8E8E8" width="79%" class="oe_form_group_cell oe_form_group_cell_label">
                
      
				  
				        <select name="file_format" id="file_format">

                                  <option value="JPG" <?=($file_format=='JPG')?'selected':''?>>JPG</option>

                                  <option value="PDF" <?=($file_format=='PDF')?'selected':''?>>PDF</option>
								  
								  <option value="JPEG" <?=($file_format=='JPEG')?'selected':''?>>JPEG</option>

                      

                      

                                </select>
				  
				  
				  
				  
				  </td>
                  
                </tr>
				
				
				
				
                <tr class="oe_form_group_row">
                  <td height="115" colspan="4" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
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
</body></html>
