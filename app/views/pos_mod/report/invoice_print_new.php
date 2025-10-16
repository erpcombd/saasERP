<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
require "../../common/check.php";
require "../../config/db_connect.php";
require "../../common/my.php";

$v_no 		= $_REQUEST['v_no'];
$no 		= $vtype."_no";
$in			= $_REQUEST['in'];

$datas=find_all_field('lc_workorder_chalan','s','id='.$v_no);

$sql1="select b.chalan_date,a.for,a.buyer_id,b.qty,c.qty,c.id,c.specification,c.meassurment,c.item_id,c.style_no,a.id from lc_workorder a,lc_workorder_chalan b,lc_workorder_details c where b.wo_id=a.id and b.specification_id=c.id and b.wo_id=".$datas->wo_id." and entry_at between '".($datas->entry_at-1200)."' and '".($datas->entry_at+1200)."'";
$data1=mysql_query($sql1);


$pi=0;
$total=0;
//echo $sql2;
while($info=mysql_fetch_row($data1)){ 
$pi++;
$ch_date=$info[0];
$for=$info[1];
$buyer=$info[2];

$sl[]=$pi;
$qty[]=$info[3];
$tqty[]=$info[4];

$amount[]=$info[3];
$total=$total+($info[3]);
$totalt=$totalt+($info[4]);
$item[]=$info[5];

$specification[]=$info[6];
$meassurment[]=$info[7];
$item_id[]=$info[8];
$style_no[]=$info[9];
$woid=$info[10];
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Cash Memo :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif">
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
				<div class="header_title"></div></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td valign="top" width="20%"><? $path='../../pic/logu.jpg';
			if(is_file($path)) echo '<img src="'.$path.'" height="80" />';?></td>
			<td width="50%" align="center" valign="top"><font face="Tahoma, Geneva, sans-serif" style="font-size:20px">
			  <strong>
			  <?
            if($for=='TT')
			echo 'TOTAL TRIMS';
			else
			echo 'NETRAKONA ACCESSORIES LTD.';
			?>
			  </strong></font><br /><font face="Tahoma, Geneva, sans-serif" style="font-size:12px">
			  Office: House# 502(1st Floor), Road# 9(East Side), DOHS Baridhara, Dhaka-1206, Tel: 88-02-8413370, 8413371	      </font><br /><br /><table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">DELIVERY CHALAN</td>
  </tr>
</table>
  </td>
			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
			    <td width="40%" align="right" valign="middle">Date : </td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><?php echo $ch_date;?>&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
			  <tr>
			    <td align="right" valign="middle"> WO No :</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><?php echo $woid;?>&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
			  <tr>
			    <td align="right" valign="middle">Chalan No :</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><?php echo $v_no;?>&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
                <tr>
			    <td align="right" valign="middle">Buyer Name :</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			      <tr>
			        <td><b><?=find_a_field('lc_buyer','buyer_name','id='.$buyer)?></b>&nbsp;</td>
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
    <td><br />
<div id="pr">
<div align="left">
<input name="button" type="button" onclick="hide();window.print();" value="Print" />
</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
       <tr>
        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Item</strong></div></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Style No</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Specification</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Meassurment</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>Order Qty.</strong></td>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>Delivery Qty.</strong></td>
        </tr>
<? for($i=0;$i<$pi;$i++){?>
      <tr>
        <td align="center" valign="top"><?=$sl[$i]?></td>
        <td align="left" valign="top"><?
        echo find_a_field('lc_product_item','item_name','id='.$item_id[$i]);?></td>
        <td align="right" valign="top"><?=$style_no[$i]?></td>
        <td align="right" valign="top"><?=$specification[$i]?></td>
        <td align="right" valign="top"><?=$meassurment[$i]?></td>
        
        <td align="right" valign="top"><?=$tqty[$i]?></td>
        <td align="right" valign="top"><?=$qty[$i]?></td>
        </tr>
<? }?>
      <tr>
        <td colspan="5" align="right">Total  :</td>
        <td align="right"><strong><?php echo number_format($totalt,0);?></strong></td>
        <td align="right"><strong><?php echo number_format($total,0);?></strong></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" style="font-size:12px"><em>All goods are received in a good condition as per L/C Terms</em></td>
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
    <td align="center"><div class="footer_left"><strong>--------------------------------<br />
          Receiver's Signature</strong></div></td>
    <td align="center"><strong>--------------------------------<br />For: <?
            if($for=='TT')
			echo 'TOTAL TRIMS';
			else
			echo 'NETRAKONA ACCESSORIES LTD.';
			?>
      </strong></td>
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
