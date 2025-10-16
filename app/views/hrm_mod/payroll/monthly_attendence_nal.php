<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';



$title='Final Payroll Proccess';	







/*ini_set('display_errors', 1);



ini_set('display_startup_errors', 1);



error_reporting(E_ALL);*/



//error_reporting(0);



if(isset($_POST['create']))



{



	//$mon=$_POST['mon'];



	$dept=$_POST['dept'];



	//$year=$_POST['year'];



	$bonus=$_POST['bonus'];

	

$year_mon = $_POST['salary_month'];

$data =explode("-",$_POST['salary_month']);

 $year =$data[0];

 $mon = $data[1];

	



	$salary_date = $year.'-'.$mon.'-01';



}else{



$mon=date('n');



$year=date('Y');



}



$days_mon = date('t',strtotime($salary_date));



?>







<script>







function getXMLHTTP() { //fuction to return the xml http object







		var xmlhttp=false;	







		try{







			xmlhttp=new XMLHttpRequest();







		}







		catch(e)	{		







			try{			







				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");



			}



			catch(e){







				try{







				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");







				}







				catch(e1){







					xmlhttp=false;







				}







			}







		}







		 	







		return xmlhttp;







    }



	function delete_value(id)







	{















var PBI_ID=id; // Rent



var fd=(document.getElementById('fd').value)*1; // Other



var td=(document.getElementById('td_'+id).value)*1; // Other



var od=(document.getElementById('od_'+id).value)*1; // Rent + Other



var hd=(document.getElementById('hd_'+id).value)*1; // Paid



var lt=document.getElementById('lt_'+id).value; 



var ab=document.getElementById('ab_'+id).value;



var lv=document.getElementById('lv_'+id).value;



var lwp=document.getElementById('lwp_'+id).value;



var pre=(document.getElementById('pre_'+id).value)*1; // Due



var pay=document.getElementById('pay_'+id).value;

var ot=(document.getElementById('ot_'+id).value)*1;



//var deduction=document.getElementById('deduction_'+id).value;



var benefits=document.getElementById('benefits_'+id).value;







var mon=document.getElementById('mon').value;



var year=document.getElementById('year').value;



var bonus=document.getElementById('bonus').value;











var strURL="monthly_attendence_delete_ajax.php?PBI_ID="+PBI_ID+"&td="+td+"&fd="+fd+"&od="+od+"&hd="+hd+"&lt="+lt+"&ab="+ab+"&lv="+lv+"&lwp="+lwp+"&pre="+pre+"&pay="+pay+"&deduction="+deduction+"&mon="+mon+"&year="+year+"&bonus="+bonus+"&benefits="+benefits+"&ot="+ot;







		var req = getXMLHTTP();







		if (req) {







			req.onreadystatechange = function() {







			







				if (req.readyState == 4) {







					// only if "OK"







					if (req.status == 200) {						







						document.getElementById('divi_'+id).style.display='inline';







						document.getElementById('divi_'+id).innerHTML=req.responseText;						







					} else {







						alert("There was a problem while using XMLHTTP:\n" + req.statusText);







					}







				}				







			}







			







						







			req.open("GET", strURL, true);







			req.send(null);







		}	







}



	function update_value(id)







	{















var PBI_ID=id; // Rent



var fd=(document.getElementById('fd').value)*1; // Other



var td=(document.getElementById('td_'+id).value)*1; // Other



var od=(document.getElementById('od_'+id).value)*1; // Rent + Other



var hd=(document.getElementById('hd_'+id).value)*1; // Paid



var lt=document.getElementById('lt_'+id).value; 



var ab=document.getElementById('ab_'+id).value;



var lv=document.getElementById('lv_'+id).value;



var lwp=document.getElementById('lwp_'+id).value;



var pre=(document.getElementById('pre_'+id).value)*1; // Due



var pay=document.getElementById('pay_'+id).value;



//var deduction=document.getElementById('deduction_'+id).value;



var benefits=document.getElementById('benefits_'+id).value;



//var other_benefits=document.getElementById('other_benefits_'+id).value;



//var dealer_code=document.getElementById('dealer_code_'+id).value;



//var remarks=document.getElementById('remarks_'+id).value;



var ot=(document.getElementById('ot_'+id).value)*1;



var mon=document.getElementById('mon').value;



var year=document.getElementById('year').value;



//var bonus=document.getElementById('bonus').value;



//var pbi_held_up = document.getElementById('pbi_held_up_'+id);











var strURL="monthly_attendence_ajax_nal.php?PBI_ID="+PBI_ID+"&td="+td+"&fd="+fd+"&od="+od+"&hd="+hd+"&lt="+lt+"&ab="+ab+"&lv="+lv+"&lwp="+lwp+"&pre="+pre+"&pay="+pay+"&mon="+mon+"&year="+year+"&benefits="+benefits+"&ot="+ot;







		var req = getXMLHTTP();







		if (req) {







			req.onreadystatechange = function() {







			







				if (req.readyState == 4) {







					// only if "OK"







					if (req.status == 200) {						







						document.getElementById('divi_'+id).style.display='inline';







						document.getElementById('divi_'+id).innerHTML=req.responseText;						







					} else {







						alert("There was a problem while using XMLHTTP:\n" + req.statusText);







					}







				}				







			}







			







						







			req.open("GET", strURL, true);







			req.send(null);







		}	







}







	function cal_all(id)







	{



var PBI_ID=id; // Rent



var td=(document.getElementById('td_'+id).value)*1; // Other



var od=(document.getElementById('od_'+id).value)*1; // Rent + Other



var hd=(document.getElementById('hd_'+id).value)*1; // Paid



var lt=(document.getElementById('lt_'+id).value)*1; 



var ab=(document.getElementById('ab_'+id).value)*1;



var lv=(document.getElementById('lv_'+id).value)*1;



var lwp=(document.getElementById('lwp_'+id).value)*1;



var ot=(document.getElementById('ot_'+id).value)*1;







var ltd=lt; 



var ltdd=ltd;



var pre=td - (od + hd + ab + lv + lwp);



var pay=td - ab  - lwp;



document.getElementById('pay_'+id).value=pay;



document.getElementById('pre_'+id).value=pre;



	}











</script>















	<!--DO create 2 form with table-->

	



	<form action=""  method="post">



		<div class="d-flex justify-content-center">

			<div class="n-form1 fo-width pt-4">

				<div class="container-fluid p-0">

					<div class="row">



						





						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<div class="form-group row m-0 mb-1 pl-3 pr-3">

								<label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Concern Company :   </label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

									<span class="oe_form_group_cell">



										  <select name="PBI_ORG" id="PBI_ORG" class="form-control" required>



											  <?=foreign_relation('user_group','id','group_name',$_POST['PBI_ORG']);?>



										  </select>



									</span>

								</div>

							</div>

						</div>







						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<div class="form-group row m-0 mb-1 pl-3 pr-3">

								<label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department :   </label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

									<select name="dept" id="dept" class="form-control">

										<option></option>

										<?=foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['dept'],' 1 order by DEPT_DESC asc');?>

									</select>



									</span>

								</div>

							</div>

						</div>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



							<div class="form-group row m-0 mb-1 pl-3 pr-3">

									<label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Salary Month :   </label>

									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

										<span class="oe_form_group_cell">

	                            <input type="hidden" name="year" id="year" value="<?=$year;?>"/>
						             	
								 <input type="hidden" id="mon" name="mon" value="<?=$mon?>"/>

											  <select name="salary_month"  id="salary_month" required>
												  <option></option>
												  <?=foreign_relation('salary_months','salary_month','salary_month',$_POST['salary_month'],'1 and status="Active"');?>
											  </select>

	

										</span>

									</div>

								</div>



						</div>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<div class="form-group row m-0 mb-1 pl-3 pr-3">

								<label for="PBI_GROUP" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Group :   </label>

								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

									<span class="oe_form_group_cell">



										  <select name="PBI_GROUP"  id="PBI_GROUP">



											  <option></option>



											  <? foreign_relation('hrm_group','id','group_name',$PBI_GROUP,'1 order by id');?>



										  </select>



									</span>

								</div>

							</div>

							

							

						</div>











					</div>





					<div class="n-form-btn-class">

							<input name="create" type="submit" id="create" value="Attendance Sheet" class="btn1 btn1-bg-submit" />

					</div>



				</div>



			</div>



		</div>



		<div class="container-fluid pt-5 p-0">



			<? if(isset($_POST['create'])){

			

				 $found = find_a_field('salary_months','status','1 and salary_month="'.$year_mon.'"');

				

			if($found=="Active"){

			?>



			<table class="table1  table-striped table-bordered table-hover table-sm" border="1">



				<thead class="thead1">

				<tr class="bgc-info">

					<th>S/L</th>

					<th>Code</th>

					<th>Full Name</th>

					<th>Designation</th>

					<th>Department</th>

					<th>TD</th>

					<th>OD</th>

					<th>HD</th>

					<th>LT</th>

					<th>AB</th>

					<th>LWP</th>

					<th>LV</th>

					<th>Pre</th>

					<th>Pay</th>

					<th>Ot</th>

					<th>Arrear</th>

					<th>&nbsp;</th>

				</tr>

				</thead>



				<tbody  class="tbody1">



				<?



				//$startTime = $days1=mktime(0,0,0,($mon-1),26,$year);



				//$endTime = $days2=mktime(0,0,0,$mon,25,$year);







				$startTime = $days1=mktime(0,0,0,($mon),01,$year);



				$endTime = $days2=mktime(0,0,0,$mon,$days_mon,$year);



				$days_in_month = $days_mon = date('t',$startTime);



				$startTime1 = $days1=mktime(0,0,0,($mon),01,$year);



				$endTime1 = $days2=mktime(0,0,0,$mon,$days_mon,$year);



				$start_date =$starting_date = $startday = date('Y-m-d',$startTime);



				$end_date =$ending_date = $endday = date('Y-m-d',$endTime);



















				for ($i = $startTime1; $i <= $endTime1; $i = $i + 86400) {



					$day   = date('l',$i);



					${'day'.date('N',$i)}++;







//if(isset($$day))



//$$day .= ',"'.date('Y-m-d', $i).'"';



//else



//$$day .= '"'.date('Y-m-d', $i).'"';



				}



				$r_count=${'day5'};



				?>

				<input name="fd" type="hidden" id="fd" value="<?=$r_count;?>" />



				<?











				$holy_day=find_a_field('salary_holy_day','count(holy_day)','holy_day between "'.$year.'-'.$mon.'-'.'01'.'" and "'.$year.'-'.$mon.'-'.$days_mon.'"');



				if($_POST['PBI_BRANCH']!='')	$con .= " and p.PBI_BRANCH = '".$_POST['PBI_BRANCH']."'";



				if($_POST['PBI_ZONE']!='')		$con .= " and PBI_ZONE = '".$_POST['PBI_ZONE']."'";



				if($_POST['PBI_GROUP']!='')		$group .= " and p.PBI_GROUP = '".$_POST['PBI_GROUP']."'";



				if($_POST['PBI_DOMAIN']!='')	$con .= " and PBI_DOMAIN = '".$_POST['PBI_DOMAIN']."'";



				if($_POST['JOB_LOCATION']!='')  $con .= " and JOB_LOCATION = '".$_POST['JOB_LOCATION']."'";



				if($_POST['pbi_id_in']!='')     $con .= " and p.PBI_ID in (".$_POST['pbi_id_in'].")";



				if($_POST['dept']!='')          $con .= " and p.DEPT_ID = '".$_POST['dept']."'";



				//echo $jday=date('d').' <br>';



				//$j_date=date('Y-m-d',mktime(0,0,0,$_POST['mon'],31,$_POST['year']));











				/*$sql = "select p.* from personnel_basic_info p, salary_info s where p.PBI_ID=s.PBI_ID and p.PBI_JOB_STATUS='In Service'  and p.PBI_ORG='".$_POST['PBI_ORG']."' ".$con."



                order by (s.basic_salary+s.consolidated_salary) desc";*/







				 $sql = "select p.* from personnel_basic_info p, salary_info s where p.PBI_ID=s.PBI_ID and p.PBI_JOB_STATUS='In Service'  and p.PBI_ORG='".$_POST['PBI_ORG']."' ".$con.$group."



order by p.PBI_DEPARTMENT,p.PBI_CODE";







				$query = db_query($sql);



				while($info=mysqli_fetch_object($query))



				{



					$leave_days_lv = 0;



					$leave_days_lwp = 0;



					$new_emp_days = 0;



					$new_emp_off = 0;



					$new_emp_holy_day = 0;



					if(strtotime($info->PBI_DOJ)>strtotime($starting_date))



					{



						$new_emp_days =ceil(($endTime - strtotime($info->PBI_DOJ))/(3600*24))+1;



						$new_emp_holy_day=find_a_field('salary_holy_day','count(holy_day)','holy_day between "'.$info->PBI_DOJ.'" and "'.$year.'-'.$mon.'-'.$days_mon.'"');



						${'day5'} = 0 ; for ($i = strtotime($info->PBI_DOJ); $i <= $endTime1; $i = $i + 86400) {$day   = date('l',$i);${'day'.date('N',$i)}++;}



						$new_emp_off=${'day5'};



					}















					if(strtotime($info->PBI_DOJ) > strtotime($startday)){$startday=date('Y-m-d',strtotime($info->PBI_DOJ));}



					else $startday = date('Y-m-d',$startTime);



					$leave_days = 0;







					$lsql = 'select * from hrm_leave_info where PBI_ID="'.$info->PBI_ID.'" and



((s_date<="'.$startday.'" and e_date>="'.$startday.'" and e_date!="0000-00-00") or



(s_date>="'.$startday.'" and e_date<="'.$endday.'" and e_date!="0000-00-00" ) or



(s_date between "'.$startday.'" and "'.$endday.'" and total_days="0.5") or



(s_date<="'.$endday.'" and e_date>="'.$endday.'" and e_date!="0000-00-00"))';



					$qquery = db_query($lsql);



					while($le = mysqli_fetch_object($qquery))



					{



						$leave_day = 0;



						if(($le->s_date<=$startday)&&($le->e_date>=$startday))



						{



							$start_date = $startday;



							if($le->e_date>=$endday) $end_date = $endday;



							else $end_date = $le->e_date;











							$date1=date_create($start_date);



							$date2=date_create($end_date);



							$diff=date_diff($date1,$date2);



							$leave_day = $diff->d +1 ;







							$leave_days = $leave_days + $leave_day;



						}



						elseif(($le->s_date>=$startday)&&($le->e_date<=$endday))



						{



							$start_date = $le->s_date;



							$end_date = $le->e_date;











							$date1=date_create($start_date);



							$date2=date_create($end_date);



							$diff=date_diff($date1,$date2);







							if($le->total_days=='0.5')



								$leave_day = .5 ;



							else $leave_day = $diff->d + 1 ;



							$leave_days = $leave_days + $leave_day;



						}



						elseif(($le->s_date<=$startday)&&($le->e_date>=$endday))



						{



							$start_date = $startday;



							$end_date = $endday;



							$date1=date_create($start_date);



							$date2=date_create($end_date);



							$diff=date_diff($date1,$date2);







							$leave_day = $diff->d +1 ;



							$leave_days = $leave_days + $leave_day;



						}



						elseif(($le->s_date<=$endday)&&($le->e_date>=$endday))



						{



							$start_date = $le->s_date;



							$end_date = $endday;



							$date1=date_create($start_date);



							$date2=date_create($end_date);



							$diff=date_diff($date1,$date2);







							$leave_day = $diff->d +1 ;



							$leave_days = $leave_days + $leave_day;



						}



						else



							echo 'doom';



					}







					$leave_days_lwp = 0;



					$leave_days_lv =  0;



//echo '<br>'.$info->PBI_ID.' - ';



//echo $startday.' - ';



//echo $info->PBI_DUE_DOJ;



					if($startday>$info->PBI_DUE_DOJ)



					{



						$leave_days_lwp = 0;



						$leave_days_lv = $leave_days;}



					else



					{



						$leave_days_lwp = $leave_days;



						$leave_days_lv = 0;}











					$mobile_bills = find_a_field('hrm_moblie_bill','mobile_bill','emp_id="'.$info->PBI_ID.'" and `month`="'.$mon.'" and `year`="'.$year.'" ');



					$other_bill = find_a_field('hrm_other_bill','other_bill','emp_id="'.$info->PBI_ID.'" and `month`="'.$mon.'" and `year`="'.$year.'" ');







					if(@$att->od=='') @$att->od = $r_count;











					$data = find_all_field('salary_attendence','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');



					if($data->td>0)



					{



						$status='Edit';



						$att->status = 0;



						$att->remarks = '';



					}



					else



					{



						if($info->special_attendence==0)



						{



							$att = find_all_field('hrm_attendence_final','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');







						}



						else



						{



							$att->lt = 0;



							$att->ab = 0;



							$att->lv = 0;



							$att->ot = 0;







							$att->pay = $days_mon;



							$att->pre = $days_mon - ($holy_day + $r_count);



						}



						$status='Save';



						$pay = $days_mon;



						$pre = $days_mon - ($holy_day + $r_count);



					}















					?>



					<tr style="font-size:10px; padding:3px; "><td><?=++$S?></td>



						<td><strong><?=$info->PBI_CODE?></strong>



							<input name="dept_<?=$info->PBI_ID?>" type="hidden" id="dept_<?=$info->PBI_ID?>"  value="<?=$info->PBI_DEPARTMENT;?>" />



							<input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>







						<? if ($att->ab > '6' || $data->ab > '6') { ?>



							<td style="color: #FF0000"><b><strong><?=$info->PBI_NAME?></strong></b></td>



						<? }else{ ?>



							<td><strong><?=$info->PBI_NAME?></strong></td>



						<? } ?>



















						<td><? ($data->pbi_designation!='')?$desg_id=$data->pbi_designation:$desg_id=$info->DESG_ID; echo find_a_field('designation','DESG_SHORT_NAME','DESG_ID='.$desg_id)?></td><td><?=$info->PBI_DEPARTMENT; ?> </td>



						<!--<td align="center"><?



						$res = "select concat(a.AREA_NAME,'-',d.dealer_name_e) dealer from area a, dealer_info d where a.AREA_CODE=d.area_code and d.dealer_code=".$data->dealer_code;



						$resq = @db_query($res);



						$res_data = @mysqli_fetch_object($resq); echo $res_data->dealer; ?></td>-->



						<td align="center"><input name="td_<?=$info->PBI_ID?>" type="text" id="td_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;border: 1px solid blue;"



												  value="<? if($data->td==0){if($att->td>0) echo $att->td; else {if($new_emp_days>0) echo $new_emp_days; else echo $days_mon;}} else echo $data->td;?>" size="2" maxlength="2" readonly="readonly" /></td>



						<td align="center"><input name="od_<?=$info->PBI_ID?>" type="text" id="od_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;border: 1px solid blue;" size="2" maxlength="2" value="<?=($data->od=='')?$att->od:$data->od;?>" /></td>



						<td align="center"><input name="hd_<?=$info->PBI_ID?>" type="text" id="hd_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;border: 1px solid blue;" size="2" maxlength="2" value="<?=($data->hd=='')?$att->hd:$data->hd;?>" /></td>



						<td align="center"><input name="lt_<?=$info->PBI_ID?>" type="text" id="lt_<?=$info->PBI_ID?>" style="font-size:10px; width:40px; min-width:40px;border: 1px solid blue;" value="<?=($data->lt=='')?$att->lt:$data->lt;?>" size="2" maxlength="2" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>







						<td align="center">



							<input name="ab_<?=$info->PBI_ID?>" type="text" id="ab_<?=$info->PBI_ID?>" style="font-size:10px; width:40px; min-width:40px;border: 1px solid blue;"



								   value="<?=($data->ab=='')?$att->ab:$data->ab;?>" size="2" maxlength="2"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>











						<td align="center"><input name="lwp_<?=$info->PBI_ID?>" type="text" id="lwp_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:28px;border: 1px solid blue;" value="<?=($data->lwp=='')?$att->lwp:$data->lwp;?>" size="4" maxlength="4"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>



						<td align="center"><input name="lv_<?=$info->PBI_ID?>" type="text" id="lv_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:28px;border: 1px solid blue;" value="<?=($data->lv=='')?$att->lv:$data->lv;?>" size="4" maxlength="4"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>



						

						<td align="center"><input name="pre_<?=$info->PBI_ID?>" type="text" id="pre_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:20px;border: 1px solid blue;" onchange="cal_all(<?=$info->PBI_ID?>)" value="<?=($data->pre=='')?$att->pre:$data->pre;?>" size="2" maxlength="2" readonly="readonly" /></td>



						<td align="center"><input name="pay_<?=$info->PBI_ID?>" type="text" id="pay_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:20px;border: 1px solid blue;" value="<?=($data->pay=='')?$att->pay:$data->pay;?>" size="2" maxlength="2" readonly="readonly" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>



<td align="center"><input name="ot_<?=$info->PBI_ID?>" type="text" id="ot_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:28px;border: 1px solid blue;" value="<?=($data->ot=='')?$att->ot:$data->ot;?>" size="4" maxlength="4"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>



						<!--<td align="center"><input type="checkbox" name="pbi_held_up_<?=$info->PBI_ID?>" id="pbi_held_up_<?=$info->PBI_ID?>"







<? if($data->pbi_held_up==0){if($att->status>0) echo 'CHECKED="CHECKED"';}



						else echo 'CHECKED="CHECKED"'; ?> value="1"/></td>-->







						<!--<td align="center"><input name="remarks_<?=$info->PBI_ID?>" type="text" id="remarks_<?=$info->PBI_ID?>" style="font-size:10px; width:100px; min-width:20px;"



value="<?=($data->remarks=='')?$att->remarks:$data->remarks;?>" size="10" maxlength="50" /></td>-->







						<td align="center"><input name="benefits_<?=$info->PBI_ID?>" type="text" id="benefits_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:20px;border: 1px solid blue;" value="<?=$data->salary_arrear?>" size="8" maxlength="8" /></td>







						<td align="center"><span id="divi_<?=$info->PBI_ID?>">



            <?







			if($status=='Edit')



			{



				if($_SESSION['user']['level']==5||$_SESSION['user']['level']==2)



				{?><input type="button" class="btn1 btn1-bg-submit" name="Button" value="<?=$status?>"  onclick="cal_all(<?=$info->PBI_ID?>), update_value(<?=$info->PBI_ID?>)"/>



					<input type="button" class="btn1 btn1-bg-cancel" name="Button" value="Delete"  onclick="delete_value(<?=$info->PBI_ID?>)"/><?



				}



				else echo 'Saved';



			}



			else



			{



				?><input type="button" class="btn1 btn1-bg-submit"  name="Button" value="<?=$status?>"  onclick="cal_all(<?=$info->PBI_ID?>), update_value(<?=$info->PBI_ID?>)"/><? }?>



          </span>&nbsp;</td>

					</tr>



					<?



				}



				?>



				</tbody>







				<tfoot>



				<tr>



					<td colspan="17" style="background:#ccc;">&nbsp;</td>

				</tr>

				</tfoot>

			</table>





		<? } }?>







		</div>

	</form>





















<?php/*>



	<br>

<br>

<br>

<br>













<form action=""  method="post">



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







          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">



<table width="100%" border="0" class="table table-bordered table-sm"><thead>

</thead><tbody>



<tr  class="table-primary">



    <td align="right"><strong>Year:</strong></td>



    <td>

		<select name="year"  id="year" required="required" class="form-control">



        <option <?=($year=='2020')?'selected':''?>>2020</option>



		<option <?=($year=='2021')?'selected':''?>>2021</option>



		<option <?=($year=='2022')?'selected':''?>>2022</option>



		 <option <?=($year=='2023')?'selected':''?>>2023</option>



		<option <?=($year=='2024')?'selected':''?>>2024</option>



		<option <?=($year=='2025')?'selected':''?>>2025</option>



    </select>

	</td>



	 <td align="right"><strong>Month:&nbsp;</strong></td>



    <td>



     <select name="mon"  id="mon" required="required" class="form-control">



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



    </td>







  </tr>



  <tr >



    <td align="right" class="alt">Concern Company :</td>



    <td align="left" class="alt">

		<span class="oe_form_group_cell">



      <select name="PBI_ORG" style="width:160px;" id="PBI_ORG" class="form-control" required>



        <?=foreign_relation('user_group','id','group_name',$_POST['PBI_ORG']);?>



      </select>



    </span>

	</td>





   <td align="right"><strong>Department:</strong></td>



    <td colspan="3">

		<span class="oe_form_group_cell">



      <select name="dept" style="width:160px;" id="dept" class="form-control">



	    <option></option>



        <?=foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['dept'],' 1 order by DEPT_DESC asc');?>



      </select>



    </span>



	</td>

    </tr>



	<tr >



    <td align="right" class="alt">Branch :</td>



    <td align="left" class="alt">

		<span class="oe_form_group_cell">



      <select name="PBI_BRANCH" style="width:160px;" id="PBI_BRANCH" class="form-control">



	  <option></option>



        <?=foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$_POST['PBI_BRANCH']);?>



      </select>



    </span>

	</td>



    <td align="right"><strong>&nbsp;</strong></td>



    <td colspan="3">&nbsp;</td>



    </tr>



  <!--<tr>



    <td align="right" class="alt">&nbsp;</td>



    <td align="left" class="alt">&nbsp;</td>



    <td align="right"><strong>Region: </strong></td>



    <td><span class="oe_form_group_cell">



      <select name="PBI_BRANCH" id="PBI_BRANCH">



	  	<option></option>



        <?



		foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$_POST['PBI_BRANCH'],' 1 order by BRANCH_NAME');?>



      </select>



    </span></td>



    <td><div align="right"><strong>Zone: </strong></div></td>



    <td><span class="oe_form_group_cell">



      <select name="PBI_ZONE" id="PBI_ZONE">



	  <option></option>



        <?



		foreign_relation('zon','ZONE_CODE','ZONE_NAME',$_POST['PBI_ZONE'],' 1 order by ZONE_NAME');?>



      </select>



    </span></td>



  </tr>-->



  <!--<tr>



    <td align="right"><strong>Bonus Month (?):</strong></td>



    <td align="left"><span class="oe_form_group_cell">



      <select name="bonus" style="width:160px;" id="bonus" required="required">



        <option <?=($bonus=='No')?'selected':''?>>No</option>



        <option <?=($bonus=='Yes')?'selected':''?>>Yes</option>



      </select>



    </span></td>



    <td align="right"><strong>Job Location: </strong></td>



    <td><span class="oe_form_group_cell">



      <select name="JOB_LOCATION" id="JOB_LOCATION">



	  <option></option>



        <? foreign_relation('office_location','ID','LOCATION_NAME',$_POST['JOB_LOCATION'],'1');?>



      </select>



    </span></td>



    <td><div align="right"><strong>Group</strong>:</div></td>



    <td><span class="oe_form_group_cell">



      <select name="PBI_GROUP" id="PBI_GROUP" style="">



	  <option></option>



        <? foreign_relation('product_group','group_name','group_name',$_POST['PBI_GROUP']);?>



      </select>



    </span></td>



  </tr>-->



  <!--<tr>



    <td align="right">&nbsp;</td>



    <td align="left">&nbsp;</td>



    <td align="right">&nbsp;</td>



    <td>&nbsp;</td>



    <td align="right"><strong>PBI ID IN:</strong></td>



    <td><input name="pbi_id_in" type="text" id="pbi_id_in" value="<?=$_POST['pbi_id_in']?>" /></td>



  </tr>-->







  </tbody></table>

<div style="text-align:center">



<table width="100%" class="oe_list_content">

<thead>

<tr class="oe_list_header_columns">

<th colspan="4"><input name="create" type="submit" id="create" value="Attendence Sheet" class="btn1 btn1-bg-submit" /></th>

</tr>

</thead>

</table>

<br />

<div class="oe_form_sheetbg">



        <div class="oe_form_sheet oe_form_sheet_width">







          <div class="oe_view_manager_view_list">







			  <div class="oe_list oe_view">



          <? if(isset($_POST['create'])){?>



		<table class="table1  table-striped table-bordered table-hover table-sm" border="1">



			<thead class="thead1">



				<tr class="bgc-info">



				<th>S/L</th>



				<th>Code</th>



				<th>Full Name</th>



				<th>Designation</th>



				<th>Department</th>



				<th>TD</th>



				<th>OD</th>



				<th>HD</th>



				<th>LT</th>



				<th>AB</th>



				<th>LWP</th>



				<th>LV</th>



				<th>Pre</th>



				<th>Pay</th>



				<th>Arrear</th>



				<th>&nbsp;</th>



				</tr>



			</thead>



        <tbody  class="tbody1">



        <?



//$startTime = $days1=mktime(0,0,0,($mon-1),26,$year);



//$endTime = $days2=mktime(0,0,0,$mon,25,$year);







$startTime = $days1=mktime(0,0,0,($mon),01,$year);



$endTime = $days2=mktime(0,0,0,$mon,$days_mon,$year);



$days_in_month = $days_mon = date('t',$startTime);



$startTime1 = $days1=mktime(0,0,0,($mon),01,$year);



$endTime1 = $days2=mktime(0,0,0,$mon,$days_mon,$year);



$start_date =$starting_date = $startday = date('Y-m-d',$startTime);



$end_date =$ending_date = $endday = date('Y-m-d',$endTime);



















for ($i = $startTime1; $i <= $endTime1; $i = $i + 86400) {



$day   = date('l',$i);



${'day'.date('N',$i)}++;







//if(isset($$day))



//$$day .= ',"'.date('Y-m-d', $i).'"';



//else



//$$day .= '"'.date('Y-m-d', $i).'"';



}



$r_count=${'day5'};



?>



<input name="fd" type="hidden" id="fd" value="<?=$r_count;?>" />



<?











		$holy_day=find_a_field('salary_holy_day','count(holy_day)','holy_day between "'.$year.'-'.$mon.'-'.'01'.'" and "'.$year.'-'.$mon.'-'.$days_mon.'"');



		if($_POST['PBI_BRANCH']!='')	$con .= " and p.PBI_BRANCH = '".$_POST['PBI_BRANCH']."'";



		if($_POST['PBI_ZONE']!='')		$con .= " and PBI_ZONE = '".$_POST['PBI_ZONE']."'";



		if($_POST['PBI_GROUP']!='')		$con .= " and PBI_GROUP = '".$_POST['PBI_GROUP']."'";



		if($_POST['PBI_DOMAIN']!='')	$con .= " and PBI_DOMAIN = '".$_POST['PBI_DOMAIN']."'";



		if($_POST['JOB_LOCATION']!='')  $con .= " and JOB_LOCATION = '".$_POST['JOB_LOCATION']."'";



		if($_POST['pbi_id_in']!='')     $con .= " and p.PBI_ID in (".$_POST['pbi_id_in'].")";



		if($_POST['dept']!='')          $con .= " and p.DEPT_ID = '".$_POST['dept']."'";



		//echo $jday=date('d').' <br>';



		//$j_date=date('Y-m-d',mktime(0,0,0,$_POST['mon'],31,$_POST['year']));











//$//sql = "select p.* from personnel_basic_info p, salary_info s where p.PBI_ID=s.PBI_ID and p.PBI_JOB_STATUS='In Service'  and p.PBI_ORG='".$_POST['PBI_ORG']."' ".$con."



order by (s.basic_salary+s.consolidated_salary) desc";







  $sql = "select p.* from personnel_basic_info p, salary_info s where p.PBI_ID=s.PBI_ID and p.PBI_JOB_STATUS='In Service'  and p.PBI_ORG='".$_POST['PBI_ORG']."' ".$con."



order by p.PBI_DEPARTMENT,p.PBI_ID";







		$query = db_query($sql);



		while($info=mysqli_fetch_object($query))



		{



$leave_days_lv = 0;



$leave_days_lwp = 0;



		$new_emp_days = 0;



		$new_emp_off = 0;



		$new_emp_holy_day = 0;



		if(strtotime($info->PBI_DOJ)>strtotime($starting_date))



		{



		$new_emp_days =ceil(($endTime - strtotime($info->PBI_DOJ))/(3600*24))+1;



		$new_emp_holy_day=find_a_field('salary_holy_day','count(holy_day)','holy_day between "'.$info->PBI_DOJ.'" and "'.$year.'-'.$mon.'-'.$days_mon.'"');



		${'day5'} = 0 ; for ($i = strtotime($info->PBI_DOJ); $i <= $endTime1; $i = $i + 86400) {$day   = date('l',$i);${'day'.date('N',$i)}++;}



		$new_emp_off=${'day5'};



		}















if(strtotime($info->PBI_DOJ) > strtotime($startday)){$startday=date('Y-m-d',strtotime($info->PBI_DOJ));}



else $startday = date('Y-m-d',$startTime);



$leave_days = 0;







$lsql = 'select * from hrm_leave_info where PBI_ID="'.$info->PBI_ID.'" and



((s_date<="'.$startday.'" and e_date>="'.$startday.'" and e_date!="0000-00-00") or



(s_date>="'.$startday.'" and e_date<="'.$endday.'" and e_date!="0000-00-00" ) or



(s_date between "'.$startday.'" and "'.$endday.'" and total_days="0.5") or



(s_date<="'.$endday.'" and e_date>="'.$endday.'" and e_date!="0000-00-00"))';



$qquery = db_query($lsql);



while($le = mysqli_fetch_object($qquery))



{



$leave_day = 0;



if(($le->s_date<=$startday)&&($le->e_date>=$startday))



{



$start_date = $startday;



if($le->e_date>=$endday) $end_date = $endday;



else $end_date = $le->e_date;











$date1=date_create($start_date);



$date2=date_create($end_date);



$diff=date_diff($date1,$date2);



 $leave_day = $diff->d +1 ;







$leave_days = $leave_days + $leave_day;



}



elseif(($le->s_date>=$startday)&&($le->e_date<=$endday))



{



$start_date = $le->s_date;



$end_date = $le->e_date;











$date1=date_create($start_date);



$date2=date_create($end_date);



$diff=date_diff($date1,$date2);







if($le->total_days=='0.5')



$leave_day = .5 ;



else $leave_day = $diff->d + 1 ;



$leave_days = $leave_days + $leave_day;



			}



			elseif(($le->s_date<=$startday)&&($le->e_date>=$endday))



			{



				$start_date = $startday;



				$end_date = $endday;



$date1=date_create($start_date);



$date2=date_create($end_date);



$diff=date_diff($date1,$date2);







$leave_day = $diff->d +1 ;



$leave_days = $leave_days + $leave_day;



			}



			elseif(($le->s_date<=$endday)&&($le->e_date>=$endday))



			{



$start_date = $le->s_date;



$end_date = $endday;



$date1=date_create($start_date);



$date2=date_create($end_date);



$diff=date_diff($date1,$date2);







$leave_day = $diff->d +1 ;



$leave_days = $leave_days + $leave_day;



			}



			else



			echo 'doom';



			}







$leave_days_lwp = 0;



$leave_days_lv =  0;



//echo '<br>'.$info->PBI_ID.' - ';



//echo $startday.' - ';



//echo $info->PBI_DUE_DOJ;



if($startday>$info->PBI_DUE_DOJ)



{



$leave_days_lwp = 0;



$leave_days_lv = $leave_days;}



else



{



$leave_days_lwp = $leave_days;



$leave_days_lv = 0;}











$mobile_bills = find_a_field('hrm_moblie_bill','mobile_bill','emp_id="'.$info->PBI_ID.'" and `month`="'.$mon.'" and `year`="'.$year.'" ');



$other_bill = find_a_field('hrm_other_bill','other_bill','emp_id="'.$info->PBI_ID.'" and `month`="'.$mon.'" and `year`="'.$year.'" ');







if(@$att->od=='') @$att->od = $r_count;











		$data = find_all_field('salary_attendence','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');



		if($data->td>0)



		{



			$status='Edit';



			$att->status = 0;



			$att->remarks = '';



		}



		else



		{



			if($info->special_attendence==0)



			{



			$att = find_all_field('hrm_attendence_final','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');







			}



			else



			{



			$att->lt = 0;



			$att->ab = 0;



			$att->lv = 0;



			$att->ot = 0;







			$att->pay = $days_mon;



			$att->pre = $days_mon - ($holy_day + $r_count);



			}



			$status='Save';



			$pay = $days_mon;



			$pre = $days_mon - ($holy_day + $r_count);



		}















?>



        <tr style="font-size:10px; padding:3px; "><td><?=++$S?></td>



          <td><strong><?=$info->PBI_CODE?></strong>



            <input name="dept_<?=$info->PBI_ID?>" type="hidden" id="dept_<?=$info->PBI_ID?>"  value="<?=$info->PBI_DEPARTMENT;?>" />



            <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>







<? if ($att->ab > '6' || $data->ab > '6') { ?>



<td style="color: #FF0000"><b><strong><?=$info->PBI_NAME?></strong></b></td>



<? }else{ ?>



<td><strong><?=$info->PBI_NAME?></strong></td>



<? } ?>



















<td><? ($data->pbi_designation!='')?$desg_id=$data->pbi_designation:$desg_id=$info->DESG_ID; echo find_a_field('designation','DESG_SHORT_NAME','DESG_ID='.$desg_id)?></td><td><?=$info->PBI_DEPARTMENT; ?> </td>



          <!--<td align="center"><?



          $res = "select concat(a.AREA_NAME,'-',d.dealer_name_e) dealer from area a, dealer_info d where a.AREA_CODE=d.area_code and d.dealer_code=".$data->dealer_code;



		  $resq = @db_query($res);



		  $res_data = @mysqli_fetch_object($resq); echo $res_data->dealer; ?></td>-->



          <td align="center"><input name="td_<?=$info->PBI_ID?>" type="text" id="td_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;border: 1px solid blue;"



value="<? if($data->td==0){if($att->td>0) echo $att->td; else {if($new_emp_days>0) echo $new_emp_days; else echo $days_mon;}} else echo $data->td;?>" size="2" maxlength="2" readonly="readonly" /></td>



<td align="center"><input name="od_<?=$info->PBI_ID?>" type="text" id="od_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;border: 1px solid blue;" size="2" maxlength="2" value="<?=($data->od=='')?$att->od:$data->od;?>" /></td>



<td align="center"><input name="hd_<?=$info->PBI_ID?>" type="text" id="hd_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;border: 1px solid blue;" size="2" maxlength="2" value="<?=($data->hd=='')?$att->hd:$data->hd;?>" /></td>



<td align="center"><input name="lt_<?=$info->PBI_ID?>" type="text" id="lt_<?=$info->PBI_ID?>" style="font-size:10px; width:40px; min-width:40px;border: 1px solid blue;" value="<?=($data->lt=='')?$att->lt:$data->lt;?>" size="2" maxlength="2" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>







<td align="center">



<input name="ab_<?=$info->PBI_ID?>" type="text" id="ab_<?=$info->PBI_ID?>" style="font-size:10px; width:40px; min-width:40px;border: 1px solid blue;"



value="<?=($data->ab=='')?$att->ab:$data->ab;?>" size="2" maxlength="2"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>











<td align="center"><input name="lwp_<?=$info->PBI_ID?>" type="text" id="lwp_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:28px;border: 1px solid blue;" value="<?=($data->lwp=='')?$att->lwp:$data->lwp;?>" size="4" maxlength="4"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>



<td align="center"><input name="lv_<?=$info->PBI_ID?>" type="text" id="lv_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:28px;border: 1px solid blue;" value="<?=($data->lv=='')?$att->lv:$data->lv;?>" size="4" maxlength="4"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>



<td align="center"><input name="pre_<?=$info->PBI_ID?>" type="text" id="pre_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:20px;border: 1px solid blue;" onchange="cal_all(<?=$info->PBI_ID?>)" value="<?=($data->pre=='')?$att->pre:$data->pre;?>" size="2" maxlength="2" readonly="readonly" /></td>



<td align="center"><input name="pay_<?=$info->PBI_ID?>" type="text" id="pay_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:20px;border: 1px solid blue;" value="<?=($data->pay=='')?$att->pay:$data->pay;?>" size="2" maxlength="2" readonly="readonly" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>







<!--<td align="center"><input type="checkbox" name="pbi_held_up_<?=$info->PBI_ID?>" id="pbi_held_up_<?=$info->PBI_ID?>"







<? if($data->pbi_held_up==0){if($att->status>0) echo 'CHECKED="CHECKED"';}



else echo 'CHECKED="CHECKED"'; ?> value="1"/></td>-->







<!--<td align="center"><input name="remarks_<?=$info->PBI_ID?>" type="text" id="remarks_<?=$info->PBI_ID?>" style="font-size:10px; width:100px; min-width:20px;"



value="<?=($data->remarks=='')?$att->remarks:$data->remarks;?>" size="10" maxlength="50" /></td>-->







          <td align="center"><input name="benefits_<?=$info->PBI_ID?>" type="text" id="benefits_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:20px;border: 1px solid blue;" value="<?=$data->salary_arrear?>" size="8" maxlength="8" /></td>







          <td align="center"><span id="divi_<?=$info->PBI_ID?>">



            <?







			  if($status=='Edit')



			  {



			  if($_SESSION['user']['level']==5||$_SESSION['user']['level']==2)



			  {?><input type="button" class="btn1 btn1-bg-submit" name="Button" value="<?=$status?>"  onclick="cal_all(<?=$info->PBI_ID?>), update_value(<?=$info->PBI_ID?>)"/>



			    <input type="button" class="btn1 btn1-bg-cancel" name="Button" value="Delete"  onclick="delete_value(<?=$info->PBI_ID?>)"/><?



			  }



			  else echo 'Saved';



			  }



			  else



			  {



			  ?><input type="button" class="btn1 btn1-bg-submit"  name="Button" value="<?=$status?>"  onclick="cal_all(<?=$info->PBI_ID?>), update_value(<?=$info->PBI_ID?>)"/><? }?>



          </span>&nbsp;</td>



          </tr>



        <?



		}



		?>



        </tbody>







        <tfoot>



        <tr>



		<td colspan="16" style="background:#ccc;">&nbsp;</td>



        </tr>



        </tfoot>



        </table>



		</div>

		  </div>



          </div>



    </div>



<p>



  <!--<input name="save" type="submit" id="save" value="SAVE" />-->



</p>



		<? }?>



  </div>

			  </div></div>



          </div>



    </div>



    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">



      <div class="oe_follower_list"></div>



    </div></div></div></div></div>



    </div></div>







        </div>



  </div>



</form>





	<*/?>







<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>