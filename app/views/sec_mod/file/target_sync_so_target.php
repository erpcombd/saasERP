<?php
session_start ();
include ("config/access_admin.php");
include ("config/db.php");
include 'config/function.php';


$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Target';
$sub_menu 		= 'target_sync_so_target';



$entry_by = $_SESSION['username'];
$datetime 	= date('Y-m-d H:i:s');

if($_POST['mon']!=''){
$mon=$_POST['mon'];
}else{
$mon=date('n');
}

if($_POST['year']!=''){
$year=$_POST['year'];
}else{
$year=date('Y');
}



if($_POST['update']){

$year=$_POST['year'];
$mon=$_POST['mon'];


$del = 'delete from ss_target_upload where target_year="'.$year.'" and target_month="'.$mon.'" ';
mysqli_query($conn,$del);


// Dealer Target
$tt="select dealer_code as code,sum(target_amount) as amount from sale_target_upload where target_year='".$year."' and target_month='".$mon."' 
group by dealer_code";
$query1 = mysqli_query($conn,$tt);
while($info1 = mysqli_fetch_object($query1)){
$dealer_target_amount[$info1->code]=$info1->amount;
}


// Target Contribution Data
$tc = "select emp_code,target_con from ss_target_ratio where target_year='".$year."' and target_month='".$mon."' group by emp_code";
$query2 = mysqli_query($conn,$tc);
while($info2 = mysqli_fetch_object($query2)){
$contribution[$info2->emp_code]=$info2->target_con;
}




// USER LIST
$sql='select * from ss_user where status="Active" order by username';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){

$dealer_code = $info->dealer_code;

$target_con     =$contribution[$info->username]; if($target_con==''){ $target_con=100;}
$dealer_target  = $dealer_target_amount[$dealer_code];
$sales_target   = ($dealer_target*$target_con)/100;


// Insert data 
if($sales_target>0){
$ss="INSERT INTO ss_target_upload ( target_year,target_month,so_code,dealer_code,target_amount,entry_by,entry_at
) VALUES (
'".$year."','".$mon."','".$info->username."','".$dealer_code."','".$sales_target."','".$entry_by."','".$datetime."'
)";
mysqli_query($conn,$ss);
}
		
$target_con=0;
$dealer_target=0;
$sales_target=0;
			
}	// end while user list

echo 'Done';
} // end submit
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
            <h1 class="m-0">Update So target from head office target: ss_target_upload</h1>
          </div>
<!--           <div class="col-sm-6">
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






<form action="" method="post">
<div class="oe_view_manager oe_view_manager_current">
        
    <div class="oe_view_manager_body">
            
    <div  class="oe_view_manager_view_list"></div>
            
        <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
<div class="oe_form_sheetbg" style="min-height:10px;">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
           	 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
<!--    <td bgcolor="#33CCFF">Group</td>
    <td bgcolor="#33CCFF"><select name="grp" style="width:160px;" id="grp" required="required">
      <option <?=($grp=='A')?'selected':''?>>A</option>
      <option <?=($grp=='B')?'selected':''?>>B</option>
      <option <?=($grp=='C')?'selected':''?>>C</option>
    </select></td>-->
    <td height="35" bgcolor="#33CCFF"><strong>Year: </strong></td>
    <td bgcolor="#33CCFF">
	<select name="year" style="width:160px;" id="year" required="required" >
	  <option <?=($year=='2022')?'selected':''?>>2022</option>
	</select>
	
</td>
    <td bgcolor="#33CCFF"><strong>Month</strong></td>
    <td bgcolor="#33CCFF">
	<select name="mon" style="width:160px;" id="mon" required="required" >
	    <option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>
        <option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>
        <option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>
        <option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>
        <option value="5" <?=($mon=='5')?'selected':''?>>May</option>
        <option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>
        <option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>
        <option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>
        <option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>
        <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
        <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
        <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>
	</select>
	</td>
    <td align="center" valign="middle" bgcolor="#33CCCC"><input name="update" type="submit" id="submit" value="Update" /></td>
  </tr>
</table>

		
		  
          </div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
  </div>
</form>











      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 


<?php
include 'inc/footer.php';
?>  