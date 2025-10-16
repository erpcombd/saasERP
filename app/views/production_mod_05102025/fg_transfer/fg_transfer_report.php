<?php


session_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





$oi_no 		= url_decode(str_replace(' ', '+', $_REQUEST['v_no']));








$datas=find_all_field('fg_transfer_master','s','st_no='.$oi_no);





 $sql1="select b.* from fg_transfer_master b where b.st_no = '".$oi_no."'";


$data1=db_query($sql1);





$pi=0;


$total=0;


while($info=mysqli_fetch_object($data1)){ 


$issued_to=$info->warehouse_to;


$oi_details=$info->st_details;




$approved_by=$info->approved_by;


$entry_by=$info->entry_by;


$entry_at=$info->entry_at;


$issue_type=$info->Issue_type;


$oi_date=$info->st_date;


$requisition_from=$info->warehouse_from;


}





$sql1="select b.* from fg_transfer_details b where b.st_no = '".$oi_no."'";


$data1=db_query($sql1);





$pi=0;


$total=0;


while($info=mysqli_fetch_object($data1)){ 


$pi++;














$item_id[] = $info->item_id;


$rate[] = $info->rate;


$amount[] = $info->amount;






$unit_rate[] =$info->rate;
$ctn[]= $info->ctn;
$pcs[]=$info->pcs;
$unit_amount[] =$info->amount;





$unit_qty[] = $info->qty;

$remarks[]=$info->remarks;

$unit_name[] = $info->unit_name;


}





?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">


<head>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<title>.: FG Issue Report :.</title>


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
		
		<td rowspan="3" width="30% px" height="" align="right"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style="width:73%;height:63 px;"/></td>
        <td bgcolor="" style="text-align:center; color:; font-size:30px; font-weight:bold;"><?=find_a_field('project_info','proj_name','proj_id=1')?></td>
      </tr>
	  <tr>

        <td  bgcolor="" style="text-align:center; color:; font-size:15px; font-weight:bold;"><?=find_a_field('project_info','proj_address','proj_id=1')?></td>
      </tr>


      <tr>


        <td bgcolor="" style="text-align:center; color:; font-size:18px; font-weight:bold;" colspan="2">FG Transfer Report</td>
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


		              <td ><strong><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$issued_to);?></strong>&nbsp;</td>


		              </tr>


		            </table></td>


		          </tr>


		        


		        <tr>


                  <td align="right" valign="middle">From:</td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                      <tr>


                        <td><?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$requisition_from);?></td>


                      </tr>


                  </table></td>


		          </tr>


				


				


		        <tr>


		          <td align="right" valign="middle"> Note :</td>


		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


		            <tr>


		              <td><?php echo $oi_details;?></td>


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


				<td align="right" valign="middle">Manual Issue No : </td>


			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">


                    <tr>


                      <td>&nbsp; <?=$datas->manual_req_no;?></td>


                    </tr>


                </table></td>


			    </tr>
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


        <td align="center" bgcolor="#CCCCCC"><strong>Ctn</strong></td>

		
		 <td align="center" bgcolor="#CCCCCC"><strong>Pcs</strong></td>
		 <td align="center" bgcolor="#CCCCCC"><strong>Total Unit </strong></td>
		 <td align="center" bgcolor="#CCCCCC"><strong>Remarks</strong></td>
        </tr>


       


<? for($i=0;$i<$pi;$i++){?>


      


      <tr>


        <td align="center" valign="top"><?=$i+1?></td>


        <td align="left" valign="top"><?=$item_id[$i]?></td>


        <td align="left" valign="top"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>


        <td align="right" valign="top"><?=$unit_name[$i]?></td>


        <td align="right" valign="top"><?=$ctn[$i]; $tot_ctn +=$ctn[$i];?></td>
		
		<td align="right" valign="top"><?=$pcs[$i]; $tot_pcs +=$pcs[$i];?></td>
		<td align="right" valign="top"><?=$unit_qty[$i]; $tot_unit += $unit_qty[$i];?></td>
		<td align="right" valign="top"><?=$remarks[$i]?></td>
        </tr>


<? }?>

	<tr>
	<td colspan="4"><b>Total</b></td>
	<td align="right"><?=number_format($tot_ctn,2)?></td>
	
	<td align="right"><?=number_format($tot_pcs,2)?></td>
	<td align="right"><?=number_format($tot_unit,2)?></td>
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


