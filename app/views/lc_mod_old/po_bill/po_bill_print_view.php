<?php

//

//====================== EOF ===================



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//require "../../../engine/tools/class.numbertoword.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$bill_id		= $_REQUEST['bill_id'];



$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);



if(isset($_POST['cash_discount']))



{



	$po_no = $_POST['po_no'];



	$cash_discount = $_POST['cash_discount'];



	$ssql='update purchase_sp_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';



	db_query($ssql);



}







$sql1="select * from po_bill_master where bill_id='$bill_id'";


$data=mysqli_fetch_object(db_query($sql1));



$manager=find_all_field('purchase_manager','','id='.$data->purchase_manager );


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title>.: Purchased Bill :.</title>



<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>



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



</style></head>



<body>



<form action="" method="post">



<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">



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
									  <td style="padding-bottom:3px; "><span style="font-size:22px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$group_data->group_name?></span></td>
							  </tr>
							  
							  
									<tr><td style="font-size:16px; line-height:20px;"><?=$group_data->address?></td>
									</tr>
									
									
									
									<tr>
   <td colspan="2" align="center"><h4 style="font-size:18px; width: 30%; padding:5px 0; margin:0; border:2px solid #000000; margin: 8px 0;  border-radius: 5px; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px; text-transform:uppercase;">Purchased Bill</h4></td>
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
  
 
  
  
  <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="68%" valign="top">


		      <table width="96%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">
		        <tr style=" line-height:20px;" >
		          <td width="25%" align="left" valign="middle"  style="font-size:14px;" ><strong>Purchase Manager  </strong></td>
		          <td width="3%" align="left" valign="middle"  style="font-size:14px;" ><strong>: </strong></td>
		          <td width="72%" style="font-size:18px; "><strong><span style="font-size:18px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?= $manager->purchase_manager;?></span></strong></td>
	            </tr>
		        <tr style=" line-height:15px;">
		          <td align="left" valign="middle"><strong>Mobile No</strong></td>
		          <td align="left" valign="middle"><strong>:</strong></td>
		          <td><?= $manager->manager;?></td>
	            </tr>
		        
		        </table>		      </td>


			<td width="32%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2"  style="font-size:11px">
			
			
			
			<tr>


                <td width="58%" align="right" valign="middle"><strong> Bill No: </strong></td>


			    <td width="42%"><table width="100%" border="1" cellspacing="0" cellpadding="1">


                    <tr height="20">


                      <td>&nbsp; <?=$data->bill_no?></td>
                    </tr>


                </table></td> </tr>




			  <tr>


                <td width="58%" align="right" valign="middle"><strong> Bill Date: </strong></td>


			    <td width="42%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <?= date("d-m-Y",strtotime($data->bill_date));?></td>
                  </tr>
                </table></td> </tr>
				
			


		    </table></td>
		  </tr>


		</table>		</td></tr>



    
	
	
	<tr>
	  <td colspan="3" valign="top" style="font-size:13px; padding: 5px 0px 0px 0px; letter-spacing: .3px; line-height:20px" ><div align="justify">Memo no: 
	    <b>  
	      <?  
$o=0;
		 $po_sql = 'SELECT m.invoice_no, m.po_date FROM po_bill_details p, purchase_sp_master m WHERE p.po_no=m.po_no and p.bill_id="'.$bill_id.'" GROUP by p.po_no ';
			$po_query=db_query($po_sql);
			while($po_data= mysqli_fetch_object($po_query)){
			$o++;
			if ($o>1) echo ', ';
//echo $po_data->invoice_no.'. DT. '.date('d-m-Y',strtotime($po_data->po_date));

echo $po_data->invoice_no;}?>
	      </b> </div></td>
	  </tr>



  <tr>



    <td><div id="pr">



      <div align="left">



        



          <table width="60%" border="0" cellspacing="0" cellpadding="0">



        <tr>



          <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>



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



        <td width="7%"><strong>SL</strong></td>

        <td width="49%"><strong> Item Description </strong></td>


        <td width="10%"><strong>Unit</strong></td>
        <td width="11%"><strong>Quantity</strong></td>

        <td width="11%"><strong>Unit Price </strong></td>

        <td width="12%"><strong> Amount </strong></td>
      </tr>
	  
	  
	   <?
	   
	   
$sql_sub="select a.*, i.sub_group_id, s.sub_group_name from po_bill_details b, purchase_sp_invoice a, item_info i, item_sub_group s where a.po_no=b.po_no and a.item_id=i.item_id and i.sub_group_id=s.sub_group_id and  b.bill_id='$bill_id' 
group by i.sub_group_id";
$data_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($data_sub)){ 
	   
	   
	   ?>
	   
	   
	   <tr>



        <td width="7%"><strong></strong></td>

        <td colspan="5" align="left"><strong> <?=$info_sub->sub_group_name?></strong><strong></strong><strong></strong><strong></strong><strong>  </strong></td>
        </tr>



	  <?php



$final_amt=0;



$pi=0;



$total=0;



$sql2="select a.*, i.sub_group_id, i.item_name from po_bill_details b, purchase_sp_invoice a, item_info i where  a.po_no=b.po_no and  a.item_id=i.item_id and i.sub_group_id='".$info_sub->sub_group_id."' and b.bill_id='".$bill_id."'  order by i.item_name";



$data2=db_query($sql2);



//echo $sql2;



while($info=mysqli_fetch_object($data2)){ 



$pi++;


$sl=$pi;



$unit_name=$info->unit_name;
$qty=$info->qty;
$rate=$info->rate;
$amount=$info->amount;
$sub_total_amt +=$amount;




?>



<tr>



        <td valign="top"><?=$sl?></td>

        <td align="left" valign="top"><?=$info->item_name;?></td>


        <td valign="top"><?=$unit_name?></td>
        <td valign="right"><?=$qty; ?></td>

        <td align="right" valign="top"><?=number_format($rate,2)?></td>

        <td align="right" valign="top"><?=number_format($amount,2)?></td>
      </tr>



<? }?>

<tr>



        <td colspan="5" valign="top"><div align="right"><strong>Sub Total:</strong></div></td>

        <td align="right" valign="top"><strong><?=number_format($sub_total_amt,2); $tot_total_amt +=$sub_total_amt;?></strong></td>
      </tr>
	  
	  
	  
<?
$sub_total_amt = 0;
 }?>




      <tr>
        <td align="right" colspan="5"><strong> Total:</strong></td>
        <td align="right"><strong><?php echo number_format($tot_total_amt,2);?></strong></td>
      </tr>
	  
	  
	  <? 
	   $vat_sql="SELECT sum(vat_amt) as vat_amt FROM po_bill_details p, purchase_sp_master m WHERE p.po_no=m.po_no and p.bill_id='".$bill_id."' GROUP by p.bill_id ";
$vat_amt = find_a_field_sql($vat_sql);
	  ?>
	  
	  
	  <? if($vat_amt>0) {?>
      <tr  align="right">
        <td colspan="5"><strong>VAT Amt:</strong></td>
        <td align="right"><strong>
          <?  echo number_format($tax_total=$vat_amt,2);?>
        </strong></td>
      </tr>
	  <? }?>
	  
	   
	  <? 
	   $trn_sql="SELECT sum(transport_bill) as transport_bill FROM po_bill_details p, purchase_sp_master m WHERE p.po_no=m.po_no and p.bill_id='".$bill_id."' GROUP by p.bill_id ";
$transport_bill = find_a_field_sql($trn_sql);
	  ?>
	  
	  <? if($transport_bill>0) {?>
      <tr  align="right">
        <td colspan="5"><strong>Transport Bill:</strong></td>
        <td align="right"><strong>
          <?  echo number_format($transport_bill,2);?>
        </strong></td>
      </tr>
	  <? }?>
	  
	  
	  <? 
	   $lbr_sql="SELECT sum(labor_bill) as labor_bill FROM po_bill_details p, purchase_sp_master m WHERE p.po_no=m.po_no and p.bill_id='".$bill_id."' GROUP by p.bill_id ";
$labor_bill = find_a_field_sql($lbr_sql);
	  ?>
	  
	  <? if($labor_bill>0) {?>
      <tr  align="right">
        <td colspan="5"><strong>Labor Bill:</strong></td>
        <td align="right"><strong>
          <?  echo number_format($labor_bill,2);?>
        </strong></td>
      </tr>
	  <? }?>
	  
	  
	  <? 
	   $otr_sql="SELECT sum(other_bill) as other_bill FROM po_bill_details p, purchase_sp_master m WHERE p.po_no=m.po_no and p.bill_id='".$bill_id."' GROUP by p.bill_id ";
$other_bill = find_a_field_sql($otr_sql);
	  ?>
	  
	   <? if($other_bill>0) {?>
      <tr  align="right">
        <td colspan="5"><strong>Other Bill:</strong></td>
        <td align="right"><strong>
          <?  echo number_format($other_bill,2);?>
        </strong></td>
      </tr>
	  <? }?>
	  
	  
	  <? 
	   $adj_sql="SELECT sum(bill_adjustment) as bill_adjustment FROM po_bill_details p, purchase_sp_master m WHERE p.po_no=m.po_no and p.bill_id='".$bill_id."' GROUP by p.bill_id ";
$bill_adjustment = find_a_field_sql($adj_sql);
	  ?>
	  
	  
	  
	   <? if($bill_adjustment>0) {?>
      <tr  align="right">
        <td colspan="5"><strong>Bill Adjustment (-):</strong></td>
        <td align="right"><strong>
          <?  echo number_format($bill_adjustment,2);?>
        </strong></td>
      </tr>
	  <? }?>
	  
	  <? $other_amt = (($tax_total+$transport_bill+$labor_bill+$other_bill)-$bill_adjustment)?>
	  
	   <? if($other_amt<>0) {?>
      <tr>
        <td   align="right" colspan="5"><strong>Bill Amount: </strong></td>
        <td align="right"><strong><? echo number_format($payable_amount=($tot_total_amt+$tax_total+$transport_bill+$labor_bill+$other_bill)-$bill_adjustment,2);?></strong></td>
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
        <tr style="font-size:16px; font-weight:500; letter-spacing:.3px;">



		<td colspan="4">
		
		In Word: <?

		

		$scs =  ($tot_total_amt+$tax_total+$transport_bill+$labor_bill+$other_bill)-$bill_adjustment;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}

	 echo ' Only';

		?>.		</td>
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
          <td width="25%" align="center"><?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
          <td  width="25%" align="center"><?=find_a_field('purchase_manager','purchase_manager','id='.$data->purchase_manager);?></td>
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
          <td align="center"><strong>Purchase Manager</strong></td>
          <td align="center"><strong>Store Incharge</strong></td>
          <td align="center"><strong>Executive Director</strong></td>
        </tr>
      </table></td>
  </tr>
</table>



</form>



</body>



</html>



