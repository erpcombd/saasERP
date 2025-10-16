<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');


 $cur = '&#x9f3;';
 
 
 require "../include/custom.php";
 
  $title = "All ".$CRMleadName." List";
 
 $table1 = 'crm_project_org';
 $table2 = 'crm_org_contacts';
 
 $crud1 = new crud($table1);
 $crud2 = new crud($table2);
 
 
 if(isset($_POST['insert'])){
     
     $_POST['entry_by'] = $_SESSION['employee_selected'];
     
     //Insert Logo --Start--
   
     //Insert Logo --End--

    $crud1->insert();
     
    // $_POST['contact_name'] = $_POST['contact_person_name'];
//     $_POST['contact_phone'] = $_POST['phone'];
//     $_POST['contact_email'] = $_POST['email'];
//     $_POST['contact_designation'] = $_POST['designation'];
     $lastId =getLastInsertID($table1, 'id');
	 
	  foreach ($_POST['contact_name1'] as $key => $value) {
	  @$HYPERLOOPGLOBAL;
	        $_POST['contact_name'] =  		$_POST['contact_name1'][$key];
			$_POST['contact_phone'] =  		$_POST['contact_phone1'][$key]; 
 			$_POST['contact_email'] = 		$_POST['contact_email1'][$key];
		    $_POST['contact_designation'] = 	$_POST['contact_designation1'][$key];
		    $_POST['project_id']=$lastId;
		   $crud2->insert()  ;
		  
	  }

     
     
 }
 
 if(isset($_POST['update'])){
     
     //Update Logo --Start--
    
     //Update Logo --End--

     $_POST['update_by'] = $_SESSION['employee_selected'];
     $_POST['update_at'] = date('Y-m-d h:s:i');
     
     $crud1->update('id');
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
            <table id="example" class="table">
                
                <thead>
				<tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Entry By</th>
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
                    
                    $leadsQry = "SELECT * FROM $table1 WHERE ".$con;
                    $rslt = db_query($leadsQry);
                    while($row = mysqli_fetch_object($rslt)){
                
                ?>
                
                    <tr>
                        <td><?=$sn?></td>
                        <td><?=$row->name?></td>
                        <td><?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$row->entry_by.'"')?></td>
                        <td><?=$row->entry_at?></td>
                        <td class="d-flex">
                            <a class="btn btn-sm btn-info mr-2" href="../info_maker/crm_view.php?view=<?=encrypTS($row->id)?>&tp='<?=encrypTS('lead')?>'"><i class="fa-solid fa-eye"></i></a>
                            <a class="btn btn-sm btn-warning" href="show.php?id=<?=$row->id?>"><i class="fa-solid fa-pencil"></i></a>
                        </td>
                    </tr>
                
                <?php 
                
                    $sn++;
                    
                    } 
                    
                ?>
                
                </tbody>
                <tfoot>
                    <td>SN</td>
                    <td>Name</td>
                    <td>Assigned to</td>
                    <td>Created at</td>
                    <td>Action</td>
                </tfoot>
                
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
            <h5 class="modal-title" id="exampleModalLongTitle"><?php if(isset($datas)){echo 'Update';}else{echo 'Create';}?> <?=$CRMleadName?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" enctype="multipart/form-data">
          <div class="modal-body">
          <h5 class=text-center><?php if(isset($datas)){echo 'Update';}else{echo 'New';}?> <?=$CRMleadName?> Information</h5>
            <div class="row">
                
                <div class="col-sm-12">
                    <table class="table">
                      <tr>
                        <td width="120">Organization Name </td>
                        <td><input type="text" name="name" value="<?=$datas->name?>" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required></td>
                      </tr>
                  </table>
                </div>
             
                <div class="col-md-6">
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
                        <td>Source </td>
                        <td>
                          <select name="lead_source" id="lead_source"  class="selectpicker input_general"  data-live-search="true">
                            <option value="">--None--</option>
                                <?php foreign_relation('crm_lead_source', 'id', 'source', $datas->lead_source, '1'); ?>
                          </select>
                        </td>
                      </tr>
                      
                      <tr>
                        <td>Employees</td>
                        <td><input type="text" value="<?=$datas->total_employees?>" name="total_employees" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>
                      </tr>
                      
                      <tr>
                        <td>Yearly Turnover </td>
                        <td><input type="text" name="annual_revenue" value="<?=$datas->annual_revenue?>" style="border-left: 3.5px solid #aeddf7 !important;" class="form-control"></td>
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
                <div class="col-md-6">
                  <table class="table">
                    <tbody>
                        
                      <?php /*?><tr>
                        <td>Company </td>
                        <td><input type="text" name="company_name" value="<?=$datas->company_name?>" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required></td>
                      </tr><?php */?>

                      <tr>
                        <td>Website</td>
                        <td><input type="text" name="website" value="<?=$datas->website?>" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>
                      </tr>
                      
                      <tr>
                        <td>Type </td>
                        <td>
                          <select name="lead_type" id="lead_type" class="selectpicker input_general" data-live-search="true">
                            <option value="">--None--</option>
                                <?php foreign_relation('crm_lead_type', 'id', 'type', $datas->lead_type, '1'); ?>
                          </select>
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
            
            <h5 class="text-center">Contact Information</h5>
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
                            <td><input type="text" name="contact_phone1[]" class="form-control " style="border-left:3.5px solid #df5b5b!important;" value="+880<?=$datas->contact_phone?>" required></td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
				  
                  <div class="col-md-6">
                    <table class="table">
                      <tbody>
                          
                        <tr>
                            <td>Email </td>
                            <td><input type="text" name="contact_email1[]" class="form-control" value="<?=$datas->contact_email?>" style="border-left:3.5px solid #df5b5b!important;" required></td>
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
				    </div>
				  </span>
              
              
              
              <span id="add_row" class="mx-auto text-light mt-3 mb-4 btn btn-primary btn-sm">+ Add Contact</span>
             
              
          
            
            <h5 class="text-center">Address Information</h5>
            <div class="row">
              <div class="col-md-6">
                <table class="table">
                  <tbody>
                    <tr>
                      <td>Address</td>
                      <td><input type="text" value="<?=$datas->address?>" name="address" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>
                    </tr>
                    <tr>
                      <td>Zip Code</td>
                      <td>
                          <select name="zip" id="zip" class="selectpicker input_general" data-live-search="true"
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
                      <td>City</td>
                      <td><input type="text" value="<?=$datas->city?>" style="border-left: 3.5px solid #aeddf7 !important;" name="city" class="form-control"></td>
                    </tr>
                    <tr>
                      <td>Country</td>
                      <td>
                        <select name="country" id="country" class="selectpicker input_required"  data-live-search="true" required>
                          <option value="">--Select One--</option>
                          <?php foreign_relation('crm_country_management','id','country_name',$datas->country,'is_active=1 ORDER BY country_name'); ?>
                        </select>
                        
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
                <div class="form-group pt-3 m-0 m-auto">
                    <label for="message text-center">Description Information</label>
                    <textarea name="description" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;" cols="40" rows="4"><?=$datas->description?></textarea>
                </div>
                
            </div>
            
            <?php if(!isset($datas)){ ?>
            <div class="form-group pt-3 text-center">
                <input type="checkbox" name="send_a_mail">
                <label> Send a confirmation mail to contact</label>
            </div>
            <?php } ?>
            
          </div>
          
          <?php if(!isset($datas)){ ?>
          <div class="modal-footer">
            <a type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-primary" name="insert">Save</button>
          </div>
          <?php }else{ ?>
            <div class="modal-footer">
                <input type="hidden" name="id" value="<?=$datas->id?>">
                <a type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-warning" name="update">Update</button>
            </div>
          <?php } ?>
          
          </form>
          
        </div>
      </div>
    </div>
    <!-- Modal End Here -->
	
<script>

    var i=1;
    $("#add_row").click(function(){

$('#addr0').append('<div class="row"><div class="col-md-6"> <table class="table"> <tbody><tr><td>Contact Person </td><td><input type="text" name="contact_name1[]" style="border-left:3.5px solid #df5b5b!important;" class="form-control" required></td></tr><tr><td>Phone </td><td><input type="text" name="contact_phone1[]" class="form-control " style="border-left:3.5px solid #df5b5b!important;"  required></td></tr></tbody></table></div><div class="col-md-6"> <table class="table"> <tbody><tr><td>Email </td><td><input type="text" name="contact_email1[]" style="border-left:3.5px solid #df5b5b!important;" class="form-control" required></td></tr><tr><td>Designation </td><td><input type="text" name="contact_designation1[]" class="form-control " style="border-left:3.5px solid #df5b5b!important;"  required></td></tr></tbody></table></div></div>');
  	});

    $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
            calc();
         });
		 

</script>


<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>


<?php if(isset($_GET['update'])){ ?>
    <script>
        $('.bd-example-modal-lg').modal('show');
    </script>
<?php } ?>


