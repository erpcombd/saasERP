<?php


session_start();


ob_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Finish Goods Receieved Production';



$tr_type="Show";

$table = 'fg_transfer_master';


$unique = 'st_no';


$status = 'PENDING';


$target_url = '../recipe/fg_issue_receive_local.php';





if($_POST[$unique]>0)


{


$_SESSION[$unique] = $_POST[$unique];


header('location:'.$target_url);


}






$tr_from="Warehouse";
?>




<div class="form-container_large">

		<form action="" method="post" name="codz" id="codz">



			<div class="container-fluid bg-form-titel">

				<div class="row">

					<div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">

						<div class="form-group row m-0">

							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">FG Receieved Production : </label>

							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">

								      <select name="<?=$unique?>" id="<?=$unique?>">


        <? foreign_relation($table,$unique,$unique,$$unique,'status="'.$status.'"');?>


      </select>

							</div>

						</div>



					</div>





					<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center">
   						 <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>

					</div>



				</div>

			</div>



		</form>

	</div>
	
	
	

<?php /*?>
<br />
<br />
<br />
<br /><br />
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


        <? foreign_relation($table,$unique,$unique,$$unique,'status="'.$status.'"');?>


      </select>


    </strong></td>


    <td bgcolor="#FF9966"><strong>


      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>


    </strong></td>


  </tr>


</table>





</form>


</div>

<?php */?>



<?


require_once SERVER_CORE."routing/layout.bottom.php";


?>