<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$address=find_a_field('project_info','proj_address',"1");

$sale_no 		= $_REQUEST['v_no'];

$j_date = $_REQUEST['p_date'];

if($j_date!=""){

$ji_date_con.=" and b.ji_date=".$j_date;
}



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


 $sql2="select b.item_id, i.item_name, sum(b.item_in-b.item_ex) as fg_stock, i.unit_name, i.finish_goods_code from journal_item b,item_info i, item_sub_group s, warehouse w where i.sub_group_id=s.sub_group_id and  w.warehouse_id=b.warehouse_id and b.item_id=i.item_id and b.warehouse_id='5' and i.sub_group_id='1096000900010000' and b.ji_date BETWEEN '2010-12-31' and '".$sale_date."' group by b.item_id";
"'";

$data1=db_query($sql1);

$data2=db_query($sql2);



$pi=0;

$total=0;


while($info2=mysqli_fetch_object($data2)){ 

$fi++;

$fg_code[] = $info2->finish_goods_code;

$item_id_fg[] = $info2->item_id;

$item_name[] = $info2->item_name;

$unit_name_fg[] = $info2->unit_name;

$fg_stock[] = $info2->fg_stock;

$tot_fg_stock += $info2->fg_stock;
}



while($info=mysqli_fetch_object($data1)){ 

$pi++;


$qc_by=$info->qc_by;

$item_id[] = $info->item_id;

$unit_name[] = $info->unit_name;

$finish_goods_code[] = $info->finish_goods_code;

$today_open[] = $info->today_open;

$tot_today_open +=$info->today_open;

$today_receive[] = $info->today_receive;

$tot_today_receive += $info->today_receive;

$today_issue[] = $info->today_issue;

$tot_today_issue += $info->today_issue;

$today_close[] = $info->today_close;

$tot_today_close += $info->today_close;

$total_unit[] = $info->total_unit;

$item_rate[] = $info->item_rate;

$today_sale_amt[] = $info->today_sale_amt;

$total_today_sale_amt +=$info->today_sale_amt;
$sale_date = $info->sale_date;
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>.: Daily Stock Position Report :.</title>

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
.style2 {font-weight: bold}
-->
</style>
</head>

<body style="font-family:Tahoma, Geneva, sans-serif">

<table style="width:80%; margin:0 auto; border-collapse:collapse; border:0; padding:0;" >

  <tr>

    <td><div class="header">

	<table style="width:100%; border-collapse:collapse; border:0; padding:0;">

	  <tr>

	    <td><table style="width:100%; border-collapse:collapse; border:0; padding:0;">

          <tr>

            <td><table style="width:100%; border-collapse:collapse; border:0; padding:0;">

              <tr>

                <td>

				<table style="width:60%; margin:0 auto; border:0; border-collapse:collapse;">
				
				<tr>

        <td style="text-align:center; background-color:#CCCCCC; color:#000; font-size:20px; font-weight:bold;"> <strong style="font-size:22px"><?

if($_SESSION['user']['group']>1){

echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);}

else{

echo $_SESSION['proj_name'];}

				?>. Pkg. Div.<br /></strong> <!--<br /><strong><?=$address?></strong> --></td>
      </tr>

      <tr>

        <td  style="text-align:center;background-color:#CCCCCC; color:#000; font-size:15px; font-weight:bold;">Khan Tea Estate, Chiknagool, Sylhet </td>
      </tr>
      
      <tr>

        <td  style="text-align:center;background-color:#CCCCCC; color:#000; font-size:16px; font-weight:bold;">Daily Stock Report </td>
      </tr>
      
    </table></td>
              </tr>

            </table></td>
          </tr>



        </table></td>
	    </tr>

	  <tr>

	    <td><table style="width:100%; border-collapse:collapse; border:0; padding:0;">

		  <tr>

		    <td  style="vertical-align:top;">&nbsp;</td>

			<td  style="width:30%;vertical-align:top;">
			    <table style="width:100%; border-collapse:collapse; border:0; font-size:13px;">

			  <tr>
				<tr>

				<td  style="text-align:right; vertical-align:middle;">  Date : </td>

			    <td><table style="width:100%; border:1px solid #000; border-collapse:collapse;">

                    <tr>

                      <td>&nbsp;

                        <span class="style2">
                        <?=date("d M, Y",strtotime($sale_date))?>
                        </span></td>
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
    <td>	</td>
  </tr>
  <tr>
    <td>To<br />
	The Managing Director<br />
	M. Ahmed Tea &amp; Lands Co. Ltd. Pkg. Div. <br />
	Dargamohalla, Sylhet.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Dear Sir <br />
    Givens Below are the Particulars of present stock & necessary others on &nbsp;<b><?=date("d M, Y",strtotime($sale_date))?></b>&nbsp; for your kind information.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>

    <td>

      <div id="pr">

  <div  style="text-align:left;">

<input name="button" type="button" onclick="hide();window.print();" value="Print" />
  </div>
</div>

<table class="tabledesign" style="width:100%; border:1px solid #000; border-collapse:separate; border-spacing:0;">
  <tr>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>SL</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Black Tea</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Stock</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Unit</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>SL</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Packet Tea</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Stock</strong></td>
    <td style="text-align:center; background-color:#CCCCCC; border:1px solid #000; padding:5px;"><strong>Unit</strong></td>
  </tr>

  <? for($i=0;$i<$pi;$i++){?>
  <tr>
    <td style="text-align:center; vertical-align:top; border:1px solid #000; padding:5px;"><?=$i+1?></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><?=number_format($today_close[$i],2);?></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><?=$unit_name[$i]?></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><?=$i+1?></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><?=$item_name[$i]?></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><?=number_format($fg_stock[$i],2);?></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><?=$unit_name_fg[$i]?></td>
  </tr>
  <? }?>

  <tr>
    <td colspan="2" style="text-align:right; vertical-align:top; border:1px solid #000; padding:5px;"><strong>Total</strong></td>
    <td style="text-align:right; vertical-align:top; border:1px solid #000; padding:5px;"><span class="style1"><?=number_format($tot_today_close,2)?></span></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><strong>KG</strong></td>
    <td style="text-align:right; vertical-align:top; border:1px solid #000; padding:5px;">&nbsp;</td>
    <td style="text-align:right; vertical-align:top; border:1px solid #000; padding:5px;"><strong>Total</strong></td>
    <td style="text-align:right; vertical-align:top; border:1px solid #000; padding:5px;"><span class="style1"><?=number_format($tot_fg_stock,2)?></span></td>
    <td style="text-align:left; vertical-align:top; border:1px solid #000; padding:5px;"><strong>KG</strong></td>
  </tr>
</table>

  
  </td>
  </tr>

  <tr>

    <td  style="text-align:center;">

    <table style="width:100%; border-collapse:collapse; border:0; padding:0;">

  <tr>

    <td colspan="3" style="font-size:12px">&nbsp;</td>
    </tr>

  <tr>

    <td width="38%">&nbsp;</td>

    <td colspan="2">&nbsp;</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>

    <td>&nbsp;</td>

    <td colspan="2">&nbsp;</td>
  </tr>

  <tr>

    <td>&nbsp;</td>

    <td colspan="2">&nbsp;</td>
  </tr>

  <tr>

    <td colspan="3" style="text-align:center;"><strong><br />

      </strong>

      <table style="width:100%; border-collapse:collapse; border:0; padding:0;">

        <tr>
          <td><div style="text-align:center;"><?php /*?><?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?><?php */?>  <hr style="width:60%;" /></div></td>
          
          <td>&nbsp;</td>
          <td width="39%"><div style="text-align:center;"><?php /*?><?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?><?php */?>  <hr style="width:60%;" /></div></td>
        </tr>
        <tr>

          <td style="width:38%;"><div style="text-align:center;">Supervisor</div></td>

          

          <td width="23%">&nbsp;</td>
          <td><div  style="text-align:center;">Assistant Manager </div></td>
          </tr>
      </table></td>
    </tr>

  <tr>

    <td><div style="text-align:center;">M. Ahmed Tea &amp; Lands Co. Ltd. Pkg. Div.</div></td>
 <td  style="width:23%;">&nbsp;</td>
    <td  style="width:39%;"><div style="text-align:center;">M. Ahmed Tea &amp; Lands Co. Ltd. Pkg. Div.</div></td>
  </tr>
    </table>

    <div class="footer1"> </div>    </td>
  </tr>
</table>

</body>

</html>

