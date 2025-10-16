<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";
// ::::: Edit This Section ::::: 
$title='Shift & Schedule Setup Input';			// Page Name and Page Title
$page="schedule_type.php";		// PHP File Name
$input_page="schedule_type_input.php";
$root='setup';

$table='hrm_schedule_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='schedule_name';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

$crud      =new crud($table);
$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert']) || isset($_POST['insertn']))
{		

$now= time();
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
foreach($data as $key => $value)
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
<html style="height: 100%;">
<head>
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<link href="../../../../public/assets/css/css.css" rel="stylesheet">
<link href="../../../../public/assets/css/bootstrap.v4.4.1.min.css" type="text/css" rel="stylesheet"/>

<style>
.oe_form_sheet{
    padding: 0px !important;    
}

header{
    position: fixed  !important;
    width: 93%  !important;
    z-index: 9999 !important;
    text-align: center !important;
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

.tabs {
  max-width: 100%;
  margin: 0 auto;
}
#tab-button {
  display: table;
  table-layout: fixed;
  width: 100%;
  margin: 0;
  padding: 0;
  list-style: none;
}
ul li{
    border: 1px solid #999292;
}
#tab-button li {
  display: table-cell;
  width: 20%;
}
#tab-button li a {
  display: block;
  padding: .5em;
  background: #eee;
  border: 1px solid #ddd;
  text-align: center;
  color: #000;
  text-decoration: none;
}
#tab-button li:not(:first-child) a {
  border-left: none;
}
#tab-button li a:hover,
#tab-button .is-active a {
  border-bottom-color: transparent;
  background: #004d89;
  color: white;
}
.tab-contents {
  padding: .5em 2em 1em;
  border: 1px solid #ddd;
}



.tab-button-outer {
  display: none;
}
.tab-contents {
  margin-top: 20px;
}
.h2-new1{
    background-color: #6df662c7;
}
.h2-new2{
    background-color: #ecd84ccc;
}

.h2-new3{
    background-color: #ec984ccc;
}

.h2-new1, .h2-new2, .h2-new3{
    text-align: center;
    text-transform: uppercase;
    font-size: 18px;
    font-weight: 600;
    padding: 5px;
}

@media screen and (min-width: 768px) {
  .tab-button-outer {
    position: relative;
    z-index: 2;
    display: block;
  }
  .tab-select-outer {
    display: none;
  }
  .tab-contents {
    position: relative;
    top: -1px;
    margin-top: 0;
    padding: 10px;
  }
}

  table {
    border-collapse: collapse;
    width: 100%;
  }
  
  thead {
    font-weight: bold;
    background-color: #acc7df  !important;
}
  
  .form-control{
          height: 30px !important
  }
  
.oe_form td.oe_form_group_cell_label {
    border-right: 1px solid #5c5858;
    padding: 2px 0px;
}

.oe_form td.oe_form_group_cell + .oe_form_group_cell {
    padding: 2px 8px 2px 8px;
}

  th, td {
    border: 1px solid #817878;
       padding: 5px;
    text-align: center;
  }
  
  
  .ui-timepicker-wrapper {
	overflow-y: auto;
	max-height: 150px;
	width: 6.5em;
	background: #fff;
	border: 1px solid #ddd;
	-webkit-box-shadow:0 5px 10px rgba(0,0,0,0.2);
	-moz-box-shadow:0 5px 10px rgba(0,0,0,0.2);
	box-shadow:0 5px 10px rgba(0,0,0,0.2);
	outline: none;
	z-index: 10052;
	margin: 0;
}

.ui-timepicker-wrapper.ui-timepicker-with-duration {
	width: 13em;
}

.ui-timepicker-wrapper.ui-timepicker-with-duration.ui-timepicker-step-30,
.ui-timepicker-wrapper.ui-timepicker-with-duration.ui-timepicker-step-60 {
	width: 11em;
}

.ui-timepicker-list {
	margin: 0;
	padding: 0;
	list-style: none;
}

.ui-timepicker-duration {
	margin-left: 5px; color: #888;
}

.ui-timepicker-list:hover .ui-timepicker-duration {
	color: #888;
}

.ui-timepicker-list li {
	padding: 3px 0 3px 5px;
	cursor: pointer;
	white-space: nowrap;
	color: #000;
	list-style: none;
	margin: 0;
}

.ui-timepicker-list:hover .ui-timepicker-selected {
	background: #fff; color: #000;
}

li.ui-timepicker-selected,
.ui-timepicker-list li:hover,
.ui-timepicker-list .ui-timepicker-selected:hover {
	background: #1980EC; color: #fff;
}

li.ui-timepicker-selected .ui-timepicker-duration,
.ui-timepicker-list li:hover .ui-timepicker-duration {
	color: #ccc;
}

.ui-timepicker-list li.ui-timepicker-disabled,
.ui-timepicker-list li.ui-timepicker-disabled:hover,
.ui-timepicker-list li.ui-timepicker-selected.ui-timepicker-disabled {
	color: #888;
	cursor: default;
}

.ui-timepicker-list li.ui-timepicker-disabled:hover,
.ui-timepicker-list li.ui-timepicker-selected.ui-timepicker-disabled {
	background: #f2f2f2;
}
</style>
</head>

 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 <script src="timepicker.min.js"></script>
    
<body style=" background-color: #e6e6e600 !important; ">
<!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
<form action="" method="post">
  <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */ left: 16px; top: 21px;" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
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
                
                <div class="row m-0 p-0 pt-5">
                    <div class="col-sm-12 col-md-12 col-lg-12 p-0 pt-3">
                        <div class="tabs">
  <div class="tab-button-outer">
    <ul id="tab-button">
      <li><a href="#tab01">WORKING DAY</a></li>
  
    </ul>
  </div>
  <div class="tab-select-outer">
    <select id="tab-select">
      <option value="#tab01">WORKING DAY</option>
  
    </select>
  </div>

  <div id="tab01" class="tab-contents">
    <h2 class="h2-new1">WORKING DAY</h2>
                <div class="oe_form_sheetbg">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <table width="100%" class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr class="oe_form_group_row">
                          <td class="oe_form_group_cell">
                              <table width="100%" height="165" border="0" cellpadding="0" cellspacing="0" class="oe_form_group " style=" margin: 0px; ">
                              <tbody>
							  
							  
							  <tr class="oe_form_group_row">
							  
							      <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"></span> Concern  Name : </td>
                                  <td bgcolor="#E8E8E8" width="25%" class="oe_form_group_cell">
								  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" class="form-control"/>
								  
								  <select name="group_for" class="form-control" id="group_for" required>
                                      <? foreign_relation('user_group','id','group_name',$group_for);?>
                                    </select></td>
									
									
                                  <td bgcolor="#E8E8E8" width="32%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Status :</td>
                                  <td bgcolor="#E8E8E8" width="30%" class="oe_form_group_cell oe_form_group_cell_label"><select name="status" class="form-control">
                                      <option selected>
                                      <?=$status?>
                                      </option>
                                      <option>Enable</option>
                                      <option>Disable</option>
                                    </select>
                                  </td>
								  
                            
                                </tr>
								
	                      <tr class="oe_form_group_row">
								
                                  <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> Day Type :</span></td>
                                  <td bgcolor="#E8E8E8" width="25%" class="oe_form_group_cell">
								  
								   <select name="sch_type" class="form-control" id="sch_type" required>
                               
                                      <option value="Duty" <?=($sch_type=='Duty') ? 'selected' : '' ?>>Working Day</option>
                                    
                                    </select>
                                  </td>
								  
								  
                                  <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"> Shift Type : </span>  </td>
                                  <td bgcolor="#E8E8E8" width="25%" class="oe_form_group_cell"> 
                                  
                                  <select name="schedule_type" id="schedule_type" class="form-control">
                                            <option selected="selected">
                                            <?=$schedule_type?>
                                            </option>
                                            <option>Regular</option>
                                            <option>Roster</option>
                                          </select>
                                          
                                          </td>
                                </tr>
								
								
								
							  
                                <tr class="oe_form_group_row">
                                  <td bgcolor="#E8E8E8" width="32%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Shift  Name:</td>
                                  <td bgcolor="#E8E8E8" width="30%" class="oe_form_group_cell oe_form_group_cell_label">
                                    <input name="schedule_name" type="text" id="schedule_name" value="<?=$schedule_name?>" class="form-control"/>
                                  </td>
                                  <td bgcolor="#E8E8E8" width="32%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Acronyms :</td>
                                  <td bgcolor="#E8E8E8" width="30%" class="oe_form_group_cell oe_form_group_cell_label">
                                      <input name="acronyms" type="text" id="acronyms" value="<?=$acronyms?>"  class="form-control"/>
                                  </td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td bgcolor="#E8E8E8" width="32%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;  Shift Time  :</td>
                                  <td bgcolor="#E8E8E8" width="30%" class="oe_form_group_cell oe_form_group_cell_label">
                                      
                                      <input type="time" id="office_start_time" name="office_start_time" value="<?=$office_start_time?>" class="form-control">
                                  
                                  </td>
                                  <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; End Time :</span> </td>
                                  <td bgcolor="#E8E8E8" width="25%" class="oe_form_group_cell">
                                      
                                 <input type="time" id="office_end_time" name="office_end_time" value="<?=$office_end_time?>">
                                  
                                  </td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td bgcolor="#83B0DE" width="32%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Start Time  :</td>
                                  <td bgcolor="#83B0DE" width="30%" class="oe_form_group_cell oe_form_group_cell_label">
                                      
                                     <input type="time" id="shift_start_time" name="shift_start_time" value="<?=$shift_start_time?>" class="form-control">
                                      
                                      
                                  </td>
                                  <td bgcolor="#83B0DE" width="23%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Last Time :</span> </td>
                                  <td bgcolor="#83B0DE" width="25%" class="oe_form_group_cell">
                                       <input type="time" id="shift_last_time" name="shift_last_time" value="<?=$shift_last_time?>"class="form-control">
                                      
                                     
                                  </td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td bgcolor="#E8E8E8" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"> Early In Hour :</td>
                                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input name="min_in" type="text" id="min_in" value="<?=$min_in?>" class="form-control"/></td>
                                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"> Max Out Hour : </td>
                                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="max_out" type="text" id="max_out" value="<?=$max_out?>" class="form-control"/></td>
                                </tr>
                                
                                <tr class="oe_form_group_row">
                                  <td bgcolor="#E8E8E8" width="32%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Break Start : </td>
                                  <td bgcolor="#E8E8E8" width="30%" class="oe_form_group_cell oe_form_group_cell_label">
                                      
                                       <input type="time" id="office_mid_time" name="office_mid_time" value="<?=$office_mid_time?>" class="form-control">
                                      
                                   
                                  </td>
                                  <td bgcolor="#E8E8E8" width="32%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Break End : </td>
                                  <td bgcolor="#E8E8E8" width="30%" class="oe_form_group_cell oe_form_group_cell_label">
                                      
                                      <input type="time" id="office_mid_time2" name="office_mid_time2" value="<?=$office_mid_time2?>" class="form-control">
                                  
                                  </td>
                                </tr>
								
								
                                <tr class="oe_form_group_row">
								
                  <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">In Grace Time : </span></td>
                                  <td bgcolor="#E8E8E8" width="25%" class="oe_form_group_cell">
                                      
							   <input type="text" id="timeInput" name="in_grace_time" value="<?=$in_grace_time?>"  class="form-control" placeholder="hh:mm">
								  
				
								  
								  </td>
            <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"></span> Early Out Grace Time : </td>
                                  <td bgcolor="#E8E8E8" width="25%" class="oe_form_group_cell">
							
								    <input type="text" id="grace_time" name="grace_time" value="<?=$grace_time?>"  class="form-control" placeholder="hh:mm">
								
								</td>
                                </tr>
               
                              </tbody>
                            </table>
                      
                            </td>
                        </tr>
                      </tbody>
                    </table>
                    <br>
                    <br>
                    
                    <table class="table table-bordered table-sm" align="center">
                      <thead>
                        <tr>
                          <th colspan="2">1st Quater</th>
                          <th colspan="2">2nd Quater</th>
        
                        </tr>
						
						  <tr>
							<td>In Time</td>
							<td>Out Time</td>
							
							<td>In Time</td>
							<td>Out Time</td>
							
							
						  </tr>
  
  
                      </thead>
                      <tbody>
                        <tr>
                        
                          <td><input type="time" id="quater1_in" name="quater1_in" value="<?=$quater1_in?>"></td>
                          <td><input type="time" id="quater1_out" name="quater1_out" value="<?=$quater1_out?>" ></td>
                          
                          <td><input type="time" id="quater2_in" name="quater2_in" value="<?=$quater2_in?>"></td>
                          <td><input type="time" id="quater2_out" name="quater2_out" value="<?=$quater2_out?>"></td>
                          
                         
                        </tr>
                        
                        
                       
                      </tbody>
                    </table>
                  
                  <br>

                    <table class="table table-bordered table-sm" align="center">
                      <thead>
                        <tr>
                         
                          <th colspan="2">3rd Quater</th>
                          <th colspan="2">4th Quater</th>
						 
                        </tr>
						
						  <tr>
						
							
							<td>In Time</td>
							<td>Out Time</td>
							
							<td>In Time</td>
							<td>Out Time</td>
							
						
						  </tr>
  
  
                      </thead>
                      <tbody>
                        <tr>
                        
                         
                          
                          <td><input type="time" id="quater3_in" name="quater3_in" value="<?=$quater3_in?>"></td>
                          <td><input type="time" id="quater3_out" name="quater3_out" value="<?=$quater3_out?>"></td>
                          
                          <td><input type="time" id="quater4_in" name="quater4_in" value="<?=$quater4_in?>"></td>
                          <td><input type="time" id="quater4_out" name="quater4_out" value="<?=$quater4_out?>"></td>
                          
                          
                        </tr>
                        
                        
                       
                      </tbody>
                    </table>
                                    
                  <br>

                    <table class="table table-bordered table-sm" align="center">
                      <thead>
                        <tr>
                         
						  <th colspan="2">1st Half</th>
                          <th colspan="2">2nd Half</th>
                        </tr>
						
						  <tr>
							
							
							<td>In Time</td>
							<td>Out Time</td>
							
							<td>In Time</td>
							<td>Out Time</td>
						  </tr>
  
  
                      </thead>
                      <tbody>
                        <tr>
                        
                        
                          
                          <td><input type="time" id="frist_half_in" name="frist_half_in" value="<?=$frist_half_in?>"></td>
                          <td><input type="time" id="frist_half_out" name="frist_half_out" value="<?=$frist_half_out?>"></td>
                          
                          <td><input type="time" id="sec_half_in" name="sec_half_in" value="<?=$sec_half_in?>"></td>
                          <td><input type="time" id="sec_half_out" name="sec_half_out" value="<?=$sec_half_out?>"></td>
                        
                        </tr>
                        
                        
                       
                      </tbody>
                    </table>
                  
                  
                  
                  
                  
                  
                  </div>
                </div>
  </div>
  
  
  
  
  
  














</div>
                        
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
    <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix"> </div>
  </div>
</form>

<script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../../assets/js/popper.min.js"></script>

   <script>
        $(document).ready(function(){
            $('#timeInput').timepicker({
                timeFormat: 'H:i',
                step: 1,
                scrollDefault: 'now'
            });
        });
    </script>
    
      <script>
        $(document).ready(function(){
            $('#grace_time').timepicker({
                timeFormat: 'H:i',
                step: 1,
                scrollDefault: 'now'
            });
        });
    </script>
	
	
     <script>
        $(document).ready(function(){
            $('#weekly_grace_in').timepicker({
                timeFormat: 'H:i',
                step: 1,
                scrollDefault: 'now'
            });
        });
    </script>  
	
	
	   <script>
        $(document).ready(function(){
            $('#weekly_grace_out').timepicker({
                timeFormat: 'H:i',
                step: 1,
                scrollDefault: 'now'
            });
        });
    </script> 
	
	
	  <script>
        $(document).ready(function(){
            $('#dayoff_grace_in').timepicker({
                timeFormat: 'H:i',
                step: 1,
                scrollDefault: 'now'
            });
        });
    </script> 
	
	
	  <script>
        $(document).ready(function(){
            $('#dayoff_grace_out').timepicker({
                timeFormat: 'H:i',
                step: 1,
                scrollDefault: 'now'
            });
        });
    </script> 
	
		  <script>
        $(document).ready(function(){
            $('#holiday_grace_in').timepicker({
                timeFormat: 'H:i',
                step: 1,
                scrollDefault: 'now'
            });
        });
    </script> 
	
	
			  <script>
        $(document).ready(function(){
            $('#holiday_grace_out').timepicker({
                timeFormat: 'H:i',
                step: 1,
                scrollDefault: 'now'
            });
        });
    </script> 
    

<script>
    $(function() {
  var $tabButtonItem = $('#tab-button li'),
      $tabSelect = $('#tab-select'),
      $tabContents = $('.tab-contents'),
      activeClass = 'is-active';

  $tabButtonItem.first().addClass(activeClass);
  $tabContents.not(':first').hide();

  $tabButtonItem.find('a').on('click', function(e) {
    var target = $(this).attr('href');

    $tabButtonItem.removeClass(activeClass);
    $(this).parent().addClass(activeClass);
    $tabSelect.val(target);
    $tabContents.hide();
    $(target).show();
    e.preventDefault();
  });

  $tabSelect.on('change', function() {
    var target = $(this).val(),
        targetSelectNum = $(this).prop('selectedIndex');

    $tabButtonItem.removeClass(activeClass);
    $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
    $tabContents.hide();
    $(target).show();
  });
});
</script>
</body>
</html>
