<?php


session_start();


ob_start();


require_once "../../../assets/support/inc.all.php";


$title='Upcoming Purchase Order List';





do_calander('#fdate');


do_calander('#tdate');





$table = 'production_floor_issue_master';


$unique = 'pi_no';


$status = 'MANUAL';


$target_url = '../recipe/daily_fg_chalan.php';





if($_REQUEST[$unique]>0)


{


$_SESSION[$unique] = $_REQUEST[$unique];


header('location:'.$target_url);


}





?>


<script language="javascript">


function custom(theUrl)


{


	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);


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


          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" autocomplete="off"  />


        </strong></td>


        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>


        <td width="1" bgcolor="#FF9966"><strong>


          <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />


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


$con .= 'and m.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';





 $res='select m.pi_no,m.pi_no,m.pi_date, w.warehouse_name, m.batch_type, m.status from production_floor_issue_master m, warehouse w where m.warehouse_to=w.warehouse_id '.$con.' and m.status="MANUAL" ';


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


include ("../../template/main_layout.php");


?>