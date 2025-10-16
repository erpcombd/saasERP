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



        <td width="4%"><strong>SL</strong></td>

        <td width="9%"><strong>PO No </strong></td>


        <td width="10%"><strong>Memo No </strong></td>
        <td width="17%"><strong>PO Date </strong></td>
        <td width="42%"><strong>Vendor</strong></td>
        <td width="18%"><strong> Amount </strong></td>
      </tr>
	  
	 
	

	  <?php


 		$sql = "select j.tr_id, v.ledger_id, j.cr_amt, j.jv_no from journal j, vendor v where j.ledger_id=v.ledger_id and j.tr_from='Purchase' group by j.tr_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $cr_amt[$info->ledger_id][$info->tr_id]=$info->cr_amt;
		 $jv_no[$info->ledger_id][$info->tr_id]=$info->jv_no;
	
		}



 $sql2="select b.*, a.po_date, a.invoice_no, a.po_details, v.vendor_name from po_bill_details b, purchase_sp_master a, vendor v  where a.vendor_id=v.vendor_id and a.po_no=b.po_no and  b.bill_id='".$bill_id."' group by a.po_no";



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

        <td align="left" valign="top"><?=$info->po_no;?></td>


        <td align="left" valign="top"><?=$info->invoice_no;?></td>
        <td align="left" valign="top"><?php echo date('d-m-Y',strtotime($info->po_date));?></td>
        <td align="left" valign="top">
		<? if ($info->vendor_id==48) {
			echo $info->po_details;
		} else {
			echo $info->vendor_name;
		}?></td>
        <td align="right" valign="top"><?= number_format($cr_amt[$info->ledger_id][$info->po_no],2); $tot_cr_amt +=$cr_amt[$info->ledger_id][$info->po_no];?></td>
      </tr>



<? }?>

<tr>



        <td colspan="5" valign="top"><div align="right"><strong> Total:</strong></div></td>

        <td align="right" valign="top"><strong><?=number_format($tot_cr_amt,2); ?></strong></td>
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

		

		$scs =  $tot_cr_amt;

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



