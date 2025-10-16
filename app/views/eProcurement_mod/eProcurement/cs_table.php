<?php
require_once "../../../controllers/routing/layout.top.php";
$current_page = "Events";
$title='Event Management';

do_calander("#f_date");
do_calander("#t_date");

$unique='rfq_no';
$table_master='rfq_master';

$table_details='purchase_invoice';

$unsetSql = 'select * from form_elements where 1';
$usetQry = db_query($unsetSql);
while($elementData=mysqli_fetch_object($usetQry)){
unset($_SESSION[$elementData->element]);
}

if($_GET['rfq_no']>0){
$_SESSION[$unique] = $_GET['rfq_no'];
}




if(isset($_POST['unseal'])){
 $Crud   = new Crud($table_master);
 unset($_POST);
 $_POST[$unique] = $_SESSION[$unique];
 $_POST['status'] = 'UNSEALED';
 $Crud->update($unique);
 $type=1;
 
}

if($_SESSION[$unique]>0)

{

		$condition=$unique."=".$_SESSION[$unique];

		$data=db_fetch_object($table_master,$condition);

        foreach($data as $key=>$value)

		{ ${$key}=$value;}

		

}

?>
<? include 'ep_menu.php'; ?>

    <script type="text/javascript" src="../../../../public/assets/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../../../../public/assets/js/jquery-3.4.1.min.js"></script>
	
<style>
.nav-tabs .nav-item .nav-link, .nav-tabs .nav-item .nav-link:hover, .nav-tabs .nav-item .nav-link:focus {
    border: 0 !important;
    color: #007bff !important;
    font-weight: 500;
	text-transform: capitalize;
	font-size: 14px !important;
}
.sidebar, .sidemenu{
	display:none;
    width: 0% !important;
}

.main_content{
	width: 100% !important;
}


.tab-content>.active {
    display: block;
    border: 1px solid #f5f5f5;

	background-color: #fffffffb;
}

.nav-tabs .nav-item .nav-link.active{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
	color: #121089 !important;
}
.nav-tabs .nav-item .nav-link:hover{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}

.h1{
    font-size: 16px !important;
    font-weight: 400;
}

.h1 i{
    font-size: 18px !important;
    font-weight: 400;
	color:#00469e;
}
.tr .td1{
	width:30%;
	text-align:right;
	font-weight:bold;
}
.tr .td2{
	width:70%;
	text-align:left;
	padding-left:6px;
}
tr:nth-child(even) {
    background-color: #fffffffb!important;
	color: #333 !important;
}

tr:nth-child(odd) {
    background-color: #fffffffb !important;
    color: #333 !important;
}

.tox-notifications-container{
      display: none !important;
  }

</style>



<style>

 .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    position: absolute;
    background-color: #f9f9f9;
    min-width: 210px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
	left: 10px; 
	padding: 5px 0px;
	border-radius: 3px;
  }
  .dropdown-content a{
  	background-color:#fff !important;
	text-align:left;
	padding: 5px 0px 5px 10px;
  }
  .dropdown-content a:hover{
  color:#f37025;
  }
 
.d-flex-bg-color{
background-color:#333 !important;
}
.ep-bg-color{
	background-color:#f5f5f5 !important;
}
.btn1-bg-submit{
	margin:10px !important;
	background-color:#FFFFFF !important;
	color:#333 !important;
	font-weight:bold !important;	
}
.alerts-bg{
	background-color:#f0f0f0;
	padding:10px;
}
.bg-alerts-bg{
background-color:#FFFFFF !important;
}
.alerts-table{
	height:300px !important;
}
.sourcing-table{
	width:100%;
}

.sourcing-table tr:nth-child(odd), .sourcing-table tr:nth-child(even)  {
    background-color: #fff !important;
    color: #333!important;
	text-align:left;
}
.tab-pane{
background-color:#fff !important;
}
.nav-tabs {
    border-bottom: 1px solid #d9d9d9;
    background-color: #fffefe;
}

</style>


<div class="container mt-1 p-0 ">

<div class="row p-0 pb-5">
	<div class="col-sm-9 col-lg-9 col-md-9 col-9">
	<h1 class="container" style=" font-size: 30px !important; ">Supplier Response - <?=$event_name?> #<?=$_SESSION['rfq_version']?></h1>
						
	</div>
	<div class="col-sm-3 col-lg-3 col-md-3 col-3">
	</div>
</div>

			 <div class="pt-1" style="overflow:scroll">
		    <button id="btnExport" class="btn1 btn1-bg-update" type="button" onclick="fnExcelReport();" style="cursor: pointer;"> Download </button>
			<?
			$sql = 'SELECT id, rfq_no, vendor_id FROM rfq_vendor_response WHERE rfq_no LIKE "'.$_SESSION[$unique].'" AND id IN ( SELECT MAX(id) AS first_id FROM rfq_vendor_response WHERE rfq_no LIKE "'.$_SESSION[$unique].'" AND status LIKE "SUBMITED" GROUP BY vendor_id )';
		 $response_query = db_query($sql);
		 while($response=mysqli_fetch_object($response_query)){
		 
		 	 $vendor_info[$response->vendor_id] = find_a_field('vendor','vendor_name','vendor_id='.$response->vendor_id);
		 			
			 $vendorSql = 'select * from rfq_vendor_item_response where rfq_no="'.$_SESSION[$unique].'" and section_id="'.$response->id.'" ';
			 $vendorQuery = db_query($vendorSql);
			 while($vendor=mysqli_fetch_object($vendorQuery)){
				$vendor_unit_price[$vendor->vendor_id][$vendor->item_id] = $vendor->unit_price;
				$vendor_unit_amount[$vendor->vendor_id][$vendor->item_id] = $vendor->total_amount;
				$vendor_unit_currency[$vendor->vendor_id][$vendor->item_id] = $vendor->currency;
				//$vendor_unit_currency[$vendor->vendor_id][$vendor->item_id] = $vendor->unit_price;
			 }
		 }
		 //print_r($vendor_info);
			?>
				<table class="table1  table-striped table-bordered table-hover table-sm" id="ExportTable" style="overflow-x: scroll; width: 100% !important;">
                    <thead class="thead1">
					
                    <tr class="bgc-info">
						<th rowspan="2" scope="col">Sl</th>
						<th rowspan="2" scope="col">Item Description</th>
						<th rowspan="2" scope="col">Quantity</th>
						<th rowspan="2" scope="col">UOM</th>
					<? foreach($vendor_info as $vendorID => $vendor_name){?>	
                        <th colspan="3" scope="col"><?php echo $vendor_name;?></th>
						<!--<th colspan="3" scope="col">Supplier Name</th>-->
					<? } ?>	
                    </tr>
                    <tr class="bgc-info">
					<? foreach($vendor_info as $vendorID => $vendor_name){?>
                      <th scope="col">Currency</th>
                      <th scope="col">Price</th>
                      <th scope="col">Amount</th>
					 <? } ?> 
                    </tr>
                    </thead>

                    <tbody class="tbody1" id="response_details">
					<?
		 
		
		 $sql = 'select r.* , i.item_name from rfq_item_details r, item_info i where i.item_id=r.item_id and r.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 $sl=1;
		 while($item=mysqli_fetch_object($qry)){
		 
		 
		?>
					    <tr>
							<td><?=$sl++;?></td>
							<td style=" text-align: left; "><?=$item->item_name;?></td>
							<td><?=$item->expected_qty;?></td>
							<td><?=$item->unit;?></td>
							<? foreach($vendor_info as $vendorID => $vendor_name){?>
								<td><?php echo $vendor_unit_currency[$vendorID][$item->item_id];?></td>
								<td><?php echo number_format($vendor_unit_price[$vendorID][$item->item_id],2);?></td>
								<td><?php echo number_format($vendor_unit_amount[$vendorID][$item->item_id],2);?></td>
							<? } ?>	
								
					    </tr>
							<? } ?>
					</tbody>
                </table>
  			
 
  
  
  </div>
  <!--this seript for excel-->
<script type="text/javascript" src="../../../../public/assets/js/xlsx.full.min.js"></script>
<script>

    function html_table_to_excel(type, filename)
    {
        var data = document.getElementById('ExportTable');

        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

        XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });

        XLSX.writeFile(file, filename + '.' + type);
    }

    const export_button = document.getElementById('btnExport');
    
    // Get the dynamic file name
    const eventName = "<?= $event_name ?>";
    const rfqVersion = "<?= $_SESSION['rfq_version'] ?>";
    const fileName = `${eventName} #${rfqVersion}`;

    export_button.addEventListener('click', () =>  {
        html_table_to_excel('xlsx', fileName);
    });

</script>

  <!--this seript for excel-->
<?
require_once "../../../controllers/routing/layout.bottom.php";
?>