<?php
//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Education Management';			// Page Name and Page Title
$page="edcation.php";		// PHP File Name
$input_page="edcation_input.php";
$root='hrm';

$table='education_detail';		// Database Table Name Mainly related to this page
$unique='EDUCATION_D_ID';			// Primary Key of this Database table
$shown='EDUCATION_NOE';				// For a New or Edit Data a must have data field

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

$vars['PBI_EDU_QUALIFICATION']=$_POST['EDUCATION_NOE'];
db_update('personnel_basic_info', $_POST['PBI_ID'], $vars, 'PBI_ID');

$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';

if(isset($_POST['insert']))
{
echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/'.$page.'";</script>';
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
		echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/'.$page.'";</script>';
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
            <td class="oe_form_group_cell"><table width="274" height="156" border="0" cellpadding="0" cellspacing="0" class="oe_form_group "><tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="19%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Name of Exam :</td>
                  <td bgcolor="#E8E8E8" width="29%" class="oe_form_group_cell">
					<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <select name="EDUCATION_NOE">
                    <? foreign_relation('edu_qua','EDU_QUA_DESC','EDU_QUA_DESC',$EDUCATION_NOE);?>
                     
                    </select></td>
                  <td bgcolor="#E8E8E8" width="15%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Year :</span></td>
                  <td bgcolor="#E8E8E8" width="37%" class="oe_form_group_cell"><select name="EDUCATION_YEAR">
                    <option selected>
                      <?=$EDUCATION_YEAR?>
                      </option>
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
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Subject :</label></td>
                  <td class="oe_form_group_cell"><select name="EDUCATION_SUBJECT">
                    <? foreign_relation('edu_subject','SUBJECT_NAME','SUBJECT_NAME',$EDUCATION_SUBJECT);?>
                  </select></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Group :</span></td>
                  <td class="oe_form_group_cell"><select name="EDUCATION_GROUP">
                    <option selected>
                      <?=$EDUCATION_GROUP?>
                      </option>
                    <option>Arts</option>
                    <option>Science</option>
                    <option>Commerce</option>
                    <option>Humanetics</option>
                    <option>Engineering</option>
                    <option>Medical</option>
                    <option>General</option>
                    <option>Vocational</option>
                    <option>Business Management</option>
                  </select></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Name of Institute :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">
                  <input name="EDUCATION_NOI" type="text" id="EDUCATION_NOI" value="<?=$EDUCATION_NOI?>" />
                  </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Thesis Topic :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="EDUCATION_THESIS_TOPIC" type="text" id="EDUCATION_THESIS_TOPIC" value="<?=$EDUCATION_THESIS_TOPIC?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Board/University :</td>
                  <td class="oe_form_group_cell"><select name="EDUCATION_BU">
                    <? foreign_relation('university','UNIVERSITY_NAME','UNIVERSITY_NAME',$EDUCATION_BU);?>
                  </select></td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Total Marks :</span></td>
                  <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                    <input name="EDUCATION_TOTAL_MARK" type="text" id="EDUCATION_TOTAL_MARK" value="<?=$EDUCATION_TOTAL_MARK?>" />
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Grade/Class :</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="EDUCATION_GRADE_CLASS">
                   <option selected><?=$EDUCATION_GRADE_CLASS?></option>
						<option>A+</option>
						<option>A</option>
                        <option>A-</option>
						<option>B+</option>
                        <option>B</option>
						<option>B-</option>
                        <option>C+</option>
                        <option>C</option>
                        <option>C-</option>
                        <option>D</option>
                        <option>F</option>
                        <option>1st Division</option>
                        <option>2nd Division</option>
                        <option>3rd Division</option>
                        <option>1st Class</option>
                        <option>2nd Class</option>
                        <option>3rd Class</option>
                  </select></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">GPA :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="EDUCATION_GPA" type="text" id="EDUCATION_GPA" value="<?=$EDUCATION_GPA?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="2" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Document :</span></td>
                  <td class="oe_form_group_cell"><span class="EDUCATION_DOCUMENT">
                    <select name="EDUCATION_DOCUMENT">
                      <option selected>
                        <?=$EDUCATION_DOCUMENT?>
                        </option>
                      <option>Yes</option>
                      <option>No</option>
                    </select>
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="4" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
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
