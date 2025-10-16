<?php



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





$title='Requisition Status';





do_calander('#fdate');


do_calander('#tdate');





$table = 'requisition_master_local';


$unique = 'req_no';


$status = 'UNCHECKED';


$target_url = '../mr_local/mr_print_view.php';





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


    <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>


    <td width="1" bgcolor="#FF9966"><strong>


      <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=$_POST['fdate']?>" />


    </strong></td>


    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>


    <td width="1" bgcolor="#FF9966"><strong>


      <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=$_POST['tdate']?>" />


    </strong></td>


    <td rowspan="4" bgcolor="#FF9966"><strong>


      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>


    </strong></td>
  </tr>


  <tr>
    <td align="right" bgcolor="#FF9966"><strong>
      Section For : 
    </strong></td>
    <td colspan="3" bgcolor="#FF9966"><strong>
      <select name="req_for" id="req_for" style="width:200px;">
	  <option></option>
        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['req_for'],' use_type="PL"');?>
      </select>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>
      <?=$title?>
    </strong></td>
    <td colspan="3" bgcolor="#FF9966"><strong>
      <select name="status" id="status" style="width:200px;">
        <option>
          <?=$_POST['status']?>
          </option>
        <option>UNCHECKED</option>
        <option>CHECKED</option>
        <option>PENDING</option>
        <option>COMPLETE</option>
        <option>STOPPED</option>
        <option>ALL</option>
      </select>
    </strong></td>
  </tr>
  <tr>


    <td align="right" bgcolor="#FF9966"><strong>User Wise: </strong></td>


    <td colspan="3" bgcolor="#FF9966"><strong>


<select name="user_id" id="user_id" style="width:200px;">


<option><?=find_a_field('user_activity_management','fname','1 and user_id='.$_POST['user_id']);?></option>

<? foreign_relation('user_activity_management','user_id','fname',$user_id);?>
</select>


    </strong></td>
    </tr>
</table>





</form>


</div>





<table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>


<td><div class="tabledesign2">


<? 


if(isset($_POST['submitit']))


{

if($_POST['status']!=''&&$_POST['status']!='ALL')
$con .= 'and a.status="'.$_POST['status'].'"';

if($_POST['user_id']!=''){$user_con='and a.edit_by='.$_POST['user_id'];};

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['req_for']>0)
$con .='and a.req_for = "'.$_POST['req_for'].'"';


$res='select a.req_no,count(a.req_no) as t_r from requisition_master_local a,warehouse b,user_activity_management c,user_activity_management d where a.edit_by=d.user_id and a.warehouse_id='.$_SESSION['user']['depot'].' and a.req_for=b.warehouse_id and a.entry_by=c.user_id '.$con.$user_con.' and a.status not in ("MANUAL") order by a.req_no desc';

echo '<button style="margin-left: 300px; text-align: center;">'.link_report($res,'mr_print_view.php').'</button>';


 $res='select a.req_no,a.req_no, a.req_date, b.warehouse_name as Req_For, a.manual_req_no as auto_req,d.fname as entry_by, c.fname as edit_by, a.entry_at,a.status from requisition_master_local a,warehouse b,user_activity_management c,user_activity_management d where a.edit_by=d.user_id and a.warehouse_id='.$_SESSION['user']['depot'].' and a.req_for=b.warehouse_id and a.entry_by=c.user_id '.$con.$user_con.' and a.status not in ("MANUAL") order by a.req_no desc';


echo link_report($res,'mr_print_view.php');


}


?>


</div></td>


</tr>


</table>





<?


$main_content=ob_get_contents();


ob_end_clean();


require_once SERVER_CORE."routing/layout.bottom.php";


?>