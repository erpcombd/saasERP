<?php

//require_once "../../../controllers/routing/default_values.php";
//require_once SERVER_CORE."routing/layout.top.php";
require_once "../../../controllers/routing/print_view.top.php";

//require_once "../../../controllers/core/class.numbertoword.php";


$batch_no=url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

//$batch_no		= $_REQUEST['batch_no'];







if(isset($_POST['cash_discount']))







{







	$po_no = $_POST['po_no'];







	$cash_discount = $_POST['cash_discount'];







	$ssql='update purchase_sp_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';







	db_query($ssql);







}















$sql_ms="select * from batch_master where batch_no='$batch_no'";



$ms_data=mysqli_fetch_object(db_query($sql_ms));



$company=find_all_field('user_group','','id='.$ms_data->group_for);



$whouse=find_all_field('warehouse','','warehouse_id='.$ms_data->warehouse_id);


$group = find_all_field('user_group', '', 'id="'.$ms_data->group_for.'"');



?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>







<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />







<title>.: Batch Assignment :.</title>







<link href="../../../../public/assets/css/invoice.css" type="text/css" rel="stylesheet"/>







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


@media print {
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

 @page {
		
		@bottom-center {
		  content: "Page " counter(page) " of " counter(pages);
		}
  }


</style></head>







<body>







<form action="" method="post">







<table style="width:80%;" border="0" cellspacing="0" cellpadding="0" align="center">





<!-- ------------Top Header Design start here by shakhawat ------------ -->

<!-- <tr>







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

									  <td style="padding-bottom:3px; "><span style="font-size:22px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$company->group_name?></span></td>

							  </tr>

							  

							  

									<tr><td style="font-size:16px; line-height:20px;"><?=$company->address?></td>

									</tr>

									



							  

						  </table>						  </td>                    </tr>

                    </table></td>

                </tr>

              </table></td>

          </tr>

        </table>

       </div></td>


</tr> -->



<tr>
  <td>
     <div style="display: flex; justify-content: space-between; align-items: center;">
  <div>
    <img style="width:200px" src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
  </div>

  <div >
    <div style="display:flex; flex-direction:column; align-items:center; line-height:1;">

      <h2 style="font-size: 30px; font-weight:bold; margin:0; line-height:1.5;">
        <?=$group->group_name?> 
      </h2>			

      

      <div style="text-align: left;">
        <p style="margin:0; line-height:2; font-size:14px;">
        <?=$group->address?>
      </p>
        <p style="margin:0; line-height:1; font-size:14px">
        Cell: <?=$group->mobile?>. Email: <?=$group->email?> <br> <?=$group_data->vat_reg?> 
      </p>

      
      </div>
    </div>
  </div>

  <div>
              <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($batch_no); // Change variable as needed
              $print_url = "https://saaserp.ezzy-erp.com/app/views/production_mod/BATCH/invoice_print_view.php?c=" . rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data);
              $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($print_url);
              ?>
              <img src="<?=$qr_code?>" alt="QR Code" style="width:100px; height:100px;">
   
  </div>
</div>

  </td>
</tr>




<!-- ---------Top header design end here-------------- -->




  <tr>

    <td colspan="0" align="center"><hr style="border: 1px solid black; margin:20px 0;" /></td>

  </tr>

  

 

  	<tr>

   <td colspan="2" align="center"><h4 class="print-bg-table" style="font-size:18px; width: 30%; background-color:#068F0A; color:white; padding:5px 0; margin:0; border:2px solid #000000; margin: 8px 0;  border-radius: 5px; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px; text-transform:uppercase;">Batch Assignment</h4></td>

  </tr>

  

  <tr> 
    
  <td>


  <!-- Batch Assignment Header Item start Here  by shakhawat-->

<div style="width:100%; display:flex; justify-content:space-between; gap:10px; margin-top:25px;">

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
    <span style="width:30%; font-size:16px; font-weight:bold;">Batch Qty</span>
    <span style="width:5%; font-size:16px; font-weight:bold; text-align:center;">:</span>
    <h1 style="width:50%; font-size:16px; font-weight:normal; border:1px solid #000; margin:0; padding:3px 0 3px 5px;">
      <?= $ms_data->batch_qty;?> <?= $ms_data->unit_name;?>
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
  <div style="width:48%; display:flex; flex-direction:column; align-items:flex-end; padding-right:10px; gap:5px;">
    
    <div style="display:flex; align-items:center; width:100%; justify-content:flex-end; gap:10px;">
      <span style="font-size:14px; font-weight:bold; white-space:nowrap;">Batch No <strong>:</strong> </span>
      <h1 style="flex:0 0 50%; font-size:16px; font-weight:normal; border:1px solid #000; padding:3px 0 3px 5px; margin:0;">
        &nbsp; <?=$ms_data->inv_type;?><?=$_GET['batch_no']?>
      </h1>
    </div>

    <div style="display:flex; align-items:center; width:100%; justify-content:flex-end; gap:10px;">
      <span style="font-size:14px; font-weight:bold; white-space:nowrap;">Batch Date <strong>:</strong></span>
      <h1 style="flex:0 0 50%; font-size:16px; font-weight:normal; border:1px solid #000; padding:3px 0 3px 5px; margin:0;">
        &nbsp; <?= date("d-m-Y",strtotime($ms_data->batch_date));?>
      </h1>
    </div>
    <div style="display:flex; align-items:center; width:100%; justify-content:flex-end; gap:10px;">
      <span style="font-size:14px; font-weight:bold; white-space:nowrap;">BOM No <strong>:</strong></span>
     <?php /*?> <h1 style="flex:0 0 50%; font-size:16px; font-weight:normal; border:1px solid #000; padding:3px 0 3px 5px; margin:0;">
        &nbsp; <a href="../BOM/invoice_print_view.php?bom_no=<?=$ms_data->bom_no;?>" target="_blank"> BOM-<a href="../BOM/invoice_print_view.php?bom_no=<?=$ms_data->bom_no;?>" target="_blank">
        <?= $ms_data->bom_no;?>
        </a></a>      </h1><?php */?>
		
		<h1 style="flex:0 0 50%; font-size:16px; font-weight:normal; border:1px solid #000; padding:3px 0 3px 5px; margin:0;">
  &nbsp;
  <a href="../BOM/invoice_print_view.php?c=<?=rawurlencode(url_encode($c_id));?>&v=<?=rawurlencode(url_encode($ms_data->bom_no));?>" target="_blank">
    BOM-<?= $ms_data->bom_no;?>
  </a>
</h1>


    </div>

  </div>
</div>



 </div>


<!-- Batch Assignment Header Item end Here -->
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







          <!--<td><span class="style3">Special Cash Discount: </span></td>







          <td><label>







            <input name="cash_discount" type="text" id="cash_discount" value="<?=$cash_discount?>" />







            </label>







            <input type="hidden" name="po_no" id="po_no" value="<?=$po_no?>" /></td>







          <td><label>







            <input type="submit" name="Update" value="Update" />







          </label></td>-->

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



        <td width="5%"  class="print-bg-table" style="background-color:#068F0A; color:white;"><strong>SL</strong></td>
        <td width="21%" class="print-bg-table" style="background-color:#068F0A; color:white;"><strong> Ledger Group </strong></td>
        <td width="57%" class="print-bg-table" style="background-color:#068F0A; color:white;"><strong>Ledger Name</strong></td>
        <td width="17%" class="print-bg-table" style="background-color:#068F0A; color:white;"><strong> Amount </strong></td>

      </tr>



	  <?php







$final_amt=0;







$pi=0;







$total=0;







	 $sql2="select l.group_name, a.ledger_id, a.ledger_name, f.final_amt as amount

	from ledger_group l, accounts_ledger a, batch_factory_overhead f where l.group_id=a.ledger_group_id and f.ledger_id=a.ledger_id and f.batch_no='".$batch_no."'

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

       <tr>



        <td width="4%"  class="print-bg-table" style="background-color:#068F0A; color:white;"><strong>SL</strong></td>
        <td width="21%" class="print-bg-table" style="background-color:#068F0A; color:white;"><strong> Category </strong></td>
        <td width="45%" class="print-bg-table" style="background-color:#068F0A; color:white;"><strong> Item Description </strong></td>
        <td width="12%" class="print-bg-table" style="background-color:#068F0A; color:white;"><strong>Unit</strong></td>
        <td width="18%" class="print-bg-table" style="background-color:#068F0A; color:white;"><strong>Quantity </strong></td>

        </tr>



	  <?php







$final_amt=0;







$pi=0;







$total=0;







$sql3="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.finish_goods_code from batch_raw_material a, item_info i, item_sub_group s where  a.item_id=i.item_id  and i.sub_group_id=s.sub_group_id and a.batch_no='".$batch_no."' and a.final_qty>0 order by i.sub_group_id, i.item_name";







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

        <td valign="top" align="right"><?=number_format($info2->final_qty,5);?></td>

        </tr>







<? }?>

    </table>	</td>

	</tr>

	

	

	

	

	



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

      </table></td>

  </tr>

</table>







</form>







</body>







</html>







