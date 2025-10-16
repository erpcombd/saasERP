<?php



session_start();



ob_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





$title='SR Status change';			// Page Name and Page Title



$do_no = $_REQUEST['do_no'];

$status = $_REQUEST['status'];





if(isset($_REQUEST['do_no'])!='')
{
$sql1 = "update sale_return_master set status = '".$status."' where do_no='".$do_no."'";
db_query($sql1);
}



?><title>Status Change</title>

<? if($do_no>0){ ?>
		<div class="alert alert-success p-2" role="alert">
  			Successfull
		</div>
<!--<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FF66">
      <tr>
        <td><div align="center" class="style2">Successfull </div></td>
      </tr>
</table>-->
<? } ?>



<form action="" method="post">
	<div class="container-fluid bg-form-titel">
				<div class="row">
					<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">SR No</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input name="do_no" type="text" id="do_no" value="<?=$do_no?>" required />
							</div>
						</div>
	
					</div>
					<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Return To</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							   <select name="status" id="status">
	
								   <option value=""></option>
							
								  <option value="MANUAL">MANUAL</option>
							
							
							 </select>
	
							</div>
						</div>
					</div>
	
					<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
						<input name="search" type="submit" id="search" class="btn1 btn1-submit-input" value="CONFIRM" />
					  
					   
					</div>
	
				</div>
			</div>
	</form>




<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>