<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$pi_no 		= $_REQUEST['v_no'];



$datas=find_all_field('production_issue_master','s','pi_no='.$pi_no);



$sql1="select b.* from production_issue_master b where b.pi_no = '".$pi_no."'";

$data1=db_query($sql1);



$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$warehouse_to=$info->warehouse_to;

$warehouse_from=$info->warehouse_from;

$carried_by=$info->carried_by;

$remarks=$info->remarks;

$pi_date=$info->pi_date;

$entry_by=$info->entry_by;
}



$sql1="select b.*,i.unit_name, i.finish_goods_code from production_issue_detail b,item_info i where b.item_id=i.item_id and b.pi_no = '".$pi_no."'";

$data1=db_query($sql1);



$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$pi++;




$qc_by=$info->qc_by;

$item_id[] = $info->item_id;

$unit_name[] = $info->unit_name;

$finish_goods_code[] = $info->finish_goods_code;

$total_unit[] = $info->total_unit;

$unit_price[] = $info->unit_price;

$total_amt[] = $info->total_amt;

$grand_total_amt +=$info->total_amt;

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Daily Sales Sheet :.</title>

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
</head>

<body style="font-family:Tahoma, Geneva, sans-serif">

<table  style="width:80%; margin:0 auto; border:0; border-collapse:collapse; border-spacing:0; padding:0; text-align:center;">

  <tr>

    <td><div class="header">

	<table  style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:0;">

	  <tr>

	    <td><table style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:0;" >

          <tr>

            <td><table style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:0;">

              <tr>

                <td>

				<table  style="width:60%; margin:0 auto; border:0; text-align:center; border-collapse:collapse; border-spacing:0; padding:5px;">
				
				<tr>

        <td  style="text-align:center; color:#000; font-size:20px; font-weight:bold; background-color:#CCCCCC;"> Sylhet Trading Agencies </td>

      </tr>

      <tr>

        <td  style="text-align:center; color:#000; font-size:15px; font-weight:bold; background-color:#CCCCCC;">Daily  Sales Sheet</td>

      </tr>

    </table></td>

              </tr>

            </table></td>

          </tr>



        </table></td>

	    </tr>

	  <tr>

	    <td><table  style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:0;">

		  <tr>

		    <td style="vertical-align:top">

		      <table  style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:3px; font-size:13px">

		        <tr>

		          <td style="width:40%; text-align:right; vertical-align:middle;">SE Name  : </td>

		          <td><table  style="width:100%; border:2px solid #000000; boder-collapse:collapse; border-spacing:0; padding:10px;">

		            <tr>

		              <td><strong><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_to);?></strong></td>

		              </tr>

		            </table></td>

		          </tr>

		        <tr>

		          <td style="text-align:right; vertical-align:middle;"> Sale House:</td>

		          <td><table style="width:100%; border:2px solid #000000; boder-collapse:collapse; border-spacing:0; padding:10px;">

                    <tr>

                      <td><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_from);?></td>

                    </tr>

                  </table></td>

		        </tr>

		        

		        <tr>

		          <td  style="text-align:right; vertical-align:middle;"> Carried By:</td>

		          <td><table style="width:100%; border:2px solid #000000; boder-collapse:collapse; border-spacing:0; padding:3px;">

		            <tr>

		              <td><?php echo $carried_by;?>&nbsp;</td>

		              </tr>

		            </table></td>

		          </tr>

		        </table>		      </td>

			<td width="30%" valign="top"><table  style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:3px; font-size:13px">

			  <tr>

                <td style="text-align:right; vertical-align:middle;"> Sale No:</td>

			    <td><table style="width:100%; border:2px solid #000000; boder-collapse:collapse; border-spacing:0; padding:3px;">

                    <tr>

                      <td>&nbsp;<strong><?php echo $pi_no;?></strong></td>

                    </tr>

                </table></td>

				<tr>

				<td  style="vertical-align:middle; text-align:right;">Sale Date : </td>

			    <td><table style="width:100%; border:2px solid #000000; boder-collapse:collapse; border-spacing:0; padding:3px;">

                    <tr>

                      <td>&nbsp;

                        <?=date("d M, Y",strtotime($pi_date))?></td>

                    </tr>

                </table></td>

			    </tr>

				<tr>

				<td  style="text-align:right; vertical-align:middle;">Note  : </td>

			    <td><table style="width:100%; border:2px solid #000000; boder-collapse:collapse; border-spacing:0; padding:3px;">

                    <tr>

                      <td>&nbsp;<?php echo $remarks;?></td>

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

  <div style="text-align:left;">

<input name="button" type="button" onclick="hide();window.print();" value="Print" />

  </div>

</div>

<table class="tabledesign"  style="width:100%; border:2px solid #000000; boder-collapse:collapse; border-spacing:1px; padding:5px;">

       <tr>

        <td style="text-align:center; background-color:#CCCCCC;"><strong>SL</strong></td>

        <td style="text-align:center; background-color:#CCCCCC;"><strong>Code</strong></td>

        <td style="text-align:center; background-color:#CCCCCC;"><div style="text-align:center; "><strong>Product Name</strong></div></td>

        <td style="text-align:center; background-color:#CCCCCC;"><strong>Unit</strong></td>

        <td style="text-align:center; background-color:#CCCCCC;"><strong>Rate</strong></td>
        <td style="text-align:center; background-color:#CCCCCC;"><strong>Quantity</strong></td>
        <td style="text-align:center; background-color:#CCCCCC;"><strong>Sale Amount</strong> </td>
        </tr>

       

<? for($i=0;$i<$pi;$i++){?>

      

      <tr>

        <td style="text-align:center; vertical-align:top;"><?=$i+1?></td>

        <td style="text-align:center; vertical-align:top;"><?=$finish_goods_code[$i]?></td>

        <td style="text-align:left; vertical-align:top;"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>

        <td style="text-align:center; vertical-align:top;"><?=$unit_name[$i]?></td>

        <td style="text-align:left; vertical-align:top;"><?=$unit_price[$i]?></td>
        <td style="text-align:left; vertical-align:top;"><?=number_format($total_unit[$i],2);?></td>
        <td style="text-align:right;  vertical-align:top;"><?=number_format($total_amt[$i],2);?></td>
        </tr>
		
		<? }?>
      <tr>
        <td colspan="6" style="text-align:center; vertical-align:top;"><div style="text-align:right; "><strong>Total : </strong></div></td>
        <td style="text-align:right; vertical-align:top;"><span class="style1">
          <?=number_format($grand_total_amt,2);?>
        </span></td>
      </tr>


  </table></td>

  </tr>

  <tr>

    <td style="text-align:left;">

    <table  style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:0;">

  <tr>

    <td colspan="2" style="font-size:12px"><em>All goods are received in a good condition as per Terms</em></td>

    </tr>

  <tr>

    <td style="width:50%;">&nbsp;</td>

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

    <td colspan="2" style="text-align:center;"><strong><br />

      </strong>

      <table style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:0;">

        <tr>
          <td><div  style="text-align:center;"><?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?>  <hr style="width:60%;" /></div></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>

          <td><div style="text-align:center; ">Prepared By </div></td>

          <td><div style="text-align:center; ">Sales Executive </div></td>

          <td><div style="text-align:center; ">Incharge Person</div></td>
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

