<?php
session_start();
//

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";
$title='Shift  Schedule Setup';		

?>

<div class="page-content page-container" id="page-content">
  <div class="padding">
    <div class="row">
      <div class="col-sm-6">
        <form>
          <div class="card">
            <!--<div class="card-header"><strong>Register</strong></div>-->
            <div class="card-body">
              <p class="text-muted" style="color:#E16127">Please fill the information to continue</p>
              
              
              <div class="form-row">
                <div class="form-group col-sm-4">
                  <label>Group</label>
                  <input type="password" class="form-control" required="" id="pwd">
                </div>
                <div class="form-group col-sm-4">
                  <label>Grade</label>
                  <input type="password" class="form-control" data-parsley-equalto="#pwd" required="">
                </div>
                
                
                 <div class="form-group col-sm-4">
                  <label>Year</label>
                  <input type="password" class="form-control" data-parsley-equalto="#pwd" required="">
                </div>
                
                
              </div>
              
              
      
              <div class="form-row">
                <div class="form-group col-sm-6">
                  <label>Gross Salary</label>
                  <input type="password" class="form-control" required="" id="pwd">
                </div>
                <div class="form-group col-sm-6">
                  <label>Basic Salary</label>
                  <input type="password" class="form-control" data-parsley-equalto="#pwd" required="">
                </div>
              </div>
              
              
              
              <div class="form-row">
                <div class="form-group col-sm-6">
                  <label>House Rent</label>
                  <input type="password" class="form-control" required="" id="pwd">
                </div>
                <div class="form-group col-sm-6">
                  <label>Medical Allowance </label>
                  <input type="password" class="form-control" data-parsley-equalto="#pwd" required="">
                </div>
              </div>
              
              
              
              
              <div class="form-row">
                <div class="form-group col-sm-6">
                  <label>Conveyance Allowance</label>
                  <input type="password" class="form-control" required="" id="pwd">
                </div>
                <div class="form-group col-sm-6">
                  <label>Monthly Income Tax</label>
                  <input type="password" class="form-control" data-parsley-equalto="#pwd" required="">
                </div>
              </div>
              
              
                <div class="form-row">
                <div class="form-group col-sm-6">
                  <label>Personal PF</label>
                  <input type="password" class="form-control" required="" id="pwd">
                </div>
                <div class="form-group col-sm-6">
                  <label>Company PF</label>
                  <input type="password" class="form-control" data-parsley-equalto="#pwd" required="">
                </div>
              </div>
              
              
              
              
              
      
              <div class="checkcard">
                <label class="ui-check">
                <input type="checkbox" name="check" checked="checked" required="true">
                <i></i> I agree to the <a href="#" class="text-primary">Terms of Service</a></label>
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-sm-6">
        <form>
          <div class="card">
            <div class="card-header"><strong>Contact</strong></div>
            <div class="card-body">
              <p class="text-muted">Need support? please fill the fields below.</p>
              
              
              <div class="form-row">
                <div class="form-group col-sm-6">
                  <label>Overtime Applicable</label>
                  <input type="text" class="form-control" placeholder="Name" required="">
                </div>
                <div class="form-group col-sm-6">
                  <label>OT Weekend Applicable</label>
                  <input type="email" class="form-control" placeholder="Enter email" required="">
                </div>
              </div>
              
              
              <div class="form-row">
                <div class="form-group col-sm-6">
                  <label>OT Holiday Applicable</label>
                  <input type="text" class="form-control" placeholder="Name" required="">
                </div>
                <div class="form-group col-sm-6">
                  <label>OT Weekend Applicable</label>
                  <input type="email" class="form-control" placeholder="Enter email" required="">
                </div>
              </div>
              
              
                <div class="form-row">
                <div class="form-group col-sm-6">
                  <label>Bank Name</label>
                  <input type="text" class="form-control" placeholder="Name" required="">
                </div>
                <div class="form-group col-sm-6">
                  <label>Account No</label>
                  <input type="email" class="form-control" placeholder="Enter email" required="">
                </div>
              </div>
              
             <div class="form-group">
                <label>Salary Given by</label>
                <input type="url" required="" class="form-control" placeholder="Your website url">
              </div>
              
              
                <div class="form-row">
                <div class="form-group col-sm-6">
                  <label>Cash Given by</label>
                  <input type="text" class="form-control" placeholder="Name" required="">
                </div>
                <div class="form-group col-sm-6">
                  <label>Bank Paid</label>
                  <input type="email" class="form-control" placeholder="Enter email" required="">
                </div>
              </div>
              
              
              
         
              <div class="text-right pt-2">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  
  </div>
</div>
<?

$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";

?>
