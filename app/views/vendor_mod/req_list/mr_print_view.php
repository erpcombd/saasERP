<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$table_details='quotation_detail';

$crudMaster= new crud('quotation_master');


$req_no 		=url_decode($_REQUEST['req_no']);


$sql="select * from requisition_master where  req_no='$req_no'";

$data=db_query($sql);

$all=mysqli_fetch_object($data);



if(isset($_POST['create_po'])){


 /*$_POST['vendor_id']=			find_a_field('user_activity_management','vendor_code','user_id='.$_SESSION['user']['id']);
 $_POST['group_for']=			$_SESSION['user']['group'];
 $_POST['warehouse_id']=		$_SESSION['user']['depot'];
 $_POST['quotation_date']=		date('Y-m-d');
 $_POST['status']=				"MANUAL";
 $_POST['entry_by']=			$_SESSION['user']['id'];
 $_POST['entry_at']=			date('Y-m-d h:s:i');
 
 $last_id=$crudMaster->insert();
 
   $sql = "select a.* from requisition_order a where a.req_no='".$_POST['req_no']."' order by a.id";

		$query = db_query($sql);

		while($info=mysqli_fetch_object($query))

		{
	

 $insSql = 'INSERT INTO quotation_detail(`quotation_no`, `quotation_date`, `req_no`, `order_no`, vendor_id, `group_for`, `warehouse_id`, `item_id`, `brand`, `origin`, `qty`, `unit_name`, req_remarks, `quotation_price`, 

`quotation_brand`, `entry_by`,  `entry_at`) 

VALUES ("'.$last_id.'", "'.$_POST['quotation_date'].'", "'.$info->req_no.'", "'.$info->id.'", 

 "'.$_POST['vendor_id'].'", "'.$_POST['group_for'].'",  "'.$info->warehouse_id.'",  "'.$info->item_id.'",

   "'.$info->brand.'", "'.$info->origin.'", "'.$info->qty.'", "'.$info->unit_name.'", "'.$info->remarks.'", 

   "0", "0", "'.$_SESSION['user']['id'].'","'.$_POST['entry_at'].'" )';

	db_query($insSql);

		

			}
 
 
 

	
	
 
 
 

  $_SESSION['quotation_no'] = $last_id;*/
  $_SESSION['rfq_req_no'] = $_POST['req_no'];
  header('location:../quotation/mr_create.php');

 



}



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

    <style type="text/css">

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


@page {

		@bottom-center {
		  content: "Page " counter(page) " of " counter(pages);
		}
  }
    </style>

</head>

<body>



<div id="pr">

    <h5 align="center"> <input name="button" type="button" onclick="hide();window.print();" value="Print" /></h5>

</div>



<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td>

        <div class="header">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

	  <tr>

          <td width="20%"></td>

          <td width="60%">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">



                <tr>

                    <td style="text-align:center">

                        <h2 style="margin: 0px"><?=$_SESSION['company_name']?></h2>

                    </td>

                </tr>

                <tr>

                    <td style="text-align:center; font-size: 14px;">

                        <strong>

                            <? $war=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);

                            echo $war->warehouse_name;?>

                        </strong>

                    </td>

                </tr>



            </table>

        </td>



          <td width="20%"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['depot']?>.png"  width="100%" /></td>



	    </tr>



    </table>

    </div>

    </td>

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

        <p><span style="font-weight:bold;">Purchase Requisition</span><br/><strong>Date:</strong> <?php echo $all->req_date;?><br />

            <strong>Requisition  No :</strong>  <?php echo $all->req_no;?><br />

            <strong>Requisition For :</strong>  <?php echo $all->req_for;?><br />

        </p>

      </div>

      <div class="header2_right">

        <p>

            <strong>Note : </strong> <?php echo $all->req_note;?><br />

            <strong>Need Before :</strong> <?php echo $all->need_by;?><br />

        </p>

      </div>

    </div></td>

  </tr>

  <tr>

    <td>



<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="2" cellpadding="2" style="border-collapse:collapse;">

       <tr bgcolor="#ffec62">

        <td width="2%"><strong>SL.</strong></td>

        <td><strong>REQ-ID</strong></td>

        <td><strong>Description of the Goods </strong></td>

		<td><strong>Remarks</strong></td>

        <td><strong>Req QTY</strong></td>

       </tr>

	  <?php

$final_amt=(int)$data1[0];

$pi=0;

$total=0;

$sql2="select * from requisition_order where  req_no='$req_no'";

$data2=db_query($sql2);

//echo $sql2;

while($info=mysqli_fetch_object($data2)){ 

$pi++;

$amount=$info->qty*$info->rate;

$total=$total+($info->qty*$info->rate);

$sl=$pi;

$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);

$qty=$info->qty;

$qoh=$info->qoh;

$last_p_date=$info->last_p_date;

$last_p_qty=$info->last_p_qty;

$item_for=$info->item_for;

$total_qty +=$qty;

?>

      <tr>

        <td valign="top"><?=$sl?></td>

        <td align="left" valign="top"><?=$info->id?></td>

        <td align="left" valign="top">Code:<?=$info->item_id?><br><?=$item->item_name.' : '.$item->item_description?></td>

        <td valign="top"><?=$info->remarks?></td>

        <td valign="top"><?=$qty.' '.$item->unit_name?></td>

      </tr>

<? }?>

<tr bgcolor="#ffec62">

<!-- <td colspan="7">&nbsp;</td>-->

 <td colspan="4" align="right"><strong>Total </strong> </td>



 <td align="right"> <strong><?=number_format($total_qty,2)?></strong></td>

</tr>

    </table></td>

  </tr>

  <tr>

    <td colspan="2">&nbsp;</td>

  </tr>

  <tr>

    <td align="center">

	<form method="post" action="">

	  <input name="create_po" type="submit" class="btn btn-info" value="Create Quotation" style="width:200px; font-weight:bold; font-size:12px; height:30px; color:white; background:cornflowerblue; border:0px;" />

	  <input type="hidden" name="req_no" value="<?=$req_no?>" />

	  </form>

	  </td>

	  

  </tr>

   <tr>

    <td colspan="2">&nbsp;</td>

  </tr>

   <tr>

    <td colspan="2">&nbsp;</td>

  </tr>

  <tr>

    <td align="center">

	<div class="footer1"></div>

	<div class="footer1">

     <table width="551" border="0">



         <tr>

             <td colspan="2" align="right">&nbsp;</td>

         </tr>

         <!--<tr>

             <td colspan="2" align="right">&nbsp;</td>

         </tr>-->

         <tr>

             <td colspan="2" align="right">&nbsp;</td>

         </tr>





     









     </table>

     </div>

    </td>

  </tr>

</table>

</body>

</html>



