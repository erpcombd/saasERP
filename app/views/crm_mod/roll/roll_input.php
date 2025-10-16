<?php
session_start();

// 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
// ::::: Edit This Section ::::: 
$title='Roll Assign Information';			// Page Name and Page Title
$page="roll.php";		// PHP File Name
$input_page="roll_input.php";
$root='roll';

$table='crm_roll_assign';		// Database Table Name Mainly related to this page
$unique='PBI_ID';			// Primary Key of this Database table
$shown='PBI_ID';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud=new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];




//for Modify..................................

if(isset($_POST['update']))
{

 $$unique= $_POST[$unique];

if($$unique>0){

$delete = 'delete from crm_roll_assign where PBI_ID="'.$$unique.'"';

db_query($delete);

$now				= time();
$_POST['entry_by'] = $_SESSION['srrr'];
$_POST['update_by'] = $_SESSION['srrr'];
$crud->insert();
		$type=1;
		$msg='Successfully Updated.';


}


		
		

				echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
}
//for Delete..................................


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
        <link href="../../css/css.css" rel="stylesheet">
		
    <link href="../../vendors/bootstrap/dist/css/buttons.bootstrap.min.css" rel="stylesheet">

    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="854" height="297" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
   <td bgcolor="#E8E8E8" width="23%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Employee Name  :</td>
                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
				  <?
				  $se = 'select * from personnel_basic_info where PBI_ID="'.$$unique.'"';
				  $qu = db_query($se);
				  $rw = mysqli_fetch_object($qu);
				  ?>
                  <input type="text" value="<?=$rw->PBI_NAME?>" readonly=""/></td>
				  <td colspan="2" bgcolor="#E8E8E8">
				    <div align="center">Account Access ? </div></td>
				  <td width="21%" bgcolor="#E8E8E8"><span class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">
				  
				  <select style="width: 50px; height: 30px" name="access" id="access">
                        <? foreign_relation('crm_access_type','id','type',$access,'1  order by id asc')?>
                      </select>			</span>	  </td>
                  </tr>
				  
				  
				  <tr class="oe_form_group_row">
				    <td bgcolor="#E8E8E8" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Department  :</td>
				    <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input type="text" value="<?=find_a_field('department','DEPT_DESC','DEPT_ID='.$rw->PBI_DEPARTMENT)?>" readonly="">				      &nbsp;&nbsp;</td>
				    <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><div align="center">Designation  :</div></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input type="text" value="<?=find_a_field('designation','DESG_DESC','DESG_ID='.$rw->PBI_DESIGNATION)?>" readonly=""></td>
				    </tr>
				  <tr class="oe_form_group_row">
				    <td height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
				    <td width="16%" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
				    <td width="16%" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
				    <td width="15%" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
				    <td width="9%" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
				    <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
				    </tr>
				  <tr class="oe_form_group_row">
				    <td bgcolor="#E8E8E8" height="33" colspan="1" style="border-bottom: 1px dotted white;" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Dashboard Panel</td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><select style="width: 120px; height: 30px" name="dashboard_panel" id="dashboard_panel">
                        <? foreign_relation('crm_roll_type','id','type',$dashboard_panel,'1 order by id asc')?>
                    </select></td>
				    <td  class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;</td>
				    <td  class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;</td>
				    <td  class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;</td>
				    <td  class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;</td>
				    </tr>
				  <tr class="oe_form_group_row">
                    <td bgcolor="#E8E8E8" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;&nbsp;Roll Panel </td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><select style="width: 120px; height: 30px" name="roll_panel" id="roll_panel">
                        <? foreign_relation('crm_roll_type','id','type',$roll_panel,'1 order by id asc')?>
                      </select>                    </td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><div align="center">Modification ? </div></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><select style="width: 50px; height: 30px" name="roll_edit" id="roll_edit">
                        <? foreign_relation('crm_access_type','id','type',$roll_edit,'1  order by id asc')?>
                      </select>                    </td>
				    <td  class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;</td>
				    <td class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;</td>
				    </tr>
				  <tr class="oe_form_group_row">
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;&nbsp;Setup Panel </td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><select style="width: 120px; height: 30px" name="setup_panel" id="setup_panel">
                        <? foreign_relation('crm_roll_type','id','type',$setup_panel,'1 order by id asc')?>
                      </select>                    </td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><div align="center">Modification ? </div></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><span class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">
                      <select style="width: 50px; height: 30px" name="setup_edit" id="setup_edit">
                        <? foreign_relation('crm_access_type','id','type',$setup_edit,'1  order by id asc')?>
                      </select>
                    </span></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">Create ? </span></div></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><span class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">
				      <select style="width: 50px; height: 30px" name="setup_create" id="setup_create">
                        <? foreign_relation('crm_access_type','id','type',$setup_create,'1  order by id asc')?>
                      </select>
				    </span></td>
				    </tr>
				  <tr class="oe_form_group_row">
				    <td bgcolor="#E8E8E8" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;&nbsp;Customer Panel </td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><select style="width: 120px; height: 30px" name="customer_panel" id="customer_panel">
                      <? foreign_relation('crm_roll_type','id','type',$customer_panel,'1  order by id asc')?>
                    </select></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><div align="center">Modification ? </div></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><span class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">
                      <select style="width: 50px; height: 30px" name="customer_edit" id="customer_edit">
                        <? foreign_relation('crm_access_type','id','type',$customer_edit,'1  order by id asc')?>
                      </select>
                    </span></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">Create ? </span></div></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><span class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">
				      <select style="width: 50px; height: 30px" name="customer_create" id="customer_create">
                        <? foreign_relation('crm_access_type','id','type',$customer_create,'1  order by id asc')?>
                      </select>
				    </span></td>
				    </tr>
				  <tr class="oe_form_group_row">
				    <td bgcolor="#E8E8E8" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;&nbsp;Lead Panel </td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><select style="width: 120px; height: 30px" name="lead_panel" id="lead_panel">
                      <? foreign_relation('crm_roll_type','id','type',$lead_panel,'1 order by id asc')?>
                    </select></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><div align="center">Modification ? </div></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><span class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">
                      <select style="width: 50px; height: 30px" name="lead_edit" id="lead_edit">
                        <? foreign_relation('crm_access_type','id','type',$lead_edit,'1  order by id asc')?>
                      </select>
                    </span></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">Create ? </span></div></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><span class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">
				      <select style="width: 50px; height: 30px" name="lead_create" id="lead_create">
                        <? foreign_relation('crm_access_type','id','type',$lead_create,'1  order by id asc')?>
                      </select>
				    </span></td>
				    </tr>
				  <tr class="oe_form_group_row">
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;&nbsp;Communication Panel </td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><select style="width: 120px; height: 30px" name="comm_panel" id="comm_panel">
                        <? foreign_relation('crm_roll_type','id','type',$comm_panel,'1 order by id asc')?>
                    </select></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><div align="center">Modification ? </div></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><span class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">
                      <select style="width: 50px; height: 30px" name="comm_edit" id="comm_edit">
                        <? foreign_relation('crm_access_type','id','type',$comm_edit,'1  order by id asc')?>
                      </select>
                    </span></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">Create ? </span></div></td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><span class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">
				      <select style="width: 50px; height: 30px" name="comm_create" id="comm_create">
                        <? foreign_relation('crm_access_type','id','type',$comm_create,'1  order by id asc')?>
                      </select>
				    </span></td>
				    </tr>
				  <tr class="oe_form_group_row">
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;&nbsp;Report Panel </td>
				    <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;"><select style="width: 120px; height: 30px" name="report_panel" id="report_panel">
                        <? foreign_relation('crm_roll_type','id','type',$report_panel,'1 order by id asc')?>
                    </select></td>
				    <td  class="oe_form_group_cell oe_form_group_cell_label"  style="border-bottom: 1px dotted white;">&nbsp;</td>
				    <td  class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;</td>
				    <td  class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;</td>
				    <td  class="oe_form_group_cell oe_form_group_cell_label" style="border-bottom: 1px dotted white;">&nbsp;</td>
				    </tr><tr class="oe_form_group_row">
                  <td height="33" colspan="6" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
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




</html>
