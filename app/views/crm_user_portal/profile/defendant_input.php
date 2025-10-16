<?php

//



require "../../support/inc.all.php";



// ::::: Edit This Section ::::: 

$title='Dependant Management';			// Page Name and Page Title

$page="update_profile.php";		// PHP File Name

$input_page="defendant_input.php";

$root='profile';



$table='defendant_info';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='name';				// For a New or Edit Data a must have data field



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

			$path='../../../hrm_mod/pic/experience/';

			move_uploaded_file($file_tmp, $path.$$unique.'.'.$ext);

			}

			



$_POST['PBI_ID']=$_SESSION['employee_selected'];



 $date1=date_create($_POST['EXPERIENCE_FROM']);

 

 if($_POST['EXPERIENCE_TO']=='0000-00-00'){

  $date2 = date_create(date('Y-m-d'));

 }else{

    $date2=date_create($_POST['EXPERIENCE_TO']);

 }

 

 $diff=date_diff($date1,$date2);



$_POST['EXPERIENCE_LENGTH']=$diff->format("%a");

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

			$path='../../../hrm_mod/pic/experience/';

			move_uploaded_file($file_tmp, $path.$$unique.'.'.$ext);

			}



 $date1=date_create($_POST['EXPERIENCE_FROM']);

 

 if($_POST['EXPERIENCE_TO']=='0000-00-00'){

  $date2 = date_create(date('Y-m-d'));

 }else{

    $date2=date_create($_POST['EXPERIENCE_TO']);

 }

 

 $diff=date_diff($date1,$date2);



$_POST['EXPERIENCE_LENGTH']=$diff->format("%a");

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

<link href="../../css/css.css" rel="stylesheet">

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>

<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>

<? do_calander('#EXPERIENCE_FROM');?><? do_calander('#EXPERIENCE_TO');?>

</head>

<body style="background:none !important">



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

        <td class="oe_form_group_cell"><table width="282" height="109" border="0" cellpadding="0" cellspacing="0" class="oe_form_group "><tbody>

                <tr class="oe_form_group_row">

         <td bgcolor="#E8E8E8" width="38%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Name :</td>

                  <td bgcolor="#E8E8E8" width="31%" colspan="1" class="oe_form_group_cell">

                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                    <input name="name" type="text" id="name" value="<?=$name?>" style="width:250px; height:30px;" /></td>

                  <td bgcolor="#E8E8E8" width="31%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Relation :</span></td>

                  <td bgcolor="#E8E8E8" width="62%" class="oe_form_group_cell"><input type="text" name="relation" id="relation" value="<?=$relation?>" style="width:250px; height:30px;" />

                    </td>

                </tr>

                <tr class="oe_form_group_row">

                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp;&nbsp;Date of birth :</label></td>

                  <td class="oe_form_group_cell"><input name="date_of_birth" type="date" id="date_of_birth" value="<?=$date_of_birth?>" style="width:250px; height:30px;"  /></td>

                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">NID :</span></td>

                  <td class="oe_form_group_cell"><span class="oe_form_field oe_datepicker_root oe_form_field_date">

                    <input name="nid" type="text" id="nid" value="<?=$nid?>" style="width:250px; height:30px;"  />

                  </span></td>

                </tr>

                <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Blood Group :</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="blood_group" type="text" id="blood_group" value="<?=$blood_group?>" style="width:250px; height:30px;"  /></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Gender</span></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="gender" id="gender" style="width:250px; height:30px;">
				  <option></option>
				  <option <?=($gender=='Male')? 'selected' : ''?>>Male</option>
				  <option <?=($gender=='Female')? 'selected' : ''?>>Female</option>
				  
				  </select></td>

                </tr>
				
				
				
				

                </tbody></table>

              </td>

            </tr>

			  

			 

			

			

			</tbody></table>

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

