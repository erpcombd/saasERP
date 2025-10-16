<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";
$chalan_no 		= $_REQUEST['tr_no'];


$datas=find_all_field('lc_workorder_chalan','s','chalan_no='.$v_no);


$sql1=" select i.*,d.*,b.*,b.entry_at,sum(d.total_unit) as total_unit from asset_transfer_master b,asset_transfer_details d,item_info i  where d.item_id=i.item_id and b.pi_no=d.pi_no and b.pi_no = '".$chalan_no."' group by d.item_id ";
$data1=db_query($sql1);

$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
$pi++;
$item_all = find_all_field('item_info','','item_id="'.$info->item_id.'"');
$item_desc[] = $item_all->item_description;
$entry_time=$info->entry_time;
$pi_date=$info->pi_date;
$item_brand[] = find_a_field('item_brand','brand_name','id="'.$item_all->item_brand.'"');
$item_model[] = find_a_field('item_model','model_name','id="'.$item_all->model.'"');
$dist_unit[] = $info->total_unit;
$total_unit[] = $info->total_unit;
$item_name[] = $info->item_name;
$serial[] = $info->serial_no;
$item_id[]=$info->item_id;
$unit[]=$info->unit_name;
}
$master = find_all_field('asset_transfer_master','','pi_no="'.$chalan_no.'"');

//if(isset($_POST['cash_discount']))
//{
//	$c_no = $_POST['c_no'];
//	$cash_discount = $_POST['cash_discount'];
//	$ssql='update sale_do_chalan set cash_discount="'.$_POST['cash_discount'].'" where chalan_no="'.$c_no.'"';
//	db_query($ssql);
//
//}

$company_info = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Asset Transfer :.</title>
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

                    <td  style="text-align:center;  font-size:14px; font-weight:bold;"><span class="style4"><br />

                          <span style="color:black;"><?=$company_info->address?></span></span><br /><br /></td>
                  </tr>

                  

                </table>
				<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" style="background:darkgray;">
      <tr>
        <td style="text-align:center; color:white; font-size:18px; font-weight:bold;"><span class="style1" >Asset Transfer<br /><?php echo find_a_field('warehouse','warehouse_name','warehouse_id="'.$master->warehouse_from.'"');?></span></td>
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
		          <td width="20%" align="left" valign="middle">Transfer No </td>
				  <td>:</td>
		          <td width="80%"><?php echo $chalan_no;?></td>
		        </tr>
				  <tr>
		          <td width="20%" align="left" valign="middle">Transfer From </td>
				  <td>:</td>
		          <td width="80%"><?php echo find_a_field('warehouse','warehouse_name','warehouse_id="'.$master->warehouse_from.'"');?></td>
		        </tr>
		         <tr>
                <td width="48%" align="right" valign="middle"> <div align="left">Prepard By</div></td>
				<td>:</td>
			    <td width="52%"><?=find_a_field('user_activity_management','fname','user_id="'.$master->entry_by.'"')?></td>
			  </tr>
		        
		        </table>		      </td>
			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
                <td width="48%" align="right" valign="middle"> <div align="left">Transfer Date</div></td>
				<td>:</td>
			    <td width="52%"><?=date('d-M-Y',strtotime($master->pi_date))?></td>
			  </tr>
			  
			 
			  <tr>
                <td width="48%" align="right" valign="middle"> <div align="left">Transfer For</div></td>
				<td>:</td>
			    <td width="52%"><? echo find_a_field('warehouse','warehouse_name','warehouse_id="'.$master->warehouse_to.'"')?></td>
			  </tr>
			  
			  <tr>
                <td width="48%" align="right" valign="middle"> <div align="left">Status</div></td>
				<td>:</td>
			    <td width="52%"><?=$master->status?></td>
			  </tr>
			  
			 <!--<tr>
		          <td align="left" valign="middle"><span class="style6">Entry Time:</span></td>
		          <td><span class="style6">
		            <?=date('Y-m-d H:i:s',strtotime($master->entry_time));?>
		          </span></td>
		        </tr>-->
			 
			  
			  <!--<tr>
			    <td align="right" valign="middle"><div align="left">Order Date: </div></td>
			    <td><?=$do->do_date?></td>
			    </tr>
			  <tr>
			    <td align="right" valign="middle"><div align="left">DO No:</div></td>
			    <td><?php echo $do_no;?></td>
			  </tr>
			  <tr>
			    <td align="right" valign="middle"><div align="left">Challan No:</div></td>
			    <td><?php echo $chalan_no;?></td>
			  </tr>
			  <tr>
                <td align="right" valign="middle"><div align="left">Bill No:</div></td>
			    <td><strong><?php echo $do->remarks;?></strong></td>
			    </tr>-->
			  
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
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="2" style="font-size:11px;">
       
       <tr>
         <td align="center" bgcolor="#FFFFFF"><strong>SL</strong></td>
         <td align="center" bgcolor="#FFFFFF"><strong>Product Description </strong></td>
		 <!--<td align="center" bgcolor="#FFFFFF"><strong>Serial Number </strong></td>-->
		 <td align="center" bgcolor="#FFFFFF"><strong>Unit Name </strong></td>
         <td align="center" bgcolor="#FFFFFF"><strong>Quantity</strong></td>
        </tr>
       
<? for($i=0;$i<$pi;$i++){ 

?>

      <tr style="line-height:30px;">
        <td align="center" valign="top"><?=$i+1?></td>
      
        <td align="left" valign="top"><? echo $item_name[$i].'<br>'; ?>
		<?
		  $gsql = 'select serial_no from asset_transfer_details where pi_no="'.$chalan_no.'" and item_id="'.$item_id[$i].'"';
		$gquery = db_query($gsql);
		 echo ' Serial : ';
		while($qdata=mysqli_fetch_object($gquery)){if($qdata->serial_no!='') echo ''.$qdata->serial_no.', '; } ?>
		
		</td>
		<!--<td align="center"><?=$serial[$i]?></td>-->
		<td align="center"><?=$unit[$i]?></td>
        <td align="right"><?=$dist_unit[$i]?></td>
        
        </tr>
<? $tot_qty = $tot_qty+$dist_unit[$i]; }?>
      
		
		
		
		
      
      <tr style="border-bottom:#FFFFFF">
        <td colspan="3" align="center" valign="top"><div align="right"><strong>Total  </strong></div></td>
       
        
        <td align="right" valign="top"><strong>
          <?=$tot_qty?>
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

        

        <td align="center" valign="bottom">&nbsp;</td>

  

        <td align="center" valign="bottom">&nbsp;</td>

      </tr>
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

        
        <td width="34%"><div align="left">Received By </div></td>

        <td width="33%"><div align="right">Authorize Signature </div></td>

      </tr>

    </table> </div>
    </td>
  </tr>
</table>
</body>
</html>
