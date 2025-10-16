<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$address=find_a_field('project_info','proj_address',"1");

$sale_no 		= $_REQUEST['sale_no'];



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

$today_open[] = $info->today_open;

$today_issue[] = $info->today_issue;

$today_close[] = $info->today_close;

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

<table  style="width:80%; margin:0 auto; border:0; border-collapse:collapse; border-spacing:0; padding:0; text-align:center;">

  <tr>

    <td><div class="header">

	<table style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:0;">

	  <tr>

	    <td><table style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:0;">

          <tr>

            <td><table style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:0;">

              <tr>

                <td>

				<table  style="width:60%; border:0; margin:0 auto; border-collapse:collapse; text-align:center; padding:5px; border-spacing:0;">
				
				<tr>

        <td style="text-align:center; color:#000; font-size:20px; font-weight:bold; background-color:#CCCCCC;"> <strong style="font-size:22px"><?

if($_SESSION['user']['group']>1){

echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);}

else{

echo $_SESSION['proj_name'];}

				?><br /></strong> <!--<br /><strong><?=$address?></strong> --></td>

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

		    <td  style="vertical-align:top;">

		      <table  style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:3px; font-size:13px">

		        <tr>

		          <td style="width:40%; text-align:right; vertical-align:middle;">SE Name  : </td>

		          <td><table style="width:100%; border: 2px solid #000000; border-spacing:0; padding:10px;">

		            <tr>

		              <td><strong><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$se_id);?></strong></td>

		              </tr>

		            </table></td>

		          </tr>

		        <tr>

		          <td style="text-align:right; vertical-align:middle;"> Sale House:</td>

		          <td><table style="width:100%; border: 2px solid #000000; border-spacing:0; padding:10px;">

                    <tr>

                      <td><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);?></td>

                    </tr>

                  </table></td>

		        </tr>

		        

	

		        </table>		      </td>

			<td  style="width:30%; vertical-align:top;"><table  style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding: 3px; font-size:13px">

			  <tr>

                <td  style="text-align:right; vertical-align:middle;"> Sale No:</td>

			    <td><table style="width:100%; border:2px solid #000000; border-collapse:collapse; border-spacing:0; padding:3px;">

                    <tr>

                      <td>&nbsp;<strong><?php echo $sale_no;?></strong></td>

                    </tr>

                </table></td>

				<tr>

				<td  style="text-align:right; vertical-align:middle;">Sale Date : </td>

			    <td><table style="width:100%; border: 2px solid #000000; border-collapse:collapse; border-spacing:0; padding:3px;">

                    <tr>

                      <td>&nbsp;

                        <?=date("d M, Y",strtotime($sale_date))?></td>

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

<table class="tabledesign" style="width:100%; border:1px solid #000; border-collapse:separate; border-spacing:0;">
  <tr>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>SL</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Code</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Product Name</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Unit</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Rate</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Opening</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Issue</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Sale</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Closing</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Sale Amount</strong></td>
  </tr>

  <? for($i=0;$i<$pi;$i++){?>
  <tr>
    <td style="text-align:center; vertical-align:top; border:1px solid #000; padding:5px;"><?=$i+1?></td>
    <td style="text-align:center; vertical-align:top; border:1px solid #000; padding:5px;"><?=$finish_goods_code[$i]?></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
    <td style="text-align:center; vertical-align:top; border:1px solid #000; padding:5px;"><?=$unit_name[$i]?></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><?=$item_rate[$i]?></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><?=number_format($today_open[$i],2);?></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><?=number_format($today_issue[$i],2);?></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><?=number_format($today_sale[$i],2);?></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><?=number_format($today_close[$i],2);?></td>
    <td style="text-align:right; vertical-align:top; border:1px solid #000; padding:5px;"><?=number_format($today_sale_amt[$i],2);?></td>
  </tr>
  <? }?>

  <tr>
    <td colspan="9" style="text-align:center; vertical-align:top; border:1px solid #000; padding:5px;">
      <div style="text-align:right;"><strong>Total : </strong></div>
    </td>
    <td style="text-align:right; vertical-align:top; border:1px solid #000; padding:5px;">
      <span class="style1"><?=number_format($total_today_sale_amt,2);?></span>
    </td>
  </tr>
</table>

  
  </td>

  </tr>

  <tr>

    <td  style="text-align:left;">

    <table style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:0;">

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

    <td colspan="2"  style="text-align:center;"><strong><br />

      </strong>

      <table  style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:0;">

        <tr>
          <td><div  style="text-align:center;"><?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?>  <hr style="width:60%;" /></div></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>

          <td><div style="text-align:center;">Prepared By </div></td>

          <td><div style="text-align:center;">Sales Executive </div></td>

          <td><div style="text-align:center;">Incharge Person</div></td>
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

