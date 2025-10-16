<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title = "Check Request List";

$table = 'it_support_request';



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

.form-container_large {
padding:0px !important;
}

.round{
    border-radius: 5px !important;
}
.box{
	
	 padding-top: 12px;
    background-color: #fff;
    border-color: #fff;
}

.shadow1 {
    background-color: var(--add-shadow1-bg-color);
    box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.16), 0px 0px 0px rgba(0, 0, 0, 0.23);
}
</style>
<div class="form-container_large">
<div class="container-fluid p-0  ">
    <div class="row box">
        <div class="col-12    round">
            
            <form method="post">
                
                <div class="row ">
				 
                        <div class="n-form-btn-class col-12">
                            <a href="support_request.php" class="btn btn-md btn-success" ><i class="glyphicon glyphicon-plus"></i> New</a>
                        </div>
                     <!--   <div style="float:left;">-->
                            <div class="col-md-3">
                                <select name="type_filter" class="form-control " data-live-search="true">
                                    <option value="">--SELECT--</option>
                                    <?php foreign_relation('it_support_type', 'id', 'name', $_POST['type_filter'], 'is_active=1 AND id IN (1,3)'); ?>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="status_filter" class="form-control " data-live-search="true">
                                    <option value="">Pending</option>
                                    <?php foreign_relation('it_support_status', 'id', 'name', $_POST['status_filter'], 'is_active=1 AND id IN (2,3,4,5)'); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="from_date" value="<?=$_POST['from_date']?>" placeholder="From..." class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="to_date" value="<?=$_POST['to_date']?>" placeholder="to..." class="form-control">
                            </div>
							<div class=" col-md-2">
                            <div class="col-md-6 text-right">
                                <input type="submit" name="filter" value="Filter" class="btn btn-primary">
                            </div>
							</div>
                       
                </div>
                
            </form>
            
        </div>
    </div>
            
        
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
                       <th>Assigned at</th>
                       <th>Requested by/for</th>
                       <th>Status</th>
                       <!--<th>IT Remarks</th>-->
                       <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    
                    <?php
                    
                        $con = '1';
                        
                        if(isset($_POST['type_filter']) && $_POST['type_filter'] != ''){
                            $con .= " AND type='".$_POST['type_filter']."' ";
                        }
                        
                        if(isset($_POST['status_filter']) && $_POST['status_filter'] != ''){
                            $con .= " AND status='".$_POST['status_filter']."' ";
                        }else{
                            $con .= " AND status='0' ";
                        }
                        
                        if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
                            $con .= " AND DATE_FORMAT(entry_at,'%Y-%m-%d') BETWEEN '".$_POST['from_date']."' AND '".$_POST['to_date']."' ";
                        }else if($_POST['from_date'] != '' && $_POST['to_date'] == ''){
                            $con .= " AND DATE_FORMAT(entry_at,'%Y-%m-%d') > '".$_POST['from_date']."' ";
                        }else if($_POST['from_date'] == '' && $_POST['to_date'] != ''){
                            $con .= " AND DATE_FORMAT(entry_at,'%Y-%m-%d') < '".$_POST['to_date']."' ";
                        }

                        $sql = "SELECT * FROM $table WHERE ".$con." AND type IN (1,3) ORDER BY entry_at DESC";
                        $rslt = db_query($sql);
                        while($data = mysqli_fetch_object($rslt)){
                    
                    ?>
                    
                    <tr>
                       <td><?=$data->request_id?></td> 
                       <td><?=find_a_field('it_support_type', 'name', 'id="'.$data->type.'"')?></td>
                       <td><?=substr($data->subject, 0, 35).'..'?></td>
                       <td><?=$data->entry_at?></td>
                       <td><?php if($data->assigned_to!=NULL){echo find_a_field('user_activity_management', 'username', 'PBI_ID="'.$data->assigned_to.'"');}else{echo 'None';}?></td>
                       <td><?php if($data->assigned_at!='0000-00-00 00:00:00'){echo $data->assigned_at;}else{echo '--:--';}?></td>
                       <td><?=find_a_field('user_activity_management', 'concat(fname,"::",username)', 'PBI_ID="'.$data->PBI_ID.'"')?></td>
                       <td><?php if($data->status > 0){echo find_a_field('it_support_status', 'name', 'id="'.$data->status.'"');}else{echo 'Pending';}?></td>
                       <!--<td><?//=$data->remarks?></td>-->
                       <td>
                            <?php if($data->status == 0 && $data->entry_by == $_SESSION['selected_employee']){ ?>
                                <a class="btn btn-xs btn-block btn-warning" href="support_request.php?update=<?=$data->id?>">EDIT</a>
                            <?php }else{ ?>
                                <a class="btn btn-xs btn-block btn-info" href="view_support.php?view=<?=$data->id?>&tp=<?='sp'?>">VIEW</a>
                            <?php } ?>
                        </td>
                    </tr>
                    
                    <?php
                    
                        $cnt++;
                        
                        }
                    
                    ?>
                    
                </tbody>
                
            </table>
            
        </div>
        
    </div>
	</div>
	</div>
    </div>
    

<?php

require_once SERVER_CORE."routing/layout.bottom.php";

?>


<script>
        $('#example').DataTable({
            order: [[3, 'desc']],
        });
</script>