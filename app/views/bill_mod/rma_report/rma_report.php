<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='RMA Report';

do_calander("#f_date");
do_calander("#t_date");
do_calander("#cut_date");
//auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','canceled="Yes" order by dealer_code','dealer_code');
//auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');

auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and finish_goods_code>0','item_id');
?>
<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="box4">
          <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
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
                                <td><input name="report" type="radio" class="radio" value="1" /></td>
                                <td><div align="left">RMA Details Report</div></td>
                              </tr>
                          </table></td>







                        </tr>







                    </table></td>







                  </tr>







              </table></td>







              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">


                  <tr>
                    <td>Product Name : </td>
                    <td><input type="text" name="item_id" id="item_id" class="form-control" style="margin-left:4px" /></td>
                  </tr>
				  
				  
                  <tr>
                    <td>From : </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" class="form-control"/></td>
                  </tr>

                  <tr>
                    <td>To : </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" class="form-control"/></td>
                  </tr>


				  <tr>

                    <td>Customer Name :</td>
                    <td>
                    <input type="text" list="dealer" name="dealer_code" id="dealer_code" />
					<datalist id="dealer">
					 <? foreign_relation('dealer_info','concat(dealer_name_e,"#",dealer_code)','""',$_POST['dealer_code']);?>
					</datalist>					</td>
                  </tr>

				  <!--<tr>
				    <td>RMA Status :</td>
				    <td><select name="status" id="status" style="margin-left:4px" class="form-control">
					    <option value="ALL">All</option>
                        <option value="PROCESSING">PROCESSING</option>
                        <option value="CHECKED">CHECKED</option>
					    <option value="COMPLETED">COMPLETED</option>
						  <option value="CANCELED">CANCELED</option>
			        </select></td>
			      </tr>-->
				  
				   <tr>

    <td><strong>Serial No: </strong></td>

    <td><strong>

<input type="text" name="serial_no" id="serial_no" style="width:200px;" value="<?=$_POST['serial_no']?>">
    </strong></td>

    </tr>
	
	<tr>

    <td><strong>Complain No: </strong></td>

    <td><strong>

<input type="text" name="service_no" id="service_no" style="width:200px;" value="<?=$_POST['service_no']?>">
    </strong></td>

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
$main_content=ob_get_contents();

ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>