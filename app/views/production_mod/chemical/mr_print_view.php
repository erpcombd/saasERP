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
	$ssql='update master_requisition_master set status="'.$_GET['req_status'].'" where req_no="'.$req_no.'"';
	db_query($ssql);
}

$sql="select * from master_requisition_master where  req_no='$req_no'";



$data=db_query($sql);



$all=mysqli_fetch_object($data);



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
</head>
<body>

<table style="width:800px; margin:0px auto;" border="0" cellspacing="0" cellpadding="0">

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
				<td colspan="3"><hr /></td>
			</tr>

        	<tr>


                <td colspan="3" align="center">

                	<h1><?
					
					 if($_SESSION['user']['depot']>0)

					  $warehouse =  find_all_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);?></h1>

                    <h6>Warehouse/Store: <?=$warehouse->address;?></h6>

                    <h6><span align="center" style="border:1px solid #000000; padding:2px;width:180px;">

						Store Requisition</span>

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

       <table style="font-size:14px;font-weight:600; width:800px; margin:0px auto;">

       <tr><td>

<div style="float:left">

        SI.  No : <?php echo $all->req_no;?><br />

        Section: <?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$all->req_for);?><br />


<div style="float:right;">
				Manual Req no : <?php echo $all->manual_req_no;?><br />

			 Requisition For : <?php echo $all->req_date;?><br />
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
				<div style="float:center;" width="50%">
				  <input name="button" id="print" type="button" onclick="hide();" value="print" float="center"/>
				</div>
		  </td>
	  </tr>
    </table>
	
	


<table style=" width:800px; margin:0px auto" class="" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">



       <thead>



  <th rowspan="1" width="2%"><strong>SL.</strong></th>

<!--

        <td><strong>REQ-ID</strong></td>-->

		<th width="17%" rowspan="1" ><strong>Product Name</strong></th>

        <th width="26%" rowspan="1" ><strong>Item Description </strong></th>
		<th width="10%" rowspan="1" ><strong>CWH</strong></th>

		<th width="7%" rowspan="1" ><strong> Req. Qty</strong></th>

        <th width="7%" rowspan="1" ><strong> App. Qty</strong></th>

        <th width="10%" rowspan="1" ><strong> Unit</strong></th>

        <th width="14%" rowspan="1" ><strong> Delivery Date</strong></th>

        <th width="17%" rowspan="1" ><strong>Remarks</strong></th></thead>

	  <?php



$final_amt=(int)$data1[0];



$pi=0;



$total=0;



$sql2="select * from master_requisition_details where  req_no='$req_no'";



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
		
		

        <td align="left" valign="top"><?=number_format(find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$item->item_id.'" and warehouse_id =12'),2);?></td>
		
		

		<td align="right" valign="top"><?=number_format($order_qty,2,".",",")?></td>

        <td align="right" valign="top"><?=number_format($qty,2,".",",")?></td>

        <td  align="center" ><?=$item->unit_name?></td>

        <td align="center" valign="top"><? echo substr($info->exp_date,2,10);?></td>

		<td align="right" valign="top"><?=$info->remarks?></td>

      </tr>

      

     



<? }?>



</table>

   

    <div style="width:800px; margin:0px auto;">

    	Note : <?php echo $all->req_note;?><br />

    </div>

    <table style=" width:800px; margin:0px auto">

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


</table>

<table>





</table>



</body>



</html>



