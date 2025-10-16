<?php



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Unfinished CMR List';

$table = 'production_floor_receive_master';


$unique = 'pr_no';


$status = "MANUAL";


$target_url = '../production_receive/production_receive.php';




if(isset($_POST['confirm']))

{

echo '<h1>'.$_POST['pr_no'].'</h1>';

$select = "update production_floor_receive_master set status='COMPLETE' where pr_no=".$_POST['pr_no'];

db_query($select);




}

/*if($_POST[$unique]>0)


{


$_SESSION[$unique] = $_POST[$unique];


header('location:'.$target_url);


}*/





?>
<div class="form-container_large">


<form action="<?=$target_url?>" method="post" name="codz" id="codz">


<table width="80%" border="0" align="center">


  <tr>


    <td>&nbsp;</td>


    <td>&nbsp;</td>


    <td>&nbsp;</td>


  </tr>


  <tr>


    <td>&nbsp;</td>


    <td>&nbsp;</td>


    <td>&nbsp;</td>


  </tr>


  <tr>


    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>


    <td bgcolor="#FF9966"><strong>


      <select name="old_pr_no" id="old_pr_no">
    <?
        $sql = 'select pr_no from production_floor_receive_master where  status="MANUAL" ';
        $rs = db_query($sql);
        while($row=mysqli_fetch_object($rs)){
            echo '<option value="'.$row->pr_no.'">'.$row->pr_no.'</option>';
        }
        ?>
      </select>


    </strong></td>


    <td bgcolor="#FF9966"><strong>


      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>


    </strong></td>


  </tr>


</table>





</form>


</div>





<?


$main_content=ob_get_contents();


ob_end_clean();


require_once SERVER_CORE."routing/layout.bottom.php";


?>