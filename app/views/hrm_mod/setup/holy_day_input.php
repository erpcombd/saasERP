<?php



session_start();








require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







// ::::: Edit This Section ::::: 



$title='Holiday Information';			// Page Name and Page Title



$page="holy_day.php";		// PHP File Name



$input_page="holy_day_input.php";



$root='setup';







$table='salary_holy_day';		// Database Table Name Mainly related to this page



$unique='id';			// Primary Key of this Database table



$shown='holy_day';					// For a New or Edit Data a must have data field







// ::::: End Edit Section :::::











$crud      =new crud($table);







$$unique = $_GET[$unique];



if(isset($_POST[$shown]))



{



$$unique = $_POST[$unique];







if(isset($_POST['insert'])||isset($_POST['insertn']))



{		



//$now				= time();



$start_d=strtotime($_POST['holy_day']);

$end_d=strtotime($_POST['holy_day2']);



for($i=$start_d; $i<=$end_d; $i+=86400){

 echo $_POST['holy_day']=date('Y-m-d',$i);

//$crud->insert();

$ins_query='INSERT INTO salary_holy_day( holy_day, reason,job_loc_id) VALUES ( "'.$_POST['holy_day'].'", "'.$_POST['reason'].'" ,3)';

db_query($ins_query);

}



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



foreach($data as $key => $value)



{ $$key=$value;}



}



if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);



?>



<html style="height: 100%;"><head>



        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">



        <meta content="text/html; charset=UTF-8" http-equiv="content-type">



        <link href="../../../../public/assets/css/css.css" rel="stylesheet">



        <script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>



<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>



<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>



        <? do_calander('#holy_day');?>

		<? do_calander('#holy_day2');?>



        </head>



<body>



        <!--[if lte IE 8]>



        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>



        <script>CFInstall.check({mode: "overlay"});</script>



        <![endif]-->



       <form action="" method="post"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */ left: 16px; top: 21px;" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">



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



          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">



            <td class="oe_form_group_cell"><table width="350" height="132" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">



              <tbody>



                <tr class="oe_form_group_row">



                  <td bgcolor="#E8E8E8" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Holiday from Date :</td>



                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">
				  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />



                    <input name="holy_day" type="date" id="holy_day" value="<?=$holy_day?>" /></td>

                </tr>

				<? if($_GET[$unique]<1){?>

                <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Holiday to Date :</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input name="holy_day2" type="date" id="holy_day2" value="<?=$holy_day2?>" /></td>

                </tr>

				<? }?>



                <tr class="oe_form_group_row">



                  <td width="45%" height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Name of the Occasion :</td>



                  <td width="55%" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">



                  



                  <input name="reason" type="text" id="reason" value="<?=$reason?>" />                  </td>

                </tr>

				

				<?php /*?><tr class="oe_form_group_row">



                  <td width="45%" height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Name of  Concern :</td>



                  <td width="55%" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">

                  

				  <select name="cid">

				  <option value="0">all</option>

				 <? foreign_relation('user_group','id','group_name',$cid,' 1');?>

				  </select>

				  </td>

                </tr><?php */?>

				

				

				

				

				

				

				<tr class="oe_form_group_row">



                  <td height="33" colspan="2" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



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



