<?php



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Finished Goods Issue List';
do_calander('#fdate');


do_calander('#tdate');





$table = 'purchase_master';


$unique = 'po_no';


$status = 'CHECKED';


$target_url = '../fg_transfer/fg_transfer_report.php';





if($_REQUEST[$unique]>0)


{


$_SESSION[$unique] = $_REQUEST[$unique];


header('location:'.$target_url);


}





?>


<script language="javascript">


function custom(theUrl)


{


	window.open('<?=$target_url?>?v_no='+theUrl);


}


</script>

<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">
      <div class="container-fluid bg-form-titel">
        <div class="row">
          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 row">
		  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pr-0">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date:</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                <input type="text" name="fdate" id="fdate" value="<?=date('Y-m-01')?>" autocomplete="off" />
              </div>
            </div>
          </div>
		  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-0">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                <input type="text" name="tdate" id="tdate" value="<?=(isset($_POST['tdate']))?$_POST['tdate']:date('Y-m-d')?>"  autocomplete="off"/>
              </div>
            </div>
          </div>

          </div>
		  
		  <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
		            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Section </label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                	<select  name="warehouse" id="warehouse">
					
					<option></option>
					<? foreign_relation('warehouse','warehouse_id','warehouse_name',$$field,'1 and use_type="PL" order by warehouse_name asc');?>
					
					</select>


              </div>
            </div>
		  </div>
          
<?php /*?>		 <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Challan No: </label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                <input type="text" name="invoice_no" id="invoice_no" value="<?=$_POST['invoice_no']?>" />
			 </div>
            </div>
          </div><?php */?>

          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center">
		            <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
          </div>

        </div>
      </div>
    </form>

      <div class="container-fluid pt-5 p-0">
	  <? 


if(isset($_POST['submitit'])){


?>
        <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">
          <thead class="thead1">
          <tr class="bgc-info">
            <th>Issue No</th>
            <th>Manual Issue No</th>
            <th>Issue Date</th>
            <th>Issue To</th>
			<th>Total Qty</th>
          </tr>
          </thead>
          <tbody class="tbody1">
           
<?
$con .= 'and a.st_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['warehouse']!='') { $warehouse = ' and a.warehouse_from='.$_POST['warehouse'];  }

 $res='select  a.st_no,a.st_no,a.st_date,a.manual_req_no, w.warehouse_name as issue_to,a.issue_type,sum(b.qty) as Total

from fg_transfer_master a, fg_transfer_details b,warehouse w

where  a.st_no=b.st_no and w.warehouse_id=a.warehouse_to   '.$con.$warehouse.' group by a.st_no order by a.st_no desc';

$query = db_query($res);

while($data = mysqli_fetch_object($query)){


?>				<tr>

			<td><a href="../fg_transfer/fg_transfer_report.php?v_no=<?=rawurlencode(url_encode($data->st_no));?>" target="_blank">
			  <?=$data->st_no;?>
			</a></td>
			<td><?=$data->manual_req_no;?></td>
			<td><?=$data->st_date;?></td>
			<td><?=$data->issue_to;?></td>
			<td><?=$data->Total;?></td>
			</tr>	
<? } ?>
          </tbody>
        </table>
		<? } ?>
      </div>


  </div>





<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>