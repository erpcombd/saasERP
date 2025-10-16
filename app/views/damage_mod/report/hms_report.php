<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Hotel Information Reports';

do_calander("#f_date");
do_calander("#t_date");
?>

<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="box4">
          <table width="84%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="1" /></td>
                                <td width="94%"><div align="left">Daily Sales Summary</div></td>
                              </tr>
                              
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="2" /></td>
                                <td><div align="left">Daily Cash Report</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="25" /></td>
                                <td><div align="left">Daily Payment Receive Report</div></td>
                              </tr>
							  
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="26" /></td>
                                <td><div align="left">In House Guest Ledger</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                                <td><div align="left">Pending Billing Report </div></td>
                              </tr>
							  
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="21" /></td>
                                <td><div align="left">Reservation Status Report (Date Wise)</div></td>
                              </tr>
							  
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="22" /></td>
                                <td><div align="left">Expected Arrival Status Report (Date Wise)</div></td>
                              </tr>
							  
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="23" /></td>
                                <td><div align="left">Check In Status Report (Date Wise)</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="24" /></td>
                                <td><div align="left">Check Out Status Report (Date Wise)</div></td>
                              </tr>
							  
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="4" /></td>
                                <td><div align="left">Present Room Status Report</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="5" /></td>
                                <td><div align="left">Present Occupancy Report</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="6" /></td>
                                <td><div align="left">Present Room Ready Report</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="7" /></td>
                                <td><div align="left">Present Room Out of Order Report</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="8" /></td>
							    <td><div align="left">Present Floor Wise Occupancy Report</div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="9" /></td>
							    <td><div align="left">Daily Guest List </div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="10" /></td>
							    <td><div align="left">Privious Service Bill </div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="11" /></td>
							    <td><div align="left">Privious Rent Bill </div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="12" /></td>
							    <td><div align="left">Reservation Wise Bill </div></td>
						      </tr>
<tr>
                                <td><input name="report" type="radio" class="radio" value="27" /></td>
							    <td><div align="left">Payment Receivable Report</div></td>
						      </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="28" /></td>
							    <td><div align="left">Payment Receivable Report (Received)</div></td>
						      </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><div class="box3">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Room No   :</td>
                      <td><select name="room_id" id="room_id">
					  <option></option>
<? 
$sql="SELECT a.id,concat(a.room_no,' : ',b.room_type) FROM `hms_hotel_room` a,`hms_room_type` b WHERE b.id=a.room_type_id order by b.room_type";
advance_foreign_relation($sql,$room_id);	  
?>
</select></td>
                    </tr>
                    <tr>
                      <td>Service Group : </td>
                      <td><select name="service_id" id="service_id">
					  <option></option>
				<? foreign_relation('hms_service_group','id','service_group',$data->service_id);?>
			</select></td>
                    </tr>
                    <tr>
                      <td>Date or From : </td>
                      <td><input  name="f_date" type="text" id="f_date" value=""/></td>
                    </tr>
                    <tr>
                      <td>To : </td>
                      <td><input  name="t_date" type="text" id="t_date" value=""/></td>
                    </tr>
					<tr>
                      <td>Service Bill No : </td>
                      <td><input  name="service_bill_no" type="text" id="service_bill_no" value=""/></td>
                    </tr>
					
					<tr>
                      <td>Rent Bill No : </td>
                      <td><input  name="rent_bill_no" type="text" id="rent_bill_no" value=""/></td>
                    </tr>
					
					<tr>
                      <td>Reserve ID  : </td>
                      <td><input  name="reserve_id" type="text" id="reserve_id" value=""/></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
              </div></td>
            </tr>
          </table>
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div class="box">
        <table width="1%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td><input name="submit" type="submit" class="btn" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
</form>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>