<?php




session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Report Management';			// Page Name and Page Title
$page="report_manage.php";		// PHP File Name
$input_page="report_manage_input.php";
$root='setup';

$table='report_manage';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='page_name';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];
create_combobox("feature_id");
create_combobox("page_id");
$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{	
	
$now				= time();

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
foreach ($data as $key => $value)
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
<html style="height: 100%;"><head>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
  <link href="../../../../public/assets/css/css.css" type="text/css" rel="stylesheet"/></head>
<body>
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
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
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td class="oe_form_group_cell"><table width="168%" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
            <tbody>
			
				<tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Report Name : </td>
                  <td colspan="1" class="oe_form_group_cell"><input name="report_name" type="text" id="report_name" value="<?=$report_name?>" /></td>
                </tr>
				
                <tr class="oe_form_group_row">
                  <td width="50%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Page Name :</td>
                  <td width="50%" colspan="1" class="oe_form_group_cell"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <input name="page_name" type="text" id="page_name" value="<?=$page_name?>" /></td>
                </tr>
                
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Folder Name : </td>
                  <td colspan="1" class="oe_form_group_cell"><input name="folder_name" type="text" id="folder_name" value="<?=$folder_name?>" /></td>
                </tr>
                
                
<tr class="oe_form_group_row">
  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>Feature Name :</label></td>
  <td colspan="1" class="oe_form_group_cell"><select name="feature_id" id="feature_id">
  <option></option>
      <? foreign_relation('user_feature_manage f, user_module_manage m','f.id','concat(m.module_name," >> ",f.feature_name)',$feature_id,'1 and f.module_id=m.id 
	  and f.feature_name LIKE "%repor%" order by f.module_id,f.feature_name asc');?>
  </select></td>
</tr>


<tr class="oe_form_group_row">
  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>Page Name :</label></td>
  <td colspan="1" class="oe_form_group_cell"><select name="page_id" id="page_id">
  <option></option>
      <? foreign_relation('user_page_manage f, user_feature_manage m, user_module_manage u','f.id','concat(u.module_name,">>",m.feature_name," >> ",f.page_name)',$page_id,'1 and f.feature_id=m.id and u.id=m.module_id  and f.page_name LIKE "%repor%" order by f.feature_id,f.page_name asc');?>
  </select></td>
</tr>
                
                
                
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>Status :</label></td>
                  <td colspan="1" class="oe_form_group_cell"><select name="status" id="status">
                      <option>
                        <?=$status?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                  </select></td>
                </tr>
				
				
				  <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>Type :</label></td>
                  <td colspan="1" class="oe_form_group_cell"><select name="type" id="type">
                      <option>
                        <?=$type?>
                        </option>
                      <option>Configuration</option>
                      <option>Basic</option>
					  <option>Advance</option>
                  </select></td>
                </tr>
				
				
				<tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Report No : </td>
                  <td colspan="1" class="oe_form_group_cell"><input name="report_no" type="text" id="report_no" value="<?=$report_no?>" /></td>
                </tr>
				
				
				<tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Report Ordering : </td>
                  <td colspan="1" class="oe_form_group_cell"><input name="ordering" type="text" id="ordering" value="<?=$ordering?>" /></td>
                </tr>
				
				
				
				<?php /*?><tr class="oe_form_group_row"> 
    <td width="30%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>Type :</label></td>
                  <td width="70%" colspan="1" class="oe_form_group_cell">
        <select name="type" id="type"  required >
            <option value=""></option>
            <?php foreign_relation('features_type', 'id', 'features_type',$type, 'status="Active"'); ?>
        </select>
    </td>
</tr><?php */?>
				
				
				<?php /*?><tr class="oe_form_group_row"> 
    <td width="17%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Product ID:</td>
    <td width="83%" colspan="1" class="oe_form_group_cell">
	
		<? 
		
		$report_nos = explode(",", $report_no); ?>
        <select name="report_no[]" id="report_no" multiple required style="height:100px;">
            <option value=""></option>
            <?php foreign_relation2('product_info', 'id', 'product_name',$report_nos, 'status="Active"'); ?>
        </select>
    </td>
</tr><?php */?>
				
				
				
                </tbody></table></td>
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
