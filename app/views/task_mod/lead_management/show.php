<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$id=$_REQUEST['id'];
$condition="id=".$id;
$data=db_fetch_object('crm_project_lead',$condition);
while (list($key, $value)=@each($data))
{ $$key=$value;}


if(isset($_POST['update'])){
$crud= new crud('crm_project_org');
$crud->update('id');
 db_query('delete from crm_org_contacts where project_id="'.$id.'"');
 	 foreach ($_POST['contact_name1'] as $key => $value) { 
	 if($_POST['contact_name1'][$key]!='') {
 $sql='INSERT INTO `crm_org_contacts`( `project_id`, `contact_name`, `contact_phone`, `contact_email`, `contact_designation`, `entry_by`, `entry_at`) VALUES ("'.$id.'","'.$_POST['contact_name1'][$key].'","'.$_POST['contact_phone1'][$key].'","'.$_POST['contact_email1'][$key].'","'.$_POST['contact_designation1'][$key].'","'.$_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
 db_query($sql);
 }
	   		  
	  }
  
  echo "<script>window.top.location='show_all_org.php'</script>";
  
}
?>

          <form method="post">
          <div class="modal-body">
          <h5 class=text-center>Update Organization Information</h5>
            <div class="row">
                
                <div class="col-sm-12">
                    <table class="table">
                      <tr>
                        <td width="120">Organization Name </td>
                        <td><input type="text" name="name" value="<?=$name?>" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required></td>
                      </tr>
                  </table>
                </div>
             
                <div class="col-md-6">
                  <table class="table">
                    <tbody>
                      
                      <tr>
                        <td>Source </td>
                        <td>
                          <select name="lead_source" id="lead_source"  class=" input_general"  data-live-search="true">
                            <option value="">--None--</option>
                                <?php foreign_relation('crm_lead_source', 'id', 'source', $lead_source, '1'); ?>
                          </select>
                        </td>
                      </tr>
                      
                      <tr>
                        <td>Employees</td>
                        <td><input type="text" value="<?=$total_employees?>" name="total_employees" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>
                      </tr>
                      
                      <tr>
                        <td>Yearly Turnover </td>
                        <td><input type="text" name="annual_revenue" value="<?=$annual_revenue?>" style="border-left: 3.5px solid #aeddf7 !important;" class="form-control"></td>
                      </tr>
                      
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
                        <td><input type="text" name="website" value="<?=$website?>" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>
                      </tr>
                      
                      <tr>
                        <td>Type </td>
                        <td>
                          <select name="lead_type" id="lead_type" class=" input_general" data-live-search="true">
                            <option value="">--None--</option>
                                <?php foreign_relation('crm_lead_type', 'id', 'type', $lead_type, '1'); ?>
                          </select>
                        </td>
                      </tr>
                  

            
                    </tbody>
                  </table>
                </div>
		<div class=" col-md-12 text-center"><strong>Contact Information</strong></div>
		
		<?php
		$query=db_query('select * from crm_org_contacts where project_id="'.$id.'"');
		while($data=mysqli_fetch_object($query)){
		?>
                  <div class="col-md-6">
                    <table class="table">
                      <tbody>
                        <tr>
                            <td>Contact Person </td>
                            <td><input type="text" name="contact_name1[]" value="<?=$data->contact_name?>" style="border-left:3.5px solid #df5b5b!important;" class="form-control" ></td>
                        </tr>
                          
                        <tr>
                            <td>Phone </td>
                            <td><input type="text" name="contact_phone1[]" class="form-control " style="border-left:3.5px solid #df5b5b!important;" value="<?=$data->contact_phone?>" ></td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
				  
                  <div class="col-md-6">
                    <table class="table">
                      <tbody>
                          
                        <tr>
                            <td>Email </td>
                            <td><input type="text" name="contact_email1[]" class="form-control" value="<?=$data->contact_email?>" style="border-left:3.5px solid #df5b5b!important;" ></td>
                        </tr>
                        
                        <tr>
                          <td>Designation</td>
                          <td>
                            <input type="text" name="contact_designation1[]" id="designation" class="form-control" value="<?=$data->contact_designation?>" style="border-left: 3.5px solid #aeddf7 !important;">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
				 
				  <? }?>
				  <div class="col-md-12"  id="addr0"></div>
				   <span id="add_row" class="mx-auto text-light mt-3 mb-4 btn btn-primary btn-sm">+ Add Contact</span>
				   <div class="col-md-12 text-center"><strong>Address Information</strong></div>
				   <div class="col-md-6">
                <table class="table">
                  <tbody>
                    <tr>
                      <td>Address</td>
                      <td><input type="text" value="<?=$address?>" name="address" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;"></td>
                    </tr>
                    <tr>
                      <td>Zip Code</td>
                      <td>
                          <input list="dfg" type="text" name="zip" id="zip" value="<?=$zip?>" class=" input_general" data-live-search="true" />
						  <datalist id="dfg">
                            <option value="">--Select One--</option>
                            <?php foreign_relation('crm_postalcode_list','id','concat(po_name,"-",po_code)',$zip,'is_active=1 ORDER BY po_name'); ?>
                          </datalist>
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
                      <td><input type="text" value="<?=$city?>" style="border-left: 3.5px solid #aeddf7 !important;" name="city" class="form-control"></td>
                    </tr>
                    <tr>
                      <td>Country</td>
                      <td>
                        <input list="cvb" name="country" id="country" type="text" value="<?=$country?>" class=" input_required"  data-live-search="true" required>
						<datalist id="cvb">
                          <option value="">--Select One--</option>
                          <?php foreign_relation('crm_country_management','id','country_name',$country,'is_active=1 ORDER BY country_name'); ?>
                        </datalist>
                        
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
                <div class="form-group pt-3 m-0 m-auto">
                    <label for="message text-center">Description Information</label>
                    <textarea name="description" class="form-control" style="border-left: 3.5px solid #aeddf7 !important;" cols="40" rows="4"><?=$description?></textarea>
                </div>
                
            </div>

            
          </div>
		  <div class="text-center">
                <input type="hidden" name="id" value="<?=$id?>">
                <button type="submit" class="btn btn-warning" name="update">Update</button>
            </div>
       </form>   
	   
	   <script>
	       $("#add_row").click(function(){

$('#addr0').append('<div class="row"><div class="col-md-6"> <table class="table"> <tbody><tr><td>Contact Person </td><td><input type="text" name="contact_name1[]" style="border-left:3.5px solid #df5b5b!important;" class="form-control"></td></tr><tr><td>Phone </td><td><input type="text" name="contact_phone1[]" class="form-control " style="border-left:3.5px solid #df5b5b!important;" ></td></tr></tbody></table></div><div class="col-md-6"> <table class="table"> <tbody><tr><td>Email </td><td><input type="text" name="contact_email1[]" style="border-left:3.5px solid #df5b5b!important;" class="form-control"></td></tr><tr><td>Designation </td><td><input type="text" name="contact_designation1[]" class="form-control " style="border-left:3.5px solid #df5b5b!important;" ></td></tr></tbody></table></div></div>');
  	});
	   </script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>



