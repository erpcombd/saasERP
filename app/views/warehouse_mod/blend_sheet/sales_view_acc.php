<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$address=find_a_field('project_info','proj_address',"1");

$sale_no 		= $_REQUEST['v_no'];



$datas=find_all_field('item_sale_issue','s','sale_no='.$sale_no);



$sql1="select b.* from item_sale_issue b where b.sale_no = '".$sale_no."'";

$data1=db_query($sql1);



$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$se_id=$info->se_id;

$warehouse_id=$info->warehouse_id;

$carried_by=$info->carried_by;

$remarks=$info->remarks;

$sale_date=$info->sale_date;

$entry_by=$info->entry_by;
}



$sql1="select b.*,i.unit_name, i.finish_goods_code from item_sale_issue b,item_info i where b.item_id=i.item_id and b.sale_no = '".$sale_no."'";

$data1=db_query($sql1);



$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$pi++;




$qc_by=$info->qc_by;

$item_id[] = $info->item_id;

$unit_name[] = $info->unit_name;

$finish_goods_code[] = $info->finish_goods_code;

$today_sale[] = $info->today_sale;

$total_unit[] = $info->total_unit;

$item_rate[] = $info->item_rate;

$today_sale_amt[] = $info->today_sale_amt;

$total_today_sale_amt +=$info->today_sale_amt;

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

        <td bgcolor="#CCCCCC" style="text-align:center; color:#000; font-size:20px; font-weight:bold;"> <strong style="font-size:22px"><?

if($_SESSION['user']['group']>1){
echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);
}

else{
echo $_SESSION['proj_name'];
}

				?><br /></strong> <!--<br /><strong><?=$address?></strong> --></td>

      </tr>

      <tr>

        <td bgcolor="#CCCCCC" style="text-align:center; color:#000; font-size:15px; font-weight:bold;">Daily  Sales Sheet</td>

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

		          <td width="40%" align="right" valign="middle">SE Name  : </td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

		            <tr>

		              <td><strong><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$se_id);?></strong></td>

		              </tr>

		            </table></td>

		          </tr>

		        <tr>

		          <td align="right" valign="middle"> Sale House:</td>

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

                <td align="right" valign="middle"> Sale No:</td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td>&nbsp;<strong><?php echo $sale_no;?></strong></td>

                    </tr>

                </table></td>

				<tr>

				<td align="right" valign="middle">Sale Date : </td>

			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">

                    <tr>

                      <td>&nbsp;

                        <?=date("d M, Y",strtotime($sale_date))?></td>

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

        <td align="center" bgcolor="#CCCCCC"><strong>Code</strong></td>

        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>

        <td align="center" bgcolor="#CCCCCC"><strong>Rate</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Quantity</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Sale Amount</strong> </td>
        </tr>

       

<? for($i=0;$i<$pi;$i++){?>

      

      <tr>

        <td align="center" valign="top"><?=$i+1?></td>

        <td align="center" valign="top"><?=$finish_goods_code[$i]?></td>

        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>

        <td align="center" valign="top"><?=$unit_name[$i]?></td>

        <td align="left" valign="top"><?=$item_rate[$i]?></td>
        <td align="left" valign="top"><?=number_format($today_sale[$i],2);?></td>
        <td align="right" valign="top"><?=number_format($today_sale_amt[$i],2);?></td>
        </tr>
		
		<? }?>
      <tr>
        <td colspan="6" align="center" valign="top"><div align="right"><strong>Total : </strong></div></td>
        <td align="right" valign="top"><span class="style1">
          <?=number_format($total_today_sale_amt,2);?>
        </span></td>
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

        <tr>
          <td><div align="center"><?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?>  <hr style="width:60%;" /></div></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>

          <td><div align="center">Prepared By </div></td>

          <td><div align="center">Sales Executive </div></td>

          <td><div align="center">Incharge Person</div></td>
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

