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
	<h1 class="container" style=" font-size: 30px !important; ">Supplier Response - Event #<?=$_SESSION[$unique]?></h1>
						
	</div>
	<div class="col-sm-3 col-lg-3 col-md-3 col-3">
	</div>
</div>

			 <div class="pt-1">
		    <button id="btnExport" class="btn1 btn1-bg-update" type="button" onclick="fnExcelReport();" style="cursor: pointer;"> Download </button>
				<table class="table1  table-striped table-bordered table-hover table-sm" id="ExportTable">
                    <thead class="thead1">
															
                    <tr class="bgc-info">
						<th scope="col" colspan="5"></th>
													
<?
 $sql = 'select r.*,i.item_name,i.item_id,v.vendor_name,v.vendor_id,m.status as m_status from rfq_vendor_item_response r, item_info i, vendor v, rfq_master m where r.rfq_no=m.rfq_no and r.vendor_id=v.vendor_id and i.item_id=r.item_id and r.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 while($item=mysqli_fetch_object($qry)){

?>
						<th scope="col" colspan="2"> <?=$item->vendor_name;?></th>
<? } ?>
						
                    </tr>
                    <tr class="bgc-info">
						<th scope="col">Sl</th>
						<th scope="col">Item Name</th>
                        <th scope="col">Quantity</th>
						<th scope="col">UOM</th>
						<th scope="col">Currency</th>
						<?
 $sql = 'select r.*,i.item_name,i.item_id,v.vendor_name,v.vendor_id,m.status as m_status from rfq_vendor_item_response r, item_info i, vendor v, rfq_master m where r.rfq_no=m.rfq_no and r.vendor_id=v.vendor_id and i.item_id=r.item_id and r.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 while($item=mysqli_fetch_object($qry)){

?>
						<th scope="col">Unit Price</th>
						<th scope="col">Total Amount</th>
<? } ?>

                    </tr>
					
                    </thead>

                    <tbody class="tbody1" id="response_details">
<?php /*?>					<?
		$sql = 'select r.*,i.item_name,i.item_id,v.vendor_name,v.vendor_id,m.status as m_status from rfq_vendor_item_response r, item_info i, vendor v, rfq_master m where r.rfq_no=m.rfq_no and r.vendor_id=v.vendor_id and i.item_id=r.item_id and r.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 $sl=1;
		 while($item=mysqli_fetch_object($qry)){
		 $all_item = find_all_field('rfq_item_details','*','rfq_no='.$item->rfq_no.' and item_id='.$item->item_id.' ');
		?>
					    <tr>
							<td><?=$sl++;?></td>
							<td><?=$item->vendor_name;?></td>
							<td><?=$item->item_name;?></td>

							<td><?=$item->expected_qty;?></td>
							<td><?=$all_item->unit;?></td>
							<td><?=$all_item->currency;?></td>
							<td><?=$item->unit_price;?></td>

							<td><?=($item->expected_qty*$item->unit_price);?></td>
							
							</tr>
							<? } ?><?php */?>
							
							
							
<?
		//$sql1 = 'select r.*,i.item_name,i.item_id,v.vendor_name,v.vendor_id,m.status as m_status from rfq_vendor_item_response r, item_info i, vendor v, rfq_master m where r.rfq_no=m.rfq_no and r.vendor_id=v.vendor_id and i.item_id=r.item_id and r.rfq_no="'.$_SESSION[$unique].'"';
		
		
		echo $sql = 'select d.*, i.item_name FROM rfq_item_details d, item_info i WHERE d.item_id=i.item_id and d.rfq_no ="'.$_SESSION[$unique].'"';
		
		 $qry = db_query($sql);
		 $sl=1;
		 while($item=mysqli_fetch_object($qry)){
		 $all_item = find_all_field('rfq_item_details','*','rfq_no='.$item->rfq_no.' and item_id='.$item->item_id.' ');
?>
					    <tr>
							<td><?=$sl++;?></td>
							<td><?=$item->item_name;?></td>

							<td><?=$item->expected_qty;?></td>
							<td><?=$item->unit;?></td>
							<td><?=$item->currency;?></td>
							
													<?
 $sql = 'select r.*,i.item_name,i.item_id,v.vendor_name,v.vendor_id,m.status as m_status from rfq_vendor_item_response r, item_info i, vendor v, rfq_master m where r.rfq_no=m.rfq_no and r.vendor_id=v.vendor_id and i.item_id=r.item_id and r.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 while($item=mysqli_fetch_object($qry)){

?>
							<td><?=$item->unit_price;?></td>
							<td><?=($item->expected_qty*$item->unit_price);?></td>
<? } ?>

							
							</tr>
<? } ?>
							
							
							
							
							
							
					
					</tbody>
                </table>
  			
 
  
  
  </div>
	<script type="text/javascript" src = "../../../../public/assets/js/xlsx.full.min.js"></script>
<script>

    function html_table_to_excel(type)
    {
        var data = document.getElementById('ExportTable');

        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

        XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });

        XLSX.writeFile(file, 'file.' + type);
    }

    const export_button = document.getElementById('btnExport');

    export_button.addEventListener('click', () =>  {
        html_table_to_excel('xlsx');
    });

</script>
<?
require_once "../../../controllers/routing/layout.bottom.php";
?>