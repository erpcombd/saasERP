<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$oi_no 		= $_REQUEST['v_no'];


$datas=find_all_field('warehouse_other_issue','s','oi_no='.$oi_no);
$group = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');
$sql111="select b.* from warehouse_other_issue b where b.oi_no = '".$oi_no."'";
$data111=db_query($sql111);

$data=mysqli_fetch_object($data111);
$rec_frm=$data->vendor_name;
$requisition_from=$data->requisition_from;
$oi_date=$data->oi_date;
$entry_by = find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');


$sql1="select b.* from warehouse_other_issue_detail b where b.oi_no = '".$oi_no."'";
$data1=db_query($sql1);

$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
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
<title>.: Local Sales :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
#pr input[type="button"] {
    width: 70px;
    height: 25px;
    background-color: #6cff36;
    color: #333;
    font-weight: bolder;
    border-radius: 5px;
    border: 1px solid #333;
    cursor: pointer;
}
</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif">

<div id="pr">
    <h2 align="center">	<input name="button" type="button" onclick="hide();window.print();" value="Print"/></h2>
</div>

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">


        <tr>
            <td><div class="header">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="20%">
                                                        <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style=" width:100%" />
                                                    <td width="60%"><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                                                            <tr>
                                                                <td style="text-align:center; color:#000; font-size:14px; font-weight:bold;">

                                                                    <h1 style="margin: 0px;"><?=$_SESSION['company_name']?></h1>
                                                                    <p style="font-size:14px; font-weight:300; color:#000000; margin:0; padding:0;"><?=$group->address?></p>
                                                                </td>
                                                            </tr>
                                                            <tr>


                                                                <!--<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">WORK ORDER </td>-->
                                                            </tr>
                                                        </table>
                                                    <td width="20%">

                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                            <tr>

                                                                <td align="center"></td>
                                                            </tr>


                                                            <tr>

                                                                <td><?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?></td>
                                                            </tr>

                                                            <tr>

                                                                <td><span style="font-size:14px; padding: 3px 0 0 10px; letter-spacing:7px;"><?=$chalan_no?></span></td>
                                                            </tr>
                                                        </table>						</td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>          </tr>
                    </table>
                </div></td>
        </tr>


        <tr> <td><hr /></td></tr>



        <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
				<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">DIRECT SALES </td>
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
		    <td width="50%">
		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
		        <tr>
		          <td width="40%" align="right" valign="middle"><strong>Customer Name:</strong> </td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
		            <tr>
		              <td><?php echo $rec_frm;?>&nbsp;</td>
		              </tr>
		            </table></td>
		          </tr>
		        
		        
		        
		        <tr>
                  <td align="right" valign="middle"><strong>Note   :</strong></td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                      <tr>
                        <td><?php echo $data->oi_subject;?></td>
                      </tr>
                  </table></td>
		          </tr>
		        </table>		      </td>
              <td width="20%">   </td>
			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  <tr>
                <td align="right" valign="middle"><strong>LS No:</strong></td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><strong><?php echo $oi_no;?></strong>&nbsp;</td>
                    </tr>
                </table></td>
			    </tr>
			  <tr>
                <td align="right" valign="middle"> <strong>LS Date:</strong></td>
			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                    <tr>
                      <td><?=date("d M, Y",strtotime($oi_date))?>
                        &nbsp;</td>
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
    
	<td><br></td>
  </tr>

  
  <tr>
    <td>


<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
       <tr bgcolor="#e4ffbe">
        <td align="center" ><strong>SL</strong></td>
        <td align="center" ><strong>Code</strong></td>
        <td align="center" ><div align="center"><strong>Product Name</strong></div></td>
        <td align="center" ><strong>Unit</strong></td>
        <td align="center" ><strong>Rate</strong></td>
        <td align="center" ><strong>Rec Qty</strong></td>
        <td align="center" ><strong>Amount</strong></td>
        </tr>
       
<? for($i=0;$i<$pi;$i++){?>
      
      <tr>
        <td align="center" valign="top"><?=$i+1?></td>
        <td align="left" valign="top"><?=$item_id[$i]?></td>
        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
        <td align="right" valign="top"><?=$unit_name[$i]?></td>
        <td align="right" valign="top"><?=$rate[$i]?></td>
        <td align="right" valign="top"><?=$unit_qty[$i]?></td>
        <td align="right" valign="top"><?=$amount[$i]; $t_amount = $t_amount + $amount[$i];?></td>
        </tr>
<? }?>
    <tr bgcolor="#fcffb5">
  <td colspan="6" align="center" valign="top"><div align="right"><strong>Total Amount: </strong></div></td>
        <td align="right" valign="top"><span class="style1">
          <?=$t_amount?>
        </span></td>
    </tr>
    </table>
    </td>
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
          <td><div align="center"><?=$entry_by?></div></td>
          <td><div align="center"></div></td>
          <td><div align="center"></div></td>
          </tr>
		  <tr>
          <td><div align="center">___________________</div></td>
          <td><div align="center">___________________</div></td>
          <td><div align="center">___________________</div></td>
          </tr>
		  <tr>
          <td><div align="center">Prepared By </div></td>
          <td><div align="center">Reviewd By </div></td>
          <td><div align="center">Approved By</div></td>
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
