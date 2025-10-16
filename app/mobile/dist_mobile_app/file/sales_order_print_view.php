<?php

//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);

session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$do_no 		= $_REQUEST['v_no'];
$master= find_all_field('sale_do_master','','do_no='.$do_no);
$group_data = find_all_field('user_group','group_name','id='.$master->group_for);


  		  $barcode_content = $chalan_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}

$ssql = 'select a.* from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;

$dealer = find_all_field_sql($ssql);

$entry_time=$dealer->do_date;


$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;
$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('sale_do_chalan','sum(pkt_unit)','chalan_no='.$chalan_no);

$to_pcs = find_a_field('sale_do_chalan','sum(dist_unit)','chalan_no='.$chalan_no); 



$ordered_total_ctn = find_a_field('sale_do_details','sum(pkt_unit)','dist_unit = 0 and do_no='.$do_no);

$ordered_total_pcs = find_a_field('sale_do_details','sum(dist_unit)','do_no='.$do_no); 

?>

<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide(){
document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">


@media (max-width: 767px) {
		
}
<!--
.header table tr td table tr td table tr td table tr td {
	color: #000;
}



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

@media print {
  .brack {page-break-after: always;}
  .back_button{
  		display: none !important;
  }
}
</style>




<div class="page_brack" >

<a href="report_view.php" class="back_button"><button class="btn btn-print" style="margin-bottom: 10px; padding: 8px 15px; text-transform: uppercase; background-color: #00BCD4; color: white; border: none; border-radius: 5px; cursor: pointer;" >Back </button></a>

	<div id="pr"><input name="button" type="button" onclick="hide();window.print();" value="Print"  style="margin-bottom: 10px; padding: 8px 15px; text-transform: uppercase; background-color: #0f3193; color: white; border: none; border-radius: 5px; cursor: pointer;" />
	</div>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">

  
  <thead>
  <tr>
    <td><div class="header" style="margin-top:0; padding: 5px 10px; background:#CCCCCC;  border-radius: 5px;  ">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
		  <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="25%">
						<table width="100%" border="0" cellspacing="0" align="center" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									<td>
						  	          <div align="left"><img src="../../../logo/<?=$master->group_for?>.png"   style=" width:75%;"  />
						  	            
		  	                          </div></td>
							</tr>
							</table> 
						
						</td>
                        <td width="50%" align="center">
						  <table width="100%" border="0" cellspacing="0" align="center" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									<td>&nbsp;
						  	          </td>
							</tr>
							</table>
						  </td>
                        
                        <td width="25%"> 
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									  <td style="padding-bottom:3px;"><span style="font-size:16px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$group_data->group_name?></span></td>
							  </tr>
							  
							  
									
									
									<tr>
									  <td style="font-size:14px; line-height:24px;"><?=$group_data->address?></td>
									</tr>
									
									
							  
							  <tr><td style=" font-size:14px; line-height:24px;"><?=$group_data->vat_reg?></td>
							  </tr>
						  </table>						  </td>                    </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
       </div></td>
  </tr>
  
  
  


 
 
 
 
 <tr> <td><hr /></td></tr>

 
  
 
  
  
  <tr> <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  <tr><td>&nbsp;</td></tr>
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; "><span style="color:#FFF; font-size:18px; background:#CCCCCC; padding:8px 30px; color:#000000; font-weight:bold; border: 2px solid #000000; border-radius: 5px; ">
	  SALES ORDER</span> </td>
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
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold;" class="style8"> SO No: <?php echo $master->do_no?> &nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold; float: left;" class="style8"> SO Date:
                            <?=$master->do_date?>
                      &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

                  <tr>
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>
		              <td ><span style="font-size:14px;" class="style8">
		               Party Name:  <?=$dealer->dealer_name_e;?>&nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span class="style8" style="font-size:14px; font-weight:bold;">Party Code: <?php echo $dealer->dealer_code2;?> &nbsp; 
		              (Party Type: <?=find1("select dealer_type from dealer_type where id='".$master->sales_type."' ");?>)
		              </span></td>
		              </tr>

		            </table></td>
		          
		          
		          </tr>

		        <tr>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">Address: <?php echo $dealer->address_e?></span></td>
		              </tr>

		            </table></td>
					
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">Contact No: <?php echo $dealer->mobile_no?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>
				  
				  
				  <tr>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">Entry Time: <?php echo $master->entry_at?><br>
		              Approve Time: <?php echo $master->checked_at?>&nbsp;</span></td>
		              </tr>

		            </table></td>
					
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8">Remarks: <?php echo $master->remarks?>&nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

                  
		        </table>		      </td>

<!--<td width="30%"><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="font-size:12px">-->

<!--<tr>-->
<!--<td align="center" valign="middle"><img style="margin:0; padding:0;" src="https://chart.googleapis.com/chart?chs=140x140&cht=qr&chl=<?=$group_data->group_name?>&choe=UTF-8" title="" /></td>-->
<!--</tr>-->

<!--</td>-->
</table>

		  </tr>

		</table></td>

	  </tr>
  
  <tr><td>&nbsp;</td></tr>
</thead>
  
 
  <tbody >
 
  <tr >
    <td valign="top">
      
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px"  >
       
       
<tr>
    <th width="4%" bgcolor="#CCCCCC">SL</th>
    <th width="10%" bgcolor="#CCCCCC">Product Code</th>
    <th width="25%" bgcolor="#CCCCCC">Product</th>
    <th width="5%" bgcolor="#CCCCCC">Qty</th>
    <th width="5%" bgcolor="#CCCCCC">Unit</th>
    <th width="9%" bgcolor="#CCCCCC">TP Rate</th>
    <th width="9%" bgcolor="#CCCCCC">TP Total</th>
    <th width="5%" bgcolor="#CCCCCC">Dis%</th>
    <th width="8%" bgcolor="#CCCCCC">Dis Amt</th>
    <th width="10%" bgcolor="#CCCCCC"><span role="presentation" dir="ltr">Total</span></th>
</tr>
<? 
$res='select  b.item_name, a.*, b.finish_goods_code,a.tp_price as t_price,a.dp_price_per as d_price_per,a.unit_price as d_price
from sale_do_details a, item_info b 
where b.item_id=a.item_id and a.do_no='.$do_no.' order by a.id ';
   
$i=1;
$query = db_query($res);
while($data=mysqli_fetch_object($query)){
?>
<tr>
<td><?=$i++?></td>
<td><?=$data->finish_goods_code?></td>
<td><? if($data->total_amt==0) { echo '<strong>'.$data->item_name.' (Free)</strong>';}else { echo $data->item_name;}?><br><?=$data->item_note?></td>
<td><?=$data->total_unit; $gqty+=$data->total_unit;?></td>
<td><?=$data->unit_name?></td>
<td><?=$data->t_price?></td>
<td><? $tp_total=($data->t_price*$data->total_unit); echo $tp_total; $gtp_total+=$tp_total;?></td>


<td><?
if($master->sales_type==6) {
    //echo $data->d_price_per; 
}else{
   echo $data->d_price_per;  
}
?>

</td>

<td><? $dis_amt = ($tp_total - $data->total_amt); echo $dis_amt; $gdis_amt+=$dis_amt; ?></td>

<td><div align="right"><?=$data->total_amt; $tot_total_amt +=$data->total_amt;?></div></td>
</tr>
<?  } ?>
<tr>

<td colspan="3"><div align="right"><strong> Total:</strong></div></td>
<td><div align="left"><strong><?=$gqty?></strong></div></td>
<td><div align="right"><strong></strong></div></td>
<td><div align="right"><strong></strong></div></td>
<td><div align="left"><strong><?=$gtp_total?></strong></div></td>

<td><div align="right"><strong></strong></div></td>
<td><div align="left"><strong><?=$gdis_amt?></strong></div></td>

<td><div align="right"><strong><?=number_format($tot_total_amt,2);?></strong></div></td>
</tr>


<tr>
<td colspan="10"><span class="style8" style="font-size:14px; font-weight:500; letter-spacing:.3px;">In Word:
<?
$scs =  $tot_total_amt;

			 $credit_amt = explode('.',$scs);

	 if($credit_amt[0]>0){

	 

	 echo convertNumberToWordsForIndia($credit_amt[0]);}

	 if($credit_amt[1]>0){

	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;

	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}

	 echo ' Only.';

		?></span></td>
</tr>


</table>  
Print Time: <?=date('Y-m-d H:i:s');?>     
     
      </td>
  </tr>
  
 


<tr>
<td><table width="100%" border="0" cellspacing="0" cellpadding="0"></table></td>
</tr>
  
  
  </tbody>
  
	
	
	<tfoot >

	<tr>
		<td>
	
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
		  <?php $uid=find_a_field('sale_do_master','entry_by','do_no="'.$do_no.'"'); echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>
		  </td>
		  <td align="center"  style=" font-size:12px;">
		  <?php $uid=find_a_field('sale_do_master','checked_by','do_no="'.$do_no.'"'); echo find_a_field('user_activity_management','fname','user_id="'.$uid.'"')?>
		  </td>
		  <td align="center"></td>
		  </tr>
		<tr>
		  <td align="center" >---------------------------------</td>
		  <td align="center" >---------------------------------</td>
		  <td align="center" >---------------------------------</td>
		  <td align="center">---------------------------------</td>
		  </tr>
		<tr>
		  <td align="center"></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong>Ordered By</strong></td>
            <td align="center" width="25%"><strong>Approved By</strong></td>
            <td align="center" width="25%"><strong>Delivered By </strong></td>
		    <td  align="center" width="25%"><strong>Received By </strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		
			
	
			
			
				
	
	<!--<tr>-->
 <!--           <td colspan="5">  <hr /> </td>-->
	<!--	</tr>-->
		
		
		
		
	
        
	
  <!--        <tr>-->
  <!--          <td colspan="5" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" ><?=$group_data->group_name?></td>-->
		<!--</tr>-->
		<!--  <tr>-->
		<!--	 <td colspan="5" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Address: <?=$group_data->address?></td>-->
		<!--</tr>-->
		<!--  <tr>-->
		<!--	 <td colspan="5" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: <?=$group_data->mobile;?>,  Email: <?=$group_data->email;?></td>-->
  <!--        </tr>-->
		<!--  <tr>-->
		<!--	 <td colspan="5" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web:  <?=$group_data->website;?></td>-->
  <!--        </tr>-->
	</table>
	
	</div>
	
</td>
	  </tr>
	
	</tfoot>
	
  
</table>


</div>



<?php 
 require_once '../assets/template/inc.footer.php';
 ?>