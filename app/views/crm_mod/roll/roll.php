<?php

session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 

$title='Roll Assign Information';			// Page Name and Page Title

$page="roll.php";		// PHP File Name

$input_page="roll_input.php";

$root='roll';





if(isset($_POST['insert'])){









}



$table='crm_roll_assign';		// Database Table Name Mainly related to this page

$unique='PBI_ID';			// Primary Key of this Database table

$shown='PBI_ID';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::





$crud      =new crud($table);



$$unique = $_GET[$unique];

?>

<script type="text/javascript"> function DoNav(lk){



	return GB_show('ggg', '../../crm_mod/pages/<?=$root?>/roll_input.php?<?=$unique?>='+lk,600,940)

	}</script>

	

<style type="text/css">



#grp th {

    min-width: 150px;

	

	}



</style>

	



<form action="" method="post">

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

    <? //include('../../common/report_bar.php');?>

<div class="oe_form_sheetbg">

        <div class="">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">

		  

		  <? if($_SESSION['flash']){ ?>

		  <div class="alert alert-danger alert-dismissible">

    <button type="button" class="close" data-dismiss="alert">&times;</button>

    <strong>Sorry!</strong> <?=$_SESSION['flash']?>

  </div>

  <? unset($_SESSION['flash']); } ?>

  

  

  

          <? 	 $res='select PBI_ID, PBI_CODE, PBI_NAME from personnel_basic_info where PBI_JOB_STATUS="In Service" ';



											//echo $crud->link_report($res,$link);?>

											

											

											

								<table id="example" class="display nowrap table" style="width:100%">

        <thead style="background: #1ABB9C;">

            <tr><th>ID</th><th>Employee</th><th>Department</th><th>Roll</th><th>Setup</th><th>Customer</th><th>Com</th><th>Lead</th><th>Report</th><th>Dashboard</th>
			
			<? 
			
			$access = find_a_field('crm_roll_assign','roll_edit','PBI_ID="'.$_SESSION['srrr'].'"') ; 
		
			
			?>
			
			<th>Action</th></tr>

        </thead>

        <tbody>

           <?

		$query = db_query($res);

		while($rows = mysqli_fetch_object($query)){

$sselect = 'select * from crm_roll_assign where PBI_ID="'.$rows->PBI_ID.'"';

$squery = db_query($sselect);
$rowss = mysqli_fetch_object($squery);


		?>

		<tr>

		<td><?=$rows->PBI_CODE?></td>
		<td><?=$rows->PBI_NAME?></td>
		<td><?=find_a_field('personnel_basic_info p,department d','d.DEPT_DESC','p.PBI_DEPARTMENT=d.DEPT_ID and PBI_ID='.$rows->PBI_ID)?></td>
		
		<td><? if($rowss->roll_panel==1){ echo "Y" ;}else{ echo "N" ;};?></td>
		<td><? if($rowss->setup_panel==1){ echo "Y" ;}else{ echo "N" ;};?> </td>
		<td><? if($rowss->customer_panel==1){ echo "Y" ;}else{ echo "N" ;};?></td>

		<td><? if($rowss->comm_panel==1){ echo "Y" ;}else{ echo "N" ;};?></td>

		<td><? if($rowss->lead_panel==1){ echo "Y" ;}else{ echo "N" ;}; ?></td>

		<td style="font-size: 12px;"><? if($rowss->report_panel==1){ echo "Y" ;}else{ echo "N" ;}; ?></td>
		<td style="font-size: 12px;"><? if($rowss->dashboard_panel==1){ echo "Y" ;}else{ echo "N" ;}; ?></td>

		<td> <button type="button" class="btn btn-warning btn-xs" onclick="DoNav(<?=$rows->PBI_ID?>);"><i class="fa fa-edit"></i></button></td>

		

		</tr>

		<? } ?>

        </tbody>

        <tfoot>

            <tr><th>ID</th><th>Employee</th><th>Department</th><th>Roll</th><th>Setup</th><th>Customer</th><th>Com</th><th>Lead</th><th>Report</th><th>Dashboard</th>
			
			<th>Action</th>
			
		
			
			</tr>

        </tfoot>

    </table>			

											

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

require_once SERVER_CORE."routing/layout.bottom.php";

?>