<?php







session_start();







//====================== EOF ===================







//var_dump($_SESSION);








require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";






if($_REQUEST['pi_no']>0)







$pi_no 		= $_REQUEST['pi_no'];



















if(isset($_POST['edit'])){



 $c_id = $_POST['c_id'];







$rejected = $_POST['reject'];



$sq = "UPDATE `purchase_receive` SET `reject`='".$rejected."' where id='".$c_id." ' ";



db_query($sq);







$bb = '<input type="button" value="Done" style="font-size:11px; color: white; background: green; border: 0px;" />';







}















if(isset($_POST['approved'])){



$now = date('Y-m-d H:i:s');





$q = "UPDATE `production_floor_issue_master` SET `status`='COMPLETE', approved_at='".$now."', approved_by='".$_SESSION['user']['id']."'  where pi_no=".$pi_no." ";







$sr = "<button style='background: red; color: white; border-color: green;'>UPDATED</button>";



$status =  find_a_field('production_floor_issue_master','status','pi_no='.$pi_no);


if($status=="MANUAL"){

$item =  find_a_field('production_floor_issue_master','item_id','pi_no='.$pi_no);

$pi_date =  find_a_field('production_floor_issue_master','pi_date','pi_no='.$pi_no);

$batch_qty =  find_a_field('production_floor_issue_master','batch_qty','pi_no='.$pi_no);

		journal_item_control($item,12,$pi_date,$batch_qty,0,'Production Receive',$pi_no,'','',$pi_no);
		db_query($q);
}



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







        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:24px; font-weight:bold;">Alin Foods Products Ltd. </td>







      </tr>

<tr>







        <td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:16px; font-weight:bold;">Finished Goods Issued Challan</td>







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
		          <td align="right" valign="middle">Finish Goods :</td>
		          <td>
		            <table width="100%" border="1" cellspacing="0" cellpadding="3">
                      <tr>
                        <td><?=find_a_field('item_info i, production_floor_issue_master m ','i.item_name','m.item_id=i.item_id');?>
                          &nbsp;</td>
                      </tr>
                    </table></td>
		          </tr>
		        <tr>







		          <td width="40%" align="right" valign="middle">Batch For : </td>







		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">







		            <tr>







		              <td><?=find_a_field('production_floor_issue_master','batch_type','pi_no='.$pi_no);?>&nbsp;</td>
		              </tr>







		            </table></td>
		          </tr>





		        <tr>
                  <td align="right" valign="top"> Section For :</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                      <tr>
                        <td><?=find_a_field('production_floor_issue_master m ,warehouse w','w.warehouse_name',' m.warehouse_to=w.warehouse_id and m.pi_no='.$pi_no);?>
                          &nbsp;</td>
                      </tr>
                  </table></td>
		          </tr>
		        <tr>
                  <td align="right" valign="top"> Carried By :</td>
		          <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                      <tr>
                        <td><?=find_a_field('production_floor_issue_master','carried_by','pi_no='.$pi_no);?>
                          &nbsp;</td>
                      </tr>
                  </table></td>
		          </tr>
		        <tr>







		          <td align="right" valign="top"> Remarks :</td>







                  <td><table width="100%" border="1" cellspacing="0" cellpadding="3">







                      <tr>







                        <td><?=find_a_field('production_floor_issue_master','remarks','pi_no='.$pi_no);?>&nbsp;</td>
                      </tr>







                  </table></td>
		          </tr>

				  

				  <tr>

				  <td colspan="2">

				  

<input name="button" type="button" onclick="hide();window.print();" value="Print" />				  </td>
				  </tr>
		        </table>		      </td>







			<td width="30%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">







			  <tr>







                <td align="right" valign="middle">Pi No:</td>







			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">







                    <tr>







                      <td><strong><?php echo $pi_no;?></strong>&nbsp;</td>
                    </tr>







                </table></td>
			    </tr>







			  <tr>







                <td align="right" valign="middle"> PI Date</td>







			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">







                    <tr>







                      <td><?=find_a_field('production_floor_issue_master','pi_date','pi_no='.$pi_no);?>







                        &nbsp;</td>
                    </tr>







                </table></td>
			    </tr>







			  <tr>







                <td align="right" valign="middle">Batch Qty : </td>







			    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">







                    <tr>







                      <td><?=find_a_field('production_floor_issue_master','batch_qty','pi_no='.$pi_no);?></td>
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



	



<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">







       <tr style="font-size:13px;">







        <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
		<td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>

        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Section For</strong></div></td>
		<td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Batch NO</strong></div></td>
		<td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Batch Type</strong></div></td>
		

        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Unit</strong></div></td>

		<td align="center" bgcolor="#CCCCCC"><div align="center"><strong>FG Qty CTN</strong></div></td>
		
        <td align="center" bgcolor="#CCCCCC"><div align="center"><strong>FG Qty PCS</strong></div></td>
		
        
		
        </tr>







       













<? 
 $select = 'select i.item_name, i.unit_name, m.raw_qty,m.wastage_qty from production_floor_issue_detail m, item_info i where m.item_id=i.item_id and m.pi_no="'.$pi_no.'"';
$sl = 0;
$query = db_query($select);
while($row = mysqli_fetch_object($query)){
 ?>




      <tr style="font-size:12px; height:40px;" <?=($i%2)?'bgcolor="#F7F7F7"':'';?>>







        <td align="center" valign="top"><?=++$sl?></td>







        <td align="left" valign="top"><?=find_a_field('item_info i, production_floor_issue_master m ','i.item_name','m.item_id=i.item_id');?>
                          &nbsp;</td>







        <td align="right" valign="top"><?=find_a_field('production_floor_issue_master m ,warehouse w','w.warehouse_name',' m.warehouse_to=w.warehouse_id and m.pi_no='.$pi_no);?>
                          &nbsp;</td>







        <td align="right" valign="top"><?php echo $pi_no;?>&nbsp;</td>
        <td align="right" valign="top"><?=find_a_field('production_floor_issue_master','batch_type','pi_no='.$pi_no);?>&nbsp;</td>
		<td align="right" valign="top"><?=$row->unit?></td>
		<td align="right" valign="top"><?=find_a_field('production_floor_issue_master','batch_qty','pi_no='.$pi_no);?></td>
		<td align="right" valign="top"><?=$row->wastage_qty?></td>
        </tr>





<? $t_raw_qty +=$row->raw_qty; $t_wastage_qty += $row->wastage_qty;} ?>



  <tr style="font-size:14px;"><td colspan="6" align="center" valign="top"><div align="center"><strong>Total Amount: </strong></div></td>







        <td align="right" valign="top"><span class="style1"> <?=number_format($t_raw_qty,2)?></span></td>
        <td align="right" valign="top"><span class="style1">







          <?=number_format($t_wastage_qty,2)?>







        </span></td>
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







     <!-- <div id="pr">







  <div align="left">













 <input type="submit" value="APPROVED" name="approved" style="margin-top: 20px; float: right; font-size: 15px; background: green; border: 1px solid black; color: white; padding:5px; border-radious: 5px;"> <span style="margin-top: 24px; float: right; margin-right: 20px;"><?=$sr;?></span>



 



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







