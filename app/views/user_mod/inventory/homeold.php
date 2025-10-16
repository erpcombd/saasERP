<?php
@//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$_SESSION['employee_selected'] = $_SESSION['user']['PBI_ID'];


$title='Inventory Home Page';
echo $_SESSION['user']['module'];

?>


<style type="text/css">



.oe_app .oe_app_icon{

display:block;

float: left;

height: 48px;

position: relative;

width: 48px;

}



.oe_app .oe_app_icon img{

display:block;

height: 100%;

width: 100%;

}



.oe_app .oe_app_descr{

font-family:"Open Sans";

margin-left: 64px;

font-weight: 300;

font-size: 17px;

text-decoration:none;

color:#959494;

}



.oe_app_descr{



font-family:"Open Sans";

}





.oe_app .oe_app_name {

    font-size: 18px;

    /*font-weight: 400;*/

	/*text-align:center;*/

    margin-left: 64px;

    margin-top: -4px;

	/*font-family:"Open Sans";*/

	color:#646464;

	

}

.home_table td {

    padding: 2px;

}

.home_table_title {

    color: #617a03;

    font-weight: bold;

}

.home_box1 {

    background: url("../images/h_box_01.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);

    height: 212px;

    width: 249px;

}

.home_box2 {

    background: url("../images/h_box_02.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);

    height: 212px;

    width: 266px;

}

.home_box3 {

    background: url("../images/h_box_03.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);

    height: 212px;

    width: 241px;

}

.home_box4 {

    background: url("../images/h_box_04.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);

    height: 212px;

    width: 249px;

}

.home_box5 {

    background: url("../images/h_box_05.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);

    height: 212px;

    width: 266px;

}

.home_box6 {

    background: url("../images/h_box_06.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);

    height: 212px;

    width: 241px;

}

.left_report {

    overflow: auto;

}

.oe_app {

    background: none repeat scroll 0 0 whitesmoke;

    border: 1px solid transparent;

    border-radius: 2px;

    box-shadow: 0 0 white;

    box-sizing: border-box;

    color: inherit !important;

    cursor: pointer;

    display: block;

    float: left;

    height: 76px;

    margin: 16px;

    overflow: hidden;

    padding: 16px;

    position: relative;

    text-align: left;

    top: 0;

    transition: all 150ms linear 0s;

    width: 276px;

}

.oe_app:hover {

    border: 1px solid rgba(0, 0, 0, 0.1);

    box-shadow: 0 4px #dddddd, 0 4px 4px rgba(0, 0, 0, 0.1);

    top: -4px;

}

.style1 {font-size: 24px; color:#fff; font-weight:bold; margin-top:5px;}

.style2 {

	color: #FFFFFF;

	font-weight: bold;

}

</style>
<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->
          <div class="">
		  
		  
           
        <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Plain Page</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  
				  	 <div class="openerp openerp_webclient_container">
                    <table class="oe_webclient">
                    <tbody>
   
                      <tr>
			
				  
				  
                
				  


        <table width="96%" border="0" align="center" cellpadding="10" cellspacing="0" style="margin:20px;">

  <tr>

    <td>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Details Staff Report</title>



<style type="text/css">

body { font-family:Tahoma, Geneva, sans-serif;

font-size:12px; }

table{ border:solid; border:#99C; padding:5px; margin-bottom:5px;}

td{

text-align:center;

}

.style4 {font-size: 14px}

.style9 {color: #FFFFFF}

.style10 {font-size: 14px; color: #000; margin-top:10px }

.style14 {font-size: 16px; font-weight: bold; }

.style16 {font-size: 12}

</style>
<body>








<form action="" method="post" enctype="multipart/form-data">

<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title" align="center">USER MODULE</h3>
				</div>
				<div class="panel-body">
				

<!--<table width="30%" border="1" align="center" cellpadding="0" cellspacing="0" eight="790" style="border-color:#CCCCCC">
 <tr>
   <td colspan="5"><div align="center">1. <strong>KPI Marks Distribution (নম্বর বণ্টন):</strong> </div></td>
 </tr>
 <tr>
   <td colspan="3"><div align="center" style="font-weight:bold; font-size:16px;">Marks</div></td>
   <td colspan="2"><div align="center" style="font-weight:bold; font-size:16px;">Grade</div></td>
 </tr>
  <tr>
   <td colspan="3"><div align="center">90-100</div></td>
   <td colspan="2"><div align="center">A</div></td>
 </tr>
  <tr>
   <td colspan="3"><div align="center">80-89</div></td>
   <td colspan="2"><div align="center">B</div></td>
 </tr>
 <tr>
   <td colspan="3"><div align="center">70-79</div></td>
   <td colspan="2"><div align="center">C</div></td>
 </tr>
 <tr>
   <td colspan="3"><div align="center">60-69</div></td>
   <td colspan="2"><div align="center">D</div></td>
 </tr>
 <tr>
   <td colspan="3"><div align="center">01-59</div></td>
   <td colspan="2"><div align="center">F</div></td>
 </tr>
 </table><br />
 
 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" eight="790" style="border-color:#CCCCCC; font-size:16px;">

  
  <tr height="30">
     <td colspan="5">2.<strong>	Daily Tasks</strong> (প্রতিদিনের কাজ): For daily task there will be 40 (Forty) marks.প্রতিদিনের কাজের জন্য ৪০ (চল্লিশ) নম্বর থাকবে।</td></tr>
	 <tr height="30"><td colspan="5">3.	<strong>Weekly Tasks</strong> (সাপ্তাহিক কাজ): For weekly task there will be 60 (Sixty) marks.সাপ্তাহিক কাজের জন্য ৬0 (ষাট) নম্বর থাকবে।</td></tr>
	<tr height="30"> <td colspan="5">4.	<strong>Weekly Error & Overtime Report</strong> (সাপ্তাহিক ভুল এবং অতিরিক্ত সময় কাজ করার প্রতিবেদন): </td></tr>
	 <tr height="30"><td colspan="5">&nbsp;&nbsp;a)	For general mistake 3 marks will be deducted. সাধারণ ভুলের জন্য ৩ টি নম্বর কেটে নেওয়া হবে।</td></tr>
	 <tr height="30"><td colspan="5">&nbsp;&nbsp;b)	For serious mistake 10 marks will be deducted.গুরুতর ভুলের জন্য 10 নম্বর কেটে নেওয়া হবে।</td></tr>
 <tr height="30"><td colspan="5">&nbsp;&nbsp;c)	In case of overtime, for every hour 1 mark will be added to the score. ওভারটাইমের ক্ষেত্রে প্রতি ঘন্টার জন্য ১ নম্বর যুক্ত করা হবে।</td>
  </tr>
  

  

  

  

  

  
</table>-->

  
  
</form>
</td>

  
</table>

</div>
          </div>
		  </div>
          </div>
		  </div>
          </div>

</div>
          </div>
        </div>
        <!-- /page content -->


<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>            