<?php
session_start();
//====================== EOF ===================


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$req_no 		= $_REQUEST['req_no'];


if($_GET['update']=='Update')
{
	$req_status = $_GET['req_status'];
	$ssql='update requisition_master set status="'.$_GET['req_status'].'" where req_no="'.$req_no.'"';
	db_query($ssql);
}

$sql="select * from requisition_master where  req_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Material Requisition :.</title>
<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
</head>
<body>
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
				<div class="header_title">
				Purchase Requisition
				</div></td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td align="center" valign="bottom"><strong>
<span style="font-size:15px;"><?=find_a_field('user_group','group_name','id="'.$_SESSION['user']['group'].'"')?></span>
<br />
		      <?=find_a_field('user_group','address','id="'.$_SESSION['user']['group'].'"')?>
		    </strong></td>
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
        <p>Approved Date: <?php echo date('Y-m-d',strtotime($all->entry_at));?><br />
          Requisition  No : <?php echo $all->req_no;?><br />
          <!--Requisition For : <?php echo $all->req_for;?>--><br />
        </p>
      </div>
      <div class="header2_right">
        <p>
          Note : <?php echo $all->req_note;?><br />
          Need Before : <?php echo $all->need_by;?><br />
          Present Status : <?php echo $all->status;?><br />
        </p>
      </div>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div id="pr">
<div align="left">

</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="3%"><strong>SL.</strong></td>
        <td><strong>Description of the Goods </strong></td>
       
     
        <td><strong>Unit</strong></td>
        <td><strong>Requested QTY</strong></td>
       </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select * from requisition_order where  req_no='$req_no'";
$data2=db_query($sql2);

while($info=mysqli_fetch_object($data2)){ 
$pi++;
$amount=$info->qty*$info->rate;
$total=$total+($info->qty*$info->rate);
$sl=$pi;
$item=find_all_field('item_info','','item_id='.$info->item_id);
$qty=$info->qty;
$stock = find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$info->item_id.'" and warehouse_id="'.$_SESSION['warehouse_id'].'"');
$qoh=$info->qoh;
$last_p_date=$info->last_p_date;
$last_p_qty=$info->last_p_qty;
?>
      <tr>
        <td valign="top"><?=$sl?></td>
        <td align="left" valign="top"><?=$item->item_name.' : '.$item->item_description?></td>
        
     
        <td align="right" valign="top"><?=$item->unit_name?></td>
        <td align="right" valign="top"><?=$qty?></td>
      </tr>
<? }?>
    </table></td>
  </tr>
  <tr>
    <td align="center">
	<div class="footer1">
	  <div style="float:left">
	  <p style="text-align:center"><br />--------------------------<br />Authorized Person</p>
	  </div>
      <div style="float:right">
	  
	  </div>
	</div>
	<div class="footer1">
      <p style="float:left; font-weight:bold;">Prepared By: <?=find_a_field('user_activity_management','fname','user_id='.$all->edit_by);?><br /><?php echo date('Y-m-d',strtotime($all->edit_at));?></p>
	</div></td>
  </tr>
</table>
</body>
</html>
