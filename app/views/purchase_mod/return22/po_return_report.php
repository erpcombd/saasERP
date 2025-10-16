<?php



session_start();



//====================== EOF ===================



//var_dump($_SESSION);



require "../../support/inc.all.php";







require "../../../engine/tools/class.numbertoword.php";





$comp_info=find_all_field('project_info','','1');




$or_no 		= $_REQUEST['v_no'];











$datas=find_all_field('purchase_item_return_details','s','oi_no='.$or_no);

$mrr_no =find_a_field('purchase_item_return_master','mrr_no','oi_no='.$or_no);

$vendor = find_all_field('vendor','s','vendor_id='.$datas->vendor_id);



$sql1="select b.* from purchase_item_return_master b where b.oi_no = '".$or_no."'";



$data1=db_query($sql1);







//auto_insert_sales_return_secoundary('9027');







$pi=0;



$total=0;



while($info=mysqli_fetch_object($data1)){ 



$rec_frm=$info->vendor_name;



$vendor_name=$info->vendor_name;



$vendor_id=$info->vendor_id;



$oi_subject=$info->oi_subject;



$oi_date=$info->oi_date;







$warehouse_id=$info->warehouse_id;



}







$sql1="select b.* from purchase_item_return_details b where b.oi_no = '".$or_no."'";



$data1=db_query($sql1);







$pi=0;



$total=0;



while($info=mysqli_fetch_object($data1)){ 



$pi++;







$order_no[]=$info->order_no;



$qc_by=$info->qc_by;







$item_id[] = $info->item_id;



$rate[] = $info->rate;



$amount[] = $info->rate*$info->qty;







$unit_qty[] = $info->qty;



$unit_name[] = $info->unit_name;

$remarks[]=$info->remarks;

}







?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title>.: PO Return  Report :.</title>



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



              <tr  style="text-align:center; color:#000000;">
 


                <td>



				<table width="70%"  style="border-collapse:collapse; border: 3px dashed black;color:#000000;margin-bottom:100px"  bgcolor="" align="center" cellpadding="5" cellspacing="0">



      <tr>

<td bgcolor="" rowspan="3" style="align:left;"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$comp_info->proj_img?>" height="45px" width="80px" /></td>

        <td bgcolor="" style="text-align:center; color:#000000; font-size:25px; font-weight:bold;">



		



		<?







if($_SESSION['user']['group']>1)







echo find_a_field('user_group','group_name',"id=".$_SESSION['user']['group']);







else







echo $_SESSION['proj_name'];







				?>



		



		</td>



      </tr>
		
		<tr>







        <td bgcolor="" colspan="2" style="text-align:center; color:#000000; font-size:15px; font-weight:bold;"><?php echo $comp_info->proj_address; ?></td>







      </tr>



	  



	   <tr>







        <td bgcolor=""  colspan="2" style="text-align:center; color:#000000; font-size:15px; font-weight:bold;">Product Return Challan</td>







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



		          <td width="40%" align="right" valign="middle">Vendor : </td>



		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">



		            <tr>



		              <td><strong><?php echo $vendor->vendor_name;?> </strong></td>



		              </tr>



		            </table></td>



		          </tr>

					 <tr>



		          <td width="40%" align="right" valign="middle">Vendor Address : </td>



		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">



		            <tr>



		              <td><strong><?php echo $vendor->address.'&nbsp;'.' Mobile: '.$vendor->contact_person_mobile;?></strong></td>



		              </tr>



		            </table></td>



		          </tr>

		        



		        



		        <tr>



                  <td align="right" valign="middle"> Warehouse :</td>



		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">



                      <tr>



                        <td><strong><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);?></strong>&nbsp;</td>



                      </tr>



                  </table></td>



		          </tr>



		          <td align="right" valign="middle"> Note :</td>



		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">



		            <tr>



		              <td><?php echo $oi_subject;?>&nbsp;</td>



		              </tr>



		            </table></td>



		          </tr>



                  



		        <tr>



		        </table>		      </td>



			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">



			  <tr>



                <td width="38%" align="right" valign="middle">Return No :</td>



			    <td width="62%"><table width="100%" border="1" cellspacing="0" cellpadding="3">



                    <tr>



                      <td><strong><?php echo $or_no;?></strong>&nbsp;</td>



                    </tr>



                </table></td>



			    </tr>



			  <tr>



                <td align="right" valign="middle"> Return Date :</td>



			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">



                    <tr>



                      <td><strong><?=date("d M, Y",strtotime($oi_date))?></strong>



                        &nbsp;</td>



                    </tr>



                </table></td>



			    </tr>



				 <tr>



                <td align="right" valign="middle"> Mrr No :</td>



			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">



                    <tr>



                      <td><strong><?=$mrr_no?></strong>



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



    



	<td>	</td>



  </tr>



  



  <tr>



    <td>



      <div id="pr">



  <div align="left">



<input name="button" type="button" onclick="window.print();" value="Print" />



  </div>



</div>



<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">



       <tr>



        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>



        <td align="center" bgcolor="#CCCCCC"><strong>Code</strong></td>



        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>







        <td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>



      <!--  <td align="center" bgcolor="#CCCCCC"><strong>Rate</strong></td>-->



        <td align="center" bgcolor="#CCCCCC"><strong>Return Qty</strong></td>



        <td align="center" bgcolor="#CCCCCC"><strong>Remarks</strong></td>



        </tr>



       



<? for($i=0;$i<$pi;$i++){



$item = find_all_field('item_info','item_name','item_id='.$item_id[$i]);







?>



      



      <tr>



        <td align="center" valign="top"><?=$i+1?></td>



        <td align="left" valign="top"><?=$item->item_id?></td>



        <td align="left" valign="top"><?=$item->item_name;?></td>



        <td align="right" valign="top"><?=$unit_name[$i]?></td>



       <?php /*?> <td align="right" valign="top"><?=$rate[$i]?></td><?php */?>



        <td align="right" valign="top"><?=$unit_qty[$i]; $t_qt= $t_qt + $unit_qty[$i];?></td>



        <?php /*?><td align="right" valign="top"><?=$amount[$i]; $t_amount = $t_amount + $amount[$i];?></td><?php */?>

	 <td align="right" valign="top"><?php echo $remarks[$i]; ?>&nbsp;</td>

        </tr>



<? }?>



  <td colspan="4" align="center" valign="top"><div align="right"><strong>Total Quantity: </strong></div></td>



        <td align="right" valign="top" colspan=""><span class="style1">



          <?= $t_qt;?>



        </span></td>

 <td colspan="" align="center" valign="top"><div align="right">&nbsp;</div></td>

    </table></td>



  </tr>



  <tr>



    <td align="center">



    <table width="100%" border="0" cellspacing="0" cellpadding="0">



  <tr>



    <td colspan="2" style="font-size:12px">&nbsp;</td>



    </tr>



  <?php /*?><tr>



    <td colspan="2"><span style="font-size:14px"><strong>In Word :</strong> <span style="font-size:16px;">



    <?







		//echo $tot_ctn;







			 $credit_amt = explode('.',$t_amount);







	 if($credit_amt[0]>0){







	 







	 echo convertNumberToWordsForIndia($credit_amt[0]);}







	 if($credit_amt[1]>0){







	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;







	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa ';}







	 echo ' Only.';







		?>



    </span></span></td>



    </tr><?php */?>



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



    <td colspan="2" align="center"><strong><br />



      </strong>



      <table width="100%" border="0" cellspacing="0" cellpadding="0">



        <tr>



          <td><div align="center">
		  ----------------------<br/>
		  
		  Issued By </div></td>
		  
		  <td><div align="center">
		   ----------------------<br/>
		  
		  Checked By </div></td>



          <td><div align="center">
		   ----------------------<br/>
		  
		  Received By</div></td>



          <td><div align="center"> ----------------------<br/>
		  
		  Approved By</div></td>



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



