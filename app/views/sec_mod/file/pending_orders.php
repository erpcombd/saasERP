<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

include '../config/function.php';

$title='Tracking Report';	
$google_api = find1("select map_api from ss_config where id=1");



$today 			= date('Y-m-d');

$company_id   	= $_SESSION['company_id'];

$menu 			= 'Product';

$sub_menu 		= 'item_info';




function getAddress($latitude, $longitude)
{
        //google map api url
       $url = "https://maps.google.com/maps/api/geocode/json?key=<?=$google_api?>&latlng=$latitude,$longitude";

        // send http request
        $geocode = file_get_contents($url);
        $json = json_decode($geocode);
        $address = $json->results[0]->formatted_address;
        return $address;
}




//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>1){	
//
//  $delid = $_REQUEST['delid'];
//
//  mysqli_query($conn, "delete from item_info where item_id='".$delid."'");
//
//  $msg="Delete successfully";
//
//  redirect('item_info.php');
//
//}

if (isset($_REQUEST['delid']) && $_REQUEST['delid'] > 1) {
    $delid = $_REQUEST['delid'];
    $stmt = $conn->prepare("DELETE FROM item_info WHERE item_id = ?");
  
    $stmt->bind_param("i", $delid); 
    
    if ($stmt->execute()) {
        $msg = "Delete successfully";
    } else {
        $msg = "Error deleting record: " . $stmt->error;
    }
    
    $stmt->close();

    header('Location: item_info.php');
    exit();
}






?>

    <div class="container-fluid">      
          <div class="form-container_large">
            <form action="" method="post">
			<h4 align="center" class="n-form-titel1 mb-0"> <?=$title?></h4>
              <div class="container-fluid bg-form-titel">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group row m-0 pl-3 pr-3 p-1">
                      <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label">FO Name: </label>
                      <div class="col-sm-9 p-0">
                        <select class=" form-control border border-info" name="user_id" required id="user_id" onchange="FetchItemCategory(this.value)">
                          <? if($_POST['user_id']>0){ ?>
                          <option value="<?php echo $_POST['username']?>">
                          <?=find1("select concat(username,' ',fname) name from ss_user where user_id='".$_POST['user_id']."'");?>
                          </option>
                          <? }else{ ?>
                          <option></option>
                          <? } ?>
                          <?php optionlist("select username,concat(username,' ',fname) name from ss_user where 1 order by user_id"); ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group row m-0 pl-3 pr-3 p-1">
                      <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label">From: </label>
                      <div class="col-sm-9 p-0">
                        <input type="date" name="fdate" id="fdate" value="<?=$_POST['fdate']?$_POST['fdate']:date('Y-m-01');?>" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group row m-0 pl-3 pr-3 p-1">
                      <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label">To: </label>
                      <div class="col-sm-9 p-0">
                        <input type="date" name="tdate" id="tdate" value="<?=$_POST['tdate']?$_POST['tdate']:date('Y-m-d');?>"  class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group row m-0 pl-3 pr-3 p-1">
                      <div class="col-sm-9 p-0">
                        <input name="view" type="submit" id="view" value="Search" class="btn1 btn1-bg-submit"/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <?php

$condition='';
$condition1='';


if(isset($_POST['view'])){

    
if($_POST['user_id']!=''){ 

  $sql = "select m.do_no,s.*,sum(d.total_amt) as total_amt,m.do_date 
  from ss_shop s,ss_do_master m,ss_do_details d 
  where s.dealer_code=m.dealer_code and m.do_no=d.do_no and m.status='CHECKED'
  and m.entry_by='".$_POST['user_id']."'
  and m.do_date between '".$_POST['fdate']."' and '".$_POST['tdate']."'
  group by m.do_no order by m.do_no desc";

}



if($_POST['fdate']!='' && $_POST['tdate']!=''){ 

    $date_con =" and date between '".$_POST['fdate']."' and '".$_POST['tdate']."' ";

}


//  $sql="select p.* from user_location_tracking p where 1 ".$user_id.$date_con;

}else{
  $sql = "select m.do_no,s.*,sum(d.total_amt) as total_amt,m.do_date 
from ss_shop s,ss_do_master m,ss_do_details d 
where s.dealer_code=m.dealer_code and m.do_no=d.do_no and m.status='CHECKED'
group by m.do_no order by m.do_no desc";
}

if($_POST['fdate']!='' && $_POST['tdate']!=''){ 
?>
                  <p style="text-align: center; font-size: 16px; font-weight: bold;">Date Interval
                    <?=$_POST['fdate']?>
                    To
                    <?=$_POST['tdate']?>
                  </p>
                  <?
}

?>
                  <div class="container-fluid pt-5 p-0 ">
                    <table class="table1 table-striped table-bordered table-hover table-sm">
                      <thead class="thead1">
                        <tr class="bgc-info">
                          <th>Order NO</th>
                          <th>SHOP Name</th>
                          <th>Order Date</th>
                          <th>Total Amount</th>
                         <!-- <th>See Details</th>-->
                        </tr>
                      </thead>
                      <tbody class="tbody1" id="ress">
                        <?php 

			$i=1;

            $res=mysqli_query($conn,$sql);

			while($row=mysqli_fetch_assoc($res)){

			   
			?>
                        <tr>
                          <td><?php echo $row['do_no']." - ";   ?></td>
                          <td><?php echo $row['shop_name']?></td>
                          <td><?php echo $row['do_date']?></td>
                          <td><?php echo $row['total_amt']?></td>
<!--                          <td><a href="/app/views/sec_mod/file/ss_do_chalan.php?do=<?php echo $row['do_no']?>" class="btn btn-success btn-xs" target="_blank">View</a></td>-->
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
  

<?php

require_once SERVER_CORE."routing/layout.bottom.php";
?>
<script type="text/javascript">

  function FetchItemCategory(id){

    $('#category_id').html('');

    $('#subcategory_id').html('');

    $.ajax({

      type:'post',

      url: 'get_data.php',

      data : { item_group : id},

      success : function(data){

         $('#category_id').html(data);

      }



    })

  }



  function FetchItemSubcategory(id){

    $('#subcategory_id').html('');

    $.ajax({

      type:'post',

      url: 'get_data.php',

      data : { category_id : id},

      success : function(data){

         $('#subcategory_id').html(data);

      }



    })

  }



</script>
