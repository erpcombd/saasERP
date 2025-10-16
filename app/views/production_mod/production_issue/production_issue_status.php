<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Production Issue Line';







do_calander('#fdate');



do_calander('#tdate');







$table = 'purchase_master';



$unique = 'po_no';



$status = 'CHECKED';



$target_url = '../production_issue/production_issue_report.php';







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

  <div class="container-fluid bg-form-titel">
    <div class="row">
      <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
        <div class="form-group row m-0">
          <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date From:</label>
          <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />

          </div>
        </div>

      </div>
      <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
        <div class="form-group row m-0">
          <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To:</label>
          <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
          <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />
          </div>
        </div>

      </div>
      <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
        <div class="form-group row m-0">
          <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Production Line:</label>
          <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
          <select name="line_id" id="line_id" style="width:200px;">
            <? foreign_relation('warehouse','warehouse_id','warehouse_name','','use_type="PL" order by warehouse_name',$_POST['line_id']);?>
		        <option></option>Sss
          </select>

          </div>
        </div>
      </div>

      <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
       
        <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />

      </div>

    </div>
  </div>







  <div class="container-fluid pt-3 p-0 ">



  <? 
if(isset($_POST['submitit'])){

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


if($_POST['line_id']>0)

$con .= 'and a.warehouse_to = "'.$_POST['line_id'].'"';

 $res='select a.pi_no,a.pi_no,a.pi_date,a.remarks as sr_no,i.item_name,a.batch_type as issue_to,a.carried_by,a.entry_at,u.fname as user from production_floor_issue_master a, warehouse c, user_activity_management u, item_info i
where a.item_id=i.item_id and  a.warehouse_from=c.warehouse_id and a.entry_by=u.user_id  '.$con.' group by a.pi_no order by a.pi_no desc';

//echo link_report($res,'production_issue_report.php');
$query = db_query($res);
?>

    <table class="table1  table-striped table-bordered table-hover table-sm">
        <thead class="thead1">
        <tr class="bgc-info">
            <th>Pi No</th>
            <th>Pi Date</th>
            <th>Sr No</th>

            <th>Item Name</th>
            <th>Issue to</th>
            <th>Carried By</th>
            <th>Entry At</th>
            <th>User</th>
            <th>Action</th>


        </tr>
        </thead>

        <tbody class="tbody1">

        <?
        while($row = mysqli_fetch_object($query)){
            ?>

            <tr>
                <td><?=$row->pi_no?></td>
                <td><?=$row->pi_date?></td>
                <td><?=$row->sr_no?></td>
                <td><?=$row->item_name?></td>
                <td><?=$row->issue_to?></td>
                <td><?=$row->carried_by?></td>
                <td><?=$row->entry_at?></td>
                <td><?=$row->user?></td>

                <td>
                  <input type="submit" name="submitit" id="submitit" value="RECEIVED" class="btn1 btn1-submit-input" onclick="custom(<?=$row->pi_no?>);" /></td>

            </tr>

        <? } ?>

        </tbody>
    </table>

    <? } ?>


</div>
</form>
</div>

<?/*>

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







            <? foreign_relation('warehouse','warehouse_id','warehouse_name','','use_type="PL" order by warehouse_name',$_POST['line_id']);?>

		  <option></option>Sss

          </select>



        </strong></td>



        <td rowspan="2" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
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
      </tr>
    </table>



  </form>



  <table width="100%" border="0" cellspacing="0" cellpadding="0">



<tr>



<td><div class="tabledesign2">



<? 



if(isset($_POST['submitit'])){











if($_POST['fdate']!=''&&$_POST['tdate']!='')



$con .= 'and a.pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';







if($_POST['line_id']>0)



$con .= 'and a.warehouse_to = "'.$_POST['line_id'].'"';







 $res='select a.pi_no,a.pi_no,a.pi_date,a.remarks as sr_no,i.item_name,a.batch_type as issue_to,a.carried_by,a.entry_at,u.fname as user from production_floor_issue_master a, warehouse c, user_activity_management u, item_info i
where a.item_id=i.item_id and  a.warehouse_from=c.warehouse_id and a.entry_by=u.user_id  '.$con.' group by a.pi_no order by a.pi_no desc';



echo link_report($res,'production_issue_report.php');







}



?>



</div></td>



</tr>



</table>



</div>




<*/?>


<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>