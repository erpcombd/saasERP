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
		  $rfq_no = $_SESSION[$unique];
		  
		  if($_SESSION['user_role']=='Owner'){ 
		  	 $section_in = " 'General', 'Technical', 'Commercial'";
		  }else{
		  	$sq = 'select a.id,u.fname,u.user_id,a.action,a.section from rfq_section_evaluation_team a, user_activity_management u where a.user_id=u.user_id 
			and a.rfq_no="'.$_SESSION['rfq_no'].'" and u.user_id="'.$_SESSION['user']['id'].'"';
			
			$qr = db_query($sq);
		 	while($dat=mysqli_fetch_object($qr)){
				$sections[] = "'".$dat->action."'";
			}
			
			$section_in = implode(",", $sections);
		  }
			
		 $sql = 'select r.vendor_id, v.vendor_name from rfq_evaluation_section_vendor r, vendor v where v.vendor_id=r.vendor_id and r.rfq_no="'.$rfq_no.'" 
		 and r.section_name in ('.$section_in.') group by r.vendor_id';
		 $qry = db_query($sql);
		 while($doc1=mysqli_fetch_object($qry)){
		 	$vendor_names[$doc1->vendor_id] = $doc1->vendor_name;
			
			 $sql2 = 'select * from rfq_evaluation_section_vendor where rfq_no="'.$rfq_no.'" and vendor_id="'.$doc1->vendor_id.'"';
			 $qry2 = db_query($sql2);
			 while($doc=mysqli_fetch_object($qry2)){
			 	
				 $sql3 = 'select * from rfq_evaluation_section_child_vendor where rfq_no="'.$rfq_no.'" and section_id="'.$doc->id.'" and vendor_id="'.$doc->vendor_id.'"';
				 $qry3 = db_query($sql3);
				 while($doc2=mysqli_fetch_object($qry3)){
				 
				 	 $sectionNamePer[$doc2->id] = $doc->section_name.'-'.$doc->section_percent.'%';
					 $sectionID[$doc2->id] = $doc->id;
					 
					 
					 $child_name[$doc->id][$doc2->id][$doc->vendor_id] = $doc2->child_name;
					 $child_percent[$doc->id][$doc2->id][$doc->vendor_id] = $doc2->child_percent;
					 $average_percent[$doc->id][$doc2->id][$doc->vendor_id] = $doc2->average_percent;
					 $final_mark[$doc->setup_section_id][$doc2->setup_detilas_id][$doc->vendor_id] = $doc2->final_mark;
					 //section id, chiled id, vendor_id
				 }
				 
			 }
		 }
		?>
			
			
			
				<table class="table1  table-striped table-bordered table-hover table-sm" id="ExportTable" style="overflow-x: scroll; width: 100% !important;">
                    <thead class="thead1">
					
                    <tr class="bgc-info">
						<th rowspan="2" scope="col">Sl</th>
						<th rowspan="2" scope="col">Item</th>
						<th rowspan="2" scope="col">Evaluation Criteria</th>
						<th rowspan="2" scope="col">Average</th>
					<?
					 
					 foreach($vendor_names as $vendorID => $vendor_name){?>	
                        <th scope="col"><?php echo $vendor_name;?></th>
					<? } ?>	
                    </tr>
                    <tr class="bgc-info">
					<? foreach($vendor_names as $vendorID => $vendor_name){?>
                      <th scope="col">Evaluator Mark</th>
					 <? } ?> 
                    </tr>
                    </thead>

                    <tbody class="tbody1" id="response_details">
					<?
					
		  $sql2 = 'SELECT MIN(id) AS id, section_name, rfq_no 
						FROM rfq_evaluation_section_vendor 
						WHERE rfq_no = '.$rfq_no.' and section_name in ('.$section_in.')
						GROUP BY section_name, rfq_no';
		 $qry2 = db_query($sql2);
		 while($doc=mysqli_fetch_object($qry2)){
		 ?>
		 <tr>
		 	<td><?=$doc->section_name;?></td>
		 </tr>
		 <?
		
			 $sql3 = 'select distinct section_id, child_name,child_percent, average_percent, id, setup_section_id, setup_detilas_id
			  from rfq_evaluation_section_child_vendor where  rfq_no="'.$rfq_no.'"
			  and section_id="'.$doc->id.'" ';
			 $qry3 = db_query($sql3);
			 $sl=1;
			 while($item=mysqli_fetch_object($qry3)){
		 
		 
		?>
					    <tr>
							<td><?=$sl++;?></td>
							<td style=" text-align: left; "><?=$item->child_name;?></td>
							<td><?=$item->child_percent; $total_child += $item->child_percent; ?></td>
							<td><?=$item->average_percent; $total_average+=$item->average_percent;?></td>
							<? foreach($vendor_names as $vendorID => $vendor_name){?>
								<td><?php //echo $vendor_unit_currency[$vendorID][$item->item_id];
								 echo $final_mark[$item->setup_section_id][$item->setup_detilas_id][$vendorID];
								 $total_final[$vendorID] += $final_mark[$item->setup_section_id][$item->setup_detilas_id][$vendorID];
					 			//section id, chiled id, vendor_id
								?></td>
							<? } ?>	
								
					    </tr>
							<? } } ?>
						<tr>
							<td colspan="2" style="text-align:right; font-weight: bold"><b>Total: </b></td>
							<td style="font-weight: bold"><?=number_format($total_child);?></td>
							<td style="font-weight: bold"><?=number_format($total_average);?></td>
							<? foreach($vendor_names as $vendorID => $vendor_name){?>
							<td style="font-weight: bold"><?=number_format($total_final[$vendorID]);?></td>
							<? } ?>
						</tr>	
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