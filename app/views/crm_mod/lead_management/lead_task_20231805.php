<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');

do_calander('#date');

 $cur = '&#x9f3;';



 require "../include/custom.php";

 

  $title = "Lead Activity";

 

 $table1 = 'crm_lead_activity';

 $crud1 = new crud($table1);

 if(isset($_POST['insert'])){



$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['entry_at']=date("Y-m-d H:i:s");
$log_id=$crud1->insert();



 }


?>



    <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>

    

    

    <div class="row well">

        <div class="col-md-12 text-right">

            <a href="../home/home.php" class="btn btn-warning" style="margin-top:12px; margin-bottom:14px;">Go Back</a>

            <a data-toggle="modal" data-target="#exampleModal"  class="btn btn-success text-light" style="margin-top:12px; margin-bottom:14px;">+ Add New</a>

        </div>    

    </div>

    

   

        <div class="col-md-12">

            <table id="" class="table">
                <thead>

				<tr>

                    <th>SN</th>

                    <th>Date & Time</th>
					
					<th>Lead Name</th>

                    <th>Activity Type</th>
					
					 <th>Activity Details</th>

					</tr>

                </thead>

                <tbody>

                

                <?php 

                

                    $sn = 1;


                     $leadsQry = "SELECT a.*,concat(o.name,'##',p.products) as activity FROM $table1 a,crm_project_lead l,crm_project_org o,crm_lead_products p WHERE a.lead_id=l.id and l.organization=o.id and l.product=p.id group by a.id order by a.id DESC";

                    $rslt = db_query($leadsQry);

                    while($row = mysqli_fetch_object($rslt)){

                

                ?>

                

                    <tr>

                        <td><?=$row->id?></td>

                        <td><?=$row->date?><br /><?=date("h:i A ",strtotime($row->time))?> </td>
						
						<td><?=$row->activity?></td>

                        <td><?=$row->activity_type?></td>
						
						<td><?=$row->details?></td>

                   

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

        $datas = find_all_field($table1, '', 'id="'.decrypTS($_GET['update']).' AND '.$con.'"'); 

        if(isset($datas)){$assigned_id = $datas->assigned_person_id;}else{$assigned_id = $_SESSION['employee_selected'];} 

    } ?>

    

    <div id="exampleModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

      <div class="modal-dialog modal-lg">

        <div class="modal-content">

        <div class="modal-header">

            <h5 class="modal-title" id="exampleModalLongTitle">Lead Activity</h5>

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
						<td>Select Lead</td>
						<td><select  name="lead_id"  class="selectpicker input_general" required  data-live-search="true">
						<option></option>
						<? foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p','l.id','concat(o.name,"##(",p.products,")")',$organization,'l.organization=o.id and l.product=p.id'); ?>
						</select></td>
						</tr>
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
			  
			  
            </div>
			<div class="modal-footer">

            <a type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</a>

            <button type="submit" class="btn btn-primary" name="insert">Save</button>

          </div>
          </form>

          

        </div>

      </div>

    </div>

    <!-- Modal End Here -->

	


<?







require_once SERVER_CORE."routing/layout.bottom.php";







?>





<?php if(isset($_GET['update'])){ ?>

    <script>

        $('.bd-example-modal-lg').modal('show');

    </script>

<?php } ?>





