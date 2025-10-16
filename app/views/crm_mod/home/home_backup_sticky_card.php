<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


 $unique='task_id'; 
$title = "Customer Relationship Management Dashboard";



$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');


$table='crm_task_add_information';		// Database Table Name Mainly related to this page

$crud    =new crud($table);
//for update..................................
if(isset($_POST['update']))
{
$_POST['edit_at']=time();
$_POST['edit_by']=$_SESSION['user']['id'];
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');



/*if($_SESSION['employee_selected']==0 || $_SESSION['employee_selected']==''){



header('location:../../../crm_mod/pages/home/index.php');



}*/



 

 $cur = '&#x9f3;';

 

 

 $table1 = 'crm_project_lead';

 $table2 = 'crm_task_lists';

 $table3 = 'crm_call_schedule';
 
 $table4 = 'crm_campaign_management';

 

//  $crud1 = new crud($table1);

//  $crud2 = new crud($table2);

//  $crud3 = new crud($table3);
 
//  $crud4 = new crud($table4);

 


require "../include/custom.php";

echo '<link rel="stylesheet" href="../include/Style/calendarStyle.css">';



?>



        <?php



            if(in_array($_SESSION['employee_selected'], $superID)){

                $con = "";

            }else{

                $con = " AND assigned_person_id = '".$_SESSION['employee_selected']."' ";

            } 

            

        	
if(isset($$unique))
{
$condition=$unique."=".$$unique;	
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}	
?>

<script type="text/javascript">
  function nav(lkf){document.location.href = '<?=$page?>?<?=$unique?>='+lkf;}
</script>

        

    

  <style>.nav-tabs .nav-link.active, .nav-tabs .nav-link.active:active, .nav-tabs .nav-link.active:focus, .nav-tabs .nav-link.active:visited, .nav-tabs .nav-link.active:hover{border-color: #bfc1f5;}
</style>










<style>

.order-card {
    color: #fff;
}

.bg-c-blue {
    background: linear-gradient(45deg,#4099ff,#73b4ff);
}

.bg-c-green {
    background: linear-gradient(45deg,#2ed8b6,#59e0c5);
}

.bg-c-yellow {
    background: linear-gradient(45deg,#FFB64D,#ffcb80);
}

.bg-c-pink {
    background: linear-gradient(45deg,#FF5370,#ff869a);
}


.mycard2 {
    padding-left:2px;
    padding-right:2px;
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    border: none;
    margin-bottom: 30px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.mycard2 .card-block {

    padding: 25px;
}

.order-card i {
    font-size: 26px;
}

.f-left {
    float: left;
}

.f-right {
    float: right;
}

.order-card:hover {
    transform: translateY(-10px);
    -webkit-transform: translateY(-10px);
    -moz-transform: translateY(-10px);
    -ms-transform: translateY(-10px);
    -o-transform: translateY(-10px);
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    -webkit-box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

.order-card:hover .card-block {
    background-color: rgba(255, 255, 255, 0.1);
}

.order-card:hover h6, .order-card:hover h2 {
    color: #fff;
}
#topcard{
  padding-top: 15px;
  padding-left: 15px;
  padding-right: 15px;
}
.textspan{
  font-size:25px !important;
}


</style>

<div class="card card-stats" id="topcard">
<div class="row">
        <div class="col-md-3 col-xl-3">
            <div class="mycard2 bg-c-blue order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Active Lead</h6>
                    <h2 class="text-right"><i class="fa-solid fa-users-medical f-left"></i><span class="textspan"><?=find_a_field('crm_project_lead', 'count(id)', 'status = "1"')?></span></h2>
                    
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-xl-3">
            <div class="mycard2 bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20"> Total Generated Lead</h6>
                    <h2 class="text-right"><i class="fa-solid fa-users-gear f-left"></i><span class="textspan"><?=find_a_field('crm_project_lead', 'count(id)', '1')?></span></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-xl-3">
            <div class="mycard2 bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Running Projects</h6>
                    <h2 class="text-right"><i class="fas fa-chart-pie f-left"></i><span class="textspan"><?=find_a_field('crm_project_lead a, crm_project_org b', 'count(b.id)', 'a.organization=b.id AND a.status="1"')?></span></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-xl-3">
            <div class="mycard2 bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Task</h6>
                    <h2 class="text-right"><i class="fas fa-tasks f-left"></i><span class="textspan"><?=find_a_field('crm_task_add_information', 'count(task_id)', '1')?></span></h2>
                </div>
            </div>
        </div>
        
<!-- 
        <div class="col-md-2 col-xl-3">
            <div class="mycard2 bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Expenses</h6>
                    <h2 class="text-right"><i class="fa-solid fa-square-dollar f-left"></i><span><//?php $tb=find_a_field('crm_campaign_management', 'sum(budget)', '1');if($tb>0){echo $tb;}else{echo '0.00';}?> $</span></h2>
                </div>
            </div>
        </div> -->

</div>
</div>
         
 





















<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>










