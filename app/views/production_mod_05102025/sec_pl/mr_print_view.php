<?php







session_start();







//====================== EOF ===================




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$req_no 		= $_REQUEST['req_no'];

$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);







		  $barcode_content = $req_no;

		  $barcodeText = $barcode_content;

          $barcodeType='code128';

		  $barcodeDisplay='horizontal';

          $barcodeSize=40;

          $printText='';



if($_GET['update']=='Update'){

	$req_status = $_GET['req_status'];

	$ssql='update pl_issue_master set status="'.$_GET['req_status'].'" where req_no="'.$req_no.'"';

	db_query($ssql);

}



$sql="select * from pl_issue_master where  req_no='$req_no'";







$data=db_query($sql);







$all=mysqli_fetch_object($data);



$tr_type="Show";




?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">







<html xmlns="http://www.w3.org/1999/xhtml">







<head>







<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />







<title>.: Cash Memo :.</title>







<link href="../../css/invoice.css" type="text/css" rel="stylesheet"/>



<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>



<script type="text/javascript">







function hide()







{

    document.getElementById("pr").style.display="none";

}



</script>


<style>
  .print-only{display: none;}
@media print {
  .print-only { 
        display: block;
       position: absolute;
       bottom: 0;
      }
  
  .print-bg-table {
    background-color: #068F0A !important;
    -webkit-print-color-adjust: exact; /* for Chrome, Safari */
    print-color-adjust: exact;         /* for Firefox */
    color-adjust: exact;               /* older spec */
  }

  table {
    width: 95% !important;   /* Take full printable area */
    max-width: 95% !important;
    /* margin: 0 auto;         */
    /* border-collapse: collapse; */
  }

  
}
</style>

</head>

<body>



<table style="width:80%; margin:0px auto;" border="0" cellspacing="0" cellpadding="0">



			<tr>

				<td class="logo">

					<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/>

				</td>

				

				<td class="titel">

						<h2 class="text-titel"> <?=$group_data->group_name?> </h2>			

						<p class="text"><?=$group_data->address?></p>

						<p class="text">Cell: <?=$group_data->mobile?>. Email: <?=$group_data->email?> <br> <?=$group_data->vat_reg?></p>

				</td>

				

				

				<td class="Qrl_code">

							<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>

					<p class="qrl-text"><?php echo $all->manual_req_no;?></p>

				</td>

				

			</tr>

			<tr>

				<td colspan="3"><hr style="border:1px solid #000000" /></td>

			</tr>



        	<tr>





                <td colspan="3" align="center">



                	<h1><?

					

					 if($_SESSION['user']['depot']>0)



					  $warehouse =  find_all_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);?></h1>



                    <h6>Warehouse/Store: <?=$warehouse->address;?></h6>



                    <h6><h6 align="center" class="print-bg-table" style="border:1px solid #000000;background-color:#068F0A; color:white; padding:8px 0; border-radius:2px; width:15%;">



						Store PL Issue </h6>



					</h6>

                    <strong>

		      <? $war=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);

              ?>

		    </strong>



              </td>

            </tr>

			

			



			<tr>



                <td align="center" colspan="3">







				</td>







  </tr>



		  <tr>







		    <td align="center" valign="bottom" colspan="3"></td>







  </tr>







</table>



       <table style="font-size:14px;font-weight:600; width:80%; margin:0px auto;">



       <tr><td>


       <div style="width:48%; padding:5px; margin:20px 0;">
  
  <!-- Row 1 -->
  <div style="display:flex; align-items:center; margin-bottom:5px;">
    <span style="width:30%; font-size:16px; font-weight:bold;">SI.  No</span>
    <span style="width:5%; font-size:16px; font-weight:bold; text-align:center;">:</span>
    <h1 style="width:55%; font-size:16px; font-weight:normal; border:1px solid #000; margin:0; padding:3px 0 3px 5px;">
      <?php echo $all->req_no;?>
    </h1>
  </div>

  <!-- Row 2 -->
  <div style="display:flex; align-items:center; margin-bottom:5px;">
    <span style="width:30%; font-size:16px; font-weight:bold;">Section</span>
    <span style="width:5%; font-size:16px; font-weight:bold; text-align:center;">:</span>
    <h1 style="width:55%; font-size:16px; font-weight:normal; border:1px solid #000; margin:0; padding:3px 0 3px 5px;">
      <?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$all->req_for);?>
    </h1>
  </div>

  <!-- Row 3 -->
  <div style="display:flex; align-items:center;">
    <span style="width:30%; font-size:16px; font-weight:bold;">Manual Req no</span>
    <span style="width:5%; font-size:16px; font-weight:bold; text-align:center;">:</span>
    <h1 style="width:55%; font-size:16px; font-weight:normal; border:1px solid #000; margin:0; padding:3px 0 3px 5px;">
      <?php echo $all->manual_req_no;?>
    </h1>
  </div>
  <!-- Row 4 -->
  <div style="display:flex; align-items:center;">
    <span style="width:30%; font-size:16px; font-weight:bold;">Requisition For</span>
    <span style="width:5%; font-size:16px; font-weight:bold; text-align:center;">:</span>
    <h1 style="width:55%; font-size:16px; font-weight:normal; border:1px solid #000; margin-top:5px; padding:3px 0 3px 5px;">
      <?php echo $all->req_date;?>
    </h1>
  </div>

</div>

      </td>

      </tr>

	  

	  <tr>

		  <td>

		  	       

				<script>

					function hide(){

					document.getElementById("print").style.display="none";

					window.print();

					}

				</script>

						 

						  <!--Present Status : <?php //echo $all->status;?><br />-->      </div>

				<div style="float:center; margin:10px 0;" width="50%">

				  <input name="button" style="padding: 2px 10px; font-weight:bold; background-color:#CFFCF0; border-radius:2px; " id="print" type="button" onclick="hide();" value="Print" float="center" onmouseover="this.style.backgroundColor='#A8E6D1';"
  onmouseout="this.style.backgroundColor='#CFFCF0';"/>

				</div>

		  </td>

	  </tr>

    </table>

	

	





<table style=" width:80%; margin:0px auto" class="" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">







       <thead>







  <th rowspan="1" width="2%"   style="background-color:#068F0A; color:white; font-size:14px; text-align:center;" class="print-bg-table"><strong>SL.</strong></th>
	<th width="17%" rowspan="1"  style="background-color:#068F0A; color:white; font-size:14px; text-align:center;" class="print-bg-table"><strong>Product Name</strong></th>
  <th width="26%" rowspan="1"  style="background-color:#068F0A; color:white; font-size:14px; text-align:center;" class="print-bg-table"><strong>Item Description </strong></th>
	<th width="10%" rowspan="1"  style="background-color:#068F0A; color:white; font-size:14px; text-align:center;" class="print-bg-table"><strong>CWH</strong></th>
	<th width="7%" rowspan="1"   style="background-color:#068F0A; color:white; font-size:14px; text-align:center;" class="print-bg-table"><strong> Req. Qty</strong></th>
  <th width="7%" rowspan="1"   style="background-color:#068F0A; color:white; font-size:14px; text-align:center;" class="print-bg-table"><strong> App. Qty</strong></th>
  <th width="10%" rowspan="1"  style="background-color:#068F0A; color:white; font-size:14px; text-align:center;" class="print-bg-table"><strong> Unit</strong></th>
  <th width="14%" rowspan="1"  style="background-color:#068F0A; color:white; font-size:14px; text-align:center;" class="print-bg-table"><strong> Delivery Date</strong></th>
  <th width="17%" rowspan="1"  style="background-color:#068F0A; color:white; font-size:14px; text-align:center;" class="print-bg-table"><strong>Remarks</strong></th></thead>



	  <?php







$final_amt=(int)$data1[0];







$pi=0;







$total=0;







$sql2="select * from pl_issue_details where  req_no='$req_no'";







$data2=db_query($sql2);







//echo $sql2;







while($info=mysqli_fetch_object($data2)){ 







$pi++;







$amount=$info->qty*$info->rate;







$total=$total+($info->qty*$info->rate);







$sl=$pi;







$item=find_all_field('item_info','','item_id='.$info->item_id);







$qty=$info->qty;



$order_qty=$info->order_qty;







$qoh=$info->qoh;







$last_p_date=$info->last_p_date;







$last_p_qty=$info->last_p_qty;



$entry_by=$info->entry_by;







?>







      <tr>







        <td valign="top" align="center"><?=$sl;?></td>







        <!--<td align="left" valign="top"><?=$info->id?></td>-->







        <td align="left" valign="top"><?=$item->item_name?></td>



        <td align="left" valign="top"><? ?></td>

		

		



        <td  valign="top" style="text-align: right;"><?=number_format(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$item->item_id.'" and warehouse_id =12'),2);?></td>

		

		



		<td align="right" valign="top"><?=number_format($order_qty,2,".",",")?></td>



        <td align="right" valign="top"><?=number_format($qty,2,".",",")?></td>



        <td  align="center" ><?=$item->unit_name?></td>



        <td align="center" valign="top"><? echo substr($info->exp_date,2,10);?></td>



		<td  style="text-align: center;" valign="top"><?=$info->remarks?></td>



      </tr>



    


<? }?>







</table>



   



    <div style="width:80%; margin:0px auto;">



    	Note : <?php echo $all->req_note;?><br />



    </div>



    <table style=" width:80%; margin:0px auto">



    <tr>



    	<td></td>



        <td></td>



        <td></td>



        <td></td>



    </tr>



    <tr>



    	<td></td>



        <td></td>



        <td></td>



        <td></td>



    </tr>



    <tr>



    	<td></td>



        <td></td>



        <td></td>



        <td></td>



    </tr>



    <tr>



    	<td height="38"></td>



        <td></td>



        <td></td>



        <td></td>



        <td></td>



    </tr>

	<tr>



    <td width="135" align="center"><?=find_a_field('user_activity_management','fname',' user_id='.$entry_by) ;?></td>



	<td width="141" align="center">&nbsp;</td>



	<td width="120" align="center">&nbsp;</td>                  



    <td width="172" align="center">&nbsp;</td>



    <td width="172" align="center">&nbsp;</td>



  </tr>



     <tr>



    <td width="135" align="center">-------------------</td>



	<td width="141" align="center">---------------------</td>



	<td width="120" align="center">-------------------</td>                  



    <td width="172" align="center">------------------------</td>



    <td width="172" align="center">-----------------------</td>



  </tr>



  <tr>



  	<td align="center">Prepared By</td>



	<td align="center">Authorised By</td>



	<td align="center">Checked By</td>                    



    <td align="center">Delivered By</td>



    <td width="108" align="center">Received by</td> 



    



  </tr></table>



  



 







<table style=" width:800px; margin:0px auto" border="0" cellspacing="0" cellpadding="0" align="center">







  <tr>







    <td><div class="header">







	<table style=" width:800px; margin:0px auto" border="0" cellspacing="0" cellpadding="0">



	  <tr>



	    <td>



       		</td>







	  </tr>







    </table>







    </div></td>







  </tr>







  <tr>







    







	<td>	</td>







  </tr>







  <tr>







    <td></td>







  </tr>







  



  <tr>







    <td>















<form action="" method="get">















<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">







  <tr>







    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>







    <td width="100" align="right">Present Status:</td>







    <td width="1">







    







    <select name="req_status">







    <option><?=$all->status;?></option>







    <option>PENDING</option>







    <option>STOPPED</option>







    <option>CANCELED</option>







    <option>COMPLETE</option>







    </select></td>







    <td><input name="update" type="submit" value="Update" /><input type="hidden" name="req_no" id="req_no" value="<?=$req_no?>" /></td>







  </tr>







</table>-->



</form>







    



    </td>







  </tr>



<tr>



	<td colspan="3"><?php include("../../../assets/template/report_print_buttom_content.php");?></td>



   



</tr>




<tr>
  <td colspan="3" style="text-align:left;">
    <div 
      style=" left: 0; right: 0; margin: 0 auto; max-width: 1000px; font-size: 12px; text-align:left;" 
      class="print-only">
      <?php require_once "../../../controllers/routing/report_print_buttom_content.php";?>
    </div>
  </td>
</tr>



</table>




</body>







</html>

<?
$page_name="Store PL Issue";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>