<?php



//



//




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';







if(isset($_POST['create']))



{



	$mon=$_POST['mon'];



	$dept=$_POST['dept'];



	$year=$_POST['year'];



	$bonus=$_POST['bonus'];



}else{



$mon=date('n');



$year=date('Y');



}



   $monthof = date('n');



   $yearof=date('Y');



   



   $curMo =  date('M');



   $curMoInt =  date('n');



   if(date('Y-m-d') < date('Y-m-10')){



    



   $preMon = date('M',strtotime('first day of -1 month'));



   $preMonInt = date('n',strtotime('first day of -1 month'));



   }



   $nextMon = date('M',strtotime('first day of +1 month'));



   $nextMonInt = date('n',strtotime('first day of +1 month'));



   ?> 



<style type="text/css">



.click {

  border: 1px solid #00FF7C;

  position: relative;

  top: 0px;

  transition: all ease 0.3s;

}

     .click:active {

  box-shadow: 0 5px 0 #00823F;

  top: 5px;

   }

</style>

	



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



var ot=document.getElementById('ot_'+id).value;



//var oDuty=document.getElementById('oDuty_'+id).value;



var department=document.getElementById('dept_'+id).value;



var designation=document.getElementById('desg_'+id).value;



var netLate=document.getElementById('netLate_'+id).value;



var adjustment_amount=(document.getElementById('adjustment_amount_'+id).value)*1;

var offday_allowance=(document.getElementById('offday_allowance_'+id).value)*1;

var sitevisit_allowance=(document.getElementById('sitevisit_allowance_'+id).value)*1;



var remarks_details=document.getElementById('remarks_details_'+id).value;







var mon=document.getElementById('mon').value;



var year=document.getElementById('year').value;



var bonus=document.getElementById('bonus').value;











var strURL="monthly_attendence_ajax.php?PBI_ID="+PBI_ID+"&td="+td+"&fd="+fd+"&od="+od+"&hd="+hd+"&ot="+ot+"&lt="+lt+"&ab="+ab+"&lv="+lv+"&lwp="+lwp+"&pre="+pre+"&pay="+pay+"&mon="+mon+"&year="+year+"&bonus="+bonus+"&department="+department+"&designation="+designation+"&netLate="+netLate+"&adjustment_amount="+adjustment_amount+"&remarks_details="+remarks_details+"&offday_allowance="+offday_allowance+"&sitevisit_allowance="+sitevisit_allowance;







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







var ltd=lt/3; 



var ltdd=Math.floor(ltd);



var pre=td - (od + hd + ab + lv + lwp );



var pay=td - ab - lwp;



document.getElementById('pay_'+id).value=pay;



document.getElementById('pre_'+id).value=pre;



document.getElementById('netLate_'+id).value=ltdd;



	}











</script>





<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->

          <div class="">

		  

		  

           

        <div class="clearfix"></div>



            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2>ATTENDENCE PAGE</h2>

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





<form action=""  method="post">



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



       







          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">



<table width="100%" border="0" class="oe_list_content"><thead>



<tr class="oe_list_header_columns">



  <th colspan="4"><span style="text-align: center; font-size:19px; color:#3d6485"><center>MONTHLY ATTENDENCE ENTRY</center></span></th>



  </tr>



<tr class="oe_list_header_columns">



  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>



  </tr>



</thead><tfoot>



</tfoot><tbody>







  <tr  class="alt">



    <td align="right"><strong>Year:</strong></td>



    <td><select name="year" style="width:160px;" id="year" required="required">



	
        
        <option value="2019" <?=($_POST['year']==2019)? 'selected':''?>>2019</option>
	    <option value="2020" <?=($_POST['year']==2020)? 'selected':''?>>2020</option>
		<option value="2021" <?=($_POST['year']==2021)? 'selected':''?>>2021</option>
	    <option value="2022" <?=($_POST['year']==2022)? 'selected':''?>>2022</option>
        
        



		



    </select></td>



    <td align="right"><strong>Month:</strong></td>



    <td><span class="oe_form_group_cell">



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



	  



    </span></td>



  </tr>



  <tr >



    <td align="right" class="alt">Concern Company :</td>



    <td align="left" class="alt"><span class="oe_form_group_cell">



      <select name="PBI_ORG" style="width:160px;" id="PBI_ORG" required>



        <? //=foreign_relation('user_group','id','group_name',$_POST['PBI_ORG']);?>



		<option selected value="2">Aksid Corporation Limited</option>



      </select>



    </span></td>



    <td align="right"><strong>Department:</strong></td>



    <td><span class="oe_form_group_cell">



      <select name="dept" style="width:160px;" id="dept">



	  



        <?=foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['dept']);?>



      </select>



    </span></td>



    </tr>



  <tr >



    <td align="right" class="alt"><strong>Bonus Month (?):</strong></td>



    <td align="left" class="alt"><span class="oe_form_group_cell">



      <select name="bonus" style="width:160px;" id="bonus" required="required">



        <option <?=($bonus=='No')?'selected':''?>>No</option>



        <option <?=($bonus=='Yes')?'selected':''?>>Yes</option>



      </select>



    </span></td>



    <td align="right"><strong>Project Name : </strong></td>



    <td><span class="oe_form_group_cell">



      <select name="JOB_LOCATION" style="width:160px;" id="JOB_LOCATION">



        <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$_POST['JOB_LOCATION'],'1');?>



      </select>



    </span></td>



    </tr>



  



  



  </tbody></table>



<br /><div style="text-align:center">



<table width="100%" class="oe_list_content">



  <thead>



<tr class="oe_list_header_columns">



  <th colspan="4"><input name="create" type="submit" class="btn btn-primary" id="create" value="View Sheet" /></th>



  </tr>



  </thead>



  <tfoot>



  </tfoot>



  <tbody>



    </tbody>



</table>



<div class="oe_form_sheetbg">



       







          <div class="oe_view_manager_view_list"><div class="oe_list oe_view">



          <? if(isset($_POST['create'])){?>



		<table width="100%" class="oe_list_content">



		  <thead align="center"><tr class="oe_list_header_columns" align="center" style="font-size:10px;padding:3px; background:#2ECCFA;">



        <th>S/L</th>



        <th >ID</th>



        <th><div align="center">Full Name</div></th>



        <th>Designation</th>



        <th>Total Day</th>



        <th>Weekend</th>



        <th>Holiday</th>



        <th>OT</th>



        <th>Late</th>



        <th style="display:none;">OD</th>



        <th>Absent</th>



        <th>LWP</th>



        <th>Leave</th>



        <th>Present</th>



        <th>Payable</th>



        <th><div align="center">Offday<br>Amount</div></th>
		
        <th><div align="center">Site Visit<br>Amount</div></th>
		
        <th><div align="center">Adjustment<br>Amount</div></th>



        <th>Remarks</th>



        <th>&nbsp;</th>



        </tr>
		</thead>



        <tbody>



        <? 



//$startTime = $days1=mktime(0,0,0,($mon-1),26,$year);



//$endTime = $days2=mktime(0,0,0,$mon,25,$year);







$startTime = $days1=mktime(0,0,0,$mon,01,$year);



//$endTime = $days2=mktime(0,0,0,$mon,date('t',$startTime),$year);



$endTime = $days2=mktime(0,0,0,$mon,30,$year);







$days_in_month = date('t',$endTime);







$startTime1 = $days1=mktime(0,0,0,($mon),01,$year);



$endTime1 = $days2=mktime(0,0,0,$mon,$days_in_month,$year);







$startday = date('Y-m-d',$startTime);



$endday = date('Y-m-d',$endTime);



	







//$start_date = $year.'-'.($mon-1).'-26';



//$end_date = $year.'-'.$mon.'-25';







$start_date =$starting_date = $year.'-'.$mon.'-01';



$end_date =$ending_date = $year.'-'.$mon.'-'.date('t',$startTime);







//$days_mon=ceil(($endTime - $startTime)/(3600*24))+1;



$days_mon=30;



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



		if($_POST['PBI_BRANCH']!='')	$con .= " and PBI_BRANCH = '".$_POST['PBI_BRANCH']."'";



		if($_POST['PBI_ZONE']!='')		$con .= " and PBI_ZONE = '".$_POST['PBI_ZONE']."'";



		if($_POST['PBI_GROUP']!='')		$con .= " and PBI_GROUP = '".$_POST['PBI_GROUP']."'";



		if($_POST['dept']!='')	$con .= " and p.PBI_DEPARTMENT = '".$_POST['dept']."'";



		if($_POST['JOB_LOCATION']!='')  $con .= " and p.JOB_LOCATION = '".$_POST['JOB_LOCATION']."'";



		//echo $jday=date('d').' <br>';



		$j_date=date('Y-m-d',mktime(0,0,0,$_POST['mon'],31,$_POST['year']));



		$sql = "select p.*, if(d.DEPT_DESC='NO DEPARTMENT','',d.DEPT_DESC) as DEPT_DESC, g.DESG_DESC from personnel_basic_info p, salary_info s, designation g, department d where p.PBI_DEPARTMENT=d.DEPT_ID and p.PBI_DESIGNATION=g.DESG_ID and p.PBI_ID=s.PBI_ID and p.PBI_JOB_STATUS='In Service'".$con." and p.PBI_DOJ<'".$j_date."' order by (s.basic_salary+s.consolidated_salary) desc";



		



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



		if($info->PBI_DEPARTMENT=='S&M')



		$r_count = 0;



		$data = find_all_field('salary_attendence','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');



		if($data->td>0)



		{



			$status='Edit';



		}



		else



		{



			if($info->special_attendence==0)



			$att = find_all_field('hrm_attendence_final','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');



			else



			{



			$att->lt = 0;



			$att->ab = 0;

			

			



			 $att->lv =0;

			

			$att->lwp = 0;



			$att->ot = 0;



			



			$att->pay = $days_mon;



			$att->pre = $days_mon - ($holy_day + $r_count);



			}



			$status='Save';



			$pay = $days_mon;



			$pre = $days_mon - ($holy_day + $r_count);



			



if(strtotime($info->PBI_DOJ) > strtotime($startday)){$startday=date('Y-m-d',strtotime($rgn_data->PBI_DOJ));}



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







if($startday>$info->PBI_DUE_DOJ)



{



$leave_days_lwp = 0;



$leave_days_lv = $leave_days;}



else



{



$leave_days_lwp = $leave_days;



$leave_days_lv = 0;}















		}

		

		/*echo $sql = 'select sum(total_days) from hrm_leave_info where mon="'.$mon.'" and year="'.$year.'" and PBI_ID="'.$info->PBI_ID.'" and leave_status="GRANTED" and type in (1,2,3,4,5,6,7,8)';*/

		   

		   $m_s_date = $year.'-'.$mon.'-'.'01';

		   $m_e_date = $year.'-'.$mon.'-'.'31';

                

				$next_month = $mon+1;

		  $create_next_date = $year.'-'.$next_month.'-'.'01';

		  

		 



                

				  $dd = 'select s_date,e_date from hrm_leave_info where s_date>="'.$m_s_date.'" and PBI_ID="'.$info->PBI_ID.'" and leave_status="GRANTED" and type in (1,2,3,4,5,6,7,8)';

				 

				$dumping = db_query($dd);

				$day_count = 0;

				$last_date = $year.'-'.$mon.'-'.'31';

				while($leave_d = mysqli_fetch_object($dumping)){

				

				 $d = date_parse_from_format("Y-m-d", $leave_d->e_date);

                  $next_m =  $d["month"];

				  

				   if($mon<$next_m){

				   

				   $e_date = $last_date;

				   

				   }else{

				   $e_date = $leave_d->e_date;

				   }

				   

				   

				   

				 

				$s_date = $leave_d->s_date;

				

				

				

				

				$e_date = date('Y-m-d H:i:s', strtotime($e_date . ' +1 day'));

				

		 $begin = new DateTime($s_date);

        $end = new DateTime($e_date);



      $interval = DateInterval::createFromDateString('1 day');

      $period = new DatePeriod($begin, $interval, $end);

	



    foreach ($period as $dt) {

	   

     $dt->format("l Y-m-d H:i:s\n");

    $today = $dt->format("Y-m-d");

    if($dt->format("l")!='Friday')

    {

       $found = 0;

       $found = find_a_field('salary_holy_day','1',' holy_day="'.$today.'" ');

       if($found==0)

       $day_count++;

	  

       }

}

  

}

$att->lvv =  $day_count;



				

				

			  //$att->lvv = find_a_field('hrm_leave_info','sum(total_days)',' s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'" and PBI_ID="'.$info->PBI_ID.'" and leave_status="GRANTED" and type in (1,2,3,4,5,6,7,8)');

			

			$att->lwpp = find_a_field('hrm_leave_info','sum(total_days)','s_date>="'.$m_s_date.'" and e_date<="'.$m_e_date.'"  and PBI_ID="'.$info->PBI_ID.'" and leave_status="GRANTED" and type in (9)');



		?>



        <tr style="font-size:10px; padding:3px; "><td><?=++$S?></td>



          <td><?=$info->PBI_ID?>



            <input name="dept_<?=$info->PBI_ID?>" type="hidden" id="dept_<?=$info->PBI_ID?>"  value="<?=$info->PBI_DEPARTMENT;?>" />



			<input name="desg_<?=$info->PBI_ID?>" type="hidden" id="desg_<?=$info->PBI_ID?>"  value="<?=$info->PBI_DESIGNATION;?>" />



			<input name="netLate_<?=$info->PBI_ID?>" type="hidden" id="netLate_<?=$info->PBI_ID?>"  value="" />



            <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>



          <td><?=$info->PBI_NAME?></td><td><?=$info->DESG_DESC?></td><td align="center"><input name="td_<?=$info->PBI_ID?>" type="text" id="td_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" 



value="<? if($att->td>0) echo $att->td; else {if($new_emp_days>0) echo $new_emp_days; else echo $days_mon;}?>" size="2" maxlength="2" readonly="readonly" /></td>



<td align="center"><input name="od_<?=$info->PBI_ID?>" type="text" id="od_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" size="2" maxlength="2" readonly="readonly" value="<? if($att->od>0) echo $att->od; else {if($new_emp_off>0) echo $new_emp_off; else echo $r_count;}?>" /></td>



<td align="center"><input name="hd_<?=$info->PBI_ID?>" type="text" id="hd_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" size="2" maxlength="2" readonly="readonly" value="<? if($att->hd>0) echo $att->hd; else {if($new_emp_holy_day>0) echo $new_emp_holy_day; else echo $holy_day;}?>" /></td>



<td align="center"><input name="ot_<?=$info->PBI_ID?>" type="text" id="ot_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" value="<?=($data->ot=='')?$att->ot:$data->ot;?>" size="2" maxlength="2" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>



<td align="center"><input name="lt_<?=$info->PBI_ID?>" type="text" id="lt_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" value="<?=($data->lt=='')?$att->lt:$data->lt;?>" size="2" maxlength="2" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>



<!--<td align="center"><input name="oDuty_<?=$info->PBI_ID?>" type="hidden" id="oDuty_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" value="<?=($data->oDuty=='')?$att->oDuty:$data->oDuty;?>" size="2" maxlength="2" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>
-->


<td align="center"><input name="ab_<?=$info->PBI_ID?>" type="text" id="ab_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" value="<?=($data->ab=='')?$att->ab:$data->ab;?>" size="2" maxlength="2"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>



<td align="center"><input name="lwp_<?=$info->PBI_ID?>" type="text" id="lwp_<?=$info->PBI_ID?>" style="font-size:10px; width:28px; min-width:28px;" value="<?=($data->lwp=='')?$att->lwpp:$att->lwpp;?>" size="4" maxlength="4"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>



<td align="center"><input name="lv_<?=$info->PBI_ID?>" type="text" id="lv_<?=$info->PBI_ID?>" style="font-size:10px; width:28px; min-width:28px;" value="<?=($data->lv=='')?$att->lvv:$att->lvv;?>" size="4" maxlength="4"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>



<td align="center"><input name="pre_<?=$info->PBI_ID?>" type="text" id="pre_<?=$info->PBI_ID?>" style="font-size:10px; width:25px; min-width:20px;" onchange="cal_all(<?=$info->PBI_ID?>)" value="<?=($data->pre=='')?$att->pre:$data->pre;?>" size="2" maxlength="2" readonly="readonly" /></td>



<td align="center"><input name="pay_<?=$info->PBI_ID?>" type="text" id="pay_<?=$info->PBI_ID?>" style="font-size:10px; width:25px; min-width:20px;" value="<?=($data->pay=='')?$att->pay:$data->pay;?>" size="2" maxlength="2" readonly="readonly" /></td>



<td align="center" bgcolor="#FFFFFF"><input name="offday_allowance_<?=$info->PBI_ID?>" type="text" id="offday_allowance_<?=$info->PBI_ID?>" style="font-size:10px; width:60px; min-width:20px;" value="<?=($data->offday_allowance=='')?$att->offday_allowance:$data->offday_allowance;?>" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>

<td align="center" bgcolor="#FFFFFF"><input name="sitevisit_allowance_<?=$info->PBI_ID?>" type="text" id="sitevisit_allowance_<?=$info->PBI_ID?>" style="font-size:10px; width:60px; min-width:20px;" value="<?=($data->sitevisit_allowance=='')?$att->sitevisit_allowance:$data->sitevisit_allowance;?>" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>

<td align="center" bgcolor="#FFFFFF"><input name="adjustment_amount_<?=$info->PBI_ID?>" type="text" id="adjustment_amount_<?=$info->PBI_ID?>" style="font-size:10px; width:60px; min-width:20px;" value="<?=($data->adjustment_amount=='')?$att->adjustment_amount:$data->adjustment_amount;?>" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>



<td align="center" bgcolor="#FFFFFF"><input name="remarks_details_<?=$info->PBI_ID?>" type="text" id="remarks_details_<?=$info->PBI_ID?>" style="font-size:10px; width:60px; min-width:20px;" value="<?=($data->remarks_details=='')?$att->remarks_details:$data->remarks_details;?>" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>



<td align="center" bgcolor="#FFFFFF"><span id="divi_<?=$info->PBI_ID?>">



            <? 



			  if($status=='Edit')



			  {?>



			  <input type="button" name="Button" value="<?=$status?>" class="click"  onclick="cal_all(<?=$info->PBI_ID?>), update_value(<?=$info->PBI_ID?>)" style="font-size:11px; font-weight: bold; background-color: #1c5fcc; padding:5px 8px; border-radius:3px; border:2px solid #CCC; box-shadow:2px 2px 2px 2px BLUE; color:white; width:100%; height:30px; align:center; padding:0px;"/>



			  <? }



			  else{



			  ?>



			  <input type="button" name="Button" value="<?=$status?>"  class="click"  onclick="cal_all(<?=$info->PBI_ID?>), update_value(<?=$info->PBI_ID?>)" style="font-size:10px; font-weight: bold; background-color: #1c5fcc; padding:5px 8px; border-radius:3px; border:2px solid #CCC;box-shadow:2px 2px 2px 2px BLUE; color:white; height:30px; width:100%; padding:0px;"/><? }?>



          </span>&nbsp;</td>
          </tr>



        <?



		}



		?>



        <tr><td colspan="2"></tbody>



        



        <tfoot>



        <tr><td colspan="2"></td><td></td><td></td><td></td>



          <td></td>



          <td></td>



          <td></td>



          <td></td>



          <td></td>



          <td></td>



          <td></td>



          <td></td>



          <td></td>



          <td></td>



          <td></td>
          <td></td>
          <td></td>



          <td></td>



          <td></td>
          </tr>
        </tfoot>
        </table>



		<? }?>          </div></div>



          </div>



    </div>



<p align="center">



  <input name="save" type="submit" id="save" value="SAVE" />



  



</p>



  </div>

  

  </div></div>



          </div>



    </div>



    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">



      <div class="oe_follower_list"></div>



    </div></div></div></div></div>



    </div></div>



            



       



  



</form>



</div>







 

		   </div>

		   

		   

		   </div>

		    </div>

            </div>

			</div>

			</div>

        <!-- /End page content -->





<?



//



//



require_once SERVER_CORE."routing/layout.bottom.php";

include_once("../../template/footer.php");



?>