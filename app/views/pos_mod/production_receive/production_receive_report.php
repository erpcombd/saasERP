<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
require_once "../../../assets/support/inc.all.php";

$pr_no 		= $_REQUEST['v_no'];

$datas=find_all_field('production_receive_master','s','pr_no='.$pr_no);


$entry_sql = 'select u.fname from user_activity_management u, production_receive_master b where u.user_id=b.entry_by and b.pr_no='.$pr_no;

$entry_by = find_all_field_sql($entry_sql);


$sql1="select b.* from production_receive_master b where b.pr_no = '".$pr_no."'";
$data1=mysql_query($sql1);

$pr=0;
$total=0;
while($info=mysql_fetch_object($data1)){ 
$warehouse_to=$info->warehouse_to;
$warehouse_from=$info->warehouse_from;
$carried_by=$info->carried_by;
$pr_date=$info->pr_date;
}

$sql1="select b.*,i.unit_name from production_receive_detail b,item_info i where b.item_id=i.item_id and b.pr_no = '".$pr_no."'";
$data1=mysql_query($sql1);

$pr=0;
$total=0;
while($info=mysql_fetch_object($data1)){ 
$pr++;

$qc_by=$info->qc_by;

$item_id[] = $info->item_id;
$unit_name[] = $info->unit_name;
$total_unit[] = $info->total_unit;

$tot_total_unit += $info->total_unit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Production Line Receive Report :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style2 {font-size: 16px}
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
			  
			  
			<td>
				<table  width="60%" border="0" align="center" cellpadding="8" cellspacing="0">
                  <tr>
                    <td bgcolor="#00CC33" style="text-align:center; line-height:20px; color:#000;  font-weight:bold;"><span class="style4"><span class="style2">M. Ahmed Tea & Lands Co. Ltd</span><br />
                          <span class="style6" style="font-size:12px;">Head Office: Dargamohalla, Sylhet. Phone: +880-821-716552, 718815</span></span></td>
                  </tr>
                  
                </table>
			
			</td>
			  </tr>
			  
			  <tr>
			 
                <td>
				<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">Production Line Receive  Report</td>
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
		          <td width="40%" align="right" valign="middle">Receive From : </td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_from);?></td>
		              </tr>
		            </table></td>
		          </tr>
		        <tr>
		          <td align="right" valign="top"> Issue To:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_to);?></td>
                    </tr>
                  </table></td>
		        </tr>
		        
		        <tr>
		          <td align="right" valign="middle"> Carried By:</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $carried_by;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        </table>		      </td>
			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
                <td align="right" valign="middle"> Pr No:</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td>&nbsp;<strong><?php echo $pr_no;?></strong></td>
                    </tr>
                </table></td>
				<tr>
				<td align="right" valign="middle">Pr Date</td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td>&nbsp;
                        <?=date("d M, Y",strtotime($pr_date))?></td>
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
		
        <td align="center" bgcolor="#CCCCCC"><strong>Item Code</strong></td>
        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Rec Qty</strong></td>
        </tr>
       
<? for($i=0;$i<$pr;$i++){?>
      
      <tr>
        <td align="center" valign="top"><?=$i+1?></td>
		
        <td align="left" valign="top"><?=$item_id[$i]?></td>
        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
        <td align="right" valign="top"><?=$unit_name[$i]?></td>
        <td align="right" valign="top"><?=$total_unit[$i]?></td>
        </tr>
		
		<? }?>
      <tr>
        <td colspan="3" align="center" valign="top">&nbsp;</td>
        <td align="right" valign="top"><strong>Total</strong></td>
        <td align="right" valign="top"><strong><?=number_format($tot_total_unit,2)?></strong></td>
      </tr>

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
       <br>
       <br>
       
       
       <tr>
          <td align="center"><?php echo $entry_by->fname; ?>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        
        </tr>
       
       
        <tr>
          <td><div align="center"><hr width="80%"></hr>Received By </div></td>
          <td><div align="center"><hr width="80%"></hr>Quality Controller </div></td>
          <td><div align="center"><hr width="80%"></hr>Store Incharge </div></td>
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
