<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Configuration Reports';

do_calander("#f_date");
do_calander("#t_date");

$tr_type="Show";

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// Build the full URL
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


$trimmed_path = str_replace("https://saaserp.ezzy-erp.com/app/views/", "", $url);
$parts = explode('/', $trimmed_path);

 $mod_name = $parts[0]; 
 $folder_name = $parts[1];
 $page_name = $parts[2]; 


	 $res2 ='SELECT  r.folder_name, r.report_no, r.feature_id,r.page_id, p.id AS page_id, f.id AS feature_id, f.feature_name,  m.id AS module_id,  m.module_name
			FROM  user_page_manage p JOIN  user_feature_manage f ON p.feature_id = f.id JOIN  user_module_manage m ON f.module_id = m.id, report_manage r
			WHERE  m.module_file="'.$mod_name.'" and p.folder_name="'.$folder_name.'" and p.page_link="'.$page_name .'" and r.folder_name="'.$folder_name.'" and r.feature_id=f.id and r.page_id=p.id';

								$query=db_query($res2);
								
								While($row=mysqli_fetch_object($query)){
									$page_file[$row->page_no] = $row->page_id;
								}



?>



<div class="d-flex justify-content-center">
    <form class="n-form1 fo-width pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
				
				
					<?
					
							 //$res ='select report_name,page_id,report_no,status from report_manage where page_id="'.$page_file[$row->page_id].'" and status="Yes"';
							 
							 $res ='select r.id,r.report_name,r.page_id,r.report_no,r.status,u.user_id,a.user_id,a.report_id 
							 from report_manage r, user_activity_management u,user_report_access a 
							 where r.page_id="'.$page_file[$row->page_id].'" and a.report_id=r.id and a.user_id=u.user_id and u.user_id="'.$_SESSION['user']['id'].'" and a.access="1" and r.status="Yes"';
									
									$query=db_query($res);
								While($row=mysqli_fetch_object($query)){
								
								?>
				
				
				
				
				
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="<?=$row->report_no?>" checked="checked" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                      <?=$row->report_name?> (<?=$row->report_no?>)
                    </label>
                </div>
            </div>
			
			
			
			<? } ?>

            <div class="col-sm-7">
				<!--<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Prepare By</label>
                    <div class="col-sm-8 p-0">
                      <select name="by" id="by" class="form-control">
					  	<option></option>
							<? 
							$sql="SELECT a.user_id,a.fname FROM `user_activity_management` a WHERE 1";
							advance_foreign_relation($sql,$by);	  
							?>
						</select>
                    </div>
                </div>-->
				<!--<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Sub Category</label>
                    <div class="col-sm-8 p-0">
					<input type="text" list="sub_group" name="sub_group_id" id="sub_group_id" class="form-control" />
                      <datalist id="sub_group">
					 		 <option></option>
							<? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$data->sub_group_id,'group_for="'.$_SESSION['user']['group'].'"');?>
					</datalist>
                    </div>
                </div>-->
                <!--<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Name</label>
                    <div class="col-sm-8 p-0">
					<input type="text" list="item" name="item_id" id="item_id" class="form-control" />
                      <datalist id="item">
                        <option></option>
                      
						<? foreign_relation('item_info','item_id','item_name',$item_id,'group_for="'.$_SESSION['user']['group'].'"');?>
                    </datalist>
                    </div>
                </div>-->  

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date</label>
                    <div class="col-sm-8 p-0">
                     <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" required autocomplete="off" / class="form-control">
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                     <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required autocomplete="off" / class="form-control">
                      </span>

                    </div>
                </div>

                <!--<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Vendor Name</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
						<input type="text" list="vendor" name="vendor_id" id="vendor_id" class="form-control" />
                            <datalist id="vendor">
                       		 <option></option>
								<? 
								$sql = "select v.vendor_id,v.vendor_name from vendor v where v.group_for='".$_SESSION['user']['group']."' order by v.vendor_name";
								foreign_relation_sql($sql);?>
                   			 </datalist>

                        </span>


                    </div>
                </div>-->
				<!--<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Purchae Status</label>
                    <div class="col-sm-8 p-0">
                      <select name="status" id="status" class="form-control">
					    <option value="">All</option>
						<option value="UNCHECKED">UNCHECKED</option>
                        <option value="CHECKED">CHECKED</option>   
					    <option value="COMPLETED">COMPLETED</option>
			        </select>
                    </div>
                </div>-->
                 <!--<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Inventory Name:</label>
                    <div class="col-sm-8 p-0">
                            
                            <select name="warehouse_id" id="warehouse_id">
							<option></option>
							  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','1');?>
                   			 </select>

                    </div>
                </div>-->

            </div>

        </div>
        <div class="n-form-btn-class">
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" />
        </div>
    </form>
</div>




<!--<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">
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
                                <td width="6%"><input name="report" type="radio" class="radio" value="1" /></td>
                                <td width="94%"><div align="left">Purchase Order Summary</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1005" /></td>
                                <td><div align="left">Present Stock Summary</div></td>
                              </tr>-->
                              
                            <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="2" /></td>
                                <td><div align="left">Purchase Receive Report(PO Wise)</div></td>
                              </tr>
                               <tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                                <td><div align="left">Purchase Receive Report(Date Wise)</div></td>
                              </tr>-->
                            <!--  <tr>
                                <td><input name="report" type="radio" class="radio" value="5" /></td>
                                <td><div align="left">Purchase Receive Report (PO Wise)</div></td>
                              </tr>-->
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="6" /></td>
                                <td><div align="left">Purchase Receive Report</div></td>
                              </tr>-->
                       <!--       <tr>
                                <td><input name="report" type="radio" class="radio" value="4" /></td>
                                <td><div align="left">View Purchase Order(Single)</div></td>
                              </tr>-->
                   <!--       </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Prepared By:</td>
                    <td><select name="by" id="by" class="form-control">
					  <option></option>-->
<?php /*?><? 
$sql="SELECT a.user_id,a.fname FROM `user_activity_management` a WHERE level=3 or level=5";
advance_foreign_relation($sql,$by);	  
?>
</select></td>
                  </tr>
                  <tr>
                    <td>Product Sub Category: </td>
                    <td><select name="sub_group_id" id="sub_group_id" class="form-control">
					  <option></option>
				<? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$data->sub_group_id);?>
			</select></td>
                  </tr>
                  <tr>
                    <td>Product Name: </td>
                    <td><select name="item_id" id="item_id" class="form-control">
                        <option></option>
                      
						<? foreign_relation('item_info','item_id','item_name',$item_id);?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>From: </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" required autocomplete="off" / class="form-control"></td>
                  </tr>
                  <tr>
                    <td>To: </td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required autocomplete="off" / class="form-control"></td>
                  </tr>
				  <tr>
                    <td>Vendor Name: </td>
                    <td><select name="vendor_id" id="vendor_id" class="form-control">
                        <option></option>
                        <? 
						$sql = "select v.vendor_id,concat(v.vendor_name,'-',g.group_name) from vendor v,user_group g where v.group_for=g.id order by v.vendor_name";
						foreign_relation_sql($sql);?>
                    </select></td>
                  </tr>
					
				  <tr>
				    <td>Purchase Order Status:</td>
				    <td><select name="status" id="status" class="form-control">
					    <option value="">All</option>
                        <option value="CHECKED">CHECKED</option>
                        <option value="UNCHECKED">UNCHECKED</option>
					    <option value="DONE">DONE</option>
			        </select></td>
			      </tr>
				  <!--<tr>
                    <td>Purchase Order No: </td>
                    <td><input  name="wo_id" type="text" id="wo_id" value=""/></td>
                  </tr>-->
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
</form><?php */?>
<?
$tr_from="Purchase";
require_once SERVER_CORE."routing/layout.bottom.php";
?>