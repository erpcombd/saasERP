<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";

$title='Vehicle Management Reports';


do_calander('#f_date');
do_calander('#t_date');



do_calander("#cut_date");
auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');
auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<6000','item_id');?>

<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="box4">
          <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="2" class="title1"><div align="left">Select Report -<?=$_SESSION['ip'];?>-<?=$_SESSION['php_ip']?></div></td>
                              </tr>
							   <tr>
                                <td><input name="report" type="radio" class="radio" value="1" /></td>
                                <td><div align="left">Driver Attendence</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="6" /></td>
                                <td><div align="left">Vehicle Log Book</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="2" /></td>
                                <td><div align="left">Fuel Expense Report</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="44" /></td>
                                <td><div align="left">Tools Maintenance Report</div></td>
                              </tr>
							   <tr>
                                <td><input name="report" type="radio" class="radio" value="7" /></td>
                                <td><div align="left">Fuel Cost Calculation Sheet</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                                <td><div align="left">Office Expense Report</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="4" /></td>
                                <td><div align="left">Vehicle List</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="5" /></td>
                                <td><div align="left">Documents/Equipments Info</div></td>
                              </tr>
							  
							 
<tr>
							  
							  
                          </table></td>
                        </tr>
                    </table>
					</td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  
                  
                  
                  <tr>
                    <td>From : </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>
                  </tr>
                  <tr>
                    <td>To : </td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>
                  </tr>
				  <tr>
                    <td>Vehicle : </td>
                    <td><select  class="form-control border border-info" name="vehicle" id="vehicle">
			<option></option>
			<? foreign_relation('vehicle_info','vehicle_id','vehicle_name',$_POST['vehicle'],'1')?>
			</select></td>
                  </tr>
				  <tr>
                    <td>Driver/User : </td>
                    <td><select  class="form-control border border-info" name="user_id" id="user_id">
			<option></option>
			<? foreign_relation('user_activity_management','user_id','fname',$_POST['user_id'],'1')?>
			</select></td>
                  </tr>
				  
					
              </table></td>
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
require_once SERVER_CORE."routing/layout.bottom.php";
?>