<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='CUSTOMER TO CUSTOMER COMPARISON ';

do_calander("#f_date");
do_calander("#t_date");


auto_complete_from_db('dealer_info','concat(dealer_code, " - ", dealer_name_e)','dealer_code','1','dealer_search');

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

							  													 <td><input name="report" type="radio" class="radio" value="220305001"  checked="checked"/></td>

																					<td><div align="left">CUSTOMER TO CUSTOMER COMPARISON </div></td>
																			 </tr>
																			 
						 
									


                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                 
				  
				  <tr>

                    <td>Item Mother Group:</td>

                    <td><span class="oe_form_group_cell">

                      <select name="item_mother_group" id="item_mother_group"  onchange="getData2('item_mother_group_ajax.php', 'mother_group', this.value, 
document.getElementById('item_mother_group').value);">

                      <option></option>

                        <? foreign_relation('item_mother_group','id','mother_group_name',$item_mother_group);?>

                      </select>

                    </span></td>

                  </tr>
				  
				  <tr>

                    <td>Item Group: </td>

                    <td>
					<span id="mother_group">
					<select name="item_group" id="item_group"  onchange="getData2('item_sub_group_ajax.php', 'sub_group', this.value, 
document.getElementById('item_group').value);">

                      <option></option>
                      <? foreign_relation('item_group','group_id','group_name',$item_group, 'product_type="Finish Goods"');?>

                    </select>
					</span></td>
                  </tr>
				  
				  
				  
				   <tr>

                    <td>Item Sub Group: </td>

                    <td>
					<span id="sub_group">
					<select name="item_sub_group" id="item_sub_group"  onchange="getData2('item_name_ajax.php', 'item_name', this.value, 
document.getElementById('item_sub_group').value);">

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, "fg_sub_group='Yes'");?>

                    </select></span></td>
                  </tr>
				  
				  
				  <tr>

                    <td>Item Size: </td>

                    <td>
					<span id="item_name">
					<select name="item_id" id="item_id">

                      <option></option>

                      <? foreign_relation('item_info','item_id','item_name',$item_id, "product_nature='Salable'");?>

                    </select></span></td>
                  </tr>
				  
				  <tr>

                    <td>Item Type:</td>

                    <td><select name="item_type" id="item_type"  >

                      <option></option>

                      <? foreign_relation('item_type','id','item_type',$item_type,' 1 order by item_type');?>

                    </select></td>

                  </tr>
				  
				  
				  
				  
				  
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

                    <td>Dealer Search:</td>

                    <td>

                    <input  name="dealer_search" type="text" id="dealer_search" />

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Dealer Code in:</td>

                    <td>

                    
					
					<textarea id="dealer_code_in" name="dealer_code_in"  rows="3"    style="height:60px; width:300px;  background:#FFFFFF; color: #000000;"></textarea>	

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