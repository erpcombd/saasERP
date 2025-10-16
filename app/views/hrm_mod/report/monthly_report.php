<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$head = '<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';



$title = 'Advance Reporting';



do_calander('#ijdb');
do_calander('#ijda');

do_calander('#ppjdb');
do_calander('#ppjda');

do_calander('#fdate');
do_calander('#tdate');


if ($_POST['mon'] != '') {
  $mon = $_POST['mon'];
} else {

  $mon = date('n');
}

if ($_POST['year'] != '') {

  $year = $_POST['year'];
} else {

  $year = date('Y');
}



?><style type="text/css">
  <!--
  .style1 {

    font-size: 16px;

    color: #C00;

  }
  -->

</style>





<form action="../report/master_report.php" target="_blank" method="post">
  <div class="form-container_large">
    <h4 class="text-center bg-titel bold pt-2 pb-2"> ADVANCE REPORT </h4>
	  
	                            
    <? include('../../common/title_bar_report.php');?>
	 
	 
   <?php /*?> <div class="container-fluid bg-form-titel">
      <div class="row">
		  

			  
		  
        <!--left form-->
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <div class="container n-form2">

            <div class="form-group row m-0 pb-1">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <select name="PBI_ORG" id="PBI_ORG" class="form-control">
                  <option></option>
                  <? foreign_relation('user_group', 'id', 'group_name', $PBI_ORG); ?>

                </select>
              </div>
            </div>
            <div class="form-group row m-0 pb-1">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Group</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <select name="PBI_GROUP" id="PBI_GROUP" class="form-control">

                  <option></option>

                  <? foreign_relation('hrm_group', 'id', 'group_name', $PBI_GROUP, '1 order by id'); ?>

                </select>
              </div>
            </div>
            <div class="form-group row m-0 pb-1">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Branch</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <select name="PBI_BRANCH" id="PBI_BRANCH" class="form-control">

                  <option></option>

                  <? foreign_relation('branch', 'BRANCH_ID', 'BRANCH_NAME', $PBI_BRANCH); ?>

                </select>
              </div>
            </div>
            <div class="form-group row m-0 pb-1">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <input list="pbi" type="text" name="PBI_ID" class="form-control" autocomplete="off" class="form-control">
				  <datalist  id="pbi" >
                      <option></option>
                          <? foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_CODE,"-",PBI_NAME)',$PBI_ID , '1') ;?>
                  </datalist>  
              </div>
            </div>
          </div>
        </div>

        <!--Right form-->
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <div class="container n-form2">


            <div class="form-group row m-0 pb-1">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <select name="department" id="department" class="form-control">

                  <option></option>

                  <? foreign_relation('department', 'DEPT_ID', 'DEPT_DESC', $PBI_DEPART, ' 1 order by DEPT_DESC'); ?>

                </select>
              </div>
            </div>
            <div class="form-group row m-0 pb-1">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Designation</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <select name="PBI_DESIGNATION" class="form-control">

                  <option></option>

                  <? foreign_relation('designation', 'DESG_ID', 'DESG_DESC', $_POST['PBI_DESIGNATION']); ?>

                </select>
              </div>
            </div>
            <div class="form-group row m-0 pb-1">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Status</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <select name="job_status" class="form-control">

                  <option></option>

                  <option>In Service</option>

                  <option>Not In Service</option>

                </select>
              </div>
            </div>




            <div class="form-group row m-0 pb-1">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bonus Type </label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                <select name="bonus_type" class="form-control">

                  <option></option>

                  <option value="1">Eid-Ul-Fitre</option>

                  <option value="2">Eid-Ul-Adha</option>

                </select>
              </div>
            </div>





          </div>
        </div>


      </div>

    </div><?php */?>
    <br />
	  
	  
    <div class="container-fluid bg-form-titel">
      <div class="row">

        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> For Payroll (Month)</label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
              <select name="mon" id="mon" required="required">
                <option value="01" <?= ($mon == '1') ? 'selected' : '' ?>>Jan</option>
                <option value="02" <?= ($mon == '2') ? 'selected' : '' ?>>Feb</option>
                <option value="03" <?= ($mon == '3') ? 'selected' : '' ?>>Mar</option>
                <option value="04" <?= ($mon == '4') ? 'selected' : '' ?>>Apr</option>
                <option value="05" <?= ($mon == '5') ? 'selected' : '' ?>>May</option>
                <option value="06" <?= ($mon == '6') ? 'selected' : '' ?>>Jun</option>
                <option value="07" <?= ($mon == '7') ? 'selected' : '' ?>>Jul</option>
                <option value="08" <?= ($mon == '8') ? 'selected' : '' ?>>Aug</option>
                <option value="09" <?= ($mon == '9') ? 'selected' : '' ?>>Sep</option>
                <option value="10" <?= ($mon == '10') ? 'selected' : '' ?>>Oct</option>
                <option value="11" <?= ($mon == '11') ? 'selected' : '' ?>>Nov</option>
                <option value="12" <?= ($mon == '12') ? 'selected' : '' ?>>Dec</option>
              </select>

            </div>
          </div>
        </div>

        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">For Payroll(Year)</label>

            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
              <select name="year" id="year" required="required">
                <option <?= ($year == '2013') ? 'selected' : '' ?>>2013</option>
                <option <?= ($year == '2014') ? 'selected' : '' ?>>2014</option>
                <option <?= ($year == '2015') ? 'selected' : '' ?>>2015</option>
                <option <?= ($year == '2016') ? 'selected' : '' ?>>2016</option>
                <option <?= ($year == '2017') ? 'selected' : '' ?>>2017</option>
                <option <?= ($year == '2018') ? 'selected' : '' ?>>2018</option>
                <option <?= ($year == '2019') ? 'selected' : '' ?>>2019</option>
                <option <?= ($year == '2020') ? 'selected' : '' ?>>2020</option>
                <option <?= ($year == '2021') ? 'selected' : '' ?>>2021</option>
                <option <?= ($year == '2022') ? 'selected' : '' ?>>2022</option>
                <option <?= ($year == '2023') ? 'selected' : '' ?>>2023</option>
                <option <?= ($year == '2024') ? 'selected' : '' ?>>2024</option>
                <option <?= ($year == '2025') ? 'selected' : '' ?>>2025</option>
                <option <?= ($year == '2026') ? 'selected' : '' ?>>2026</option>
                <option <?= ($year == '2027') ? 'selected' : '' ?>>2027</option>
                <option <?= ($year == '2028') ? 'selected' : '' ?>>2028</option>
                <option <?= ($year == '2029') ? 'selected' : '' ?>>2029</option>
                <option <?= ($year == '2030') ? 'selected' : '' ?>>2030</option>
              </select>
            </div>
          </div>
        </div>

      </div>
    </div>
	<!--<div class="container-fluid bg-form-titel mt-2">
      <div class="row">

        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Start Date :</label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
         <input type="text" id="fdate" name="fdate" class="form-control" placeholder="Start Date" value="<?=date('Y-m-01')?>" />

            </div>
          </div>
        </div>

        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">End Date :</label>

            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
              <input type="text" id="tdate" name="tdate" class="form-control" placeholder=" End Date" value="<?=date('Y-m-d')?>" />
            </div>
          </div>
        </div>

      </div>
    </div> -->
	  
	  
	  
	  
	  
	  
	  
	  
	  
    <br />

	  
	  
	  
	  
    <h4 class="text-center bg-titel bold pt-2 pb-2">
      Select report
    </h4>

    <div class="container-fluid p-0 ">
      <!--            table start hear-->
      <table class="table1  table-striped table-bordered table-hover table-sm">
        <thead class="thead1">
          <tr class="bgc-info">
            <th width="5%"></th>
            <th class="text-left"></th>
            <th width="5%"></th>
            <th class="text-left"></th>
          </tr>
        </thead>
        <tbody class="tbody1">
            
            
           

          <tr>
           
            
           <!--     <td><input type="radio" placeholder="test 2" id="4" id="report" name="report" value="81" /></td>
            <td class="bold" align="left"> <label for="4"> Attendance Summary Portal </label> </td> -->
			<td><input type="radio" placeholder="test 2" id="report" name="report" value="666" checked="checked" /></td>
            <td class="bold" align="left"> <label for="666"> Attendence Summary</label> </td>

            
            
            
            
            <td><input type="radio" placeholder="test 2"  id="report" name="report" value="78" /></td>
            <td class="bold" align="left"> <label for="78">Worker Salary Sheet  </label> </td>

          </tr>
         
         


         <!-- <tr>
            <td><input type="radio" placeholder="test 2" id="3" id="report" name="report" value="789" /></td>
            <td class="bold" align="left"> <label for="3">Salary Payroll Report </label> </td>

            <td><input type="radio" placeholder="test 2" id="6" id="report" name="report" value="60" /></td>
            <td class="bold" align="left"> <label for="6">IOM Report</label> </td>
          </tr> -->



          <tr>
		  <td><input type="radio"  placeholder="test 2" id="report" name="report" value="665" /></td>
            <td class="bold" align="left"> <label for="665">Salary Top Sheet</label> </td>
			
			
            

            
            
         <!--    <td><input type="radio" id="788" placeholder="test 2" id="report" name="report" value="788" /></td>
            <td class="bold" align="left"> <label for="788">Bank Salary Bill</label> </td> -->
            
            
            <td><input type="radio"  placeholder="test 2" id="report" name="report" value="662" /></td>
            <td class="bold" align="left"><label for="662">Pay Slip </label> </td>


          </tr>

          <tr>
            <td><input type="radio"  placeholder="test 2" id="report" name="report" value="663" /></td>
            <td class="bold" align="left"><label for="663">Salary Summary Sheet </label> </td>

             <td><input type="radio" placeholder="test 2"  id="report" name="report" value="1011"  /></td>
            <td class="bold" align="left"> <label for="1011"> Basic Information</label> </td>
           
            
          </tr>
          
          
          <tr>
          
			
			 <td><input type="radio" placeholder="test 2" id="report" name="report" value="661" /></td>
            <td class="bold" align="left"> <label for="661">Management Salary Sheet</label> </td>
			
			 <td></td>
            <td > </td>
            
      <!--   <td><input type="radio" placeholder="test 2" id="report" name="report" value="670" /></td>
            <td class="bold" align="left"> <label for="661">Increment Report</label> </td> -->
            
         
            
          </tr>
          
          
           <tr>
		   <!--  <td><input type="radio" placeholder="test 2" id="report" name="report" value="672" /></td>
            <td class="bold" align="left"> <label for="661">Festival Bonus Sheet(Management)</label> </td>
          
			
			 <td><input type="radio" placeholder="test 2" id="report" name="report" value="671" /></td>
            <td class="bold" align="left"> <label for="661">Festival Bonus Sheet(worker)</label> </td> -->
            
         <!--<td><input type="radio" placeholder="test 2" id="report" name="report" value="670" /></td>-->
            <!--<td class="bold" align="left"> <label for="661">Increment Report</label> </td>-->
			
            
          
          </tr>
          
                    
            <tr>
		 <!--    <td><input type="radio" placeholder="test 2" id="report" name="report" value="673" /></td>
            <td class="bold" align="left"> <label for="661">Bonus Summary Sheet</label> </td>
          
			
			 <td><input type="radio" placeholder="test 2" id="report" name="report" value="674" /></td>
           <td class="bold" align="left"> <label for="661">Bonus Top Sheet</label> </td> -->
            
         <!--<td><input type="radio" placeholder="test 2" id="report" name="report" value="670" /></td>-->
            <!--<td class="bold" align="left"> <label for="661">Increment Report</label> </td>-->
			
            
          
          </tr>
         









        </tbody>
      </table>


      <div class="n-form-btn-class">
        <!--            button code hear-->
        <input name="submit" type="submit" class="btn1 btn1-bg-submit" id="submit" value="SHOW" />
      </div>

    </div>
  </div>

</form>







<?php /*?><form action="../report/master_report.php" target="_blank" method="post">



<div class="oe_view_manager oe_view_manager_current">



        



        <div class="oe_view_manager_body">



            



                <div  class="oe_view_manager_view_list"></div>



            



                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">



        <div class="oe_form_buttons"></div>



        <div class="oe_form_sidebar"></div>



        <div class="oe_form_pager"></div>



        <div class="oe_form_container"><div class="oe_form">



          <div class="">



<div class="oe_form_sheetbg">



        <div class="oe_form_sheet oe_form_sheet_width">







          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">



<table width="100%" border="0" class="table table-bordered table-sm"><thead>



<!--<tr class="oe_list_header_columns" style="text-align:center">



  <th colspan="4"><center><span style="text-align: center; font-size:18px; color:#09F">Advance Reporting</span></center></th>



  </tr>-->



<!--<tr class="oe_list_header_columns" style="text-align:center">



  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>



  </tr>-->



</thead><tfoot>



</tfoot><tbody>



  <tr>



    <td align="right" class="alt"><strong>Company :</strong></td>



    <td align="left" class="alt"><span class="oe_form_group_cell">



      <select name="PBI_ORG" style="width:160px;" id="PBI_ORG" class="form-control">



        <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>



      </select>



    </span></td>



    <td width="40%" align="right" class="alt"><strong>Department :</strong></td>



    <td width="10%"><span class="oe_form_group_cell">



      <select name="department" style="width:160px;" id="department" class="form-control">



	   <option></option>



        <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPART,' 1 order by DEPT_DESC');?>



      </select>



    </span></td>



  </tr>



  <tr>



    <td align="right"><strong>Group  :</strong></td>



    <td align="left"><span class="oe_form_group_cell">



      <select name="GROUP" style="width:160px;" id="GROUP" class="form-control">



	  <option></option>



        <? foreign_relation('salary_group','id','group_name',$_POST['GROUP']);?>



      </select>



    </span></td>



    <td align="right"><strong>Designation :</strong></td>



    <td><strong>



      <select name="PBI_DESIGNATION" class="form-control">



	  <option></option>



        <? foreign_relation('designation','DESG_ID','DESG_DESC',$_POST['PBI_DESIGNATION']);?>



      </select>



    </strong></td>



  </tr>



  



  <tr >



    <td align="right"><strong>Branch :</strong></td>



    <td align="left"><span class="oe_form_group_cell">



      <select name="PBI_BRANCH" style="width:160px;" id="PBI_BRANCH" class="form-control">



	  <option></option>



        <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH);?>



      </select>



    </span></td>



    <td align="right"><strong>Job Status :</strong></td>



    <td><span class="oe_form_group_cell">



      <select name="job_status" style="width:160px;" class="form-control">



        <option></option>



        <option>IN SERVICE</option>



        <option>NOT IN SERVICE</option>



      </select>



    </span></td>



  </tr>



  







  <tr >



    <td align="right"><strong>Bonus Type  : </strong></td>



    <td align="left"><strong>



      <select name="bonus_type" style="width:160px;" class="form-control">



	  <option></option>



        <option value="1">Eid-Ul-Fitre</option>



		<option value="2">Eid-Ul-Adha</option>



      </select>



    </strong></td>



    <td align="right"><strong>Employee Code IN:</strong></td>



    <td><input name="pbi_id_in" type="text" id="pbi_id_in" / class="form-control"></td>



  </tr>



  



  <tr class="table-primary">



    <td align="right">(For Payroll) Month  :</td>



    <td align="left"><span class="oe_form_group_cell">



      <select name="mon" style="width:160px;" id="mon" required="required" class="form-control">



        <option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>



        <option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>



        <option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>



        <option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>



        <option value="5" <?=($mon=='5')?'selected':''?>>May</option>



        <option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>



        <option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>



        <option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>



        <option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>



        <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>



        <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>



        <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>



      </select>



    </span></td>



    <td align="right">(For Payroll) Year  :</td>



    <td><select name="year" style="width:160px;" id="year" required="required" class="form-control">



      



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



    </select></td>



  </tr>



  </tbody></table>

<div style="text-align:center">



<table width="100%" class="table table-bordered table-sm">




  <tbody>



    <tr>



      <td align="center">&nbsp;</td>



      <td align="left"><span class="style1" style="text-decoration:underline;">Personnel Information </span></td>



     



    </tr>



    <tr>



      <td width="4%" align="center"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>



      <td width="44%" align="left"><strong>Basic Information</strong></td>



     



    </tr>



    <tr>



      <td align="center"><input name="report" type="radio" class="radio" value="2" /></td>



      <td align="left"><strong>Employee Salary and Benefits Information</strong></td>



     



    </tr>



    <tr >



      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="3" /></td>



      <td align="left" class="alt"><strong>Monthly Attendence Report</strong></td>



      



    </tr>



    <tr >



      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="78" /></td>



      <td align="left" class="alt"><strong>Salary Payroll Report Final</strong></td>



      



    </tr>



	



	<tr >



      <td align="center" class="alt"><input name="report" type="radio" class="radio" value="79" /></td>



      <td align="left" class="alt"><strong>Salary Payslip</strong></td>



      



    </tr>



   



	  <tr >



	    <td align="center" class="alt">&nbsp;</td>



	    <td class="alt">&nbsp;</td>



	   



	    </tr>



	  <tr>



	    <td align="center" class="alt">&nbsp;</td>



	    <td class="alt" align="left"><span class="style1" style="text-decoration:underline;">Attendance Related Reports </span></td>



	    



	  </tr>



	  <tr>



	    <td align="center" class="alt"><input name="report" type="radio" class="radio" value="80" /></td>



	    <td align="left" class="alt"><strong>Attendance Summary Portal-Remarks</strong></td>



	   



	  </tr>



	  <tr>



	    <td align="center" class="alt"><input name="report" type="radio" class="radio" value="81" /></td>



	    <td align="left" class="alt"><strong>Attendance Summary Portal</strong></td>



	    



	  </tr>



	<tr >



	  <td align="center" class="alt"><input name="report" type="radio" class="radio" value="60" /></td>



	  <td align="left" class="alt"><strong>IOM Report</strong></td>



	 



    </tr>



	<tr >



	  <td align="center" class="alt"><input name="report" type="radio" class="radio" value="61" /></td>



	  <td align="left" class="alt"><strong>Leave Report</strong></td>



	 



	</tr>



	<!--<tr >



	  <td align="center" class="alt"><input name="report" type="radio" class="radio" value="22222" /></td>



	  <td class="alt"><strong>Roster Routine(22222)</strong></td>



	  



	</tr>



	<tr >



	  <td align="center" class="alt"><input name="report" type="radio" class="radio" value="4" /></td>



	  <td class="alt"><strong>Over Time Amount Report(4)</strong></td>



	  



	</tr>-->



	



  </tbody>



</table>



<input name="submit" type="submit" id="submit" class="btn btn-danger" value="SHOW" />



          </div></div></div>



          </div>



    </div>



    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">



      <div class="oe_follower_list"></div>



    </div></div></div></div></div>



    </div></div>



            



        </div>



  </div>



</form><?php */ ?>



<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>