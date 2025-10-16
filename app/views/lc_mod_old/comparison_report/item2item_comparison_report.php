<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Zone to Zone Sales Comparison Reports';

do_calander("#f_date");
do_calander("#t_date");

auto_complete_from_db('item_info','concat(item_name)','item_id','product_nature="Salable"','item_search');


?>



<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>


      <td><div class="box4" style="width:950px;">

          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

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

							  													 <td><input name="report" type="radio" class="radio" value="211100703"  checked="checked"/></td>

																					<td><div align="left">ITEM TO ITEM COMPARISON (PRODUCT QUANTITY)</div></td>
																			 </tr>
																			 
						 
									


                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                 
				  
		
				  
				  
				  <tr>

                    <td>Sales Type:</td>

                    <td><select name="do_type" id="do_type"  >

                      <option></option>

                      <? foreign_relation('sale_type','sale_type','sale_type',$do_type,' 1 order by id');?>

                    </select></td>

                  </tr>
				  

                  <tr>

                    <td>From: </td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>

                  </tr>

                  <tr>

                    <td>To: </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>

                  </tr>

				  <tr>

                    <td>Item Search:</td>

                    <td>

                    <input  name="item_search" type="text" id="item_search" />

                    </td>

                  </tr>
				  
				  
				  
				  <tr>

                    <td>Item ID:</td>

                    <td>

                  
					
					<textarea id="item_id_in" name="item_id_in"  rows="3"    style="height:50px; width:200px; background:#FFFFFF; color: #000000;"></textarea>	

                    </td>

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

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>