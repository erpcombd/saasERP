<?php



require_once "../../../controllers/routing/default_values.php";

require_once "../../../controllers/config/check_login_static.php";



if(check_for_loginstatic('saaserp','supportuser','312351bff07989769097660a56395065',1)){

require_once SERVER_CORE."routing/layout.top.php";

$title = "Check Request Status";
$table = 'it_support_request';

if(isset($_POST['search'])){
    $data = $_POST['request_id']; 
} else {
    $data = '';
}



//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);
//error_reporting(-1);


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
                    <div class="col-md-3">
                        <select name="type_filter" class="form-control" data-live-search="true">
                            <option value="">--TYPE--</option>
                            <?php foreign_relation('it_support_type', 'id', 'name', $_POST['type_filter'], 'is_active=1'); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status_filter" class="form-control" data-live-search="true">
                            <option value="">--STATUS--</option>
                            <option value="Open" >Open</option>
							<option value="Assigned" >Assigned</option>
							<option value="Pending" >Pending</option>
							<option value="Completed" >Completed</option>
							<option value="Rejected" >Rejected</option>
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
    <!--<form action="" method="post" name="codz" id="codz">
       <div class="container-fluid p-0">     
        <div class="col-12 shadow1 round ">		
		
            <div class="row new-bg m-0">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0 p-0">
                        <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From:</label>
                        <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 p-0">
                            <input type="date" name="fdate" value="" class="form-control req">
                        </div>
                    </div>

                </div>
				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0 p-0">
                        <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To:</label>
                        <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 p-0">
                            <input type="date" name="tdate" value="" class="form-control req">
                        </div>
                    </div>

                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0 p-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req Status:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="status" id="status" class="req1">
								<option></option>
								<option>CHECKED</option>
								<option>COMPLETED</option>
							</select>

                        </div>
                    </div>
                </div>

                <div class="n-form-btn-class col-12">
										<input type="submit" name="insert" class="btn1 btn1-bg-submit" value="Submit" style="margin-top:12px;margin-bottom:12px;">
				</div>

            </div>
        </div>
	</div>

    </form>-->
            
        <div class="container-fluid pt-3 p-0">
			<div class="col-12 shadow1  round">

				<div class="pt-3 pb-3">
				<table id="example" class="table1  table-striped table-bordered table-hover table-sm">
                <thead  class="thead1">
                    <tr  class="bgc-info">
                        <th>Req. ID</th> 
                        <th>Type</th> 
                        <th>Subject</th>
                        <th>Submitted at</th>
                        <th>Assigned to</th>
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

                       echo $sql = "SELECT * FROM $table WHERE " . $con . " and cid='".$_SESSION['support_cid']."' ";
                        $rslt = db_query($sql);
                        while($data = mysqli_fetch_object($rslt)){
                    ?>
                    <tr <?php if(($data->status >= 3 && $data->status <= 5) && $data->has_seen == 0){ ?> style="background: #dcf2f3;" <?php } ?>>
                        <td><?= $data->request_id ?></td> 
                        <td><?= find_a_field('it_support_type', 'name', 'id="' . $data->type . '"') ?></td>
                        <td><?= substr($data->subject, 0, 50) . '..' ?></td>
                        <td><?= $data->entry_at ?></td>
                        <td><?php 
        if (!empty($data->assigned_to)) {
            $assigned_ids = explode(',', $data->assigned_to);
            $usernames = [];

            foreach ($assigned_ids as $id) {
			
                $username = find_a_field('user_activity_management', 'fname', 'user_id="' . trim($id) . '"');
                if ($username) {
                    $usernames[] = $username;
                }
            }

            echo !empty($usernames) ? implode(',<br>', $usernames) : 'None';
        } else {
            echo 'None';
        }
    ?>
</td>
                        
                        <td>
                            <?php 
                                echo $data->status;
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
<? } ?>