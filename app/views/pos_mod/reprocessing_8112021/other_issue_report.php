<?php
require_once "../../../assets/template/layout.top.php";

$oi_no 		= $_REQUEST['v_no'];


$datas=find_all_field('warehouse_other_issue','s','oi_no='.$oi_no);

$sql1="select b.* from warehouse_other_issue b where b.oi_no = '".$oi_no."'";
$data1=mysql_query($sql1);

$pi=0;
$total=0;
while($info=mysql_fetch_object($data1)){ 
$issued_to=$info->issued_to;
$oi_details=$info->oi_details;
$oi_subject=$info->oi_subject;
$entry_by=$info->entry_by;
$entry_at=$info->entry_at;
$issue_type=$info->issue_type;
$oi_date=$info->oi_date;
$requisition_from=$info->requisition_from;
$approved_by=$info->approved_by;
}

$sql1="select b.* from warehouse_other_issue_detail b where b.oi_no = '".$oi_no."'";
$data1=mysql_query($sql1);

$pi=0;
$total=0;
while($info=mysql_fetch_object($data1)){ 
$pi++;

$order_no[]=$info->order_no;
$qc_by=$info->qc_by;

$item_id[] = $info->item_id;
$rate[] = $info->rate;
$amount[] = $info->amount;




$unit_qty[] = $info->qty;
$unit_name[] = $info->unit_name;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Other Issue Report :.</title>
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
                <td>
				<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">REPROCESS ISSUE Report</td>
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
		    <td valign="top">
		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
		        <tr>
		          <td width="40%" align="right" valign="middle">Issue To  : </td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><strong><?php echo find_a_field('user_group','group_name','id='.$issued_to);?></strong>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        
		        <tr>
                  <td align="right" valign="middle">Note :</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                      <tr>
                        <td><?php echo $oi_subject;?></td>
                      </tr>
                  </table></td>
		          </tr>
				
				
		        <tr>
		          <td align="right" valign="middle">  Entry By :</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>
		              </tr>
		            </table></td>
		          </tr>
				  
				  
				  <tr>
		          <td align="right" valign="middle">Approved By :</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td width="45%"><?php echo $approved_by;?></td>
		              <td width="55%"> Time: <?php echo $entry_at;?></td>
		              </tr>
		            </table></td>
		          </tr>
		        </table></td>
			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
                <td width="47%" align="right" valign="middle">Issue No :</td>
			    <td width="53%"><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td>&nbsp;<strong><?php echo $oi_no;?></strong></td>
                    </tr>
                </table></td>
				<tr>
				<td align="right" valign="middle">Issue Date : </td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td>&nbsp; <?=date("d M, Y",strtotime($oi_date))?></td>
                    </tr>
                </table></td>
			    </tr>
				<tr>
				<td align="right" valign="middle">Store Serial No :</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td>&nbsp;<?php echo $requisition_from;?></td>
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
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
       <tr>
        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Code</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>FG</strong></td>
        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Qty</strong></td>
        </tr>
       
<? for($i=0;$i<$pi;$i++){?>
<? $item = find_all_field('item_info','item_name','item_id='.$item_id[$i]);?>
      <tr>
        <td align="center" valign="top"><?=$i+1?></td>
        <td align="left" valign="top"><?=$item_id[$i]?></td>
        <td align="left" valign="top"><?=$item->finish_goods_code?></td>
        <td align="left" valign="top"><?=$item->item_name?></td>
        <td align="right" valign="top"><?=$unit_name[$i]?></td>
        <td align="right" valign="top"><?=$unit_qty[$i]?></td>
        </tr>
<? }?>
  </table></td>
  </tr>
  <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" style="font-size:12px"><em>All goods are received in a good condition as per Terms</em></td>
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
          <td><div align="center">Received By </div></td>
          <td><div align="center">
            <p>Prepared By</p>
          </div></td>
          <td><div align="center">Store Incharge </div></td>
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
