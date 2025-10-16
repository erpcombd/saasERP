<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once "../../../controllers/core/class.numbertoword.php";
$group = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');

$pr_no		= $_REQUEST['pr_no'];

			
		  $barcode_content = $pr_no;
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







$sql_ms="select * from production_receive_master where pr_no='$pr_no'";

$ms_data=mysqli_fetch_object(db_query($sql_ms));

$company=find_all_field('user_group','','id='.$ms_data->group_for);

$whouse=find_all_field('warehouse','','warehouse_id='.$ms_data->warehouse_id);


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title>.: Production Receive :.</title>



<link href="../../../../public/assets/css/invoice.css" type="text/css" rel="stylesheet"/>

<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>

<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";



}



</script>

<style>
  .print-only { display: none; }
  @media print {
    .print-only { display: block;
      position: absolute;
       bottom: 0;
    
    }

    .print-bg-row{
      background-color: #CFFCF0 !important;
      -webkit-print-color-adjust: exact; /* for Chrome, Safari */
      print-color-adjust: exact;         /* for Firefox */
      color-adjust: exact;               /* older spec */
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
    /* margin: 0 auto;           Center the table if needed */
    /* border-collapse: collapse; */
  }

  body {
    margin: 0;  /* Remove default print margins */
  }
  }
</style>


</head>



<body>



<form action="" method="post">



<table  border="0" cellspacing="0" cellpadding="0" align="center" style="width:80%;">

<!-- ------------------------ -->

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
										<td><div class="header">
											<table class="table1">
											<tr>
											<td class="logo">
												<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/>
											</td>
											
											<td class="titel">
													<h2 class="text-titel"> <?=$group->group_name?> </h2>			
													<p class="text"><?=$group->address?></p>
													<p class="text">Cell: <?=$group->mobile?>. Email: <?=$group->email?> <br> <?=$group_data->vat_reg?></p>
													<p class="text">
														 <? $war=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);
														  echo $war->warehouse_name;?>
													</p>
											</td>
											
											
											<td class="Qrl_code">
														<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
												<p class="qrl-text"><?=$_GET['pr_no']?></p>
											</td>
											
											</tr>
											 
											</table>
										</div></td>
									  </tr>
									
									<tr>
										<td><hr style="border:1px solid #000000;" /></td>
									</tr>
									
									<tr>
   <td colspan="2" align="center"><h4 class="print-bg-table" style="font-size:18px;background-color: #068F0A;color:white; width: 40%; padding:5px 0; border:2px solid #000000; margin: 8px 0;  border-radius: 5px; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px; text-transform:uppercase;">Production Receive</h4></td>
  </tr>
									
									
							
									
							  
							  
						  </table>						  </td>                    </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
       </div></td>


</tr>
<!-- ----------------- -->


  <tr>
    <td colspan="0" align="center"><hr /></td>
  </tr>
  
 
  
<tr> 
   <td>

<!-- Production Receive Header Item start Here  by shakhawat-->

<div style="width:100%; display:flex; justify-content:space-between; gap:10px; margin-top:20px;">

 <!-- LEFT SIDE -->
<div style="width:48%; padding:5px;">
  
  <!-- Row 1 -->
  <div style="display:flex; align-items:center; margin-bottom:5px;">
    <span style="width:30%; font-size:16px; font-weight:bold;">Product Name</span>
    <span style="width:5%; font-size:16px; font-weight:bold; text-align:center;">:</span>
    <h1 style="width:50%; font-size:16px; font-weight:normal; border:1px solid #000; margin:0; padding:3px 0 3px 5px;">
      <?= find_a_field('item_info','item_name','item_id="'.$ms_data->fg_item_id.'"');?>
    </h1>
  </div>

  <!-- Row 2 -->
  <div style="display:flex; align-items:center; margin-bottom:5px;">
    <span style="width:30%; font-size:16px; font-weight:bold;">Product Qty</span>
    <span style="width:5%; font-size:16px; font-weight:bold; text-align:center;">:</span>
    <h1 style="width:50%; font-size:16px; font-weight:normal; border:1px solid #000; margin:0; padding:3px 0 3px 5px;">
      <?= $ms_data->pr_qty;?> <?= $ms_data->unit_name;?>
    </h1>
  </div>

  <!-- Row 3 -->
  <div style="display:flex; align-items:center;">
    <span style="width:30%; font-size:16px; font-weight:bold;">Factory Unit</span>
    <span style="width:5%; font-size:16px; font-weight:bold; text-align:center;">:</span>
    <h1 style="width:50%; font-size:16px; font-weight:normal; border:1px solid #000; margin:0; padding:3px 0 3px 5px;">
      <?=$whouse->warehouse_name;?>
    </h1>
  </div>

</div>



  <!-- RIGHT SIDE -->
  <div style="width:48%; display:flex; flex-direction:column; align-items:flex-end; padding-right:10px; gap:10px;">
    
    <div style="display:flex; align-items:center; width:100%; justify-content:flex-end; gap:10px;">
      <span style="font-size:14px; font-weight:bold; white-space:nowrap;">PR No <strong>:</strong> </span>
      <h1 style="flex:0 0 50%; font-size:16px; font-weight:normal; border:1px solid #000; padding:3px 0 3px 5px; margin:0;">
        &nbsp; <?=$ms_data->inv_type;?><?=$_GET['pr_no']?>
      </h1>
    </div>

    <div style="display:flex; align-items:center; width:100%; justify-content:flex-end; gap:10px;">
      <span style="font-size:14px; font-weight:bold; white-space:nowrap;">PR Date <strong>:</strong></span>
      <h1 style="flex:0 0 50%; font-size:16px; font-weight:normal; border:1px solid #000; padding:3px 0 3px 5px; margin:0;">
        &nbsp; <?= date("d-m-Y",strtotime($ms_data->pr_date));?>
      </h1>
    </div>
    <div style="display:flex; align-items:center; width:100%; justify-content:flex-end; gap:10px;">
      <span style="font-size:14px; font-weight:bold; white-space:nowrap;">BATCH No <strong>:</strong></span>
      <h1 style="flex:0 0 50%; font-size:16px; font-weight:normal; border:1px solid #000; padding:3px 0 3px 5px; margin:0;">
        &nbsp; <a href="../BATCH/invoice_print_view.php?batch_no=<?=$ms_data->batch_no;?>" target="_blank"> BATCH-<?= $ms_data->batch_no;?></a>
      </h1>
    </div>

  </div>
</div>



 </div>


<!-- Production Receive Header Item end Here -->

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



          <td>

          <div style="float:center; margin:10px 0;" width="50%">
				  <input style="background-color:#CFFCF0; border-radius:3px; cursor:pointer; padding:5px 15px; font-weight:bold;" name="button" id="print" type="button" onclick="hide(); window.print();" value="Print" float="center" onmouseover="this.style.backgroundColor='#A8E6D1';"
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
       <tr>

        <td width="5%"  class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>SL</strong></td>
        <td width="21%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong> Ledger Group </strong></td>
        <td width="57%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>Ledger Name</strong></td>
        <td width="17%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong> Amount </strong></td>
      </tr>

	  <?php



$final_amt=0;



$pi=0;



$total=0;



	 $sql2="select l.group_name, a.ledger_id, a.ledger_name, f.final_foe_amt as amount
	from ledger_group l, accounts_ledger a, production_factory_overhead f where l.group_id=a.ledger_group_id and f.ledger_id=a.ledger_id and f.pr_no='".$pr_no."'
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

<tr style="background-color:#CFFCF0;" class="print-bg-row">



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
         <td colspan="7" align="center"><strong>Raw Materials Consumption </strong></td>
         </tr>
       <tr>

        <td width="4%"  class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>SL</strong></td>
        <td width="21%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong> Category </strong></td>
        <td width="45%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong> Item Description </strong></td>
        <td width="12%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>Unit</strong></td>
        <td width="18%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>Price</strong></td>
        <td width="18%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>Quantity </strong></td>
        <td width="18%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>Amount</strong></td>
       </tr>

	  <?php



$final_amt=0;



$pi=0;



$total=0;



$sql3="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.unit_name, i.finish_goods_code from production_rm_consumption a, item_info i, item_sub_group s where  a.item_id=i.item_id  and i.sub_group_id=s.sub_group_id and a.pr_no='".$pr_no."'  order by i.sub_group_id, i.item_name";



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
        <td valign="top"><?=number_format($info2->unit_price,2);?></td>
        <td valign="top"><?=number_format($info2->total_unit,2);?></td>
        <td valign="top"><?=number_format($info2->total_amt,2); $tot_rm_amt +=$info2->total_amt;?></td>
</tr>



<? }?>


<tr style="background-color: #CFFCF0;" class="print-bg-row">



        <!-- <td valign="top"></td> -->

        <!-- <td valign="top"  align="left">&nbsp;</td> -->
        <td colspan="6" align="right" valign="top"><strong>Total:</strong></td>
        <!-- <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td> -->
        <td valign="top"><strong><?=number_format($tot_rm_amt,2); ?></strong></td>
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
         <td colspan="7" align="center"><strong>Production Cost (FG & By Product) </strong></td>
         </tr>
       <tr>

        <td width="4%"  class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>SL</strong></td>
        <td width="21%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong> Category </strong></td>
        <td width="45%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong> Item Description </strong></td>
        <td width="12%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>Unit</strong></td>
        <td width="18%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>Price</strong></td>
        <td width="18%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>Quantity </strong></td>
        <td width="18%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>Amount</strong></td>
       </tr>

	  <?php



$final_amt=0;



$pi=0;



$total=0;



$sql4="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.unit_name, i.finish_goods_code from production_receive_detail a, item_info i, item_sub_group s where  a.item_id=i.item_id  and i.sub_group_id=s.sub_group_id and a.pr_no='".$pr_no."'  order by i.sub_group_id, i.item_name";



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
        <td valign="top"><?=number_format($info4->unit_price,3);?></td>
        <td valign="top"><?=number_format($info4->total_unit,2);?></td>
        <td valign="top"><?=number_format($info4->total_amt,2); $tot_fg_amt +=$info4->total_amt;?></td>
</tr>



<? }?>


<tr style="background-color: #CFFCF0;" class="print-bg-row">



        <!-- <td valign="top"></td> -->

        <!-- <td valign="top"  align="left">&nbsp;</td> -->
        <td colspan="6" align="right" valign="top"><strong>Total:</strong></td>
        <!-- <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td> -->
        <td valign="top"><strong><?=number_format($tot_fg_amt,2); ?></strong></td>
</tr>
    </table>	</td>
	</tr>
	
	
		<tr>

<td>&nbsp;

</td></tr>
	


<!--<tr>

<td>


<table width="100%" class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0">

       <tr>
         <td colspan="7" align="center"><strong>Production Cost (By Product) </strong></td>
         </tr>
       <tr>

        <td width="4%"  class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>SL</strong></td>
        <td width="21%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong> Category </strong></td>
        <td width="45%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong> Item Description </strong></td>
        <td width="12%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>Unit</strong></td>
        <td width="18%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>Price</strong></td>
        <td width="18%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>Quantity </strong></td>
        <td width="18%" class="print-bg-table" style="background-color: #068F0A;color:white;"><strong>Amount</strong></td>
       </tr>

	  <?php



$final_amt=0;



$pi=0;



$total=0;



$sql5="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.unit_name, i.finish_goods_code from batch_by_product a, item_info i, item_sub_group s where  a.item_id=i.item_id  and i.sub_group_id=s.sub_group_id and a.batch_no='".$ms_data->batch_no."'  order by i.sub_group_id, i.item_name";



$data5=db_query($sql5);



//echo $sql2;



while($info5=mysqli_fetch_object($data5)){ 



$pi++;


$sl=$pi;



?>



<tr>



        <td valign="top"><?=$sl?></td>

        <td valign="top"  align="left"><?=$info5->sub_group_name;?></td>
        <td align="left" valign="top"><?=$info5->item_name;?></td>
        <td valign="top"><?=$info5->unit_name;?></td>
        <td valign="top"><?=number_format($info5->unit_price,3);?></td>
        <td valign="top"><?=number_format($info5->final_qty,2);?></td>
        <td valign="top"><?  $amount = ($info5->unit_price*$info5->final_qty); echo number_format($amount,2); $tot_by_amt +=$amount;?></td>
</tr>



<? }?>


<tr style="background-color: #CFFCF0;" class="print-bg-row">



         <td valign="top"></td> 

         <td valign="top"  align="left">&nbsp;</td> 
        <td colspan="6" align="right" valign="top"><strong>Total:</strong></td>
         <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td> 
        <td valign="top"><strong><?=number_format($tot_by_amt,2); ?></strong></td>
</tr>
    </table>	</td>
	</tr>-->



<tr>

<td>

      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >



        <tr style=" font-weight:500; letter-spacing:.3px;">
          <td colspan="4" width="100%">&nbsp;</td>
        </tr>
        <?php /*?><tr style="font-size:16px; font-weight:500; letter-spacing:.3px;">



		<td colspan="4">
		
		In Word: <?

		

		$scs =  $tot_total_amt;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa. ';}

	 echo ' Only';

		?>.		</td>
          </tr><?php */?>





        <tr>
          <td colspan="4" align="right">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="4" align="right">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="right">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="right">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="right">&nbsp;</td>
        </tr>
        
        
        
        <tr>
          <td colspan="4" align="right">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="right">&nbsp;</td>
          </tr>
        <tr>

          <td colspan="4" align="right">&nbsp;</td>
          </tr>

		



		



        <tr>
          <td width="25%" align="center"><?=find_a_field('user_activity_management','fname','user_id='.$ms_data->entry_by);?></td>
          <td  width="25%" align="center">&nbsp;</td>
          <td width="25%" align="center">&nbsp;</td>
          <td width="25%" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">-------------------------------</td>
          <td align="center">-------------------------------</td>
          <td align="center">-------------------------------</td>
          <td align="center">-------------------------------</td>
        </tr>
        <tr>
          <td align="center"><strong>Prepared By</strong></td>
          <td align="center"><strong>Production Manager</strong></td>
          <td align="center"><strong>Account's Officer </strong></td>
          <td align="center"><strong>Executive Director</strong></td>
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
      </table></td>
  </tr>
</table>



</form>



</body>



</html>



