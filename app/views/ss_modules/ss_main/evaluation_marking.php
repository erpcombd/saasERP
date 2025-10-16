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


$vendor_name = find_a_field('vendor','vendor_name','vendor_id="'.$_GET['vendor_id'].'"');





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

		foreach($data as $key => $value)

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
	background-color: white;
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
	<h1 class="container" style=" font-size: 30px !important; "><?=$vendor_name?> - Event #<?=$_SESSION[$unique]?><span style="font-size:11px;">(Evaluation)</span></h1>
						
	</div>
	<div class="col-sm-3 col-lg-3 col-md-3 col-3">
	</div>
</div>




			<form method="post" action="" id="ep_form">
			<div id="section_details">
			<?
			
		 $sql = 'select * from rfq_evaluation_section where rfq_no="'.$rfq_no.'" and id="'.$_GET['evaluation_id'].'"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		 $evaluation_status = $doc->status;
		?>

			<div class="col-12 row">
	<div class="col-6 ">
	<?=$doc->section_name.' Evaluation Weightage '.$doc->section_percent?> %
			<fieldset class="scheduler-border">
    
            
            <div id="section_child_details_<?=$doc->id?>"><input type="hidden" name="section_id" id="section_id" value="<?=$doc->id?>" />
			<input type="hidden" name="vendor_id" id="vendor_id" value="<?=$_GET['vendor_id']?>" />
			<input type="hidden" name="section_name" id="section_name" value="<?=$doc->section_name?>" />
			<input type="hidden" name="section_percent" id="section_percent" value="<?=$doc->section_percent?>" />
             <table class="w-100"    border="1">
			 <thead>
			   <tr>
			    <th>Criteria</th>
				<th>Weightage</th>
				<th>Marking</th>
			   </tr>
			 </thead>
            <tbody>
			<?
		 $sql2 = 'select * from rfq_evaluation_section_child where rfq_no="'.$rfq_no.'" and section_id="'.$doc->id.'"';
		 $qry2 = db_query($sql2);
		 while($doc2=mysqli_fetch_object($qry2)){
		 $marking = find_a_field('rfq_evaluation_section_child_vendor','final_mark','setup_detilas_id="'.$doc2->id.'" and vendor_id="'.$_GET['vendor_id'].'"');
		?>
           
           <tr>
             <td><?=$doc2->child_name?><input type="hidden" name="section_child_id" id="section_child_id" value="<?=$doc2->id?>" /></td>
             <td><?=$doc2->child_percent?>%</td>
   
             <td><input type="text" name="<?=$doc->id.'_'.$doc2->id?>" id="<?=$doc->id.'_'.$doc2->id?>" placeholder="Marking..%" value="<?=$marking?>" required /></td>
           </tr>
			
			
			<? } ?>
			<tr>
			<td colspan="3"  >
			<? if($marking<1){?>
			  <span id="confirmation_msg" style="color:green; font-size:15px;"><button type="button" name="section" class="btn1 btn1-bg-update" onclick="evaluation_confirmation()">Save</button></span>
			  <? } else{ echo 'Already Marking Completed'; } ?>
			  </td>
			</tr>
			</tbody>
            </table>
			</div>
			</fieldset>
            
			</div>
            
			</div>
			
			<? } ?>
			
			</div>
			</form>
			</div>
<script>
function get_response_details(){
var response_type = 'test';
getData2('get_response_details_ajax.php','response_details',response_type,response_type);
}
</script>			
<script type="text/javascript" src="evaluation_confirm_script.js"></script>

<?
require_once "../../../controllers/routing/layout.bottom.php";
?>