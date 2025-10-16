<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$address=find_a_field('project_info','proj_address',"1");

$issue_no 		= $_REQUEST['v_no'];



$datas=find_all_field('black_tea_consumption','s','issue_no='.$issue_no);



$sql1="select b.* from black_tea_consumption b where b.issue_no = '".$issue_no."'";

$data1=db_query($sql1);



$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$blend_type=$info->blend_type;

$warehouse_id=$info->warehouse_id;

$carried_by=$info->carried_by;

$remarks=$info->remarks;

$issue_date=$info->issue_date;

$entry_by=$info->entry_by;
}



$sql1="select b.*,i.unit_name, i.finish_goods_code, g.garden_name from black_tea_consumption b, item_info i, tea_garden g where b.item_id=i.item_id and g.garden_id=b.garden_id and b.issue_no = '".$issue_no."'";

$data1=db_query($sql1);



$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$pi++;




$qc_by=$info->qc_by;

$item_id[] = $info->item_id;

$unit_name[] = $info->unit_name;

$finish_goods_code[] = $info->finish_goods_code;

$sale_no[] = $info->sale_no;

$lot_no[] = $info->lot_no;

$garden_name[] = $info->garden_name;

$invoice_no[] = $info->invoice_no;

$pkgs[] = $info->pkgs;

$sam_qty[] = $info->sam_qty;

$qty[] = $info->qty;

$rate[] = $info->rate;

$amount[] = $info->amount;


}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Daily Black Tea Transection Sheet :.</title>

<link href="../../../css_js/css/invoice.css" type="text/css" rel="stylesheet"/>

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
</head>

<body style="font-family:Tahoma, Geneva, sans-serif">

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

				<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
				
				<tr>

        <td bgcolor="#CCCCCC" style="text-align:center; color:#000; font-size:20px; font-weight:bold;"> <strong style="font-size:22px"><?

if($_SESSION['user']['group']>1)

echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);

else

echo $_SESSION['proj_name'];

				?><br /></strong> <!--<br /><strong><?=$address?></strong> --></td>

      </tr>

      <tr>

        <td bgcolor="#CCCCCC" style="text-align:center; color:#000; font-size:15px; font-weight:bold;">Daily  Black Tea Transection Sheet</td>

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

		          <td width="40%" align="right" valign="middle">Blend Type    : </td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><strong><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$blend_type);?></strong></td>

		              </tr>

		            </table></td>

		          </tr>

		        <tr>

		          <td align="right" valign="middle"> Warehouse :</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);?></td>

                    </tr>

                  </table></td>

		        </tr>

		        

		        <!--<tr>

		          <td align="right" valign="middle"> Carried By:</td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><?php echo $carried_by;?>&nbsp;</td>

		              </tr>

		            </table></td>

		          </tr>-->

		        </table>		      </td>

			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

			  <tr>

                <td align="right" valign="middle"> Tr No :</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td>&nbsp;<strong><?php echo $issue_no;?></strong></td>

                    </tr>

                </table></td>

				<tr>

				<td align="right" valign="middle">Tr  Date : </td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td>&nbsp;

                        <?=date("d M, Y",strtotime($issue_date))?></td>

                    </tr>

                </table></td>

			    </tr>

				<!--<tr>

				<td align="right" valign="middle">Note  : </td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td>&nbsp;<?php echo $remarks;?></td>

                    </tr>

                </table></td>

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

<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">

       <tr>

        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Sale No </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Lot No </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Garden</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Inv. No </strong></td>

        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Item Gread </strong></div></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Pkgs</strong></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Sam. Qty </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Issue Qty </strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Rate</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Amount</strong></td>
        </tr>

       

<? for($i=0;$i<$pi;$i++){?>

      

      <tr>

        <td align="center" valign="top"><?=$i+1?></td>

        <td align="center" valign="top"><?=$sale_no[$i]?></td>
        <td align="center" valign="top"><?=$lot_no[$i]?></td>
        <td align="center" valign="top"><?=$garden_name[$i]?></td>
        <td align="center" valign="top"><?=$invoice_no[$i]?></td>

        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>

        <td align="center" valign="top"><?=$pkgs[$i]; $tot_pkgs+=$pkgs[$i]?></td>

        <td align="left" valign="top"><?=number_format($sam_qty[$i],2);?></td>
        <td align="left" valign="top"><?=number_format($qty[$i],2); $tot_issue_qty +=$qty[$i];?></td>
        <td align="left" valign="top"><?=number_format($rate[$i],2);?></td>
        <td align="left" valign="top"><?=number_format($amount[$i],2); $tot_amount+=$amount[$i];?></td>
        </tr>
		
		<? }?>
      <tr>
        <td colspan="6" align="center" valign="top"><div align="right"><strong>Total</strong></div></td>
        <td align="center" valign="top"><span class="style1"><?=number_format($tot_pkgs,2)?></span></td>
        <td align="right" valign="top">&nbsp;</td>
        <td align="right" valign="top"><span class="style1">
          <?=number_format($tot_issue_qty,2)?>
        </span></td>
        <td align="right" valign="top">&nbsp;</td>
        <td align="right" valign="top"><span class="style1">
          <?=number_format($tot_amount,2)?>
        </span></td>
      </tr>
  </table></td>

  </tr>

  <tr>

    <td align="center">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="2" style="font-size:12px">&nbsp;</td>
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
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
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
          <td><div align="center"><?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?>  <hr style="width:60%;" /></div></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>

          <td><div align="center">Prepared By </div></td>

          <td><div align="center">Incharge Person</div></td>

          <td><div align="center">Assistant Manager</div></td>
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

