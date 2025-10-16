<?php
require_once "../../../assets/template/layout.top.php";
$title='Local Sales Report';

do_calander("#f_date");
do_calander("#t_date");
do_calander("#cut_date");
create_combobox('dealer_code');
//auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','canceled="Yes" order by dealer_code','dealer_code');
//auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');

auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and finish_goods_code>0','item_id');
?>


<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="ls_master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1" checked="checked" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                        Local Sales Report
                    </label>
                </div>
               

            </div>

            <div class="col-sm-7">
                

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product name:</label>
                    <div class="col-sm-8 p-0">
                        <select name="item_id" id="item_id" class="form-control">
                        	<option></option>
                      
							<? foreign_relation('item_info','item_id','item_name',$item_id);?>
                   		 </select>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From:</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        	<input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" required autocomplete="off" / class="form-control">
                      </span>

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required autocomplete="off" / class="form-control">

                        </span>


                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Depot:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <select name="warehouse_id" id="warehouse_id" class="form-control" >
                    			<option></option>
                       			 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'1');?>
                     		 </select>

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







<!--<form action="ls_master_report.php" method="post" name="form1" target="_blank" id="form1">

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
                                <td><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>
                                <td><div align="left">Local Sales Report</div></td>
                              </tr>-->
                              

<!--
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td width="94%"><div align="left">Delivered Do Details Report</div></td>
                              </tr>

  <tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                          <td><div align="left">Delivered Do Report Dealer Wise</div></td>
                          </tr>
         <tr>
                <td><input name="report" type="radio" class="radio" value="4" /></td>
                <td><div align="left">Chalan Report(Chalan Date Wise)</div></td>
                   </tr>

           <tr>-->
                <!--<tr>

                           <td><input name="report" type="radio" class="radio" value="2001" /></td>
                           <td><div align="left">Aksid Staff Commission Report</div></td>
                            
               </tr>-->
              <!-- <tr>
                           <td><input name="report" type="radio" class="radio" value="200222" /></td>
                           <td><div align="left">Aksid Staff Commission Report New</div></td>
                            
               </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="701" /></td>
                                <td><div align="left">Item Wise Undelivered DO Report(With Sample)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="7011" /></td>
                                <td><div align="left">Item Wise Undelivered DO Report(Without Sample)</div></td>
                              </tr>
                <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="6" /></td>
                                <td><div align="left">View DO  (Single)</div></td>
                              </tr>-->
                              <!--
                <tr>
                                <td><input name="report" type="radio" class="radio" value="1992" /></td>
                                <td><div align="left">Sales Statement(As Per DO)</div></td>
                              </tr>
                <tr>
                                <td><input name="report" type="radio" class="radio" value="5" /></td>
                                <td><div align="left">Delivery Order Brief Report (Region Wise)</div></td>
                              </tr>
                <tr>
                                <td><input name="report" type="radio" class="radio" value="14" /></td>
                                <td><div align="left">Item DO Report (Region)</div></td>
                              </tr>

                              <tr>
                                <td><input name="report" type="radio" class="radio" value="9" /></td>

                                <td><div align="left">Item DO Report (Region+Zone)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="8" /></td>

                                <td><div align="left">Dealer Performance Report</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="10" /></td>
                                <td><div align="left">Daily Collection Summary</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="13" /></td>
                                <td><div align="left">Daily Collection Summary (Ext)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="11" /></td>
                                <td><div align="left">Daily Collection &amp; Order Summary</div></td>
                              </tr>
                              <tr>

                                <td><input name="report" type="radio" class="radio" value="1999" /></td>

                                <td><div align="left">DO Report for Scratch Card</div></td>

                              </tr>-->







                          <!--</table></td>







                        </tr>







                    </table></td>







                  </tr>







              </table></td>
-->






              <?php /*?><td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">



                  <tr>
                    <td>Product Name : </td>
                    <td><input type="text" name="item_id" id="item_id" class="form-control" /></td>
                  </tr>


                  <tr>
                    <td>From : </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-d')?>" class="form-control" /></td>
                  </tr>

                  <tr>
                    <td>To : </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" class="form-control" /></td>
                  </tr>


          <tr><?php */?>

                   <!-- <td>Client Name :</td>
                    <td>
					   <select name="dealer_code" id="dealer_code">
					    <option></option>
						<?php /*?><? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1');?><?php */?>
					   </select>
					</td>
                  </tr>

                  <tr>
                    <td>Region Name :</td>
                    <td><span id="branch" class="oe_form_group_cell">
                      <select name="region_id" id="region_id" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">
                        <option></option>
                        <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 order by BRANCH_NAME');?>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>Zone Name :</td>
                    <td><span id="zone"><select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)" style="margin-left:4px">
                      <option></option>
                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 order by ZONE_NAME');?>
                    </select></span></td>

                  </tr>
                  <tr>
                    <td>Area Name :</td>
                    <td><span id="area"><select name="area_id" id="area_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)" style="margin-left:4px">
                    <option></option>

                      <? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');?>
                    </select></span></td>
                  </tr>
                  <tr>

                    <td>Chalan Cut off Date  : </td>
                    <td><input  name="cut_date" type="text" id="cut_date" value=""/></td>
                  </tr>
                  <tr>
                    <td>Depot Name :</td>
                    <td><span class="oe_form_group_cell" >

                      <select name="warehouse_id" id="warehouse_id" class="form-control" >
                      <option></option>
                        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'1');?>
                      </select>
                    </span></td>
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
              <td><input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>

</form>-->
<?
require_once "../../../assets/template/layout.bottom.php";
?>