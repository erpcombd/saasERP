<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Production Receive Line';







do_calander('#fdate');



do_calander('#tdate');







$table = 'production_floor_return_master';



$unique = 'po_no';



$status = 'CHECKED';



$target_url = '../production_return/production_receive_report.php';







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



        <td align="right" bgcolor="#FF9966">Production Line : </td>



        <td colspan="3" bgcolor="#FF9966"><strong>



          <select name="line_id" id="line_id" style="width:200px;">



		  <option></option>



            <? foreign_relation('warehouse','warehouse_id','warehouse_name','','use_type="PL" order by warehouse_name',$_POST['line_id']);?>



          </select>



        </strong></td>



        <td rowspan="2" bgcolor="#FF9966"><strong>



          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>



        </strong></td>



      </tr>



      <tr>



        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>



        <td width="1" bgcolor="#FF9966"><strong>



          <input type="text" name="fdate" id="fdate" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />



        </strong></td>



        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>



        <td width="1" bgcolor="#FF9966"><strong>



          <input type="text" name="tdate" id="tdate" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />



        </strong></td>



      </tr>



    </table>



  </form>



  <table width="80%" border="0" cellspacing="0" cellpadding="0">



<tr>



<td><div class="tabledesign2">



<? 



if(isset($_POST['submitit'])){











if($_POST['fdate']!=''&&$_POST['tdate']!='')



$con .= 'and pr_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';







if($_POST['line_id']>0)



$con2 .= ' and warehouse_from = "'.$_POST['line_id'].'"';







 $res='select pr_no,pr_no,pr_date,remarks,(select warehouse_name from warehouse where warehouse_id=warehouse_from) as warehouse_from,carried_by,received_by,status,production_for,goods_type from production_floor_return_master where 1 '.$con2.$con.'';



echo link_report($res,'production_receive_report.php');







}



?>



</div></td>



</tr>



</table>



</div>







<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>