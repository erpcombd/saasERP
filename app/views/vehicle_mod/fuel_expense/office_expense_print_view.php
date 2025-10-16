<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
require_once "../../../assets/support/inc.all.php";
require_once ('../../../acc_mod/common/class.numbertoword.php');
$expense_no 		= $_REQUEST['expense_no'];

$datas=find_all_field('fuel_expense','s','expense_no='.$expense_no);

$sql1=" select d.*,m.*, i.item_name from fuel_expense_detail d, fuel_expense m, item_info i where i.item_id=d.item_id and d.expense_no=m.expense_no and m.expense_no=".$expense_no;
$data1=mysql_query($sql1);


$pi=0;
$total=0;
while($info=mysql_fetch_object($data1)){ 
$pi++;
$item_name[] = $info->item_name;
$uom[]=$info->uom;
$qty[]=$info->qty;
$rate[] = $info->rate;
$amount[] = $info->amount;
$att_file[]=$info->att_file;
$entry_by = find_a_field('user_activity_management','fname','user_id="'.$datas->entry_by.'"');
$checked_by = find_a_field('user_activity_management','fname','user_id="'.$datas->checked_by.'"');
$approved_by = find_a_field('user_activity_management','fname','user_id="'.$datas->approved_by.'"');
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
<style type="text/css">
<!--
.style1 {color: #000000}
.style6 {color: #FF3366; font-weight: bold; }
-->
</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif"><br /><br /><br />
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
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
		          <td width="20%" align="left" valign="middle">Staff No. </td>
				  <td>:</td>
		          <td width="80%"><?php echo $expense_no;?></td>
		        </tr>
				<tr>
		          <td width="20%" align="left" valign="middle">Staff Name. </td>
				  <td>:</td>
		          <td width="80%"><?=$entry_by?></td>
		        </tr>
				  
				 <tr>
		          <td width="20%" align="left" valign="middle">Department </td>
				  <td>:</td>
		          <td width="80%"></td>
		        </tr>
				
				
		         
		        
		        </table>		      </td>
			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			 <tr>
		          <td width="20%" align="left" valign="middle">Expense No. </td>
				  <td>:</td>
		          <td width="80%"><?php echo $expense_no;?></td>
		        </tr>
			
				<tr>
		          <td width="20%" align="left" valign="middle">Expense Date </td>
				  <td>:</td>
		          <td width="80%"><?=date('d-m-Y',strtotime($datas->expense_date));?></td>
		        </tr>
				<tr>
		          <td width="20%" align="left" valign="middle">Status </td>
				  <td>:</td>
		          <td width="80%"><?=$datas->status;?></td>
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
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="2" style="font-size:11px;">
       
       <tr>
         <td align="center" bgcolor="#FFFFFF"><strong>SL</strong></td>
		 <td align="center" bgcolor="#FFFFFF"><strong>Expense Head</strong></td>
		 <td align="center" bgcolor="#FFFFFF"><strong>Amount</strong></td>
		 <td align="center" bgcolor="#FFFFFF"><strong>Attachment</strong></td>
        </tr>
       
<? for($i=0;$i<$pi;$i++){ 

?>

      <tr style="line-height:20px;">
        <td align="center" valign="top"><?=$i+1?></td>
   
		<td align="left" valign="top"><? echo $item_name[$i]?></td>
		<td align="right"> <b><?=$amount[$i]?></b></td>
		<td align="center"> <b><? if($att_file[$i]!=''){?><a href="<?=$att_file[$i]?>" target="_blank">View</a><? } ?></b></td>
        
        </tr>
		
       <? $tot_amt = $tot_amt+$amount[$i]; }?>
      
		
		
		
		
      
      <tr style="border-bottom:#FFFFFF">
        <td colspan="2" align="center" valign="top"><div align="right"><strong>Total  </strong></div></td>
       
        
        <td align="right" valign="top"><strong>
          <?=number_format($tot_amt,2)?>
        </strong></td>
		<td>&nbsp;</td>
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
     	<td width="23%" align="center" > <?=$checked_by?></td>

		  <td width="23%" align="center" > <?=$approved_by?></td>

        
	</tr>
	
	<tr>
     	<td width="23%" align="center" ><div align="center">_________________</div></td>

		  <td width="23%"> <div align="center">_________________</div></td>

          
	</tr>
        

        <tr>

          <td width="23%"> <div align="center">Checked By </div></td>

		  <td width="23%"><div align="center">Approved By</div></td>
         
          </tr>
		  
      </tr>
	  <tr>

        

        <td align="center" valign="bottom">&nbsp;</td>

  

        <td align="center" valign="bottom">&nbsp;</td>

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
