<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
require_once "../../../assets/support/inc.all.php";
require "../../../engine/tools/class.numbertoword.php";



$req_no 		= $_REQUEST['req_no'];

$sql="select * from requisition_fg_master where  req_no='$req_no'";
$data=mysql_query($sql);
$all=mysql_fetch_object($data);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Requsition Copy</title>
<link href="../../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
</head>
<body>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
				<div class="header_title">
				FG Transfer Requisition
				</div></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td valign="bottom"><div align="center">From <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_id);?> to 
			<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_to);?></div></td>
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
    <td><div class="line"></div></td>
  </tr>
  <tr>
    <td><div class="header2">
          <div class="header2_left">
        <p>Date: <?php echo $all->req_date;?><br />
          Requisition  No : <?php echo $all->req_no;?><br />
          Requisition For : <?php echo $all->req_for;?><br />
        </p>
      </div>
      <div class="header2_right">
        <p>
          Note : <?php echo $all->req_note;?><br />
          Need Before : <?php echo $all->need_by;?><br />
        </p>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="pr">
<div align="left">
<form action="" method="get">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
  </tr>
</table>

</form><br /><br />
</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="2%"><strong>SL.</strong></td>
        <td><strong>REQ-ID</strong></td>
        <td><strong>FG-Code</strong></td>
        <td><strong>Description of the Goods </strong></td>
        <td><strong>For</strong></td>
        <td><strong>Stock in pcs</strong></td>
        <td><strong>Req Ctn</strong></td>
        <td><strong>Req Pcs</strong></td>
        </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select * from requisition_fg_order where  req_no='$req_no'";
$data2=mysql_query($sql2);
//echo $sql2;
while($info=mysql_fetch_object($data2)){ 
$pi++;
$amount=$info->qty*$info->rate;
$total=$total+($info->qty*$info->rate);
$sl=$pi;
$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);
$qty=($info->qty%$item->pack_size);
$ctn=(int)(@($info->qty/$item->pack_size));
$qoh=$info->qoh;
$last_p_date=$info->last_p_date;
$last_p_qty=$info->last_p_qty;
?>
      <tr>
        <td valign="top"><?=$sl?></td>
        <td align="left" valign="top"><?=$info->id?></td>
        <td align="left" valign="top"><?=$item->finish_goods_code?>&nbsp;</td>
        <td align="left" valign="top"><?=$item->item_name?></td>
        <td align="left" valign="top"><?=$info->for;?></td>
        <td valign="top"><?=$qoh?></td>
        <td valign="top"><?=$ctn?></td>
        <td valign="top"><?=$qty?></td>
        </tr>
<? }?>
    </table></td>
  </tr>
  <tr>
    <td align="center">
	<div class="footer1">
	  <div style="float:left">
	  <p style="text-align:center">--------------------------<br />Authorized Person</p>
	  </div>
	</div>
	<div class="footer1">
      <p style="float:left; font-weight:bold;">Prepared By: <?=find_a_field('user_activity_management','username','user_id='.$all->entry_by)?></p>
	</div></td>
  </tr>
</table>
</body>
</html>
