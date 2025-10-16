<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



do_calander('#start_date');
do_calander('#end_date');





$att_id=find_a_field('hrm_att_summary','in_time','id='.$_GET["id"]);
$in_time=date("d-M-Y h:i:s",strtotime($att_id));



 if(isset($_POST['edit'])){
 
            $in_timee = $_POST['in_time'];
			$in_timee_formated=date("Y-m-d h:i:s",strtotime($in_timee));
			$msg='<div class="alert alert-success">Data Edited Successfully!</div>';
			
			//values for coditional query
			$sac_time=find_a_field('hrm_att_summary','sch_in_time','id='.$_GET["id"]);
            $sac_time=date("H:i",strtotime($sac_time));
			$new_in_timee=date("H:i",strtotime($in_timee));
			
			
			if($new_in_timee<$sac_time){
			
			$sql="UPDATE hrm_att_summary SET in_time = '$in_timee_formated',final_late_min=0,final_late_status=0 WHERE id ='".$_GET['id']."' ";
            $result =db_query($sql);
            if($result){
            $msg ;     }
			
			
			}else{
			
			$sql="UPDATE hrm_att_summary SET in_time = '$in_timee_formated',final_late_min=5,final_late_status=1 WHERE id ='".$_GET['id']."' ";
            $result =db_query($sql);
            if($result){
            $msg ;     }
			
			
			}
			
			
			
		    
			
			
			
			}
 


 
 

?>



<style type="text/css">
<!--
.style2 {color: #FFFFFF; }
-->
</style>



<div class="right_col" role="main">
  <!-- Must not delete it ,this is main design header-->
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>EDIT ATTENDENCE INTIME PAGE</h2>
            
            <div class="clearfix"></div>
          </div>
          <div class="openerp openerp_webclient_container">
            <div class="x_content">


<form action="" method="post">
  <div class="form-group">
  <div><h4><?=$msg;?></h4></div>
    <label for="in_time">Change In Time</label>
    <input type="datetime" name="in_time" class="form-control" id="time"  value="<?=$in_time;?>"  >
    <small id="emailHelp" class="form-text text-muted" style="color:#FF0000">Actual Attendence Date : <?=$att_id;?></small>
  </div>
  

 
 
  <button type="submit" name="edit" class="btn btn-primary">Submit</button>
</form>




</div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
    </div>
	
	
	</div>
</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





<?

require_once SERVER_CORE."routing/layout.bottom.php";



?>