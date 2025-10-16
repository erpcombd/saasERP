<?php


session_start();


ob_start();



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Upcoming Finished Goods Receive List';





do_calander('#fdate');


do_calander('#tdate');





$table = 'production_floor_issue_master';


$unique = 'pi_no';


$status = 'PENDING';


$target_url = '../recipe/chalan_view_edit_manual.php';





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


        <td width="421">&nbsp;</td>


        <td>&nbsp;</td>


        <td width="470">&nbsp;</td>
      </tr>


      <tr>


        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>


        <td width="202" bgcolor="#FF9966"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="41%"><strong>
                <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" autocomplete="off">
              </strong></td>
              <td width="13%"><div align="center"><strong>To</strong></div></td>
              <td width="46%"><strong>
                <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-01');?>" autocomplete="off">
              </strong></td>
            </tr>
          </table>
          <strong>

          </strong></td>


        <td bgcolor="#FF9966" rowspan="3"><strong>


          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>


        </strong></td>
      </tr>
	  <tr> 
	  
	   <td align="right" bgcolor="#FF9966"><strong>Section For :</strong></td>


        <td width="202" bgcolor="#FF9966" colspan=""><strong>


          <select name="warehouse_to" id="warehouse_to">

	<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_to'],' use_type="PL"');?>
	</select>


        </strong></td>
	  </tr>
	  
	   <tr> 
	  
	   <td align="right" bgcolor="#FF9966"><strong>Batch Type :</strong></td>


        <td width="202" bgcolor="#FF9966" colspan=""><strong>


         <select name="batch_type" id="batch_type">
		 <option></option>
	<option><?=$_POST['batch_type']?></option>
	
	<option>Local</option>
	<option>Foreign</option>
	</select>


        </strong></td>
	  </tr>
    </table>


  </form>


  <table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>


<td><div class="tabledesign2">


<? 


if(isset($_POST['submitit'])){








if($_POST['fdate']!='')


$con .= 'and m.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['batch_type']!=''&&$_POST['batch_type']!='ALL')


$con .= 'and m.batch_type="'.$_POST['batch_type'].'"';

if($_POST['warehouse_to']>0)
$con .= 'and m.warehouse_to = "'.$_POST['warehouse_to'].'"  ';



  $res='select m.pi_date,m.pi_no,m.pi_date, w.warehouse_name, m.batch_type, m.status from production_floor_issue_master m, warehouse w where m.warehouse_to=w.warehouse_id '.$con.' and m.status="UNCHECKED" group by m.pi_date ';
 
 
 
 $query = db_query($res);
 
  while($row = mysqli_fetch_object($query)){
 

?>
<table width="100%" style="text-align: center;">
<tbody>
<tr>
<td style="text-align: center;"><a href="chalan_view_edit_manual.php?pi_date=<?=$row->pi_date?>&&warehouse_to=<?=$_POST['warehouse_to']?>&&batch_type=<?=$_POST['batch_type'];?>" target="_blank" style="display:block;">Pi Date : <?=$row->pi_date?></a></td>
</tr>
</tbody>

</table>



<?
}
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