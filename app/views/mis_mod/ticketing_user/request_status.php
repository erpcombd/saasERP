<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Check Request Status";
$table = 'it_support_request';

if(isset($_POST['search'])){
    $data = $_POST['request_id']; 
} else {
    $data = '';
}




if(isset($_POST['assign'])){
    $person_id = $_POST['person_ids'];
    $ticket_id = $_POST['id'];
    $status = 1;
//     print_r($person_id);
//   exist;
    for ($i = 0; $i <= $person_id; $i++) {
      $insert__details_stmt = $conn->prepare("INSERT INTO support_req_assign (support_req_id, assigned_person, status) VALUES (?, ?, ?)");
                   
        $insert__details_stmt->bind_param("iii", $ticket_id, $person_id[$i], $status);
        $insert__details_stmt->execute();
    }
    
    header("Location: request_status.php");
exit;
    
}




$project_name_qry = 'SELECT id,name FROM crm_project_org WHERE 1';
$pr_res = db_query($project_name_qry);
while($pro_rows=mysqli_fetch_object($pr_res)){
    $pro_name[$pro_rows->id] = $pro_rows->name; 
}



$pbi_name_qry = 'SELECT PBI_ID,PBI_NAME FROM personnel_basic_info WHERE 1';
$pbi_res = db_query($pbi_name_qry);
while($pbi_rows=mysqli_fetch_object($pbi_res)){
    $pbi_name[$pbi_rows->id] = $pbi_rows->name; 
}

$support_assign_query = 'SELECT support_req_id,assigned_person  FROM support_req_assign WHERE status=1';
$support_ass_res = db_query($support_assign_query);
while($support_req_id = mysqli_fetch_object($support_ass_res)){
    $support_assign_id[$support_req_id->support_req_id] = $support_req_id->assigned_person;
}

?>

<style>
.sr-main-content-padding {
    background: #f5f5f5 !important;
    padding: 10px 20px;
    border: 1px solid #f5f5f5;
    border-bottom: none;
}
.sr-main-content, .wrapper {
    background-color: #f5f5f5 !important;
}
.sidebar {
    background: #F5F5F2 !important;
    position: fixed;
}

body {
    background-color: #f5f5f5 !important;
}
.form-container_large {.box{
	
	 padding-top: 12px;
    background-color: #fff;
    border-color: #fff;
}
padding:0px !important;}
.round{
    border-radius: 5px !important;
}

.shadow1 {
    background-color: var(--add-shadow1-bg-color);
    box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.16), 0px 0px 0px rgba(0, 0, 0, 0.23);
}

</style>





<div class="form-container_large">
    <div class="container-fluid p-0 ">
    <div class="row box">
        <div class="col-12  round">
            <form method="post">
                <!-- Filter Inputs Row -->
                <div class="row ">
				 <div class="n-form-btn-class col-12">
                        <a href="support_request.php" class="btn btn-md btn-success" style=" margin-bottom: 5px;">
                            <i class="glyphicon glyphicon-plus"></i> New
                        </a>
                    </div>
                    <div class="col-md-3">
                        <select name="type_filter" class="form-control" data-live-search="true">
                            <option value="">--REQ. TYPE--</option>
                            <?php foreign_relation('it_support_type', 'id', 'name', $_POST['type_filter'], 'is_active=1'); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status_filter" class="form-control" data-live-search="true">
                            <option value="">--STATUS--</option>
                            <?php foreign_relation('it_support_status', 'id', 'name', $_POST['status_filter'], 'is_active=1'); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="from_date" value="<?= htmlspecialchars($_POST['from_date'] ?? '') ?>" placeholder="From..." class="form-control">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="to_date" value="<?= htmlspecialchars($_POST['to_date'] ?? '') ?>" placeholder="To..." class="form-control">
                    </div>
                    <div class=" col-md-2">

                    <div class="col-md-6 text-right">
                       <input type="submit" name="filter" value="Filter" class="btn btn-primary">
                    </div>
                </div>
                </div>
               
                <!-- Action Buttons Row -->

            </form>
        </div>
    </div>

    <!-- Table Section -->
    
</div>

    <style>
.mini-plus {
    
  width: 24px;
  height: 24px;
  font-size: 18px;
  line-height: 1;
  text-align: center;
  border: 1px solid #333;
  border-radius: 4px;
  background: white;
  cursor: pointer;
  padding: 0;
  user-select: none;
}
.mini-plus:hover {
  background: #eee;
}



</style>
            
        <div class="container-fluid pt-3 p-0">
			<div class="col-12 shadow1  round">

				<div class="pt-3 pb-3">
				<table id="example" class="table1  table-striped table-bordered table-hover table-sm">
                <thead  class="thead1">
                    <tr  class="bgc-info">
                        <th>Req. ID</th>
                        <th>Project Name</th>
                        <th>Type</th> 
                        <th>Subject</th>
                        <th>Submitted at</th>
                        <th>Assigned to</th>
                        <th>Assigned at</th>
                        <th>Status</th>
                        <th>IT Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $con = '1';
                        if(isset($_POST['type_filter']) && $_POST['type_filter'] != ''){
                            $con .= " AND type='" . $_POST['type_filter'] . "' ";
                        }
                        if(isset($_POST['status_filter']) && $_POST['status_filter'] != ''){
                            $con .= " AND status='" . $_POST['status_filter'] . "' ";
                        }
                        if(!empty($_POST['from_date']) && !empty($_POST['to_date'])){
                            $con .= " AND DATE_FORMAT(entry_at,'%Y-%m-%d') BETWEEN '" . $_POST['from_date'] . "' AND '" . $_POST['to_date'] . "' ";
                        } else if(!empty($_POST['from_date']) && empty($_POST['to_date'])){
                            $con .= " AND DATE_FORMAT(entry_at,'%Y-%m-%d') > '" . $_POST['from_date'] . "' ";
                        } else if(empty($_POST['from_date']) && !empty($_POST['to_date'])){
                            $con .= " AND DATE_FORMAT(entry_at,'%Y-%m-%d') < '" . $_POST['to_date'] . "' ";
                        }

                         $sql = "SELECT * FROM $table WHERE " . $con;
                        $rslt = db_query($sql);
                        while($data = mysqli_fetch_object($rslt)){
                    ?>
                    <tr <?php if(($data->status >= 3 && $data->status <= 5) && $data->has_seen == 0){ ?> style="background: #dcf2f3;" <?php } ?>>
                        <td><?= $data->request_id ?></td>
                        <td><?= $pro_name[$data->project_id]?></td>
                        <td><?= find_a_field('it_support_type', 'name', 'id="' . $data->type . '"') ?></td>
                        <td><?= substr($data->subject, 0, 35) . '..' ?></td>
                        <td><?= $data->entry_at ?></td>
                        <td>
                            <?php 
                                echo ($data->assigned_to != NULL) ? find_a_field('user_activity_management', 'username', 'PBI_ID="' . $data->assigned_to . '"') : 'None';
                            ?><br><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">+</button>
                            
                            
                            
<!--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--  <div class="modal-dialog" role="document">-->
<!--    <div class="modal-content">-->
<!--      <div class="modal-header">-->
<!--        <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>-->
        
        
<!--         <div class="form-group row m-0 pt-1">-->
<!--				<label  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text" for="form2" >Assign Person Name</label>-->
<!--					<select class="form-control req" name="person_ids[]" id="person_ids" required>-->
<!--                        <option selected value="<?=$PBI_ID?>">-->
<!--                          <? //= find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "' . $PBI_ID . '"') ?>-->
<!--                        </option>-->
<!--        				<?php //foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_ID," - ",PBI_NAME)', $assign_person, '1'); ?>-->
<!--                    </select>-->
<!--		</div>-->
				
				
<!--      </div>-->
<!--      <div class="modal-body">-->
<!--        Modal content goes here.-->
<!--      </div>-->
<!--      <div class="modal-footer">-->
<!--        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->






 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-body1" role="document">
                    <div class="modal-content" style="padding: 10px !important;">
                        <div class="modal-header"  style="padding: 10px !important;">
                            <h5 class="modal-title" id="exampleModalLabel">Assign Person:</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <form method="post" id="statustable">
                            <div class="modal-body"  style="padding: 10px !important;">

                                <input type="hidden" name="id" id="id" value="<?=$data->id?>" />

                                <div class="form-group row m-0 pt-1"  style="padding: 10px !important;">
                                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Assign People:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                                      	<select class="form-control req " name="person_ids[]" id="person_ids"   required >	
                        				      				
                                        <?php 
                                        
                                            $person = explode('#', $datas->person);
                                            
                                            $multiple_select_query = "SELECT PBI_ID, PBI_NAME FROM personnel_basic_info"; 
                                            $pbi_res = db_query($multiple_select_query);
                                            while($multi_rows = mysqli_fetch_object($pbi_res)){
                                                
                                                if(in_array($multi_rows->PBI_ID, $person)){
                                                    echo '<option value="'.$multi_rows->PBI_ID.'" selected>'.$multi_rows->PBI_NAME.'</option>';
                                                }else{
                                                    echo '<option value="'.$multi_rows->PBI_ID.'">'.$multi_rows->PBI_NAME.'</option>';
                                                }
                                            }
                                            
                                        ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer"  style="padding: 10px !important;">
                                <button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
                                <input name="assign" type="submit" id="orgentryeditbtn" value="Assign" class="btn1 btn1-bg-update">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
                                
                            </td>
                        <td>
                            <?php 
                                echo ($data->assigned_at != '0000-00-00 00:00:00') ? $data->assigned_at : '--:--';
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo ($data->status > 0) ? find_a_field('it_support_status', 'name', 'id="' . $data->status . '"') : 'Pending';
                            ?>
                        </td>
                        <td><?= $data->remarks ?></td>
                        <td>
                            <?php if($data->status == 0){ ?>
														
							
                                <a href="support_request.php?update=<?= $data->id ?>">
                                   <button type="button" class="btn2 btn1-bg-update"><i class="fa-solid fa-pencil"></i></button>
                                </a>
                            <?php } else { ?>
                                <a href="view_support.php?view=<?= $data->id ?>">
                                    <button type="button" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
				
				
				
				</div>
				
				
				
			
			</div>
			

        </div>
        


</div>



<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>

<script>
    $(document).ready(function(){
        $('#example').DataTable({
            order: [[3, 'desc']],
        });
    });
</script>



