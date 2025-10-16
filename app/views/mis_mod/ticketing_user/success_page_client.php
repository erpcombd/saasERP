<?php

require_once "../../../controllers/routing/default_values.php";
require_once "../../../controllers/config/check_login_static.php";




if(check_for_loginstatic('saaserp','supportuser','312351bff07989769097660a56395065',1)){


require_once SERVER_CORE."routing/layout.top.php";


$title = "Ticket Created Successfully";


$datas = find_all_field('it_support_request', '', 'id="'.$_GET['ticket'].'"');

?>


    <style>
        td {
            padding: 7px!important;
        }
    </style>

    

    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            
        <div class="container mt-5">
        <div class="card border-primary" style="background-color: #f5faff;">
    <div class="card-body d-flex justify-content-between align-items-center">
      <div>
        <h5 class="card-title font-weight-bold text-dark">Ticket Successfully Created</h5>
        <p class="mb-3 text-secondary">
          Ticket Issued: Your TicketId Is 
          <a href="#" class="font-weight-bold text-primary"><?=$datas->request_id?></a>
        </p>
        <a href="view_support_client.php?view=<?= $datas->id ?>" class="btn btn-primary">Your Ticket</a>
      </div>
      <div>
        <img src="../../../../public/assets/images/ticket.gif" alt="Ticket Icon">
      </div>
    </div>
  </div>
</div>

            
        </div>
    </div>



<?php
require_once SERVER_CORE."routing/layout.bottom.php";
}
?>