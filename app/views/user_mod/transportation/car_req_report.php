<?php



@//



//




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title="Car Requisition Report";

$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';



do_calander('#f_date');



do_calander('#t_date');



do_calander('#ppjdb');



do_calander('#ppjda');



if($_POST['mon']!=''){

$mon=$_POST['mon'];}

else{

$mon=date('n');

}



if($_POST['year']!=''){

$year=$_POST['year'];}

else{

$year=date('Y');

}



if(isset($_POST['lock'])){

	$check_sql = 'select 1 from salary_lock where month='.$_POST['mon'].' and year='.$_POST['year'].'';

	

	$check_query = db_query($check_sql);

	$last_check = mysqli_num_rows($check_query );

	

	if($last_check >0){

		echo "<h3 style='text-align:center;background-color:red;color:white;'>This month and Year Salary Exist. Lock down is not possible</h3>";

		}else{

	for($i=0;$i<count($_POST['tr_type']);$i++){

		 $sql = 'INSERT INTO `salary_lock`( `month`, `year`, `job_location`, `salary_amount`, `tr_type`) 

		VALUES ("'.$_POST['mon'].'","'.$_POST['year'].'","'.$_POST['job_location'][$i].'" , "'.$_POST['salary_amount'][$i].'" ,"'.$_POST['tr_type'][$i].'" )';

		

		db_query($sql);

	}

		echo "<h3 style='text-align:center;background-color:green;color:white;'>Salary is been Locked</h3>";

		}

		

		

		



}



?>



<style>



#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;}

#country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}

#country-list li:hover{background:#ece3d2;cursor: pointer;}

#PBI_ID{padding: 10px;border: #a8d4b1 1px solid;}



tr:nth-child(odd){
    background-color: #fafafa !important;
}
tr:nth-child(Even){
    background-color: #fafafa !important;
}
tr td,tr{
    border: 0px !important;
    background-color: #FFFFFF;
}
</style>

<div class="d-flex justify-content-center">
    <form class="n-form1 fo-width pt-4" action="../od_report/master_report.php" autocomplete="off" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report</div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" value="226655" checked="checked" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                      Car Requisition Report (226655)
                    </label>
                </div>
                <!-- <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="226644" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                      Short Leave Report (226644)
                    </label>
                </div> -->
                <!-- <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="201912" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                      OD Report (201912)
                    </label>
                </div> -->
                <? //if($_SESSION['employee_selected'] == 101656 || $_SESSION['employee_selected'] == 921636 || $_SESSION['employee_selected'] == 921638 || $_SESSION['employee_selected'] == 220500693){?>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" value="226655" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                      Pending OD Report (201913)
                    </label>
                </div>
                <!-- <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="232" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                      Performance Appraisal Summary (232)
                    </label>
                </div> -->
            </div>
            <div class="col-sm-7">
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Company :</label>
                  <div class="col-sm-8 p-0">
                    <select name="PBI_ORG" id="PBI_ORG class="form-control">
                      <option></option>
                      <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
                    </select>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Department :</label>
                  <div class="col-sm-8 p-0">
                    <select name="department" id="department" class="form-control">
                      <option></option>
                      <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT,'1 order by DEPT_DESC');?>
                    </select>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Leave Status :</label>
                  <div class="col-sm-8 p-0">
                    <select name="leave_status" id="leave_status" class="form-control">
                      <option><?=$_POST['leave_status']?></option>
                      <option>Granted</option>
                      <option>Not Granted</option>
                      <option>Pending</option>
                    </select>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Project :</label>
                  <div class="col-sm-8 p-0">
                    <select name="project" id="project" class="form-control">
                      <option></option>
                      <? foreign_relation('project','PROJECT_ID','PROJECT_NAME',$project);?>
                    </select>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Gender :</label>
                  <div class="col-sm-8 p-0">
                    <select name="gender" class="form-control">
                      <option selected="selected"></option>
                      <option>Male</option>
                      <option>Female</option>
                    </select>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Job Status :</label>
                  <div class="col-sm-8 p-0">
                    <select name="job_status" class="form-control">
                      <option selected="selected"></option>
                      <option>IN SERVICE</option>
                      <option>NOT IN SERVICE</option>
                    </select>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                  <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Employee ID:</label>
                  <div class="col-sm-8 p-0">
                    <select name="PBI_ID" id="PBI_ID" class="form-control">
                      <option></option>
                      <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$PBI_ID);?>
                    </select>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Month :</label>
                    <div class="col-sm-8 p-0">
                     <input  name="f_date" type="date" id="f_date" value="<?=date('Y-m-01')?>" required autocomplete="off" / class="form-control">
                    </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Year :</label>
                    <div class="col-sm-8 p-0">
                     <input  name="t_date" type="date" id="t_date" value="<?=date('Y-m-01')?>" required autocomplete="off" / class="form-control">
                    </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Month :</label>
                    <div class="col-sm-8 p-0">
                      <select name="mon" id="mon" class="form-control" required>
                        <option value="01" <?=($mon=='1')?'selected':''?>>Jan</option>
                        <option value="02" <?=($mon=='2')?'selected':''?>>Feb</option>
                        <option value="03" <?=($mon=='3')?'selected':''?>>Mar</option>
                        <option value="04" <?=($mon=='4')?'selected':''?>>Apr</option>
                        <option value="05" <?=($mon=='5')?'selected':''?>>May</option>
                        <option value="06" <?=($mon=='6')?'selected':''?>>Jun</option>
                        <option value="07" <?=($mon=='7')?'selected':''?>>Jul</option>
                        <option value="08" <?=($mon=='8')?'selected':''?>>Aug</option>
                        <option value="09" <?=($mon=='9')?'selected':''?>>Sep</option>
                        <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
                        <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
                        <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>
                      </select>
                  </div>
              </div>
              <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Year :</label>
                    <div class="col-sm-8 p-0">
                      <select name="year" id="year" class="form-control" required>
                        <option <?=($year=='2016')?'selected':''?>>2016</option>
                        <option <?=($year=='2017')?'selected':''?>>2017</option>
                        <option <?=($year=='2018')?'selected':''?>>2018</option>
                        <option <?=($year=='2019')?'selected':''?>>2019</option>
                        <option <?=($year=='2020')?'selected':''?>>2020</option>
                        <option <?=($year=='2021')?'selected':''?>>2021</option>
                        <option <?=($year=='2022')?'selected':''?>>2022</option>
                        <option <?=($year=='2023')?'selected':''?>>2023</option>
                        <option <?=($year=='2024')?'selected':''?>>2024</option>
                        <option <?=($year=='2025')?'selected':''?>>2025</option>
                        <option <?=($year=='2026')?'selected':''?>>2026</option>
                        <option <?=($year=='2027')?'selected':''?>>2027</option>
                        <option <?=($year=='2028')?'selected':''?>>2028</option>
                        <option <?=($year=='2029')?'selected':''?>>2029</option>
                        <option <?=($year=='2030')?'selected':''?>>2030</option>
                      </select>
                  </div>
              </div>
            </div>
        </div>
        <div class="n-form-btn-class">
             <input name="submit" type="submit" id="submit" class="btn1 btn1-bg-submit" />
        </div>
    </form>
</div>



<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

<script>

$(document).ready(function(){

	$("#PBI_ID").keyup(function(){

		$.ajax({

		type: "POST",

		url: "auto_com.php",

		data:'keyword='+$(this).val(),

		beforeSend: function(){

			$("#PBI_ID").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");

		},

		success: function(data){

			$("#suggesstion-box").show();

			$("#suggesstion-box").html(data);

			$("#PBI_ID").css("background","#FFF");

		}

		});

	});

});



function selectCountry(val) {

$("#PBI_ID").val(val);

$("#suggesstion-box").hide();

}

</script>



<?



//



//



require_once SERVER_CORE."routing/layout.bottom.php";







?>