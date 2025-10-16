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




$sql1="select b.*, w.warehouse_name, u.fname from blend_sheet_master b, warehouse w, user_activity_management u  where  b.line_id=w.warehouse_id and b.entry_by =u.user_id and  b.budg_id=".$oi_no;
$data1=mysql_query($sql1);



$pi=0;

$total=0;

while($info=mysql_fetch_object($data1)){ 

$entry_date=$info->budg_date;

$warehouse_id=$info->warehouse_name;

$location=$info->location;

$supervisor_id=$info->fname;

$blend_no=$info->budg_id;


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
                        <td width="40%"  align="right" valign="middle">Supervisor Name:</td>
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
                                <?=$blend_no?></td>
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
<? $mjr_sql="select m.* from  blend_sheet_section m where  m.budj_id=".$oi_no;

$mjr_data=mysql_query($mjr_sql);

$pi=0;

$total=0;

while($mjr_info=mysql_fetch_object($mjr_data)){ 

$pi++;?>
	   
	    <tr align="left" bgcolor="#CCCCCC">
          <td colspan="14"><strong>Section No : <?= $mjr_info->mjr_task_name?> </strong></td>
        </tr>
		
        <tr bgcolor="#FFFFFF">
		<td width="4%" align="center"><strong>SL</strong></td>
          <td width="7%" align="center"><strong>Sale No</strong></td>
          <td width="5%" align="center"><strong>Lot No </strong></td>
          <td width="16%" align="center"><strong>Garden Name</strong></td>
          <td width="9%" align="center"><strong>Invoice</strong></td>
          <td width="12%" align="center"><strong>Item Gread </strong></td>
          <td width="7%" align="center"><strong>Pkgs</strong></td>
          <td width="9%" align="center"><strong>Sample</strong></td>
          <td width="7%" align="center"><strong>Sam Qty</strong></td>
          <td width="8%" align="center"><strong>Total Kgs </strong></td>
          <td colspan="2" align="center"><strong>Rate</strong></td>
          <td width="5%" align="center"><strong>Amount</strong></td>
          <td width="5%" align="center"><strong>Remarks</strong></td>
        </tr>
<? $tsk_sql='SELECT b.id, b.sale_no, b.lot_no, g.garden_name, b.invoice_no, i.item_name, b.pkgs, b.sam_pay, b.sam_qty, b.qty, b.rate, b.amount from blend_sheet_details b, item_info i, tea_garden g where g.garden_id=b.garden_id and i.item_id=b.item_id  and b.major_task_id='.$mjr_info->mjr_task_name.' and b.budget_m_id='.$mjr_info->budj_id;
//echo $tsk_sql;
$tsk_data=mysql_query($tsk_sql);

$pi=0;

$total=0;

while($tsk_info=mysql_fetch_object($tsk_data)){ 
$t_task_qty+=$tsk_info->task_qty;
$t_task_vlm+=$tsk_info->total_volume;

$t_task_qty_f+=$tsk_info->task_qty;
$t_task_vlm_f+=$tsk_info->total_volume;

$t_amount+=($tsk_info->total_volume*$tsk_info->lab_rate);
$t_amount_f+=($tsk_info->total_volume*$tsk_info->lab_rate);
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
		  <td align="right" valign="top"><? num_convt($tsk_info->amount)?></td>
          <td align="right" valign="top">&nbsp;</td>
        </tr>
        
        
		<? } ?>
	<tr>
          <td colspan="6" align="right" valign="top"><strong>Sub Total </strong></td>
          <td align="right" valign="top">&nbsp;</td>
          <td align="right" valign="top">&nbsp;</td>
          <td align="right" valign="top">&nbsp;</td>
          <td align="right" valign="top">&nbsp;</td>
          <td colspan="2" align="right" valign="top">&nbsp;</td>
          <td align="right" valign="top">&nbsp;</td>
          <td align="right" valign="top">&nbsp;</td>
        </tr>	
<? } ?>
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
          <td align="center">&nbsp;</td>
          <td colspan="2" align="center"><?php echo $prepare_by;?></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">Received By </td>
          <td colspan="2" align="center">Prepared By</td>
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
