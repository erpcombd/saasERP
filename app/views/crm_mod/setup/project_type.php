<?php


 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
 


// ::::: Edit This Section ::::: 
$title='Customer Information';			// Page Name and Page Title
$page="project_type.php";		// PHP File Name
$input_page="project_type_input.php";
$root='setup';

$table='crm_customer_info';		// Database Table Name Mainly related to this page
$unique='dealer_code';			// Primary Key of this Database table
$shown='dealer_name_e';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::





if(isset($_POST['insert'])){


}



$table='crm_customer_info';		// Database Table Name Mainly related to this page

$unique='dealer_code';			// Primary Key of this Database table

$shown='dealer_name_e';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::





$crud      =new crud($table);



echo $$unique = $_GET[$unique];

?>

<script type="text/javascript"> function DoNav(lk){



	return GB_show('ggg', '../../crm_mod/pages/<?=$root?>/project_type_input.php?<?=$unique?>='+lk,600,940)

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
		  <? $access = find_a_field('crm_roll_assign','customer_create','PBI_ID="'.$_SESSION['srrr'].'"') ; ?>

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

  

  

  

          <?  $res='select '.$unique.','.$unique.' as customer_id, '.$shown.',organization,mobile_no,designation,email from '.$table.' where entry_by="'.$_SESSION['employee_selected'].'"';



											//echo $crud->link_report($res,$link);?>

											

											

											

								<table id="example" class="table table-bordered table-striped" style="width:100%">

        <thead style="background: #1ABB9C;">

            <tr><th>Customer ID</th><th>Organization</th><th>Mobile</th><th>Designation</th><th>Email</th><th>Action</th></tr>

        </thead>

        <tbody>

           <?

		$query = db_query($res);

		while($rows = mysqli_fetch_object($query)){

		?>

		<tr>

		<td><?=$rows->customer_id?></td>
		<td><?=$rows->organization?></td>
        <td><?=$rows->mobile_no?></td>
		<td><?=$rows->designation?></td>
		<td><?=$rows->email?></td>
		

		
		<td> <button type="button" class="btn btn-warning btn-xs" onclick="DoNav(<?=$rows->customer_id?>);"><i class="fa fa-edit"></i></button></td>

	

		</tr>

		<? } ?>

        </tbody>

        <tfoot>

            <tr><th>Customer ID</th><th>Name</th><th>Mobile</th><th>Email</th><th>Action</th></tr>

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

require_once SERVER_CORE."routing/layout.bottom.php";

?>