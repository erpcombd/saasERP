<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once ('../../common/class.numbertoword.php');
$proj_id=$_SESSION['proj_id'];
$_REQUEST['v_type']=strtolower($_REQUEST['v_type']);
$vtype=$_REQUEST['v_type'];
 $jv_no=$_REQUEST['vo_no'];
$no=$vtype."_no";
$vdate=$vtype."_date";

$all = find_all_field('secondary_journal','','jv_no="'.$jv_no.'"');
$cr_amt = find_a_field('secondary_journal','cr_amt','jv_no="'.$jv_no.'" and cr_amt>0');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Voucher :.</title>
<link href="../../../assets/css/voucher_print.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script></head>
<body >
<table width="820" style="border:2px solid black;" cellspacing="0" cellpadding="0" align="center">
  <tr>
     <td><? $path='../../../logo/'.$_SESSION['proj_id'].'.png';
			if(is_file($path)) echo '<img src="'.$path.'" height="80" />';?></td>
	  <td><span style="font-size:30px; font-weight:bold;">AWN</span>&nbsp;&nbsp;<span style="font-size:12px;">Finance</span><br /><span>Jeddah-Makkah-Madinah</span></td>
	 </tr>
	 <tr>
    <td colspan="2">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:5px;">
	  
	  <tr style="background-color:brown; font-weight:bold; color:#FFFFFF; font-size:18px; height:30px;">
	    <td><div align="left">Payment Request</div></td>
		<td><div align="right"><?=$all->jv_no?></div></td>
	    </tr><br />
		
	   <tr style="font-size:15px; height:30px" >  
	    <td colspan="2"><strong> Date : <?=$all->jv_date?></strong></td>
	    </tr>
		
		 <tr style="font-size:15px; height:30px;" >  
	    <td colspan="2"><strong> Subject : <?=$all->received_from?></strong></td>
	    </tr>
		
	  
	  
	  <tr style="font-size:15px; height:30px"  >
	    <td colspan="2" height="30"><strong>Amount :</strong> <span style="border:1px solid #333333;">SAR <?=$cr_amt?></span> SAR<span style="background:#999999;"> 
		
		
		<?
		
		$scs =  $cr_amt;
			 $credit_amt = explode('.',$scs);
	 if($credit_amt[0]>0){
	 
	 echo convertNumberToWordsForIndia($credit_amt[0]);}
	 if($credit_amt[1]>0){
	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}
	 echo ' Only.';
		?>
		
		
		
		
		</span></td>
	    </tr>
	  <tr style="font-size:15px; height:30px;">
	    <td colspan="2"><strong>Beneficiary :  <?=find_a_field('accounts_ledger','ledger_name','ledger_id="'.$all->ledger_id.'"')?></strong></td>
	  </tr>
	  
	  <tr style="font-size:15px; height:30px;">
	    <td style="float:left;"><strong> Method :  <?=$all->type?></strong></td>
		 <td style="float:right;"><strong> Bank Name : </strong> <?=find_a_field('accounts_ledger','ledger_name','ledger_id="'.$all->relavent_cash_head.'"');?></td>
	  </tr>
    </table>    </td>
  </tr>
  <tr>
    
	<td colspan="2">	</td>
  </tr>
  
  <tr>

    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" class="tabledesign_text">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="tabledesign_text"></td>
        </tr>
      <tr>
        <td class="tabledesign_text">&nbsp;</td>
        <td class="tabledesign_text">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
 
  <tr>
    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tabledesign">
      <tr style="background-color:brown; color:#FFFFFF">
        <td align="center"><strong>Discription</strong></td>
        <td><strong>Amount</strong></td>
      </tr>
      
	  <?
           $ssql = 'select * from secondary_journal where dr_amt>0 and jv_no="'.$jv_no.'"';
             $data2=db_query($ssql);
			  while($info=mysqli_fetch_object($data2)){ $pi++;
			  $dr_amt = $dr_amt+$info->dr_amt;
			  
	  ?>
      <tr>
        <td align="left"><?=$info->narration?></td>
        <td align="right"><?=$info->dr_amt?></td>
      </tr>
	  <?php }?>
      <tr style="background-color:brown; color:#FFFFFF">
        <td align="left">
         <strong> <span style="background-color:brown;">SAR  

	
	 
	 <?
		
		$scs =  $dr_amt;
			 $credit_amt = explode('.',$scs);
	 if($credit_amt[0]>0){
	 
	 echo convertNumberToWordsForIndia($credit_amt[0]);}
	 if($credit_amt[1]>0){
	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}
	 echo ' Only.';
		?>
	 
	  </span></strong></td>
        <td align="right"><strong><? echo number_format($dr_amt,2);?></strong></td>
        </tr>

      
      
    </table></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" valign="bottom">......................</td>
        <td align="center" valign="bottom">......................</td>
        <td align="center" valign="bottom">......................</td>
        <td align="center" valign="bottom">......................</td>
        <td align="center" valign="bottom">......................</td>
      </tr>
      <tr style="font-size:15px;">
        <td><div align="center">Accounts</div></td>
        <td><div align="center">Chief Accounts</div></td>
        <td><div align="center">Financial Controller </div></td>
        <td><div align="center">Operation Manage </div></td>
        <td><div align="center">CEO </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?
$main_content=ob_get_contents();
ob_end_clean();

echo $main_content;
echo '<br>';echo '<br>';echo '<br>';echo '<br>';

?>