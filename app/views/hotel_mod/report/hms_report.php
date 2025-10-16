<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";;
$title='Hotel Information Reports';

do_calander("#f_date");
do_calander("#t_date");
?>
<script type="text/javascript">
function getflatData()
{
	var b=1;
	var a=document.getElementById('proj_code').value;
			$.ajax({
		  url: '../../common/flat_option_report.php',
		  data: "a="+a+"&b="+b,
		  success: function(data) {						
				$('#fid').html(data);	
			 }
		});
}
</script>

<div class="d-flex justify-content-center">
    <form class="n-form1 fo-width pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1" value="1" checked="checked" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1">
                        Daily Sales Summary (1)
                    </label>
                </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report2" value="2" tabindex="1"/>
                    <label class="form-check-label p-0" for="report2">
                        	
							Daily Cash Report (2)

                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report25" value="25" tabindex="1"/>
                    <label class="form-check-label p-0" for="report25">
                        	
							Daily Payment Receive Report (25)

                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report26" value="26" tabindex="1"/>
                    <label class="form-check-label p-0" for="report26">
                        	
							In House Guest Ledger (26)
                    </label>
                </div>
				 
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report3" value="3"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report3">
                        Pending Billing Report (3)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report21" value="21"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report21">
                        Reservation Status Report (Date Wise) (21)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report22" value="22"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report22">
                        Expected Arrival Status Report (Date Wise) (22)

                    </label>
                </div>
				
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report5-btn" value="23"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report5-btn">
                       Check In Status Report (Date Wise) (23)

                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report24" value="24"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report24">
                        Check Out Status Report (Date Wise) (24)


                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report32" value="32"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report32">
                        Check Out Base Sales Report (32)


                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report4" value="4"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report4">
                        Present Room Status Report (4)

                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report5" value="5"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report5">
                        Present Occupancy Report (5)

                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report6" value="6"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report6">
                        Present Room Ready Report (6)

                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report7" value="7"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report7">
                        Present Room Out of Order Report (7)


                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report8" value="8"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report8">
                        Present Floor Wise Occupancy Report (8)


                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report9" value="9"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report9">
                        Daily Guest List (9)


                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report10" value="10"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report10">
                        Privious Service Bill (10)


                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report11" value="11"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report11">
                       Privious Rent Bill (11)


                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report12" value="12"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report12">
                        Reservation Wise Bill (12)


                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report27" value="27"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report27">
                       Payment Receivable Report (27)


                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report28" value="28"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report28">
                    Payment Receivable Report (Received) (28)

                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report30" value="30"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report30">
                        Master Sales Report (30)


                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report31" value="31"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report31">
                        Daily Sales Report (31)

                    </label>
                </div>
				
               

            </div>

            <div class="col-sm-7">
                


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Room No :</label>
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
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Service Group :	</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
							<select name="service_id" id="service_id">
					  <option></option>
				<? foreign_relation('hms_service_group','id','service_group',$data->service_id);?>
			</select>
                        </span>


                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Date or From : </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
							<input  name="f_date" type="text" id="f_date" value=""/>
                        </span>


                    </div>
                </div>

                
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Date To: </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
							<input  name="t_date" type="text" id="t_date" value=""/>
                        </span>


                    </div>
                </div>
	
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Service Bill No : </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
								<input  name="service_bill_no" type="text" id="service_bill_no" value=""/>
                        </span>


                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Rent Bill No :</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <input  name="rent_bill_no" type="text" id="rent_bill_no" value=""/>

                        </span>


                    </div>
                </div>  
				
				
				
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Reserve ID : </label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <input  name="reserve_id" type="text" id="reserve_id" value=""/>

                        </span>


                    </div>
                </div> 




            </div>

        </div>
        <div class="n-form-btn-class">
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" />
        </div>
    </form>
</div>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>