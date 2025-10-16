<?php



session_start();



ob_start();



require "../../support/inc.all.php";



$title='PO Return Status';







do_calander('#fdate');



do_calander('#tdate');







$table = 'purchase_master';



$unique = 'po_no';



$status = 'CHECKED';



$target_url = '../local_purchase/po_return_report.php';







if($_REQUEST[$unique]>0)



{



$_SESSION[$unique] = $_REQUEST[$unique];



header('location:'.$target_url);



}







?>



<script language="javascript">



function custom(theUrl)



{



	window.open('<?=$target_url?>?v_no='+theUrl);



}



</script>



<div class="form-container_large">



  <form action="" method="post" name="codz" id="codz">



    <table width="80%" border="0" align="center">



      <tr>



        <td>&nbsp;</td>



        <td colspan="3">&nbsp;</td>



        <td>&nbsp;</td>



      </tr>



      <tr>



        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>



        <td width="1" bgcolor="#FF9966"><strong>



          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />



        </strong></td>



        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>



        <td width="1" bgcolor="#FF9966"><strong>



          <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />



        </strong></td>



        <td bgcolor="#FF9966"><strong>



          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>



        </strong></td>



      </tr>



    </table>



  </form>



  <table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>



<td><div class="tabledesign2">



<? 



if(isset($_POST['submitit'])){











if($_POST['fdate']!=''&&$_POST['tdate']!='')



$con .= 'and a.oi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';







$res='select  a.oi_no,a.oi_no as return_no,a.oi_date as return_date,v.vendor_name, w.warehouse_name as House_name, sum(b.qty) as Quantity,sum(amount) as Amount from purchase_item_return_master a, purchase_item_return_details b, warehouse w, vendor v where a.oi_no=b.oi_no and a.vendor_id=v.vendor_id and a.warehouse_id=w.warehouse_id and a.issue_type = "Purchase Return" '.$con.' group by a.oi_no order by a.oi_no desc';











echo link_report($res,'po_print_view.php');







}



?>



</div></td>



</tr>



</table>



</div>







<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>