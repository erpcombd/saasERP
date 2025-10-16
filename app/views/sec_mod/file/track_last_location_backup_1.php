<?php
session_start ();
include ("config/access_admin.php");
include ("config/db.php");
include 'config/function.php';


$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Tracking';
$sub_menu 		= 'track_last_location';
$google_api = find1("select map_api from ss_config where id=1");





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
            <h1 class="m-0">Last Position</h1>
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



<form  method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>
<td style="width: 100px;">Date : </td>
<td><input class="form-control" name="visit_date" type="date" value="<?=$_POST['visit_date']?$_POST['visit_date']:date('Y-m-d');?>" required/></td>

<td>Zone : </td> 
<td>
<select class="form-control" name="zon_id" required>
  <option value=""></option>
  <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$_POST['zon_id'],'1'); ?>
</select>  
</td>

<td>&nbsp;&nbsp;</td>
<td><input name="search" type="submit" id="search" value="Search" class="btn btn-warning" /></td>

</tr> 
</table>
</form>








<? if(isset($_POST['search'])){ 
  
  $sql = 'SELECT ss_user.fname, ss_user.mobile, ss_user.address, ss_location_log.latitude, ss_location_log.longitude, MAX(ss_location_log.access_time) AS last_access_time
  FROM ss_location_log
  INNER JOIN ss_user ON ss_location_log.user_id = ss_user.username
  WHERE ss_location_log.access_date="'.$_POST['visit_date'].'"
  GROUP BY ss_user.fname, ss_user.mobile, ss_user.address, ss_location_log.latitude, ss_location_log.longitude';

$query = mysqli_query($conn, $sql);
?>

  <?php
  while ($row = mysqli_fetch_assoc($query)) {
      ?>
      <tr style="background: #EEEEEE;">
          <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;"><?= $row['fname'] ?></td>
          <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;"><?= $row['mobile'] ?></td>
          <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;"><?= $row['address'] ?></td>
          <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;"><?= $row['latitude'] ?></td>
          <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;"><?= $row['longitude'] ?></td>
          <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;"><?= $row['last_access_time'] ?></td>
          <td style="padding: 12px; text-align: center; border: 1px solid #EEEEEE;"><button>Show On Map</button></td>
      </tr>
  <?php } ?>
  </tbody>
</table>
</div>

<? } ?>
















      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 


<?php
include 'inc/footer.php';
?>  