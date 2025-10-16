<?php



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Unfinished Batch List';





$table = 'production_floor_issue_master';


$unique = 'pi_no';


$status = 'MANUAL';


$target_url = '../recipe/create_new_batch.php';





if($_POST[$unique]>0)


{


$_SESSION[$unique] = $_POST[$unique];

$line = find_a_field('production_floor_issue_master','warehouse_to','1 and pi_no='.$_POST[$unique]);


//header("location:".$target_url."?line_id=".$line);

echo '<script> window.location="../recipe/create_new_batch.php?pi_no='.$_POST[$unique].'&line_id='.$line.'" </script>';


}

?>



  <div class="form-container_large">

    <form  action="" method="post" name="codz" id="codz">

      <div class="container-fluid bg-form-titel">
        <div class="row">

          <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"><?=$title?>:</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                <select name="<?=$unique?>" id="<?=$unique?>">
                  <option><?=$_SESSION['user']['depot']?></option>
                  <? foreign_relation($table,$unique,$unique,$$unique,'warehouse_from='.$_SESSION['user']['depot'].' and status="'.$status.'"');?>
                </select>

              </div>
            </div>
          </div>

          <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <input type="submit" name="submitit" id="submitit" value="View Detail" class="btn1 btn1-submit-input"/>
          </div>

        </div>
      </div>

    </form>
  </div>









<?/*>
<br>
<br>
<br>
<br>

<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">


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


      <select name="<?=$unique?>" id="<?=$unique?>">

		<option><?=$_SESSION['user']['depot']?></option>
        <? foreign_relation($table,$unique,$unique,$$unique,'warehouse_from='.$_SESSION['user']['depot'].' and status="'.$status.'"');?>


      </select>


    </strong></td>


    <td bgcolor="#FF9966"><strong>


      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>


    </strong></td>


  </tr>


</table>





</form>
</div>

  <*/?>



<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>