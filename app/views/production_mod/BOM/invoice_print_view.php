<?php

require_once "../../../controllers/routing/print_view.top.php";

$bom_no = url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

//$bom_no		= url_decode(str_replace(' ', '+', $_REQUEST['bom_no']));

		$barcode_content = $bom_no;
		$barcodeText = $barcode_content;
        $barcodeType='code128';
	    $barcodeDisplay='horizontal';
        $barcodeSize=40;
        $printText='';


if(isset($_POST['cash_discount']))
{
	$po_no = $_POST['po_no'];
	$cash_discount = $_POST['cash_discount'];
	$ssql='update purchase_sp_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';
	db_query($ssql);
}

$sql_ms="select * from bom_master where bom_no='$bom_no'";

$ms_data=mysqli_fetch_object(db_query($sql_ms));


$group_data = find_all_field('user_group','group_name','id='.$ms_data->group_for);

$company=find_all_field('user_group','','id='.$ms_data->group_for);
$whouse=find_all_field('warehouse','','warehouse_id='.$ms_data->warehouse_id);


$tr_type="Show";



?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">






<head>







<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />







<title>.: Bill of Materials (BOM) :.</title>







<link href="../../../../public/assets/css/invoice.css" type="text/css" rel="stylesheet"/>





<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>

<script type="text/javascript">






function hide()

{
    document.getElementById("pr").style.display="none";

}







</script>







<style type="text/css">







<!--







@font-face {

  font-family: 'MYRIADPRO-REGULAR';

  src: url('MYRIADPRO-REGULAR.OTF'); /* IE9 Compat Modes */



}



@font-face {

  font-family: 'TradeGothicLTStd-Extended';

  src: url('TradeGothicLTStd-Extended.otf'); /* IE9 Compat Modes */



}





@font-face {

  font-family: 'Humaira demo';

  src: url('Humaira demo.otf'); /* IE9 Compat Modes */



}









.style4 {







	font-size: 12px;







	font-weight: bold;







}



.style5 {font-weight: bold}



.style6 {font-weight: bold}



.style7 {font-weight: bold}



.style9 {font-weight: bold}



.style10 {font-weight: bold}







-->




.print-only { display: none; }
  @media print {

   .print-only {
        display: block;
    position: absolute;
    bottom: 0;
        left: 0;
        max-width: 1000px !important;         /* full width */
        padding: 5px 0;      /* optional spacing */
        margin: 0;           /* remove body or div margin */
        box-sizing: border-box;
        text-align: center;  /* optional alignment */
  }
     

    .print-bg-table {
    background-color: #068F0A !important;
    -webkit-print-color-adjust: exact; /* for Chrome, Safari */
    print-color-adjust: exact;         /* for Firefox */
    color-adjust: exact;               /* older spec */
  }

  table {
    width: 100% !important;   /* Take full printable area */
    max-width: 100% !important;
    margin: 0 auto;        
    /* border-collapse: collapse; */
  }
  }

 @page {
		
		@bottom-center {
		  content: "Page " counter(page) " of " counter(pages);
		}
  }
</style></head>







<body>







<form action="" method="post">







<table  style="width:80%; margin:0 auto;" border="0" cellspacing="0" cellpadding="0" align="center">







  <tr>







    <td align="center"><div class="header" style="margin-top:0;">

       <table width="100%" border="0" cellspacing="0" cellpadding="0">

    

		  <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr>

                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td width="100%"> 

							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0; text-align:center; " >

								
									<tr>
										<td class="logo">
											<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
										</td>
										
										<td class="titel">
												<h2 class="text-titel"> <?=$group_data->group_name?> </h2>			
												<p class="text"><?=$group_data->address?></p>
												<p class="text">Cell: <?=$group_data->mobile?>. Email: <?=$group_data->email?> </p>
										</td>
										
										
										<?php /*?><td class="Qrl_code">
													<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
											<p class="qrl-text"> <?=url_decode($_GET['bom_no']);?></p>
										</td><?php */?>
										
										
										<td class="qr-code">
        <?php 
		$company_id=url_encode($cid);
        $req_no_qr_data = url_encode($bom_no);
        $print_url = "https://saaserp.ezzy-erp.com/app/views/production_mod/BOM/invoice_print_view.php?c=".rawurlencode($company_id)."&v=" . rawurlencode($req_no_qr_data);
        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);
        ?>
        <img src="<?=$qr_code?>" alt="QR Code" style=" width: 110px; height: 110px; ">
    </td>
										
									</tr>
									<tr>
										<td colspan="3"><hr style="border:1px solid #000000" /></td>
									</tr>

									

									<tr>

   <td colspan="3" align="center"><h4 class="print-bg-table" style="font-size:18px; width: 40%;background-color:#068F0A; color:white; padding:5px 0; margin:0; border:2px solid #000000; margin: 8px 0;  border-radius: 5px; font-family:  'MYRIADPRO-REGULAR'; font-weight:bold; letter-spacing:1px; text-transform:uppercase;">Bill of Materials (BOM)</h4></td>

  </tr>

			
						  </table>						  </td>                    </tr>

                    </table></td>

                </tr>

              </table></td>

          </tr>

        </table>

       </div></td>

  </tr>







  <tr>

    <td colspan="0" align="center"><hr /></td>

  </tr>

  

 

  

  

  <tr> <td>

 <!--Bill of Materials content items  start Here by shakhawat-->

<div style="width:100%; display:flex; justify-content:space-between; gap:10px; margin-top:20px;">

 <!-- LEFT SIDE -->
<div style="width:48%; padding:5px;">
  
  <!-- Row 1 -->
  <div style="display:flex; align-items:center; margin-bottom:5px;">
    <span style="width:30%; font-size:16px; font-weight:bold;">Product Name</span>
    <span style="width:5%; font-size:16px; font-weight:bold; text-align:center;">:</span>
    <h1 style="width:50%; font-size:16px; font-weight:normal; border:1px solid #000; margin:0; padding:3px 0 3px 5px;">
       &nbsp; <?= find_a_field('item_info','item_name','item_id="'.$ms_data->fg_item_id.'"'); ?>
    </h1>
  </div>

  <!-- Row 2 -->
  <div style="display:flex; align-items:center; margin-bottom:5px;">
    <span style="width:30%; font-size:16px; font-weight:bold;">Quantity</span>
    <span style="width:5%; font-size:16px; font-weight:bold; text-align:center;">:</span>
    <h1 style="width:50%; font-size:16px; font-weight:normal; border:1px solid #000; margin:0; padding:3px 0 3px 5px;">
      &nbsp; <?= $ms_data->quantity; ?> <?= $ms_data->unit_name; ?>
    </h1>
  </div>

  

</div>



  <!-- RIGHT SIDE -->
  <div style="width:48%; display:flex; flex-direction:column; align-items:flex-end; padding-right:10px; gap:5px;">
    <!-- Row 1 -->
    <div style="display:flex; align-items:center; width:100%; justify-content:flex-end; gap:10px;">
      <span style="font-size:14px; font-weight:bold; white-space:nowrap;">BOM No <strong>:</strong> </span>
      <h1 style="flex:0 0 50%; font-size:16px; font-weight:normal; border:1px solid #000; padding:3px 0 3px 5px; margin:0;">
        &nbsp; <?=$ms_data->inv_type;?><?=url_decode($_GET['bom_no']);?>
      </h1>
    </div>
<!-- Row 2 -->
    <div style="display:flex; align-items:center; width:100%; justify-content:flex-end; gap:10px;">
      <span style="font-size:14px; font-weight:bold; white-space:nowrap;">BOM Date <strong>:</strong></span>
      <h1 style="flex:0 0 50%; font-size:16px; font-weight:normal; border:1px solid #000; padding:3px 0 3px 5px; margin:0;">
        &nbsp; <?= date("d-m-Y",strtotime($ms_data->bom_date));?>
      </h1>
    </div>
    

  </div>
</div>



 </div>
<!--Bill of Materials content items  start Here -->

    
  </td>
</tr>
  
    <tr>

		<td>&nbsp;</td>

	</tr>


  <tr>

    <td><div id="pr">

      <div align="left">
          <table width="60%" border="0" cellspacing="0" cellpadding="0">


        <tr>
          <td >
            <div style="float:center; margin:10px 0;" width="50%">
				  <input style="background-color:#CFFCF0; border-radius:3px; padding:2px 10px; font-weight:bold;" name="button" id="print" type="button" onclick="hide();window.print();" value="Print" float="center" onmouseover="this.style.backgroundColor='#A8E6D1';"
  onmouseout="this.style.backgroundColor='#CFFCF0';"/>
				</div>
          </td>


        </tr>

      </table>

      </div>







    </div></td>

</tr>



<tr>



<td>





<table width="100%" class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0">



       <tr>

         <td colspan="4" align="center"><strong>Factory Overhead Cost</strong></td>

         </tr>

       <tr class="print-bg-table" style="font-size:12px; background-color:#068F0A; color:white;">



        <td width="5%"><strong>SL</strong></td>



        <td width="21%"><strong> Ledger Group </strong></td>

        <td width="57%"><strong>Ledger Name</strong></td>

        <td width="17%"><strong> Amount </strong></td>

      </tr>



	  <?php







$final_amt=0;







$pi=0;







$total=0;







	 $sql2="select l.group_name, a.ledger_id, a.ledger_name, f.amount

	from ledger_group l, accounts_ledger a, bom_factory_overhead f where l.group_id=a.ledger_group_id and f.ledger_id=a.ledger_id and f.bom_no='".$bom_no."'

	order by l.group_id, a.ledger_id";







$data2=db_query($sql2);







//echo $sql2;







while($info=mysqli_fetch_object($data2)){ 







$pi++;





$sl=$pi;





?>







<tr>







        <td valign="top"><?=$sl?></td>



        <td valign="top"  align="left"><?=$info->group_name;?></td>

        <td align="left" valign="top"><?=$info->ledger_name;?></td>

        <td align="right" valign="top"><?=number_format($info->amount,2); $sub_total_amt +=$info->amount;?></td>

      </tr>







<? }?>



<tr>







        <td colspan="3" valign="top"><div align="right"><strong> Total:</strong></div></td>



        <td align="right" valign="top"><strong><?=number_format($sub_total_amt,2); ?></strong></td>

      </tr>

    </table>	</td>

	</tr>

	

	

	

	<tr>



<td>&nbsp;



</td></tr>

	

<tr>



<td>





<table width="100%" class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0">



       <tr>

         <td colspan="5" align="center"><strong>Raw Materials Required</strong></td>

         </tr>

       <tr class="print-bg-table" style="font-size:12px; background-color:#068F0A; color:white;">



        <td width="4%"><strong>SL</strong></td>



        <td width="21%"><strong> Category </strong></td>

        <td width="45%"><strong> Item Description </strong></td>



        <td width="12%"><strong>Unit</strong></td>

        <td width="18%"><strong>Quantity </strong></td>

        </tr>



	  <?php







$final_amt=0;







$pi=0;







$total=0;







$sql3="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.finish_goods_code from bom_raw_material a, item_info i, item_sub_group s where  a.item_id=i.item_id  and i.sub_group_id=s.sub_group_id and a.bom_no='".$bom_no."' order by i.sub_group_id, i.item_name";







$data3=db_query($sql3);







//echo $sql2;







while($info2=mysqli_fetch_object($data3)){ 







$pi++;





$sl=$pi;







?>







<tr>







        <td valign="top"><?=$sl?></td>



        <td valign="top"  align="left"><?=$info2->sub_group_name;?></td>

        <td align="left" valign="top"><?=$info2->item_name;?></td>

        <td valign="top"><?=$info2->unit_name;?></td>

        <td valign="top"><?=number_format($info2->total_unit,5);?></td>

        </tr>







<? }?>

    </table>	</td>

	</tr>

	

		<tr>



<td>&nbsp;



</td></tr>


	

	

	



<tr>



<td>



      <table width="100%" class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0">



       <tr>

         <td colspan="6" align="center"><strong>By Product</strong></td>

         </tr>

       <tr class="print-bg-table" style="font-size:12px; background-color:#068F0A; color:white;">



        <td width="4%"><strong>SL</strong></td>



        <td width="21%"><strong> Category </strong></td>

        <td width="45%"><strong> Item Description </strong></td>



        <td width="12%"><strong>Unit</strong></td>
		
		<td width="12%"><strong>Ratio</strong></td>

        <td width="18%"><strong>Quantity </strong></td>

        </tr>



	  <?php







$final_amt=0;







$pi=0;







$total=0;







$sql4="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.finish_goods_code from bom_by_product a, item_info i, item_sub_group s where  a.item_id=i.item_id  and i.sub_group_id=s.sub_group_id and a.bom_no='".$bom_no."' order by i.sub_group_id, i.item_name";







$data4=db_query($sql4);







//echo $sql2;







while($info4=mysqli_fetch_object($data4)){ 







$pi++;





$sl=$pi;







?>







<tr>







        <td valign="top"><?=$sl?></td>



        <td valign="top"  align="left"><?=$info4->sub_group_name;?></td>

        <td align="left" valign="top"><?=$info4->item_name;?></td>

        <td valign="top"><?=$info4->unit_name;?></td>
		
		<td valign="top"><?=number_format($info4->rate_ratio,2);?></td>

        <td valign="top"><?=number_format($info4->total_unit,5);?></td>

        </tr>







<? }?>

    </table>
	  
	  
	  
	  </td>

  </tr>
  <tr>
  		<td colspan="3">&nbsp;</td>
  </tr>
  
   

</table>


<table>
  <tr class="print-only">
    <td>
      <?php include("../../../controllers/routing/report_print_buttom_content.php"); ?>
    </td>
  </tr>
</table>






</form>







</body>







</html>

<?
$page_name=" ";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>
