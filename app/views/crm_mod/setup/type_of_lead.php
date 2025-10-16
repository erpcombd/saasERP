<?php
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
 



// ::::: Edit This Section ::::: 

$title='Type Of Lead';			// Page Name and Page Title

$page="type_of_lead.php";		// PHP File Name

$input_page="type_of_lead_input.php";

$root='setup';





if(isset($_POST['insert'])){









}



$table='crm_type_of_lead';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='type';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::





$crud      =new crud($table);



echo $$unique = $_GET[$unique];

?>

<script type="text/javascript"> function DoNav(lk){



	return GB_show('ggg', '../../crm_mod/pages/<?=$root?>/type_of_lead_input.php?<?=$unique?>='+lk,600,940)

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


<? $access = find_a_field('crm_roll_assign','setup_create','PBI_ID="'.$_SESSION['srrr'].'"') ;  ?>
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

  

  

  

          <? 	 $res='select '.$unique.','.$unique.' as id, '.$shown.', remark from '.$table;



											//echo $crud->link_report($res,$link);?>

											

											

											

											<table id="example" class="display nowrap table" style="width:100%">

        <thead style="background: #1ABB9C;">

            <tr><th>Id</th><th>Type</th><th>Rmarks</th><th>Total Lead</th>
			
			<? 
			
			$access = find_a_field('crm_roll_assign','setup_edit','PBI_ID="'.$_SESSION['srrr'].'"') ; 
			
			
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

		<td><?=$rows->id?></td>

		<td><?=$rows->type?></td>
		<td><?=$rows->remark?></td>

		<td><a href="../report/master_report.php?report=202&&lead_type=<?=$rows->id?>" target="_blank" style="color: red; text-decoration: underline;"><button type="button" class="btn btn-xs btn-info"><?=find_a_field('crm_lead_master','count(lead_no)',' lead_type="'.$rows->id.'"');?></button></a></td>



		<td> <button type="button" class="btn btn-warning btn-xs" onclick="DoNav(<?=$rows->id?>);"><i class="fa fa-edit"></i></button></td>

		
		</tr>

		<? } ?>

        </tbody>

        <tfoot>

            <tr><th>Id</th><th>Type</th><th>Remarks</th><th>Total Lead</th>
			
		
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

require_once SERVER_CORE."routing/layout.bottom.php";

?>