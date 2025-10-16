<?php
session_start();
ob_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once ('../../../acc_mod/common/class.numbertoword.php');
$service_no	= $_REQUEST['service_no'];

$sql1=" select b.*,c.*,i.item_name,i.item_description,d.dealer_name_e,d.address_e from service_master b,service_details c,item_info i, dealer_info d  where b.service_no=c.service_no and d.dealer_code=b.client_id and  c.item_id=i.item_id and b.service_no = '".$service_no."' group by c.item_id ";
$data1=db_query($sql1);


$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$item_desc[] = $info->item_description;
$pi++;
$entry_time=$info->entry_at;
$sales_date=$info->sales_date;
$service_date = $info->service_date;
$service_note=$info->note;
$service_no = $info->service_no;
$support_type = $info->support_type;
$client_name = $info->dealer_name_e;
$client_address = $info->client_address;
$received_by = find_a_field('user_activity_management','fname','user_id="'.$info->entry_by.'"');
$warranty_status = $info->warranty_status;
$complain_media = $info->complain_media;
$received_branch = find_a_field('warehouse','warehouse_name','warehouse_id="'.$info->received_branch.'"');
$mobile_no = $info->mobile_no;
$chalan_no = $info->invoice_no;
$status = $info->status;
$unit[] = $item_all->unit_name;
$item_id[] = $info->item_id;
$total_unit[] = $info->total_unit;
$serial[] = $info->serial_no;
}


$company_info = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: DELIVERY CHALAN :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style1 {color: #000000}
.style6 {color: #FF3366; font-weight: bold; }
-->
body {
    margin-bottom:50px;
}
html, body {
    height: 100%;
}
footer {
    position: absolute;
    bottom: 0;
}
</style>
</head>
<body style="font-family:none;"><br /><br /><br />
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px; padding-left:30px;">
<tbody>
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
				<table  width="100%" border="0" align="center" cellpadding="3" cellspacing="0">

               <tr>

                    <td  style="text-align:center;  font-size:15px; font-weight:bold; text-align:left; "><img src="<?=SERVER_ROOT?>public/uploads/logo/demo7.png" /></td>
					<td align="center"><strong></strong></td>
					<td  style="text-align:center;  font-size:14px; text-align:right;">Phone: +88 09677996677<br />Email:ccd@ubsbd.com.bd
<br />Web:ubsbd.com.bd<br />Mobile:+88 01992079833</td>
                  </tr>
				   <tr>

                    <td  style="text-align:center;  font-size:15px; text-align:left;" colspan="3">Service Center,4th floor,House No 11,Road No 11,Block G,Banani Dhaka</td>
                  </tr>
				

                  

                </table>
				<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" style=" border-bottom:2px solid #333333;">
      <tr>
        <td style="text-align:center; color:white; font-size:18px; font-weight:bold;"></td>
      </tr>
    </table></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		 <tr>
		   <td colspan="2" align="center" style="text-align:center; color:#000; font-size:18px; font-weight:bold; text-decoration:underline;">Complain Receive</td>
		 </tr>
		  <tr>
		    <td valign="top">
		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:14px;">
		        <tr>
		          <td width="20%" align="left" valign="middle">Order  No </td>
				  <td>:</td>
		          <td width="80%"><?php echo $service_no;?></td>
		        </tr>
				  <tr>
		          <td width="20%" align="left" valign="middle">Support Type </td>
				  <td>:</td>
		          <td width="80%"><?php echo $support_type;?></td>
		        </tr>
		        <tr>
                  <td align="left" valign="middle">Client Name</td>
				  <td>:</td>
		          <td><?php echo $client_name;?></td>
		          </tr>
				  <tr>
		          <td align="left" valign="middle">Client Address</td>
				  <td>:</td>
		          <td><?php echo $client_address;?></td>
		        </tr>
				<tr>
		          <td align="left" valign="middle">Mobile No</td>
				  <td>:</td>
		          <td><?php echo $mobile_no;?></td>
		        </tr>
		        <tr>
		          <td align="left" valign="top">Sales Date</td>
				  <td>:</td>
		          <td><?php echo $sales_date?></td>
		        </tr>
		           <tr>
		          <td align="left" valign="top">Complain Date</td>
				  <td>:</td>
		          <td><?=$service_date;?></td>
		        </tr>
				 
		        </table>		      </td>
			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
                <td width="48%" align="right" valign="middle"> <div align="left">Received By</div></td>
				<td>:</td>
			    <td width="52%"><?=$received_by?></td>
			  </tr>
			  
			 
			  <tr>
                <td width="48%" align="right" valign="middle"> <div align="left">Warranty Status</div></td>
				<td>:</td>
			    <td width="52%"><? echo $warranty_status?></td>
			  </tr>
			  
			   <tr>
                <td width="48%" align="right" valign="middle"> <div align="left">Complain Media</div></td>
				<td>:</td>
			    <td width="52%"><?=$complain_media?></td>
			  </tr>
			   <tr>
                <td width="48%" align="right" valign="middle"> <div align="left">Received Branch</div></td>
				<td>:</td>
			    <td width="52%"><?=$received_branch?></td>
			  </tr>
			  
			  <tr>
                <td width="48%" align="right" valign="middle"> <div align="left">Status</div></td>
				<td>:</td>
			    <td width="52%"><?=$status?></td>
			  </tr>
			  
			 
			 
			  </table></td>
		  </tr>
		</table>		</td>
	  </tr>
    </table>
    </div></td>
  </tr>
  <tr>
    
	<td>	</td>
  </tr>
  
  <tr><br />
    <td><br />
      <div id="pr">

  <div align="left">

<input name="button" type="button" onclick="hide();window.print();" value="Print" />

  </div>

</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="2" style="font-size:14px;font-family:Bank Gothic;">
       
       <tr>
         <td align="center" bgcolor="#FFFFFF"><strong>SL</strong></td>
         <td align="center" bgcolor="#FFFFFF"><strong>Product Description </strong></td>
		 <td align="center" bgcolor="#FFFFFF"><strong>Serial Number </strong></td>
		<!-- <td align="center" bgcolor="#FFFFFF"><strong>Unit Name </strong></td>-->
         <td align="center" bgcolor="#FFFFFF"><strong>Invoice No</strong></td>
        </tr>
       
<? for($i=0;$i<$pi;$i++){ ?>

      <tr style="line-height:20px;">
        <td align="center" valign="top"><?=$i+1?></td>
        <td align="left" valign="top"><? echo $item_desc[$i]?></td>
		<td align="center"><?=$serial[$i]?></td>
        <td align="center"><?=$chalan_no?></td>
        
        </tr>
<? }?>
      
	
      
    </table></td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  
 <!-- <tr>
    <td colspan="2" style="font-size:12px"><em>N B : This is software generated bill, Signatiory is not required. </em></td>
    </tr>-->
 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    </table>
    <div class="footer1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>

        

        <td align="center" valign="bottom">&nbsp;</td>

  

        <td align="center" valign="bottom">&nbsp;</td>

      </tr>
	  <tr>

        

        <td align="center" valign="bottom">&nbsp;</td>

  

        <td align="center" valign="bottom">&nbsp;</td>

      </tr>
	 
	  
      <tr>

        

        <td align="left" valign="bottom">................................</td>

  

        <td align="right" valign="bottom">................................</td>

      </tr>

      <tr>

        
        <td width="34%"><div align="left">Customer Signature </div></td>

        <td width="33%"><div align="right">Authorize Signature </div></td>

      </tr>

    </table> </div>
    </td>
  </tr>
  </tbody>
  
</table>
<div class="footer"></div>
</body>
</html>
<?
$body=ob_get_contents();

ob_end_clean();
echo $body;
echo $body;
?>