<?php
session_start();
ob_start();
require_once "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Show User';			// Page Name and Page Title
$page="show_user.php";		// PHP File Name
$input_page="show_user_input.php";
$root='user';

$table='personnel_basic_info';		// Database Table Name Mainly related to this page
$unique='PBI_ID';			// Primary Key of this Database table
$shown='PBI_NAME';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::
$crud      =new crud($table);

$$unique = $_GET[$unique];

?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>

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
    <? include('../../common/report_bar.php');?>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
		 
		 <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
		
                
              <tr class="oe_form_group_row">
                
                    <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Department</span></td>
                  <td bgcolor="#E8E8E8" colspan="" class="oe_form_group_cell">
				 <select name="department">
                    <? foreign_relation('department','DEPT_ID','DEPT_DESC',$department,' 1 order by DEPT_DESC');?>
                    
                  </select>
				  </td>
				   <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Designation</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">
				  
				   <select name="designation">
                     <? foreign_relation('designation','DESG_ID','DESG_DESC',$designation,' 1 order by DESG_DESC');?>
                  </select>
				  
				  
				  </td>
				       <td bgcolor="#E8E8E8" class="oe_form_group_cell">
				     <input type="submit" value="Show" id="" name="view" style="background:#3079ed;color:#fff;" />
				  </td>
                </tr>
      
          </table>
		  <hr/>
		    
          <?
		    if($_POST['view']){
			     if($_POST['department']){
			       $department = $_POST['department'];
				   $con = ' and a.department='.$department;
			  }
			  if($_POST['designation']){
			   $designation = $_POST['designation'];
			    $con .= ' and a.designation='.$designation;
			   }
			
			}
		  
		   	$res='select a.'.$unique.',PBI_ID as USER_ID, PBI_NAME as Full_Name, PBI_EMAIL as Email,PBI_MOBILE as Mobile, b.DEPT_DESC as Department,c.DESG_DESC as Designation from '.$table.' a,department b,designation c where a.PBI_DEPARTMENT=b.DEPT_ID and a.PBI_DESIGNATION=c.DESG_ID order by PBI_ID ASC'.$con;
					//	echo $res;
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
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>