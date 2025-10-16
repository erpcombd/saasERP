<?php


session_start();


ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$c_id = $_SESSION['proj_id'];

$title='Finish Good Received Status';
do_calander('#fdate');
$tr_type="Show";

do_calander('#tdate');

$table = 'purchase_master';


$unique = 'po_no';


$status = 'COMPLETE';


$target_url = '../recipe/fg_transfer_report.php';





if($_REQUEST[$unique]>0)


{


$_SESSION[$unique] = $_REQUEST[$unique];


header('location:'.$target_url);


}




$tr_from="Warehouse";
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
		<div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 row">
			  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
				<div class="form-group row m-0">
				  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Form Date:</label>
				  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
					 <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=date('Y-m-01')?>" />
				  </div>
				</div>
	
			  </div>
			 
			 <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
				<div class="form-group row m-0">
				  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>
				  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						
								<select  name="warehouse" style="width:160px;" id="warehouse">
						
						<option></option>
						<? foreign_relation('warehouse','warehouse_id','warehouse_name',$$field,'1 and use_type="WH" order by warehouse_name asc');?>
						
						</select>			
				  </div>
				</div>
	
			  </div>
			  
			  
			  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
				<div class="form-group row m-0">
				  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date :</label>
				  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
					 <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=(isset($_POST['tdate']))?$_POST['tdate']:date('Y-m-d')?>" />
	
				  </div>
				</div>
			  </div>
			  

			  
			  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
				<div class="form-group row m-0">
				  <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Section :</label>
				  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										
						<select  name="warehouse_from" style="width:160px;" id="warehouse_from">
						
						<option></option>
						<? foreign_relation('warehouse','warehouse_id','warehouse_name',$$field,'1 and use_type="PL" order by warehouse_name asc');?>
						
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
            
        <div class="container-fluid pt-5 p-0">



			<? 
			if(isset($_POST['submitit'])){
			?>
					<table id="grp" class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th>Issue No</th>
						<th>Issue From</th>
						<th>Issue Date</th>
						<th>Issue To</th>
						<th>Total Ctn</th>
						<th>Total Pcs</th>
						<th>Total Qty </th>
					</tr>
			</thead>
			
			<tbody  class="tbody1">
			<?
			
			$con .= 'and a.st_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
			
			if($_POST['warehouse']!='') { $warehouse = ' and a.warehouse_to='.$_POST['warehouse'];  }
			if($_POST['warehouse_from']!='') { $warehouse_from = ' and a.warehouse_from='.$_POST['warehouse_from'];  }
			
			
			 $res='select  a.st_no,a.st_no,(SELECT warehouse_name from warehouse where warehouse_id=a.warehouse_from) as Issue_from,a.st_date, w.warehouse_name as issue_to,a.issue_type,sum(b.ctn) as ctn,sum(b.pcs) as pcs, sum(b.qty) as Total
			
			
			from fg_transfer_master a, fg_transfer_details b,warehouse w
			
			
			where  a.st_no=b.st_no and w.warehouse_id=a.warehouse_to and w.warehouse_id=a.warehouse_to and a.status="COMPLETE"   '.$con.$warehouse.$warehouse_from.' group by a.st_no order by a.st_no desc';
			
			
			$query = db_query($res);
			
			while($data = mysqli_fetch_object($query)){
			
			
			?>				<tr>
						<?php /*?><td width="10%"><a href="../recipe/fg_transfer_report.php?v_no=<?=$data->st_no?>" target="_blank">
						  <?=$data->st_no;?>
						</a></td><?php */?>
						
						<td width="10%"><a href="../recipe/fg_transfer_report.php?c=<?=rawurlencode(url_encode($c_id))?>&v=<?=rawurlencode(url_encode($data->st_no))?>" target="_blank">
						  <?=$data->st_no;?>
						</a></td>
						<td width="10%"><?=$data->Issue_from;?></td>
						<td width="10%"><?=$data->st_date;?></td>
						<td width="10%"><?=$data->issue_to;?></td>
						<td width="10%"><?=$data->ctn;?></td>
						<td width="10%"><?=$data->pcs;?></td>
						<td width="10%"><?=$data->Total;?></td>
						</tr>
				
			<?
			}
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