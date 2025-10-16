<?php
session_start();

require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Leave Input Management';			// Page Name and Page Title
$page="leave.php";		// PHP File Name
$input_page="leave_input.php";
$root='hrm';

$table='leave_detail';		// Database Table Name Mainly related to this page
$unique='LEAVE_D_ID';			// Primary Key of this Database table
$shown='LEAVE_YEAR';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


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
while (list($key, $value)=each($data))
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
<html style="height: 100%;"><head>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <link href="../../css/css.css" rel="stylesheet">
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
</head>
<body>
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post" enctype="multipart/form-data"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
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
            <td colspan="1" class="oe_form_group_cell" width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="24%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Year :</td>
                  <td bgcolor="#E8E8E8" colspan="5" class="oe_form_group_cell">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <select name="LEAVE_YEAR">
                      <option selected><?=$LEAVE_YEAR?></option>
                            <option>1950</option>
                        <option>1951</option>
                        <option>1952</option>
                        <option>1953</option>
                        <option>1954</option>
                        <option>1955</option>
                        <option>1956</option>
                        <option>1957</option>
                        <option>1958</option>
                        <option>1959</option>
                        <option>1960</option>
                        <option>1961</option>
                        <option>1962</option>
                        <option>1963</option>
                        <option>1964</option>
                        <option>1965</option>
                        <option>1966</option>
                        <option>1967</option>
                        <option>1968</option>
                        <option>1969</option>
                        <option>1970</option>
                        <option>1971</option>
                        <option>1972</option>
                        <option>1973</option>
                        <option>1974</option>
                        <option>1975</option>
                        <option>1976</option>
                        <option>1977</option>
                        <option>1978</option>
                        <option>1979</option>
                        <option>1980</option>
                        <option>1981</option>
                        <option>1982</option>
                        <option>1983</option>
                        <option>1984</option>
                        <option>1985</option>
                        <option>1986</option>
                        <option>1987</option>
                        <option>1988</option>
                        <option>1989</option>
                        <option>1990</option>
                        <option>1991</option>
                        <option>1992</option>
                        <option>1993</option>
                        <option>1994</option>
                        <option>1995</option>
                        <option>1996</option>
                        <option>1997</option>
                        <option>1998</option>                     
                        <option>1999</option>
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
                        <option>2017</option>
                        <option>2018</option>
                        <option>2019</option>
                        <option>2020</option>
                    </select></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Casual Leave(CL):</label></td>
                  <td width="19%" class="oe_form_group_cell"><input name="LEAVE_CL" type="text" id="LEAVE_CL" value="<?=$LEAVE_CL?>" /></td>
                  
                  <td width="13%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Leave Avail :</span></td>
                  <td width="19%" class="oe_form_group_cell"><input name="LEAVE_CL_AVAIL" type="text" id="LEAVE_CL_AVAIL" value="<?=$LEAVE_CL_AVAIL?>" /></td>
                  
                  <td width="6%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Due :</span></td>
                  <td width="19%" class="oe_form_group_cell"><input name="LEAVE_CL_DUE" type="text" id="LEAVE_CL_DUE" value="<?=$LEAVE_CL_DUE?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Medical Leavel :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="LEAVE_ML" type="text" id="LEAVE_ML" value="<?=$LEAVE_ML?>" /></td>
                  
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Leave Avail :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="LEAVE_ML_AVAIL" type="text" id="LEAVE_ML_AVAIL" value="<?=$LEAVE_ML_AVAIL?>" /></td>
                  
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Due :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="LEAVE_ML_DUE" type="text" id="LEAVE_ML_DUE" value="<?=$LEAVE_ML_DUE?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td class="oe_form_group_cell">&nbsp;</td>
                  <td colspan="4" rowspan="6" class="oe_form_group_cell">&nbsp;</td>
                  </tr>

                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Meternity Leave :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="LEAVE_MATERNITY" type="text" id="LEAVE_MATERNITY" value="<?=$LEAVE_MATERNITY?>" /></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Paternity Leave :</td>
                  <td class="oe_form_group_cell"><input name="LEAVE_PATERNITY" type="text" id="LEAVE_PATERNITY" value="<?=$LEAVE_PATERNITY?>" /></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Transfer Leave : </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="LEAVE_TRANSFER" type="text" id="LEAVE_TRANSFER" value="<?=$LEAVE_TRANSFER?>" /></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Leave without pay (LWP):</td>
                  <td class="oe_form_group_cell"><input name="LEAVE_LWP" type="text" id="LEAVE_LWP" value="<?=$LEAVE_LWP?>" /></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                  </tr>
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
