<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$tr_type="Show";
$title='PR Pending';



do_calander('#fdate');

do_calander('#tdate');



$table = 'requisition_master';

$unique = 'req_no';

$status = 'UNCHECKED';

$target_url = '../mr/mr_checking_type.php';


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

	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);

}

</script>
<script>
        // Function to check if any checkbox is selected
        function checkCheckboxes() {
            const checkboxes = document.querySelectorAll('input[name="myChec[]"]');
            const button = document.getElementById('pobtn');
            let anyChecked = false;
			const reqNoBox = document.getElementById('req_no');
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


<div class="form-container_large">

    

    <form action="" method="post" name="codz" id="codz">

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
				
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 pt-1 pb-1">
                    <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> For Warehouse :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            					  
					  	
                            <select name="warehouse_id" id="warehouse_id">

								<option></option>
								<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],' use_type = "WH" and group_for="'.$_SESSION['user']['group'].'" ');?>

							</select>

                        </div>
                    </div>
                </div>
				
				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 pt-1 pb-1">
                    <div class="form-group row m-0">
                        
                  </div>

                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                     <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
                </div>

            </div>
        </div>
		
		</form>

        

<?

$btn_name="CREATE  PO";
$link="../po/po_create.php?new=2";
?>



<form method="POST" action="<?=$link?>" target="">
<br/>
		
		<input type="submit"  name="pobtn" id="pobtn" value="<?=$btn_name?>" class="btn btn-info btn-block" style="display:none" /></p>
		<input type="hidden" name="req_no" id="req_no" />
                <table class="table1  table-striped table-bordered table-hover table-sm">

                    <thead class="thead1">

                    <tr class="bgc-info">

                        <th>id</th>
						<th>Req No </th>
                        <th>Expire Date</th>
                        <th>Remain Dayes</th>
                        <th>Item</th>
                        
                        <th>Req QTY</th>
                        <th>Req PO</th>
                        <th>Remain QTY</th>
                        <th>Entry BY</th>
                        <th>Entry At</th>
                        <th>Item Status</th>
                        <th>CHECK</th>
                        



                        

                    </tr>

                    </thead>



                    <tbody class="tbody1">

						<? 



				if($_POST['status']!=''&&$_POST['status']!='ALL')

				$con .= ' and a.status="'.$_POST['status'].'"';
				
				
				if($_POST['p_type']!='')

				$con3 .= ' and o.p_type="'.$_POST['p_type'].'"';




						if($_POST['fdate']!=''&&$_POST['tdate']!='')

				$con2 .= ' and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
				
				if($_POST['warehouse_id']!='')
								$con .= 'and a.warehouse_id = "'.$_POST['warehouse_id'].'"';


						


       $res="SELECT o.id, o.req_no, o.required_in, o.item_id, i.item_name, b.warehouse_name AS warehouse, o.remarks, o.qty, o.purchase_qty, c.fname AS entry_by, a.entry_at, a.status AS po_status,o.status
   FROM requisition_order o JOIN requisition_master a ON o.req_no = a.req_no JOIN warehouse b ON o.warehouse_id = b.warehouse_id JOIN item_info i ON o.item_id = i.item_id JOIN user_activity_management c ON a.entry_by = c.user_id 
   WHERE o.status IN ('PENDING', 'CHECKED')  ".$con.$con2.$con3." ORDER BY o.req_no, o.id DESC";
//a.warehouse_id="'.$_SESSION['user']['depot'].'" and 
								

								$query=db_query($res);

								

								While($row=mysqli_fetch_object($query)){
								
								$currentDate = time();
								 $targetdate = strtotime($row->required_in);
							 	$remain= $targetdate-$currentDate;
							 	$days=ceil($remain / (60 * 60 * 24));
								
								if($days> (-1)){

								?>

                        <tr>

                            <td><?=$row->id?></td>

                            <td><?=$row->req_no?></td>

                            <td><?=$row->required_in; ?></td>
						
                              <td  <? if ($days<=5){echo' bgcolor="#ffcccc"';} else {echo' bgcolor="#ccffeb"';}; ?>><strong><?=$days; ?></strong></td>
						
                            <td><?=$row->item_id?> &nbsp; <?=$row->item_name?></td>

                         

							<td><?=$row->qty?></td>

							<td ><?=$row->purchase_qty?></td>
							<td><?= $row->qty-$row->purchase_qty?></td>
							<td><?=$row->entry_by?></td>
							<td><?=$row->entry_at?></td>
							<td><?=$row->status?></td>
					<td><input type="checkbox" id="myChec_<?=$row->id?>" value="<?=$row->id?>" name="myChec[]" data-reqno="<?=$row->req_no;?>" onchange="checkCheckboxes()"></td>
						

       



                        </tr>

							<? 

							} 
							}
							

							?>

                    </tbody>

                </table>
				
				
	
   
</div>




 </form>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>



