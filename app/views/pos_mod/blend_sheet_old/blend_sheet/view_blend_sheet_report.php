<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);

require_once "../../../assets/support/inc.all.php";



$oi_no 		= $_REQUEST['v_no'];



function num_convt($value){
if($value==(int)$value){
echo number_format($value);
}else{
echo number_format($value,2);
}
}




$sql1="select b.*, w.warehouse_name, u.fname from blend_sheet_master b, warehouse w, user_activity_management u  where  b.line_id=w.warehouse_id and b.entry_by =u.user_id and  b.blend_id=".$oi_no;
$data1=mysql_query($sql1);



$pi=0;

$total=0;

while($info=mysql_fetch_object($data1)){ 

$entry_date=$info->blend_date;

$warehouse_id=$info->warehouse_name;

$location=$info->location;

$supervisor_id=$info->fname;

$blend_no=$info->blend_id;


}









?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: View Blend Sheet :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
                            <tr>
                              <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">BLEND SHEET FOR FG PRODUCT</td>
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
                  <td width="54%" valign="top"><table width="100%" border="0" align="left" cellpadding="3" cellspacing="0"  style="font-size:13px">
                      <tr>
                        <td width="40%" align="right" valign="middle">Blend Name : </td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td><strong><?php echo $warehouse_id;?></strong>&nbsp;</td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td width="40%"  align="right" valign="middle">Supervisor Name :</td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td><strong><?php echo $supervisor_id;?></strong></td>
                            </tr>
                          </table></td>
                      </tr>
                      
                  </table></td>
                  <td width="46%" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0"  style="font-size:13px">
                      <tr>
                        <td width="33%" align="right" valign="middle">Blend Date :</td>
                        <td width="67%"><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td>&nbsp;<strong><?php echo $entry_date;?></strong></td>
                            </tr>
                        </table></td>
                      <tr>
                        <td align="right" valign="middle">Blend No  : </td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td>&nbsp;
                               <strong> <?=$blend_no?></strong></td>
                            </tr>
                          </table></td>
                      </tr>
                  </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><div id="pr">
        <div align="left">
          <input name="button" type="button" onclick="hide();window.print();" value="Print" />
        </div>
      </div>
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
<? 
$grand_tot_qty='select sum(qty) as qty from blend_sheet_details where blend_id='.$oi_no.' group by blend_id';
$grand_tot_qty_value=mysql_fetch_object(mysql_query($grand_tot_qty));
$mjr_sql="select m.* from  blend_sheet_section m where   m.blend_id=".$oi_no." order by blend_section asc";

$mjr_data=mysql_query($mjr_sql);

$pi=0;

$total=0;

while($mjr_info=mysql_fetch_object($mjr_data)){ 

$pi++;?>
	   
	    <tr align="left" bgcolor="#CCCCCC">
          <td colspan="14"><strong>Section No : <?= $mjr_info->blend_section?> </strong></td>
        </tr>
		
        <tr bgcolor="#FFFFFF">
		<td width="4%" align="center"><strong>SL</strong></td>
          <td width="7%" align="center"><strong>Sale No</strong></td>
          <td width="5%" align="center"><strong>Lot No </strong></td>
          <td width="10%" align="center"><strong>Garden Name</strong></td>
          <td width="9%" align="center"><strong>Invoice</strong></td>
          <td width="11%" align="center"><strong>Item Gread </strong></td>
          <td width="6%" align="center"><strong>Pkgs</strong></td>
          <td width="6%" align="center"><strong>Sam</strong></td>
          <td width="7%" align="center"><strong>Sam Qty</strong></td>
          <td width="8%" align="center"><strong>Total Kgs </strong></td>
          <td colspan="2" align="center"><strong>Rate</strong></td>
          <td width="12%" align="center"><strong>Amount</strong></td>
          <td width="11%" align="center"><strong>Remarks</strong></td>
        </tr>
<? $tsk_sql='SELECT b.id, b.sale_no, b.lot_no, g.garden_name, b.invoice_no, i.item_name, b.pkgs, b.sam_pay, b.sam_qty, b.qty, b.rate, b.amount from blend_sheet_details b, item_info i, tea_garden g where g.garden_id=b.garden_id and i.item_id=b.item_id  and b.blend_section_id='.$mjr_info->blend_section.' and b.blend_id='.$mjr_info->blend_id;
//echo $tsk_sql;
$tsk_data=mysql_query($tsk_sql);

$pi=0;

$total=0;

while($tsk_info=mysql_fetch_object($tsk_data)){ 


$tot_pkgs+=$tsk_info->pkgs;
$tot_qty+=$tsk_info->qty;
$tot_amount+=$tsk_info->amount;

$gtot_pkgs+=$tsk_info->pkgs;
$gtot_qty+=$tsk_info->qty;
$gtot_amount+=$tsk_info->amount;



$pi++;?>
        <tr>
          <td align="center" valign="top"><?=$pi?></td>
          <td align="left" valign="top"><?=$tsk_info->sale_no?></td>
          <td align="left" valign="top"><?=$tsk_info->lot_no?></td>
          <td align="left" valign="top"><?=$tsk_info->garden_name?></td>
          <td align="left" valign="top"><?=$tsk_info->invoice_no?></td>
          <td align="left" valign="top"><?=$tsk_info->item_name?></td>
          <td align="right" valign="top"><?=$tsk_info->pkgs?></td>
          <td align="right" valign="top"><?=$tsk_info->sam_pay?></td>
          <td align="right" valign="top"><?=$tsk_info->sam_qty?></td>
          <td align="right" valign="top"><?=$tsk_info->qty?></td>
          <td colspan="2" align="right" valign="top"><?=$tsk_info->rate?></td>
		 
		  <td align="right" valign="top"><?=$tsk_info->amount?></td>
          <td align="right" valign="top">&nbsp;</td>
        </tr>
        
        
		<? } ?>
	
	<tr>
          <td colspan="6" align="right" valign="top"><strong>Sub Total </strong></td>
          <td align="right" valign="top"><?=$tot_pkgs?></td>
          <td align="right" valign="top">&nbsp;</td>
          <td align="right" valign="top">&nbsp;</td>
          <td align="right" valign="top"><?=number_format($tot_qty,2)?></td>
          <td colspan="2" align="right" valign="top"><?=number_format($tot_amount/$tot_qty,2)?></td>
          <td align="right" valign="top"><?=number_format($tot_amount,2)?></td>
          <td align="right" valign="top"><?=$pgtot_qty=number_format((($tot_qty/$grand_tot_qty_value->qty)*100),2);$gpgtot_qty+=$pgtot_qty;?></td>
        </tr>
	
<? 
$tot_pkgs=0;
$tot_qty=0;
$tot_amount=0;
//$pgtot_qty=0;
} ?>

<tr>
	  <td colspan="6" align="right" valign="top"><strong>Grand Total</strong></td>
	  <td align="right" valign="top"><strong><?=$gtot_pkgs?></strong></td>
	  <td align="right" valign="top">&nbsp;</td>
	  <td align="right" valign="top">&nbsp;</td>
	  <td align="right" valign="top"><strong><?=number_format($gtot_qty,2)?></strong></td>
	  <td colspan="2" align="right" valign="top"><strong><?=number_format($gtot_amount/$gtot_qty,2)?></strong></td>
	  <td align="right" valign="top"><strong><?=number_format($gtot_amount,2)?></strong></td>
	  <td align="right" valign="top"><strong><?=$gpgtot_qty.'%'?></strong></td>
	  </tr>	
      </table></td>
  </tr>
  
 
  
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="4" style="font-size:12px">&nbsp;</td>
        </tr>
        <tr>
          <td width="50%" colspan="2">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><?php echo $supervisor_id;?></td>
          <td colspan="2" align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><strong>---------------------</strong></td>
          <td colspan="2" align="center"><strong>---------------------</strong></td>
          <td align="center"><strong>---------------------</strong></td>
        </tr>
        <tr>
          <td align="center">Prepared By</td>
          <td colspan="2" align="center">Received By</td>
          <td align="center">Approved By </td>
        </tr>
        
        <tr>
          <td colspan="2">&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="center"><blockquote>
            <p>&nbsp;</p>
          </blockquote></td>
          <td colspan="2" align="center"><blockquote>
            <p>&nbsp;</p>
          </blockquote></td>
        </tr>
      </table>
      <div class="footer1"> </div></td>
  </tr>
</table>
</body>
</html>
