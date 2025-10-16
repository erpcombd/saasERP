<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//require_once ('../../../acc_mod/common/class.numbertoword.php');
$expense_no 		= $_REQUEST['expense_no'];

$datas=find_all_field('fuel_expense','s','expense_no='.$expense_no);

$sql1=" select d.*,m.*, i.expense_name as item_name,d.expense_date as claim_date from fuel_expense_detail d, fuel_expense m, expense_head i where i.id=d.item_id and d.expense_no=m.expense_no and m.expense_no=".$expense_no;
$data1=db_query($sql1);


$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$pi++;
$item_name[] = $info->item_name;
$uom[]=$info->uom;
$qty[]=$info->qty;
$rate[] = $info->rate;
$amount[] = $info->amount;
$vendor[] =  $info->vendor;
$att_file[]=$info->att_file;
$entry_by = find_a_field('user_activity_management','fname','user_id="'.$datas->entry_by.'"');
$checked_by = find_a_field('user_activity_management','fname','user_id="'.$datas->checked_by.'"');
$approved_by = find_a_field('user_activity_management','fname','user_id="'.$datas->approved_by.'"');
$expense_date = $info->entry_at;
$expense_date2[] = $info->claim_date;
}

//if(isset($_POST['cash_discount']))
//{
//	$c_no = $_POST['c_no'];
//	$cash_discount = $_POST['cash_discount'];
//	$ssql='update sale_do_chalan set cash_discount="'.$_POST['cash_discount'].'" where chalan_no="'.$c_no.'"';
//	mysql_query($ssql);
//
//}

$company_info = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Claim Form :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>

</head>
<body style="font-family:Tahoma, Geneva, sans-serif"><br /><br /><br />
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
				<table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">

                  <tr>

                   <!-- <td  style="text-align:center;  font-size:14px; font-weight:bold;"><span class="style4"><img src="../../../logo/demo7.png" style="width:190px;"/><br /><br />

                          <span style="color:black;"><?=$company_info->address?></span></span><br /><br /></td>-->
                  </tr>

                  

                </table>
				<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" style="background:darkgray;">
      <tr>
        <td style="text-align:center; color:white; font-size:18px; font-weight:bold;"><span class="style1" >Claim Form</span></td>
      </tr>
    </table></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td valign="top">
		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
		        
				<tr>
		          <td width="20%" align="left" valign="middle">Claim No.</td>
				  <td>:</td>
		          <td width="80%"><?php echo $expense_no;?></td>
		        </tr>
				<tr>
		          <td width="50%" align="left" valign="middle">Full Name Of Staff/Claimer </td>
				  <td>:</td>
		          <td width="50%"><?php echo $entry_by;?></td>
		        </tr>
				
		         
		        
		        </table>		      </td>
			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			 <tr>
		          <td width="20%" align="left" valign="middle">Submit Date. </td>
				  <td>:</td>
		          <td width="80%"><?php echo date('d-M-y',strtotime($expense_date));?></td>
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
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
    <td>
      <div id="pr">

  <div align="left">

<input name="button" type="button" onclick="hide();window.print();" value="Print" />

  </div>

</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="2" style="font-size:11px; border-collapse:collapse;">
       
       <tr>
         <td align="center" bgcolor="#FFFFFF"><strong>SL</strong></td>
		 <td align="center" bgcolor="#FFFFFF"><strong>Items</strong></td>
		 <td align="center" bgcolor="#FFFFFF"><strong>Date</strong></td>
		 <td align="center" bgcolor="#FFFFFF"><strong>Currency</strong></td>
		 <td align="center" bgcolor="#FFFFFF"><strong>Amount</strong></td>
		 <td align="center" bgcolor="#FFFFFF"><strong>Ref. No.</strong></td>
        </tr>
       
<? for($i=0;$i<$pi;$i++){ 

?>

      <tr style="line-height:20px;">
        <td align="center" valign="top"><?=$i+1?></td>
   
		<td align="left" valign="top"><? echo 'Purchased '.$item_name[$i].' From '.$vendor[$i]?></td>
		<td align="center"> <b><?=$expense_date2[$i]?></b></td>
		<td align="center"> <b>BDT</b></td>
		
		<td align="right"> <b><?=number_format($amount[$i],2)?></b></td>
		<td align="center"> <b><? if($att_file[$i]!=''){?><a href="../../../vehicle_mod/<?=$att_file[$i]?>" target="_blank">Ref. <?=$i+1?> </a><? } ?></b></td>
        
        </tr>
		
       <? $tot_amt = $tot_amt+$amount[$i]; }?>
      
		
      <tr>
        <td colspan="3" align="center"><div align="right"><strong>Total  </strong></div></td>
       
        
        <td align="right">&nbsp;</td>
		<td align="right"><strong>
		  <?=number_format($tot_amt,2)?>
		</strong></td>
        </tr>
	  
      
      
    </table></td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  
 <!-- <tr>
    <td colspan="2" style="font-size:12px"><em>N B : This is software generated bill, Signatiory is not required. </em></td>
    </tr>-->
  <tr>
    <td width="50%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td width="50%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td width="50%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    </table>
    <div class="footer1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    
	<tr>
     	<td width="23%" align="center" > <span style="text-decoration:underline;">Check & Sign By <?=$entry_by?></span><br>Calculation</td>

		  <td width="23%" align="center" ><img src="../../files/signature/s1.png" style="height:80px; width:150px;" /></td>
		  
		  <td width="23%" align="center" > <span style="text-decoration:underline;">Check & Release By Abbas</span><br>Released By Superior</td>
		  
		  <td width="23%" align="center" > <img src="../../files/signature/s1.png" style="height:80px; width:150px;" /></td>

        
	</tr>
	
	<tr>
     	<td width="23%" align="center" > <span style="text-decoration:underline;"><?=$entry_by?></span><br>Received</td>

		  <td width="23%" align="center" ><img src="../../files/signature/s2.jpg" style="height:85px; width:100px; margin-left:-70px;" /><img src="../../files/signature/s1.png" style="height:80px; width:150px;" /></td>
		  
		  <td width="23%" align="center" > <span style="text-decoration:underline;">Check & Approved By MD</span><br>Approved By Managing Director</td>
		  
		  <td width="23%" align="center" > <img src="../../files/signature/s1.png" style="height:80px; width:150px;" /></td>

        
	</tr>
	
	
        

       
		  
      </tr>
	  
	  <tr>

        

        <td align="center" valign="bottom">&nbsp;</td>

  

        <td align="center" valign="bottom">&nbsp;</td>

      </tr>
	  
	  
	 
	  
      <!--<tr>

        

        <td align="left" valign="bottom">................................</td>

  

        <td align="right" valign="bottom">................................</td>

      </tr>-->

      <!--<tr>

        
        <td width="34%"><div align="left">Customer Signature </div></td>

        <td width="33%"><div align="right">Authorize Signature </div></td>

      </tr>-->

    </table> </div>
    </td>
  </tr>
</table>
</body>
</html>
