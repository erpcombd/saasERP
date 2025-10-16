<?php

 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$c_id = $_SESSION['proj_id'];

$title='Sales Return Status';

$tr_type="Show";

do_calander('#fdate');

do_calander('#tdate');



$table = 'sale_return_master';

$unique = 'v_no';

$status = 'UNCHECKED';

$target_url = 'sales_return_print_view.php';

$tr_from="Warehouse";

?>

<script language="javascript">

function custom(theUrl,c_id)
{
	window.open('<?=$target_url?>?c='+encodeURIComponent(c_id)+'&v='+ encodeURIComponent(theUrl));
}

</script>



  <div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">

      <div class="container-fluid bg-form-titel">
        <div class="row">
		<div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 row">
			  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
				<div class="form-group row m-0">
				  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Form Date:</label>
				  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
					 <input type="text" name="fdate" id="fdate" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01')?>" />
				  </div>
				</div>
	
			  </div>
			 
			 <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
				<div class="form-group row m-0">
				  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>
				  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
									
					  <select name="warehouse_id" id="warehouse_id">
				
						<option value="">ALL</option>
				
						<? user_warehouse_access($depot_id);?>
				
					  </select>
				  </div>
				</div>
	
			  </div>
			  
			  
			  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
				<div class="form-group row m-0">
				  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> To Date:</label>
				  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
					 <input type="text" name="tdate" id="tdate" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d')?>" />
	
				  </div>
				</div>
			  </div>
			  

			  
			  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
				<div class="form-group row m-0">
				  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company Name :</label>
				  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										
						  <select name="group_for" id="group_for">
					
						  <option></option>
					
								<? user_company_access($group_for); ?>
					
						  </select>
	
				  </div>
				</div>
			  </div>
			  
		</div>
		
          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
            <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
          </div>

        </div>
      </div>


</form>

<!--Table start-->
      <div class="container-fluid pt-5 p-0 ">
	  
<? 

if(isset($_POST['submitit'])){





if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.sr_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



if($_POST['group_for']!='')

$con .= 'and a.group_for = "'.$_POST['group_for'].'"';



if($_POST['warehouse_id']!='')

$con .= 'and a.depot_id = "'.$_POST['warehouse_id'].'"'; 


 $res='select  a.sr_no,a.sr_no as SR_NO,a.sr_date as SR_Date , d.dealer_name_e as Customer_Name, u.group_name as company, b.warehouse_name as warehouse, a.received_status, c.fname as "Entry", a.entry_at from sale_return_master a, warehouse b,user_activity_management c, dealer_info d, user_group u where a.depot_id=b.warehouse_id and a.entry_by=c.user_id and a.dealer_code=d.dealer_code and u.id=a.group_for  order by a.sr_no desc';

//echo link_report($res,'po_print_view.php');,

 $query = db_query($res);

}

?>

        <table class="table1  table-striped table-bordered table-hover table-sm">
          <thead class="thead1">
          <tr class="bgc-info">
            <th>SR NO</th>
            <th>SR Date</th>
            <th>Customer Name</th>

            <th>Company</th>
            <th>Warehouse</th>
            <th>Received Status </th>
			<th>Entry </th>
			<th>Entry At </th>
			<th>Action </th>

          </tr>
          </thead>

          <tbody class="tbody1">
           <?
		   if($query)
		    while($row = mysqli_fetch_object($query)){?>

          <tr>
            <td><?=$row->SR_NO?> </td>
			<td><?=$row->SR_Date?> </td>
			<td><?=$row->Customer_Name?> </td>			
			<td><?=$row->company?> </td>
			<td><?=$row->warehouse?> </td>
			<td><?=$row->received_status?> </td>
			<td><?=$row->Entry?> </td>
			<td><?=$row->entry_at?> </td>
            <td>
			<button type="button" name="submitit" value="View" class="btn2 btn1-bg-submit" onclick="custom('<?=url_encode($row->SR_NO);?>','<?=url_encode($c_id);?>');">
							 	 <i class="fa-solid fa-eye"></i>
				</button>
			
			</td>
          </tr>


<? } ?>
          </tbody>
		  
        </table>



      </div>

  </div>








<?



require_once SERVER_CORE."routing/layout.bottom.php";

?>