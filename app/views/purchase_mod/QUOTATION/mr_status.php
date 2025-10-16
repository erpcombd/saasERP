<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$tr_type="Show";
$title='Purchase Quotation Status';
$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);
do_calander('#fdate');
do_calander('#tdate');

$table = 'quotation_master';
$unique = 'quotation_no';
$status = 'UNCHECKED';
$target_url = '../quotation/quotation_print_view.php';
$tr_from="Purchase";
?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
}
</script>



<div class="form-container_large">
    
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> From Date:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<?=$_POST['fdate']?>" autocomplete="off" />
                        </div>
                  </div>

                </div>
				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date :</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<?=$_POST['tdate']?>" autocomplete="off" />
                        </div>
                  </div>

                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Purchase QS:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <select name="status" id="status" >
								<option><?=$_POST['status']?></option>
								<option>UNCHECKED</option>
								<option>CHECKED</option>
								<option>ALL</option>
							</select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
					
                    
                </div>

            </div>
        </div>






            
        <div class="container-fluid pt-5 p-0 ">

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Quotation No</th>
                        <th>Quotation Date</th>
                        <th>Vendor Name</th>

                        <th>Entry By </th>
                        <th>Entry At</th>
                        <th>Status</th>
						<th>Action</th>
                        <th>Attachment</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					
					<? 
							if($_POST['status']!=''&&$_POST['status']!='ALL'){
							$con .= 'and a.status="'.$_POST['status'].'"';
							}
							if($_POST['fdate']!=''&&$_POST['tdate']!=''){
							$con .= 'and a.quotation_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
							}
							
							   $res='select  	a.quotation_no,a.quotation_no as quotation_no, DATE_FORMAT(a.quotation_date, "%d-%m-%Y") as quotation_date,  v.vendor_name as vendor_name,    a.status,  c.fname as entry_by,  a.entry_at, a.quotation from quotation_master a, user_activity_management c, vendor v where a.vendor_id=v.vendor_id and a.group_for="'.$_SESSION['user']['group'].'" and
							 a.entry_by=c.user_id '.$con.' and a.status in ("UNCHECKED","CHECKED", "COMPLETED") group by a.quotation_no order by a.quotation_no desc';
						

								
								$query=db_query($res);
								
								While($row=mysqli_fetch_object($query)){
								
								
								?>
                        <tr>
                            <td><?=$row->quotation_no?></td>
                            <td><?=$row->quotation_date?></td>
                            <td style="text-align:left"><?=$row->vendor_name?></td>

                            <td><?=$row->entry_by?></td>
                            <td><?=$row->entry_at?></td>
                            <td><?=$row->status?></td>
							<td><button type="button" onclick="custom('<?=url_encode($row->quotation_no);?>')" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button></td>

                            <!--<td><a href="../../../../media/quotation/<?=$row->quotation?>" target="_blank">View Attachment</a></td>-->
							 <td><a href="../../../assets/support/upload_view.php?name=<?=$row->quotation?>&folder=quotation&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank">View Attachment</a></td>
                            

                        </tr>
							<? 
							}
							?>
                    </tbody>
                </table>





        </div>
    </form>
</div>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>