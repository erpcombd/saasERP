<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$oi_no 		= $_REQUEST['req_no'];

  		  $barcode_content = $oi_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';
		  
$group = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');
$req_no 		= $_REQUEST['req_no'];

$sql="select * from requisition_master where  req_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Requsition Copy</title>
<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>
	<?php include("../../../../public/assets/css/theme_responsib_new_table_report1.php");?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
    <style>
  	.hr1{
	 	border:1px solid black;
 		}
	.logo-img{
		width:200px;
			}
			.logo{
 	 width:10% !important;
  }
  .addr{
  	font-size: 12px !important ;
  }
  .teg{
  	
	font-size:16px;
  	}
	body {
    width: 1186px;
    margin: 0 auto;
    font-size: 16px;
}
@font-face {
  font-family: 'MYRIADPRO-REGULAR';
  src: url('MYRIADPRO-REGULAR.OTF'); /* IE9 Compat Modes */

}

@font-face {
  font-family: 'TradeGothicLTStd-Extended';
  src: url('TradeGothicLTStd-Extended.otf'); /* IE9 Compat Modes */

}


@font-face {
  font-family: 'Humaira demo';
  src: url('Humaira demo.otf'); /* IE9 Compat Modes */

}

@media print {
	body{
		/*width:  100% !important;*/
		font-size: 18px !important;
	 }
}
  </style>
</head>
<body style="font-family: Poppins, serif; font-size: 14px; ">

<table width="100%" cellspacing="0" cellpadding="2" border="0">
  <thead>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="2" border="0">
      <tr>
        <td width="20%" class="logo"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/></td>
        <td width="60%" align="center">
				<p style="font-size:28px; color:#000000; margin:0; padding: 0 0 5px 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"> <?=$group->group_name?> </p>			
				<p class="text"><strong>Address: </strong><?=$group->address?></p>
				<p class="text"><strong>Cell:</strong> <?=$group->mobile?>. <strong>Email: </strong><?=$group->email?> <br><strong>  <?=$group_data->vat_reg?> </strong></p>
				<p class="text">
                     <? $war=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);
                      echo $war->warehouse_name;?>
				</p>
		</td>
        <td class="qrl-text">
			<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p class="qrl-text"><?php echo $master->po_no;?></p>
		</td>
		
      </tr>
	 
    </table>      </td>
  </tr>
   <tr><td><hr class="hr mt-1 mb-1"/></td></tr>
  </thead>
  <tbody>
  <tr>
    <td>
	<table width="100%" cellspacing="0" cellpadding="2" border="0">
      <tr>
        <td>
		<h5 class="text-center font-weight-bold mt-0 ml-0 mb-2 ">PURCHASE REQUISITION</h5>
		<!--<hr class="hr1 w-25">-->
		</td>
      </tr>
      <tr>
        <td><table width="100%" cellspacing="0" cellpadding="2" border="0" >
          <tr>
            <td width="35%">
				<table>
				<tr>
				
				<td width="32%">Date </td>
					<td width="68%"> : <?php echo $all->req_date;?></td>
				</tr>
				<tr>
					<td width="32%">Requisition  No </td>
					<td width="68%"> : <?php echo $all->req_no;?></td>
				</tr>
				<tr>
					<td>Requisition For </td>
					<td> : <?php echo $all->req_for;?></td>
				</tr>
				
				</table>
			
				
				
            <td width="30%"></td>
            <td width="35%" >
				<table width="100%" cellspacing="0" cellpadding="2" border="0">
				
				<tr>
					<td width="40%">Status</td>
					<td width="60%">: <?php echo $all->status;?></td>
				</tr>
				<tr>
					<td >Note</td>
					<td >: <?php echo $all->req_note;?></td>
				</tr>
				<tr>
					<td >Need Before</td>
					<td>: <?php echo $all->need_by;?></td>
				</tr>
				
				
				</table>
			</td>
          </tr>
        </table></td>
      </tr>
      
      <tr>
        <td>
		<div id="pr">
        <div align="left">
          <p>
            <input name="button" type="button" onClick="hide();window.print();" value="Print" />
          </p>	    
		  </div>
      </div>
		<table width="100%" cellspacing="0" cellpadding="3" border="1" style=" margin-top: 50px;" >
		<tr>
				<th class="text-center">SL</th>
				<th >REQ-ID</th>
				<th class="text-center">Description of the Goods</th>
				<th class="text-center">Remarks</th>
				<th class="text-center">In Stock</th>
				<th class="text-center">Last Pur. Date</th>
				<th class="text-center">Last Pur. QTY</th>
				<th class="text-center">Unit</th>
				<th class="text-center">Req QTY</th>
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
        <td  style="text-align:center;"><?=$sl?></td>
        <td class="text-center"><?=$info->id?></td>
        <td class="text-left" >Code:<?=$info->item_id?><br><?=$item->item_name.' : '.$item->item_description?></td>
        <td class="text-right"><?=$info->item_for?></td>
		<td class="text-right"><?=$qoh?></td>
        <td class="text-right"><?=$last_p_date?></td>
        <td class="text-right"><?=$last_p_qty?></td>
        <td class="text-center"><?=$item->unit_name?></td>
		<td class="text-right"><?=$qty?></td>
      </tr>
<? }?>
		
		
		
			  <tr>
 		<td colspan="6" style="text-align:right;"><strong>Total</strong></td>
 		<td colspan="3" align="right"><strong><?=number_format($total_qty,2)?></strong></td>
		</tr>
    </table></td>
  </tr>
			
  <tr class="mb-10">
    <td >
	<table width="100%" cellspacing="0" cellpadding="2" border="0" style=" margin-top: 100px;">
      <tr>
                    <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?></td>
                    <!--<td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->approve_by)?></td>-->
                    <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->checked_by)?></td>
                </tr>

                <tr>
                    <td align="center">-------------------------------</td>
                    <!--<td align="center">-------------------------------</td>-->
                    <td align="center">-------------------------------</td>
                </tr>
                <tr>
                    <td align="center"><strong>Prepared By:</strong></td>
                    <!--<td align="center"><strong>Checked By:</strong></td>-->
                    <td align="center"><strong>Approved By:</strong></td>
                </tr>

    </table></td>
  </tr>
 </tbody>
   
</table>
    <script>
        // JavaScript for page number counting
        function updatePageNumber() {
            var pageNumberElement = document.getElementById('footer');
            var totalPages = document.querySelectorAll('.pagedjs_page').length;

            pageNumberElement.textContent = 'Page ' + window.pagedConfig.pageCount + ' of ' + totalPages;
        }

        // Call the updatePageNumber function when the page is loaded and after printing
        window.onload = updatePageNumber;
        window.onafterprint = updatePageNumber;
    </script>
</body>
</html>