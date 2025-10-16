
<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

// ::::: Edit This Section ::::: 
$title='Letter Of Credit (LC)';			// Page Name and Page Title
$page="createLc.php";					// PHP File Name
$input_page="createLc_input.php";
$root='lc';

$table='xlc_lc_details';		// Database Table Name Mainly related to this page
$unique='id';					// Primary Key of this Database table
$shown='pi_id';					// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

$lc_id = $_SESSION['lc_id'];
$lc = find_all_field('xlc_lc_master','','id='.$lc_id);
//var_dump($lc);
$crud      =new crud($table);

$$unique = $_GET[$unique];

if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		
$now				= time();
$crud->insert();
$pi_id = $_POST['pi_id'];
$sql = 'update xlc_pi_master set under_lc ='.$lc_id.' where id ='.$pi_id;
db_query($sql);

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
	   $npi_id = $_POST['pi_id'];

db_query('update xlc_pi_master set under_lc ='.$lc_id.' where id ='.$npi_id);


		$type=1;
		$msg='Successfully Updated.';
echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/'.$page.'";</script>';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;	
		$crud->delete($condition);
		$sql = 'update xlc_pi_master set under_lc =0 where id ='.$pi_id.'and under_lc='.$lc_id;
//echo $sql;
db_query($sql);
  //   echo $condition;
		unset($$unique);
		echo '<script type="text/javascript"> parent.parent.document.location.href = "../'.$root.'/'.$page.'";  </script>';   
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
		
		
		
<script>
$(document).ready(function(){

})
</script>


      <form action="" method="post" enctype="multipart/form-data" name="cloud" id="cloud"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
             <? include('../../common/title/title_bar_popup.php');?>
          <div style="display: block; max-height: 464px; overflow-y: auto; width: auto; min-height: 82px; height: auto;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">

            <div style="width:100%" class="oe_popup_form">
              <div class="oe_formview oe_view oe_form_editable" style="opacity: 1;">
                <div class="oe_form_buttons"></div>
                <div class="oe_form_sidebar" style="display: none;"></div>
                <div class="oe_form_container">
                  <div class="oe_form">
                    <div class="">
               <? include('../../common/title/input_bar.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
	
    </label>
          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="274" border="0" cellpadding="0" cellspacing="0" class="oe_form_group "><tbody>
             <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" width="24%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Select PI: </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">
				      			  
				      <input name="lc_id" id="lc_id" value="<?php echo $_SESSION['lc_id'];?>" type="hidden" />
                   <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                   <select name="pi_id" id="pi_id" style="width:500px;">
<?php  
if($pi_id>0)
foreign_relation('xlc_pi_master','id','id',$pi_id,' party_id="'.$lc->party_id.'"');
else
foreign_relation('xlc_pi_master','id','id',$pi_id,'under_lc=0 and party_id="'.$lc->party_id.'"');?>
                   </select>                   <span class="oe_form_group_cell oe_form_group_cell_label"> </span>				   			  </td>
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
