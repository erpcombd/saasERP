<?php
session_start();
//


require "../../config/inc.all.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

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


if(isset($_REQUEST['lock'])){
//project brief salary to secondary journal
   $sss = 'select proj.PROJECT_DESC,proj.account_ledger ,a.job_location, sum(a.total_payable) as total_amt from salary_attendence a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.PBI_JOB_STATUS="In Service"  and  a.job_location = proj.PROJECT_ID and a.pay>0 GROUP BY proj.PROJECT_ID';
		$query12 = db_query($sss);
		

		
   $date = $_POST['year'].'-'.$_POST['mon'].'-'.'30';
  
   $jv_date = strtotime($date);
   $narration_dr = 'Salary expense for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];
   $narration_cr = 'Salary Payable for the month of ' .$_POST['mon']. ' and year of ' .$_POST['year'];
   $tr_from = 'Payroll';
   $tr_no = date('Ym'.'01');
   $jv_no = next_journal_sec_voucher_id();
   $jv_no1 = next_journal_voucher_id();
   
	$ledger_id_cr = 2063000200000000;
   while($dataaa = mysqli_fetch_object($query12)){
   
   $ledger_id_dr = $dataaa->account_ledger;
   $total_amt = $total_amt+ $dataaa->total_amt;
   
   $insert = 'INSERT INTO `salary_journal`(`department`, `project`, `mon`, `year`, `total_salary`, `total_deduction`, `total_payable`, `entry_at`, `entry_by`, `checked_at`, `cheked_by`) VALUES ("","'.$dataaa->job_location.'","'.$_POST['mon'].'","'.$_POST['year'].'","'.$dataaa->total_amt.'","","","'.$date.'","'.$_SESSION['user']['id'].'","","")';
   $row = db_query($insert);
   
   //add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr, $dataaa->total_amt, '0', $tr_from, $tr_no);
   
  //add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,  $dataaa->total_amt, '0', $tr_from, $tr_no);
   }
   
   
   
//department brief salary to secondary journal

		$sqli11 = 'select dept.DEPT_DESC,dept.account_ledger,a.department, sum(a.total_payable) as total_amt from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].'  and b.PBI_JOB_STATUS="In Service"   and a.department = dept.DEPT_ID and  a.pay>0 and dept.DEPT_ID not in (13)  GROUP BY dept.DEPT_ID  ';
		$query13 = db_query($sqli11);
    while($dataa1 = mysqli_fetch_object($query13)){
	 $ledger_id_dr = $dataa1->account_ledger;
   $total_amt = $total_amt+ $dataa1->total_amt;
   $insert11 = 'INSERT INTO `salary_journal`(`department`, `project`, `mon`, `year`, `total_salary`, `total_deduction`, `total_payable`, `entry_at`, `entry_by`, `checked_at`, `cheked_by`) VALUES ("'.$dataa1->department.'","","'.$_POST['mon'].'","'.$_POST['year'].'","'.$dataa1->total_amt.'","","","'.$date.'","'.$_SESSION['user']['id'].'","","")';
   
   $row = db_query($insert11);
   
   
   //add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_dr, $narration_dr, $dataa1->total_amt, '0', $tr_from, $tr_no);
   //add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_dr, $narration_dr,  $dataa1->total_amt, '0', $tr_from, $tr_no);
    
   
   }
   
   //add_to_sec_journal('Aksid', $jv_no, $jv_date, $ledger_id_cr, $narration_cr, '0', $total_amt, $tr_from, $tr_no);
   
   //add_to_journal('Aksid', $jv_no1, $jv_date, $ledger_id_cr, $narration_cr, '0',  $total_amt, $tr_from, $tr_no);
}

?>

<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->
          <div class="">
		  
		  
           
        <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Salary Lock</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  
				  	 <div class="openerp openerp_webclient_container">
                  
				  
				  
                  <div class="x_content">



<form action="" method="post">
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
                <div class="oe_form_sheetbg">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <div  class="oe_view_manager_view_list">
                      <div  class="oe_list oe_view">
					  
                        <table width="100%" border="0" class="oe_list_content">
                          <thead>
                            <tr class="oe_list_header_columns">
                              <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Salary Posted For Accounts</span></th>
                            </tr>
                          </thead>
                          <tfoot>
                          </tfoot>
                          <tbody>
                            <tr>
                              <td width="24%" align="right" class="alt"><strong>Month  : </strong></td>
                              <td width="35%" align="left" class="alt"><strong>
                              <select name="mon" style="width:160px;" id="mon" required="required">
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
                              </strong></td>
                              
     <td width="29%" align="right" class="alt"><strong>Year </strong>: </td>
                              <td width="12%"><select name="year" style="width:160px;" id="year" required="required">
                                  <option <?=($year=='2017')?'selected':''?>>2017</option>
                                  <option <?=($year=='2018')?'selected':''?>>2018</option>
                                  <option <?=($year=='2019')?'selected':''?>>2019</option>
                                  <option <?=($year=='2020')?'selected':''?>>2020</option>
                                </select></td>
                            </tr>
                            
                          </tbody>
                        </table>
                        <br />
                        <div style="text-align:center">
						               <input name="show" type="submit" id="show" value="SHOW" />
                         
                        </div>
  <?
    if(isset($_POST['show'])){
	
  ?>
  
  <table width="100%" class="oe_list_content">
		   <tr>
		   <td colspan="6"><div align="center">Salary Posted</div></td>
		 </tr>


<?		
		
		
		  $sqli1 = 'select proj.PROJECT_DESC ,a.job_location, sum(a.total_payable) as total_amt from salary_attendence a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].' and b.PBI_JOB_STATUS="In Service"  and  a.job_location = proj.PROJECT_ID and a.pay>0 GROUP BY proj.PROJECT_ID';
		$query1 = db_query($sqli1);$s = 1 ;
		

   while($info1 = mysqli_fetch_object($query1)){
   
?>
       
        <tr style="font-size:10px; padding:3px; ">
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		 
		  
		  <td style="width:250px; font-size:16px;"><?=$info1->PROJECT_DESC?></td>
		 
		   <td style="width:100px"><input type="text" value="<?=$info1->total_amt?>" name="total_salary" id="total_salary" style="width:100px;"/>
		  
		   <input type="hidden" value="<?=$info1->job_location?>" name="project" id="project" />
		   </td>
		  <td>&nbsp; 
		 
			  </td>
			   <td>&nbsp;</td>
			 
         </tr>
		 
		<? } 
		
		
		if($_POST['year']!='')	$con .= " and s.year = '".$_POST['year']."'";
		if($_POST['dept']!='')	$con .= " and s.department = '".$_POST['dept']."'";
		if($_POST['JOB_LOCATION']!='')  $con .= " and s.job_location = '".$_POST['JOB_LOCATION']."'";
		if($_POST['mon']!='')  $con .= " and s.mon = '".$_POST['mon']."'";
		
		 $sqli = 'select dept.DEPT_DESC,a.department, sum(a.total_payable) as total_amt from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon='.$_POST['mon'].' and year='.$_POST['year'].'  and b.PBI_JOB_STATUS="In Service" and a.job_location=0   and a.department = dept.DEPT_ID and  a.pay>0 and dept.DEPT_ID not in (13)  GROUP BY dept.DEPT_ID  ';
		$query = db_query($sqli);$s = 1 ;
		

   while($info = mysqli_fetch_object($query)){
   
?>
        <tr style="font-size:10px; padding:3px; ">
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		 
		  
		  <td style="width:250px; font-size:16px;"><?=$info->DEPT_DESC?></td>
		 
		   <td style="width:100px"><input type="text" value="<?=$info->total_amt?>" name="total_salary" id="total_salary" style="width:100px;"/>
		   
		   <input type="hidden" value="<?=$info->department?>" name="department" id="department" />
		   </td>
		  <td>&nbsp; 
		  
			  </td>
			   <td>&nbsp;</td>
			 
         </tr>
		 <? }  ?>
		  <tr>
		   <td colspan="6">&nbsp;</td>
		 </tr>
		 <tr>
		   
		   <td colspan="6"><div align="center"><input type="submit" name="lock" value="Post" style="width:100px; height:30px" /></div></td>
		 </tr>
        </table>
		
		
		
		
		
		<? }  ?>
		
		
                      </div>
                    </div>
                  </div>
                </div>
                <div class="oe_chatter" style="padding:0px;">
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
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
include_once("../../template/footer.php");
?>
