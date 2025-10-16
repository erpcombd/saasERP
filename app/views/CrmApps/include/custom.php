    <style>
    
    .my-dashboard-stat {
        cursor:pointer;
    }
    .my-dashboard-stat-bg:hover {
        background: #cbcbcb29!important;
        color: #5a5a5afa!important;
    }
    .stat-name {
        font-size: 14px;
    }
    .stat-counter {
        font-size:18px;
    }
    
    .lead-contacts span {
        display: block;    
    }
    
    @media only screen and (min-width: 640px) {
      .lead-contacts{
        border-left: 1px solid #c5c5c5ab;
        text-align: right;
      }
    }
    
    .lead-task-card {
        width: 96%!important;
        margin: 0 auto;
        border-radius: 3px!important;
        height: 115px;
        box-shadow: none!important;
        border: 1px solid #e5e5e57d!important;
        border-bottom: 1px solid #a3a3a373!important;
        overflow: hidden;
    }
    
    a {
        color: #333333 !important;
    }
    
    input:hover, input:focus, select:hover, select:focus {
       border: none;
       background: #F7F6F600;  
    }
    .dropdown-menu .dropdown-item:hover, .dropdown-menu .dropdown-item:focus, .dropdown-menu a:hover, .dropdown-menu a:focus, .dropdown-menu a:active {
        
        box-shadow: none!important; 
        background-color: #ffffff00!important;
        color: #FFFFFF; 
    }
    
    .bootstrap-select > .dropdown-toggle{
        height: 32px!important;
        width: 99.2%!important;
    }
    
    .bootstrap-select.show-tick .dropdown-menu li a span.text {
        margin-right: 2px!important; 
    }
    
    .bootstrap-select {
        border: 1px solid #9fb2c5 !important;
        border-radius: .25rem!important;
        height: 35px!important;
    }
    
    .selected {
        background-color: #e3e3e3bd!important;
        text-shadow: none!important;
        box-shadow: none!important;
    }
    
    a.selected {
        background: #ffffff00!important;
        margin-left: 10px!important;
        padding: 2px!important;
    }
    
    span.text {
        font-family: inherit!important;
     /*   font-size: 14px !important;*/
  /*      margin-top: 3px!important;*/
    }
    
    select.input_required > .bootstrap-select{
        border-left:3.5px solid #df5b5b!important;
    }
    
    select.input_general > .bootstrap-select{
        border-left:3.5px solid #aeddf7!important;
    }
    
    .input_required {
        border-left:3.5px solid #df5b5b!important;
    }
    .input_general {
        border-left: 3.5px solid #aeddf7 !important;
    }
    
    .event {
        width: 135%;
        height: 20px;
        padding: 0px!important;
        margin-left: -10px;
        overflow: hidden;
        text-align: center!important;
        font-size:10px!important;
    }
    
</style>

<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
-->

    <?php    
    
        if(!isset($_SESSION['user']['id'])){
            die();
        }
 
        
        
        //get there from $table = 'hrm_weekly_offdays' if connected with HRM;   
        $offDays = array();
        
        $WeekendQry = "SELECT * FROM hrm_weekly_offdays WHERE employee_PBI_ID = '".$_SESSION['employee_selected']."'";
        $WeekendRslt = db_query($WeekendQry);
        if($WeekendRslt)
        while($Weekend = mysqli_fetch_object($WeekendRslt)){
            array_push($offDays, $Weekend->day);
        }
        
        //get there from $table = 'hrm_partial_offdays' if connected with HRM; 
        
        $partialOffDays = array();
        
        $partialWeekendQry = "SELECT * FROM hrm_partial_offdays WHERE employee_PBI_ID = '".$_SESSION['employee_selected']."'";
        $partialWeekendRslt = db_query($partialWeekendQry);
        if($partialWeekendRslt)
        while($partialWeekend = mysqli_fetch_object($partialWeekendRslt)){
            array_push($partialOffDays, $partialWeekend->week_no.'#'.$partialWeekend->day_no);
        }
        
        
        
        //get there from $table = 'crm_feature_names' if connected with CRM;
        $CRMtaskName = "Activities";
        $CRMleadName = "Project";
        $CRMscheduleName = "Schedules";
        $CRMcampaignName = "CRM Campaign";
    
    ?>
    
    
    


<?php

    $today = date('Y-m-d H:i');

    function needPastDate($dayAgo, $today){
        $lastdays = date("Y-m-d H:i", strtotime("-".$dayAgo." days", strtotime($today)));
        return $lastdays;
    }
    
    function ts_time_diff_show($atp, $top='', $msg=''){
        date_default_timezone_set('Asia/Dhaka');
        if($top==''){
            $top = date('Y-m-d H:i:s');
        }else{
            $top = date('Y-m-d H:i:s', strtotime($top));
        }
        $atpObject = new DateTime($atp);
        $topObject = new DateTime($top);
    
        if($topObject <= $atpObject){
            if($msg==''){
                echo 'in time';
            }else{
               echo $msg; 
            }
            
        }else{
            $interval = $topObject->diff($atpObject);
            
            $years = $interval->y;
            $months = $interval->m;
            $days = $interval->d;
            $hours = $interval->h;
            $mins = $interval->i;
            $seconds = $interval->s;
            
            if($years != 0 || $years != '' || $years != NULL){
                echo $years.' years ';
            }if($months != 0 || $months != '' || $months != NULL){
                echo $months.' months ';
            }if($days != 0 || $days != '' || $days != NULL){
                echo $days.' days ';
            }if($hours != 0 || $hours != '' || $hours != NULL){
                echo $hours.' hours ';
            }if($mins != 0 || $mins != '' || $mins != NULL){
                echo $mins.' mins ';
            }if($seconds != 0 || $seconds != '' || $seconds != NULL){
                echo $seconds.' seconds';
            }
        }
    
    }


        
        $superID = array('1007');
        
        $Task_stat_ar = array('', 'Ongoing', 'Completed', 'Due', 'Canceled', 'Expired', 'Upcoming');
        $Priority_ar = array('', 'High', 'Medium', 'Low');
    
        function encrypTS($str){
            $ciphering = "AES-128-CTR";   
            $salt = "TsEncrYptIon";  
            $encrypted = openssl_encrypt($str, $ciphering, $salt);
            return $encrypted;
        }
        
        function decrypTS($str){
            $ciphering = "AES-128-CTR";   
            $salt = "TsEncrYptIon";  
            $decrypted = openssl_decrypt($str, $ciphering, $salt);
            return $decrypted;
        }
        
        function getLastInsertID($table, $id='id'){
            
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
            
            $lastID_qry = "SELECT $id as a FROM $table ORDER BY $id DESC LIMIT 1";
            $lastID_rslt = db_query($lastID_qry);
            $lastID_data = mysqli_fetch_object($lastID_rslt);
            return $lastID_data->a;
        }


?>



<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>

<script>$('.selectpicker').selectpicker();</script>


<?php 
//////////////This function for Selected and search//////////////
    function selected_erp($data) {
        echo '<script language="javascript">
          $("'.$data.'").select2({
              placeholder: "Select",
              allowClear: true
          });</script>';
    }

?>