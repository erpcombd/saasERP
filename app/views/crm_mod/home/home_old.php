<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Customer Relationship Management Dashboard";

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');

/*if($_SESSION['employee_selected']==0 || $_SESSION['employee_selected']==''){

header('location:../../../crm_mod/pages/home/index.php');

}*/

 $today = date('Y-m-d');

 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));

 $cur = '&#x9f3;';

?>








<div class="container">
  <div class="row">
    <div class="col-md-6">
      <div class="card bg-light mb-3" style="max-width: 120rem;">
        <div class="card-header h2">08</div>
          <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg">
            <i class="fa fa-plus-circle fa-3x" style="position:absolute;right:10px;top:5px;" aria-hidden="true"></i>
            </a>
        <div class="card-body" >
          <h5 class="card-title text-danger">Project</h5>
          <p class="card-text text-muted">Lorem ipsum dolor sit amet.</p>
        </div>
        <div class="card-footer" style="border-top:1px solid tomato">
        <div class="form-group text-end">
          <a href="#" class="btn btn-sm">Learn More</a>
        </div>
        </div>
      </div>
    </div>
<!-- Modal Start Here -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Create Lead</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post">
      <div class="modal-body">
      <h3 class=text-center>Lead Information</h3>
        <div class="row">
         
            <div class="col-sm-6">
              <table class="table">
                <tbody>
                  <tr>
                    <td>Lead Owner</td>
                    <td>
                      <select name="" id="" class="form-control">
                        <option value="">Sabbir Ahammed</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>First Name</td>
                    <td><input type="text" class="form-control"></td>
                  </tr>
                  <tr>
                    <td>Title</td>
                    <td><input type="text" class="form-control"></td>
                  </tr>
                  <tr>
                    <td>Phone</td>
                    <td><input type="text" class="form-control"></td>
                  </tr>
                  <tr>
                    <td>Mobile</td>
                    <td><input type="text" class="form-control"></td>
                  </tr>
                  <tr>
                    <td>Lead Source</td>
                    <td>
                      <select name="" id="">
                        <option value="">--None--</option>
                        <option>Advertisement</option>
                        <option>Web Research</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Industry</td>
                    <td>
                      <select name="" id="">
                        <option value="">--None--</option>
                        <option>ASP(application service provider)</option>
                        <option>Data/telecom OEM</option>
                      </select>
                    </td>
                  </tr>
                
                  <tr>
                    <td style="width:40%;">Email Opt Out</td>
                    <td><input type="checkbox"></td>
                  </tr>
                  
                </tbody>
              </table>
            </div>
            <div class="col-sm-6">
              <table class="table">
                <tbody>
                  <tr>
                    <td>Company</td>
                    <td><input type="text" class="form-control"></td>
                  </tr>
                  <tr>
                    <td>Email</td>
                    <td><input type="text" class="form-control"></td>
                  </tr>
                  <tr>
                    <td>Website</td>
                    <td><input type="text" class="form-control"></td>
                  </tr>
                  <tr>
                    <td>Lead Status</td>
                    <td>
                      <select name="" id="">
                        <option value="">--None--</option>
                        <option>Attempted to Contact</option>
                        <option>Contact In future</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>No of Employees</td>
                    <td><input type="text" class="form-control"></td>
                  </tr>
                  <tr>
                    <td>Rating</td>
                    <td>
                      <select name="" id="">
                        <option value="">--None--</option>
                        <option>Acquired</option>
                        <option>Active</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Annual Revenue</td>
                    <td><input type="text" class="form-control"></td>
                  </tr>
                </tbody>
              </table>
            </div>
         
        </div>
        <h3 class="text-center">Address Information</h3>
        <div class="row">
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr>
                  <td>Street</td>
                  <td><input type="text" class="form-control"></td>
                </tr>
                <tr>
                  <td>State</td>
                  <td><input type="text" class="form-control"></td>
                </tr>
                <tr>
                  <td>Country</td>
                  <td><input type="text" class="form-control"></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr>
                  <td>City</td>
                  <td><input type="text" class="form-control"></td>
                </tr>
                <tr>
                  <td>Zip Code</td>
                  <td><input type="text" class="form-control"></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="form-group pt-3 m-0 m-auto">
                    <label for="message text-center">Description Information</label>
                    <textarea name="message" class="form-control" cols="40" rows="4" required></textarea>
                </div>
                
        </div>
      </div>
      
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal End Here -->
    <div class="col-md-6">
      <div class="card bg-light mb-3" style="max-width: 120rem;">
        <div class="card-header h2">03</div>
        <a href="#" >
            <i class="fa fa-plus-circle fa-3x" style="position:absolute;right:10px;top:5px" aria-hidden="true"></i>
          </a>
        <div class="card-body" >
          <h5 class="card-title text-danger">Calls & Meetings</h5>
          <p class="card-text text-muted">Lorem ipsum dolor sit amet.</p>
        </div>
        <div class="card-footer" style="border-top:1px solid tomato">
        <div class="form-group text-end">
          <a href="#" class="btn btn-sm">Learn More</a>
        </div>
          
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card bg-light mb-3" style="max-width: 120rem;">
        <div class="card-header h2">12</div>
        <a href="#">
            <i class="fa fa-plus-circle fa-3x" style="position:absolute;right:10px;top:5px" aria-hidden="true"></i>
          </a>
        <div class="card-body" >
          <h5 class="card-title text-danger">Task List</h5>
          <p class="card-text text-muted">Lorem ipsum dolor sit amet.</p>
        </div>
        <div class="card-footer" style="border-top:1px solid tomato">
        <div class="form-group text-end">
          <a href="#" class="btn btn-sm">Learn More</a>
        </div>
          
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card bg-light mb-3" style="max-width: 120rem;">
        <div class="card-header h2">11</div>
        <a href="#" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-plus-circle fa-3x" style="position:absolute;right:10px;top:5px"></i>
          </a>
        <div class="card-body" >
          <h5 class="card-title text-danger">My Leads</h5>
          <p class="card-text text-muted">Lorem ipsum dolor sit amet.</p>
        </div>
        <div class="card-footer" style="border-top:1px solid tomato">
        <div class="form-group text-end">
          <a href="#" class="btn btn-sm">Learn More</a>
        </div>
          
        </div>
      </div>
    </div>
  </div>
</div>









<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>