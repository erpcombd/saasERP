<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$pr_no 		= $_REQUEST['v_no'];





$datas=find_all_field('purchase_receive','s','pr_no='.$pr_no);



$sql1="select b.*, g.garden_name, m.sale_no from purchase_receive b, tea_garden g, purchase_master m  where b.po_no=m.po_no and b.garden_id=g.garden_id and b.pr_no = '".$pr_no."'";

$data1=db_query($sql1);









$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$pi++;

$rec_date=$info->rec_date;

$rec_no=$info->rec_no;

$po_no=$info->po_no;

$order_no[]=$info->order_no;

$ch_no=$info->ch_no;

$qc_by=$info->qc_by;

$entry_at=$info->entry_at;

$entry_by=$info->entry_by;

$item_id[] = $info->item_id;

$rate[] = $info->rate;

$amount[] = $info->amount;

$sale_no = $info->sale_no;

$lot_no[] = $info->lot_no;
$garden_name[] = $info->garden_name;
$quality[] = $info->quality;
$invoice_no[] = $info->invoice_no;









$unit_qty[] = $info->qty;

$unit_name[] = $info->unit_name;

}

$ssql = 'select a.* from vendor a, purchase_master b where a.vendor_id=b.vendor_id and b.po_no='.$po_no;

$dealer = find_all_field_sql($ssql);





?>

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

<style type="text/css">

<!--

.style1 {font-weight: bold}

-->

</style>

<style type="text/css">

<!--



.style11 {

	font-size: 16px;

	font-weight: bold;

}

.style14 {font-weight: bold}

.style12 {

	font-size: 16px;

	font-weight: normal;

}

.style4 {	font-size: 18px;

	color: #000000;

}

.style6 {font-size: 10px}

.style15 {

	color: #FF0000;

	font-weight: bold;

}

.style16 {color: #336600}

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

                <td><? if($_SESSION['user']['depot']!=5){?><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">

                  <tr>

                    <td bgcolor="#FFFFCC" style="text-align:center; color:#000000; font-size:14px; font-weight:bold;"><span class="style4">M. Ahmed Tea & Lands Co. Ltd<br />

                          <span class="style6">Head Office: Dargamohalla, Sylhet. Phone: +880-821-716552, 718815</span></span></td>

                  </tr>

                  

                </table><? }else{?><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">

                  <tr>

                    <td bgcolor="#FFFFCC" style="text-align:center; color:#333333; font-size:14px; font-weight:bold;"><span class="style4">M. Ahmed Tea & Lands Co. Ltd<br />

                          <span class="style6">Head Office: Dargamohalla, Sylhet. Phone: +880-821-716552, 718815</span></span></td>

                  </tr>

                  

                </table><? }?></td>

              </tr>

              

              <tr>

                <td height="19">&nbsp;</td>

              </tr>

            </table></td>

          </tr>



        </table></td>

	    </tr>

	  

	  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td>

				<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">

      <tr>

        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">GOODS RECEIVE NOTE </td>

      </tr>

    </table>

    <? 

	

	if($datas->duplicate>0){?>

				<table width="40%" border="0" align="center" cellpadding="5" cellspacing="0">

                  <tr>

                    <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">DUPLICATE COPY </td>

                  </tr>

                </table>

    <? }else{

	db_execute('update purchase_receive set duplicate=1 where pr_no='.$pr_no);

	?>

                <table width="40%" border="0" align="center" cellpadding="5" cellspacing="0">

                  <tr>

                    <td bgcolor="#999999" style="text-align:center; color:#99FF66; font-size:18px; font-weight:bold;">ORIGINAL COPY </td>

                  </tr>

                </table>

    <? }?>

				</td>

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

		          <td width="40%" align="right" valign="middle">Party Company: </td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><?php echo $dealer->vendor_name;?>&nbsp;</td>

		              </tr>

		            </table></td>

		          </tr>

		        <tr>

		          <td align="right" valign="top"> Address:</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td height="60" valign="top"><?php echo $dealer->address;?>&nbsp;</td>

		              </tr>

		            </table></td>

		          </tr>

		        

		        <tr>

		          <td align="right" valign="middle">GR Posting Time  :</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td>By: <?php echo find_a_field('user_activity_management','fname','user_id='.$entry_by);?>/ At: <?php echo $entry_at;?></td>

                    </tr>

                  </table></td>

		          </tr>

		        <tr>

		          <td align="right" valign="middle">GR Rec No :</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><?php echo $rec_no;?></td>

		              </tr>

		            </table></td>

		          </tr>

		        </table>		      </td>

			<td width="30%"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

			
	
			  <tr>

                <td align="right" valign="middle">Sale No:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><strong><?php echo $sale_no;?></strong>&nbsp;</td>
                    </tr>

                </table></td>
			    </tr>
			  
			  
			  
			  <tr>

                <td align="right" valign="middle">GR No:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><strong><?php echo $pr_no;?></strong>&nbsp;</td>
                    </tr>

                </table></td>
			    </tr>

			  <tr>

                <td align="right" valign="middle"> REC Date</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?=$rec_date?>

                        &nbsp;</td>
                    </tr>

                </table></td>
			    </tr>

			  <tr>

			    <td align="right" valign="middle">PO No: </td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

			      <tr>

			        <td><?php echo $po_no;?></td>
			        </tr>

			      </table></td>
			    </tr>

			  <tr>

                <td align="right" valign="middle">QC By :</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?php echo $qc_by;?>&nbsp;</td>
                    </tr>

                </table></td>
			    </tr>

			  <tr>

                <td align="right" valign="middle">Chalan No  :</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><strong><?php echo $ch_no;?></strong></td>
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

        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>

        <td width="7%" align="center" bgcolor="#CCCCCC"><div align="center"><strong>Lot No </strong></div></td>
        <td width="19%" align="center" bgcolor="#CCCCCC"><div align="center"><strong>Gar. Name</strong></div> </td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><div align="center"><strong>Inv No</strong></div></td>
        <td width="9%" align="center" bgcolor="#CCCCCC"><div align="center"><strong>Item Grade </strong></div></td>



        <td width="9%" align="center" bgcolor="#CCCCCC"><strong>Liquor Marks</strong></td>
        <td width="6%" align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>

        <td width="8%" align="center" bgcolor="#CCCCCC"><strong>Rate</strong></td>

        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>Rec Qty</strong></td>

        <td width="15%" align="center" bgcolor="#CCCCCC"><strong>Amount</strong></td>
        </tr>

       

<? for($i=0;$i<$pi;$i++){?>

      

      <tr>

        <td align="center" valign="top"><?=$i+1?></td>

        <td align="left" valign="top"><?=$lot_no[$i]?></td>
        <td align="left" valign="top"><?=$garden_name[$i]?></td>
        <td align="left" valign="top"><?=$invoice_no[$i]?></td>
        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>

        <td align="right" valign="top"><?=$quality[$i]?></td>
        <td align="center" valign="top"><b>Kgs</b></td>

        <td align="right" valign="top"><?=number_format($rate[$i],2)?></td>

        <td align="right" valign="top"><?=$unit_qty[$i]?></td>

        <td align="right" valign="top"><?=number_format($amount[$i],2); $t_amount = $t_amount + $amount[$i];?></td>
        </tr>

<? }?>

  <td colspan="9" align="center" valign="top"><div align="right"><strong>Total Amount: </strong></div></td>

        <td align="right" valign="top"><span class="style1">

          <?=number_format($t_amount,2);?>

        </span></td>

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

          <td width="23%"><div align="center">Received By </div></td>

		  <td width="23%"><div align="center">Quality Controller </div></td>

          <td width="25%"><div align="center">Store Manager </div></td>

          <td width="29%"><div align="center">Authorized By </div></td>
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

