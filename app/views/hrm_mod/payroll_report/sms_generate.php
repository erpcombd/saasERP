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







$sqll = 'select * from salary_attendence s,personnel_basic_info p where s.mon="'.$_POST['mon'].'" and s.year="'.$_POST['year'].'"  and p.PBI_ID=s.PBI_ID and p.PBI_JOB_STATUS="In Service" and s.sms=0 and s.pay>0';

$querr = db_query($sqll);







if(isset($_REQUEST['show'])){



$check = find_a_field('salary_attendence','count(PBI_ID)','mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" and sms=0');



if($check>0){

$monthNum  = $_POST['mon'];

$dateObj   = DateTime::createFromFormat('!m', $monthNum);

$monthName = $dateObj->format('F');



//sms

function sms($dest_addr,$sms_text){

 $url = "https://api.mobireach.com.bd/SendTextMessage?Username=aksid&Password=Akhr@2019&From=AKSID_HR";



$fields = array(

    'Username'      => "aksid",

    'Password'      => "Akhr@2020",

    'From'          => "AKSID HR",

    'To'            => $dest_addr,

    'Message'       => $sms_text

);



//open connection

$ch = curl_init();



//set the url, number of POST vars, POST data

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_POST, count($fields));

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));



//execute post

$result = curl_exec($ch);



//close connection

curl_close($ch);



}

//sms

   

   while($data=mysqli_fetch_object($querr)){

   

  

    

   $mobile_no = find_a_field('personnel_basic_info','PBI_MOBILE','PBI_ID='.$data->PBI_ID);

   $other_deduct = $data->other_deduction+$data->other_deductions;

   

     if($data->sms==0){

   //Text Sms



 

            $recipients='88'.$mobile_no.'';

			//$recipients='8801638619180';

			

			$massage  = "Your ".$monthName." Salary \r\n";

			$massage.="Gross: ".number_format($data->gross_salary,0)."\r\n";

			if($data->food_allowance>0 && $data->offday_allowance && $data->sitevisit_allowance>0)

			$massage.="Allowances\r\n";

			if($data->food_allowance>0)

			$massage.="Food: ".number_format($data->food_allowance,0)."\r\n";

			if($data->offday_allowance>0)

			$massage.="Offday: ".number_format($data->offday_allowance,0)."\r\n";

			if($data->sitevisit_allowance>0)

			$massage.="Site Visit : ".number_format($data->sitevisit_allowance,0)."\r\n";

			$massage.="Deductions\r\n";

			if($data->mobile_deduction>0)

			$massage.="Mobile: ".number_format($data->mobile_deduction,0)."\r\n";

			if($data->income_tax>0)

			$massage.="Tax: ".number_format($data->income_tax,0)."\r\n";

			if($data->food_deduction>0)

			$massage.="Food: ".number_format($data->food_deduction,0)."\r\n";

			if($data->advance_install>0)

			$massage.="Advance: ".number_format($data->advance_install,0)."\r\n";

			if($data->absent_deduction>0)

			$massage.="Absent: ".number_format($data->absent_deduction,0)."\r\n";

			if($data->lwp_deduction>0)

			$massage.="LWP: ".number_format($data->lwp_deduction,0)."\r\n";

			if($data->late_deduction>0)

			$massage.="Late: ".number_format($data->late_deduction,0)."\r\n";
			
			if($data->hr_action_amt>0)

			$massage.="Hr Action: ".number_format($data->hr_action_amt,0)."\r\n";
			
			if($data->joining_deduction>0)

			$massage.="Joining Deduction: ".number_format($data->joining_deduction,0)."\r\n";
		    
			if($other_deduct>0)

			$massage.="Others: ".number_format($other_deduct,0)."\r\n";

			$massage.="Net Salary: ".number_format($data->total_payable,0)."\r\n";

			

			



     

	      $sms_result=sms($recipients,$massage);

		  

		 

		  

	

	

 //Text Sms

   $update = 'update salary_attendence set sms=1 where mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" and PBI_ID="'.$data->PBI_ID.'"';

   $upqr = db_query($update);

   $other_deduct = 0;

   

     //$msg = '<span style="color:green; font-weight:bold">Sms Send Successfully</span>';

 

 }

  



   

   

   

   }

  

   }else{

     

	 $msg = '<span style="color:red; font-weight:bold">Sms Already Generated For Everybody</span>';

   

   }

   

}






/*****************************************-------  BONUS SMS GENARATE ------------*****************************************/
$sqll2 = 'select * from salary_bonus s,personnel_basic_info p where s.mon="'.$_POST['mon'].'" and s.year="'.$_POST['year'].'" and p.PBI_ID=s.PBI_ID and p.PBI_JOB_STATUS="In Service" and s.sms=0';

$querrr = db_query($sqll2);



if(isset($_REQUEST['bonus'])){



$check = find_a_field('salary_bonus','count(PBI_ID)','mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" and sms=0');



if($check>0){

$monthNum  = $_POST['mon'];

$yearName  = $_POST['year'];

$dateObj   = DateTime::createFromFormat('!m', $monthNum);

$monthName = $dateObj->format('F');



//sms

function sms($dest_addr,$sms_text){

 $url = "https://api.mobireach.com.bd/SendTextMessage?Username=aksid&Password=Akhr@2019&From=AKSID_HR";



$fields = array(

    'Username'      => "aksid",

    'Password'      => "Akhr@2020",

    'From'          => "AKSID HR",

    'To'            => $dest_addr,

    'Message'       => $sms_text

);



//open connection

$ch = curl_init();



//set the url, number of POST vars, POST data

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_POST, count($fields));

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));



//execute post

$result = curl_exec($ch);



//close connection

curl_close($ch);



}

//sms

   

   while($dataa=mysqli_fetch_object($querrr)){

   $mobile_no = find_a_field('personnel_basic_info','PBI_MOBILE','PBI_ID='.$dataa->PBI_ID);

   //$other_deduct = $data->other_deduction+$data->other_deductions;

   

     if($data->sms==0){

   //Text Sms



 

            $recipients='88'.$mobile_no.'';

			//$recipients='8801638619180';

			

			$massage  = "Your Festival Bonus \r\n";

			if($dataa->bonus_type==1){
			$massage.="Festival Type: Eid-Ul Fitre ".$yearName."\r\n";
			
			}else{
			$massage.="Festival Type: Eid-Ul Adha ".$yearName."\r\n";
			}

			$massage.="Percentage: ".$dataa->bonus_percent."% \r\n";

			$massage.="Festival Bonus Amount: BDT ".number_format($dataa->bonus_amt,0)."\r\n";

			

			
 $sms_result=sms($recipients,$massage);

		  
//Text Sms

   $updatee = 'update salary_bonus set sms=1 where mon="'.$_POST['mon'].'" and year="'.$_POST['year'].'" and PBI_ID="'.$dataa->PBI_ID.'"';

   $upqrr = db_query($updatee);

   $other_deduct = 0;

   

     //$msg = '<span style="color:green; font-weight:bold">Sms Send Successfully</span>';

 }
}

}else{
$msg = '<span style="color:red; font-weight:bold">Sms Already Generated For Everybody</span>';
}

}


?>





<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->

          <div class="">

		  

		  

           

        <div class="clearfix"></div>



            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2>Pay Slip Sms Generate</h2>

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

                              <th colspan="4"><div align="center"><?=$msg; ?></div></th>

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

                        <br />

                        <div style="text-align:center">

						               <input name="show" type="submit" id="show" value="Salary sms Generate" />
									   
									   
									   

                         

                        </div>  <br />

                          <div style="text-align:center"><input name="bonus" class="btn btn-primary" type="submit" id="show" value="Bonus sms Generate" /> </div>

		

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

