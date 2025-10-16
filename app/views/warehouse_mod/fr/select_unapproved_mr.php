<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Unapproved FG Requisition List';

$table = 'requisition_fg_master';
$unique = 'req_no';
$status = 'UNCHECKED';
$target_url = 'mr_checking.php';

$wids=find_a_field('warehouse_define','group_concat(warehouse_id)','user_id="'.$_SESSION['user']['id'].'" ');

if($_POST[$unique]>0)
{
//$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url.'?'.$unique.'='.$_POST[$unique]);
}
?>





<div class="sr-main-content-padding pt-4">

   


<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz">
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"><?=$title?>:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						
						 <select name="<?=$unique?>" id="<?=$unique?>">
        <? 
       // echo $wids = user_wid_list($_SESSION['user']['id']);   
        foreign_relation($table,$unique,$unique,$$unique,'warehouse_id in ('.$wids.')  and status="'.$status.'"');?>
        
      </select>
						
                         
                        </div>
                    </div>

                </div>
               

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
					 <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input">
					 
					 
					 
					 
					 
                </div>

            </div>
        </div>

        
    </form>
</div>




      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
<div class="container-fluid">
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
        </div>
      </nav>

    
	</div>




<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>