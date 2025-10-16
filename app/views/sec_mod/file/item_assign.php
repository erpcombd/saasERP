<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";
include '../config/function.php';

$title='Visit Schedule';	
$today 			    = date('Y-m-d');
$company_id         = $_SESSION['company_id'];
$entry_by           = $_SESSION['username'];
$menu 			    = 'Visit';
$sub_menu 		    = 'visit_plan';


if(isset($_POST['confimr_schedule'])){		



for($i=0;$i<count($_POST['dates']);$i++){

$user_id = find_a_field('ss_user','user_id','username="'.$_POST['PBI_ID'][$i].'"');

$delete = 'delete from ss_schedule where user_id="'.$user_id.'" and date="'.$_POST['dates'][$i].'" ';
mysqli_query($conn,$delete);


$insert = 'insert into ss_schedule set 
    user_id="'.$user_id.'", 
    date="'.$_POST['dates'][$i].'", 
    dealer_code="'.$rr->dealer_code.'",
    route_id="'.$_POST['route'][$i].'",
    PBI_ID="'.$_POST['PBI_ID'][$i].'",
    entry_by="'.$entry_by.'"
';

mysqli_query($conn,$insert);


}


}





//for Delete..................................

if(isset($_POST['delete'])){		
    
    $condition=$unique."=".$$unique;		
		$crud->delete($condition);
		unset($$unique);
		$type=1;
		$msg='Successfully Deleted.';
}

?>

<!--start -->

<div class="container n-form1">
    <form class="n-form" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-5">
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label">Zone: </label>
                    <div class="col-sm-9 p-0">
                        <select class="form-control col-md-12" name="zone_id" required id="zone" onchange="FetchArea(this.value)">
        
<? if($_SESSION['level']==103){ ?>
        <option value="<?=$_SESSION['zone_id']?>"><?=find1("select ZONE_NAME from zon where ZONE_CODE='".$_SESSION['zone_id']."'");?></option>
<? }else{ ?>
<option value="<?=$_POST['zone_id']?>"><?=find1("select ZONE_NAME from zon where ZONE_CODE='".$_POST['zone_id']."'");?></option>
        <? optionlist("select ZONE_CODE,ZONE_NAME from zon where 1 order by region_id,ZONE_NAME");?>
<? } ?>
    </select>
                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label">Area: </label>
                    <div class="col-sm-9 p-0">
                        <select class="form-control col-md-12" name="area_id" required id="area">
<? if($_SESSION['level']==103){ ?> 
    <option value="<?=$_SESSION['area_id']?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$_SESSION['area_id']."'");?></option>
<? }else{ ?>
        <option value="<?=$_POST['area_id']?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$_POST['area_id']."'");?></option>
        <option value="<?=$show2->area_id?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$show2->area_id."'");?></option>
<? } ?>
    </select>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-5">
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label">From: </label>
                    <div class="col-sm-9 p-0">
                        <input class="form-control" name="from_date" type="date" value="<?=$_POST['from_date']?$_POST['from_date']:date('Y-m-d');?>" required/>
                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">To: </label>
                    <div class="col-sm-9 p-0">
                        <input class="form-control" name="to_date" type="date" value="<?=$_POST['to_date']?$_POST['to_date']:date('Y-m-d');?>" required/>
                    </div>
                </div>
            </div>
        

        <div class="col-md-2 d-flex align-items-center justify-content-center">
            <input name="insert" type="submit" id="insert" value="Search" class="btn1 btn1-bg-submit"/>
        </div>    
</div>
</form>
</div>

<? if(isset($_POST['search'])){ 

$start    = new DateTime($_POST['from_date']);
$end      = (new DateTime($_POST['to_date']))->modify('+1 day');
$interval = new DateInterval('P1D');
$period   = new DatePeriod($start, $interval, $end);


?>
<br><p>
<form action="" method="post">
  <table class="table" width="100%" border="1" cellspacing="0">
    <thead>
      <tr>
        <th style="text-align: center;">SO ID</th>
        <th  style="text-align: center;">SO Name</th>
      </tr>

    </thead>
    <tbody>

    

<?
$select = 'select * from ss_user where status="Active" and zone_id="'.$_POST['zone_id'].'" and area_id="'.$_POST['area_id'].'"
';
$query = mysqli_query($conn,$select);
while($row = mysqli_fetch_object($query)){

?>
    <tr>
        <td style="text-align: center;"><?=$row->username?></td>
        <td style="text-align: center;"><?=$row->fname?>
      </td>
      </tr>
      <tr>
        <th style="text-align: center;">Item Name </th>
        <th  style="text-align: center;">Quantity</th>
      </tr>
        <?
        $sql_item='SELECT * FROM item_info';
        $sql_item_query= mysqli_query($conn,$sql_item);
        while($item_info = mysqli_fetch_object($sql_item_query)){
        ?>
        <tr>
        <td colspan="2">
       <input type="hidden" name="dates[]" value="<?=date('Y-m-d')?>">
       <input type="hidden" name="item_id" value="<?=$row->username?>">
       <input type="text" name="item_name" readonly value="<?=$item_info->item_name?>">
     
      </td>
      <td>
        <input type="number" name="item_quantity" id="item_quantity" value="">
      </td>
      </tr>
        <?  }} ?>
      


    </tbody>
</table>

<div class="row">
<div class="col-md-12">
  <input type="submit" value="Confirm Schedule" name="confimr_schedule" class="btn btn-primary" >
</div>
</div>
  
</form>
<? } ?>




<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>  

<script type="text/javascript">
  function FetchZone(id){
    $('#zone').html('');
    $('#area').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { region_id : id},
      success : function(data){
         $('#zone').html(data);
      }

    })
  }

  function FetchArea(id){ 
    $('#area').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { zone_id : id},
      success : function(data){
         $('#area').html(data);
      }

    })
  }
</script>