<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";
include '../config/function.php';

$title='Report List';
$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Report';
$sub_menu 		= 'report_list';




if(isset($_REQUEST['new']) && $_POST['randcheck']==$_SESSION['rand']){
  $_POST['group_for']=$company_id;  
  $_POST['status']='Active'; 

  @insert('user_activity_management');
  $msg="New data insert successfully";
}


//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>1){	
//  $delid = $_REQUEST['delid'];
//  mysqli_query($conn, "delete from user_activity_management where user_id='".$delid."'");
//  $msg="Delete successfully";
//  redirect('admin_user.php');
//}

if (isset($_REQUEST['delid']) && $_REQUEST['delid'] > 1) {
    $delid = $_REQUEST['delid'];

    // Prepare a SQL statement
    $stmt = $conn->prepare("DELETE FROM user_activity_management WHERE user_id = ?");
    
    // Bind the parameter
    $stmt->bind_param("i", $delid); 
   
    if ($stmt->execute()) {
        $msg = "Delete successfully";
    } else {
        $msg = "Error deleting record: " . $stmt->error;
    }
    
    $stmt->close();
    header('Location: admin_user.php');
    exit();
}


if(isset($_POST['update'])){
  unset($_POST['update']);
  unset($_POST['randcheck']);
  update('user_activity_management','user_id="'.$_GET['edit_id'].'"');
  $msg= "Update successfully";
  redirect('admin_user.php');
}

$ss="select * from user_activity_management where user_id='".$_GET['edit_id']."' ";
$show2 = findall($ss);
?>


<div class="d-flex justify-content-center p-0">
	<form action="master_report.php" method="post" name="form1" target="_blank" id="form1" class="n-form1 fo-width pt-0">
	<h3 align="center" class="n-form-titel1 mb-2">Report List</h3>

        <div class="row m-0 p-0">
            <div class="col-sm-5">
            
                <div class="form-check">
                    <input type="radio" checked="checked" id="optionsRadios1" name="report" value="1">
                    <label class="form-check-label p-0" for="report1">
                        SS User List (1)
                    </label>
                </div>
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report501" value="501" tabindex="1"/>
                    <label class="form-check-label p-0" for="report501">                        	
						Login Report List(501) 
                    </label>
                </div>-->
				
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report502" value="502" tabindex="1"/>
                    <label class="form-check-label p-0" for="report502">                        	
						Login Report Date wise(502)
                    </label>
                </div>-->
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report503" value="503" tabindex="1"/>
                    <label class="form-check-label p-0" for="report503">                        	
						Attendance Report(503)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report210907001" value="210907001" tabindex="1"/>
                    <label class="form-check-label p-0" for="report503">                        	
						Attendance Report New(210907001)
                    </label>
                </div>
				
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report504" value="504" tabindex="1"/>
                    <label class="form-check-label p-0" for="report504">                        	
						Visit Report(504)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report899" value="899" tabindex="1"/>
                    <label class="form-check-label p-0" for="report899">                        	
						Item List Details(899)
                    </label>
                </div>
				
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report900" value="900" tabindex="1"/>
                    <label class="form-check-label p-0" for="report900">                        	
						Item List(900)
                    </label>
                </div>-->
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report904" value="904" tabindex="1"/>
                    <label class="form-check-label p-0" for="report904">                        	
						Shop List(904)
                    </label>
                </div>
				
				
								<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report901" value="901" tabindex="1"/>
                    <label class="form-check-label p-0" for="report901">                        	
						Target Upload Item wise(901)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report902" value="902" tabindex="1"/>
                    <label class="form-check-label p-0" for="report902">                        	
						Target Upload Dealer wise(902)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report903" value="903" tabindex="1"/>
                    <label class="form-check-label p-0" for="report903">                        	
						Upload File(903)
                    </label>
                </div>-->
				
				
				<br>
<div><label>## Sales Report ##</lebel></div>


				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report51" value="51" tabindex="1"/>
                    <label class="form-check-label p-0" for="report51">                        	
						Item Wise Order/Sales (51)
                    </label>
                </div>
				
				
								<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report52" value="52" tabindex="1"/>
                    <label class="form-check-label p-0" for="report52">                        	
						Outlet Wise Order/Sales (52)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report53" value="53" tabindex="1"/>
                    <label class="form-check-label p-0" for="report53">                        	
						NSP Report Chalan wise(53)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report54" value="54" tabindex="1"/>
                    <label class="form-check-label p-0" for="report54">                        	
						NSP Report Outlet wise(54)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report55" value="55" tabindex="1"/>
                    <label class="form-check-label p-0" for="report55">                        	
						NSP Report Details(55)
                    </label>
                </div>
				 
				 
				 <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report101" value="101" tabindex="1"/>
                    <label class="form-check-label p-0" for="report101">                        	
						Item Wise Target/Sales (101)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report102" value="102" tabindex="1"/>
                    <label class="form-check-label p-0" for="report102">                        	
						Dealer Wise Target/Sales (102)
                    </label>
                </div>-->
				
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report103" value="103" tabindex="1"/>
                    <label class="form-check-label p-0" for="report103">                        	
						SO wise Order/Delivery Report (103)
                    </label>
                </div>-->
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report104" value="104" tabindex="1"/>
                    <label class="form-check-label p-0" for="report104">                        	
						Single Dealer Stock Report (104)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report105" value="105" tabindex="1"/>
                    <label class="form-check-label p-0" for="report105">                        	
						Dealer Wise Stock Report (105)
                    </label>
                </div>
				
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report110" value="110" tabindex="1"/>
                    <label class="form-check-label p-0" for="report110">                        	
						Field Officer Contribution File(110)
                    </label>
                </div>-->
				
				<!--<div><label>## Rx Report ##</lebel></div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report125" value="125" tabindex="1"/>
                    <label class="form-check-label p-0" for="report110">                        	
						Rx Visit(125)
                    </label>
                </div> -->             

            </div>

            <div class="col-sm-7">
                


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Company</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
					  <select name="room_id" id="room_id">
					  <option></option>
<? 
$sql="SELECT a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b WHERE b.id=a.room_type_id order by b.room_type";
advance_foreign_relation($sql,$room_id);	  
?>
</select>
                        	
                      </span>

                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Group</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
							<select class="form-control col-md-12" name="product_group" id="product_group">
        <option></option>
<? optionlist('select id,group_name from product_group where 1 order by group_name');?>
    </select>
                        </span>


                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
							<input list="browsers" class="form-control" name="item_id" id="item_id">
  <datalist id="browsers">
	<?php optionlist('select item_id,item_name from item_info where 1 and status=1 order by item_name');?>
  </datalist>
                        </span>


                    </div>
                </div>

                
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Date From: </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
							<input type="date" class="form-control" id="f_date" name="f_date" autocomplete="off" value="<?=date('Y-m-01');?>">
                        </span>


                    </div>
                </div>
	
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Date To : </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
								<input type="date" class="form-control" id="t_date" name="t_date" autocomplete="off" value="<?=date('Y-m-d');?>">
                        </span>


                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Dealer</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <input class="form-control" list="party" name="dealer_code" id="dealer_code" value="" autocomplete="off"/>
          <datalist id="party">
        	<option></option>
        	<?php optionlist('select dealer_code,concat(dealer_code,"-",dealer_name_e) as dealer_name from dealer_info where  1 order by dealer_name_e');?>
          </datalist>   

                        </span>


                    </div>
                </div>  
				
				
				
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Zone </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <select class="form-control col-md-12" name="region_id" id="region" onchange="FetchZone(this.value)">
    <? if($_SESSION['level']==101){ ?>
    <option value="<?=$_SESSION['region_id']?>"><?=find1("select BRANCH_NAME from branch where BRANCH_ID='".$_SESSION['region_id']."'");?></option>
    <? }else{ ?>
    <option value="<?=$show2->region_id?>"><?=find1("select BRANCH_NAME from branch where BRANCH_ID='".$show2->region_id."'");?></option>
    <? optionlist('select BRANCH_ID,BRANCH_NAME from branch where 1 order by BRANCH_NAME');?>   
    <? } ?>
    </select>

                        </span>
                    </div>
                </div> 


<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Division </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <select class="form-control col-md-12" name="zone_id" id="zone" onchange="FetchArea(this.value)">
    <? if($_SESSION['level']==101){ ?>
    <option value="<?=$_SESSION['zone_id']?>"><?=find1("select ZONE_NAME from zon where ZONE_CODE='".$_SESSION['zone_id']."'");?></option>
    <? }else{ ?>
    <option value="<?=$show2->zone_id?>"><?=find1("select ZONE_NAME from zon where ZONE_CODE='".$show2->zone_id."'");?></option>
    <? } ?>
        </select>

                        </span>
                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Territory </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <select class="form-control col-md-12" name="area_id"  id="area" onchange="FetchRoute(this.value)">
    <? if($_SESSION['level']==101){ ?>        
            <option value="<?=$_SESSION['area_id']?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$_SESSION['area_id']."'");?></option>
    <? }else{ ?>
            <option value="<?=$show2->area_id?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$show2->area_id."'");?></option>
    <? } ?>
    </select>

                        </span>
                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Route </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <select class="form-control col-md-12" name="route_id"  id="route">
            <option value="<?=$show2->route_id?>"><?=find1("select route_name from ss_route where route_id='".$show2->route_id."'");?></option>
    </select>

                        </span>
                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Target Year
 </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <select class="form-control col-md-12" name="year" id="year">
      <option></option>
      <option <?=($year=='2022')?'selected':''?>>2022</option>
      <option <?=($year=='2023')?'selected':''?>>2023</option>
      <option <?=($year=='2024')?'selected':''?>>2024</option>
      <option <?=($year=='2025')?'selected':''?>>2025</option>
      </select>

                        </span>
                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Target Month
 </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <select class="form-control col-md-12" name="mon" id="mon">
          <option></option>
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

                        </span>
                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Field Officer
 </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                                    <input list="browsers2" class="form-control" name="so_code" id="so_code">
  <datalist id="browsers2">
	<?php optionlist('select username,concat(username," ",fname) from ss_user where 1 and status=1 order by username');?>
  </datalist>

                        </span>
                    </div>
                </div>



            </div>

        </div>
        <div class="n-form-btn-class">
            <input name="submit" type="submit" class="btn btn-block btn-lg btn-success" value="Report Show" />
        </div>
    </form>
</div>




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
  
    function FetchRoute(id){
    $('#route').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { area_id : id},
      success : function(data){
         $('#route').html(data);
      }

    })
  }
</script>