<?

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

date_default_timezone_set('Asia/Dhaka');

if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0)


{


	if((strlen($_REQUEST['t_date'])==10))


	{


		$t_date=$_REQUEST['t_date'];

		$f_date=$_REQUEST['f_date'];


	}


if($_REQUEST['product_group']!='')  $product_group=$_REQUEST['product_group'];



if($_REQUEST['item_brand']!='') 	$item_brand=$_REQUEST['item_brand'];



if($_REQUEST['item_id']>0) 		    $item_id=$_REQUEST['item_id'];


if($_REQUEST['dealer_code']>0) 	    $dealer_code=$_REQUEST['dealer_code'];





$item_info = find_all_field('item_info','','item_id='.$item_id);







if(isset($item_brand)) 			{$item_brand_con=' and i.item_brand="'.$item_brand.'"';} 



if(isset($dealer_code)) 		{$dealer_con=' and a.dealer_code="'.$dealer_code.'"';} 



 



if(isset($t_date)) 				{$to_date=$t_date; $fr_date=$f_date; $date_con=' and m.do_date between \''.$fr_date.'\' and \''.$to_date.'\'';}



if(isset($product_group)) 		



{



if($product_group=='ABCD')



$pg_con=' and d.product_group!="M"';



else



$pg_con=' and d.product_group="'.$product_group.'"';



} 



if(isset($dealer_type)) 		{$dtype_con=' and d.dealer_type="'.$dealer_type.'" ';}
switch ($_REQUEST['report']) {

    case 1:



	$report="Delivery Order Summary Brief";



	break;
	


}


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="content-type" content="text/html; charset=utf-8" />



<title>



<?=$report?>



</title>



<link href="../../../../public/assets/css/report.css" type="text/css" rel="stylesheet" />

<script language="javascript">



function hide()



{



document.getElementById('pr').style.display='none';



}



</script>



<style type="text/css" media="print">



      div.page



      {



        page-break-after: always;



        page-break-inside: avoid;



      }



    </style>



<style type="text/css">



<!--



.style3 {color: #FFFFFF; font-weight: bold; }



.style5 {color: #FFFFFF}



-->



    </style>



</head>



<body>



<div align="center" id="pr">



  <input type="button" style="text-align:center" value="Print" onclick="hide();window.print();"/>



</div>



<div class="main">



<?



		$str 	.= '<div class="header">';



		if(isset($_SESSION['company_name'])) 



		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';



		if(isset($report)) 



		$str 	.= '<h2>'.$report.'</h2>';



		if(isset($dealer_code)) 



		$str 	.= '<h2>Dealer Name : '.$dealer_code.' - '.find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code).'</h2>';



		if(isset($depot_id)) 



		$str 	.= '<h2>Branch Name : '.find_a_field('warehouse','warehouse_name','warehouse_id='.$depot_id).'</h2>';



		
		if(isset($item_info->item_id)) 



		$str 	.= '<h2>Item Name : '.$item_info->item_name.'('.$item_info->finish_goods_code.')'.'('.$item_info->sales_item_type.')'.'('.$item_info->item_brand.')'.'</h2>';



		if(isset($to_date)) 



		$str 	.= '<h2>Date Interval : '.$fr_date.' To '.$to_date.'</h2>';



if($_REQUEST['report']==1) 
{

if($_POST['marketing_person']!=''){
  $con .= ' and m.marketing_person="'.$_POST['marketing_person'].'"';
}

if($_POST['depot_id']>0){
  $con .= ' and m.depot_id="'.$_POST['depot_id'].'"';
}
if($_POST['item_brand']>0){
  $con .=  ' and item.item_brand="'.$_POST['item_brand'].'"';
}

if($_POST['serial_no']!=''){
  $con .=  ' and d.serial_no="'.$_POST['serial_no'].'"';
}

if($_POST['service_no']>0){
  $con .=  ' and d.service_no="'.$_POST['service_no'].'"';
}


$sql="select d.*,i.item_name, m.sales_date as invoice_date, m.client_id from service_details d, service_master m, item_info i where d.service_no=m.service_no and i.item_id=d.item_id ".$con." ";
$query = db_query($sql);

?>



<table width="100%" style="text-align:center" cellspacing="0" cellpadding="2" border="0">
  <thead>
    <tr>
      <td style="border:0px; text-align:center" colspan="13"><?=$str?></td>
    </tr>
    <tr style="text-align:center">
      <th>S/L</th>
      <th>Complain No</th>
      <th>Complain Date</th>
      <th>Item Name</th>
      <th style="text-align:center;">Customer Name</th>
      <th style="text-align:center;">Invoice No</th>
	  <th style="text-align:center;">Invoice Date</th>
	  <th style="text-align:center;">Serial No</th>
	  <th>Problem</th>
      <th>Assign Engineer</th>
	  <th>Status</th>

    </tr>
  </thead>
  <tbody>



    <?

while($data=mysqli_fetch_object($query)){$s++;

?>
    <tr>
      <td><?=$s?></td>
      <td><a href="../service/service_received_print_view.php?service_no=<?=$data->service_no?>" target="_blank"><?=$data->service_no?></a></td>
      <td><?=$data->service_date?></td>
      <td><?=$data->item_name?></td>
      <td><?=find_a_field('dealer_info','dealer_name_e','dealer_code="'.$data->client_id.'"')?></td>
      <td><?=$data->invoice_no?></td>
	  <td><?=$data->invoice_date?></td>
      <td><?=$data->serial_no?></td>
	  <td><?=$data->problem?></td>
	  <td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$data->engineer.'"');?></td>
	  <td><?=$data->status?></td>
    </tr>
    <?php }?>

  </tbody>
</table>



<? 

}

elseif(isset($sql)&&$sql!='') {echo report_create($sql,1,$str);}

}


?>



</div>



</body>



</html>



