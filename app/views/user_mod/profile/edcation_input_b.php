<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section ::::: 
$title='Education Management';			// Page Name and Page Title
$page="update_profile.php";		// PHP File Name
$input_page="edcation_input_b.php";
$root='profile';

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


            if($_FILES['att_file']['tmp_name']!=''){
			$file_name= $_FILES['att_file']['name'];
			$file_tmp= $_FILES['att_file']['tmp_name'];
			$ext=end(explode('.',$file_name));
			$path='../../../hrm_mod/pic/education/';
			move_uploaded_file($file_tmp, $path.$$unique.'.'.$ext);
			}
			
			
			
$_POST['PBI_ID']=$_SESSION['employee_selected'];
$_POST['PBI_ID']=$_SESSION['employee_selected'];
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

       if($_FILES['att_file']['tmp_name']!=''){
			$file_name= $_FILES['att_file']['name'];
			$file_tmp= $_FILES['att_file']['tmp_name'];
			$ext=end(explode('.',$file_name));
			$path='../../../hrm_mod/pic/education/';
			move_uploaded_file($file_tmp, $path.$$unique.'.'.$ext);
			}

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
<html style="height: 100%;"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        
        <link href="css.css" rel="stylesheet">
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
</head>
<body style="background:none !important">
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post" enctype="multipart/form-data"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; background:#3399CC; /* [disabled]left: 217.5px; */" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
          <? include('../../common/title_bar_popup.php');?>
          <div style="display: block; max-height: 464px; overflow-y: auto; width: auto; min-height: 82px; height: auto;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">

            <div style="width:100%" class="oe_popup_form">
              <div class="oe_formview oe_view oe_form_editable" style="opacity: 1;">
                <div class="oe_form_buttons"></div>
                <div class="oe_form_sidebar" style="display: none;"></div>
                <div class="oe_form_container">
                  <div class="oe_form">
                    <div class="" align="center">
                      <span class="oe_form_buttons_edit" style="display: inline;">
                         <button name="insert" accesskey="S" class="btn btn-primary" type="submit" style="height: 30px; width: 60px; background: coral;">Save</button>
                      </span>
                     <span class="oe_form_buttons_edit" style="display: inline;">
                         <button name="insertn" accesskey="S" class="btn btn-info" type="submit" style="height: 30px; width: 100px; background: coral;">Save &amp; New</button>
                      </span>
                     <span class="oe_form_buttons_edit" style="display: inline;">
                         <button name="update" accesskey="S" class="btn btn-warning" type="submit" style="height: 30px; width: 80px; background: coral;">Update</button>
                     </span>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="274" height="156" border="0" cellpadding="0" cellspacing="0" class="oe_form_group "><tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="19%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Name of Degree :</td>
                  <td bgcolor="#E8E8E8" width="29%" class="oe_form_group_cell">
					<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                    <input name="EDUCATION_NOE" id="EDUCATION_NOE" type="text" style="width:250px; height:30px;" class="form-control">
                        </td>
                  <td bgcolor="#E8E8E8" width="15%" class="oe_form_group_cell">&nbsp;&nbsp;Subject</td>
                  <td bgcolor="#E8E8E8" width="37%" class="oe_form_group_cell"><input name="EDUCATION_SUBJECT" type="text" style="width:250px; height:30px;" class="form-control">
				    </td>
                </tr>
                
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Year :</td>
                  <td class="oe_form_group_cell"><input name="EDUCATION_YEAR" style="width:250px; height:30px;" class="form-control">
                   </td>
                  <td class="oe_form_group_cell">&nbsp;</td>
                  <td class="oe_form_group_cell">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Board/University :</td>
                  <td class="oe_form_group_cell"><input type="text" class="form-control" name="EDUCATION_BU" id="EDUCATION_BU" style="width:250px; height:30px;">
	             </td>
                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Grade/Class:</span></td>
                  <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">
                    <input type="text" name="EDUCATION_GRADE_CLASS" style="width:250px; height:30px;" class="form-control">
                   
                  </span></td>
                </tr>
                
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Document Upload (Pdf) : </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input type="file" name="att_file" id="att_file" style="width:220px; height:35px; border-radius:5px;"></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">GPA :</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="EDUCATION_GPA" type="text" id="EDUCATION_GPA" value="<?=$EDUCATION_GPA?>" style="width:220px; height:35px; border-radius:5px;" /></td>
                </tr>
				

				<? if($EDUCATION_NOE!=''){?>
				 <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="4" class="oe_form_group_cell oe_form_group_cell_label"><object width="900" height="400" data="../../pic/education/<?=$$unique?>.pdf"></object></td>
                  </tr><? } ?>
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
