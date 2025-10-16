<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
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
						Daily Guest List (25)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report26" value="26" tabindex="1"/>
                    <label class="form-check-label p-0" for="report26">                        	
						Payment Receivable Report (Received) (26)
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
				<? foreign_relation('hms_service_group','id','service_group',$_SESSION['user']['id'],'id="'.$_SESSION['user']['id'].'"');?>
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
                            <input  name="rent_bill_no" type="text" id="rent_bill_no" value=""/>

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