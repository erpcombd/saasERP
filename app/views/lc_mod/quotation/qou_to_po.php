<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$tr_type="Show";
$title='Quotation To PO Entry';

do_calander('#fdate');

do_calander('#tdate');

$table = 'requisition_master';

$unique = 'req_no';

$status = 'UNCHECKED';

$target_url = '../mr/mr_print_view.php';


if($_GET['vStatus']>0){

$status=find_a_field('requisition_master','vendor_status','req_no='.$_GET['vStatus']);

if($status=="No" && $_GET['status']=="No"){ db_query('update requisition_master set vendor_status="Yes" where req_no='.$_GET['vStatus'].'');}

if($status=="Yes" && $_GET['status']=="Yes"){ db_query('update requisition_master set vendor_status="Expired" where req_no='.$_GET['vStatus'].'');}

echo "<script>window.top.location='mr_pending.php'</script>";
}

$tr_from="Purchase";

?>




<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+ encodeURIComponent(theUrl));
}
</script>





<div class="form-container_large">

    

<?
 $link="foreign_po_create.php?mhafuz=2";
  $btn_name="CREATE New Purchase Order";
 
?>

   
<form method="POST" action="" target="" name="codz" id="codz">
            <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> From Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />
                        </div>
                  </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" />
                        </div>
                  </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
             <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req Status :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						
                            <select name="status" id="status">

								<option></option>

								<option <?=($_POST['status']=='CHECKED')?'selected':''?>>CHECKED</option>

								<option <?=($_POST['status']=='COMPLETED')?'selected':''?>>COMPLETED</option>

							</select>
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 pt-1 pb-1">
                    <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            					  
					  	
                            <select name="warehouse_id" id="warehouse_id">

								<option></option>
								<? user_warehouse_access($depot_id);?>

							</select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                     <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
                </div>

            </div>
        </div>
		
		

        </form>






<form method="POST" action="<?=$link?>" target="" name="codz" id="codz">




            

        <div class="container-fluid pt-5 p-0 ">

<input type="submit"  name="pobtn" id="pobtn" value="<?=$btn_name?>" class="btn btn-success btn-block" style="display:none" /></p>
		<input type="hidden" name="quotation_no" id="quotation_no" />

                <table class="table1  table-striped table-bordered table-hover table-sm">

                    <thead class="thead1">

                    <tr class="bgc-info"> 
					<th>Select</th>

                        <th>Quotation No</th>

                        <th  >Quotation Date</th>
						 <th  >Requisition No</th>
						  <th  >Vendor Name</th>
 <th  >Item Name</th>
  <th  >Qty</th>
            



                        <th>Warehouse </th>
						<th>Entry By</th>

					 
<!--
						<th>Action</th>
						-->
					 

                        

                    </tr>

                    </thead>



                    <tbody class="tbody1">

						<? 

//////item_info//
$sql='select * from item_info where 1 group by item_id';
$query=db_query($sql);
while($row=mysqli_fetch_object($query)){
	$item_name_get[$row->item_id]=$row->item_name;
}

//		//////vendor id/////////
				 
							$vsql='select * from  vendor_foreign where 1';
							$vquery=db_query($vsql);
							while($vrow=mysqli_fetch_object($vquery)){ 
							$vendor_name_get[$vrow->vendor_id]=$vrow->vendor_name;
							}

								if($_POST['status']!='' && $_POST['status']!='ALL')

				$con .= ' and a.status="'.$_POST['status'].'"';



						if($_POST['fdate']!=''&&$_POST['tdate']!='')

				$con2 .= ' and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
				
				if($_POST['warehouse_id']!='')
								$con .= 'and a.warehouse_id = "'.$_POST['warehouse_id'].'"';



    $res='select  	o.quotation_no,o.id,o.item_id,a.quotation_no,a.req_no, a.quotation_date,o.vendor_id,  b.warehouse_name as warehouse, o.remarks as note,  c.fname as entry_by, a.entry_at,a.status,o.req_qty
 
 from import_quotation_details o,import_quotation_master a,warehouse b,user_activity_management c
 
 where  o.quotation_no=a.quotation_no and a.warehouse_id=b.warehouse_id   and  o.app_status in ("APPROVED") and a.entry_by=c.user_id '.$con.$con2.'  order by o.vendor_id asc';

								

								$query=db_query($res);

								

								while($row=mysqli_fetch_object($query)){
								
								
								$currentDate = time();
								$targetdate = strtotime($row->need_by);
							 	$remain= $targetdate-$currentDate;
							 	$days=ceil($remain / (60 * 60 * 24));

								?>

                        <tr>
<td><input type="checkbox" id="myChec_<?=$row->id?>" value="<?=$row->id?>" name="myChec[]" data-reqno="<?=$row->quotation_no;?>" onchange="checkCheckboxes()"></td>
                            <td><?=$row->quotation_no?></td>

                            <td><?=$row->quotation_date?></td>
							<td><?=$row->req_no?></td>
								<td><?=$vendor_name_get[$row->vendor_id]?></td>

                          <td><?=$item_name_get[$row->item_id]?></td>
						   <td><?=$row->req_qty?></td>



                            <td><?=$row->warehouse?></td>

                      

                           
							
					 

						 

							<td><?=$row->entry_by?></td>

						 

<!--
                            <td>
							<button type="button" onclick="custom('<?=url_encode($row->req_no);?>')" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button>
							
							</td>-->
 



                        </tr>

							<? 

							}

							?>

                    </tbody>

                </table>
				
        </div>

    </form>

</div>









<!--<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<table width="80%" border="0" align="center">

  <tr>

    <td>&nbsp;</td>

    <td colspan="3">&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>

    <td width="1" bgcolor="#FF9966"><strong>

      <input type="text" name="fdate" id="fdate" style="width:100px;" value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />

    </strong></td>

    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

    <td width="1" bgcolor="#FF9966"><strong>

      <input type="text" name="tdate" id="tdate" style="width:100px;" value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" />

    </strong></td>

    <td rowspan="2" bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="View Detail" class="btn1 btn1-submit-input" />

    </strong></td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

<select name="status" id="status" style="width:200px;">

<option></option>

<option <?=($_POST['status']=='CHECKED')?'selected':''?>>CHECKED</option>

<option <?=($_POST['status']=='COMPLETED')?'selected':''?>>COMPLETED</option>

</select>

    </strong></td>

    </tr>

</table>



</form>

</div>-->

 
<script>
        // Function to check if any checkbox is selected
        function checkCheckboxes() {
            const checkboxes = document.querySelectorAll('input[name="myChec[]"]');
            const button = document.getElementById('pobtn');
            let anyChecked = false;
			const reqNoBox = document.getElementById('quotation_no');
			let reqNoSet = new Set();
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    anyChecked = true;
					reqNoSet.add(checkbox.getAttribute('data-reqno'));
                }
            });

            if (anyChecked) {
                button.style.display = 'block';
            } else {
                button.style.display = 'none';
            }
			reqNoBox.value = Array.from(reqNoSet).join(',');
        }

        // Add event listeners to all checkboxes
        document.querySelectorAll('input[name="mychec[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', checkCheckboxes);
        });

        // Initial check in case the form has pre-checked checkboxes
        checkCheckboxes();
    </script>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>

