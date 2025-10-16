<?php



//



//====================== EOF ===================



//var_dump($_SESSION);




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//require_once ('../../../acc_mod/common/class.numbertoword.php');

$lc_no = $_REQUEST['lc_no'];


$lc_data = find_all_field('lc_number_setup','','id='.$lc_no); 
$bnk_data = find_all_field('lc_bank_entry','','lc_no='.$lc_no); 
$po_data = find_all_field('lc_purchase_master','','lc_no='.$lc_no);

$closing_val = find_a_field('lc_purchase_closing','lc_no','lc_no='.$lc_no);

$group_data = find_all_field('user_group','','id='.$lc_data->group_for);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$lc_data->lc_number;?></title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";



}



</script>
<style type="text/css">



<!--
.header table tr td table tr td table tr td table tr td {
	color: #000;
}

/*@media print{
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;

   color: white;
   text-align: center;
}
}*/
-->


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

</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
<!--<thead>-->
  <tr>
    <td colspan="2"><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="20%">
                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['group']?>.png" width="65%" />
                        <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">
						
								<p style="font-size:20px; color:#000000; margin:0; padding:0; text-transform:uppercase;"><?=find_a_field('user_group','group_name','id='.$lc_data->group_for)?></p>
								<p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=find_a_field('user_group','address','id='.$lc_data->group_for)?></p>                              </td>
                            </tr>
                            <tr>


        <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
      </tr>
                          </table>
                      <td width="20%">                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>          </tr>
        </table>
      </div></td>
  </tr>
  
 <!--</thead>-->
 
 
 
 
 
 
  <tbody>
 
  <tr> <td colspan="2"><hr /></td></tr>
 
  
  
  <tr> <td colspan="2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  	<tr height="30">
  	  <td valign="top"></td>
  	  <td  style="text-align:center; color:#FFF; font-size:18px; padding:0px 0px 10px 0px; color:#000000; font-weight:bold;"><span style="text-decoration:underline">
	  Reference No: <?=$lc_data->lc_number?></span> </td>
  	  <td valign="right" align="right"><strong><?php /*?>Order Date:
          <?=date("d M, Y",strtotime($master->po_date))?><?php */?>
  	  </strong></td>
	  </tr>
	
	<tr>
		<td width="25%" valign="top">&nbsp;</td>
			<td width="50%" valign="middle" align="center">&nbsp;</td>
		<td width="25%" valign="right" align="right">&nbsp;</td>
	</tr>
  </table>
  
  </td></tr>
  
  
  <tr> <td colspan="2">&nbsp;</td></tr>
  
  
  
 <tr> <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">


		  <tr>


		    <td width="68%" valign="top">


		      <table width="96%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">
		        <tr>
		          <td align="left" valign="middle"><strong>Reference No. </strong></td>
		          <td>: &nbsp;<?=$lc_data->lc_number?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>L/C Type </strong></td>
		          <td>: &nbsp;<?= find_a_field('lc_type','lc_type','id="'.$lc_data->lc_type.'"');?></td>
	            </tr>
		        
		        
		        <tr>
		          <td align="left" valign="middle"><strong> Vendor Name</strong></td>
		          <td>: &nbsp;<?= find_a_field('vendor','vendor_name','vendor_id="'.$po_data->vendor_id.'"');?></td>
	            </tr>
		        <tr>
		          <td align="left" valign="middle"><strong>Vendor Agent</strong></td>
		          <td>: &nbsp;<?= find_a_field('agent_info','agent_name','agent_id="'.$po_data->supplier_agent.'"');?></td>
	            </tr>
		        </table>		      </td>


			<td width="32%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2"  style="font-size:11px">
			
			
			
			<tr>


                <td width="51%" align="right" valign="middle"><strong> PI No: </strong></td>


			    <td width="49%"><table width="100%" border="1" cellspacing="0" cellpadding="1">


                    <tr height="20">


                      <td> &nbsp;<?=$po_data->pi_no?></td>
                    </tr>


                </table></td> </tr>




			  <tr>


                <td width="51%" align="right" valign="middle"><strong>PI Date:</strong></td>


			    <td width="49%"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>
                      &nbsp;<?=date("d M, Y",strtotime($po_data->pi_date))?>                    </td>
                  </tr>
                </table></td> </tr>
				
				
				<tr>

				<td align="right" valign="middle"><strong> Bank L/C No: </strong></td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>&nbsp;<?=$bnk_data->bank_lc_no?></td>
                  </tr>
                </table></td>
			    </tr>
				
				
				
				
				
				<tr>

				<td align="right" valign="middle"><strong>  L/C Value: </strong></td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="1">
                  <tr height="20">
                    <td>
                      &nbsp;<?=number_format($bnk_data->lc_value,2);?>                   </td>
                  </tr>
                </table></td>
			    </tr>


			  


			  


		    </table></td>
		  </tr>


		</table>		</td></tr>
  
  
 
  <tr>
    <td width="95"><div id="pr">
        <div align="left">
          <p>
            <input name="button" type="button" onclick="hide();window.print();" value="Print" />
          </p>
          <nobr>
          <!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;--><!--<a href="do_view.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank"><span style="display:inline-block; font-size:14px; color: #0033FF;">Bill Copy</span></a>-->
          </nobr>
		  <nobr>
          
          <!--<a href="chalan_bill_distributor_vat_copy.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank">Vat Copy</a>-->
          </nobr>	    </div>
      </div>	  </td>
	  
	  
	  <td width="705">&nbsp;</td>
  </tr>
  
  
  <tr>
  	<td colspan="2">
		<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        <tr>
          <td colspan="4"><table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px">
        
        <tr>
          <td colspan="5" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>L/C Payment Details </strong></td>
          </tr>
        <tr>
          <td width="6%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td width="17%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>TR No </strong></td>
          <td width="17%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Date</strong></td>
          <td width="40%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong> Payment Category </strong></td>
          <td width="20%" align="center" bordercolor="#000000" bgcolor="#CCCCCC"><strong>Amount</strong></td>
          </tr>
		  
		   <? 
		   
		   
		   $sql = "select tr_no, jv_no from secondary_journal where tr_from='LC Journal' and tr_id='".$lc_no."' group by tr_no";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
		 $jv_no[$info->tr_no]=$info->jv_no;
		 
		 }
		   
		   
		    $sqlt = 'SELECT c.id, c.bill_type from lc_bill_payment a, lc_bill_type c
		 where a.bill_type=c.id  and a.lc_no="'.$lc_no.'" group by a.bill_type order by c.id';
			$queryt=db_query($sqlt);
			while($datat = mysqli_fetch_object($queryt)){

			?>
		  
		   <tr style="font-size:12px;">
          <td align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">&nbsp;</td>
          <td align="left" valign="top"><strong><?=$datat->bill_type;?></strong></td>
          <td align="right" valign="top">&nbsp;</td>
          </tr>
		  
		  
        
        <?  $sqlc = 'SELECT sum(a.pay_amt_in) as pay_amt_in, a.payment_date, a.payment_no, c.bill_category from lc_bill_payment a, lc_bill_category c
		 where a.bill_category=c.id  and a.lc_no="'.$lc_no.'" and a.bill_type="'.$datat->id.'" group by a.id order by a.bill_type,a.bill_category ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){

			?>
        <tr style="font-size:12px;">
          <td align="center" valign="top"><?=++$kksm;?></td>
          <td align="center" valign="top"><a href="../report/general_voucher_print_view_from_journal.php?jv_no=<?= $jv_no[$datac->payment_no];?>" target="_blank"><?=$datac->payment_no?></a> </td>
          <td align="center" valign="top"><?=date("d-m-Y",strtotime($datac->payment_date))?></td>
          <td align="left" valign="top"><?=$datac->bill_category?></td>
          <td align="right" valign="top"><?=number_format($datac->pay_amt_in,2); $tot_pay_amt_in +=$datac->pay_amt_in; ?></td>
          </tr>
        
        <? }?>
        <tr style="font-size:12px;">
        <td colspan="4" align="right" valign="middle"><strong>Sub Total:</strong></td>
        <td align="right" valign="middle"><strong><?=number_format($tot_pay_amt_in,2); $total_tot_pay_amt_in +=$tot_pay_amt_in;?></strong></td>
        </tr>
		
		
		<? 
		$tot_pay_amt_in=0;
		}?>
		
	<tr style="font-size:12px;">
        <td colspan="4" align="right" valign="middle"><strong> Total:</strong></td>
        <td align="right" valign="middle"><strong><?=number_format($total_tot_pay_amt_in,2) ;?></strong></td>
        </tr>
        
      </table></td>
		  </tr>
		</table>
	
	</td>
  
  </tr>
  
  

  
  
  
  <tr>
  	<td colspan="3">
			<table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >
        
        
        
		  
		  <tr>
		<td colspan="2" align="right">&nbsp;</td>
          <td colspan="2" width="43%" align="right">		  </td>
          </tr>
		  
		  <tr>
		<td colspan="4" align="left" style="font-size:16px">&nbsp;</td>
          </tr>

        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
		
		<tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
		
		<tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
		
		<tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
        
        
        
        
        
        <?php /*?><tr>
          <td align="left" style="font-size:10px">
          <ul>
            <li>The Copy of Work Order must be shown at the factory premises during the delivery.</li>
            <li>Company protects the right to reconsider or cancel the Work-Order every nowby any administrational dictation.</li>
            <li>Any inefficiency in maintanence must be informed(Officially) before the execution to avoid the compensation.</li>
        </ul></td>
        </tr><?php */?>
        <tr>
          <td colspan="4" align="left">&nbsp;</td>
        </tr>
      </table>	</td>
  </tr>
	</tbody>
	
	
	<!--<tfoot>-->
	<tr>
		<td colspan="2">
	
	
	<!-- style="border:1px solid #000; color: #000;"-->
	      <div class="footer"> 
	
	<table width="100%" cellspacing="0" cellpadding="0"  >
	
	
		
		<tr>
            <td colspan="4">&nbsp;  </td>
		</tr>
		
		<tr>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">-------------------------------------</td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td align="center"  width="25%"><strong>Authorized By </strong></td>
		</tr>
		
		<tr>
            <td colspan="2"><!--Prepared By :
                <?=find_a_field('user_activity_management','fname','user_id='.$master->entry_by);?>,&nbsp; Prepared At :
                <?=$master->entry_at?> --> </td>
		    <td colspan="2">This is an ERP generated report </td>
		    </tr>
	
	<tr>
            <td colspan="4">  <hr /> </td>
		</tr>
	
        
	
          <tr>
            <td colspan="4" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" >
			<? $data=mysqli_fetch_object(db_query("select * from project_info limit 1"));	?>	
			<?php echo $data->proj_name ?></td>
		</tr>
		  <tr>
			 <td colspan="4" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" >Head Office: <?php echo $data->proj_address;?></td>
		</tr>
		  <tr>
			 <td colspan="4" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Phone: <?php echo $data->proj_phone;?></td>
          </tr>
		  <tr>
			 <td colspan="4" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" >Web: <?php echo $data->website;?></td>
          </tr>
	</table>
	  </div>	</td>
  </tr>
  
  <!--</tfoot>-->
</table>
</body>
</html>
