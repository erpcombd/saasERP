<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Unfinished Quotation';



$table = 'quotation_master';

$unique = 'quotation_no';

$status = 'MANUAL';

$target_url = '../quotation/mr_create.php';



if($_POST[$unique]>0)

{

$_SESSION[$unique] = $_POST[$unique];

header('location:'.$target_url);

}



?>











<div class="form-container_large">

    

    <form action="" method="post" name="codz" id="codz">

            

        <div class="container-fluid bg-form-titel">

            <div class="row">

                

                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">

                    <div class="form-group row m-0">

                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"><?=$title?>:</label>

                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">

                            <select name="<?=$unique?>" id="<?=$unique?>">

       							 <? foreign_relation($table,$unique,$unique,$$unique,'1 and status="'.$status.'" and entry_by="'.$_SESSION['user']['id'].'"');?>

     						 </select>



                        </div>

                    </div>

                </div>



                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">

                    

                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/ >

                </div>



            </div>

        </div>



        

    </form>

</div>















<br /><br />







<?php /*?><div class="form-container_large">

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

        <? foreign_relation($table,$unique,$unique,$$unique,'1 and status="'.$status.'"');?>

      </select>

    </strong></td>

    <td bgcolor="#FF9966" class="pt-2 pb-2"><strong>

      <input type="submit" name="submitit" id="submitit" value="View Detail" class="btn1 btn1-submit-input"/>

    </strong></td>

  </tr>

</table>



</form>

</div><?php */?>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>