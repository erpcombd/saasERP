<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
if($_REQUEST['req_no']>0){
$req_no 		= $_REQUEST['req_no'];
}else{
$req_no 		= $_GET['req_no'];
}

if($_GET['update']=='Update')
{
	$req_status = $_GET['req_status'];
	$ssql='update requisition_master set status="'.$_GET['req_status'].'" where req_no="'.$req_no.'"';
	db_query($ssql);
}

$sql="select * from requisition_master where  req_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Purchase Requisition</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style>

table.table-bordered > thead > tr > th{
  border:1px solid black;
  font-size:12px;
}
table.table-bordered > tbody > tr > td{
  border:1px solid black;
    font-size:12px;
}

   .mb-3{
margin-bottom:4px!important;
}
.input-group-text{
font-size:12px;
}
      * {
    margin: 0;
    padding: 0;
	font-size:13px;
  }
  p {
    margin: 0;
    padding: 0;
  }
  h1,
  h2,
  h3,
  h4,
  h5,
  h6
   {
    margin: 0 !important;
    padding: 0 !important;
  }
  

label{

}

   
    </style>
</head>
<body>
<div class="container">
<div class="row">
	
		<div class="col-2 text-center">
			<img style="width:60px;height:55px" src="habib.png">
		</div>
		
		<div class="col-8 text-center">
			<h1><?php echo find_a_field('project_info','proj_name','1')?></h1>
			<span><h5 style="letter-spacing:1px;">Quality product at affordable cost</h5></span>
			<?php echo find_a_field('project_info','warehouse_address','1')?><br>
			Cell: <?php echo find_a_field('project_info','warehouse_phone','1')?>. Email: <?php echo find_a_field('project_info','proj_email','1')?>  <br> www.habibindustries.net
		</div>
		<div class="col-2"></div>
	</div><br />
	         <div class="text-center" >
              <button class="btn btn-default outline border rounded-pill border border-dark  text-black"><h4 style="font-size:15px; margin:0 auto;font-weight:bold;">Purchase Requisition</h4></button>
            </div>
			<br />
	<div class="row">
      <div class="col-6">
		    
			
			 
				<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Requisition  No :</span>
			  </div>
			   <input type="text" disabled class="form-control" id="no" value=" <?php echo $all->req_no;?>">
			</div>
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Requisition Date: </span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value="<?php echo date('Y-m-d',strtotime($all->req_date));?>">
			</div>
			
		
			
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;"> Requisition For :</span>
			  </div>
			   <input type="text" disabled class="form-control" id="no" value="  <?php echo $all->req_for;?>">
			</div>
			
			
			
			<!--<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Manual No</span>
			  </div>
			      <input type="text" disabled class="form-control" id="cell-tell" value="<?php echo $ch_all->mnumber;?>">
			</div>-->
			
		  </div>
		  <div class="col-6">
		  
		  <div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Present Status : </span>
			  </div>
			  <input type="text" disabled class="form-control" id="no" value=" <?php echo $all->status;?>">
			</div>
		  
		  
		  
		  
		    
		<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;"> Note :</span>
			  </div>
			  <input type="text" class="form-control" readonly="readonly" value=" <?php echo $all->req_note;?>">
			</div>
			
				
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;">Warehouse : </span>
			  </div>
			  <input type="text" disabled class="form-control" id="no" value=" <?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_id);?>">
			</div>
			
			
			
		  </div>
              
            </div>


  <div id="pr">
<div align="left">
<form action="" method="get">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
    <!--<td width="100" align="right">Present Status:</td>
    <td width="1">
    
    <select name="req_status">
    <option><?=$all->status;?></option>
    <option>PENDING</option>
    <option>STOPPED</option>
    <option>CANCELED</option>
    <option>COMPLETE</option>
    </select></td>
    <td><input name="update" type="submit" value="Update" /><input type="hidden" name="req_no" id="req_no" value="<?=$req_no?>" /></td>-->
  </tr>
</table>

</form>
</div>
</div>
<br />
<table class="table table-bordered table-condensed" >
<thead>
       <tr style="text-align:center;">
        <th>SL</th>
		<th>Item Code</th>
        <th>Description of the Goods</th>
      
        <th>Present Stock</th>
		<th>UOM</th>
		<th>Req QTY</th>
		<th >Required Date</th>
        <th >Last GRN QTY</th>
        <th>Last GRN Date </th>
        
        
		  <th >Remarks</th>
       </tr>
	   </thead>
	   <tbody>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
  $sql2="select * from requisition_order where  req_no='$req_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;

$item_id=find_a_field('item_info','finish_goods_code','item_id="'.$info->item_id.'"');

$rdate=$info->rdate;

$amount=$info->qty*$info->rate;
$total=$total+($info->qty*$info->rate);
$sl=$pi;

$item=find_all_field('item_info','','item_id='.$info->item_id);
$qty=$info->qty;
$qoh=$info->qoh;
//$last_p_date=$info->last_p_date;
//$last_p_qty=$info->last_p_qty;
$last_grn_qty=find_a_field('purchase_receive','qty','item_id="'.$info->item_id.'" order by id desc');
$last_grn_date=find_a_field('purchase_receive','rec_date','item_id="'.$info->item_id.'" order by id desc');
?>
      <tr>
        <td align="center"><?=$sl?></td>
		<td align="center" ><?=$item_id;?></td>
        <td ><?=$item->item_name?></td>
      
        <td align="center" ><?=number_format(find_a_field('journal_item','sum(item_in-item_ex)','warehouse_id="'.$info->warehouse_id.'" and item_id="'.$info->item_id.'"'),2);?></td>
		 <td align="center"><?=$item->unit_name?></td>
		 <td align="center"><?=number_format($qty,0);?></td>
		  <td align="center" ><?=$rdate?></td>
        <td align="center"><?=number_format($last_grn_qty,0)?></td>
        <td align="center" ><?=$last_grn_date;?></td>
       
       
		<td><?=$info->remarks?></td>
      </tr>
	  </tbody>
<? }?>
    </table>
  
<br /><br />
<div class="row">
<div class="col-1"></div>
              <div class="col-3 text-center">
               <b><?=find_a_field('user_activity_management','fname','user_id='.$all->edit_by);?></b>
                <br>
               <p style="border-top:1px solid"> Prepared By  </p>
                
              </div>

 <div class="col-1"></div>
              <div class="col-3 text-center">
               <b><?=find_a_field('user_activity_management','fname','user_id='.$all->acc_check);?></b>
                <br>
               <p style="border-top:1px solid"> Checked By  </p>
                
              </div>
			  
	<div class="col-1"></div>
			  <div class="col-3 text-center">
               <b><?=find_a_field('user_activity_management','fname','user_id='.$all->ware_approve);?></b>
                <br>
               <p style="border-top:1px solid"> Approved By  </p>
                
              </div>
            </div>
</div>
</body>
</html>
