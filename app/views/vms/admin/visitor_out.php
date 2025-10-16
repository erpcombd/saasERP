<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$menu           = 'Visitor';
$sub_menu       = 'visitor_out';
$today          = date('Y-m-d');
$company_id     = $_SESSION['company_id'];

$target = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."?company_id=".$company_id;
$target =  str_replace("out","self",$target);
?>


<?php
    if(isset($_POST['code'])){
        
        $code = $_POST['code'];
        
        $check = findall("select * from visitor_table where visitor_card_no='".$code."' and company_id='".$company_id."' and visitor_status='In' ");
        if($check->visitor_id>0){
        
        
            $out_date = date("Y-m-d");
            $out_time = date("Y-m-d H:i:s");
            
            $visitor_card_no = $code;
            
           $sql = 'UPDATE visitor_table 
            SET visitor_out_date = "'.$out_date.'", visitor_out_time = "'.$out_time.'" , visitor_status= "Out"
            WHERE visitor_card_no ="'.$visitor_card_no.'" and company_id="'.$company_id.'" and visitor_id="'.$check->visitor_id.'" ';
            
            mysqli_query($conn, $sql);
            
            $msg = 'Your Card: '.$visitor_card_no.'. Out Time Update successfully. Thank You';
        
        
        }else{ $msg= 'Sorry NO Visiting Card found';}

        
    }


?>

<html>
    <head>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Visitor Management System</h1>
<div class="row">
    <div class="col-md-6">
        <video id="preview" width="100%"></video>
    
    
    <form action="" method="post" class="form-horizontal"> 
    <label>SCAN QR CODE</label>
    <input type="text" name="code" id="text" readonly="" placeholder="scan qrcode" class="form-control">
</form>
    </div>
    
    
    
                
    <div class="col-md-6">
          <h1>Scan this QR Code for Self Register</h1>    
            <img src="https://chart.apis.google.com/chart?cht=qr&chs=250x250&chl=<?php echo $target?>">
            <h5><?php echo $target?></h5>
    </div>


</div>
            
<div class="row">
    <div class="col-md-6">
    <h1><?php echo $msg?></h1>
    </div>
    
    <div class="col-md-6">
   
    </div>    
    
</div>            
            
            
    </div>

        <script>
           let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
           Instascan.Camera.getCameras().then(function(cameras){
               if(cameras.length > 0 ){
                   scanner.start(cameras[0]);
               } else{
                   alert('No cameras found');
               }

           }).catch(function(e) {
               console.error(e);
           });

           scanner.addListener('scan',function(c){
               document.getElementById('text').value=c;
               document.forms[0].submit();
           });

        </script>
    </body>
</html>