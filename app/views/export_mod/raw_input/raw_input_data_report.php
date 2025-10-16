<?php


//


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Raw Input Data Report';





do_calander("#f_date");


do_calander("#t_date");


auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');


?>

<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="box4">
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
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="1" tabindex="1"/></td>
                                <td><div align="left">Finish Good Product List</div></td>
                              </tr>-->
							  
							  
							<!--  <tr>
                                <td><input name="report" type="radio" class="radio" value="888" tabindex="2"/></td>
                                <td><div align="left">Product Information (Rate Changable)</div></td>
                              </tr>-->
							  
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="13022021" checked="checked" tabindex="2"/></td>
                                <td><div align="left">Raw Input Data Report</div></td>
                              </tr>
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="118888"  tabindex="2"/></td>
                                <td><div align="left">Product Information (MINWAL)</div></td>
                              </tr>-->
							  
							  
							 <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="888811" tabindex="2"/></td>
                                <td><div align="left">Turky Sajjada & Swadie Item</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="888822" tabindex="2"/></td>
                                <td><div align="left">Zadi Item Information</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="888833" tabindex="2"/></td>
                                <td><div align="left">Minwal Carpet Item List</div></td>
                              </tr>-->
							  
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="888898" tabindex="2"/></td>
                                <td><div align="left">Warehouse Report</div></td>
                              </tr>-->
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="8889" tabindex="2"/></td>
                                <td><div align="left">Product Rate Change Information</div></td>
                              </tr>-->
							  
							  
							  
							 <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="8890" tabindex="2"/></td>
                                <td><div align="left">Area and Transport Changes Information</div></td>
                              </tr>-->
							  
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="889" tabindex="2"/></td>
                                <td><div align="left">Product Mesh Size Information </div></td>
                              </tr>-->
							  
		              
							  
							  <!--<tr>


                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>


                                <td width="94%"><div align="left">Product List Details</div></td>


                              </tr>


                              <tr>


                                <td width="6%"><input name="report" type="radio" class="radio" value="3" /></td>


                                <td width="94%"><div align="left">Price List Details</div></td>


                              </tr>-->
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  
           
				  
				  <tr>
                    <td>From :</td>
                    <td><span class="oe_form_group_cell">
                      <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" style="width:250px"/>
                      </span></td>
                  </tr>
				  
				  <tr>
                    <td>To :</td>
                    <td><span class="oe_form_group_cell">
                      <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" style="width:250px"/>
                      </span></td>
                  </tr>
				  
				  
				  
				   
				  
				  
				  
				  <tr>

                    <td>Customer Name:</td>

                    <td>

                      <select name="dealer_code" id="dealer_code"  style="width:250px" required  onchange="getData2('buyer_ajax.php', 'buyer_filter', this.value, 

document.getElementById('dealer_code').value);">

                        <option></option>

                         <?
		
		foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 order by dealer_code');

		?>

                      </select>

                     </td>

                  </tr>
				  
				  
				  
				   <tr>

                    <td>Buyer Name:</td>

                    <td>
					
					<span id="buyer_filter">

                      <select name="buyer_code" id="buyer_code"  style="width:250px"  onchange="getData2('merchandizer_ajax.php', 'merchandizer_filter', this.value, 

document.getElementById('buyer_code').value);"  >

                        <option></option>

               <?
		
		foreign_relation('buyer_info','buyer_code','buyer_name',$_POST['buyer_code'],'1 order by buyer_code');

		?>

                      </select>
					  
					  </span>

                      </td>

                  </tr>
				  
				  
				  
				     <tr>

                    <td>Merchandiser:</td>

                    <td>
					
					<span id="merchandizer_filter">

                      <select name="merchandizer_code" id="merchandizer_code"  style="width:250px" tabindex="3" >

                        <option></option>

              <?
		
		foreign_relation('merchandizer_info','merchandizer_code','merchandizer_name',$_POST['merchandizer_code'],'1 order by merchandizer_code');

		?>
                      </select>
					  </span>

                     </td>

                  </tr>
				  
  
				 
				  
				  
				  <tr>

                    <td>Product Category:</td>

                    <td><span class="oe_form_group_cell">
					
					

                      <select name="item_sub_group" id="item_sub_group" style="width:250px"  onchange="getData2('item_ajax.php', 'item_filter', this.value, 

document.getElementById('item_sub_group').value);">

                        <option></option>

                        <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, '1');?>

                      </select>

                      </span></td>

                  </tr>
				  
				  
				   <tr>

                    <td>Item Name:</td>

                    <td><span class="oe_form_group_cell">
					
					<span id="item_filter">

                      <select name="item_id" id="item_id" tabindex="4"  style="width:250px">

                        <option></option>

                        <? foreign_relation('item_info','item_id','item_name',$item_id, '1');?>

                      </select>

                      </span></span></td>

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
              <td><input name="submit" type="submit" class="btn" value="Report" tabindex="6" /></td>
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
