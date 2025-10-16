<?php

//

//====================== EOF ===================



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//require "../../../engine/tools/class.numbertoword.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

$req_no		= $_REQUEST['req_no'];






if(isset($_POST['cash_discount']))



{



	$po_no = $_POST['po_no'];



	$cash_discount = $_POST['cash_discount'];



	$ssql='update purchase_sp_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';



	db_query($ssql);



}







$sql1="select * from spare_parts_requisition_master where req_no='$req_no'";



$data=mysqli_fetch_object(db_query($sql1));



$company=find_all_field('user_group','','id='.$data->group_for );



$whouse=find_all_field('warehouse','','warehouse_id='.$data->warehouse_id);




$group_data = find_all_field('warehouse','','warehouse_id='.$data->warehouse_to);















?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title>.: Sales Order :.</title>



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
									  <td style="padding-bottom:3px; "><span style="font-size:22px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$group_data->warehouse_name?></span></td>
							  </tr>
							  
							  
									<tr><td style="font-size:16px; line-height:20px;"><?=$group_data->address?></td>
									</tr>
									
									
									
									<tr>
   <td colspan="2" align="center"><h4 style="font-size:18px; width: 30%; padding:5px 0; margin:0; border:2px solid #000000; margin: 8px 0;  border-radius: 5px; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px; text-transform:uppercase;">SALES Order</h4></td>
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
		          <td width="17%" align="left" valign="middle"  style="font-size:14px;" ><strong>Company </strong></td>
		          <td width="3%" align="left" valign="middle"  style="font-size:14px;" ><strong>: </strong></td>
		          <td width="80%" style="font-size:18px; "><strong><span style="font-size:18px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';">
				  
		 <?= $company->group_name;?>
				  
				  </span></strong></td>
	            </tr>
		        <tr style=" line-height:15px;">
		          <td align="left" valign="middle"><strong>Location</strong></td>
		          <td align="left" valign="middle"><strong>:</strong></td>
		          <td><?= $whouse->warehouse_name;?></td>
	            </tr>
		        <tr style=" line-height:15px;">
		          <td align="left" valign="middle"><strong> Mobile No </strong></td>
		          <td align="left" valign="middle"><strong>:</strong></td>
		          <td><?= $whouse->contact_no;?></td>
	            </tr>
		        </table>		      </td>


			<td width="32%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2"  style="font-size:11px">
			
			
			
			<tr>


                <td width="58%" align="right" valign="middle"><strong> SO No: </strong></td>


			    <td width="42%"><table width="100%" border="1" cellspacing="0" cellpadding="1">


                    <tr height="20">


                      <td>&nbsp; <?=$_GET['req_no']?></td>
                    </tr>


                </table></td> </tr>




			  <tr>


                <td width="58%" align="right" valign="middle"><strong> SO Date: </strong></td>


			    <td width="42%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <?= date("d-m-Y",strtotime($data->req_date));?></td>
                  </tr>
                </table></td> </tr>
				
				
				
				
			
			  


		    </table></td>
		  </tr>


		</table>		</td></tr>



    <tr>
		<td>&nbsp;</td>
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



        <td width="3%"><strong>SL</strong></td>

        <td width="39%"><strong> Item Description </strong></td>


        <td width="11%"><strong>Unit</strong></td>
        <td width="8%"><strong>Machine</strong></td>
        <td width="8%"><strong>Remarks</strong></td>
        <td width="9%"><strong>Quantity</strong></td>

        <td width="9%"><strong> Price </strong></td>

        <td width="13%"><strong> Amount </strong></td>
      </tr>
	  
	  
	   <?
	   
	   
$sql_sub="select a.*, i.sub_group_id, s.sub_group_name from spare_parts_requisition_order a, item_info i, item_sub_group s 
where a.item_id=i.item_id and i.sub_group_id=s.sub_group_id and  a.req_no='$req_no' 
group by i.sub_group_id";
$data_sub=db_query($sql_sub);

while($info_sub=mysqli_fetch_object($data_sub)){ 
	   
	   
	   ?>
	   
	   
	   <tr>



        <td width="3%"><strong></strong></td>

        <td colspan="7" align="left"><strong> <?=$info_sub->sub_group_name?></strong><strong></strong><strong></strong><strong></strong><strong>  </strong></td>
        </tr>



	  <?php



$final_amt=0;



$pi=0;



$total=0;



$sql2="select a.*, i.sub_group_id, i.item_name from spare_parts_requisition_order a, item_info i where  a.item_id=i.item_id and i.sub_group_id='".$info_sub->sub_group_id."' and a.req_no='".$req_no."'  order by i.item_name";



$data2=db_query($sql2);



//echo $sql2;



while($info=mysqli_fetch_object($data2)){ 



$pi++;


$sl=$pi;



$unit_name=$info->unit_name;
$qty=$info->qty;
$rate=$info->unit_price;
$amount=$info->amount;
$sub_total_amt +=$amount;




?>



<tr>



        <td valign="top"><?=$sl?></td>

        <td align="left" valign="top"><?=$info->item_name;?></td>


        <td valign="top"><?=$unit_name?></td>
        <td valign="top"><?=find_a_field('machine_info','machine_short_name','machine_id='.$info->machine_id);?></td>
        <td valign="top"><?=$info->remarks?></td>
        <td valign="top"><?=$qty; ?></td>

        <td align="right" valign="top"><?=number_format($rate,3)?></td>

        <td align="right" valign="top"><?=number_format($amount,2)?></td>
      </tr>



<? }?>

<tr>



        <td colspan="7" valign="top"><div align="right"><strong>Sub Total:</strong></div></td>

        <td align="right" valign="top"><strong><?=number_format($sub_total_amt,2); $tot_total_amt +=$sub_total_amt;?></strong></td>
      </tr>
	  
	  
	  
<?
$sub_total_amt = 0;
 }?>




      <tr>
        <td align="right" colspan="7"><strong> Total:</strong></td>
        <td align="right"><strong><?php echo number_format($tot_total_amt,2);?></strong></td>
      </tr>
	  
	  
	  <?
	  
	  $bill_sql="SELECT sum(service_amt) as service_amt, sum(total_amt) as total_amt  FROM spare_parts_requisition_order  WHERE req_no='".$req_no."'";
	$bill_data = find_all_field_sql($bill_sql);
	  
	  ?>
	  
	  <? if($bill_data->service_amt>0) {?>
      <tr  align="right">
        <td colspan="7"><strong>Service Charge:</strong></td>
        <td align="right"><strong>
          <?  echo number_format($bill_data->service_amt,2);?>
        </strong></td>
      </tr>
	  <? }?>
	
	  
      <tr>
        <td   align="right" colspan="7"><strong>Invoice Amount: </strong></td>
        <td align="right"><strong><? echo number_format($payable_amount=($tot_total_amt+$bill_data->service_amt),2);?></strong></td>
      </tr>
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

		

		$scs =  $payable_amount;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa. ';}

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
          <td align="center"><strong>Received By </strong></td>
          <td align="center"><strong>Store Incharge</strong></td>
          <td align="center"><strong>Executive Director</strong></td>
        </tr>
      </table></td>
  </tr>
</table>



</form>



</body>



</html>



