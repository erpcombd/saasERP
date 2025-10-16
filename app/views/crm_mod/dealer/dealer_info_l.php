<?php

session_start();

ob_start();

 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



//::::: Edit This Section::::: 

$title='People Information';		// Page Name and Page Title

$page="crm_customer_info.php";		// PHP File Name

$input_page="crm_customer_info.php";

$root='dealer';




//do_calander('#lead_date');
//::::: End Edit Section:::::

$crud      =new crud($table);


if($required_id>0)

$$unique = $_GET[$unique] = $required_id;



?>



  <div class="oe_view_manager oe_view_manager_current">
	<form action="" method="post" enctype="multipart/form-data">
    <div class="oe_view_manager_body">
      <div  class="oe_view_manager_view_list"></div>
      <div class="oe_view_manager_view_form">
        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
          <div class="oe_form_buttons"></div>
          <div class="oe_form_sidebar"></div>
          <div class="oe_form_pager"></div>
          <div class="oe_form_container">
            <div class="oe_form">
              <div class="">
                <div class="oe_form_sheetbg">
                  <div class="">
				  <?
				  $res = "select * from crm_customer_info where 1 ";
				  
				  
				  ?>
				  <div class="col-md-12 text-center"> 
				  
				  <? $access = find_a_field('crm_roll_assign','customer_create','PBI_ID="'.$_SESSION['srrr'].'"') ;  ?>
				  
				  
    <a href="dealer_info.php"><button id="singlebutton" type="button" name="singlebutton" class="btn btn-primary">Add New</button> </a>
	
	
</div>
				  
                    <table id="example" class="display nowrap table" style="width:100%">

        <thead style="background: #1ABB9C;">

            <tr><th>People ID</th><th>Name </th><th>Department </th><th>Designation </th><th>Customer</th><th>Phone</th>
			<? 
			
			$access = find_a_field('crm_roll_assign','customer_edit','PBI_ID="'.$_SESSION['srrr'].'"') ; 
			
			
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

		<td><?=$rows->dealer_code?></td>

		<td><?=$rows->dealer_name_e?></td>
		<td><?=$rows->project_dept?></td>
		<td><?=$rows->project_desg?></td>
		<td><?=find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$rows->PROJECT_ID.'"')?></td>
		<td><?=$rows->phone1?></td>


		<td><a href="dealer_info.php?dealer_code=<?=$rows->dealer_code?>"><button type="button" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></button></a></td>

		

		</tr>

		<? } ?>

        </tbody>

        <tfoot>

           <tr><th>People ID</th><th>Name </th><th>Department </th><th>Designation </th><th>Customer</th><th>Phone</th>
		
		   <th>Action</th>
	
		   
		   </tr>

        </tfoot>

    </table>
                   
                  </div>
                </div>
                <div class="oe_chatter">
                  <div class="oe_followers oe_form_invisible">
                    <div class="oe_follower_list"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	</form>
  </div>
<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>
