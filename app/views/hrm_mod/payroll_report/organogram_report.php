<?

session_start();

require "../../config/inc.all.php";

require "../../classes/report.class.php";

require_once ('../../../acc_mod/common/class.numbertoword.php');

date_default_timezone_set('Asia/Dhaka');


if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)


{}



?>


 
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AKSID || Organogram</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="resources/demos/style.css">
  <link rel="stylesheet" href="jquery-orgchart-master/demo.css"/>
        <link rel="stylesheet" href="jquery-orgchart-master/jquery.orgchart.css"/>
        <style>
        span.title {
            font-weight: normal;
            font-style: italic;
            color: #404040;
        }
		
		@media print
        {
         .noprint {display:none;}
		 .print { display:block;}
        }
 
        </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="jquery-orgchart-master/jquery.orgchart.js"></script>
        <script>
        $(function() {
            $("#organisation").orgChart({container: $("#main")});
        });
		</script>
</head>
<body>

<form action="" method="post">
   
                         <div class="noprint">
                         <table width="100%" border="0" class="oe_list_content">
                          <thead>
                            <tr class="oe_list_header_columns">
                              <th colspan="4"><span style="text-align: center;font-size:19px; color:#7c5fc8"><center>HR MANAGEMENT</center></span></th>
                            </tr>
                            <tr class="oe_list_header_columns">
                              <th colspan="4"><span style="text-align: center; font-size:14px; color:#C00"><center>Select Options</center></span></th>
                            </tr>
                          </thead>
                          <tfoot>
                          </tfoot>
                          <tbody>
                            
                            <tr  class="alt">
                              <td align="right" style="font-size:16px"><strong>Department :</strong></td>
                              <td align="left"><span class="oe_form_group_cell">
                                <select name="department" style="width:160px;" id="department">
								
                                  <? foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['department'],'1 order by DEPT_DESC');?>
                                </select>
                                </span></td>
                              <td align="right" style="font-size:16px"><strong>Project :</strong></td>
                              <td><span class="oe_form_group_cell">
                                <select name="JOB_LOCATION" style="width:160px;" id="JOB_LOCATION">
                                  <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$_POST['JOB_LOCATION']);?>
                                </select>
                              </span></td>
                            </tr>
                            
                          </tbody>
                        </table>
						
						<div align="center"> <input name="submit" type="submit" id="submit" value="SHOW" align="center" /></div>
							  
						</div>	  
   
</form>



<?php


  if(isset($_POST['submit'])){
  
   $dept = $_POST['department'];
   
 
   $project = $_POST['JOB_LOCATION'];
  
   
   if($dept>0){
   
   $dept_head = find_a_field('department','DEPT_HEAD','DEPT_ID='.$dept);
   
  echo 'Department : '.find_a_field('department','DEPT_DESC','DEPT_ID='.$dept).'';
   
   $sql = 'select p.* from personnel_basic_info p  where  1 and p.PBI_JOB_STATUS="In Service" and p.PBI_DEPARTMENT="'.$dept.'" and p.PBI_ID="'.$dept_head.'"  order by PBI_ID asc limit 0, 1';	

 
   }elseif($project>0){
   
   $proj_head = find_a_field('project','PROJECT_HEAD','PROJECT_ID='.$project);
   
    echo 'Project : '.find_a_field('project','PROJECT_DESC','PROJECT_ID='.$project).'';
   
   $sql = 'select p.* from personnel_basic_info p  where  1 and p.PBI_JOB_STATUS="In Service" and p.JOB_LOCATION="'.$project.'" and p.PBI_ID="'.$proj_head.'"  order by PBI_ID asc limit 0, 1';	

   
   }else{
   
    echo find_a_field('user_group','group_name','id=2');
   
    $sql = "select * from personnel_basic_info where  1 and PBI_ID=31502 order by PBI_ID asc limit 0, 1";	
   
   
   }
   
   
$result = db_query($sql);
$data = mysqli_fetch_object($result);
$parent_id = $data->PBI_ID;
 $main_username = $data->PBI_NAME;

function demo_recursive($parent_id, $under_id){
   
	if($parent_id!='' && $under_id == 0){
	 $sql2 = "select p.*,e.ESSENTIAL_REPORTING from personnel_basic_info p,essential_info e where  1 and p.PBI_JOB_STATUS='In Service' and p.PBI_ID=e.PBI_ID and e.ESSENTIAL_REPORTING = '".$parent_id."' ";						
	}else if ($parent_id!='' && $under_id > 0){
	 $sql2 = "select p.*,e.ESSENTIAL_REPORTING from personnel_basic_info p,essential_info e where  1 and p.PBI_JOB_STATUS='In Service' and p.PBI_ID=e.PBI_ID and e.ESSENTIAL_REPORTING = '".$parent_id."' ";							
	}

	 $result2 = db_query($sql2);
echo '<ul>';
	 while($row = mysqli_fetch_object($result2)){
		$parent_id = $row->PBI_ID;
		$under_id =  $row->ESSENTIAL_REPORTING;
		echo '<li>';
		echo '<div align="center">';
		echo '<img src="../../pic/staff/'.$row->PBI_ID.'.jpeg" style="width:70px; height:65px; border-radius:25%; margin-top:2px;"> <br>';
		echo $row->PBI_NAME.'<br>';
		echo find_a_field('designation','DESG_DESC','DESG_ID='.$row->PBI_DESIGNATION);
		echo '</div>';
		echo demo_recursive($parent_id, $under_id);
		echo '</li>';

}
echo '</ul>';
	}
	
	}else{/*
	
	
	
 $sql = "select * from personnel_basic_info where  1 and PBI_ID=31502 order by PBI_ID asc limit 0, 1";	
$result = db_query($sql);
$data = mysqli_fetch_object($result);
$parent_id = $data->PBI_ID;
$main_username = $data->PBI_NAME;

function demo_recursive($parent_id, $under_id){
   
	if($parent_id!='' && $under_id == 0){
	 $sql2 = "select p.*,e.ESSENTIAL_REPORTING from personnel_basic_info p,essential_info e where  1 and p.PBI_ID=e.PBI_ID and e.ESSENTIAL_REPORTING = '".$parent_id."' ";						
	}else if ($parent_id!='' && $under_id > 0){
	 $sql2 = "select p.*,e.ESSENTIAL_REPORTING from personnel_basic_info p,essential_info e where  1 and p.PBI_ID=e.PBI_ID and e.ESSENTIAL_REPORTING = '".$parent_id."' ";							
	}

	 $result2 = db_query($sql2);
  echo '<ul>';
	 while($row = mysqli_fetch_object($result2)){
		$parent_id = $row->PBI_ID;
		$under_id =  $row->ESSENTIAL_REPORTING;
		echo '<li>';
		echo 'bimol<img src="../../pic/staff/emp/'.$row->PBI_ID.'.jpeg" style="width:70px; height:65px; border-radius:25%; margin-top:2px;">';
		echo $row->PBI_NAME;
		echo demo_recursive($parent_id, $under_id);
		echo '</li>';

}
  echo '</ul>';
	}
	
	
	*/}

?>

<ul id="organisation" style="display:none">

<li class="company"><? 
 echo '<img src="../../pic/staff/'.$data->PBI_ID.'.jpeg" style="width:70px; height:65px; border-radius:25%; margin-top:2px;"> <br>';
 echo $main_username.'<br>';
 echo find_a_field('designation','DESG_DESC','DESG_ID='.$data->PBI_DESIGNATION);
?>
<?=demo_recursive($parent_id, 0)?>
</li>
</ul>
        <div id="content">
        
            <h1>&nbsp;</h1>
        
            <div id="main">
            </div>
           

        </div>

<script>
$(document).ready(function(){
$("#lets_see").dblclick(function(){
$(this).attr("readonly", false);
});

},
$("#lets_see").blur(function(){
$(this).attr("readonly", true);
})
);

$('#lets_see').keyup(function(event) {
  if (event.keyCode == 10 || event.keyCode == 13) {
        event.preventDefault();
    }
});
</script>
</body>
</html>
