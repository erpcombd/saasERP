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



<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->

          <div class="">

		  

		  

           

        <div class="clearfix"></div>



            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

                  

				  

				  	 <div class="openerp openerp_webclient_container">

                

			

				  

				  

                  <div class="x_content">







<form action="../od_report/master_report.php" target="_blank" method="post" autocomplete="off">

  <div class="oe_view_manager oe_view_manager_current">

    <div class="oe_view_manager_body">

      <div  class="oe_view_manager_view_list"></div>

      <div class="oe_view_manager_view_form">

        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

          <div class="oe_form_buttons"></div>

          <div class="oe_form_sidebar"></div>

          <div class="oe_form_pager"></div>

          <div class="oe_form_container">

            <div class="oe_form">

              <div class="">

              

                    <div  class="oe_view_manager_view_list">

                      <div  class="oe_list oe_view">

                        <table width="100%" border="0" class="oe_list_content">

                          <thead>

                            <tr class="oe_list_header_columns">

                              <th colspan="4"><span style="text-align: center; font-size:19px; color:#35b1ea"><center><!--LEAVE & OD MANAGENMENT--></center></span></th>

                            </tr>

                            <tr class="oe_list_header_columns">

                              <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>

                            </tr>

                          </thead>

                          <tfoot>

                          </tfoot>

                          <tbody>

                            <tr>

                              <td align="right" class="alt"  style="font-size:16px"><strong>Company :</strong></td>

                              <td align="left" class="alt"><span class="oe_form_group_cell">

                                <select name="PBI_ORG" style="width:160px;" id="PBI_ORG">

                                  <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>

								

                                </select>

                                </span></td>

                              <td width="40%" align="right" class="alt"  style="font-size:16px"><strong>Department :</strong></td>

                              <td width="10%"><span class="oe_form_group_cell">

                                <select name="department" style="width:160px;" id="department">
								<option></option>

                                  <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT,'1 order by DEPT_DESC');?>

                                </select>

                                </span></td>

                            </tr>

                            <tr  class="alt">

                              <td align="right"  style="font-size:16px"><strong>Leave Status  :</strong></td>

                              <td align="left"><span class="oe_form_group_cell">

                                <select name="leave_status" style="width:160px;" id="leave_status">

                                 <option><?=$_POST['leave_status']?></option>

								  <option>Granted</option>

								   <option>Not Granted</option>

								   

								    <option>Pending</option>                                

									</select>

                                </span></td>

                               <td align="right"  style="font-size:16px"><strong>Project:</strong></td>
                              <td><span class="oe_form_group_cell">
                                <select name="project" id="project" style="width:160px;">
								<option></option>
                                  <? foreign_relation('project','PROJECT_ID','PROJECT_NAME',$project);?>
                                </select>
                                </span></td>
                            </tr>

                            <tr >

                              <td align="right"  style="font-size:16px"><strong>Gender :</strong></td>

                              <td align="left"><span class="oe_form_group_cell">

                                <select name="gender" style="width:160px;">

                                  <option selected="selected"></option>

                                  <option>Male</option>

                                  <option>Female</option>

                                </select>

                              </span></td>

                              <td align="right"  style="font-size:16px"><strong>Job Status :</strong></td>

                              <td><span class="oe_form_group_cell">

                                <select name="job_status" style="width:160px;">

                                  <option selected="selected"></option>

                                  <option>IN SERVICE</option>

                                  <option>NOT IN SERVICE</option>

                                </select>

                              </span></td>

                            </tr>

                            <tr >
                              <td align="right"  style="font-size:16px"><strong>Employee ID:</strong></td>
                              <td align="left"><span class="oe_form_group_cell">
                                  <select name="PBI_ID" id="PBI_ID" style="width:160px;">
								  <option></option>
                                  <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$PBI_ID);?>
                                </select></span></td>
                              <td align="right"  style="font-size:16px">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>

                        

                         

                          

                            <tr >

                             <td align="right" style="background-color:#35b1ea; color:#FFFFFF; font-size:16px"><span>Month:</span> </td>

                              <td align="left" style="background-color:#35b1ea; font-size:16px"><span class="oe_form_group_cell">
							   <input type="date" name="f_date" id="f_date" />
							  </span></td>

                         <td align="right" style="background-color:#35b1ea; color:#FFFFFF; font-size:16px; "><span style="float:right">Year  :</span></td>

                              <td style="background-color:#35b1ea; font-size:16px;padding-top:4px"><input type="date" name="t_date" id="t_date" /></td>

                            </tr>
							
							<tr >

                             <td align="right" style="background-color:#35b1ea; color:#FFFFFF; font-size:16px"><span>Month:</span> </td>

                              <td align="left" style="background-color:#35b1ea; font-size:16px"><span class="oe_form_group_cell">

                                <select name="mon" style="width:160px;" id="mon" required="required">

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

                                </span></td>

                         <td align="right" style="background-color:#35b1ea; color:#FFFFFF; font-size:16px; "><span style="float:right">Year  :</span></td>

                              <td style="background-color:#35b1ea; font-size:16px;padding-top:4px"><select name="year" style="width:160px;" id="year" required="required">

                               
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

                                </select></td>

                            </tr>

                          </tbody>

                        </table>

                      

                        <div style="text-align:center">

                          <table width="100%" class="oe_list_content">

                            <thead>

                              <tr class="oe_list_header_columns">

                                <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Report</span></th>

                              </tr>

                            </thead>

                            <tfoot>

                            </tfoot>

                            <tbody align="left">

                              

                            

                                

							   <tr>

                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="226655" /></td>

                                <td class="alt"><strong>Car Requisition Report </strong><strong></strong></td>

                                <td align="center">&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>

							  

							  
<!--
							   <tr >

                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="226644" /></td>

                                <td class="alt"><strong>Short Leave Report</strong><strong></strong></td>

                                <td align="center">&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>

							  

							  

							   <tr >

                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="201912" /></td>

                                <td class="alt"><strong>OD Report</strong><strong></strong></td>

                                <td align="center">&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>-->
							  
							   <? //if($_SESSION['employee_selected'] == 101656 || $_SESSION['employee_selected'] == 921636 || $_SESSION['employee_selected'] == 921638 || $_SESSION['employee_selected'] == 220500693){?>
							  
							  <tr >

                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="201913" /></td>

                                <td class="alt"><strong>Pending OD Report</strong><strong></strong></td>

                                <td align="center">&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>
							  
							  
							   
							  
							   

							  <? // } ?>

							<!--  <tr >

                                <td align="center" class="alt"><input name="report" type="radio" class="radio" value="232" /></td>

                                <td class="alt"><strong>Performance Appraisal Summary</strong><strong></strong></td>

                                <td align="center">&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>-->

                             

                              

							   

							 

                               

                              

                            </tbody>

                          </table>

                          <input name="submit" type="submit" id="submit" value="SHOW" class="btn1 btn1-bg-submit" />

                        </div>

                     

                  </div>

                </div>

                <div class="oe_chatter">

                  <div class="oe_followers oe_form_invisible">

                    <div class="oe_follower_list"></div>

                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</form>





</div>







 </tr>

         </tbody>

          </table> 

		   </div>

		   

		   

		   </div>

		    </div>

            </div>

			</div>

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