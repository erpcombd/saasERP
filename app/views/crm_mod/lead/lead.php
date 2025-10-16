<?php

session_start();

ob_start();

 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


do_datatable('example22');
// ::::: Edit This Section ::::: 

$title='Lead Information';			// Page Name and Page Title

$page="lead.php";		// PHP File Name

$input_page="lead_input.php";

$root='lead';





if(isset($_POST['insert'])){









}



$table='crm_lead_master';		// Database Table Name Mainly related to this page

$unique='lead_no';			// Primary Key of this Database table

$shown='lead_no';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::





$crud      =new crud($table);



echo $$unique = $_GET[$unique];

?>

<script type="text/javascript"> function DoNav(lk){



	return GB_show('ggg', '../../crm_mod/pages/<?=$root?>/lead_input.php?<?=$unique?>='+lk,600,940)

	}</script>

	

<style type="text/css">


#example th{
font-size:14px!important;
}
#example td{
font-size:14px!important;
}
#grp th {

    min-width: 100px!important;

	

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

<? $access = find_a_field('crm_roll_assign','lead_create','PBI_ID="'.$_SESSION['srrr'].'"') ;  ?>

    <? include('../../common/report_bar.php');?>
	


<div class="oe_form_sheetbg">

        <div class="">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">

		  

		  <? if($_SESSION['flash']){ ?>

		  <div class="alert alert-danger alert-dismissible">

    <button type="button" class="close" data-dismiss="alert">&times;</button>

    <strong>Sorry!</strong> <?=$_SESSION['flash']?>

  </div>

  <? unset($_SESSION['flash']); } ?>

  

  

  

          <?  $res='select a.lead_no,a.lead_title,(select PBI_NAME from personnel_basic_info where PBI_ID=a.PBI_ID) as sales_person,(select type from crm_type_of_lead where id=a.lead_type) as lead_type,(select PROJECT_DESC  from crm_project where PROJECT_ID=a.project_id) as project_id,a.lead_value,(select status from  crm_lead_status where id=a.lead_status) as lead_status,(select PBI_NAME from personnel_basic_info where PBI_ID=a.entry_by) as entry_by,a.entry_at from '.$table.' a where 1 ';



											//echo $crud->link_report($res,$link);?>

											

											

											

											<table id="example22" class="table table-bordered table-striped" style="width:100%">

        <thead style="background: #1ABB9C;">

            <tr><th>Lead ID</th><th>Title</th><th>Type</th><th>Company</th><th>Status</th><th>Total Communication</th><th>Sales Person</th><th>Entry At</th>
			<? 
			
			$access = find_a_field('crm_roll_assign','lead_edit','PBI_ID="'.$_SESSION['srrr'].'"') ; 
		
			
			?>
			
			<th>Action</th>
			
			
			</tr>

        </thead>

        <tbody>

           <?

		$query = db_query($res);

		while($rows = mysqli_fetch_object($query)){

		?>

		<tr>

		<td><?=$rows->lead_no?></td>

		<td><?=$rows->lead_title?></td>
		<td><?=$rows->lead_type?></td>
		<td><?=$rows->project_id?></td>
		<td><?=$rows->lead_status?></td>

		<td style="text-align:right;"><a href="../report/master_report.php?report=203&&lead_no=<?=$rows->lead_no?>" target="_blank" style="color: red; text-decoration: underline;"><button type="button" class="btn btn-xs btn-info"><?=find_a_field('crm_comunication','count(id)',' lead_no="'.$rows->lead_no.'"');?></button></a></td>

		<td><?=$rows->sales_person?></td>
		<td><?=$rows->entry_at?></td>


		<td> <button type="button" class="btn btn-warning btn-xs" onclick="DoNav(<?=$rows->lead_no?>);"><i class="fa fa-edit"></i></button></td>

		

		</tr>

		<? } ?>

        </tbody>

        <tfoot>

            <tr><th>Lead ID</th><th>Title</th><th>Type</th><th>Company</th><th>Status</th><th>Communication</th><th>Sales Person</th><th>Entry At</th>
			
			
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