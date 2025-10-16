<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title = "Lead Info";

do_calander('#date');

 $cur = '&#x9f3;';

 $table1 = 'crm_project_lead';
 $tablecontact = 'crm_lead_contacts';
 $tableproductadd = 'crm_lead_product_individual';

 $uniqueproduct="product_individual_id";



 $crudcontact1 = new crud($tablecontact);
 $crudproductadd1 = new crud($tableproductadd);

 $pbi_id  =  $_SESSION['employee_selected'];
$user_role  =  $_SESSION['user']['fname'];


 $table2 = 'crm_task_lists';
 require "../include/custom.php";

 $id = decrypTS($_GET['view']);
 $orgId=find_a_field('crm_project_lead','organization','id="'.$id.'"');

 $qryrr = "SELECT * FROM crm_project_org WHERE id = '$orgId'";

 $rsltrr = db_query($qryrr);
 $rows = mysqli_fetch_object($rsltrr);
 $orgname=$rows->name;

 $type = decrypTS($_GET['tp']);
$condition="id=".$id;
$data=db_fetch_object('crm_project_lead',$condition);
while (list($key, $value)=@each($data))
{ $$key=$value;}


if(isset($_POST['submit']))
{

$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudcontact1->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
}
if(isset($_POST['productadd']))
{

$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudproductadd1->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';

        echo "<script>window.top.location='../info_maker/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

 
}

if (isset($_POST['scCall'])) {

	$crud   = new crud('crm_lead_activity');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();

	

	echo "<script>window.top.location='../info_maker/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

}
if(isset($_POST['updatecontact']))
{


$_POST['edit_at']=time();
$_POST['edit_by']=$_SESSION['user']['id'];
		$crudcontact1->update('id');
		$type=1;
		$msg='Successfully Updated.';
        echo "<script>window.top.location='../info_maker/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}
if(isset($_POST['cancelActivity']))
{

    $crud   = new crud('crm_lead_activity');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('activity_id');
		$type=1;
		$msg='Successfully Updated.';
        echo "<script>window.top.location='../info_maker/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}

if(isset($_POST['deleteproduct']))
{
       
        $product_individual_id = $_POST['product_individual_id'];

        
        $deletesql = "DELETE FROM crm_lead_product_individual WHERE product_individual_id = " . $product_individual_id;
        db_query($deletesql);
        $tr_type = "Delete";
        $type = 1;
        $msg = 'Successfully Deleted.';
        echo "<script>window.top.location='../info_maker/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

}

$tabletask='crm_task_add_information';		
$crudtask    =new crud($tabletask);		

if(isset($_POST['insertTasks']))
{

$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudtask->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
        echo "<script>window.top.location='../info_maker/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";


}

?>





<style>

.card1 {
  position: relative;
  width: 250px;
  padding: 20px;
  box-shadow: 3px 10px 20px rgba(0, 0, 0, 0.2);
  border-radius: 3px;
  border: 0;
  margin:15px;

}
.content1 {
    padding: 2px;
    display: flex;
    flex-direction: column;
  }


  /* #00d4ff */


  .company-info {

    padding: 20px;
    border-radius: 10px;
}

.company-info h2 {
    font-size: 24px; /* Increased font size */
            font-weight: bold; /* Made the text bold */

    color: #007bff;
}

.office-address {
    background-color: #e6f7ff;
    padding: 10px;
    border-radius: 5px;
}

.office-address h3 {
    color: #007bff;
}

.office-address a {
    color: #007bff;
    text-decoration: none;
}

.office-address a:hover {
    text-decoration: underline;
}

.card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            transition: box-shadow 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

</style>

<style>
    /* Style for the contact form container */
    .contact-form {
      max-width: 400px;
      margin: 0 auto;
    }

    /* Style for the scrollable div */
    .scrollable-div {
      max-height: 400px; /* Set a fixed height for the scrollable div */
      overflow-y: auto; /* Enable vertical scrolling */
      border: 1px solid #ccc;
      padding: 10px;
      scrollbar-width: thin;
      scrollbar-color: transparent transparent;
    }
    .scrollable-activity {
      max-height: 90%; /* Set a fixed height for the scrollable div */
      overflow-x: auto; /* Enable vertical scrolling */

      scrollbar-width: thin;
      scrollbar-color: transparent transparent;
    }
    .scrollable-div-product{
      max-height: 400px; /* Set a fixed height for the scrollable div */
      overflow-y: auto; /* Enable vertical scrolling */
      border: 1px solid #ccc;
      padding: 10px;
      scrollbar-width: thin;
      scrollbar-color: transparent transparent;
    }
  </style>

<style>
  .floatingshadowfahim{
    /* box-shadow: 0px 3px 9px 1px rgba(0, 10, 20, 0.2); */
    /* box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px; */
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    background-color: #f3f7fa !important;
  }
  .unplashscreen{
    /* background-color: whitesmoke; */
    /* background-image: url("bgunsplash3.jpg");
    background-size: cover; */
  }
</style>


<style>
@import url("https://fonts.googleapis.com/css?family=Montserrat:900");

#wrapper {
  box-sizing: border-box;
  display: flex;
  align-items: center;
  justify-content: center;
}
.my-super-cool-btn {
  position: relative;
  text-decoration: none;
  color: #fff;
  letter-spacing: 1px;
  font-size: 2rem;
  box-sizing: border-box;
}
.my-super-cool-btn span {
  position: relative;
  box-sizing: border-box;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 200px;
  height: 200px;
}
.my-super-cool-btn span:before {
  content: "";
  width: 100%;
  height: 100%;
  display: block;
  position: absolute;
  border-radius: 100%;
  border: 7px solid #f3cf14;
  box-sizing: border-box;
  transition: all 0.85s cubic-bezier(0.25, 1, 0.33, 1);
  box-shadow: 0 30px 85px rgba(0, 0, 0, 0.14), 0 15px 35px rgba(0, 0, 0, 0.14);
}
.my-super-cool-btn:hover span {
    font-size: 12px !important;
}
.my-super-cool-btn:hover p {
    font-size: 12px !important;
}
.my-super-cool-btn:hover span:before {

  transform: scale(0.8);
  box-shadow: 0 20px 55px rgba(0, 0, 0, 0.14), 0 15px 35px rgba(0, 0, 0, 0.14);
}
.my-super-cool-btn .dots-container {
  opacity: 0;
  animation: intro 1.6s;
  animation-fill-mode: forwards;
}
.my-super-cool-btn  .dot {
  width: 8px;
  height: 8px;
  display: block;
  background-color: #f3cf14;
  border-radius: 100%;
  position: absolute;
  transition: all 0.85s cubic-bezier(0.25, 1, 0.33, 1);
}
.my-super-cool-btn .btn-1 .dot {
    background-color: red;
}

.my-super-cool-btn .dot:nth-child(1) {
  top: 50px;
  left: 50px;
  transform: rotate(-140deg);
  animation: swag1-out 0.3s;
  animation-fill-mode: forwards;
  opacity: 0;
}
.my-super-cool-btn.btn-1 span:before {
  border: 7px solid #cadeef; /* Yellow */
}

.my-super-cool-btn.btn-2 span:before {
  border: 7px solid #9394a5; /* Green */
}

.my-super-cool-btn.btn-3 span:before {
  border: 7px solid #6bbf59; /* Blue */
}

.my-super-cool-btn.btn-4 span:before {
  border: 7px solid #FFB996; /* Red */
}
.my-super-cool-btn .dot:nth-child(2) {
  top: 50px;
  right: 50px;
  transform: rotate(140deg);
  animation: swag2-out 0.3s;
  animation-fill-mode: forwards;
  opacity: 0;
}
.my-super-cool-btn .dot:nth-child(3) {
  bottom: 50px;
  left: 50px;
  transform: rotate(140deg);
  animation: swag3-out 0.3s;
  animation-fill-mode: forwards;
  opacity: 0;
}
.my-super-cool-btn .dot:nth-child(4) {
  bottom: 50px;
  right: 50px;
  transform: rotate(-140deg);
  animation: swag4-out 0.3s;
  animation-fill-mode: forwards;
  opacity: 0;
}
.my-super-cool-btn:hover .dot:nth-child(1) {
  animation: swag1 0.3s;
  animation-fill-mode: forwards;
}
.my-super-cool-btn:hover .dot:nth-child(2) {
  animation: swag2 0.3s;
  animation-fill-mode: forwards;
}
.my-super-cool-btn:hover .dot:nth-child(3) {
  animation: swag3 0.3s;
  animation-fill-mode: forwards;
}
.my-super-cool-btn:hover .dot:nth-child(4) {
  animation: swag4 0.3s;
  animation-fill-mode: forwards;
}
@keyframes intro {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
@keyframes swag1 {
  0% {
    top: 50px;
    left: 50px;
    width: 8px;
  }
  50% {
    width: 30px;
    opacity: 1;
  }
  100% {
    top: 20px;
    left: 20px;
    width: 8px;
    opacity: 1;
  }
}
@keyframes swag1-out {
  0% {
    top: 20px;
    left: 20px;
    width: 8px;
  }
  50% {
    width: 30px;
    opacity: 1;
  }
  100% {
    top: 50px;
    left: 50px;
    width: 8px;
    opacity: 0;
  }
}
@keyframes swag2 {
  0% {
    top: 50px;
    right: 50px;
    width: 8px;
  }
  50% {
    width: 30px;
    opacity: 1;
  }
  100% {
    top: 20px;
    right: 20px;
    width: 8px;
    opacity: 1;
  }
}
@keyframes swag2-out {
  0% {
    top: 20px;
    right: 20px;
    width: 8px;
  }
  50% {
    width: 30px;
    opacity: 1;
  }
  100% {
    top: 50px;
    right: 50px;
    width: 8px;
    opacity: 0;
  }
}
@keyframes swag3 {
  0% {
    bottom: 50px;
    left: 50px;
    width: 8px;
  }
  50% {
    width: 30px;
    opacity: 1;
  }
  100% {
    bottom: 20px;
    left: 20px;
    width: 8px;
    opacity: 1;
  }
}
@keyframes swag3-out {
  0% {
    bottom: 20px;
    left: 20px;
    width: 8px;
  }
  50% {
    width: 30px;
    opacity: 1;
  }
  100% {
    bottom: 50px;
    left: 50px;
    width: 8px;
    opacity: 0;
  }
}
@keyframes swag4 {
  0% {
    bottom: 50px;
    right: 50px;
    width: 8px;
  }
  50% {
    width: 30px;
    opacity: 1;
  }
  100% {
    bottom: 20px;
    right: 20px;
    width: 8px;
    opacity: 1;
  }
}
@keyframes swag4-out {
  0% {
    bottom: 20px;
    right: 20px;
    width: 8px;
  }
  50% {
    width: 30px;
    opacity: 1;
  }
  100% {
    bottom: 50px;
    right: 50px;
    width: 8px;
    opacity: 0;
  }
}

span {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 17px !important;
        font-weight:900 !important;
    }
.my-super-cool-btn p{
    font-size: 17px !important;
        font-weight:900 !important;
}
</style>

<div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

        <!-- Content for the first column -->
        <div>
            <div class="card p-3 scrollable-div">
                <div class="title">
                <div class="d-flex justify-content-end"> </i></div>
                        <h1 class="myh6">Company Name</h1>
                        <h2>"Contact Information"</h2>

                        
                </div>
                <?php
          
         $sqlTasks = "SELECT * FROM crm_lead_contacts  WHERE lead_id = $id;";
            $resultTasks = db_query($sqlTasks);

            while ($row = mysqli_fetch_object($resultTasks)) {
?>
                <div class="content1 rounded p-2 " style="background-color:#f3f7fa !important;margin-top: 20px; box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;">
                   <div class="d-flex justify-content-between align-items-center ">
                      <h1><?=$row->contact_name;?></h1>

                      <button type="button" class="border-0" data-toggle="modal"
                        data-target="#contactmodal"
                        onclick="openModalcontact('<?=$row->id;?>', '<?=$row->contact_name;?>', '<?=$row->contact_phone;?>','<?=$row->contact_email;?>','<?=$row->contact_designation?>')">
                        <i class="fa-solid fa-pen-to-square"></i>
                </button>
                     
                   </div>
                   
                        <div class="social">
                            <h1>Designation:<?=$row->contact_designation?></h1>
                            <h1><span><i class="fa-solid fa-phone"></i> </span>Phone Number :<?=$row->contact_phone?></h1>
                        </div>
                        <div class="social">
                            
                            <h1><span><i class="fa-solid fa-envelope"></i> </span>Email : <?=$row->contact_email?></h1>
                        </div>
                        <div class="circle"></div>
                </div>
              <?}?>
            

            </div>
            <div class="d-flex justify-content-center p-3" >
            <button class="btn toggle" style="background-color:#39ace7 !important"><i class="fa-solid fa-plus" data-toggle="modal" data-target="#contactmodal">ADD CONTACT</i></button>
                </div>
        </div>
      </div>
 <div class="col-md-6">
        <!-- Content for the first column -->
        <div class="card">
        <?php
         
         $sqlTasks = "SELECT * FROM crm_project_lead join crm_project_org ON crm_project_lead.organization=crm_project_org.id WHERE crm_project_lead.id = $id;";
            $resultTasks = db_query($sqlTasks);

            if($row = mysqli_fetch_object($resultTasks)) {
?>
        <div class="company-info">
            <p class="myh6 d-flex justify-content-center" style="background-color: #D8F0FA;"><?=$orgname?></p>
            <p style="font-size: 15px !important;"><i class="fa-solid fa-magnifying-glass-arrow-right"></i>Lead Source <?=$row->lead_source?></p>
            <p style="font-size: 15px !important;"><i class="fa-solid fa-coins"></i>Organization Revenue: <?=$row->annual_revenue?></p>
            <div class="circle" ></div>
            <div class="officetype">
           
            <p style="font-size: 15px !important;"><i class="fa-solid fa-coins"></i>Lead Value: <?=$row->lead_value?></p>
            <!-- <p style="font-size: 15px !important;"><i class="fa-solid fa-users"></i> Total Employee(s): 100</p> -->
            </div>
            <div class="circle"></div>
            
            <div class="office-address">
            
                <h3 style="font-size: 30px;"> Office Address</h3>
                <p style="font-size: 15px !important;"><i class="fa-solid fa-briefcase"></i>  Address: <?=$row->address?>, <?=$row->city?>,<?=$row->district?>,<?=$row->division?>, <?=$row->zip?></p>
                <p style="font-size: 15px !important;"><i class="fa-solid fa-globe"></i> <a href=""></a> Website: <?=$row->website?>,</p>
            </div>
            <div class="circle"></div>
        </div>
      <?}?>

</div>




        <!-- end Content for the first column -->
      </div>
      <div class="col-md-3">
        <!-- Content for the first column -->

       <div>
                <div class="card scrollable-div-product" style="background-color:#ff0000;">

            <div class="card-header">
            <div class=" d-flex justify-content-end"> <i class="fa-solid fa-pen-to-square"></i></div>
                Product List
            </div>
                <div class="list-group " style="">
                <?php
         
         $sqlTasks = "SELECT * FROM crm_lead_products  JOIN crm_lead_product_individual ON crm_lead_products.id=crm_lead_product_individual.product_id WHERE crm_lead_product_individual.lead_id=$id;";
            $resultTasks = db_query($sqlTasks);

            while ($row = mysqli_fetch_object($resultTasks)) { ?>
                        <div>
                            <div class="d-flex justify-content-between align-items-center ">
                                <li class="list-group-item"><?=$row->products?></li>
                    <?php 
                       if (mysqli_num_rows($resultTasks) > 1) {
                    ?>
                     <button type="button" class="border-0" data-toggle="modal"
                        data-target="#productaddmodaldelete"
                        onclick="openModalproduct('<?=$row->product_individual_id;?>', '<?=$row->products?>')"
                        >
                        <i class="fa-solid fa-trash"></i>
                        <?}?>

                            </div>
                            <?}?>
                            <div class="circle"></div>
                        </div>
              

                 
    </div>

 </div>
 <div class="d-flex justify-content-center p-3" >
            <button class="btn toggle" style="background-color:#39ace7 !important"><i class="fa-solid fa-plus" data-toggle="modal" data-target="#productaddmodal">ADD PRODUCT</i></button>
                </div>
       </div>
        
        <!-- end Content for the first column -->
      </div>
    </div>
</div>


<div class="container-fluid">



<div style="display: flex; flex-direction: row; justify-content: space-around; align-items: center;">
   <div style="display: flex; flex-wrap: wrap; justify-content: space-around; align-items: center;  width: 100%; height: 50vh;">

   <div id="wrapper">
  <button data-toggle="modal" data-target="#schedulecall" style="background-color: transparent; border:none;" href="#" class="my-super-cool-btn btn-1">

    <div class="dots-container">
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
    <div>
       
       <span style="color:black !important;"> Schedule a Call <i class="fa-solid fa-plus"></i> </span>
     </div>

  </button>
</div>
   <div id="wrapper">
  <button data-toggle="modal" data-target="#schedulemeeting" style="background-color: transparent; border:none;" href="#" class="my-super-cool-btn btn-2">
    <div class="dots-container">
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
    <div>
       
       <span style="color:black !important;"> Schedule a <p>Meeting</p>  <i class="fa-solid fa-plus"></i> </span>
     </div>
  </button>
</div>
   <div id="wrapper">
  <button data-toggle="modal" data-target="#schedulevisit" style="background-color: transparent; border:none;" href="#" class="my-super-cool-btn btn-3">
    <div class="dots-container">
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
    <div>
       
       <span style="color:black !important;"> Schedule a Visit <i class="fa-solid fa-plus"></i> </span>
     </div>
    
  </button>
</div>
   <div id="wrapper">
  <button data-toggle="modal" data-target="#scheduleemail" style="background-color: transparent; border:none;" href="#" class="my-super-cool-btn btn-4">
    <div class="dots-container">
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
    <div>
       
      <span style="color:black !important;"> Schedule a Email <i class="fa-solid fa-plus"></i> </span>
    </div>
   
  </button>
</div>

<div id="wrapper">
  <button data-toggle="modal" data-target="#addtaskmodal" style="background-color: transparent; border:none;" href="#" class="my-super-cool-btn btn-3">
    <div class="dots-container">
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
    <div>
       
       <span style="color:black !important;"> Add a task<i class="fa-solid fa-plus"></i> </span>
     </div>
    
  </button>
</div>
    

        
   </div>
 </div>
 
 
    
<!-- Start sticky note -->



    
<!-- Start sticky note -->


<style>
    

    .card-big-shadow {
        max-width: 320px;
        position: relative;
    }

    .coloured-cards .mycard {
        margin-top: 30px;
    }

    .mycard[data-radius="none"] {
        border-radius: 0px;
    }
    .mycard {
        border-radius: 8px;
        box-shadow: 0 2px 2px rgba(204, 197, 185, 0.5);
        background-color: #FFFFFF;
        color: #252422;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }


    .mycard[data-background="image"] .title, .mycard[data-background="image"] .stats, .mycard[data-background="image"] .category, .mycard[data-background="image"] .description, .mycard[data-background="image"] .content, .mycard[data-background="image"] .card-footer, .mycard[data-background="image"] small, .mycard[data-background="image"] .content a, .mycard[data-background="color"] .title, .mycard[data-background="color"] .stats, .mycard[data-background="color"] .category, .mycard[data-background="color"] .description, .mycard[data-background="color"] .content, .mycard[data-background="color"] .card-footer, .mycard[data-background="color"] small, .card[data-background="color"] .content a {
        color: #FFFFFF;
    }
    .mycard.card-just-text .ourcontent {
        padding: 50px 65px;
        text-align: center;
    }
    .mycard .content {
        padding: 20px 20px 10px 20px;
    }
    .mycard[data-color="blue"] .category {
        color: #7a9e9f;
    }

    .mycard .category, .mycard .label {
        font-size: 14px;
        margin-bottom: 0px;
    }
    .card-big-shadow:before {
        background-image: url("http://static.tumblr.com/i21wc39/coTmrkw40/shadow.png");
        background-position: center bottom;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        bottom: -12%;
        content: "";
        display: block;
        left: -12%;
        position: absolute;
        right: 0;
        top: 0;
        z-index: 0;
    }
    h4, .myh4 {
        font-size: 1.5em;
        font-weight: 600;
        line-height: 1.2em;
    }
    h6, .myh6 {
        font-size: 2.5em;
        font-weight: 1000;
        text-transform: uppercase;
    }
    .mycard .description {
        font-size: 16px;
        color: #66615b;
        display: -webkit-box;
        /* Set as a block element */
        /* -webkit-line-clamp: 4; */
        /* Limit to 5 lines */
        /* -webkit-box-orient: vertical; */
        /* overflow: hidden; */
        /* Set vertical orientation */
        /* text-overflow: ellipsis; */
        /* Add ellipsis for overflow text */
    }
    .mycontent-card{
        margin-top:30px;    
    }
    a:hover, a:focus {
        text-decoration: none;
    }

    /======== COLORS ===========/
    .mycard[data-color="blue"] {
        background: #b8d8d8;
    }
    .mycard[data-color="blue"] .description {
        color: #506568;
    }

    .mycard[data-color="green"] {
        background: #d5e5a3;
    }
    .mycard[data-color="green"] .description {
        color: #60773d;
    }
    .mycard[data-color="green"] .category {
        color: #92ac56;
    }

    .mycard[data-color="yellow"] {
        background: #ffe28c;
    }
    .mycard[data-color="yellow"] .description {
        color: #b25825;
    }
    .mycard[data-color="yellow"] .category {
        color: #d88715;
    }

    .mycard[data-color="brown"] {
        background: #d6c1ab;
    }
    .mycard[data-color="brown"] .description {
        color: #75442e;
    }
    .mycard[data-color="brown"] .category {
        color: #a47e65;
    }

    .mycard[data-color="purple"] {
        background: #baa9ba;
    }
    .mycard[data-color="purple"] .description {
        color: #3a283d;
    }
    .mycard[data-color="purple"] .category {
        color: #5a283d;
    }

    .mycard[data-color="orange"] {
        background: #ff8f5e;
    }
    .mycard[data-color="orange"] .description {
        color: #772510;
    }
    .mycard[data-color="orange"] .category {
        color: #e95e37;
    }
    .mycard[data-color="red"] {
    background: #ffcccc;
    }

    .mycard[data-color="teal"] {
        background: #a7e6e3;
    }
    .mycard[data-color="teal"] .description {
        color: #004c4c;
    }
    .mycard[data-color="teal"] .category {
        color: #1aa39c;
    }

    .mycard[data-color="grey"] {
        background: #e6e6e6;
    }
    .mycard[data-color="grey"] .description {
        color: #4d4d4d;
    }
    .mycard[data-color="grey"] .category {
        color: #808080;
    }
    .mycard[data-color1="white"] {
            background: #f3f7fa !important;
        }

    .mycard[data-color="pink"] {
        background: #ffc0cb;
    }
    .mycard[data-color="pink"] .description {
        color: #800080;
    }
    .mycard[data-color="pink"] .category {
        color: #ff69b4;
    }

    .mycard[data-color="cyan"] {
        background: #7fffd4;
    }
    .mycard[data-color="cyan"] .description {
        color: #008b8b;
    }
    .mycard[data-color="cyan"] .category {
        color: #00cccc;
    }
</style>


  <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>


<!-- meeting -->


<div class="container card-stats" >
        <div class="container bootstrap snippets bootdeys" >
                    <div class="circle"></div>
                    <p style="width: 100% !important; text-align: center; padding-top:15px !important; font-size:40px !important;font-weight:900 !important;">MEETINGS</p>
                            <div class="row">
                                <?php
                                $currentDateTime = date("Y-m-d H:i:s");
                                $sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'Meeting' AND status != 'cancelled' ORDER BY activity_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
                                ?>

                                <div class="col-md-4 col-sm-6 mycontent-card">
                                    <div class="card-big-shadow">
                                        <div class="mycard card-just-text" data-background="color" data-color="blue" data-radius="none">
                                            <div class="ourcontent">
                                                <h6 class="myh6 category"><?=$row->activity_type;?></h6>
                                                <!-- <h4 class="myh4 title"><a href="#"><?=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');?></a></h4> -->
                                                <h4 class="myh4 category"><?=$row->date;?></h4>
                                                <h4 class="myh4 category"><?=$row->time;?></h4>
                                                <p class="description"><?=$row->details;?> </p>
                                                  <div class="d-flex justify-content-between align-items-center ">
                                                       <a class="btn btn-sm btn-info mr-2" href="../info_maker/lead_task_details_show.php?leadid=<?=encrypTS($id)?>&activityid='<?=encrypTS($row->id)?>'"><i class="fa-solid fa-eye"></i></a>
                                                       <button type="button" class="border-0" data-toggle="modal"
                                                                data-target="#activityCancelModal"
                                                                onclick="openModalcancelmeeting('<?=$row->activity_id;?>')"
                                                        >
                                                        <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                   </div>
                                            </div>
                                        </div> <!-- end card -->
                                    </div>
                                </div>
                            
                                <?php } ?>

                            </div>
                
        </div>
                                


 




        <!-- Meeting -->

<div class="container card-stats">
<div class="container bootstrap snippets bootdeys">
        <div class="circle"></div>
        <p style="width: 100% !important; text-align: center; padding-top:15px !important; font-size:40px !important;font-weight:900 !important;">CAllS</p>

                    <div class="row">




        <?php
        $currentDateTime = date("Y-m-d H:i:s");
        $sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'call' AND status != 'cancelled' ORDER BY activity_id DESC;";
        $resultTasks = db_query($sqlTasks);

        while ($row = mysqli_fetch_object($resultTasks)) {
        ?>

        <div class="col-md-4 col-sm-6 mycontent-card">
            <div class="card-big-shadow">
                <div class="mycard card-just-text" data-background="color" data-color="blue" data-radius="none">
                    <div class="ourcontent">
                        <h6 class="myh6 category"><?=$row->activity_type;?></h6>
                        <!-- <h4 class="myh4 title"><a href="#"><?=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');?></a></h4> -->
                        <h4 class="myh4 category"><?=$row->date;?></h4>
                        <h4 class="myh4 category"><?=$row->time;?></h4>
                        <p class="description"><?=$row->details;?> </p>

                        <div class="d-flex justify-content-between align-items-center ">
                                                       <a class="btn btn-sm btn-info mr-2" href="../info_maker/lead_task_details_show.php?leadid=<?=encrypTS($id)?>&activityid='<?=encrypTS($row->id)?>'"><i class="fa-solid fa-eye"></i></a>
                                                       <button type="button" class="border-0" data-toggle="modal"
                                                                data-target="#activityCancelModal"
                                                                onclick="openModalcancelmeeting('<?=$row->activity_id;?>')"
                                                        >
                                                        <i class="fa-solid fa-xmark"></i>
                        </button>
                            </div>
                    </div>
                </div> <!-- end card -->
            </div>
       </div>
        <?php } ?>
     

<!-- VIsit -->

<div class="container card-stats">
<div class="container bootstrap snippets bootdeys">
<div class="circle"></div>
<p style="width: 100% !important; text-align: center; padding-top:15px !important; font-size:40px !important;font-weight:900 !important;">VISITS</p>

            <div class="row">






  <?php
$currentDateTime = date("Y-m-d H:i:s");
$sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'visit' ORDER BY activity_id DESC;";
$resultTasks = db_query($sqlTasks);

while ($row = mysqli_fetch_object($resultTasks)) {
?>

<div class="col-md-4 col-sm-6 mycontent-card">
    <div class="card-big-shadow">
        <div class="mycard card-just-text" data-background="color" data-color="blue" data-radius="none">
            <div class="ourcontent">
                <h6 class="myh6 category"><?=$row->activity_type;?></h6>
                <!-- <h4 class="myh4 title"><a href="#"><?=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');?></a></h4> -->
                <h4 class="myh4 category"><?=$row->date;?></h4>
                <h4 class="myh4 category"><?=$row->time;?></h4>
                <p class="description"><?=$row->details;?> </p>

                <div class="d-flex justify-content-between align-items-center ">
                                                       <a class="btn btn-sm btn-info mr-2" href="../info_maker/lead_task_details_show.php?leadid=<?=encrypTS($id)?>&activityid='<?=encrypTS($row->id)?>'"><i class="fa-solid fa-eye"></i></a>
                                                       <button type="button" class="border-0" data-toggle="modal"
                                                                data-target="#activityCancelModal"
                                                                onclick="openModalcancelmeeting('<?=$row->activity_id;?>')"
                                                        >
                                                        <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                   </div>
            </div>
        </div> <!-- end card -->


        
    </div>
</div>
<?php } ?>
<!-- VIsit -->

<div class="container card-stats">
<div class="container bootstrap snippets bootdeys">
<div class="circle"></div>
<p style="width: 100% !important; text-align: center; padding-top:15px !important; font-size:40px !important;font-weight:900 !important;">EMAILS</p>

            <div class="row">






  <?php
$currentDateTime = date("Y-m-d H:i:s");
$sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'Email' ORDER BY activity_id DESC;";
$resultTasks = db_query($sqlTasks);

while ($row = mysqli_fetch_object($resultTasks)) {
?>

<div class="col-md-4 col-sm-6 mycontent-card">
    <div class="card-big-shadow">
        <div class="mycard card-just-text" data-background="color" data-color="blue" data-radius="none">
            <div class="ourcontent">
                <h6 class="myh6 category"><?=$row->activity_type;?></h6>
                <!-- <h4 class="myh4 title"><a href="#"><?=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');?></a></h4> -->
                <h4 class="myh4 category"><?=$row->date;?></h4>
                <h4 class="myh4 category"><?=$row->time;?></h4>
                <p class="description"><?=$row->details;?> </p>

                <div class="d-flex justify-content-between align-items-center ">
                                                       <a class="btn btn-sm btn-info mr-2" href="../info_maker/lead_task_details_show.php?leadid=<?=encrypTS($id)?>&activityid='<?=encrypTS($row->id)?>'"><i class="fa-solid fa-eye"></i></a>
                                                       <button type="button" class="border-0" data-toggle="modal"
                                                                data-target="#activityCancelModal"
                                                                onclick="openModalcancelmeeting('<?=$row->activity_id;?>')"
                                                        >
                                                        <i class="fa-solid fa-xmark"></i>
                                                        </button>
                            </div>
                        </div>
                </div> <!-- end card -->

            </div>
            </div>
<?php } ?>
</div>

<div>
    <div class="circle"></div>
    <p style="width: 100% !important; text-align: center; padding-top:15px !important; font-size:40px !important;font-weight:900 !important;">tasks</p>


    <div class="row">
    <?php



$currentDateTime = date("Y-m-d H:i:s");
$sqlTasks = "SELECT * FROM crm_task_add_information WHERE lead_id=$id  ORDER BY task_id DESC";
$resultTasks = db_query($sqlTasks);

while ($row = mysqli_fetch_object($resultTasks)) {
?>
<div class="col-md-4 col-sm-6 mycontent-card">
    
    <div class="card-big-shadow">
        <div class="mycard card-just-text"data-background="color" data-color="blue" data-radius="none">
            <div class="ourcontent">
                <h6 class="myh6 category"><?=$row->task_name;?></h6>
                <h4 class="myh4 title"><a href="#"><?=find_a_field('crm_project_org','name','id="'.$row->organization_id.'"');?></a></h4>
                <h4 class="myh4 category"><?=$row->task_date;?></h4>
                <h4 class="myh4 category"><?=$row->task_time;?></h4>
                <p class="description"><?=$row->task_details;?> </p>
                <button type="button" class="btn btn-outline-success" data-toggle="modal"
                        data-target="#exampleModalCenter"
                        data-task-id="<?=$row->task_id;?>"
                        data-task-name="<?=$row->task_name;?>"
                        data-task-details="<?=$row->task_details;?>"
                        onclick="openModalfortask('<?=$row->task_id;?>', '<?=$row->task_name;?>', '<?=$row->task_details;?>')">
                         Show More
                </button>
            </div>
        </div> <!-- end card -->
    </div>
</div>
<?php } ?>
    </div>

</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    // Define arrays of colors for background and text (excluding white)
    var backgroundColors = ["blue", "green", "yellow", "brown", "purple",  "cyan", "pink", "grey"];
    var textColors = ["blue", "green", "yellow", "brown", "purple",  "cyan", "pink", "grey"];

    // Select all elements with class 'mycard'
    var cards = document.querySelectorAll('.mycard');

    // // Set the first card to have a white background
    // cards[0].setAttribute('data-background', 'white');
    // cards[0].setAttribute('data-color', 'black'); // You can set the text color as well

    // Loop through each card starting from the second one
    for (var i = 0; i < cards.length; i++) {
        // Generate a random index to select a color from the arrays
        var randomBackgroundIndex = Math.floor(Math.random() * backgroundColors.length);
        var randomTextIndex = Math.floor(Math.random() * textColors.length);

        // Get the random colors
        var randomBackgroundColor = backgroundColors[randomBackgroundIndex];
        var randomTextColor = textColors[randomTextIndex];

        // Set the data-background attribute to the random background color
        cards[i].setAttribute('data-background', randomBackgroundColor);
        // Set the data-color attribute to the random text color
        cards[i].setAttribute('data-color', randomTextColor);

        // Add the random color classes to the card
        cards[i].classList.add('mycard[data-background="' + randomBackgroundColor + '"]');
        cards[i].classList.add('mycard[data-color="' + randomTextColor + '"]');
    }
});

    

    function openModalcontact(contactId, contactName, contactphone,contactemail,contactdesignation) {
        console.log(contactId, contactName, contactphone,contactemail,contactdesignation)
        document.getElementById('id').value = contactId;
        document.getElementById('contactsave').classList.add('d-none');// or 'inline' depending on your styling
        document.getElementById('contactedit').classList.remove('d-none');// or 'inline' depending on your styling
        document.getElementById('contact_name').value = contactName;
        document.getElementById('contact_phone').value = contactphone;
        document.getElementById('contact_email').value = contactemail;
        document.getElementById('contact_designation').value = contactdesignation;

    }
    function openModalproduct(productId, productName) {
        console.log(productId)
        document.getElementById('product_individual_id').value = productId;
     // or 'inline' depending on your 

    }
    function openModalcancelmeeting(activityId) {
        console.log(activityId)
        document.getElementById('activity_id').value = activityId;
     // or 'inline' depending on your 


    }

    function openModalfortask(taskId, taskName, taskDetails) {
    console.log(taskId, taskName, taskDetails);
    document.getElementById('tasktittleid').innerText = taskName;
    document.getElementById('exampleDetailsid').innerText = 'Task Details: ' + taskDetails;
}

    // JavaScript to handle modal show event
</script>




<!-- End Sticky note -->


</div>


</div>



<!-- Meeting Cancel Modal -->
<div class="modal fade" id="activityCancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-body1" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Activity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        

            <form method="post">
                <div class="modal-body">

                    <!-- <input type="hidden" name="product_individual_id" id="product_individual_id" value="" /> -->
                    <input  type="hidden" name="activity_id" id="activity_id" value="" />
                    <input type="hidden" name="status" id="status" value="cancelled" />
                


                <p>Are You sure to cancel</p>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                    <input name="cancelActivity" type="submit" id="cancelactivity" value="OK" class="btn1 btn1-bg-submit">
                    
                    <!-- <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button> -->
                </div>
            </form>
        </div>
    </div>
</div>
<!-- product delete modal -->
<div class="modal fade" id="productaddmodaldelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-body1" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        

            <form method="post" id="contacttable">
                <div class="modal-body">

                    <!-- <input type="hidden" name="product_individual_id" id="product_individual_id" value="" /> -->
                    <input type="text" name="<?=$uniqueproduct?>" id="<?=$uniqueproduct?>" value="" />
                />


                <p>Are You sure</p>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                    <input name="deleteproduct" type="submit" id="deleteproduct" value="Delete" class="btn1 btn1-bg-submit">
                    <input  name="deleteproduct" type="submit" id="deleteproduct" value="Update" class="btn1 btn1-bg-update d-none">
                    <!-- <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button> -->
                </div>
            </form>
        </div>
    </div>
</div>





<!-- Model product add information -->
    <div class="modal fade" id="productaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-body1" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Products</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                   

                    <form method="post" id="contacttable">
                        <div class="modal-body">

                            <input type="hidden" name="product_individual_id" id="product_individual_id" value="" />
                            <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                         


                            <div class="form-group row m-0 pt-1">
                                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Lead Organization</label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                     <p><?=$orgname?></p>
                                </div>
                            </div>

                            <div class="form-group row m-0 pt-1">
                                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact Person Name:</label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                                <select class="form-control req" name="product_id" id="product_id">
						
						          <? foreign_relation('crm_lead_products','id','products',$product,'1'); ?>
						       </select>
                                </div>
                            </div>






                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                            <input name="productadd" type="submit" id="productadd" value="SAVE" class="btn1 btn1-bg-submit">
                            <input  name="updateproduct" type="submit" id="productedit" value="Update" class="btn1 btn1-bg-update d-none">
                            <!-- <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button> -->
                        </div>
                    </form>
                </div>
            </div>
</div>

<!-- Model contact add information -->
    <div class="modal fade" id="contactmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Schedule a call</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                   

                    <form method="post"  >
                        <div class="modal-body">

                            <input type="hidden" name="id" id="id" value="5" />
                            <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                            <input type="hidden" name="activity_type" value="Call" />
                            <input type="hidden" name="main" value="1" />


                            <div class="form-group row m-0 pt-1">
                                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Lead Organization</label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                     <p><?=$orgname?></p>
                                </div>
                            </div>

                            <div class="form-group row m-0 pt-1">
                                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact Person Name:</label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                                    <input class="form-control req" name="contact_name" id="contact_name">
                                </div>
                            </div>


                            <div class="form-group row m-0 pt-1">
                                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact Person Mobile:</label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                                    <input class="form-control req" name="contact_phone" id="contact_phone">
                                </div>
                            </div>

                            <div class="form-group row m-0 pt-1">
                                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact Person Email:</label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                    <input type="text" name="contact_email" id="contact_email" value="" class="form-control req" />
                                </div>
                            </div>

                            <div class="form-group row m-0 pt-1">
                                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Contact Person Designation:</label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                    <input type="text" name="contact_designation" id="contact_designation" value="" class="form-control req" />
                                </div>
                            </div>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                            <input name="submit" type="submit" id="contactsave" value="SAVE" class="btn1 btn1-bg-submit">
                            <input  name="updatecontact" type="submit" id="contactedit" value="Update" class="btn1 btn1-bg-update d-none">
                            <!-- <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button> -->
                        </div>
                    </form>
                </div>
            </div>
</div>
<!-- Model contact EDIT information -->

<!--Schedule a call Modal Start-->
<div class="modal fade" id="schedulecall" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Schedule a call</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>


            <form method="post">
                <div class="modal-body">
                <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                    <input type="hidden" name="call_main" value="Schedule" />
                    <input type="hidden" name="activity_type" value="Call" />
                    <input type="hidden" name="main" value="1" />
                    
                    <div class="form-group row m-0 pt-1">
                                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Lead Organization</label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                     <p><?=$orgname?></p>
                                </div>
                            </div>
                    <!-- <div class="form-group row m-0 pt-1"> -->
                        <!-- <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Select call Lead:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0"> -->
                       
                            <!-- <select class="form-control req" name="lead_id" id="lead_id">
                                <? 
                               // if($user_role=="Admin"){
                                   // foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');
                               // }else{
                                //foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id and l.assign_person="'.$pbi_id.'"'); 
                                //}?>
                            </select> -->
                        <!-- </div>
                    </div> -->


                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call to:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                            <input class="form-control req" name="call_to" id="call_to">
                        </div>
                    </div>


                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call type:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select class="form-control req" name="call_type" required>
                                <option></option>
                                <option value="Inbound Call">Inbound Call</option>
                                <option value="Outbound Call">Outbound Call</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="date" name="date" id="date" value="" class="form-control req" />
                        </div>
                    </div>

                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Time:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="time" name="time" id="time" value="" class="form-control req" />
                        </div>
                    </div>


                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Purpose:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="subject" id="subject" value="" class="form-control req" />
                        </div>
                    </div>

                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Note:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <textarea class="form-control req1" name="details"></textarea>
                        </div>
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Schedule a call Modal End-->

<!--Visit Modal 1st Start-->
<div class="modal fade " id="schedulevisit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content w-100">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Visit </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="post">
                <div class="modal-body">
                <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                    <input type="hidden" name="activity_type" value="Visit" />

                    <div class="form-group row m-0 pt-1">
                                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Lead Organization</label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                     <p><?=$orgname?></p>
                                </div>
                            </div>


                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Location:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

                            <input type="text" name="location" id="location" value="" class="form-control req" />
                        </div>
                    </div>



                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Purpose:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="subject" id="subject" value="" class="form-control req" />
                        </div>
                    </div>

                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="date" name="date" id="date" value="" class="form-control req" />
                        </div>
                    </div>
                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Time:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="time" name="time" id="time" value="" class="form-control req" />
                        </div>
                    </div>


                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Note:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <textarea class="form-control req1" name="details"></textarea>
                        </div>
                    </div>




                </div>

                <div class="modal-footer">
                    <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Visit  Modal 1st End-->




<!--Meeting Modal 1st Start-->
<div class="modal fade " id="schedulemeeting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content w-100">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Meeting Add </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="post">
        <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
            <div class="modal-body">


                <input type="hidden" name="activity_type" value="Meeting" />
                <div class="form-group row m-0 pt-1">
                                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Lead Organization</label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                     <p><?=$orgname?></p>
                                </div>
                 </div>




                <div class="form-group row m-0 pt-1">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Meeting Type:</label>

                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <select class="form-control req" name="meeting_type">
                            <option value="Online">Online </option>
                            <option value="Offline">Offline</option>
                        </select>
                    </div>
                </div>



                <div class="form-group row m-0 pt-1">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Meeting Subject:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input type="text" name="subject" id="subject" value="" class="form-control req" />
                    </div>
                </div>

                <div class="form-group row m-0 pt-1">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Location:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input type="text" name="location" id="location" value="" class="form-control req" />
                    </div>
                </div>

                <div class="form-group row m-0 pt-1">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Date:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input type="date" name="date" id="date" value="" class="form-control req" />
                    </div>
                </div>
                <div class="form-group row m-0 pt-1">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Time:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input type="time" name="time" id="time" value="" class="form-control req" />
                    </div>
                </div>


                <div class="form-group row m-0 pt-1">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Note:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <textarea class="form-control req1" name="details"></textarea>
                    </div>
                </div>




            </div>

            <div class="modal-footer">
                <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button>
            </div>
        </form>
    </div>
</div>
</div>
<!--Meeting  Modal 1st End-->

<!--Email Modal 1st Start-->
<div class="modal fade " id="scheduleemail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content w-100">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Email Add </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="post">
                <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                <div class="modal-body">


                    <input type="hidden" name="activity_type" value="Email" />
                    <div class="form-group row m-0 pt-1">
                                <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Lead Organization</label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                     <p><?=$orgname?></p>
                                </div>
                    </div>

                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="date" name="date" id="date" value="" class="form-control req" />
                        </div>
                    </div>
                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Time:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="time" name="time" id="time" value="" class="form-control req" />
                        </div>
                    </div>

                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Email to:</label>

                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="call_to" id="call_to" value="" class="form-control req" />
                        </div>
                    </div>



                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Email Subject:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="subject" id="subject" value="" class="form-control req" />
                        </div>
                    </div>

                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Email Body:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="details" id="details" value="" class="form-control req" />
                        </div>
                    </div>

                    <?php /*?>								<div class="form-group row m-0 pt-1">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Attachment:</label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                <input type="file" name="" id="" value="" class="form-control req" style="padding:3px;" />
            </div>
        </div>
<?php */ ?>


                </div>


                <div class="modal-footer">
                    <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button>
                </div>

            </form>
        </div>
    </div>
</div>
<!--Email  Modal 1st End-->





<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold fw-10 w-100 p-1" style="height:30px !important; font-size: 24px !important" id="tasktittleid"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body shadow rounded m-3  ">
                    <p  id="exampleDetailsid"></p>
                </div>
                <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary">Mark as Done</button> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- add task modal -->

<div class="modal fade " id="addtaskmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  
     <div class="rounded shadow " style=" display: flex; flex-direction: row; justify-content: center; align-items: center; padding:40px !important">
        <section class="" style="width: 40% !important; border-radius: 30px !important; background-color:white !important;">

                  <div class=" rounded shadow p-4 ">
                        <form action="" method="post" enctype="multipart/form-data">
                        

                            <div class="form-outline mb-2">
                        
                                <input name="task_name" id="task_name" value="" type="text" id="form3Example3" class="form-control form-control-lg"
                                placeholder="Enter your task name" />
                            
                            </div>

                            <input type="text" name="lead_id" id="lead_id" value="<?=$id?>" />
                            <input type="hidden" name="activity_id" id="activity_id" value="<?=$activityd?>" />
                            <div class="form-outline mb-3">

                                <select class="form-control form-control-lg ">
                                    <option value="<?=$orgname?>"><?=$orgname?></option>
                                                <!-- <? //foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');?> -->
                                    </select>
                            
                            </div>
                            <div class="form-outline mb-3">

                                <select class="form-control form-control-lg ">
                                    <option value="<?=$orgname?>"><?=$orgname?></option>
                                                <!-- <? //foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');?> -->
                                    </select>
                            
                            </div>

                                <div class="form-outline mb-2">
                                
                                    <textarea style=" font-size: 14px;"  class="form-control form-control-lg  mb-2"  type="text"  name="task_details" id="task_details" cols="30" rows="5" placeholder="Tasks Details"></textarea>
                                
                                </div>

                            
                            <div class="form-outline mt-4 mb-2">
                            <label for="">Enter task date</label>
                            <input type="date" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_date" id="task_date"   placeholder="Subject">
                            
                            </div>
                            <div class="form-outline mb-2">
                            <label for="">Enter task Time</label>
                            <input type="time" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_time" id="task_time"   placeholder="Subject">
                            
                            </div>
                            <div class="form-outline mb-2">
                            <label for="">Enter Remainder Date</label>
                            <input type="date" class="form-control form-control-lg " style="margin-top:1em !important;" name="reaminder_start_date" id="reaminder_start_date"   placeholder="Subject">
                            
                            </div>
                            <div class="form-outline mb-2">

                            <label for="">Enter Remainder Time</label>
                            <input type="time" class="form-control form-control-lg " style="margin-top:1em !important;" name="reaminder_start_time" id="reaminder_start_time"   placeholder="Subject">
                            
                            </div>

                    
                    
                        
                        

                            <div class="text-center text-lg-start mt-4 pt-2">

                            
                    
                            <input type="submit" name="insertTasks" id="submit" value="submit" class="btn btn-primary btn-lg"/>
                            <!-- <input name="reset" type="button" class="btn btn-danger  btn-lg" id="reset" value="RESET" onclick="parent.location='show_all_tasks.php'"> -->
             

                            </div>

                            </form>
                        </div>
                        </div>
                    </div>

                    </section>
                    </div>
 
</div>




  <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
 



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>