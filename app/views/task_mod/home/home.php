<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$pbi_id  =  $_SESSION['employee_selected'];
$user_role  =  $_SESSION['user']['fname'];

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');

 $cur = '&#x9f3;';
//require "../include/custom.php";
 $title = "All ".$CRMleadName." List";

 $tablecustomerlist1 = 'crm_project_org';
 $table2 = 'crm_org_contacts';

 $crud1 = new crud( $tablecustomerlist1);
 $crud2 = new crud($table2);

 if (isset($_POST['insert'])) {
  try {
      $_POST['entry_by'] = $_SESSION['employee_selected'];

      // Insert Logo --Start--
		$folder='Organization_logo';
		$field = 'logo'; 
		$file_name = $folder.'-'.strtotime('now');
		
		if($_FILES['logo']['tmp_name']!=''){
		  $_POST['logo']=upload_file($folder,$field,$file_name);
		
		}
      // Insert Logo --End--
	  
	  // Insert visiting_card_img Start--
		$folder='Organization_card';
		$field = 'visiting_card_img'; 
		$file_name = $folder.'-'.strtotime('now');
		
		if($_FILES['visiting_card_img']['tmp_name']!=''){
		  $_POST['visiting_card_img']=upload_file($folder,$field,$file_name);
		}
      // Insert visiting_card_img End--

      $crud1->insert();

      // Uncomment the following lines if you want to capture errors in the subsequent code block
      // $lastId = getLastInsertID($tablecustomerlist1, 'id');
      // foreach ($_POST['contact_name1'] as $key => $value) {
      //     // Your existing code here
      // }

      // Additional code...

  } catch (Exception $e) {
      // Display or log the error message
      echo "Error: " . $e->getMessage();
  }
}



if(isset($_POST['insertconverttolead'])){

  echo "ddddddddd";
  $table1 = 'crm_project_lead';
$crud1 = new crud($table1);

$_POST['entry_by'] = $_SESSION['user']['id'];
$log_id=$crud1->insert();

$cd= new crud('crm_lead_log');
 $_POST['lead_id']=$log_id;
 $cd->insert(); 	

// echo "<script>window.top.location='/crm_mod/pages/home/home.php'</script>";
}

if(isset($_POST['updateentrylead'])){

  echo"jjjjjj";
  $crud= new crud('crm_project_org');
  $crud->update('id');
  //  db_query('delete from crm_org_contacts where project_id="'.$id.'"');
  //     foreach ($_POST['contact_name1'] as $key => $value) { 
  //    if($_POST['contact_name1'][$key]!='') {
  //  $sql='INSERT INTO `crm_org_contacts`( `project_id`, `contact_name`, `contact_phone`, `contact_email`, `contact_designation`, `entry_by`, `entry_at`) VALUES ("'.$id.'","'.$_POST['contact_name1'][$key].'","'.$_POST['contact_phone1'][$key].'","'.$_POST['contact_email1'][$key].'","'.$_POST['contact_designation1'][$key].'","'.$_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
  //  db_query($sql);
  //  }
             
  //     }
    
    // echo "<script>window.top.location='/crm_mod/pages/home/home.php'</script>";
    
  }


 

 if(isset($_POST['update'])){

     

      // update Logo --Start--
		$folder='Organization_logo';
		$field = 'logo'; 
		$file_name = $folder.'-'.strtotime('now');
		
		if($_FILES['logo']['tmp_name']!=''){
		  $_POST['logo']=upload_file($folder,$field,$file_name);
		
		}
      // update Logo --End--
	  
	  // update visiting_card_img Start--
		$folder='Organization_card';
		$field = 'visiting_card_img'; 
		$file_name = $folder.'-'.strtotime('now');
		
		if($_FILES['visiting_card_img']['tmp_name']!=''){
		  $_POST['visiting_card_img']=upload_file($folder,$field,$file_name);
		}
      // update visiting_card_img End--
	 



     $_POST['update_by'] = $_SESSION['employee_selected'];

     $_POST['update_at'] = date('Y-m-d h:s:i');

     

     $crud1->update('id');

 }

 

 
//end







 $unique='task_id'; 
$title = "Task Management Dashboard";



$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');


//$table='crm_task_add_information';	


// $title = "All Lead List";

 

$tableprojectlead = 'crm_project_lead';

$tableleadcontacts = 'crm_lead_contacts';

$pbi_id  =  $_SESSION['employee_selected'];
$user_role  =  $_SESSION['user']['fname'];



$crud1 = new crud($table1);

//$crud2 = new crud($table2);









// Database Table Name Mainly related to this page

$crud    =new crud($table);
//for update..................................
// if(isset($_POST['update']))
// {
// $_POST['edit_at']=time();
// $_POST['edit_by']=$_SESSION['user']['id'];
// 		$crud->update($unique);
// 		$type=1;
// 		$msg='Successfully Updated.';
// }

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');



/*if($_SESSION['employee_selected']==0 || $_SESSION['employee_selected']==''){



header('location:../../../crm_mod/pages/home/index.php');



}*/



 

 $cur = '&#x9f3;';
 $table1 = 'crm_project_lead';

 //$table2 = 'crm_task_lists';

 //$table3 = 'crm_call_schedule';
 
 //$table4 = 'crm_campaign_management';

 

//  $crud1 = new crud($table1);

//  $crud2 = new crud($table2);

//  $crud3 = new crud($table3);
 
//  $crud4 = new crud($table4);

 


require "../include/custom.php";

//echo '<link rel="stylesheet" href="../include/Style/calendarStyle.css">';



?>



        <?php



            if(in_array($_SESSION['employee_selected'], $superID)){

                $con = "";

            }else{

                $con = " AND assigned_person_id = '".$_SESSION['employee_selected']."' ";

            } 

            

        	
// if(isset($$unique))
// {
// $condition=$unique."=".$$unique;	
// $data=db_fetch_object($table,$condition);
// foreach ($data as $key => $value)
// { $$key=$value;}
// }	
?>


        

<link rel="stylesheet" href="style.css">

<style>
.sidebar, .sidemenu{
	display:none;
    width: 0% !important;
}

.main_content{
	width: 100% !important;
}
  #example{
    margin: 0px !important;
  }
  .sorting{
    background-color: #f8fcfc !important;
  }
  .odd{
    background-color: 'red' !important;
  }

</style>

  <style>.nav-tabs .nav-link.active, .nav-tabs .nav-link.active:active, .nav-tabs .nav-link.active:focus, .nav-tabs .nav-link.active:visited, .nav-tabs .nav-link.active:hover{border-color: #bfc1f5;}
</style>










<style>
.sr-main-content-padding{
padding: 0px !important;

}
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


  .floatingshadowfahim{
    box-shadow: rgb(38 57 77 / 33%) 0px 20px 30px -10px;
    background-color: #fcfcfc !important;
	height: 100% !important;
    width: 100% !important;
    border-radius: 15px !important;
    padding: 15px !important;
  }
    .floatingshadowfahim .rounded{
	text-align:center;
	
	}
	
  .floatingshadowfahim h2 span, .floatingshadowfahim h2 i{
  	font-size:36px !important;
  }
  
  .floatingshadowfahim h2 span i, .floatingshadowfahim h2 i, .floatingshadowfahim h2 .textspan{
      top: 39px !important;
    position: relative;
  }
  
  .unplashscreen{
    /* background-color: whitesmoke; */
    /* background-image: url("bgunsplash3.jpg");
    background-size: cover; */
  }

  tr:nth-child(odd), tr:nth-child(even){
    /* box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px; */
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    background-color: #f3f7fa !important;
  }
  thead, tbody, tfoot, tr, td, th {
    border: none !important;
}
tr{
  margin-top: 5px;
}
table {
    border-spacing: 0px 0.3rem !important;
}
.dataTables_wrapper .dataTables_filter input {
    margin-left: 0.5em;
    
}
label {
    display: inline-block;
    border-radius: 10px;
    padding-bottom:10px;
    padding-right:10px;
    padding-left:10px;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    background-color: #f3f7fa !important;
}

.table>tbody {
    vertical-align: inherit;
   
}
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: 100px !important;
}

.dataTables_length label, .dataTables_filter  label{
display: flex;
    justify-content: center;
    align-items: center;
    padding-top: 9px;
}

#customerleadbutton{
z-index:100 !important;  
margin:5px; 
padding:10px !important; 
background-color: #0c8; 
color:#FFFFFF;
box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; 
cursor: pointer;
}
#customerleadbutton,#customerlistbutton{
    width: 135px;
    text-align: center;
}
#customerlistbutton{
z-index:100 !important;
 margin:5px; 
 padding:10px !important; 
 background-color: #3d90a7; 
color:#FFFFFF;
 box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
  cursor: pointer;
}

</style>

<script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>


<div class="unplashscreen  pr-0" id="topcard">

<div class="row pr-0">
 <div class="rounded col-sm-5" style="padding:25px; box-shadow: rgb(38 57 77 / 33%) 0px 20px 30px -10px; background-color: #fcfcfc !important;"><canvas id="leadChart"></canvas></div>
   <div class="col-sm-7 row">
   
   <div class="col-sm-6 pb-2">
            <div class="floatingshadowfahim">
                <div class="card-block">
                    <h6 class="m-b-20 p-2 rounded " style="background-color: #FBF4E2;">Total Active Lead</h6>
                    <h2 class="text-right" > <span> <i  class="fa-solid fa-users-medical f-left" style="color: #FBF4E2;"></i></span><span class="textspan"><?=find_a_field('crm_project_lead', 'count(id)', 'status = "1"')?></span></h2>
                    
                </div>
            </div>
        </div>
        
        <div class="col-sm-6 pb-2">
            <div class="floatingshadowfahim">
                <div class="card-block">
                    <h6 class="m-b-20 p-2 rounded "  style="background-color: #D8F0FA;"> Total Generated Lead</h6>
                    <h2 class="text-right"><i class="fa-solid fa-users-gear f-left" style="color: #D8F0FA;"></i><span class="textspan"><?=find_a_field('crm_project_lead', 'count(id)', '1')?></span></h2>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6 pb-2">
            <div class="floatingshadowfahim">
                <div class="card-block">
                    <h6 class="m-b-20 rounded p-2"  style="background-color: #F7E3EE;">Running Projects</h6>
                    <h2 class="text-right"><i class="fas fa-chart-pie f-left" style="color: #F7E3EE;"></i><span class="textspan"><?=find_a_field('crm_project_lead a, crm_project_org b', 'count(b.id)', 'a.organization=b.id AND a.status="1"')?></span></h2>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6 pb-2">
            <div class="floatingshadowfahim">
                <div class="card-block">
                    <h6 class="m-b-20 rounded p-2"  style="background-color: #D5DCAC;">Total Task</h6>
                    <h2 class="text-right"><i class="fas fa-tasks f-left" style="color: #D5DCAC;"></i><span class="textspan"><?=find_a_field('crm_task_add_information', 'count(task_id)', '1')?></span></h2>
                </div>
            </div>
        </div>
   </div>
 </div>
 
 <div class="col-sm-12" style="position: relative !important; bottom: -60px !important;  display: flex; flex-direction: row; justify-content: center; align-items: center;">
  <p id="customerleadbutton" class="rounded" href="/crm_mod/pages/org/show_all_org.php" onclick="toggleleadlist()">See Lead List</p>
  
 <p id="customerlistbutton" class="rounded" href="/crm_mod/pages/org/show_all_org.php" onclick="togglecustomerlist()">See Customer List</p>

</div>
 
 <!-- for leads list -->
 <div id="leadlistid">
        <div class="m-0 p-0 ">

                <table id="example1" class="table">
                                <thead>

                            <tr>
                                    <th>SN</th>
                                    <th>Organization</th>
                                    <th>Lead Name</th>

                            		<th>Product</th>

                                    <th>Assigned to</th>

                            		<th>Status</th>

                                    <th>Created at</th>

                                    <th>Action</th>

                            </tr>

                                </thead>

                                <tbody>

                                

                                <?php 

                                

                                    $sn = 1;

                                    if(in_array($_SESSION['employee_selected'], $superID)){

                                        $con = " 1 ";

                                    }else{

                                        $con = " assigned_person_id = '".$_SESSION['employee_selected']."' ";

                                    }

                                    
                                    if($user_role=="Admin"){
                                  
                                        $leadsQry = "SELECT a.*,o.name FROM $table1 a,crm_project_org o WHERE a.organization=o.id ORDER BY a.id DESC";
                                        
                                    }else{
                                        $leadsQry = "SELECT a.*,o.name FROM $table1 a,crm_project_org o WHERE a.organization=o.id and a.assign_person=$pbi_id ORDER BY a.id DESC";
                                    }
                                    
                                
                                    $rslt = db_query($leadsQry);

                                    while($row = mysqli_fetch_object($rslt)){

                                

                                ?>

                                

                                    <tr>

                                        <td><?=$row->id?></td>

                                        <td><?=$row->name?></td>
                                        <td><?=$row->lead_name?></td>

                            <td><?=find_a_field('crm_lead_products', 'products', 'id = "'.$row->product.'"')?></td>

                                        <td><?=find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "'.$row->assign_person.'"')?></td>

                            <td><?=find_a_field('crm_lead_status', 'status', 'id = "'.$row->status.'"')?></td>

                                        <td><?=$row->entry_at?></td>

                                        <td class="d-flex">

                                            <a class="btn2 btn1-bg-submit text-light mr-2" href="../info_maker/lead_details_show.php?view=<?=encrypTS($row->id)?>&tp='<?=encrypTS('lead')?>'"><i class="fa-solid fa-eye"></i></a>

                                        </td>

                                    </tr>

                                

                                <?php 

                                

                                    $sn++;

                                    

                                    } 

                                    

                                ?>

                                

                                </tbody>
                </table>   



        </div>

 </div>


 <div id="customerlistid" style="display:none;">

 <div class="row well">

<div class="col-md-12 text-right  pr-4">

    <a href="../home/home.php" class="btn btn-warning" style="margin-top:12px; margin-bottom:14px;">Go Back</a>

    <a data-toggle="modal" data-target="#leadentrymodal"  class="btn btn-success text-light" style="margin-top:12px; margin-bottom:14px;">+ Add New</a>

</div>    

</div>





<div class="col-md-12  m-0 p-0">

    <table id="example" class="table">

        

        <thead>

        <tr>

            <th>SN</th>

            <th>Name</th>

            <th>Entry By</th>

            <th>Created at</th>
            <?if($user_role=="Admin"){?> 
            <th>Action</th>
            <?}?>
            </tr>

        </thead>

        <tbody>

        

        <?php 

        

            $sn = 1;

            if(in_array($_SESSION['employee_selected'], $superID)){

                $con = " 1 ";

            }else{

              //  $con = " assigned_person_id = '".$_SESSION['employee_selected']."' ";

            }

            

            $leadsQry = "SELECT * FROM  $tablecustomerlist1 WHERE1 ";

            $rslt = db_query($leadsQry);

            while($row = mysqli_fetch_object($rslt)){
            
        ?>

  

        

            <tr>

                <td><?=$sn?></td>

                <td><?=$row->name?></td>

                <td><?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$row->entry_by.'"')?></td>

                <td><?=$row->entry_at?></td>
              <?if($user_role=="Admin"){?>
                <td class="d-flex justify-content-center">

                    <a class="btn2 btn1-bg-submit text-light" href="../info_maker/crm_view.php?view=<?=encrypTS($row->id)?>&tp='<?=encrypTS('lead')?>'"><i class="fa-solid fa-eye"></i></a>

                    <!-- <a class="btn2 btn1-bg-help" href="../lead/show.php?id=<?//=$row->id?>"><i class="fa-solid fa-pencil"></i></a> -->
                    <?php ?>
                    <!-- <?$sourcename=find_a_field('crm_lead_source', 'source', 'id ="'.$row->id.'"'); ?> -->
                    <button class="btn2 btn1-bg-update toggle" data-toggle="modal" data-target="#leadentrymodal"  onclick="openModalleadentry('<?=$row->id;?>', '<?=$row->name;?>', '<?=$row->website;?>','<?=$row->annual_revenue;?>','<?=$row->lead_source;?>','<?=$row->total_employees;?>','<?=$row->lead_type;?>','<?=$row->address;?>','<?=$row->district;?>','<?=$row->zip;?>','<?=$row->country;?>','<?=$row->division;?>','<?=htmlspecialchars(json_encode($row->description));?>',)"><i class="fa-solid fa-pencil" style="color: #ffffff;" ></i></button>
                   
                    </div>

                    
                     <!--<a class="btn2 btn1-bg-update text-light ml-2" href="/crm_mod/pages/org/org_lead.php?id=<?=$row->id?>">Convert to Lead</a>-->
                     <button class="btn2 btn1-bg-update text-light ml-2 toggle" data-toggle="modal" data-target="#convertToLead"
                     onclick="openModalConverttolead('<?=$row->id;?>','<?=$row->name;?>')"
                      >Convert to Lead</button>

                </td>
                <?}?>
            </tr>

        

        <?php 

        

            $sn++;

            

            } 

            

        ?>

        

        </tbody>


        

    </table>   

    

</div>











<!-- Modal Start Here -->

<?php if(isset($_GET['update'])){ 

$datas = find_all_field( $tablecustomerlist1, '', 'id="'.decrypTS($_GET['update']).' AND '.$con.'"'); 

if(isset($datas)){$assigned_id = $datas->assigned_person_id;}else{$assigned_id = $_SESSION['employee_selected'];} 

} ?>



<div id="leadentrymodal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

<div class="modal-dialog modal-lg">

<div class="modal-content">

<div class="modal-header">

    <h5 class="modal-title" id="leadentrymodalLongTitle"><?php if(isset($datas)){echo 'Update';}else{echo 'Create';}?> <?=$CRMleadName?></h5>

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

      <span aria-hidden="true">&times;</span>

    </button>

  </div>

  <form id="organizationentrytable" method="post" enctype="multipart/form-data">

  

  <div class="modal-body">

  <h5 class=text-center><?php if(isset($datas)){echo 'Update';}else{echo 'New';}?> <?=$CRMleadName?> Information</h5>

    <div class="row">

        

        <div class="col-sm-12">

            <table class="table">

              <tr>

                <td width="120">Organization Name </td>

                <td><input type="text" name="name" id="orgname" value="" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required></td>

              </tr>

          </table>

        </div>

     

        <div class="col-md-6 mt-2">

          <table class="table">

            <tbody>

                

              <?php /*?><tr>

                <td>Assigned to</td>

                <td>

                  <select name="assigned_person_id" id="assigned_person_id" class="selectpicker input_required"  data-live-search="true" required>

                    <?php 

                        

                        if(in_array($_SESSION['employee_selected'], $superID)){ 

                            foreign_relation('user_activity_management', 'distinct(PBI_ID)', 'fname', $datas->assigned_person_id, '1'); 

                        }else{ 

                            foreign_relation('user_activity_management', 'distinct(PBI_ID)', 'fname', $assigned_person_id, 'PBI_ID="'.$assigned_id.'"'); 

                        }

                        

                    ?>

                  </select>

                </td>

              </tr><?php */?>

              

              <tr>

                <td >Source </td>

                <td>
                <!-- <select name="lead_source" id="lead_source"  class="selectpicker input_general"  data-live-search="true"> -->
                  <select name="lead_source" id="lead_source"  class=" input_general"  data-live-search="true">

                    <option id="leadidmodal" value=""></option>

                        <?php foreign_relation('crm_lead_source', 'id', 'source', $datas->lead_source, '1'); ?>

                  </select>

                </td>

              </tr>

              

              <tr>

                <td>Employees</td>

                <td><input type="text" value="<?=$datas->total_employees?>" name="total_employees" id="total_employees" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>

              </tr>

              

              <tr>

                <td>Yearly Turnover </td>

                <td><input type="text" name="annual_revenue" id="annual_revenue" value="<?=$datas->annual_revenue?>" style="border-left: 3.5px solid #aeddf7 !important;" class="form-control"></td>

              </tr>


              <?php /*?><tr>

                <td><label>Product</label></td>

                <td>

                    <select type="text" name="product" value="<?=$datas->product?>" style="border-left: 3.5px solid #aeddf7 !important;" class="form-control">

                        

                        <?php foreign_relation('crm_lead_products', 'id', 'products', $datas->product, '1'); ?>

                    

                    </select>

                </td>

              </tr><?php */?>

              

            </tbody>

          </table>

        </div>

        <div class="col-md-6  mt-2">

          <table class="table">

            <tbody>

                

              <?php /*?><tr>

                <td>Company </td>

                <td><input type="text" name="company_name" value="<?=$datas->company_name?>" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required></td>

              </tr><?php */?>



              <tr >

                <td>Website</td>

                <td><input type="text" name="website" id="website" value="<?=$datas->website?>" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>

              </tr>

              

              <tr>

                <td>Type </td>

                <td>

                  <select name="lead_type" id="lead_type" class="input_general" data-live-search="true">

                    <option value="">--None--</option>

                        <?php foreign_relation('crm_lead_type', 'id', 'type', $datas->lead_type, '1'); ?>

                  </select>

                </td>

              </tr>

          
			  
			  
              <tr>

                <td>Organization Logo </td>

                <td><input type="file" name="logo" id="logo" value="<?=$datas->logo?>" style="border-left: 3.5px solid #aeddf7 !important;" class="form-control">
					<?php if ($logo!=''){?>
						<a href="../../../assets/support/upload_view.php?name=<?=$datas->logo?>&folder=Organization_logo&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank">View Attachment</a>
					<?php } ?>
				</td>

              </tr>
         <?php /*?>     <tr>

                <td>Status</td>

                <td>

                  <select name="status" class="selectpicker input_required" data-live-search="true" required>

                    <?php foreign_relation('crm_lead_status', 'id', 'status', $datas->status, '1'); ?>

                  </select>

                </td>

              </tr><?php */?>

              

              <?php /*?><tr>

                  <td><label>Logo</label></td>

                  <td>

                    <input type="file" name="logo" id="image" style="display:none;" accept=".png,.jpg,.jpeg">

                    <label for="image">

                        

                        <?php if($datas->logo!=NULL){echo '<span class="text-primary" style="cursor:pointer;font-size:11px;">'.$datas->logo.'</span>';}else{echo '<span class="text-info" style="cursor:pointer;font-size:11px;"><i class="fa fa-paperclip"></i> Attach</span>';} ?>

                        

                    </label>

                  </td>

              </tr><?php */?>

    

            </tbody>

          </table>

        </div>

     

    </div>

    

    <!-- <h5 class="text-center">Contact Information</h5>

     <span  id="addr0">

    <div class="row">

          <div class="col-md-6">

            <table class="table">

              <tbody>

                <tr>

                    <td>Contact Person </td>

                    <td><input type="text" name="contact_name1[]" value="<?=$datas->contact_name?>" style="border-left:3.5px solid #df5b5b!important;" class="form-control" required></td>

                </tr>

                  

                <tr>

                    <td>Phone </td>

                    <td><input type="text" name="contact_phone1[]" class="form-control " style="border-left:3.5px solid #df5b5b!important;" value="+880<?=$datas->contact_phone?>" ></td>

                </tr>

                

              </tbody>

            </table>

          </div>

          

          <div class="col-md-6">

            <table class="table">

              <tbody>

                  

                <tr>

                    <td>Email </td>

                    <td><input type="text" name="contact_email1[]" class="form-control" value="<?=$datas->contact_email?>" style="border-left:3.5px solid #df5b5b!important;"></td>

                </tr>

                

                <tr>

                  <td>Designation</td>

                  <td>

                    <input type="text" name="contact_designation1[]" id="designation" class="form-control" value="<?=$datas->contact_designation?>" style="border-left: 3.5px solid #aeddf7 !important;">

                  </td>

                </tr>

              </tbody>

            </table>

          </div>
          <div class="col-md-6"> <table class="table"> <tbody><tr><td>Department </td><td><input type="text" name="dept[]" style="border-left:3.5px solid #df5b5b!important;" class="form-control"></td></tbody></table></div>

       </div>

          </span>

      <span id="add_row" class="mx-auto text-light mt-3 mb-4 btn btn-primary btn-sm">+ Add Contact</span> -->

    <h5 class="text-center">Address Information</h5>

    <div class="row" id="cv">

      <div class="col-md-6">

        <table class="table">

          <tbody>

            <tr>

              <td>Address</td>

              <td><input type="text" value="<?=$datas->address?>" name="address" id="orgaddress" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>

            </tr>

            <tr>
              <td>Division</td>
              <td>
                  <select name="division" id="division" class=" input_general" data-live-search="true">
                    <option value="">--Select One--</option>
                    <?php foreign_relation('division','division_CODE','division_name',$datas->division,'1'); ?>
                  </select>
              </td>

            </tr>
               <tr>
              <td>Zip Code</td>
              <td>
                  <select name="zip" id="zip" class=" input_general" data-live-search="true">
                    <option value="">--Select One--</option>
                    <?php foreign_relation('crm_postalcode_list','id','concat(po_name,"-",po_code)',$datas->zip,'is_active=1 ORDER BY po_name'); ?>
                  </select>
              </td>

            </tr>

          </tbody>

        </table>

      </div>

      <div class="col-md-6">

        <table class="table">

          <tbody>

                          <tr>

                <td>Visiting Card </td>

                <td><input type="file" name="visiting_card_img" id="visiting_card_img" value="<?=$datas->visiting_card_img?>" style="border-left: 3.5px solid #aeddf7 !important;" class="form-control">
					<?php if ($visiting_card_img!=''){?>
						<a href="../../../assets/support/upload_view.php?name=<?=$datas->visiting_card_img?>&folder=Organization_logo&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank">View Attachment</a>
					<?php } ?>
				</td>

              </tr>

            <tr>

              <td>Country</td>

              <td>  

                <select name="country" id="country" class=" input_required" onChange="ccl()"  >

                  <option value="">--Select One--</option>

                  <?php foreign_relation('crm_country_management','id','country_name',$datas->country,'is_active=1 ORDER BY country_name'); ?>

                </select>

                

              </td>

            </tr>
            <tr>
              <td>District</td>
              <td>
                  <select name="district" id="district" class=" input_general" data-live-search="true">
                    <option value="">--Select One--</option>
                    <?php foreign_relation('district_list','id','district_name',$datas->district,'1'); ?>
                  </select>
              </td>

            </tr>

          </tbody>

        </table>

      </div>

        <div class="form-group pt-3 m-0 m-auto">

            <label for="message text-center">Description Information</label>

            <textarea name="description" id="description" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;" cols="40" rows="4"></textarea>

        </div>

        

    </div>

    

    <?php if(!isset($datas)){ ?>

    <div class="form-group pt-3 text-center">

        <input type="checkbox" name="send_a_mail">

        <label> Send a confirmation mail to contact</label>

    </div>

    <?php } ?>

    

  </div>

  

  <?//php if(!isset($datas)){ ?>

  <div class="modal-footer">

    <a type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</a>

    <button type="submit" class="btn btn-primary" id="orgsavebtn" name="insert">Save</button>

    <input  name="updateentrylead" type="submit" id="orgentryeditbtn" value="Update" class="btn1 btn1-bg-update d-none">

  </div>

  <?/*php }else{ ?>

    <div class="modal-footer">

        <input type="hidden" name="id" value="<?=$datas->id?>">

        <a type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</a>

        <button type="submit" class="btn btn-warning" name="update">Update</button>

    </div>

  <?php } */?>

  

  </form>

  

</div>

</div>

</div>

<!-- Modal End Here -->



<script>

var i=1;

$("#add_row").click(function(){



$('#addr0').append('<div class="row" id="cv'+i+'"><div class="col-md-12"><button idk="'+i+'" class="btn btn-danger btn_remove">X</button></div><div class="col-md-6"> <table class="table"> <tbody><tr><td>Contact Person </td><td><input type="text" name="contact_name1[]" style="border-left:3.5px solid #df5b5b!important;" class="form-control" required></td></tr><tr><td>Phone </td><td><input type="text" name="contact_phone1[]" class="form-control " style="border-left:3.5px solid #df5b5b!important;"  ></td></tr></tbody></table></div><div class="col-md-6"> <table class="table"> <tbody><tr><td>Email </td><td><input type="text" name="contact_email1[]" style="border-left:3.5px solid #df5b5b!important;" class="form-control" ></td></tr><tr><td>Designation </td><td><input type="text" name="contact_designation1[]" class="form-control " style="border-left:3.5px solid #df5b5b!important;"  ></td></tr></tbody></table></div><div class="col-md-6"> <table class="table"> <tbody><tr><td>Department </td><td><input type="text" name="dept[]" style="border-left:3.5px solid #df5b5b!important;" class="form-control"></td></tbody></table></div></div>');
i++;
});



$(document).on('click', '.btn_remove', function () {

    var button_id = $(this).attr("idk");

    $('#cv' + button_id + '').remove();

   

 });

 






</script>



 </div>


</div>
</div>



<!-- Model Convert lead  -->
<div class="modal fade" id="convertToLead" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">

        <div class="modal-content">

        <div class="modal-header">

            <h3 class="modal-title" id="exampleModalLongTitle">Organization to Lead Convert</h3>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

          </div>

          <form id="converttoleadform" method="post" >

          <input type="hidden" name="organization" id="organization">

          <div class="modal-body">

          <h5 class=text-center>Lead Information</h5>

            <div class="row">
                <div class="col-6">
				 <table class="table">
                    <tbody>
					<tr>
						<td>Organization Name</td>
            <td ><input type="text" name="organizationnamelead" readonly id="organizationnamelead"></td>
						<!-- <td><select  name="organization"  class=" input_general"  >
              <option id="converttoleadidioption" value=""></option>
						<? //foreign_relation('crm_project_org','id','name',$orgAll->id,'id='.$orgAll->id); ?>
						</select></td> -->
						</tr>
						<tr>
							<td>Enter Lead Name</td>
						 
								<td>
								<div >
								<input class="form-control" type="text" name="lead_name" id="lead_name">
								</div>
								
								</td>
						<!-- <td>Product</td>
						<td><select  name="product"  class=" input_general" required >
						<option></option>
						<? //foreign_relation('crm_lead_products','id','products',$product,'1'); ?>
						</select></td> -->
						</tr>
						 <tr>	
							<td>Enter Lead Value</td>
						 
							<td>
								<div >
								<input class="form-control" type="text" name="lead_value" id="lead_value">
								</div>
							
							</td>
						</tr>
						</tbody>
						</table>
						

                </div>
				
				<div class="col-6">
				<table class="table">
                    <tbody>
					<tr>
						<td>Lead Status</td>
						<td><select  name="status"  class=" input_general" required >
						<option></option>
						<? foreign_relation('crm_lead_status','id','status',$lead_status,'1'); ?>
						</select></td>
						</tr>
						<tr>
						<td>Assign Person</td>
						<td><select  name="assign_person"  class=" input_general" required >
						<option></option>
						<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$assign_person,'1'); ?>
				</select></td>
						</tr>
					</tbody>
					</table>
				
				</div>
				
				
            </div>
			<div class="modal-footer">

            <button type="submit" class="btn btn-primary" name="insertconverttolead">Save</button>

          </div>
          </form>

          

        </div>

      </div>

</div>
         
 



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('leadChart').getContext('2d');
        var leadData = {
            labels: ['Total Active Lead', 'Total Generated Lead'],
            datasets: [{
                data: [
                    <?=find_a_field('crm_project_lead', 'count(id)', 'status = "1"')?>,
                    <?=find_a_field('crm_project_lead', 'count(id)', '1')?>
                ],
                backgroundColor: ['#F7E3EE', '#D8F0FA']
            }]
        };
        var leadChart = new Chart(ctx, {
            type: 'pie',
            data: leadData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                }
            }
        });
    });

    function openModalleadentry(orgId, orgName, orgwebsite,orgyearlyturnover,sourcename,orgemployee,orgtype,orgaddress,orgdistrict,orgzip,orgcountry,orgdivision,orgdescription) {
      orgdescription = orgdescription.replace(/"/g, "");

      // description = description.replace(/\n/g, '<br>');

 
      
        // document.getElementById('id').value = contactId;
        document.getElementById('orgsavebtn').classList.add('d-none');// or 'inline' depending on your styling
        document.getElementById('orgentryeditbtn').classList.remove('d-none');// or 'inline' depending on your styling
        document.getElementById('orgname').value = orgName;
 
       var selectElement = document.getElementById('lead_source');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
  // Check the value of each option
    if (selectElement.options[i].value == sourcename) {
        selectElement.options[i].selected = true;
        break;
    }
}
        // document.getElementById('lead_type').value = orgName;
       var selectElement = document.getElementById('lead_type');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgtype) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('district');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgdistrict) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('zip');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgzip) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('country');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgcountry) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('division');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgdivision) {
        selectElement.options[i].selected = true;
        break;
    }
}

        document.getElementById('annual_revenue').value = orgyearlyturnover;
        document.getElementById('website').value = orgwebsite;
        document.getElementById('total_employees').value = orgemployee;
        document.getElementById('orgaddress').value = orgaddress;
        // document.getElementById('lead_type').value = orgtype;
        
        var idInput = document.createElement('input');
        idInput.setAttribute('type', 'hidden');
        idInput.setAttribute('name', 'id');
        idInput.setAttribute('id', 'id');
        idInput.setAttribute('value', orgId);

        // Append the id input field to the form using the form's ID
        var form = document.getElementById('organizationentrytable');
        form.appendChild(idInput);

        document.getElementById('description').value = orgdescription;

    }
    function openModalConverttolead(orgId,orgName) {
 
      document.getElementById('organization').value = orgId;
      document.getElementById('organizationnamelead').value = orgName;
    }
  
</script>


<script>
        $(document).ready(function () {
        $('#example1').DataTable();
		$('#example').DataTable();
		 table.page.len(10).draw();
    });

    $('#leadentrymodal').on('hidden.bs.modal', function(e) {
  $(this).find('#organizationentrytable')[0].reset();
});
    $('#convertToLead').on('hidden.bs.modal', function(e) {
  $(this).find('#converttoleadform')[0].reset();
});
		
	
//	$(document).ready(function() {
//    // Initialize DataTable
//    var table = $('#example').DataTable();
//
//    // Set the length of displayed records
//
//});

</script>

<script>
function togglecustomerlist(){
    document.getElementById("customerlistid").style.display = "block";

    //document.getElementById("customerlistbutton").style.transform = "scale(0.8)";
    document.getElementById("customerlistbutton").style.backgroundColor = "#0c8";
    document.getElementById("customerleadbutton").style.backgroundColor = "#3d90a7";
    document.getElementById("customerleadbutton").style.transform = "scale(1)";
    document.getElementById("leadlistid").style.display = "none";
}
function toggleleadlist(){
    document.getElementById("leadlistid").style.display = "block";

    //document.getElementById("customerleadbutton").style.transform = "scale(0.8)";
    document.getElementById("customerleadbutton").style.backgroundColor = "#0c8";
    document.getElementById("customerlistbutton").style.backgroundColor = "#3d90a7";
    document.getElementById("customerlistbutton").style.transform = "scale(1)";
    document.getElementById("customerlistid").style.display = "none";
}
</script>












<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>










