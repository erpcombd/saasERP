<?php


//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section :::::

$title = 'Car Requisition';			// Page Name and Page Title
$page = "car_req_entry.php";		// PHP File Name
$root = 'transportation';
$table = 'vehicle_requisition';		// Database Table Name Mainly related to this page			
$unique ='req_no';					//Unique id



	//Insert 

	if(isset($_POST['confirmm'])){
		 $sql="INSERT INTO vehicle_requisition (req_no, req_date, v_date, prj_name, person, clnt_prf,clnt_org_name,land, pup, dop, emp_name, mb_no, v_s_t, nop)

		VALUES ('".$_POST['req_no']."', '".$_POST['req_date']."', '".$_POST['v_date']."', '".$_POST['prj_name']."', '".$_POST['person']."', '".$_POST['clnt_prf']."', '".$_POST['clnt_org_name']."','".$_POST['land']."', 
		'".$_POST['pup']."','".$_POST['dop']."','".$_POST['emp_name']."','".$_POST['mb_no']."','".$_POST['v_s_t']."',
		'".$_POST['nop']."')";
		
		$query=db_query($sql);
 
}

?>
<!-- Datatables -->

<!-- page content -->

<div class="right_col" role="main"> <!-- Must not delete it ,this is main design header-->

    <div class="">

        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="openerp openerp_webclient_container">

                    <div class="x_content">

                        <!--edit form -->

                        <style>
                            .button {

                                position: relative;

                                background-color: #04AA6D;

                                border: none;

                                font-size: 28px;

                                color: #FFFFFF;

                                padding: 20px;

                                width: 200px;

                                text-align: center;

                                -webkit-transition-duration: 0.4s;
                                /* Safari */

                                transition-duration: 0.4s;

                                text-decoration: none;

                                overflow: hidden;

                                cursor: pointer;

                            }

                            .button:after {

                                content: "";

                                background: #90EE90;

                                display: block;

                                position: absolute;

                                padding-top: 300%;

                                padding-left: 350%;

                                margin-left: -20px !important;

                                margin-top: -120%;

                                opacity: 0;

                                transition: all 0.8s
                            }

                            .button:active:after {

                                padding: 0;

                                margin: 0;

                                opacity: 1;

                                transition: 0s
                            }

                            tr:nth-child(odd) {
                                background-color: #fafafa !important;

                            }

                            tr:nth-child(Even) {}
                        </style>

                        <form action="?" method="post">


                      <table width="100%" border="0" class="table table-bordered table-sm">
                                <thead>

                                    <tr>
                                        <th colspan="4" class="text-center bg-titel bold pt-2 pb-2">Select Options</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                </tfoot>
                                <tbody>
                                  
                                    <tr>
                                        <td align="right">&nbsp;</td>
                                        <td align="right">
											
                                            <div align="left" for="PBI_GROUP"><strong>Group : </strong>
											</div>
											
                                        </td>
										
                                        <td> <select name="PBI_GROUP" class="form-control" id="PBI_GROUP">
                                                <option></option>

                                                <? foreign_relation('hrm_group','id','group_name',$PBI_GROUP,'1 order by id');?>
											
                                            </select></td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <br />
                                    <tr>
                                        <td colspan="4" align="center" style="text-align: right">
                                            <div align="center">

                                                <input name="create" id="create" value="SHOW" type="submit" class="btn1 btn1-bg-submit">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
							
							
							



    <div class="form-container_large">
        <div class="container-fluid pt-0 p-0">
            <form action="" method="post">
            <div class="row m-0">

                <div class="card">
                    <h4 class="text-center bg-titel bold pt-2 pb-2"> </h4>
                    <div class="card-body">
                        <div class="row m-0">
                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req0">Requisition No : </label>
                                <input name="req_no" type="text" id="car_req0" value="<?=$req_no?>" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req1">Requisition Date : </label>
                                <input name="req_date" type="date" id="car_req1" value="<?=$req_date?>" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req2">Visit Date : </label>
                                <input name="v_date" type="date" id="car_req2" value="<?=$v_date?>" class="form-control">
                            </div>

                            <div class="col-md-8 form-group">
                                <label class="label success" for="car_req3">Project Name : </label>
                                <input name="prj_name" type="text" id="car_req3" value="<?=$prj_name?>" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req4">Client Name : </label>
                                <input name="person" type="text" id="car_req4" value="<?=$person?>" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req5">Client Profession : </label>
                                <input name="clnt_prf" type="text" id="car_req5" value="<?=$clnt_prf?>" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req6">Client Organization Name : </label>
                                <input name="clnt_org_name" type="text" id="car_req6" value="<?=$clnt_org_name?>" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req7">Size of Proposed Land : </label>
                                <input name="land" type="text" id="car_req7" value="<?=$land?>" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req8">Client Pick Up Point : </label>
                                <input name="pup" type="text" id="car_req8" value="<?=$pup?>" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req9">Client Drop Off Point : </label>
                                <input name="dop" type="text" id="car_req9" value="<?=$dop?>" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req10">Employee Name : </label>
                                <input name="emp_name" type="text" id="car_req10" value="<?=$emp_name?>" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req11">Mobile No : </label>
                                <input name="mb_no" type="text" id="car_req11" value="<?=$mb_no?>" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req12">Visit Starting Time : </label>
                                <input name="v_s_t" type="text" id="car_req12" value="<?=$v_s_t?>" class="form-control">
                            </div>


                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req12">Number of Person : </label>
                                <input name="nop" type="text" id="car_req12" value="<?=$nop?>" class="form-control">
                            </div>
                    </div>
                </div>
                </div>


                <div class="card">
                    <h5 class="text-center bg-titel bold pt-2 pb-2">Transport Department Use Only </h5>
                    <div class="card-body">
                        <div class="row m-0">
                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req0">Requisition No : </label>
                                <input name="" type="text" id="car_req0" value="" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req2">Visit Date : </label>
                                <input name="" type="date" id="car_req2" value="" class="form-control">
                            </div>


                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req3">Car Fare : </label>
                                <input name="" type="text" id="car_req3" value="<?=$car_fare?>" class="form-control">
                            </div>


                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req4">Car Model : </label>
                                <input name="" type="text" id="car_req4" value="<?=$car_mod?>" class="form-control">
                            </div>


                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req5">Extra Duty Form : </label>
                                <input name="" type="text" id="car_req5" value="<?=$ex_d_f?>" class="form-control">
                            </div>




                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req6">To : </label>
                                <input name="" type="text" id="car_req6" value="<?=$ex_d_t?>" class="form-control">
                            </div>





                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req7">Form : </label>
                                <input name="" type="text" id="car_req7" value="<?=$form?>" class="form-control">
                            </div>




                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req8">To : </label>
                                <input name="" type="text" id="car_req8" value="<?=$_to?>" class="form-control">
                            </div>



                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req9">Extra Duty Amount : </label>
                                <input name="" type="text" id="car_req9" value="<?=$ex_d_amount?>" class="form-control">
                            </div>




                            <div class="col-md-4 form-group">
                                <label class="label success" for="car_req10">Total Amount : </label>
                                <input name="" type="text" id="car_req10" value="<?=$t_amount?>" class="form-control">
                            </div>



                            <div class="col-md-8 form-group">
                                <label class="label success" for="car_req11">Extra Duty Reasons : </label>
                                <textarea  name="" type="text" id="car_req11" rows="1" value="<?=$note?>" class="form-control"></textarea>
                            </div>


                    </div>



                </div>


                </div>


                <div class="n-form-btn-class col-sm-12">
                    <input class="btn1 btn1-bg-submit xs" name="confirmm" type="submit" id="confirmm" value="Approve">
                </div>


        </div>
       </form>
     </div>
  </div>


<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>
							
							
							
                        </form>
          </div>
      </div>
  </div>

        </div>
<?

$main_content = ob_get_contents();
//
include("../../template/main_layout.php");

?>