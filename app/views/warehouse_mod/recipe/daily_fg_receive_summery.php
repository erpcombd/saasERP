<?php







session_start();







//====================== EOF ===================







//var_dump($_SESSION);








require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";








if($_REQUEST['pi_no']>0)







$pi_no 		= $_REQUEST['pi_no'];






























if(isset($_POST['approved'])){



$now = date('Y-m-d H:i:s');


$pi_date = $_POST['pi_date'];



 
$select = 'select * from production_floor_issue_master where pi_date="'.$pi_date.'" and status="MANUAL"';

$queryy = db_query($select); 

while($row = mysqli_fetch_object($queryy)){

 journal_item_control($row->item_id,12,$pi_date,$row->batch_qty,0,'Production Receive',$row->pi_no,'','',$row->pi_no);


}



$q = "UPDATE `production_floor_issue_master` SET `status`='COMPLETE', approved_at='".$now."', approved_by='".$_SESSION['user']['id']."'  where pi_date='".$pi_date."' and status='MANUAL' ";


db_query($q);




$sr = "<button style='background: red; color: white; border-color: green;'>UPDATED</button>";






		//journal_item_control($item,12,$pi_date,$batch_qty,0,'Production Receive',$pi_no,'','',$pi_no);




}











if(isset($_POST['return'])){







$q = "UPDATE `purchase_receive` SET `pr_status`='RETURNED' where pr_no=".$_REQUEST['v_no']." ";



db_query($q);



$re = "<button style='background: red; color: white; border-color: green;'>UPDATED</button>";



}


























$pi=0;







$total=0;
















?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">







<html xmlns="http://www.w3.org/1999/xhtml">







<head>







<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />







<title>.: Sales Return  Report :.</title>







<link href="../../damage_mod/pages/css/invoice.css" type="text/css" rel="stylesheet"/>







<script type="text/javascript">







function hide()







{







    document.getElementById("pr").style.display="none";







}







function reloadPage() {







location.reload();







}















</script>







<script type="text/javascript" src="../js/paging.js"></script>







<style type="text/css">







<!--







.style1 {font-weight: bold}







-->







</style>







</head>







<body style="font-family:Tahoma, Geneva, sans-serif"><br />











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







        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:24px; font-weight:bold;">Alin Foods Product Ltd.</td>







      </tr>




      <tr>







        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">Finished Goods Issue Challan</td>







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







		    <td width="6%" valign="top">







		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">

				  

				  <tr>

				  <td>

				  

<input name="button" type="button" onclick="hide();window.print();" value="Print" />				  </td>
				  </tr>
		        </table>		      </td>







			<td width="94%" valign="top"><table width="79%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">








			  <tr>







                <td width="18%" align="right" valign="middle"> PI Date</td>







			    <td width="82%"><table width="100%" border="1" cellspacing="0" cellpadding="3">







                    <tr>







                      <td><?=$_GET['pi_date']?>







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



	



<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5" style="margin-top: 100px;">







       <tr style="font-size:13px;">







        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>







        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>






        <td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>






		<td align="center" bgcolor="#CCCCCC"><strong>Batch NO</strong>&nbsp;</td>
		
        <td align="center" bgcolor="#CCCCCC"><strong>Batch CTN</strong>&nbsp;</td>
		
		<td align="center" bgcolor="#CCCCCC"><strong>Batch PCS</strong>&nbsp;</td>
		
		<td align="center" bgcolor="#CCCCCC"><strong>Batch Section</strong>&nbsp;</td>
		
		<td align="center" bgcolor="#CCCCCC"><strong>Batch Type</strong>&nbsp;</td>
		
		<td align="center" bgcolor="#CCCCCC"><strong>Shipment No</strong>&nbsp;</td>
        </tr>







       













<? 
if($_GET['batch_type'] !=''){ $batch='and m.batch_type="'.$_GET['batch_type'].'"';}
if($_GET['warehouse_to']!=''){$warehouse=' and m.warehouse_to="'.$_GET['warehouse_to'].'"';}


 $select = 'select i.item_name, i.unit_name,m.pi_no,m.batch_ctn,m.batch_pcs,w.warehouse_name,m.remarks,m.batch_type from production_floor_issue_master m, item_info i, warehouse w where m.warehouse_to=w.warehouse_id and  m.item_id=i.item_id and m.status="COMPLETE" and m.pi_date="'.$_GET['pi_date'].'"'.$batch.''.$warehouse.'';
$sl = 0;
$query = db_query($select);
while($row = mysqli_fetch_object($query)){
 ?>




      <tr style="font-size:12px; height:40px;" <?=($i%2)?'bgcolor="#F7F7F7"':'';?>>







        <td align="center" valign="top"><?=++$sl?></td>







        <td align="left" valign="top"><?=$row->item_name;?></td>







        <td align="right" valign="top"><?=$row->unit_name?></td>







        <td align="right" valign="top"><?=$row->pi_no?>&nbsp;</td>
		
		<td align="right" valign="top"><?=$row->batch_ctn; $tctn += $row->batch_ctn;?>&nbsp;</td>
		
		<td align="right" valign="top"><?=$row->batch_pcs; $tpcs += $row->batch_pcs;?>&nbsp;</td>
		
		<td align="right" valign="top"><?=$row->warehouse_name;?>&nbsp;</td>
		
		<td align="right" valign="top"><?=$row->batch_type?>&nbsp;</td>
		
		<td align="right" valign="top"><?=$row->remarks?>&nbsp;</td>
        </tr>





<? $t_batch_qty +=$row->batch_qty; } ?>



  <tr style="font-size:14px;"><td colspan="4" align="center" valign="top"><div align="right"><strong>Total Amount: </strong></div></td>







        <td align="right" valign="top"><span class="style1"> <?=number_format($tctn,2)?></span></td>
		
		<td align="right" valign="top"><span class="style1"> <?=number_format($tpcs,2)?></span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		
		<td>&nbsp;</td>
        
		</tr>
    </table></td>







  </tr>







  <tr>







    <td align="center">







    <table width="100%" border="0" cellspacing="0" cellpadding="0">







  <tr>







    <td colspan="2" style="font-size:12px"><em>All goods are checked and confirmed as per Terms.</em></td>
    </tr>







  <tr>







    <td width="50%">&nbsp;</td>







    <td>&nbsp;</td>
  </tr>

  <tr>

  <td></td>

  <td><form action="" method="post">







      <div id="pr">







  <div align="left">









<!--<input type="hidden" name="pi_date" value="<?=$_GET['pi_date']?>" />
<input type="submit" value="APPROVED" name="approved" style="margin-top: 20px; float: right; font-size: 15px; background: green; border: 1px solid black; color: white; padding:5px; border-radious: 5px;" />
<span style="margin-top: 24px; float: right; margin-right: 20px;"><?=$sr;?></span>-->



 



  <!--<input type="submit" value="RETURN" name="return" style="margin-top: 20px; float: right;font-size: 15px; background: #9A0000; border: 1px solid black; color: white; padding:5px; border-radious: 5px;"><span style="margin-top: 24px; float: right; margin-right: 20px;"> <?=$re;?></span>-->
  </div>
</div>



</form></td>
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







          <td>



		    <div align="center">



		   <!--   <?



		  if($pr_status=='UNCHECKED' || $pr_status=='APPROVED' || $pr_status=='CHECKED') echo '<img src="sign/manager store.jpg"  style="width: 170px;">';



		  ?>-->



		      <br />

			  

		      ------------------------<br />



		      Issued By</div></td>



          <td>



		    <div align="center">



		   <!--   <?



		  if($pr_status=='UNCHECKED' || $pr_status=='APPROVED' || $pr_status=='CHECKED') echo '<img src="sign/manager store.jpg"  style="width: 170px;">';



		  ?>-->



		      <br />

			  

		      ------------------------<br />



		      Checked By</div></td>



          <td><div align="center">



		  <!--<?



		  if($pr_status=='APPROVED' || $pr_status=='CHECKED' ) {



		  echo '<img src="sign/QC.jpg"  style="width: 170px;">';



		  }  else{ echo '<br><br><br><br><br>' ;};



		  ?>-->



		      <br />

			  

			 



		  ------------------------<br />Received By</div></td>







          <td><div align="center">



		  



		 <!-- <?



		  if($pr_status=='CHECKED') {echo '<img src="sign/AGM factory.jpg"  style="width: 170px;">';} else{ echo '<br><br><br><br><br>' ;};



		  ?>-->



		      <br />



		  



		  



		  ------------------------<br />Approved by </div></td>
          </tr>
      </table></td>
    </tr>
    </table>







    <div class="footer1"> </div>







    </td>







  </tr>







</table>







</body>







</html>







