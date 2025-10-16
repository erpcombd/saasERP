<?php



session_start();



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

require_once "../../../assets/support/class.numbertoword.php";















$po_no		= $_REQUEST['po_no'];







if(isset($_POST['cash_discount']))



{



	$po_no = $_POST['po_no'];



	$cash_discount = $_POST['cash_discount'];



	$ssql='update purchase_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';



	db_query($ssql);



}







$sql1="select * from purchase_master where po_no='$po_no'";



$data=mysqli_fetch_object(db_query($sql1));



$vendor=find_all_field('vendor','','vendor_id='.$data->vendor_id );



$whouse=find_all_field('warehouse','','warehouse_id='.$data->warehouse_id);



















?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title>.: Purchase Order :.</title>



<link href="../../../css_js/css/invoice.css" type="text/css" rel="stylesheet"/>



<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";



}



</script>



<style type="text/css">



<!--



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



</style></head>



<body>



<form action="" method="post">



<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">



  <tr>



    <td align="center"><strong style="font-size:24px"><!--<?



if($_SESSION['user']['group']>1)



echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);



else



echo $_SESSION['proj_name'];



				?>--><br /></strong>







    <strong><font style="font-size:20px">Purchase Order </font></strong></td>
  </tr>


<tr>



    



	<td>	<div align="center"><span class="style4">BIN NO: 000235858-0101 </span><br />



	  </div></td>
  </tr>


  <tr>



    



	<td>	<div align="center"><span class="style4">TIN NO: 380263416055  </span><br />



	  </div></td>
  </tr>



  <tr>



    <td><div class="line">



      <div align="center"><span class="style4"></span><br />
      </div>



    </div></td>
  </tr>



  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>



    <td><p><span style="font-size:10px">



    	</span></p>



      <table width="100%" border="0" cellspacing="0" cellpadding="0">



        <tr>



          <td width="74%" valign="top"><span style="font-size:10px"><span style="font-size:20px; font-style:italic"><strong>



            <?=$vendor->vendor_name;?>



          </strong></span><br />







 <strong><?=$vendor->address;?></strong>



<br />



















          </span></td>



             <td width="26%" valign="top"><span style="font-size:15px"> &nbsp;&nbsp;&nbsp;PO No.#



             <strong>  <span class="style5">

              <?=$_GET['po_no']?>
             </strong></span>

              <br />



              &nbsp;&nbsp;&nbsp;PO Date:



               <span class="style6">

               <?= date("d-m-Y",strtotime($data->po_date));?>
               </span>

              <br />



&nbsp;&nbsp;&nbsp;Invoice No. :



<span class="style7">

<?=$data->invoice_no?>
</span><br />


&nbsp;&nbsp;&nbsp;Invoice Date:



 <span class="style9">

 <?= date("d-m-Y",strtotime($data->invoice_date));?>
 </span><br />


&nbsp;&nbsp;&nbsp;PO Status:

<?=$data->status?><br />


&nbsp;&nbsp;&nbsp;Note :



 <span class="style9">

 <?= $data->payment_details;?>
 </span><br />

&nbsp;&nbsp;&nbsp;<!--Note:-->

 <span class="style9">

<br /><br />

 </span></td>
        </tr>
      </table>   

	        </td>
  </tr>



  <tr>



    <td><div id="pr">



      <div align="left">



        



          <table width="60%" border="0" cellspacing="0" cellpadding="0">



        <tr>



          <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>



        </tr>
      </table>
      </div>



    </div>



<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">



       <tr>



        <td width="4%" align="center"><strong>SL</strong></td>


        <td width="29%"><strong> Item Description </strong></td>


        <td width="10%"><strong>Quantity</strong></td>



        <td width="8%"><strong>Unit</strong></td>
        <td width="14%"><strong>Unit Price </strong></td>



        <td width="12%"><strong>VAT (%) </strong></td>
        <td width="16%"><strong> Amount </strong></td>
      </tr>



	  <?php



$final_amt=0;



$pi=0;



$total=0;



$sql2="select * from purchase_invoice where po_no='$po_no'";



$data2=db_query($sql2);







while($info=mysqli_fetch_object($data2)){ 



$pi++;



$amount=$info->qty*$info->rate;



$total=$total+($info->qty*$info->rate);



$supplementary_duty_amt=(($total*$data->supplementary_duty)/100);



$net_total= ($total+$supplementary_duty_amt);



$sl=$pi;







$item=find_a_field('item_info','item_description','item_id='.$info->item_id);

$fg_code=find_a_field('item_info','concat(finish_goods_code)','item_id='.$info->item_id);



$sku_code=find_a_field('item_info','concat(sku_code)','item_id='.$info->item_id);



$qty=$info->qty;



$unit_name=$info->unit_name;



$rate=$info->rate;



$disc=$info->disc;



?>



<tr>



        <td valign="top" align="center"><?=$sl?></td>

        <td align="left" valign="top" style="padding:5px;"><?=$item?></td>


        <td valign="top" style="padding:5px;"><?=$qty?></td>



        <td align="center" valign="top"><?=$unit_name?></td>
        <td align="right" valign="top"><?=number_format($rate,2)?></td>



        <td align="Center" valign="top"><?=$data->tax?></td>
        <td align="right" valign="top"><?=number_format($amount,2)?></td>
      </tr>



<? }?>


      <tr>
        <td align="right" colspan="6"><strong>Sub Total:</strong></td>
        <td align="right"><strong><?php echo number_format($total,2);?></strong></td>
      </tr>
      <tr  align="right">
        <td colspan="6"><strong>VAT (<?=number_format($data->tax,0)?>%):</strong></td>
        <td align="right"><strong>
          <?  echo number_format($tax_total=(($total*$data->tax)/100),2);?>
        </strong></td>
      </tr>
      <tr>
        <td   align="right" colspan="6"><strong>Net Amount: </strong></td>
        <td align="right"><strong><? echo number_format($payable_amount=($total+$tax_total),2);?></strong></td>
      </tr>
    </table>



      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" style="width:1000px">



        <tr>



		<td colspan="2"> <strong>Terms and Conditions: </strong></td>



          <td width="49" align="right">&nbsp;</td>
        </tr>
		
		<tr>



		<td colspan="7"><? echo $data->terms_condition?></td>

        </tr>





        <tr>
          <td colspan="2" align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>

          <td width="424" colspan="2" align="right">&nbsp;</td>

          <td align="right">&nbsp;</td>
        </tr>

		














<? if($data->transport_bill>0){?>



<? }?>



<? if($data->labor_bill>0){?>



<? }?>

		

	<? if($data->advance_payment>0){?>

<? }?>

        <tr>


  
		

        </tr>
		
      
        <tr>

       

          <td colspan="3" align="left" style="font-size:14px" >



            <table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>
			  
			  <td align="center"> &nbsp;</td>
			  <td align="center">&nbsp;</td>
			  <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
			  <td align="center">&nbsp;</td>
			  <td align="center">&nbsp;</td>

                </tr>

              <tr>
			  
			  <td align="center">.........................</td>
			   <td align="center">.........................</td>
			  <td align="center">..............................</td>
			  <td align="center">.........................</td>
		
			  <td align="center">............................</td>
			  <td align="center">..............................</td>

                </tr>
				
				 <tr>
			  
			  <td align="center">Procurement Dept.</td>
			  <td align="center">Auditor</td>
			  <td align="center">Product Manager</td>
			  <td align="center"> Head of Accounts</td>
         
			  <td align="center">Director Operation</td>
			  <td align="center">Managing Director</td>

                </tr>
            </table></td>
        </tr>



        <tr>



          <td colspan="3" align="left" style="font-size:10px"><p><br />

          <em>



              <b>

              
              </b>



            </em>
            </p>            </td>
        </tr>
      </table></td>
  </tr>
</table>



</form>



</body>



</html>



