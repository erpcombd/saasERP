<?php



session_start();



//====================== EOF ===================






 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



//require "../../../engine/tools/class.numbertoword.php";



require_once ('../../../acc_mod/common/class.numbertoword.php');



$batch_no		= $_REQUEST['batch_no'];







if(isset($_POST['cash_discount']))







{







	$po_no = $_POST['po_no'];







	$cash_discount = $_POST['cash_discount'];







	$ssql='update purchase_sp_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';







	db_query($ssql);







}















$sql_ms="select * from batch_master where batch_no='$batch_no'";



$ms_data=mysqli_fetch_object(db_query($sql_ms));



$company=find_all_field('user_group','','id='.$ms_data->group_for);



$whouse=find_all_field('warehouse','','warehouse_id='.$ms_data->warehouse_id);





?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>







<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />







<title>.: Batch Assignment :.</title>







<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>







<script type="text/javascript">







function hide()







{







    document.getElementById("pr").style.display="none";







}







</script>







<style type="text/css">







<!--







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









.style4 {







	font-size: 12px;







	font-weight: bold;







}



.style5 {font-weight: bold}



.style6 {font-weight: bold}



.style7 {font-weight: bold}



.style9 {font-weight: bold}



.style10 {font-weight: bold}







-->







</style></head>







<body>







<form action="" method="post">







<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">







  <tr>







    <td align="center"><div class="header" style="margin-top:0;">

       <table width="100%" border="0" cellspacing="0" cellpadding="0">

    

		  <tr>

            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr>

                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td width="100%"> 

							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0; text-align:center; " >

								

									

									<tr>

									  <td style="padding-bottom:3px; "><span style="font-size:22px; color:#000000; margin:0; padding: 0 0 0 0; text-transform:uppercase;  font-weight:700; font-family: 'TradeGothicLTStd-Extended';"><?=$company->group_name?></span></td>

							  </tr>

							  

							  

									<tr><td style="font-size:16px; line-height:20px;"><?=$company->address?></td>

									</tr>

									

									

									

									<tr>

   <td colspan="2" align="center"><h4 style="font-size:18px; width: 40%; padding:5px 0; margin:0; border:2px solid #000000; margin: 8px 0;  border-radius: 5px; font-family:  'MYRIADPRO-REGULAR'; letter-spacing:1px; text-transform:uppercase;">Batch Assignment</h4></td>

  </tr>

									

									

							

									

							  

							  

						  </table>						  </td>                    </tr>

                    </table></td>

                </tr>

              </table></td>

          </tr>

        </table>

       </div></td>

  </tr>







  <tr>

    <td colspan="0" align="center"><hr /></td>

  </tr>

  

 

  

  

  <tr> <td><table width="100%" border="0" cellspacing="0" cellpadding="0">





		  <tr>





		    <td width="68%" valign="top">





		      <table width="96%" border="0" cellspacing="0" cellpadding="3"  style="font-size:12px">

		        <tr style=" line-height:20px;" >

		          <td width="25%" align="left" valign="middle"  style="font-size:16px;" ><strong>Product Name  </strong></td>

		          <td width="3%" align="left" valign="middle"  style="font-size:14px;" ><strong>: </strong></td>

		          <td width="72%" style="font-size:18px; "><?= find_a_field('item_info','item_name','item_id="'.$ms_data->fg_item_id.'"');?></td>

	            </tr>

		        <tr style=" line-height:20px;">

		          <td align="left" valign="middle"  style="font-size:16px;"><strong>Batch Qty</strong></td>

		          <td align="left" valign="middle"  ><strong>:</strong></td>

		          <td style="font-size:16px;"><?= $ms_data->batch_qty;?> <?= $ms_data->unit_name;?></td>

	            </tr>

		        <tr style=" line-height:20px;">

		          <td align="left" valign="middle"  style="font-size:16px;"><strong>Factory Unit</strong></td>

		          <td align="left" valign="middle"  ><strong>:</strong></td>

		          <td style="font-size:16px;"><?=$whouse->warehouse_name;?></td>

	            </tr>

		        </table>		      </td>





			<td width="32%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2"  style="font-size:11px">

			

			

			

			<tr>





                <td width="41%" align="right" valign="middle"><strong> Batch No: </strong></td>





			    <td width="59%"><table width="100%" border="1" cellspacing="0" cellpadding="1">





                    <tr height="20">





                     <td>&nbsp; <?=$ms_data->inv_type;?><?=$_GET['batch_no']?></td></a>

                    </tr>





                </table></td> </tr>









			  <tr>





                <td width="41%" align="right" valign="middle"><strong> Batch Date: </strong></td>





			    <td width="59%"><table width="100%" border="1" cellspacing="0" cellpadding="1">

                  <tr height="20">

                    <td>&nbsp; <?= date("d-m-Y",strtotime($ms_data->batch_date));?></td>

                  </tr>

                </table></td> </tr>

				

				

				<tr>





                <td width="41%" align="right" valign="middle"><strong> BOM No: </strong></td>





			    <td width="59%"><table width="100%" border="1" cellspacing="0" cellpadding="1">

                  <tr height="20">

                    <td>&nbsp; <a href="../BOM/invoice_print_view.php?bom_no=<?=$ms_data->bom_no;?>" target="_blank"> BOM-<?= $ms_data->bom_no;?></a></td>

                  </tr>

                </table></td> </tr>

				

				

				

				

			

			  





		    </table></td>

		  </tr>





		</table>		</td></tr>







    <tr>

		<td>&nbsp;</td>

	</tr>







  <tr>







    <td><div id="pr">







      <div align="left">







        







          <table width="60%" border="0" cellspacing="0" cellpadding="0">







        <tr>







          <td><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>







          <!--<td><span class="style3">Special Cash Discount: </span></td>







          <td><label>







            <input name="cash_discount" type="text" id="cash_discount" value="<?=$cash_discount?>" />







            </label>







            <input type="hidden" name="po_no" id="po_no" value="<?=$po_no?>" /></td>







          <td><label>







            <input type="submit" name="Update" value="Update" />







          </label></td>-->

        </tr>

      </table>

      </div>







    </div></td>

</tr>



<tr>



<td>





<table width="100%" class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0">



       <tr>

         <td colspan="4" align="center"><strong>Factory Overhead Cost</strong></td>

         </tr>

       <tr>



        <td width="5%"><strong>SL</strong></td>



        <td width="21%"><strong> Ledger Group </strong></td>

        <td width="57%"><strong>Ledger Name</strong></td>

        <td width="17%"><strong> Amount </strong></td>

      </tr>



	  <?php







$final_amt=0;







$pi=0;







$total=0;







	 $sql2="select l.group_name, a.ledger_id, a.ledger_name, f.final_amt as amount

	from ledger_group l, accounts_ledger a, batch_factory_overhead f where l.group_id=a.ledger_group_id and f.ledger_id=a.ledger_id and f.batch_no='".$batch_no."'

	order by l.group_id, a.ledger_id";







$data2=db_query($sql2);







//echo $sql2;







while($info=mysqli_fetch_object($data2)){ 







$pi++;





$sl=$pi;





?>







<tr>







        <td valign="top"><?=$sl?></td>



        <td valign="top"  align="left"><?=$info->group_name;?></td>

        <td align="left" valign="top"><?=$info->ledger_name;?></td>

        <td align="right" valign="top"><?=number_format($info->amount,2); $sub_total_amt +=$info->amount;?></td>

      </tr>







<? }?>



<tr>







        <td colspan="3" valign="top"><div align="right"><strong> Total:</strong></div></td>



        <td align="right" valign="top"><strong><?=number_format($sub_total_amt,2); ?></strong></td>

      </tr>

    </table>	</td>

	</tr>

	

	

	

	<tr>



<td>&nbsp;



</td></tr>

	

<tr>



<td>





<table width="100%" class="tabledesign"  bordercolor="#000000" cellspacing="0" cellpadding="0">



       <tr>

         <td colspan="5" align="center"><strong>Raw Materials Required</strong></td>

         </tr>

       <tr>



        <td width="4%"><strong>SL</strong></td>



        <td width="21%"><strong> Category </strong></td>

        <td width="45%"><strong> Item Description </strong></td>



        <td width="12%"><strong>Unit</strong></td>

        <td width="18%"><strong>Quantity </strong></td>

        </tr>



	  <?php







$final_amt=0;







$pi=0;







$total=0;







$sql3="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.finish_goods_code from batch_raw_material a, item_info i, item_sub_group s where  a.item_id=i.item_id  and i.sub_group_id=s.sub_group_id and a.batch_no='".$batch_no."' and a.final_qty>0 order by i.sub_group_id, i.item_name";







$data3=db_query($sql3);







//echo $sql2;







while($info2=mysqli_fetch_object($data3)){ 







$pi++;





$sl=$pi;







?>







<tr>







        <td valign="top"><?=$sl?></td>



        <td valign="top"  align="left"><?=$info2->sub_group_name;?></td>

        <td align="left" valign="top"><?=$info2->item_name;?></td>

        <td valign="top"><?=$info2->unit_name;?></td>

        <td valign="top"><?=number_format($info2->final_qty,5);?></td>

        </tr>







<? }?>

    </table>	</td>

	</tr>

	

	

	

	

	



<tr>



<td>



      <table width="100%" border="0" bordercolor="#000000" cellspacing="3" cellpadding="3" class="tabledesign1" >







        <tr style=" font-weight:500; letter-spacing:.3px;">

          <td colspan="4" width="100%">&nbsp;</td>

        </tr>

        <?php /*?><tr style="font-size:16px; font-weight:500; letter-spacing:.3px;">







		<td colspan="4">

		

		In Word: <?



		



		$scs =  $tot_total_amt;



			 $credit_amt = explode('.',$scs);



	 if($credit_amt[0]>0){



	 



	 echo convertNumberToWordsForIndia($credit_amt[0]);}



	 if($credit_amt[1]>0){



	 if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;



	 echo  ' & '.convertNumberToWordsForIndia($credit_amt[1]).' paisa. ';}



	 echo ' Only';



		?>.		</td>

          </tr><?php */?>











        <tr>

          <td colspan="4" align="right">&nbsp;</td>

          </tr>

        <tr>

          <td colspan="4" align="right">&nbsp;</td>

        </tr>

        <tr>

          <td colspan="4" align="right">&nbsp;</td>

        </tr>

        <tr>

          <td colspan="4" align="right">&nbsp;</td>

        </tr>

        <tr>

          <td colspan="4" align="right">&nbsp;</td>

        </tr>

        

        

        

        <tr>

          <td colspan="4" align="right">&nbsp;</td>

        </tr>

        <tr>

          <td colspan="4" align="right">&nbsp;</td>

          </tr>

        <tr>



          <td colspan="4" align="right">&nbsp;</td>

          </tr>



		







		







        <tr>

          <td width="25%" align="center"><?=find_a_field('user_activity_management','fname','user_id='.$ms_data->entry_by);?></td>

          <td  width="25%" align="center">&nbsp;</td>

          <td width="25%" align="center">&nbsp;</td>

          <td width="25%" align="center">&nbsp;</td>

        </tr>

        <tr>

          <td align="center">-------------------------------</td>

          <td align="center">-------------------------------</td>

          <td align="center">-------------------------------</td>

          <td align="center">-------------------------------</td>

        </tr>

        <tr>

          <td align="center"><strong>Prepared By</strong></td>

          <td align="center"><strong>Production Manager</strong></td>

          <td align="center"><strong>Account's Officer </strong></td>

          <td align="center"><strong>Executive Director</strong></td>

        </tr>

      </table></td>

  </tr>

</table>







</form>







</body>







</html>







