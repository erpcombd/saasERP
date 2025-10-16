<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Reports';

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
                                <td colspan="2" class="title1"><div align="left">Progress Report </div></td>
                              </tr>
                              <!--
                              <tr>
                                <td><input checked name="report" type="radio" class="radio" value="44" /></td>
                                <td><div align="left">Daily Progress Report</div></td>
                              </tr>

								-->
							  
							  <tr>
                                <td><input checked name="report" type="radio" class="radio" value="4444" /></td>
                                <td><div align="left">Daily Progress Report</div></td>
                              </tr>
							  
							  <!--<tr>
                                <td><input  name="report" type="radio" class="radio" value="54" /></td>
                                <td><div align="left">Production & Operation Target Report</div></td>
                              </tr>-->
						  
	
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  

				<!-- <tr>

                    <td>Sales person :</td>
                    <td>
                    <input name="PBI_NAME" list="con1" id="PBI_NAME" value="<?=$PBI_NAME?>" class="form-control" >
	<datalist id=con1>
		  <option></option>
		 <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME','','1 order by PBI_NAME');?>
		</datalist>
					</td>
                  </tr>-->
				  

                  <tr>
                    <td>From : </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-d')?>" class="form-control" /></td>
                  </tr>

                  <tr>
                    <td>To : </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" class="form-control" /></td>
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
              <td><input type="submit" value="Report" /></td>
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