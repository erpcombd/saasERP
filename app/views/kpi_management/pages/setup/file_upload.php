<?php
@session_start();
ob_start();
require_once "../../config/inc.all.php";
require "../../template/main_layout.php";

// ::::: Edit This Section ::::: 
$title='Welcome Image Uplaod';			// Page Name and Page Title
$page="file_upload.php";		// PHP File Name

$root='setup';

$table='welcome_file';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='att_file';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


// ::::: End Edit Section :::::


$crud      =new crud($table);

/*$$unique = $_GET[$unique];

$$unique = $_POST[$unique];

$prev_lv=mysql_num_rows(mysql_query("select * from hrm_leave_info where PBI_ID='".$_SESSION['employee_selected']."' and s_date='".$_REQUEST['s_date']."' and e_date='".$_REQUEST['e_date']."'"));


if(isset($_POST['insert'])||isset($_POST['insertn']) && $prev_lv>0)
{
$msggg= "<h2 style='color:#FF0000'>You Can't Add Same Leave Twice</h2>";

}else{		
$now				= time();

$target_dir = "../../../picture/leave_files/";
$target_file = $target_dir . $now.basename($_FILES["att_file"]["name"]);


//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];
$_REQUEST['entry_at'] = date('Y-m-d H:i:s');
$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));
$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));
$_REQUEST['leave_join_date']= date('Y-m-d',strtotime($_REQUEST['leave_join_date']));
//$_REQUEST['attachment_file']= $target_file;
$crud->insert();


move_uploaded_file($_FILES["att_file"]["tmp_name"], $target_file);

$type=1;
$msg='New Entry Successfully Inserted.';


unset($_POST);
unset($$unique);
echo '<script type="text/javascript">parent.parent.document.location.href = "../leave/view_leave.php?notify=12";</script>';

}*/


//for Modify..................................

if(isset($_POST['update']))
{
$crud->update($unique);
		$type=1;
}

//for Delete..................................

/*if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		echo '<script type="text/javascript">
parent.parent.document.location.href = "../inventory/home_leave.php?notify=12";
</script>';
		$type=1;
		$msg='Successfully Deleted.';
}*/

$$unique=$_SESSION['employee_selected'];
if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
<style type="text/css">
.MATERNITY_LEAVE{
display:none;
}

input[type="radio"], input[type="checkbox"] {
    line-height: normal;
    margin: 4px 0 0;
	width:20px;
}
.radio, .checkbox {
    min-height: 20px;
    padding-left: 20px;
}
.checkbox {
    margin-right: 4px !important;
}

.radio.inline, .checkbox.inline {
    display: inline-block;
    margin-bottom: 0;
    padding-top: 5px;
    vertical-align: middle;
}.radio.inline, .checkbox.inline {
    display: inline-block;
    margin-bottom: 0;
    padding-top: 5px;
    vertical-align: middle;
}
.radio.inline + .radio.inline, .checkbox.inline + .checkbox.inline {
    margin-left: 10px;
}
</style>
<script type="text/javascript">
$(document).ready(function(){

 $("#MATERNITY_LEAVE_LEVEL1").hide();
   $("#MATERNITY_LEAVE_INPUT1").hide();
 $('#leave_type').click(function(){
  var num =$("#leave_type").val();
   if(num=="MATERNITY"){
   $("#MATERNITY_LEAVE_LEVEL1").show();
   $("#MATERNITY_LEAVE_INPUT1").show();
    
   }
   else{
    $("#MATERNITY_LEAVE_LEVEL1").hide();
    $("#MATERNITY_LEAVE_INPUT1").hide();
     $("#materlan_count_level").hide();
   $("#materlan_count_input").hide();
   }
 });
 
 
  $('#MATERNITY_past').click(function(){
  var num =$("#MATERNITY_past").val();
   if(num=="yes"){
   $("#materlan_count_level").show();
   $("#materlan_count_input").show();
    
   }
   else{
    $("#materlan_count_level").hide();
   $("#materlan_count_input").hide();
   }
 });
 
  $("#materlan_count").change(function (){
    var materlan_count =  $("#materlan_count").val();
	
  if(materlan_count==2){
    alert("You are not Eligible for this Leave.");
	$('button[type="submit"]').attr('disabled','disabled');
  }else{
  $('button[type="submit"]').removeAttr('disabled');
  }
   
  });
   
 
    
    
  
});
 
</script>


<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->
          <div class="">
		  
		  
           
        <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Plain Page</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  
				  	 <div class="openerp openerp_webclient_container">
                    <table class="oe_webclient">
                    <tbody>
   
                      <tr>
			
				  
				  
                  <div class="x_content">




<form action="" method="post" enctype="multipart/form-data">
<div class="oe_view_manager oe_view_manager_current">

     
   
    <? include('../../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">

<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">
<?php echo $msggg; ?>
<table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td colspan="1" class="oe_form_group_cell" width="100%">
			
			<table width="100%" border="0" cellpadding="2" cellspacing="0" class="oe_form_group ">
              <tbody>
			   
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Upload :</td>
                  <td bgcolor="#E8E8E8" colspan="4" class="oe_form_group_cell">
				  <?
				 
				  ?>
				  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
				  <input name="att_file" type="file" id="att_file" value=""  style="width:420px;"/>                  </td>
                  </tr>
                
				  </tbody></table>
            </td>
            </tr>
			<tr><td><div align="center">

    <span class="oe_form_buttons_edit" style="display: inline;">
      <button name="update" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Update</button>
    </span>

			    </div></td></tr></tbody></table>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
  </div>
</form>
</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->



<?






include_once("../../template/footer.php");



?>
