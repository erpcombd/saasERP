<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
require "../../support/inc.all.php";

$do_no 		= $_REQUEST['v_no'];
//$do_no = 27746;

$datas=find_all_field('sale_do_master','s','do_no='.$do_no);

$sql1="select b.* from 
sale_do_details b
where b.do_no = '".$do_no."'";
$data1=db_query($sql1);


$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$pi++;

$item_id[] = $info->item_id;
$dp_price[] = $info->unit_price;
$tp_price[] = $info->t_price;

$pkt_size[] = $info->pkt_size;
$pkt_unit[] = $info->pkt_unit;
$dist_unit[] = $info->dist_unit;
$total_unit[] = $info->total_unit;
}
$ssql = 'select a.*,b.do_date from dealer_info a, sale_do_master b where a.dealer_code=b.dealer_code and b.do_no='.$do_no;
$dealer = find_all_field_sql($ssql);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Challan Copy :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style4 {
	font-size: 18px;
	color: #000000;
}
.style6 {font-size: 10px}
.style8 {font-size: 16px; font-weight:bold}
-->
</style>
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
                <td width="15%">
                
                <td><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                  <tr>
                    <td bgcolor="#00CC33" style="text-align:center; color:#FFF; font-size:14px; font-weight:bold;"><span class="style4">Sajeeb Corporation<br />
                          <span class="style6">Shezan Point (5th Floor),2 Indira Road, Farmgate,Dhaka-1215</span></span></td>
                  </tr>
                  <tr>
                    <td><div align="center">
                      <? if($_SESSION['user']['depot']>0)
					  echo find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);?>
                      <br />
                      <strong>Delivery Order </strong></div></td>
                  </tr>
                </table>                
                <td width="25%">
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td valign="top">
		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
		        <tr>
		          <td width="40%" align="right" valign="middle">Dealer Name: </td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><span class="style8"><?php echo $dealer->dealer_name_e.'-'.$dealer->dealer_code.'('.$dealer->product_group.')';?>&nbsp;</span></td>
		              </tr>
		            </table></td>
		          </tr>
		        <tr>
		          <td align="right" valign="top"> Address:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td height="60" valign="top"><?php echo $dealer->address_e.' Mobile: '.$dealer->mobile_no;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        
		        <tr>
                  <td align="right" valign="middle">Buyer Name:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                      <tr>
                        <td><?php echo $dealer->propritor_name_e;?>&nbsp;</td>
                      </tr>
                  </table></td>
		          </tr>
		        </table>		      </td>
			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
			    <td align="right" valign="middle">DO No:</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><?php echo $do_no;?>&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
			  <tr>
                <td align="right" valign="middle">DO Date:</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><?php echo $dealer->do_date;?>&nbsp;</td>
                    </tr>
                </table></td>
			    </tr>
			  <tr>
                <td align="right" valign="middle">Received Amt :</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><?php echo $datas->received_amt;?>&nbsp;</td>
                    </tr>
                </table></td>
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
  
  <tr>
    <td>
      <div id="pr">
  <div align="left">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />
  </div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="2" style="font-size:11px">
       
       <tr>
         <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>Code</strong></td>
         <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>
         <td align="center" bgcolor="#CCCCCC"><strong>Crt</strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>Pcs</strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>DP</strong></td>
         <td align="center" bgcolor="#CCCCCC"><strong>TP</strong></td>
        </tr>
<? for($i=0;$i<$pi;$i++){$fgc = find_a_field('item_info','finish_goods_code','item_id='.$item_id[$i]);if($fgc!=2000){?>

      <tr style="font-size:16px;">
        <td align="center" valign="top"><?=++$kk?></td>
        <td align="left" valign="top"><?=$fgc;?></td>
        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
        <td align="right" valign="top"><?=$pkt_unit[$i];?></td>
        <td align="right" valign="top"><?=$dist_unit[$i];?></td>
        <td align="right" valign="top"><? echo number_format($dp_price[$i],2);?></td>
        <td align="right" valign="top"><? echo number_format($tp_price[$i],2);?></td>
        </tr>
<? 
$t_pkt = $t_pkt + $pkt_unit[$i];
$t_pcs = $t_pcs + $dist_unit[$i];

$t_tp = $t_tp + $tp_price[$i];
$t_dp = $t_dp + $dp_price[$i];
}}?>
      <tr style="font-size:16px;">
        <td colspan="3" align="right" valign="top"><strong>Total:</strong></td>
		        <td align="right" valign="top"><strong><?=$t_pkt?></strong></td>
        <td align="right" valign="top"><strong><?=$t_pcs?></strong></td>
        <td align="right" valign="top"><?=$t_dp?></td>
        <td align="right" valign="top"><?=$t_tp?></td>

      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" style="font-size:12px">Prepared By: <?=find_a_field('user_activity_management','fname','user_id='.$datas->entry_by);?>&nbsp;&nbsp;&nbsp;Prepared At: <?=$datas->entry_at?></td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong><br />
      </strong>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center">Authorized By </div>            <div align="center"></div></td>
          <td><div align="center"></div>            <div align="center">Prepared By </div></td>
          </tr>
      </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    </table>
    <div class="footer1"> </div>
    </td>
  </tr>
</table>
</body>
</html>
