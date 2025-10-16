<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";
$title="Requisition Form";
do_calander('#m_date');

$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');

$table='hrm_inout';
$unique='id';

if(isset($_POST['search']))

{		

$emp_id=$_POST['PBI_ID'];
$access_date=$a_date=$_POST['m_date'];
$c_date=explode('-',$a_date);
$access_time=$a_date.' '.$_POST['m_hr'].':'.$_POST['m_min'].':'.'00';
$access_stamp=mktime($_POST['m_hr'],$_POST['m_min'],0,$c_date[1],$c_date[2],$c_date[0]);
$sch = find_all_field_sql('select p.off_day,s.office_start_time,s.office_end_time from personnel_basic_info p, hrm_schedule_info s where p.PBI_ID="'.$emp_id.'" and p.office_time=s.id');


	$date = date('Ymd',$access_stamp);
	if(date('N',$access_stamp)==$sch->off_day) $info['status'][$date]=0;
	else{
        if($sch->office_start_time == '')	$info['status'][$date]=1;
        else{$info['late'][$date] = (int)(($access_stamp - strtotime($access_date.' '.$sch->office_start_time))/60);

	if($info['late'][$date]>0) 	$info['status'][$date]=2;
	else $info['status'][$date]=1;

	}}











$sql="INSERT INTO `hrm_inout` (



`employee_id` ,



card_no,



`access_date` ,



`access_time` ,



`access_stamp` ,



`user` ,



`status`,off_day,start_time,end_time )



VALUES ('$emp_id', '$data[3]', '$access_date','$access_time', '$access_stamp', '$user1', '".$info['status'][$date]."','$sch->off_day', '$sch->office_start_time', '$sch->office_end_time')";



$query=db_query($sql);





$att_sql = "INSERT INTO hrm_attdump ( ztime, bizid, xenrollid, xdate, xtime,EMP_CODE) VALUES ('$access_time', '$emp_id', '$emp_id', '$access_date', '$access_time','$emp_id')"	;

$att_query=db_query($att_sql);	



		



}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Requisition Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
          
            color: #333;
        }
        .container {
          
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #ffffff;
            background: linear-gradient(135deg, #4a90e2, #7e57c2);
            padding: 20px;
            margin: -20px -20px 20px -20px;
            border-radius: 8px 8px 0 0;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }
        .form-group {
            flex: 1;
            margin-right: 15px;
        }
        .form-group:last-child {
            margin-right: 0;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus {
            border-color: #4a90e2;
            outline: none;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, #4a90e2, #7e57c2);
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }
        button:hover {
            background: linear-gradient(135deg, #3a80d2, #6e47b2);
            transform: translateY(-2px);
        }
		
       
    </style>
</head>
<body>
    <div class="container">
        <h1>Staff Requisition Form</h1>
        <form action="#" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="section_name">Section Name:</label>
                    <input type="text" id="section_name" name="section_name" placeholder="Enter section name">
                </div>
                <div class="form-group">
                    <label for="job_title">Job Title:</label>
                    <input type="text" id="job_title" name="job_title" placeholder="Enter job title">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="required_staff">Required Staff:</label>
                    <input type="text" id="required_staff" name="required_staff" placeholder="Enter required staff">
                </div>
                <div class="form-group">
                    <label for="current_staff">Current Staff:</label>
                    <input type="text" id="current_staff" name="current_staff" placeholder="Enter current staff">
                </div>
                <div class="form-group">
                    <label for="required_current_staff">Required Current Staff:</label>
                    <input type="text" id="required_current_staff" name="required_current_staff" placeholder="Enter required current staff">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="male_count">Male:</label>
                    <input type="text" id="male_count" name="male_count" placeholder="Enter male count">
                </div>
                <div class="form-group">
                    <label for="female_count">Female:</label>
                    <input type="text" id="female_count" name="female_count" placeholder="Enter female count">
                </div>
                <div class="form-group">
                    <label for="salary">Salary:</label>
                    <input type="text" id="salary" name="salary" placeholder="Enter salary">
                </div>
            </div>

            <div class="form-group">
                <label for="reason_for_demand">Reason for Demand:</label>
                <textarea id="reason_for_demand" name="reason_for_demand" placeholder="Enter reason for demand"></textarea>
            </div>

            <div class="form-group">
                <label for="educational_qualification">Educational Qualification:</label>
                <input type="text" id="educational_qualification" name="educational_qualification" placeholder="Enter educational qualification">
            </div>

            <div class="form-group">
                <label for="experience">Experience:</label>
                <input type="text" id="experience" name="experience" placeholder="Enter experience">
            </div>

            <button type="submit" name="register">Submit</button>
        </form>
    </div>
</body>
</html>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var dateInput = document.getElementById("date");
    if (!dateInput.value) {
      var today = new Date().toISOString().split('T')[0];
      dateInput.value = today;
    }
  });
</script>


<?
if(isset($_POST['register'])) {
        $date = $_POST['date'];
        $section_name = $_POST['section_name'];
        $job_title = $_POST['job_title'];
        $required_staff = $_POST['required_staff'];
        $current_staff = $_POST['current_staff'];
        $required_current_staff = $_POST['required_current_staff'];
        $male_count = $_POST['male_count'];
        $female_count = $_POST['female_count'];
        $reason_for_demand = $_POST['reason_for_demand'];
		$educational_qualification = $_POST['educational_qualification'];
        $experience = $_POST['experience'];
		$salary = $_POST['salary'];
		

    $ins_sql = "INSERT INTO `employee_requisition`(`date`, `section_name`, `job_title`, `required_staff`, `current_staff`, `required_current_staff`, `male_count`, `female_count`, `reason_for_demand`, `educational_qualification`, `experience` ,`salary`) VALUES ('$date','$section_name','$job_title','$required_staff','$current_staff','$required_current_staff','$male_count','$female_count','$reason_for_demand','$educational_qualification','$experience','$salary')";
	
  
  $ins_sql=db_query($ins_sql);
  
  if($ins_sql) {
            echo "<script>alert('Data Inserted into Database');</script>";
        } else {
            echo "<script>alert('Failed to insert data');</script>";       
        }
        
        echo "<script>window.location = '';</script>";
  
  
  }
?>


 
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>