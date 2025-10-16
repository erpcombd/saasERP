<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$menu = 'Report';
$sub_menu = 'report_list';
$today = date('Y-m-d');
?>
        
<!--Top header	-->	
<?php include("inc/header.php");?>
<?php include("inc/header_top.php");?>
        

<section class="content-main">
<div class="content-header">
<h2 class="content-title">Select Report</h2>
</div>

<div class="card mb-4">
<div class="card-body">
<!--BODY Start	-->
				


<div class="row">


<!--1st Column --> 
  
<div class="col-md-4">
<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">


<div class="radio"><label>
<input type="radio" checked="checked" id="optionsRadios1" name="report" value="101"> Visitor List (101)
</label></div>


<!--<div class="radio"><label>-->
<!--<input type="radio" id="optionsRadios1" name="report" value="102"> Department wise Visitor List (102)-->
<!--</label></div>-->

	
	
</div>
    
<!--2nd Column	-->
<div class="col-md-6">

  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Visitor Name</label>
    <div class="col-sm-10">
      <!--<input type="text" class="form-control mb-10" id="visitor_name" name="visitor_name">-->
        <input list="browsers" class="form-control mb-10" name="visitor_name" id="visitor_name" autocomplete="off">
  <datalist id="browsers">
	<?php optionlist('select visitor_name from visitor_table where 1 order by visitor_name');?>
  </datalist>
    </div>
  </div>
 
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Department</label>
    <div class="col-sm-10">
<select class="form-select mb-10" name="department" id="department">
  <option></option>
   <?php optionlist("select department_id,department_name from setup_department where 1");?> 
</select>    
  </div>  
</div>

  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Date</label>
    <div class="col-sm-4"><input type="date" class="form-control" id="f_date" name="f_date" autocomplete="off" value="<?=date('Y-m-01');?>"></div>
	<div class="col-sm-2"> To </div>
	<div class="col-sm-4"><input type="date" class="form-control" id="t_date" name="t_date" autocomplete="off" value="<?=date('Y-m-d');?>"></div>
  </div>  


</div>

</div>  
<p></p>

<div class="row">
<div class="col-md-12">
<input name="submit" type="submit" class="btn btn-block btn-lg btn-success" value="Report Show" />
</div>
</div>
</form>	





<!-- Body end -->
</div>            
</div>
</section> 		

<?php include("inc/footer.php");?>