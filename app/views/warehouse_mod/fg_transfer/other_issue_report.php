<?php


session_start();


//====================== EOF ===================


//var_dump($_SESSION);


require "../../support/inc.all.php";





$oi_no 		= $_REQUEST['v_no'];








$datas=find_all_field('warehouse_other_issue','s','oi_no='.$oi_no);





$sql1="select b.*, d.DEPT_DESC as requisition_from, p.PBI_NAME as issue_to_p from warehouse_other_issue b, department d, personnel_basic_info p where b.requisition_from= d.DEPT_ID and b.issued_to=p.PBI_ID and b.oi_no = '".$oi_no."'";


$data1=db_query($sql1);





$pi=0;


$total=0;


while($info=mysqli_fetch_object($data1)){ 


$issued_to=$info->issue_to_p;


$oi_details=$info->oi_details;


$oi_subject=$info->oi_subject;

$approved_by=$info->approved_by;


$entry_by=$info->entry_by;


$entry_at=$info->entry_at;


$issue_type=$info->issue_type;


$oi_date=$info->oi_date;


$requisition_from=$info->requisition_from;


}





$sql1="select b.* from warehouse_other_issue_detail b where b.oi_no = '".$oi_no."'";


$data1=db_query($sql1);





$pi=0;


$total=0;


while($info=mysqli_fetch_object($data1)){ 


$pi++;





$order_no[]=$info->order_no;


$qc_by=$info->qc_by;





$item_id[] = $info->item_id;


$rate[] = $info->rate;


$amount[] = $info->amount;






$unit_ctn[] = $info->ctn;
$unit_pcs[] = $info->pcs;

$unit_rate[] =$info->rate;
$unit_amount[] =$info->amount;





$unit_qty[] = $info->qty;

$remarks[] =$info->remarks_details;


$unit_name[] = $info->unit_name;


}





?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">


<head>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<title>.: Other Issue Report :.</title>


<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>


<script type="text/javascript">


function hide()


{


    document.getElementById("pr").style.display="none";


}


</script></head>


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


				<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
				
				 
<tr>
		
		<td rowspan="3" width="30% px" height="" align="right"><img src="title.png" style="width:73%;height:63 px;"/></td>
        <td bgcolor="" style="text-align:center; color:; font-size:30px; font-weight:bold;">ALIN FOOD PRODUCTS LTD.</td>
      </tr>
	  <tr>

        <td  bgcolor="" style="text-align:center; color:; font-size:15px; font-weight:bold;">Factory: 124/1 Luxmipur, Bhairab, Kishoregonj.</td>
      </tr>


      <tr>


        <td bgcolor="" style="text-align:center; color:; font-size:18px; font-weight:bold;" colspan="2"><?php echo $issue_type;?> Report</td>
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


		          <td width="40%" align="right" valign="middle">Issue To  : </td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


		            <tr>


		              <td ><strong><?php echo $issued_to;?></strong>&nbsp;</td>


		              </tr>


		            </table></td>


		          </tr>


		        


		        <tr>


                  <td align="right" valign="middle">From:</td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                      <tr>


                        <td><?php echo $requisition_from;?></td>


                      </tr>


                  </table></td>


		          </tr>


				


				


		        <tr>


		          <td align="right" valign="middle"> Note :</td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


		            <tr>


		              <td><?php echo $oi_subject;?></td>


		              </tr>


		            </table></td>


		          </tr>


				  


				  


				  <tr>


		          <td align="right" valign="middle"> Entry By:</td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


		            <tr>


		              <td width="45%"><?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>


		              <td width="55%"> Time: <?php echo $entry_at;?></td>


		              </tr>


		            </table></td>


		          </tr>


		        </table></td>


			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">


			  <tr>


                <td width="47%" align="right" valign="middle">Issue No :</td>


			    <td width="53%"><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td>&nbsp;<strong><?php echo $oi_no;?></strong></td>


                    </tr>


                </table></td>


				<tr>


				<td align="right" valign="middle">Issue Date : </td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td>&nbsp; <?=date("d M, Y",strtotime($oi_date))?></td>


                    </tr>


                </table></td>


			    </tr>


				<tr>


				<td align="right" valign="middle">Approved By :</td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td><?php echo $approved_by;?></td>
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


<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">


       <tr>


        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>


        <td align="center" bgcolor="#CCCCCC"><strong>Code</strong></td>


        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>





        <td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>


        <td align="center" bgcolor="#CCCCCC"><strong>Rate</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>Ctn</strong></td>
        <td align="center" bgcolor="#CCCCCC"><strong>PCS/KG</strong></td>
		
		 <td align="center" bgcolor="#CCCCCC"><strong>Total Unit </strong></td>
		 <td align="center" bgcolor="#CCCCCC"><strong>Total Amount </strong></td>
		 <td align="center" bgcolor="#CCCCCC"><strong>Remarks</strong></td>
        </tr>


       


<? for($i=0;$i<$pi;$i++){?>


      


      <tr>


        <td align="center" valign="top"><?=$i+1?></td>


        <td align="left" valign="top"><?=$item_id[$i]?></td>


        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>


        <td align="right" valign="top"><?=$unit_name[$i]?></td>


        <td align="right" valign="top"><?=$unit_rate[$i]?></td>
        <td align="right" valign="top"><?=$unit_ctn[$i]?></td>
        <td align="right" valign="top"><?=$unit_pcs[$i]?></td>
		
		<td align="right" valign="top"><?=$unit_qty[$i]; $tot_unit += $unit_qty[$i];?></td>
		<td align="right" valign="top"><?=$unit_amount[$i]; $tot_amt += $unit_amount[$i];?></td>
		<td align="right" valign="top"><?=$remarks[$i]?></td>
        </tr>


<? }?>

	<tr>
	<td colspan="7"><b>Total</b></td>
	<td align="right"><?=number_format($tot_unit,2)?></td>
	<td align="right"> <?=number_format($tot_amt,2)?></td>
	<td>&nbsp;</td>
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
          <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>


          <td><div align="center">Issued By</div></td>

			  <td><div align="center">Received By</div></td>
		
          <td><div align="center">


            <p>Checked By </p>


          </div></td>


          <td><div align="center">Approved By </div></td>
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


