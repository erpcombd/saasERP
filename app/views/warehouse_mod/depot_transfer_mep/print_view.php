<?php



//session_start();



require_once "../../../assets/template/layout.top.php";



$req_no 		= url_decode(str_replace(' ', '+', $_REQUEST['req_no']));





$sql="select * from fg_issue_master where  pi_no='$req_no'";



$data=mysql_query($sql);



$all=mysql_fetch_object($data);



$req_date=find1("select req_date from requisition_fg_master where req_no='".$all->req_no."'");





$company_info = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');





?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title>.: FG Challan Copy :.</title>



<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>



<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";



}



</script>



<style type="text/css">



<!--



.style11 {



	font-size: 16px;



	font-weight: bold;



}



.style14 {font-weight: bold}



.style12 {



	font-size: 12px;



	font-weight: normal;



}



.style4 {	font-size: 18px;



	color: #000000;



}



.style15 {



	color: #FF0000;



	font-weight: bold;



}



.style16 {color: #336600}

.style17 {font-size: 12px}

.style19 {font-size: 12px; font-weight: bold; }



-->



</style>



</head>



<body>



<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">



  <tr>



    <td><div class="header">



	<table width="100%" border="0" cellspacing="0" cellpadding="0">



	  <tr>



	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">



          <tr>



            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">



              <tr>



                <td><table  width="80%" border="0" align="center" cellpadding="3" cellspacing="0">

                  <tr>

<td bgcolor="#00CC33" style="text-align:center; color:#FFF; font-size:14px; font-weight:bold;">

<? if($all->group_for>0){ ?>

<span class="style4"><?=show_company($all->group_for)?><br/>

<span  style="font-size:16px"><?=find1("select address from user_group where id='".$all->group_for."'");?></span>

<br><span class="style6">CENTRAL BIN: <?=find1("select vat_reg from user_group where id='".$all->group_for."'");?></span>

</span>

<? }else{ ?>

<span class="style4">MEP Group<br/>    

<? }?>



</td>

</tr>



</table></td>

</tr>



              <tr>



                <td><div class="header_title" align="center">Delivery Challan<br>

                <strong>Product Transfer</strong></div></td>

              </tr>



              <tr>



                <td height="19">&nbsp;</td>

              </tr>



            </table></td>

          </tr>







        </table></td>

	    </tr>



	  <tr>



	    <td>

	        

<table width="100%" border="0" cellspacing="0" cellpadding="0">

		  <tr class="value_top">

            <td width="10%" valign="bottom">&nbsp;</td>

		    <td width="35%" valign="bottom"><span class="style11">From:<br><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_from);?></span>

            <br><?=find_a_field('warehouse','address','warehouse_id='.$all->warehouse_from);?>

            </td>

		    

		    <td width="10%" valign="bottom"><span style="font-size:16px; vertical-align: top;"><strong></strong></span></td>

		    

		    <td width="35%"><span class="style11">To:<br><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_to);?></span>

            <br><?=find_a_field('warehouse','address','warehouse_id='.$all->warehouse_to);?>

            </td>

            <td width="10%" valign="bottom">&nbsp;</td>

		</tr>

</table>







<table width="100%" border="0" cellspacing="0" cellpadding="0">

		  <tr>



		    <td valign="bottom">&nbsp;</td>



		    <td valign="bottom">&nbsp;</td>



		    <td valign="bottom">&nbsp;</td>



		    <td>&nbsp;</td>

		    </tr>



		  <tr>



		    <td colspan="4" valign="bottom">



			<? if($all->status=='SEND'){?><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFCC99">



			



              <tr>



                <td><div align="center" class="style15">IN TRANSIT </div></td>

              </tr>







            </table>



			<? }?>



		    <? if($all->status=='RECEIVED'){?><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCFFCC">



                <tr>



                  <td><div align="center"><strong>



	<span class="style16" style=" text-transform: uppercase;">RECEIVED BY <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_to);?></span></strong></div></td>

                </tr>



              </table><? }?>			</td>

		    </tr>



		</table>		</td>

	  </tr>

    </table>



    </div></td>



    <td>&nbsp;</td>

  </tr>



  <tr>



    



	<td>	</td>



    <td></td>

  </tr>



  <tr>



    <td><div class="line"></div></td>



    <td>&nbsp;</td>

  </tr>



  <tr>



    <td><div class="header2">



          <div class="header2_left" style="height:30px;">



        <p>

		

		<strong class="style11">Transfer ID: <?=$all->pi_no;?></strong><br />

		

		<strong class="style11">Transfer Date</strong>: <strong class="style11"><?php echo $all->pi_date;?></strong>



          

        </p>

      </div>



      <div class="header2_right">



        <p>

            

          

          <strong class="style11">Req No:: <?=$all->req_no;?>, Req Date: <?=$req_date;?><br/>



          Vehical No: <?php echo $all->carried_by;?><br/></strong>

        </p>

      </div>



    </div></td>



    <td>&nbsp;</td>

  </tr>



  <tr>



    <td><div id="pr">



<div align="left">



<form action="" method="get">







<table width="100%" border="0" cellspacing="0" cellpadding="0">



  <tr>



    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>

  </tr>

</table>

</form>

</div>



</div>



<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">



       <tr>

        <td width="5%"><strong>SL</strong></td>

        <td width="4%"><strong>FG</strong></td>

        <td width="41%"><strong>Product Name </strong></td>

        <td width="9%"><strong>Pack Size</strong></td>

        <td width="9%"><strong>Unit</strong></td>

        

        <td width="9%"><strong>Ctn Qty</strong></td>

        <td width="9%"><strong>Pcs Qty</strong></td>



        <td width="11%"><strong>Total Qty</strong></td>



       </tr>



	  <?php



$final_amt=(int)$data1[0];



$pi=0;



$total=0;



$sql2="select p.* from fg_issue_detail p, item_info i where p.item_id=i.item_id and p.pi_no='$req_no'";

$data2=mysql_query($sql2);



//echo $sql2;



while($info=mysql_fetch_object($data2)){ 



$pi++;



$total_qty=$info->total_unit;

$grand_total_qty+=$total_qty;

$rate=$info->unit_price;

$total_amount=$info->total_amt;

$grand_total_amount+=$total_amount;







$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);



if($item->item_id){



?>



      <tr>



        <td valign="top"><span class="style17">

          <?=$pi?>

        </span></td>



        <td align="center" valign="top"><span class="style17">

          <?=$item->finish_goods_code?>

        </span></td>



        <td align="left" valign="top"><span class="style12"><?=$item->item_name?></span></td>



        <td align="center" valign="top"><span class="style17"><?=$item->pack_size?></span></td>





        <td align="center" valign="top"><span class="style17">

          <?=$item->unit_name?>

        </span></td>





<td align="center" valign="top"><div align="right" class="style17"><?=(int)($total_qty/$item->pack_size); $gctn+=(int)($total_qty/$item->pack_size);?></div></td>

<td align="center" valign="top"><div align="right" class="style17"><?=$total_qty%$item->pack_size; $gpcs+=$total_qty%$item->pack_size;?></div></td>

<td align="center" valign="top"><div align="right" class="style17"><?=number_format($total_qty,2); $gtotal+=$total_qty;?></div></td>

      </tr>



      



<? } }?>



<tr>



        <td colspan="5" valign="top"><div align="right"><strong>Total:</strong></div></td>

        <td valign="top"><div align="right"><span class="style19"><?=number_format($gctn,2);?></span></div></td>

        <td valign="top"><div align="right"><span class="style19"><?=number_format($gpcs,2);?></span></div></td>

        <td valign="top"><div align="right"><span class="style19"><?=number_format($gtotal,2);?></span></div></td>



</tr>

    </table></td>



    <td>&nbsp; </td>

  </tr>



  <tr>

    <td align="center"><div align="left"><h3><b>Note:</b> &nbsp;<?php echo $all->remarks;?></h3></div></td>

    <td align="center">&nbsp;</td>

  </tr>

  <tr>



    <td align="center">



	<div class="footer1"><strong><br />



    </strong>



      <table width="100%" border="0" cellspacing="0" cellpadding="0">



        <tr>



          <td width="%"><div align="center">



            <p style="float:left; font-weight:bold;">Prepared By: <br />



              <?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?>

            </p>



          </div></td>
		  
		  <td width="%"><div align="center">



            <p style="float:left; font-weight:bold;">Verify By: <br />



              <? //=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?>

            </p>



          </div></td>



          <td width="%"><div align="center">



              <p>Received By<br /></p>



          </div></td>



          <td width="%"><div align="center"><p>Approved By<br /> </p></div></td>

        </tr>

      </table>



      </div>



	<div class="footer1"></div></td>



    <td align="center">&nbsp;</td>

  </tr>

</table>



</body>



</html>



