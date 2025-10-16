<?php


session_start();


//====================== EOF ===================


//var_dump($_SESSION);


require_once "../../../assets/template/layout.top.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');



$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);


$pi_no 		= $_REQUEST['pi_no'];





$ms_data=find_all_field('warehouse_transfer_master','s','pi_no='.$pi_no);

$wh_data=find_all_field('warehouse','s','warehouse_id='.$ms_data->warehouse_to);


$concern=find_all_field('user_group','','id='.$_SESSION['user']['group']);




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">


<head>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<title>.: Invoice View :.</title>


<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>


<script type="text/javascript">


function hide()


{


    document.getElementById("pr").style.display="none";


}


</script>


<style>


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

.jvbutton {
    display: block;
	float:left;
    width: auto;
    height: 25px;
    background: #4E9CAF;
    padding: 5px 20px 5px 20px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    line-height: 25px;
	
	margin-right: 20px;
}


.jvbutton:hover {

    color: #000000;
    font-weight: bold;

}

/*@media print{
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;

  
   text-align: center;
}
}
*/
</style>
</head>


<body style="font-family:Tahoma, Geneva, sans-serif">


<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">

<thead>
  <tr>


    <td colspan="2"><div class="header">
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
    
		  <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0; padding: 0 10px; background:#CCCCCC;  border-radius: 5px; ">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="38%">
                       		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									  <td style="padding-bottom:3px;"><span style="font-size:15px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$group_data->group_name?></span></td>
							  </tr>
							  
							  
									
									
									<tr>
									  <td style="font-size:14px; line-height:24px;"><?=$group_data->address?></td>
									</tr>
									<tr><td style="font-size:14px; line-height:24px;"><?=$group_data->cr_no?></td>
									</tr>
									
							  
							  <tr><td style=" font-size:14px; line-height:24px;"><?=$group_data->vat_reg?></td>
							  </tr>
						  </table>					    </td>
						  
						  <td width="24%" align="center">
						  <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									<td>
						  	          <div align="center"><img src="../../../logo/<?=$_SESSION['user']['group']?>.png"  width="50%" />
						  	            
					  	                        </div></td>
							</tr>
							</table>
						  </td>
                        
                        <td width="38%"> 
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									  <td style="padding-bottom:3px;"><span style="font-size:18px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$group_data->group_name_arabic;?>
									  </span></td>
							  </tr>
							  
							  
									
									
									<tr>
									  <td style="font-size:14px; line-height:24px;"><?=$group_data->address_arabic?></td>
									</tr>
									<tr><td style="font-size:14px; line-height:24px;"><?=$group_data->cr_no_arabic?></td>
									</tr>
									
							  
							  <tr><td style=" font-size:14px; line-height:24px;"><?=$group_data->vat_reg_arabic?></td>
							  </tr>
						  </table>						  </td>                    </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
          </tr>



        </table></td>
	    </tr>
		
		 <tr> <td><hr /></td></tr>
    </table>
	
	
	


	<table width="100%" border="0" cellspacing="0" cellpadding="0">


	  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  <tr><td>&nbsp;</td></tr>
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; "><span style="color:#FFF; font-size:18px; background:#CCCCCC; padding:8px 30px; color:#000000; font-weight:bold; border: 2px solid #000000; border-radius: 5px; ">
	  <?=$group_data->invoice_type?></span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>
	  
	  <tr><td>&nbsp;</td></tr>
	 
  </table>
  
  </td></tr>
		
		
		
		
		
		<tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		
		

		  <tr>

		    <td valign="top">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  
			  
			  
			  
			  
			  
			  
			  <tr>
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style="  ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold;" class="style8">Transfer No: <strong><?php echo $pi_no;?></strong>&nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold; float: left;" class="style8">Send Date:
                            <?=date("d-M-Y",strtotime($ms_data->pi_date))?>
                      &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

                  <tr>
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; " class="style8">
		               Warehouse From:  <?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$ms_data->warehouse_from);?>		              &nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; " class="style8">Warehouse To: <?php echo $wh_data->warehouse_name;?> &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        <tr>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8"><?=$group_data->vat_reg?>&nbsp;</span></td>
		              </tr>

		            </table></td>
					
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">Contact No: <span style="font-size:12px; font-weight:700;"><?php echo $wh_data->mobile_no;?></span>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>
				  
				  
				  <tr>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8"><?=$group_data->cr_no?>&nbsp;</span></td>
		              </tr>

		            </table></td>
					
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">Address: <span style="font-size:12px; font-weight:700;"><?php echo $wh_data->address;?></span>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

                  
		        </table>		      </td>

			<td width="30%"><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="font-size:10px">
			
			
	

			  <tr>

			    <td align="center" valign="middle"><img style="margin:0; padding:0;" src="https://chart.googleapis.com/chart?chs=140x140&cht=qr&chl=TAMIM HIJAZ COMPANY LIMITED&choe=UTF-8" title="TAMIM HIJAZ COMPANY LIMITED" /></td>
			    </tr>
				
				
				
				
				
			

			  

			  </table></td>

		  </tr>

		</table></td>

	  </tr>


	  
    </table>


    </div></td>
  </tr>




  <tr>


	<td colspan="2">&nbsp; 	</td>
  </tr>


  <tr id="pr">
  	<td width="94"><div >


  <div align="left">


<input name="button" type="button" onclick="hide();window.print();" value="Print" />
  </div>


</div></td>
    <td width="706"><!--<a target="_blank"  class="jvbutton" href="production_consumption_report.php?v_no=<?=$pr_no;?>"> Consumption View</a>--></td>
  </tr>
  
  
  </thead>
  
  <tbody>  
  <tr>


    <td colspan="2">


      


<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5" style="font-size:12px">


       <tr>


        <td width="4%" align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>

        <td width="9%" align="center" bgcolor="#CCCCCC"><strong>Code</strong></td>
        <td width="39%" align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>


        <td width="9%" align="center" bgcolor="#CCCCCC"><strong>Ctn Price </strong></td>
        <td width="9%" align="center" bgcolor="#CCCCCC"><strong>Pcs Price </strong></td>
        <td width="9%" align="center" bgcolor="#CCCCCC"><strong>Ctn</strong></td>
        <td width="9%" align="center" bgcolor="#CCCCCC"><strong>Pcs</strong></td>
        <td width="12%" align="center" bgcolor="#CCCCCC"><strong>Amount</strong></td>
       </tr>
		
		
		  <?
	   
	   
//$sql_sub="select a.*, i.sub_group_id, s.sub_group_name from warehouse_transfer_detail a, item_info i, item_sub_group s where a.item_id=i.item_id and i.sub_group_id=s.sub_group_id and  a.pi_no='$pi_no' 
//group by i.sub_group_id";
//$data_sub=mysql_query($sql_sub);
//
//while($info_sub=mysql_fetch_object($data_sub)){ 
	   
	   
	   ?>
		
		
		
		
		<?

 $sql1="select b.*, i.unit_name, i.item_name, i.finish_goods_code, s.sub_group_name from warehouse_transfer_detail b,item_info i,item_sub_group s where i.sub_group_id=s.sub_group_id and b.item_id=i.item_id and b.pi_no = '".$pi_no."' order by s.sub_group_id ";


$data1=mysql_query($sql1);





$pr=0;


$total=0;


while($info=mysql_fetch_object($data1)){ 


$pr++;





$qc_by=$info->qc_by;


$item_id = $info->item_id;
$sub_group_name = $info->sub_group_name;

$unit_name= $info->unit_name;


$bag_unit = $info->bag_unit;
$bag_size= $info->bag_size;
$total_unit= $info->total_unit;

$entry_at = $info->entry_at;




		
		
		
		?>


       



      


      <tr>


        <td align="center" valign="top"><?=$pr?></td>

        <td align="center" valign="top"><?=$item_id;?></td>
        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id);?></td>


        <td align="right" valign="top"><?=$info->crt_price;?></td>
        <td align="right" valign="top"><?=$info->unit_price;?></td>
        <td align="right" valign="top"><?=$info->pkt_unit; $total_pkt_unit +=$info->pkt_unit;?></td>
        <td align="right" valign="top"><?=$info->total_unit; $total_total_unit += $info->total_unit;?></td>
        <td align="right" valign="top"><?=$info->total_amt; $total_total_amt += $info->total_amt;?></td>
      </tr>




		  <?   }?>

      <tr>
        <td colspan="3" align="right" valign="top"><strong><span style="text-transform:uppercase;">Total <?php /*?><?=$info_sub->sub_group_name?><?php */?>:</span></strong></td>
        <td align="center" valign="top">&nbsp;</td>
        <td align="center" valign="top">&nbsp;</td>
        <td align="right" valign="top"><strong>
          <?=number_format($total_pkt_unit,2);?>
        </strong></td>
        <td align="right" valign="top"><strong>
          <?=number_format($total_total_unit,2);?>
        </strong></td>
        <td align="right" valign="top"><strong>
          <?=number_format($total_total_amt,2);?>
        </strong></td>
      </tr>
		<? // }?>
 
 
  </table></td>
  </tr>
  
  <tr>

	    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		
		

		  <tr>

		    <td valign="top">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

		        

                  <tr>

		          <td><table width="100%" height="70" border="1" cellpadding="3" cellspacing="0">

		            <tr>

		              <td valign="top"><span style="font-size:16px; font-weight:500; letter-spacing:.3px;" class="style8">
					  In Word: SAR
            <?
	

$taxable_amount =  $total_total_amt-$ms_data->cash_discount;
$tot_vat_amt = ($taxable_amount*$ms_data->vat)/100;
$amount_including_vat = $taxable_amount+$tot_vat_amt;
			
			

		$scs =  number_format($amount_including_vat,2);

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' Halala ';}

	 echo ' Only';

		?>.
					  
					  </span></td>
		              </tr>

		            </table></td>
		          </tr>
				  
				  
				  <tr>

		          <td><table width="100%" height="70" border="1" cellpadding="3" cellspacing="0">

		            <tr>

		              <td valign="top"><span style="font-size:12px; font-weight:500; letter-spacing:.3px;" class="style8">
					  <strong>Declaration:</strong><br />
					  We declare that this invoice shows actual price of Those goods described and that all particulars are true and correct. <br />
					  N.B.: Software Generate Bill. Signatory Not Required. 
            
					  
					  </span></td>
		              </tr>

		            </table></td>
		          </tr>
		        </table>		      </td>

			<td width="40%">
			 
			    <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			      
			      
			      
			      <tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Total (Excluding VAT) 
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			              <?=number_format($total_total_amt,2);?>
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
					
					
					
					<tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Discount
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			              <?=number_format($ms_data->cash_discount,2);?>
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
					
					
					<tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Total Taxable Amount
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			             
						  
						  <?=$taxable_amount =  $total_total_amt-$ms_data->cash_discount;?>
						  
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
					
					
					<tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Total VAT
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			              <?= $tot_vat_amt = ($taxable_amount*$ms_data->vat)/100;?>
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
					
					
					<tr>
			        
			        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			          
			          <tr>
			            
			            <td width="68%"><strong>Total Amount Including VAT 
			              
			              </strong>&nbsp;</td>
						  
						   <td width="32%"><strong>
			              <?=number_format($amount_including_vat = $taxable_amount+$tot_vat_amt,2);?>
			              </strong>&nbsp;</td>
	                    </tr>
			          
			          </table></td>
		            </tr>
			      
			      
			      
			      </table>
		      </td>
		  </tr>

		</table></td>

	  </tr>
  
  
  
  </tbody>
  
<tfoot >

	<tr>
		<td colspan="2">
	
	 <div class="footer"> 
	<table width="100%" cellspacing="0" cellpadding="0"   >
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		   <tr>
		  <td align="center"  style=" font-size:12px;">
		  
		  <?php echo find_a_field('user_activity_management','fname','user_id='.$ms_data->entry_by);?></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr>
		  <td align="center" >---------------------------------</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">---------------------------------</td>
		  </tr>
		<tr>
		  <td align="center"></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong>Prepared By </strong></td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%"><strong>Received By </strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		
			
	
			
			
				
	
	<tr>
            <td colspan="3">  <hr /> </td>
		</tr>
		
		
		
		
	
        
	
          <tr>
            <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" ><?=$group_data->group_name?></td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Address: <?=$group_data->address?></td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: <?=$group_data->mobile;?>,  Email: <?=$group_data->email;?></td>
          </tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web:  <?=$group_data->website;?></td>
          </tr>
	</table>
	
	</div>
	
</td>
	  </tr>
	
	</tfoot>

  
</table>


</body>


</html>


