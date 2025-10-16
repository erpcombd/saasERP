<?php
 
//require_once "../../../controllers/routing/default_values.php";
//require_once SERVER_CORE."routing/layout.top.php";

//require "../../../engine/tools/class.numbertoword.php";

//require_once ('../../../acc_mod/common/class.numbertoword.php');

require_once "../../../controllers/routing/print_view.top.php";

$invoice_no=url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

//$invoice_no		= $_REQUEST['invoice_no'];

$count_sum=find_a_field('purchase_quotation_details','sum(count_type)','invoice_no='.$invoice_no);


if(isset($_POST['cash_discount']))



{



	$po_no = $_POST['po_no'];



	$cash_discount = $_POST['cash_discount'];



	$ssql='update purchase_sp_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';



	db_query($ssql);



}







$sql_ms="select * from purchase_quotation_master where invoice_no='$invoice_no'";

$ms_data=mysqli_fetch_object(db_query($sql_ms));

$company=find_all_field('user_group','','id='.$ms_data->group_for);

$whouse=find_all_field('warehouse','','warehouse_id='.$ms_data->warehouse_id);
$vendor=find_all_field('vendor','','vendor_id='.$ms_data->vendor_id);

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title>.: Purchase Quotation :.</title>



<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>



<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";



}



</script><?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>


<div class="header" style="position: relative; display: flex; align-items: center; justify-content: center;">
    <div class="logo" style="position: absolute; left: 0;padding:250px;">
        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$ms_data->group_for.'.png';?>" class="logo-img" />
    </div>

    <div class="text-content" style="text-align: center;">
        <h2 class="text-title"><?=$company->company_name?></h2>
        <p class="text"><?=$company->address?></p>
        <p class="text">Cell: <?=$company->mobile?>. Email: <?=$company->email?><br><?=$company->vat_reg?></p>
    </div>
</div>




</head>



<body>



<form action="" method="post">



<table width="1100" border="0" cellspacing="0" cellpadding="0" align="center">



  <tr>



    <td align="center"><div class="header" style="margin-top:0; width="17%" align="right" class="qr-code"">
	
	 <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($invoice_no); 
			  $tr_from = url_encode($tr_from); 
              $print_url = "https://saaserp.ezzy-erp.com/app/views/purchase_mod/QUOTATION/invoice_print_view_all.php?c=" . rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data). "&tr_from=" . rawurlencode($tr_from);
              $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($print_url);
              ?>
              <img src="<?=$qr_code?>" alt="QR Code" style="width:100px; height:100px; margin-top: -102px !important;">

       <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
		  <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="100%"> 
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0; text-align:center; " >
								
									
<!--									<tr>
									  <td style="padding-bottom:3px; "><span style="font-size:22px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$company->group_name?></span></td>
							  </tr>
							  
							  
									<tr><td style="font-size:16px; line-height:20px;"><?=$company->address?></td>
									</tr>-->
									
									
									
									<tr>
   <td colspan="2" align="center"><h4 style="font-size:18px; width: 50%; padding:5px 0; margin:0; border:2px solid #000000; margin: 8px 0; background:#F5F5F5; border-radius: 5px; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px; text-transform:uppercase;">Rate Collection</h4></td>
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
		          <td width="25%" align="left" valign="middle"  style="font-size:14px;" ><strong>Vendor Name </strong></td>
		          <td width="3%" align="left" valign="middle"  style="font-size:14px;" ><strong>: </strong></td>
		          <td width="72%" style="font-size:16px; "><?= $vendor->vendor_name;?></td>
	            </tr>
		        <tr style=" line-height:20px;">
		          <td align="left" valign="top"  style="font-size:14px;"><strong>Address</strong></td>
		          <td align="left" valign="top" style="font-size:14px;" ><strong>:</strong></td>
		          <td valign="top"  style="font-size:16px;">
		            <?= $vendor->address;?>		          </td>
	            </tr>
		        <tr style=" line-height:20px;">
		          <td align="left" valign="middle"  style="font-size:14px;"><strong>Currency</strong></td>
		          <td align="left" valign="middle" style="font-size:14px;" ><strong>:</strong></td>
		          <td style="font-size:16px;"><?=$ms_data->currency_type;?></td>
	            </tr>
				<tr style=" line-height:20px;">
		          <td align="left" valign="middle"  style="font-size:14px;"><strong>Requisition Remarks</strong></td>
		          <td align="left" valign="middle" style="font-size:14px;" ><strong>:</strong></td>
		          <td style="font-size:16px;"><?=find_a_field('requisition_master','req_note','req_no='.$ms_data->view_req_no);?></td>
	            </tr>
				
				<tr style=" line-height:20px;">
		          <td align="left" valign="middle"  style="font-size:14px;"><strong>Section</strong></td>
		          <td align="left" valign="middle" style="font-size:14px;" ><strong>:</strong></td>
		          <td style="font-size:16px;"><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$ms_data->warehouse_id);?></td>
	            </tr>
				<tr style=" line-height:20px;">
		          <td align="left" valign="middle"  style="font-size:14px;"><strong>Type</strong></td>
		          <td align="left" valign="middle" style="font-size:14px;" ><strong>:</strong></td>
		          <td style="font-size:16px;"><?=find_a_field('purchase_type','po_type','id='.$ms_data->po_type);?></td>
	            </tr>
				
				
	          </table>		      </td>


			<td width="32%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2"  style="font-size:11px">
			
			
			
			<tr>


                <td width="52%" align="right" valign="middle"><strong> QUOTE No: </strong></td>


			    <td width="48%"><table width="100%" border="1" cellspacing="0" cellpadding="1">


                    <tr height="20">


                      <td>&nbsp;<?=$ms_data->view_invoice_no;?></td>
                    </tr>


                </table></td> </tr>




			  <tr>


                <td width="52%" align="right" valign="middle"><strong> QUOTE Date: </strong></td>


			    <td width="48%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <?= date("d-m-Y",strtotime($ms_data->invoice_date));?></td>
                  </tr>
                </table></td> </tr>
				
				
				<tr>


                <td width="52%" align="right" valign="middle"><strong> REQ. No: </strong></td>


			    <td width="48%"><table width="100%" border="1" cellspacing="0" cellpadding="1">


                    <tr height="20">
					  
					                <?php /*?><td>&nbsp;<a href="../../warehouse_mod/mr/mr_print_view.php?req_no=<?=$ms_data->view_req_no;?>" target="_blank"><?=$ms_data->view_req_no;?></a></td><?php */?>
									
									
	<td>&nbsp;<a href="../../warehouse_mod/mr/mr_print_view.php?c=<?=rawurlencode(url_encode($c_id));?>&v=<?=rawurlencode(url_encode($ms_data->view_req_no));?>" target="_blank"><?=$ms_data->view_req_no;?></a></td>
                    </tr>
					
					
					


                </table></td> </tr>
				
				
						  <tr>


                <td width="52%" align="right" valign="middle"><strong> Reference. No: </strong></td>


			    <td width="48%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <?=$ms_data->ref;?></td>
                  </tr>
                </table></td> </tr>
				
			
			  <tr>


                <td width="52%" align="right" valign="middle"><strong> VAT: </strong></td>


			    <td width="48%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <?=$ms_data->vat;?>&nbsp; (<?=$ms_data->vat_include;?>)</td>
                  </tr>
                </table></td> 
				</tr>


 <tr>


                <td width="52%" align="right" valign="middle"><strong> TAX: </strong></td>


			    <td width="48%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <?=$ms_data->tax;?>&nbsp; (<?=$ms_data->tax_include;?>)</td>
                  </tr>
                </table></td> 
				</tr>
				
				
				
				
				 <tr>


                <td width="52%" align="right" valign="middle"><strong> Discount: </strong></td>


			    <td width="48%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <?=$ms_data->discount;?></td>
                  </tr>
                </table></td> 
				</tr>
				
				
				
				
				
				
				 <tr>


                <td width="52%" align="right" valign="middle"><strong> Vat Rebate: </strong></td>


			    <td width="48%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp; <?=$ms_data->rebate;?></td>
                  </tr>
                </table></td> 
				</tr>
				
				

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


<table class="tabledesign1"  bordercolor="" cellspacing="0" cellpadding="0" style="width:100%; font-size:12px">

       
       <tr>

        <td width="2%" rowspan="2" bgcolor="#F5F5F5" ><strong>SL</strong></td>

        <td width="5%" rowspan="2" bgcolor="#F5F5F5" ><strong> Category </strong></td>
        <td width="10%" rowspan="2" bgcolor="#F5F5F5" ><strong> Item Name </strong></td>

       <td width="10%" rowspan="2" bgcolor="#F5F5F5" ><strong>Specification</strong></td>
		<td width="15%" rowspan="2" bgcolor="#F5F5F5" ><strong>Product<br /> Specification</strong></td>
       <td width="10%" rowspan="2" bgcolor="#F5F5F5" ><strong>Remarks</strong></td>
        
        <td width="3%" rowspan="2" bgcolor="#F5F5F5" ><strong>Unit</strong></td>
        <td width="4%" rowspan="2" bgcolor="#F5F5F5" ><strong>REQ Qty </strong></td>
        <td width="8%" rowspan="2" bgcolor="#F5F5F5" ><strong>Each Price <br />in  <?=$ms_data->currency_type;?></strong></td>
		<td width="8%" rowspan="2" bgcolor="#F5F5F5" ><strong>Value </strong></td>
        <!--<td width="3%" rowspan="2" bgcolor="#F5F5F5" ><strong>Per Unit</strong> </td>-->
        <!--<td width="9%" rowspan="2" bgcolor="#F5F5F5" ><strong>Country of Origin</strong></td>-->
		
        <td colspan="4" bgcolor="#66CCFF" align="center" ><strong>Last Purchase info </strong></td>
        </tr> 
       <tr>
         <td width="6%" bgcolor="#F5F5F5" ><strong>Date </strong></td>
         <td width="3%" bgcolor="#F5F5F5" ><strong>Rate </strong></td>
         <td width="2%" bgcolor="#F5F5F5" ><strong>Qty </strong></td>
         <td width="8%" bgcolor="#F5F5F5" ><strong>Vendor</strong></td>
        </tr>

	  <?php



$final_amt=0;



$pi=0;



$total=0;

 
		
 
		
		
		    $sql = "select id, po_no, po_date, rate, qty, vendor_id,item_id from purchase_invoice where 1 group by item_id order by id desc";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $view_invoice_no[$info->item_id]=$info->po_no;
		   $invoice_datess[$info->item_id]=$info->po_date;
		 $unit_price[$info->item_id]=$info->rate;
		 $total_unit[$info->item_id]=$info->qty;
		 $vendor_id[$info->item_id]=$info->vendor_id;
		}
		
		$sql = "select vendor_id, vendor_name from vendor where 1 group by vendor_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $vendor_name[$info->vendor_id]=$info->vendor_name;
		}




  $sql3="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.finish_goods_code from purchase_quotation_details a, item_info i, item_sub_group s where  a.item_id=i.item_id  and i.sub_group_id=s.sub_group_id and a.invoice_no='".$invoice_no."' order by i.sub_group_id, i.item_name";



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
        <td align="left" valign="top"><?=find_a_field('requisition_order','specification','item_id="'.$info2->item_id.'" and req_no="'.$info2->req_no.'"');?></td>
		<td align="left" valign="top"><?=$info2->vendor_specification;?></td>
        <td align="left" valign="top"><?=$info2->remarks;?></td>
        <td valign="top"><?=$info2->unit_name;?></td>
        <td valign="top"><?=number_format($info2->req_qty,2);$totQty+=$info2->req_qty;?></td>
        <td valign="top"><?=number_format($info2->unit_price,2);?></td>
		<td valign="top"><?= number_format($info2->req_qty * $info2->unit_price, 2); $totalAmount += $info2->req_qty * $info2->unit_price;?></td>
		
        <?php /*?><td valign="top"><?=number_format($info2->total_unit,2);?></td><?php */?>
        <?php /*?><td valign="top"><?=$info2->country_origin	;?></td><?php */?>
        <td valign="top"><?  
	if($invoice_datess[$info2->item_id]!=''){echo date("d-M-y",strtotime($invoice_datess[$info2->item_id]));}else{echo '';} ?></td>
        <td valign="top"><?= $unit_price[$info2->item_id];?></td>
        <td valign="top"><?= $total_unit[$info2->item_id];?></td>
        <td align="left" valign="top"><?= $vendor_name[$vendor_id[$info2->item_id]]?></td>
        </tr>



<? }?>
   <tr> 
   <td colspan="6"  width="100%" align="right"><strong>Total :   </strong></td>
   <td></td>
    <td  ><strong><?=$totQty?></strong></td>
	<td  ></td>
	<td  ><strong><?=$totalAmount?></strong></td>
	
	</tr>
	
   
   
   
   
   
   
   
   
   
    </table>	</td>
	
	
	
	
	
	
	
	
	
	</tr>
	
	
	
	
	

<tr>

<td>

<h4>Terms and Condition</h4>
<? echo $ms_data->terms_condition; ?>




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
<!--          <td  width="25%" align="center">&nbsp;</td>
          <td width="25%" align="center">&nbsp;</td>
          <td width="25%" align="center">&nbsp;</td>-->
        </tr>
        <tr>
          <td align="center">-------------------------------</td>
<!--          <td align="center">-------------------------------</td>
          <td align="center">-------------------------------</td>
          <td align="center">-------------------------------</td>-->
        </tr>
        <tr>
          <td align="center"><strong>Prepared By</strong></td>
<!--          <td align="center"><strong>Purchase Manager</strong></td>
          <td align="center"><strong>Account's Officer </strong></td>
          <td align="center"><strong>Executive Director</strong></td>-->
        </tr>
      </table></td>
  </tr>
</table>



</form>



</body>



</html>



