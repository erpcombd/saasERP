<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."core/class.numbertoword.php";

$req_no		= $_REQUEST['invoice_no'];
 


 






$sql_ms="select * from  requisition_master where req_no='$req_no'";

$ms_data=mysqli_fetch_object(db_query($sql_ms));

$company=find_all_field('user_group','','id='.$ms_data->group_for);

$whouse=find_all_field('warehouse','','warehouse_id='.$ms_data->warehouse_id);


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title>.: Quotations Comparison :.</title>



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



</style>


</head>



<body>



<form action="" method="post">



<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">



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
									  <td style="padding-bottom:3px; "><span style="font-size:22px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$company->group_name?></span></td>
							  </tr>
							  
							  
									<tr><td style="font-size:16px; line-height:20px;"><?=$company->address?></td>
									</tr>
									
									
									
									<tr>
   <td colspan="2" align="center"><h4 style="font-size:18px; width: 40%; padding:5px 0; margin:0; border:2px solid #000000; margin: 8px 0; background:#F5F5F5; border-radius: 5px; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px; text-transform:uppercase;">Quotations Comparison</h4></td>
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
		          <td width="25%" align="left" valign="middle"  style="font-size:14px;" ><strong>REQ. From  </strong></td>
		          <td width="3%" align="left" valign="middle"  style="font-size:14px;" ><strong>: </strong></td>
		          <td width="72%" style="font-size:14px; "><?= $whouse->warehouse_name;?></td>
	            </tr>
		        <tr style=" line-height:20px;">
		          <td align="left" valign="middle"  style="font-size:14px;"><strong>REQ. Type</strong></td>
		          <td align="left" valign="middle" style="font-size:14px;" ><strong>:</strong></td>
		          <td style="font-size:14px;">
		            <?= find_a_field('requisition_type','requisition_type','id="'.$ms_data->inv_type.'"');?>
		          </td>
	            </tr>
		        
		        </table>		      </td>


			<td width="32%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2"  style="font-size:11px">
			
			
			
			<tr>


                <td width="58%" align="right" valign="middle"><strong> REQ. No: </strong></td>


			    <td width="42%"><table width="100%" border="1" cellspacing="0" cellpadding="1">


                    <tr height="20">


                      <td>&nbsp;<?=$ms_data->req_no;?></td>
                    </tr>


                </table></td> </tr>




			  <tr>


                <td width="58%" align="right" valign="middle"><strong> REQ. Date: </strong></td>


			    <td width="42%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <?= date("d-m-Y",strtotime($ms_data->req_date));?></td>
                  </tr>
                </table></td> </tr>
				
				
				<tr>


                <td width="58%" align="right" valign="middle"><strong> Need By Date: </strong></td>


			    <td width="42%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <?= date("d-m-Y",strtotime($ms_data->need_by));?></td>
                  </tr>
                </table></td> </tr>
				
			
			  


		    </table></td>
		  </tr>


		</table>		</td></tr>



    



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

<td>&nbsp;

</td></tr>
	
<tr>

<td>


<table class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0" style="width:100%; font-size:12px;">
<?

	  
	   			 $sql  = 'select q.view_invoice_no,q.invoice_no, q.vendor_id, v.vendor_name
				from purchase_quotation_master q,  vendor v
				 where q.vendor_id=v.vendor_id and q.req_no="'.$req_no.'"  group by q.vendor_id order by q.invoice_no';
				$query = db_query($sql);
				$cols  = mysqli_num_rows($query);
				while($data=mysqli_fetch_object($query)){++$i;
				$vendor[$i] = $data->vendor_id;
		  		$vendor_name[$i] = $data->vendor_name;
				$view_invoice_no[$i] = $data->view_invoice_no;
		 		}
				
				
				
				 $sql  = 'select m.vendor_id, d.order_no, d.unit_price as qut_price, d.app_status
				 from purchase_quotation_master m, purchase_quotation_details d
				 where m.invoice_no=d.invoice_no and m.req_no="'.$req_no.'"  group by d.vendor_id, d.order_no ';
				$query = db_query($sql);	
				while($data=mysqli_fetch_object($query)){++$i;
				$vals[$data->vendor_id][$data->order_no] = $data->qut_price;
				$app_status[$data->vendor_id][$data->order_no] = $data->app_status;
				
				//$dealer_total[$data->po_no] = $dealer_total[$data->po_no] + $data->total_unit;	
//				$total_item[$data->item_id] = $total_item[$data->item_id] + $data->total_unit;
//				$all_total = $all_total +  $data->total_unit;
//				
//				$dealer_total_amt[$data->po_no] = $dealer_total_amt[$data->po_no] + $data->total_amt;
//				$total_item_amt[$data->item_id] = $total_item_amt[$data->item_id] + $data->total_amt;
//				$all_total_amt = $all_total_amt +  $data->total_amt;
				
				
				
		 		}
				


?>
       
       <tr>

        <td width="1%" rowspan="2" bgcolor="#F5F5F5" ><strong>SL</strong></td>

        <td width="33%" rowspan="2" bgcolor="#F5F5F5" ><strong> Item Description </strong></td>

     
 
        <td width="5%" rowspan="2" bgcolor="#F5F5F5" ><strong>Unit</strong></td>
    
        <td colspan="4" bgcolor="#F5F5F5" ><strong>Last Purchase info </strong></td>
        <?

for($i=1;$i<=$cols;$i++)
{
echo '<td bgcolor="#d5f5e3" width="25%"  rowspan="2" style="border: 1px solid #000000;" ><strong>'.$vendor_name[$i].' - '.$view_invoice_no[$i].'</strong></td>';
}

?>
        </tr>
       <tr>
         <td width="6%" bgcolor="#F5F5F5" ><strong>PO Date </strong></td>
         <td width="4%" bgcolor="#F5F5F5" ><strong>PO Rate </strong></td>
         <td width="4%" bgcolor="#F5F5F5" ><strong>PO Qty </strong></td>
         <td width="7%" bgcolor="#F5F5F5" ><strong>Vendor</strong></td>
         </tr>

	  <?php
	  
	  
	  


$final_amt=0;



$pi=0;



$total=0;


		 
		
 
		
		  $sql = "select id, po_no, po_date, rate, qty, vendor_id,item_id from purchase_invoice where 1 group by item_id order by id desc";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $view_invoice_no[$info->item_id]=$info->po_no;
		 $invoice_date[$info->item_id]=$info->po_date;
		 $unit_price[$info->item_id]=$info->rate;
		 $total_unit[$info->item_id]=$info->qty;
		 $vendor_id[$info->item_id]=$info->vendor_id;
		}
		
		$sql = "select vendor_id, vendor_name from vendor where 1 group by vendor_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $vendor_name[$info->vendor_id]=$info->vendor_name;
		}



  $sql3="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.finish_goods_code from  requisition_order a, item_info i, item_sub_group s where  a.item_id=i.item_id  and i.sub_group_id=s.sub_group_id and a.req_no='".$req_no."' order by i.sub_group_id, i.item_name";



$data3=db_query($sql3);



//echo $sql2;



while($info2=mysqli_fetch_object($data3)){ 



$pi++;


$sl=$pi;



?>


 
<tr>



        <td valign="top"><?=$sl?></td>

        <td align="left" valign="top"><?=$info2->item_name;?></td>
       
      
        <td valign="top"><?=$info2->unit_name;?></td>
 
        <td valign="top"><?  
	echo date("d-M-y",strtotime($invoice_date[$info2->item_id])); ?></td>
        <td valign="top"><?= $unit_price[$info2->item_id];?></td>
        <td valign="top"><?= $total_unit[$info2->item_id];?></td>
        <td align="left" valign="top"><?= $vendor_name[$vendor_id[$info2->item_id]]?> </td>
        <?

for($i=1;$i<=$cols;$i++)
{
echo '<td>'.number_format($vals[$vendor[$i]][$info2->id],3).' &nbsp;&nbsp;<img src="'.$app_status[$vendor[$i]][$info2->id].'.png" width="15" height="15"> </td>';
} ?>
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
		
<?php /*?>		In Word: <?
		$scs =  $tot_total_amt;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa. ';}

	 echo ' Only';

		?>.<?php */?>		</td>
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



