<?php
session_start ();
include ("config/access_admin.php");
include ("config/db.php");
include 'config/function.php';


$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Target';
$sub_menu 		= 'target_upload_ratio';


if($_POST['target_month']!=''){
$target_month=$_POST['target_month'];}
else{
$target_month=date('n');
}

if($_POST['target_year']!=''){
$target_year=$_POST['target_year'];}
else{
$target_year=date('Y');
}




if(isset($_POST["upload"])){

$product_group 		= $_POST['product_group'];    
$target_year 		= $_POST['target_year'];
$target_month 		= sprintf('%02d', $_POST['target_month']);
$now = date('Y-m-d H:i:s');


// delete old upload if exists
$del = "DELETE FROM ss_target_ratio WHERE target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' 
and product_group='".$_POST['product_group']."'
";
mysqli_query($conn,$del); 
// end delete


$filename=$_FILES["upload_file"]["tmp_name"];
	if($_FILES["upload_file"]["tmp_name"]!=""){
	//echo '<span style="color: red;">Excel File Successfully Imported</span>';
	$file = fopen($filename, "r");

while (($excelData = fgetcsv($file, 50000, ",")) !== FALSE){
    

if($excelData[1]>0){
        $sql = "INSERT IGNORE INTO ss_target_ratio (target_year,target_month, product_group,emp_code,emp_name,dealer_code,dealer_name, target_con, entry_by, entry_at)
        VALUES ('".$_POST['target_year']."', '".$_POST['target_month']."','".$_POST['product_group']."', '".$excelData[1]."', 
          '".$excelData[2]."', '".$excelData[3]."','".$excelData[4]."'
		,'".$excelData[5]."','".$entry_by."', '".$entry_at."'   )";	
        
  mysqli_query($conn,$sql);
}		


} // end while loop
} // end upload file
fclose($file);
$msg =  "Target Ratio Upload Complete";

} // END Upload File




if(isset($_POST["replace"])){

$product_group 		 = $_POST['product_group'];    
$target_year 		   = $_POST['target_year'];
$target_month 		 = sprintf('%02d', $_POST['target_month']);
$now               = date('Y-m-d H:i:s');



$filename=$_FILES["upload_file"]["tmp_name"];
	if($_FILES["upload_file"]["tmp_name"]!=""){
	//echo '<span style="color: red;">Excel File Successfully Imported</span>';
	$file = fopen($filename, "r");

while (($excelData = fgetcsv($file, 50000, ",")) !== FALSE){
  
  
// delete single file if exist
$del = "DELETE FROM ss_target_ratio WHERE target_year='".$_POST['target_year']."' and target_month='".$_POST['target_month']."' 
and product_group='".$_POST['product_group']."' and emp_code='".$excelData[1]."'
";
mysqli_query($conn,$del); 
// end delete
    

if($excelData[1]>0){
        $sql = "INSERT IGNORE INTO ss_target_ratio (target_year,target_month, product_group,emp_code,emp_name,dealer_code,dealer_name, target_con, entry_by, entry_at)
        VALUES ('".$_POST['target_year']."', '".$_POST['target_month']."','".$_POST['product_group']."', '".$excelData[1]."', '".$excelData[2]."', '".$excelData[3]."','".$excelData[4]."'
		,'".$excelData[5]."','".$entry_by."', '".$entry_at."'   )";	
        
        mysqli_query($conn,$sql);
}		


} // end while loop
} // end upload file


fclose($file);
$msg =  "Target Ratio Added Ok";

} // END Replce File



// copy this month to next month
if(isset($_POST["setnew"])){

$product_group 		= $_POST['product_group'];    
$target_year 		= $_POST['target_year'];
$target_month 		= $_POST['target_month'];
$now          = date('Y-m-d H:i:s');



if($target_month==12){
$new_month=1;
$new_year=$target_year+1;
}else{
$new_month=$target_month+1;
$new_year=$target_year;
}

// delete old upload if exists
$del = "DELETE FROM ss_target_ratio WHERE target_year='".$new_year."' and target_month='".$new_month."' 
and product_group='".$_POST['product_group']."'
";
mysqli_query($conn,$del); 
// end delete


$sql="select * from ss_target_ratio where target_year='".$target_year ."' and target_month='".$target_month."' and product_group='".$product_group."'";
$query=mysqli_query($conn,$sql);
while($data=mysqli_fetch_object($query)){

$ss="insert ignore into ss_target_ratio(target_year,target_month,product_group,emp_code,emp_name,dealer_code,dealer_name,target_con,entry_by,entry_at)
values
('".$new_year."','".$new_month."','".$product_group."','".$data->emp_code."','".$data->emp_name."','".$data->dealer_code."','".$data->dealer_name."','".$data->target_con."','".$entry_by."','".$entry_at."')
";
mysqli_query($conn,$ss);		

} // end while
$msg =  "New Month contribution file make Complete";
} // end next month
?>



<?php
include 'inc/header.php';
include 'inc/sidebar.php';
?>  



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Target Ratio File Upload</h1>
          </div>
<!--    <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div> -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">



<div class="content-header">
<?php if(isset($msg)){  ?><div class="alert alert-primary" role="alert"><?php echo @$msg; ?></div><?php } ?>
<?php if(isset($emsg)){  ?><div class="alert alert-danger" role="alert"><?php echo @$emsg; ?></div><?php } ?>
</div>

<div class="card mb-4">
<div class="card-body">
<!--BODY Start	-->
				
<div class="row">
<div class="col-md-12 col-xs-12">

<form action=""  method="post" enctype="multipart/form-data">
        <div class="oe_view_manager_body">
<div  class="oe_view_manager_view_list"></div>
<div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">


<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">
          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
            
            
            <table width="80%" border="1" align="center">


              <tr>
                <td>Year </td>
                <td width="24%"><select name="target_year" style="width:160px;" id="target_year" required="required">
				  <option <?=($target_year=='2022')?'selected':''?>>2022</option>
                </select></td>
               
			   
			   <!-- <td width="12%">Group For </td>-->
      <!--          <td width="59%" colspan="3"><select name="grp" id="grp" required="required">-->
      <!--            <option></option>-->
				  <!--<option value="A">A</option>-->
				  <!--<option value="B">B</option>-->
				  <!--<option value="C">C</option>-->
      <!--          </select></td>-->
              </tr>
              <tr>
                <td>Month</td>
                <td><span class="oe_form_group_cell">
                  <select name="target_month" style="width:160px;" id="target_month" required="required">
                    <option value="1" <?=($target_month=='1')?'selected':''?>>Jan</option>
                    <option value="2" <?=($target_month=='2')?'selected':''?>>Feb</option>
                    <option value="3" <?=($target_month=='3')?'selected':''?>>Mar</option>
                    <option value="4" <?=($target_month=='4')?'selected':''?>>Apr</option>
                    <option value="5" <?=($target_month=='5')?'selected':''?>>May</option>
                    <option value="6" <?=($target_month=='6')?'selected':''?>>Jun</option>
                    <option value="7" <?=($target_month=='7')?'selected':''?>>Jul</option>
                    <option value="8" <?=($target_month=='8')?'selected':''?>>Aug</option>
                    <option value="9" <?=($target_month=='9')?'selected':''?>>Sep</option>
                    <option value="10" <?=($target_month=='10')?'selected':''?>>Oct</option>
                    <option value="11" <?=($target_month=='11')?'selected':''?>>Nov</option>
                    <option value="12" <?=($target_month=='12')?'selected':''?>>Dec</option>
                  </select>
                </span></td>
                <td width="20%">&nbsp;</td>
                <td width="45%" colspan="3"><input name="setnew" type="submit" id="setnew" value="Copy to New Month" /></td>
              </tr>
              <tr>
                <td>Group</td>
                <td><select name="product_group" style="width:160px;" id="product_group" required="required">
                  <option <?=($product_group=='A')?'selected':''?>>A</option>
				  <option <?=($product_group=='B')?'selected':''?>>B</option>
				  <option <?=($product_group=='C')?'selected':''?>>C</option>
                </select></td>
                <td>&nbsp;</td>
                <td colspan="3">Note: This button help to make next month contribution file automatically.</td>
              </tr>

              <tr>
                <td>&nbsp;</td>
                <td></td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td width="11%">Upload File</td>
                <td><input name="upload_file"  type="file" id="upload_file" <? if($_POST['upload']){ ?>required="required"<? } ?>/></td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
            </tr>



              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td><input name="upload" type="submit" id="upload" value="Upload File(Delete old full data)" />
                  Note: All group data delete then insert this file. </td>
                <td>&nbsp;</td>
                <td><p>
                  <input name="replace" type="submit" id="replace" value="Upload File(Replace DATA)" />
                (Note: additional data can be use this button)</p>
                  <p>&nbsp; </p></td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>

                <td colspan="6">
                  <div align="center"></div></td>
                </tr>
<tr>
<td colspan="6"><label>
<div align="center"><p>CSV File Example: </p>

<table width="800" align="left" cellpadding="0" cellspacing="0">

  <tr height="20">
    <td><div align="left"><strong>SL </strong></div></td>
	<td><div align="left"><strong>SO Code </strong></div></td>
    <td><div align="left"><strong>SO Name </strong></div></td>
    <td><div align="left"><strong>Dealer Code</strong></div></td>
    <td><div align="left"><strong>Dealer Name</strong></div></td>
    <td><div align="left"><strong>Target Ratio </strong></div></td>
  </tr>
    <tr height="20">
    <td>1</td>
    <td>26194</td>
    <td>Karim</td>
    <td>17458</td>
    <td>Ma Enterprise</td>
    <td>48</td>
  </tr>
</table>
</div>

                    </label></td>
              </tr>
            </table>
			
		

            <br />
			
<div class="row">
Note: Some dealer point present multi Field Officer. 
<br>Thats why we have to manage them to provide individual target setup.
<br>So use this target contribution for that.
</div>			
			
          </div>
          </div>

          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
</div>
 </form>



</div> <!--end first column-->
</div>	













      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 


<?php
include 'inc/footer.php';
?>  