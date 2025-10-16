<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Entitlement Report';



do_calander("#f_date");

do_calander("#t_date");

auto_complete_from_db('item_info','item_name','item_id','1','item_id');

auto_complete_from_db('tea_garden','garden_name','garden_id','1','garden_id');

?>



<form action="stock_master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

      <td><div class="box4" style="width:900px;">

          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                              <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>

                            
							  
							  
							  <tr>

							    <td width="10%"><input name="report" type="radio" class="radio" value="220525001" checked="checked"  /></td>

							    <td width="90%"><div align="left">Entitlement Report</div></td>
						      </tr>
							  
							  
						

                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                  <tr>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>
                  </tr>

				  
				  <tr>

                    <td>Product Group:</td>

                    <td><span class="oe_form_group_cell">

                      <select name="group_id" id="group_id"  tabindex="3" onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value, 

document.getElementById('group_id').value);">

                        <option></option>

                        <? foreign_relation('item_group','group_id','group_name',$group_id,'1');?>

                      </select>

                      </span></td>

                  </tr>
				  
				  
				  
				  

                  <tr>

                    <td>Product Sub Group:</td>

                    <td><span class="oe_form_group_cell">
					
					<span id="item_sub_group">

                      <select name="sub_group_id" id="sub_group_id" tabindex="4"  >

                        <option></option>

                        <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$sub_group_id, '1');?>

                      </select>

                      </span></span></td>

                  </tr>
				  
				  
				 
				  
				  
			

                  <tr>

                    <td>From:</td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-01-01');?>"/></td>
                  </tr>

                  <tr>

                    <td>To:</td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-12-31');?>"/></td>
                  </tr>

				 
				  
				  
				  
				  <!--<tr>

                    <td>Company: </td>

                    <td><select name="group_for" id="group_for" >
					
					<option></option>

                      

					  <? foreign_relation('user_group','id','group_name',$group_for,'1 ');?>

                    </select></td>
                  </tr>-->
				  
				  

               
				  

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

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>