<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 
$title='Leave Type';			// Page Name and Page Title
$page="leave_type.php";		// PHP File Name
$input_page="leave_type_input.php";
$root='setup';
$link="leave_type_input.php";

$table='hrm_leave_type';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='leave_type_name';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];
do_datatable('grp');

?>
<script type="text/javascript"> function DoNav(lk){

	return GB_show(' ', '<?=SERVER_ROOT?>app/views/hrm_mod/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)

	}</script>
	
	
	
	
	
	




    <form  action="" method="post" enctype="multipart/form-data">
       
        <? include('../common/report_bar.php');?>
        <div class="container-fluid pt-5 p-0 ">
				 <? 	 $res='select '.$unique.',leave_type_name as Leave_Type, yearly_leave_days as total_days from '.$table;
											echo link_report1($res,$link);?>
            

        </div>

    </form>
	
	
	
	
	
	
	
	<?php /*?><div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->
          <div class="">
		  
		  
           
        <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
				  
				  	 <div class="openerp openerp_webclient_container">
                    <table class="oe_webclient">
                    <tbody>
   
                      <tr>
			
				  
				  
                  <div class="x_content">
	
	

<form action="" method="post">
<div class="oe_view_manager oe_view_manager_current">
        

        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
    <? include('../common/report_bar.php');?>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
          <? 	 $res='select '.$unique.',leave_type_name as Leave_Type, yearly_leave_days as total_days from '.$table;
											echo $crud->link_report($res,$link);?>
          </div></div>
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
        </div><?php */?>
        <!-- /page content -->



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>