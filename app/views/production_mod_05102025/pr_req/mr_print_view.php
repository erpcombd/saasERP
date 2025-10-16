<?php







session_start();







//====================== EOF ===================







//var_dump($_SESSION);







require "../../support/inc.all.php";







require "../../../engine/tools/class.numbertoword.php";















$req_no 		= $_REQUEST['req_no'];























if($_GET['update']=='Update')







{







	$req_status = $_GET['req_status'];







	$ssql='update requisition_master set status="'.$_GET['req_status'].'" where req_no="'.$req_no.'"';







	db_query($ssql);







}















$sql="select * from requisition_master where  req_no='$req_no'";







$data=db_query($sql);







$all=mysqli_fetch_object($data);























?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">







<html xmlns="http://www.w3.org/1999/xhtml">







<head>







<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />







<title>.: Cash Memo :.</title>







<link href="../../css/invoice.css" type="text/css" rel="stylesheet"/>







<script type="text/javascript">







function hide()







{







    document.getElementById("pr").style.display="none";







}







</script>







</head>







<body>



<table width="100%" border="0" cellspacing="0" cellpadding="0">



        	<tr>



            	<td width="13%" align="right"><img src="<?=SERVER_ROOT?>public/uploads/logo/title.png" width="73%" height="63" /></td>



                <td width="72%"  align="center">



                	<h1>



                	ALIN FOOD PRODUCTS LTD



                    </h1>



                    <h3>Factory: 124/1 Luxmipur, Bhairab, Kishoregonj.</h3>



                    <h2><span align="center" style="border:1px solid #000000; padding:2px;width:180px;">



						Purchase Requisition</span>



					</h2>

					

					<h2>

					<span align="center" style="padding:2px;width:180px; font-size: 14px; text-decoration:underline;">



						Section : <? echo find_a_field('warehouse', 'warehouse_name', 'warehouse_id='.$all->req_for); ?> </span>



					</h2>



               		



                <strong>







		      <? $war=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);







              ?>







		    </strong>



                </td>



                <td width="15%"></td>



            </tr>



			<tr>



                <td align="center" colspan="3">







				</td>







  </tr>



		  <tr>







		    <td align="center" valign="bottom" colspan="3"></td>







  </tr>







</table>



        <div class="line"></div>



       <table width="100%" style="font-size:14px;font-weight:600;">



       <tr><td>



<div style="float:left">



        Requisition  No : <?php echo $all->req_no;?><br />



        Requisition Date: <?php echo date('Y-m-d',strtotime($all->entry_at));?><br />



       



          



          <!--Present Status : <?php //echo $all->status;?><br />-->







      </div>







      <div style="float:right;">



			Manual Requisition No : <?php echo $all->manual_req_no;?><br />



             Location: <?=$war->warehouse_name;?>



      </div>



      </td>



      </tr>







    </table>



<table width="100%" class="" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">







       <thead>

  <tr><th rowspan="1" width="2%"><strong>SL.</strong></th>





		<th width="19%" rowspan="1" ><strong>Product Name</strong></th>



        <th width="29%" rowspan="1" ><strong>Item Description </strong></th>



		<th width="3%" rowspan="1" ><strong> Average Consumption </strong></th>

		<th width="3%" rowspan="1" ><strong> R. Qty</strong></th>



        <th width="5%" rowspan="1" ><strong> Unit</strong></th>



        <th width="7%" rowspan="1" ><strong> Delivery Date</strong></th>



        <th colspan="2" align="center"><strong> 



        <table width="100%">



        <tr><td colspan="2" align="center">Stock</td></tr>



        <tr><td width="28" align="center">C.W.H</td><td width="30" align="center">Floor</td></tr>
        </table>



        </strong></th>



        <th width="8%" rowspan="1" >Pending Qty </th>
        <!--<th width="5%" rowspan="1" ><strong>Last P. Date</strong></th>



		<th width="4%" rowspan="1" ><strong>Last P. Qty</strong></th>-->



        <th width="8%" rowspan="1" ><strong>Remarks</strong></th>
       </thead>



	  <?php







$final_amt=(int)$data1[0];







$pi=0;







$total=0;







$sql2="select * from requisition_order where  req_no='$req_no'";







$data2=db_query($sql2);







//echo $sql2;







while($info=mysqli_fetch_object($data2)){ 







$pi++;





$ss = $info->floor;

$amount=$info->qty*$info->rate;







$total=$total+($info->qty*$info->rate);







$sl=$pi;







$item=find_all_field('item_info','','item_id='.$info->item_id);







$qty=$info->qty;







$qoh=$info->qoh;







$last_p_date=$info->last_p_date;







$last_p_qty=$info->last_p_qty;







$s_time = strtotime('2018-10-01');

$e_time = time();



$diff_month =(int)(($e_time - $s_time)/(60*60*24*30));



?>

      <tr>







        <td valign="top" align="center"><?=$sl;?></td>











        <td align="left" valign="top"><?=$item->item_name?></td>

		 <td align="left" valign="top"><?=$item->item_description?></td>

		 

        <td align="left" valign="top"><? $c_issue=find_a_field('journal_item','sum(item_ex) as ex', 'tr_from="Consumption" and item_id='.$info->item_id);

			if($c_issue=='') {echo "<strong>-</strong>"; }else {echo	number_format($c_issue/$diff_month,2);}?></td>

       



		<td align="right" valign="top"><?=number_format($qty,2,".",",")?></td>



        <td  align="center" ><?=$item->unit_name?></td>



        <td align="center"><? echo substr($info->exp_date,2,10);?></td>



        <td width="30" align="center"><? $s=find_a_field('journal_item j,warehouse w','sum(j.item_in-j.item_ex) as stock_w', ' w.warehouse_id=j.warehouse_id and w.use_type="WH" and j.item_id='.$info->item_id.' group by j.item_id');



			if($s=='') {echo "<strong>-</strong>"; }else {echo	number_format($s,2);}?></td>



		<td width="30" align="center" ><?php /*?><?=$ss; echo " <b>".find_a_field('item_info','unit_name','item_id="'.$info->item_id.'"')."</b>";?><?php> */?>

		

		<? $r=find_a_field('journal_item j,warehouse w','sum(j.item_in-j.item_ex) as stock_w', ' w.warehouse_id=j.warehouse_id and w.use_type="PL" and j.item_id='.$info->item_id);

		if($r==''){echo "<strong>-</strong>";} else {echo	number_format($r,2);}

		?>		</td>



        <td align="right">
			<?


$s_journal =  find_a_field('purchase_master a, purchase_invoice b, purchase_receive c, item_info i, item_sub_group s, item_group g, requisition_master r ,requisition_order rr','sum(c.qty)','r.req_no=rr.req_no and b.req_id=rr.id and  a.po_no=b.po_no and b.id=c.order_no and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and b.item_id=i.item_id  and b.item_id="'.$info->item_id.'"');


$s_req =  find_a_field('requisition_order b,requisition_master a','SUM(b.qty)',' a.req_no=b.req_no and a.status in ("PENDING","CHECKED") and b.item_id='.$info->item_id);

$s_pqty = ($s_req-$s_journal);



if($s_pqty==''){echo "<strong>-</strong>";} else {echo	number_format($s_pqty,2);}
?>
		</td>
        <?php /*?> <td  align="center"><? echo substr($last_p_date,2,10);?></td>







        <td align="right" ><?=$last_p_qty?></td><?php */?>



		<td align="right"><?=$info->remarks?></td>
      </tr>



      



     







<? }?>
</table>



   



    <div>



    	Note : <?php echo $all->req_note;?><br />



    </div>



    <table width="100%">



    <tr>



    	<td></td>



        <td></td>



        <td></td>



        <td></td>



    </tr>



    <tr>



    	<td></td>



        <td></td>



        <td></td>



        <td></td>



    </tr>



    <tr>



    	<td></td>



        <td></td>



        <td></td>



        <td></td>



    </tr>



    <tr>



    	<td height="38"></td>



        <td></td>



        <td></td>



        <td></td>



        <td></td>



    </tr>



     <tr>



    <td width="135" align="center">--------------------------</td>



	<td width="141" align="center">--------------------------</td>



	<td width="120" align="center">--------------------------</td>                  



    <td width="172" align="center">--------------------------</td>



    <td width="172" align="center">--------------------------</td>



  </tr>



  <tr>



  	<td align="center">Prepared By</td>



	<td align="center">Asst.Manager (Store)</td>



	<td align="center">Manager (Store)</td>                    



    <td align="center">Manager(QC)</td>



    <td width="108" align="center">Approved by</td> 



    



  </tr></table>



  



 







<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">







  <tr>







    <td><div class="header">







	<table width="100%" border="0" cellspacing="0" cellpadding="0">



	  <tr>



	    <td>



       		</td>







	  </tr>







    </table>







    </div></td>







  </tr>







  <tr>







    







	<td>	</td>







  </tr>







  <tr>







    <td></td>







  </tr>







  



  <!--<tr>







    <td>















<form action="" method="get">















<table width="100%" border="0" cellspacing="0" cellpadding="0">







  <tr>







    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>







    <td width="100" align="right">Present Status:</td>







    <td width="1">







    







    <select name="req_status">







    <option><?=$all->status;?></option>







    <option>PENDING</option>







    <option>STOPPED</option>







    <option>CANCELED</option>







    <option>COMPLETE</option>







    </select></td>







    <td><input name="update" type="submit" value="Update" /><input type="hidden" name="req_no" id="req_no" value="<?=$req_no?>" /></td>







  </tr>







</table>



</form>







    



    </td>







  </tr>-->



<tr>



	<td>&nbsp;</td>



    <td>&nbsp;</td>



</tr>



  <tr>



	







    <td>Printed By:&nbsp;<?=find_a_field('user_activity_management','fname',' user_id='.$_SESSION['user']['id']) ?></td>











    <td>&nbsp;</td>











  </tr>



  <tr>











    <td>Printed At: <?=date('Y-m-d h:m:s') ?></td>











    <td>&nbsp;</td>











  </tr>



  







</table>



<table>











</table>







</body>







</html>







