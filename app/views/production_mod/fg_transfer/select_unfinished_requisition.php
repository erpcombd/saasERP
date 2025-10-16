<?php



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Warehouse Other Issue';





do_calander('#fdate');


do_calander('#tdate');





$table = 'warehouse_other_issue';


$unique = 'oi_no';


$status = 'APPROVED';


$target_url = '../other_issue/other_issue.php';





if($_REQUEST[$unique]>0)


{


$_SESSION[$unique] = $_REQUEST[$unique];


header('location:'.$target_url);


}





?>


<script language="javascript">


function custom(theUrl)


{


	window.location.assign('<?=$target_url?>?<?=$unique?>='+theUrl);


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


          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" />


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


$con .= 'and oi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';





$res='select oi_no, (select sub_group_name from item_sub_group where sub_group_id=req_category) as category, oi_date, issue_type, status from warehouse_other_issue where status in("MANUAL", "APPROVED")  order by oi_date desc';


echo link_report($res,'other_issue.php');





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