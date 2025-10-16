<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Lead Info";

do_calander('#date');

 $cur = '&#x9f3;';

 $table1 = 'crm_project_lead';

 $table2 = 'crm_task_lists';
 require "../include/custom.php";

 $id = decrypTS($_GET['view']);
 $orgId=find_a_field('crm_project_lead','organization','id="'.$id.'"');
 $type = decrypTS($_GET['tp']);
$condition="id=".$id;
$data=db_fetch_object('crm_project_lead',$condition);
while (list($key, $value)=@each($data))
{ $$key=$value;}


if(isset($_POST['insert'])){

$crud= new crud('crm_lead_activity');
$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d H:i:s');
$crud->insert();
}
if(isset($_POST['leadUp'])){
$crud= new crud('crm_project_lead');
$_POST['id']=$id;
$crud->update('id');
 $lastStatus=find_a_field('crm_lead_log','status','lead_id="'.$id.'" order by id DESC');
if($lastStatus!=$_POST['status']){
$sql='insert into crm_lead_log (lead_id,status,assign_person,entry_by,note) values("'.$id.'","'.$_POST['status'].'","'.$_POST['assign_person'].'","'.$_SESSION['user']['id'].'","'.$_POST['note'].'")';
db_query($sql);
}
//echo "<script>window.top.location='../lead_management/show_all_leads.php'</script>";

}
if(isset($_POST['actDel'])){
db_query('delete from crm_lead_activity where id="'.$_POST['del_activity'].'"');
}


?>

<link rel="stylesheet" type="text/css" href="../../../assets/css/theme_responsib_crm_timeline.css"/>
<style>
.nav-tabs .nav-item .nav-link, .nav-tabs .nav-item .nav-link:hover, .nav-tabs .nav-item .nav-link:focus {
    border: 0 !important;
    color: #007bff !important;
    font-weight: 500;
}

.nav-tabs{
	border-bottom: 1px solid #d9d9d9;
	background-color: ghostwhite;
}

.tab-content>.active {
    display: block;
    border: 1px solid #f5f5f5;
	background-color: #fbfbfb9e;
}

.nav-tabs .nav-item .nav-link.active{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}
.nav-tabs .nav-item .nav-link:hover{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}

</style>




    <div class="row">

        <div class="col-lg-12">




<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">Lead Log</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile" aria-selected="false">Lead Information</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="contact" aria-selected="false">Lead Activities</a>
  </li>
</ul>

<div class="tab-content" id="myTabContent">


                

                <?php 

                        $qry = "SELECT * FROM crm_project_lead WHERE id = '$id'";

                        $rslt = db_query($qry);

                        if($rows = mysqli_fetch_object($rslt)){

                ?>
				                
  <!--first tab -->
  <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">
		<div class="row p-0">
		<div class="col-md-6 p-4">
								<div class="card-header" style="background:#f3f3f3;">
									<form method="post"><label>Product</label>
								<select  name="product"  class=" input_general mt-2"  data-live-search="true"  disabled="disabled">
								<option></option>
								<? foreign_relation('crm_lead_products','id','products',$product,'1'); ?>
								</select><label >Lead Status</label>
						<select  name="status"  class=" input_general mt-2"  data-live-search="true">
								<option></option>
								<? foreign_relation('crm_lead_status','id','status',$status,'1'); ?>
						</select><label>Assign Person</label>
						<select  name="assign_person"  class=" input_general mt-2"  data-live-search="true">
								<option></option>
								<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$assign_person,'1'); ?>
						</select><label>Note</label>
						<textarea name="note" rows="2"></textarea><br /><button name="leadUp" type="submit" class="mt-2 btn btn-warning" style="margin-bottom: 0.5%;">Update</button></form>
		
		  </div>
		</div>
		<div class="col-md-6 p-4">
		<h2><center><u>Lead Log</u></center></h2>
		<?php
		 $lql='select * from crm_lead_log where lead_id='.$id.' order by id DESC';
		$lquery=db_query($lql);
		while($ldata=mysqli_fetch_object($lquery)){
		?>
		<?=date("d-M-Y, h:i A", strtotime($ldata->entry_at))?> → <?=$ldata->note?>(<?=find_a_field('crm_lead_status','status','id="'.$ldata->status.'"')?>)<br />
		
		<? }?>
		</div>
		</div>
  
  
  </div>
  
				
  
  <!--Secend tab -->
  <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="profile-tab">
  
  <div class="card-body">

                

                            <h5 class="card-title mb-2"><b>

                                <?=$rows->name?></b>

                                <span class="float-right">

                                    <a href="../lead_management/show_all_leads.php" class="btn btn-primary text-light btn-sm"><i class="fa fa-arrow-left"></i> Go Back</a>

                                  

                                </span>

                            </h5>

                            <hr>
<?
                    

                        $qry = "SELECT * FROM crm_project_org WHERE id = '$orgId'";

                        $rslt = db_query($qry);

                        if($rows = mysqli_fetch_object($rslt)){

?>
                            <div class="d-flex">

                                <div class="col-md-6">

                                    

                                    <?php if($rows->logo != NULL){ ?>

                                    <div class="col-md-3 mb-3 p-0">

                                        <img src="../lead_management/imgs/company_logo/<?=$rows->logo?>" width="82" height="76" style="border: 1px solid #b7b7b79e;">

                                    </div>

                                    <?php } ?>

                                    

                                    <p class="card-text"><b>Company</b>: <?=$rows->name?></p>

                                    

                                    <?php if($rows->description !=''){ ?>

                                        <p class="card-text"><b>Description</b>: <?=$rows->description?></p>

                                    <?php } ?>

    

                                    <p class="card-text"><b>Entry By</b>: <?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$rows->entry_by.'"')?></p>

                                    

                                    <?php if($rows->lead_type != 0){ ?>

                                        <p class="card-text"><b>Work Field</b>: <?=find_a_field('crm_lead_type', 'type', 'id = "'.$rows->lead_type.'"')?></p>

                                    <?php } ?>

                                    

                                    

                                    <h6 class="mt-2"><u>Office Address</u></h6>

                                    <span class="card-text"><b>Address</b>: <?php if($rows->address != ''){echo $rows->address.', ';} ?> 

                                        <?php if($rows->city != ''){echo $rows->city.', ';} ?>

                                        <?php if($rows->zip != 0){echo find_a_field('crm_postalcode_list', 'concat(po_name,"-",po_code)', 'id = "'.$rows->zip.'"').', ';} ?>

                                        <?php if($rows->country != 0){echo find_a_field('crm_country_management', 'country_name', 'id = "'.$rows->country.'"');} ?>

                                    </span>

                                    

                                    <?php if($rows->website !=''){ ?>

                                    <p class="card-text mt-1"><b>Website</b>: <a href="<?=$rows->website?>" target="_blank"><?=$rows->website?></a></p>

                                    <?php } ?>

                                    

                                    <?php if($rows->annual_revenue != 0.0){ ?>

                                    <p class="card-text mt-1"><b>Revenue</b>:

                                        <?=$rows->annual_revenue?>/year</p>

                                    <?php } ?>

                                    

                                    <?php if($rows->total_employees != 0){ ?>

                                    <p class="card-text mt-1"><b>Total Employee(s)</b>:

                                        <?=$rows->total_employees?></p>

                                    <?php } ?>

                                    

                                    <?php if($rows->lead_source !=''){ ?>

                                    <p class="card-text mt-1"><b>Source</b>:

                                        <?=find_a_field('crm_lead_source', 'source', 'id="'.$rows->lead_source.'"')?></p>

                                    <?php } ?>

    

                                </div>

                                

                                <div class="col-md-6 lead-contacts">

                                    

                                <?php 

                                

                                    $isContact = find_a_field('crm_org_contacts', 'count(*)', 'project_id = "'.$rows->id.'"'); 

                    

                                    if($isContact > 0){

                                

                                        $leadContactSql = "SELECT * FROM crm_org_contacts WHERE project_id = '$rows->id'";

                                        $leadContactRslt = db_query($leadContactSql);

                                        $i = 1;

                                        

                                        while($leadContacts = mysqli_fetch_object($leadContactRslt)){ 

                                

                                ?>

                                

                                                <h6 class="mt-2"><u>Contact</u> <small style="font-size: 11px;">(<?=$i?>)</small></h6>

                                                <span class="card-text"><b>Name</b>: <?=$leadContacts->contact_name?></span>

                                                <span class="card-text"><b>Designation</b>: <?=$leadContacts->contact_designation?></span>

                                                <span class="card-text"><b>Phone</b>: <a href="tel:<?=$leadContacts->contact_phone?>"><?=$leadContacts->contact_phone?></a></span>

                                                <span class="card-text"><b>Email</b>: <a href="mailto:<?=$leadContacts->contact_email?>"><?=$leadContacts->contact_email?></a></span>

                                    

                                <?php   

                                            

                                            $i++;

                                        }

                                        

                                        $flag = 1;

                                        

                                    }else{

                                        $flag = 0;

                                    }

                                

                                 

                                    if($flag == 0){ 

                                       echo '<h5 class="text-muted">No Contacts Found!</h5>';  

                                    }

                                 

                                ?>

                                    
                                    

                                </div>

                                

                            </div>
							
							<? }?>

                            

                        </div>
  
  
  </div>
                        


  <!--Thard tab -->
  <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="contact-tab">
  
  <div class="row mt-3 mb-4">

                            <div class="col-12 p-3">

                                <div class="mt-2 text-center mb-4" align="center">
								<a data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-success btn-sm mr-4 text-light">+ Add New Activities</a>
                                </div>

                            </div>

                        </div>
						
                <?php } //Lead View -End-  ?>
				
				
				
	
<!--Timeline design start-->
<div class="container-fluid">
    
    <div class="row example-split">
	
        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2">
            <ul class="timeline timeline-split">
			
<?php
 $cql = "SELECT * FROM crm_lead_activity WHERE lead_id = '$id' group by date";
 $cquery=db_query($cql);
 while($cdata=mysqli_fetch_object($cquery)){
?>			
			<li class="timeline-item">
			
                <li class="timeline-item period">
                    <div class="timeline-info"></div>
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h2 class="timeline-title bold"><?=date("M d Y",strtotime($cdata->date))?></h2>
                    </div>
                </li>
		<?php
		 $vsql="SELECT a.*,u.fname FROM crm_lead_activity a,user_activity_management u WHERE a.entry_by=u.user_id and a.lead_id = '$id' and a.date='".$cdata->date."'";
		 $vquery=db_query($vsql);
		 while($vdata=mysqli_fetch_object($vquery)){
		?>		
                  <li class="timeline-item">
                    <div class="timeline-info">
                        <span><?=date("h i A",strtotime($vdata->time))?></span>
                    </div>
                    <div class="timeline-marker"><div class="led">
					<?
					if($vdata->activity_type=="Visit")
					echo '<i class="fa-sharp fa-solid fa-eye"></i>';
					if($vdata->activity_type=="Call")
					echo '<i class="fa-sharp fa-solid fa-phone-arrow-up-right"></i>';
					if($vdata->activity_type=="Meeting")
					echo '<i class="fa-solid fa-users"></i>';
					if($vdata->activity_type=="Email")
					echo '<i class="fa-solid fa-envelope"></i>';
					
					?></div></div>
					
				<?
					if($vdata->activity_type=="Visit"){ ?>	
					
                    <div class="timeline-content pl-1 pt-2">
                        <h3 class="timeline-title"><spn style=" font-weight: 900; ">Visit</spn></h3>
						<p class="m-0">Visit location is <?=$vdata->location?> for <?=$vdata->subject?>.</p>
						<p class="m-0"><?=$vdata->details?></p>
						<p>by <?=$vdata->fname?>  <?=date("M d,Y",strtotime($vdata->entry_at))?></p>

                    </div>
					<? }if($vdata->activity_type=="Call"){ 
					if($vdata->call_main=="Schedule"){
					
					?>
					
				     <div class="timeline-content pl-1 pt-2">
                        <h3 class="timeline-title">Call Schedule with <spn style=" font-weight: 900; "><?=$vdata->call_to?></spn></h3>
						<p class="m-0">at  <spn style=" font-weight: 900; "><?=date("h i a",strtotime($vdata->time))?></spn> about <spn style=" font-weight: 900; "><?=$vdata->subject?></spn> </p>
						<p class="m-0"><?=$vdata->call_type?></p>
						<p class="m-0"><?=$vdata->details?></p>

							<p>by <?=$vdata->fname?>  <?=date("M d,Y",strtotime($vdata->entry_at))?></p>

                    </div>
					<? }else{?>	
					<div class="timeline-content pl-1 pt-2">
                        <h3 class="timeline-title">Call Update <spn style=" font-weight: 900; "> about <?=$vdata->subject?></spn></h3>
						<p class="m-0">Call Duration <?=$vdata->call_duration?> </p>
						<p class="m-0"><?=$vdata->details?></p>

							<p>by <?=$vdata->fname?>  <?=date("M d,Y",strtotime($vdata->entry_at))?></p>

                    </div>
					<? }}if($vdata->activity_type=="Meeting"){?>
					<div class="timeline-content pl-1 pt-2">
          <h3 class="timeline-title">Meeting for <spn style=" font-weight: 900; "><?=$vdata->subject?></spn> in <spn style=" font-weight: 900; "><?=$vdata->location?></spn></h3>
						<p class="m-0"> <?=$vdata->meeting_type?> Meeting.</p>
						<p class="m-0"><?=$vdata->details?></p>

							<p>by <?=$vdata->fname?>  <?=date("M d,Y",strtotime($vdata->entry_at))?></p>

                    </div>
					
					<? }if($vdata->activity_type=="Email"){?>
					<div class="timeline-content pl-1 pt-2">
          <h3 class="timeline-title">Email to <spn style=" font-weight: 900; "><?=$vdata->call_to?></spn> in <spn style=" font-weight: 900; "><?=$vdata->location?></spn></h3>
						<p class="m-0">subject: <?=$vdata->subject?></p>
						<p class="m-0"><?=$vdata->details?></p>

							<p>by <?=$vdata->fname?>  <?=date("M d,Y",strtotime($vdata->entry_at))?></p>

                    </div>
					
					<? }if($vdata->activity_type=="Documentation"){?>
					<div class="timeline-content pl-1 pt-2">
          <h3 class="timeline-title"><spn style=" font-weight: 900; "><?=$vdata->activity_type?></spn></h3>
						<p class="m-0"><?=$vdata->details?></p>

							<p>by <?=$vdata->fname?>  <?=date("M d,Y",strtotime($vdata->entry_at))?></p>

                    </div>
					
					<? }?>
					
					
                </li>
					<? }?>
					
                </li>
				
				<? }?>

	
				
            </ul>
        </div>
    </div>
	
</div>
<!--Timeline design End-->
				
				
  </div> 

</div>


            


        </div>

    </div>

	
<?php /*?><div  id="exampleModalCenter" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Lead Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form method="post" >

          <div class="modal-body">

          <h5 class=text-center>Lead Information</h5>

            <div class="row">
                <div class="col-6">
						<label>Organization Name</label>
						<select  name="organization"  class="selectpicker input_general"  data-live-search="true">
						<option></option>
						<? foreign_relation('crm_project_org','id','name',$organization,'1'); ?>
						</select>

                </div>
				<div class="col-6">
				<label>Lead Status</label>
				<select  name="status"  class="selectpicker input_general"  data-live-search="true">
						<option></option>
						<? foreign_relation('crm_lead_status','id','status',$status,'1'); ?>
				</select>
				
				</div>
				<div class="col-12 mt-4 ml-4">
				<label>Assign Person</label>
				<select  name="assign_person"  class="selectpicker input_general"  data-live-search="true">
						<option></option>
						<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$assign_person,'1'); ?>
				</select>
				
				</div>
            </div>
		
        
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="leadUp">Update</button>
      </div>
	    </form>
    </div>
  </div>
</div>
<?php */?>


<div id="exampleModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

      <div class="modal-dialog modal-lg">

        <div class="modal-content">

        <div class="modal-header">

            <h5 class="modal-title" id="exampleModalLongTitle">New Activity</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

              <span aria-hidden="true">&times;</span>

            </button>

          </div>

          <form method="post" >

          <div class="modal-body">

          <h5 class=text-center>Add a New Activity</h5>

            <div class="row">
               <div class="col-md-6">
                <table class="table">
                  <tbody>
                    <tr>
                      <td>Activity type</td>
                      <td>
					  <select type="text" style="border-left: 3.5px solid #aeddf7 !important;" name="activity_type" class="form-control">
					  <option></option>
					  <option>Call</option>
					  <option>Visit</option>
					  <option>Email</option>
					  <option>Meeting</option>
					  <option>Documentation</option>
					  </select>
					  </td>
                    </tr>
                     <tr>
                      <td>Time</td>
                      <td><input type="time" style="border-left: 3.5px solid #aeddf7 !important;" autocomplete="off" name="time" class="form-control"></td>
                    </tr>
					</tr>
                  </tbody>
                </table>

              </div>
			  <div class="col-md-6">
                <table class="table">
                  <tbody>
                    <tr>
                      <td>Date</td>
                      <td><input type="text" style="border-left: 3.5px solid #aeddf7 !important;" autocomplete="off" name="date" id="date" class="form-control"></td>
                    </tr>
					  <tr>
                      <td>Details</td>
                      <td>
					  <textarea rows="10" name="details"></textarea>
					  </td>
                    </tr>
                    
                  </tbody>
                </table>

              </div>
			  <input name="lead_id" type="hidden" value="<?= $id?>" />
			  
            </div>
			</div>
			<div class="modal-footer">

            <a type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</a>

            <button type="submit" class="btn btn-primary" name="insert">Save</button>

          </div>
          </form>

          

        </div>
      </div>
    </div>
	
	
	
	
	
	
	

	
	
	
	
	
	
	
	

	
    <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>		
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>