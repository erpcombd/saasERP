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





//user id

$u_id=$_SESSION['user']['id'];



$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);





	//Insert 



	if(isset($_POST['confirmm'])){

	

		echo $sql='UPDATE vehicle_requisition SET



		req_no="'.$_POST['req_no'].'", req_date="'.$_POST['req_date'].'", v_date="'.$_POST['v_date'].'", prj_name="'.$_POST['prj_name'].'",person="'.$_POST['person'].'", 

		clnt_prf="'.$_POST['clnt_prf'].'", clnt_org_name="'.$_POST['clnt_org_name'].'",land="'.$_POST['land'].'", pup="'.$_POST['pup'].'", dop="'.$_POST['dop'].'",
		 emp_name="'.$_POST['emp_name'].'", mb_no="'.$_POST['mb_no'].'", v_s_t="'.$_POST['v_s_t'].'", nop="'.$_POST['nop'].'" ,
		 car_fare="'.$_POST['car_fare'].'", car_mod="'.$_POST['car_mod'].'", ex_d_f="'.$_POST['ex_d_f'].'",   ex_d_t="'.$_POST['ex_d_t'].'",   form="'.$_POST['form'].'", 
		 
		 too="'.$_POST['too'].'",   ex_d_amount="'.$_POST['ex_d_amount'].'",    t_amount="'.$_POST['t_amount'].'",  note="'.$_POST['note'].'"
		



		WHERE req_id="'.$_GET['req_id'].'"';



		$query=db_query($sql);		

	

   header("Location:car_req_status.php");

   exit; // Make sure to exit after the redirect



}



//



$car = find_all_field('vehicle_requisition','','req_id="'.$_GET['req_id'].'"');



?>











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



                                <input name="req_no" type="text" id="car_req" value="<?=$car->req_no?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req1">Requisition Date : </label>



                                <input name="req_date" type="date" id="car_req1" value="<?=$car->req_date?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req2">Visit Date : </label>



                                <input name="v_date" type="date" id="car_req2" value="<?=$car->v_date?>" class="form-control">



                            </div>



                            <div class="col-md-8 form-group">



                                <label class="label success" for="car_req3">Project Name : </label>



                                <input name="prj_name" type="text" id="car_req3" value="<?=$car->prj_name?>" class="form-control">



                            </div>



                           <div class="col-md-4 form-group">



                                <label class="label success" for="car_req4">Client Name : </label>



                                <input name="person" type="text" id="car_req4" value="<?=$car->person?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req5">Client Profession : </label>



                                <input name="clnt_prf" type="text" id="car_req5" value="<?=$car->clnt_prf?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req6">Client Organization Name : </label>



                                <input name="clnt_org_name" type="text" id="car_req6" value="<?=$car->clnt_org_name?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req7">Size of Proposed Land : </label>



                                <input name="land" type="text" id="car_req7" value="<?=$car->land?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req8">Client Pick Up Point : </label>



                                <input name="pup" type="text" id="car_req8" value="<?=$car->pup?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req9">Client Drop Off Point : </label>



                                <input name="dop" type="text" id="car_req9" value="<?=$car->dop?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req10">Employee Name : </label>



                                <input name="emp_name" type="text" id="car_req10" value="<?=$car->emp_name?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req11">Mobile No : </label>



                                <input name="mb_no" type="text" id="car_req11" value="<?=$car->mb_no?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req12">Visit Starting Time : </label>



                                <input name="v_s_t" type="text" id="car_req12" value="<?=$car->v_s_t?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req12">Number of Person : </label>



                                <input name="nop" type="text" id="car_req12" value="<?=$car->nop?>" class="form-control">



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



                                <input name="" type="text" id="car_req0" value="<?=$car->req_no;?>" class="form-control">



                            </div>





                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req2">Visit Date : </label>



                                <input name="v_date" type="date" id="car_req2" value="<?=$car->v_date?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req3">Car Fare : </label>



                                <input name="car_fare" type="text" id="car_req3" value="<?=$car->car_fare?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req4">Car Model : </label>



                                <input name="car_mod" type="text" id="car_req4" value="<?=$car->car_mod?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req5">Extra Duty Form : </label>



                                <input name="ex_d_f" type="datetime-local" id="ex_d_f" value="<?=$car->ex_d_f?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req6">Extra Duty To : </label>



                                <input name="ex_d_t" type="datetime-local" id="ex_d_t" value="<?=$car->ex_d_t?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req7">Form : </label>



                                <input name="form" type="text" id="form" value="<?=$car->form?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req8">To : </label>



                                <input name="too" type="text" id="too" value="<?=$car->too?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req9">Extra Duty Amount : </label>



                                <input name="ex_d_amount" type="text" id="ex_d_amount" value="<?=$car->ex_d_amount?>" class="form-control">



                            </div>



                            <div class="col-md-4 form-group">



                                <label class="label success" for="car_req10">Total Amount : </label>



                                <input name="t_amount" type="text" id="t_amount" value="<?=$car->t_amount?>" class="form-control">



                            </div>



                            <div class="col-md-8 form-group">



                                <label class="label success" for="car_req11">Extra Duty Reasons : </label>



                                <textarea  name="note" type="text" id="note" rows="1" value="<?=$car->note?>" class="form-control"></textarea>

                          	</div>

                    	</div>

               	 </div>

           	 </div>

                <div class="n-form-btn-class col-sm-12">

                    <input class="btn1 btn1-bg-submit xs" name="confirmm" type="submit" id="confirmm" value="Confirm and Forward">

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