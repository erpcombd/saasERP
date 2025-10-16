<!DOCTYPE html>

<html style="height: 100%"  lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><?php echo $module_name; ?></title>
   
    <link href="../../../../public/assets/css/bootstrap.v4.4.1.min.css" type="text/css" rel="stylesheet"/>

<link rel="stylesheet" type="text/css" href="../../../../public/assets/css/acc_mod_index.css" media="all">
<?php
if($_GET['module_id']==1){  
$bg_image='accounts.png';
}
else if($_GET['module_id']==9){  
$bg_image='lc.png';
}
else if($_GET['module_id']==5){ 
$bg_image='sales.png';
}
else if($_GET['module_id']==7){  
$bg_image='purchase.png';
}
else if($_GET['module_id']==8){  
}
else if($_GET['module_id']==10){ 
$bg_image='damage.png';
}
else if($_GET['module_id']==6){  
$bg_image='mis.png';
}
else if($_GET['module_id']==4){  
$bg_image='warehouse.png';
}
else if($_GET['module_id']==2){  
$bg_image='hrm.png';
}
else if($_GET['module_id']==14){  
$bg_image='crm.png';
}
 ?>
<style type="text/css">
::placeholder{
color:#1e5fa3!important;
}
.erpcombd a.button:link, .erpcombd a.button:visited, .erpcombd button, .erpcombd input[type=submit], .erpcombd .ui-dialog-buttonpane .ui-dialog-buttonset .ui-button{
background-image:none!important;
background-color:#1e5fa3!important;
font-weight:bold;

}
.erpcombd .oe_enterprise form button {
margin-left:23px;
border-radius: 8px 8px 8px 8px!important;
height:44px;
border:0px!important;
font-size:22px;
text-shadow:none!important;
}
.erpcombd .oe_enterprise form fieldset input{
border-radius: 8px 8px 8px 8px!important;
width:75%!important;
margin-left:24px;
margin-bottom:40px;
font-size:13px;
font-family:raleway;
background-color:#c3ddf3;
border:none!important;
box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

}
.oe_enterprise_login_input{
margin-bottom:40px!important;

}
erpcombd .oe_enterprise .oe_enterprise_pane {
margin-left:24px;
   
    margin: 0 auto;
    position: relative;
    padding: 18px;
    top: 180px;
    width: 250px;
    background-color: #f5f5f5;
    background-image: -moz-linear-gradient(center top,white,rgb(227,227,227));
    border-radius: 10px 10px 10px 10px;
    box-shadow: 0 3px 16px rgba(12,0,49,.35);
    }
	

.oe_enterprise_content {
    background: url(../../../logo/<?php echo $bg_image;?>);
    background-size: 100% 100%;
    height: 100%!important;
    width: 100%!important;
    margin: 0px auto;
    padding: 0px;
}

@media screen and (max-width: 1060px) {
    #primary { width:67%; }
    #secondary { width:30%; margin-left:3%;}  
}


@media screen and (max-width: 768px) {
    #primary { width:100%; }
    #secondary { width:100%; margin:0; border:none; }
}
</style>
</head>

<body>



<div class="erpcombd erpcombd_webclient_container">

    <div class="oe_enterprise oe_login_signup">

            

            <div class="oe_enterprise_content">


                <div class="oe_login_pane oe_enterprise_pane">

                    <form action="" method="post">

                        <div style="opacity: 0; display: none;" class="oe_enterprise_signin">

                            <h2> Sign In</h2>

                        </div>

                        <div style="opacity: 1; display: block;" class="oe_enterprise_signup">
<div style="text-align:center; margin-bottom:40px;"><img alt="this is img" src="../../../../public/assets/images/logo.png" width="200px;" ></div>
                            
                        </div>

                        <div class="oe_login_error_message oe_enterprise_error_message"></div>


                      <fieldset><legend>Required Information:</legend>

                          <label style="font-size:20px; text-align:center;">OTP Verification</label>
                          <div style="background-color: #ceddd9;
padding: 10px;
border-radius: 8px;
margin: 10px;
font-size: 14px;
color: black;">We have sent a verification code on your registared mobile.</div>
 <input autofocus="autofocus" class="oe_enterprise_login_input" name="qr_input" value="" type="password"  width="75%">
                      </fieldset>
                      




                        <div style="opacity: 1; display: block;" class="oe_enterprise_signup">

                          <DIV class="oe_enterprise_submit" style="margin-top:0px!important">                                 
                            <button name="submit" style="width:270px;float:none;">Submit</button>
                          </DIV>


                      </div>
                    </form>

                </div>

            </div>

        </div>

<div class="oe_notification ui-notify"></div></div></body>

</html>

