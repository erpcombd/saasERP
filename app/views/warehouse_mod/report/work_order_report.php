<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Warehouse Advance Reports';
$ip=$_SESSION['user']['ip'];

$php_ip=substr($_SESSION['php_ip'],0,11);

if($php_ip=='115.127.35.' || $php_ip=='115.127.24.' || $php_ip=='192.168.191'){ 
	do_calander('#f_date'/*,'-1900','0'*/);
	do_calander('#t_date'/*,'-1900','30'*/);
} else {
	do_calander('#f_date'/*,'-60','0'*/);
	do_calander('#t_date'/*,'-60','30'*/);		
}
auto_complete_from_db('item_info','item_name','item_id','1 and group_for="'.$_SESSION['user']['group'].'"','item_id');
$tr_type="Show";
$tr_from="Warehouse";

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
                // var_dump($res2);
								
								While($row=mysqli_fetch_object($query)){
									$page_file[$row->page_no] = $row->page_id;
								}


?>



<div class="d-flex justify-content-center">
    <form class="n-form1 fo-width pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1" style="width:90%">
        <div class="row m-0 p-0">
            <div class="col-sm-6">
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
                    <input name="report" type="radio" class="radio1" id="report1-btn1" value="<?=$row->report_no?>" checked="checked" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn1">
                         <?=$row->report_name?> (<?=$row->report_no?>)
                    </label>
                </div>
<? } ?>
			
				
				
				<!--
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1" checked="checked" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                        Warehouse Transection Report(1)
                    </label>
                </div>
				
				        <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report2-btn" value="2" tabindex="1"/>
                    <label class="form-check-label p-0" for="report2-btn">
                        	
							Stock Position Report(Closing)(2)
                    </label>
                </div>

                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report2-btn" value="3225" tabindex="1"/>
                    <label class="form-check-label p-0" for="report2-btn">
                        	
							Stock Closing  Warehouse Wise (WH)(3225)
                    </label>

                </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report2-btn" value="32251" tabindex="1"/>
                    <label class="form-check-label p-0" for="report2-btn">
                        	
							Stock Closing  Warehouse Wise (PL)(32251)
                    </label>

                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report2-btn" value="35" tabindex="1"/>
                    <label class="form-check-label p-0" for="report2-btn">
							Stock Movement Report(35)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report2-btn" value="36" tabindex="1"/>
                    <label class="form-check-label p-0" for="report2-btn">
							Purchase Order Details(36)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report2-btn" value="20022" tabindex="1"/>
                    <label class="form-check-label p-0" for="report2-btn">
                        	
							Stock Position Alert Report(20022)
                    </label>
                </div>-->
				
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report2-btn" value="20025" tabindex="1"/>
                    <label class="form-check-label p-0" for="report2-btn">
                        	
							FG Cost Alert Report(20025)
                    </label>
                </div>-->
				 
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report3-btn" value="113"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report3-btn">
                        Item Opening Report (113)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report4-btn" value="401"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report4-btn">
                        Undelivered SO (401)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report5-btn" value="402"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report5-btn">
                        Undelivered PO (402)
                    </label>
                </div>-->
				
               

            </div>
			
			 


             


            <div class="col-sm-6">
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Group:</label>
                   <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">

                          <select name="group_id" id="group_id" tabindex="3" onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value,document.getElementById('group_id').value);">

                              <option></option>
                              <? foreign_relation('item_group','group_id','group_name',$group_id,' 1');?>

                          </select>

                        </span>


                    </div>
                </div>

      			<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Sub Group:</label>
                    <div class="col-sm-8 p-0">
                        <span class="oe_form_group_cell">

                              <select name="item_sub_group" tabindex="4">

                                <option></option>

                                <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, '1');?>

                              </select>


                        </span>

                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Name:</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
					  <select name="item_id" id="item_id">
					  <option value="">All</option>
					  <? foreign_relation('item_info','item_id','item_name');?>
					  
					  </select>
                        	
                      </span>

                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date :</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
							<input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-1')?>" class="form-control" />
                        </span>


                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
							<input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" class="form-control" />
                        </span>


                    </div>
                </div>

                <?php /*?><div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Issue Status:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
							<select name="issue_status" id="issue_status">
								<option value=""></option>
								<option value='Sales'>Sales</option>
								<option value='Bulk Sales'>Bulk Sales</option>
								<option value='Issue'>Issue</option>
								<option value='Sample Issue'>Sample Issue</option>
								<option value='Gift Issue'>Gift Issue</option>
								<option value='Entertainment Issue'>Entertainment Issue</option>
								<option value='R & D Issue'>R & D Issue</option>
								<option value='Other Issue'>Other Issue</option>
								<option value='Staff Sales'>Staff Sales</option>
								<option value='Export'>Export Sales</option>
								<option value='Other Sales'>Other Sales</option>
								<option value='Consumption'>Consumption</option>
								<option value='Reprocess Issue'>Reprocess Issue</option>
								<option value='Claim Item Issue'>Claim Item Issue</option>
								<option value='Direct Sales'>Direct Sales</option>
                   			 </select>
                        </span>


                    </div>
                </div><?php */?>

				
				<?php /*?><div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Receive Status :</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <select name="receive_status" id="receive_status">
								<option value=""></option>
								<option value='All_Purchase'>All Purchase</option>
								<option value='Purchase'>Purchase</option>
								<option value='Receive'>Receive</option>
								<option value='Return'>Return</option>
								<option value='Opening'>Opening</option>
								<option value='Other Receive'>Other Receive</option>
								<option value='Local Purchase'>Local Purchase</option>
								<option value='Sample Receive'>Sample Receive</option>
								<option value='Import'>Import</option>
								<option value='Production'>Production</option>
								<option value='Reprocess Receive'>Reprocess Receive</option>
								<option value='Claim Item Receive'>Claim Item Receive</option>
			      		  </select>
                        </span>


                    </div>
                </div><?php */?>
				
					<? $user_group_define=find_a_field('company_define ','GROUP_CONCAT(company_id ORDER BY company_id ASC)','user_id="'.$_SESSION['user']['id'].'" and status="Active"');?>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Inventory Name:<?=$user_group_define?></label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
							<select name="warehouse_id" id="warehouse_id">
                      			<option selected="selected"></option>
	
                      			<? foreign_relation('warehouse','warehouse_id','warehouse_name',
									$_POST['warehouse_id'],'group_for in ('.$user_group_define.') and status="Active" order by warehouse_name');?>
                  		    </select>
                        </span>


                    </div>
                </div>
				
				<?php /*?><div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Requisition No:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
							<input type="text" name="req_no" />
                        </span>


                    </div>
                </div><?php */?>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Sales Party:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            
								<select name="dealer_code" id="dealer_code">
									<option></option>
									
<?php /*?>									<? foreign_relation('dealer_info','dealer_code','concat(dealer_code," : ",dealer_name_e)',$dealer_code,' 1 AND `dealer_type`="BulkBuyer"
AND  `direct_sales`=  "YES" AND  `group_for` ="'.$_SESSION['user']['group'].'"');?><?php */?>

<? foreign_relation('dealer_info','dealer_code','concat(dealer_code," : ",dealer_name_e)',$dealer_code,' 1 AND  `group_for` ="'.$_SESSION['user']['group'].'"');?>
                   			    </select>
                        </span>


                    </div>
                </div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Purchase Party :</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <select name="vendor_id" id="vendor_id">
								<option></option>
								<? foreign_relation('vendor','vendor_id','concat(vendor_id," : ",vendor_name)',$vendor_id,' 1 AND  `group_for` ="'.$_SESSION['user']['group'].'"');?>
							</select>

                        </span>


                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Company:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                           <select  id="group_for" name="group_for" class="form-control" required>
										<? user_company_access($group_for); ?>
									</select>

                        </span>


                    </div>
                </div>
			
                <?php /*?><div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Other Issue Type :</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <select name="issued_to" id="issued_to">
					           <option></option>
                                 <? foreign_relation('warehouse_other_issue_type','issue_type','issue_type',$issued_to,'1 and group_for="'.$_SESSION['user']['group'].'" order by issue_type');?>
                          </select>

                        </span>


                    </div>
                </div><?php */?>




            </div>

        </div>
        <div class="n-form-btn-class">
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" />
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
                              <td colspan="2" class="title1"><div align="left">Select Report- <?=$ip;?> </div></td>
                              </tr>
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>
                                <td width="94%"><div align="left">Warehouse  Transection Report(1)</div></td>
                              </tr>
							  <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td width="94%"><div align="left">Stock Position Report(Closing)(2)</div></td>
                              </tr>
							  
							  <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="113" checked="checked" /></td>
                                <td width="94%"><div align="left">Item Opening Report</div></td>
                              </tr>
							  
							
						<tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="601" /></td>
                                <td width="94%"><div align="left">Entry Status Report User wise(601)</div></td>
                              </tr>
							  
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="301" /></td>
							    <td><div align="left">Production To Warehouse Delivery Brief(301)</div></td>
						      </tr>

							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="1008" /></td>
							    <td><div align="left">Purchase Brief Report(PO+Local)(1008)</div></td>
						      </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1022" /></td>
							    <td><div align="left">Purchase Details Report(PO+Local)(1022)</div></td>
						      </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1024" /></td>
							    <td><div align="left">Local Purchase Details Report(1024)</div></td>
						      </tr>
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="1019" /></td>
							    <td><div align="left">Purchase  Brief Report(old year)(1019)</div></td>
						      </tr>
							  
							 
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>-->
							  <!--<tr>
							    <td><input name="report" type="radio" class="radio" value="1011" /></td>
							    <td><div align="left"><strong>Purchase  Report(Without Import)(1011)</strong></div></td>
						      </tr>-->
                             <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="8002" /></td>
                                <td><div align="left">Purchase  Report(SCM)(8002)</div></td>
                              </tr>-->
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="8001" /></td>
                                <td><div align="left">Last Item Purchase  Report(Select item)(8001)</div></td>
                              </tr>
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="302" /></td>
                                <td width="94%"><div align="left">Purchase Receive with Vendor(302)</div></td>
                              </tr>  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="309" /></td>
							    <td><div align="left">Purchase Avg with last price(309)</div></td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="306" /></td>
							    <td><div align="left"><strong>Import GR Details Report(306)</strong></div></td>
						      </tr>-->
							 <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="307" /></td>
							    <td><div align="left">Import GR Brief Report-Doller(307)</div></td>
						      </tr>-->
							<!--  <tr>
                                <td><input name="report" type="radio" class="radio" value="308" /></td>
							    <td><div align="left">Import GR Brief Report-(BDT Rate)(308)</div></td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="304" /></td>
							    <td><div align="left">Requisition  Details Report(304)</div></td>
						      </tr>
							  
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>-->
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="1199" /></td>
							    <td><div align="left">Old Import Item Receive Report(1199)</div></td>
						      </tr>-->
							 <!-- <tr>
							    <td><input name="report" type="radio" class="radio" value="1010" /></td>
							    <td><div align="left">Other Issue Summery Report(1010)</div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="401" /></td>
							    <td><div align="left">Other Issue Details Report(401)</div></td>
						      </tr>
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="1013" /></td>
							    <td><div align="left">Export Issue Summery Report(1013)</div></td>
						      </tr>
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="1014" /></td>
							    <td><div align="left">Export Issue Details Report(1014)</div></td>
						      </tr>
							  							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1018" /></td>
							    <td><div align="left">Sample Issue Details Report (1018)</div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="2001" /></td>
							    <td><div align="left">Export Cartoon  Issue Summery (2001)</div></td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1021" /></td>
							    <td><div align="left">Direct Sales Report(1021)</div></td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="8" /></td>
							    <td><div align="left">Transection Report (Entry Wise)(8) </div></td>
						      </tr>
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="402" /></td>
							    <td><div align="left">Single Item Stock Position(402) </div></td>
						      </tr>
							  
							  <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="5090" /></td>
                                <td width="94%"><div align="left">Warehouse Present Stock (5090)</div></td>
                              </tr>-->
							  

<?php /*?><? if( $_SESSION['user']['group']=='3'){ ?>

<tr>
<td><input name="report" type="radio" class="radio" value="3" /></td>
<td><div align="left">Stock Report with PL,COLD(Closing)(3)</div></td>
</tr>

<tr>
  <td><input name="report" type="radio" class="radio" value="42" /></td>
  <td><div align="left">Raw Material Stock with Consumption(42)</div></td>
</tr>
<? } ?>

<tr>
  <td><input name="report" type="radio" class="radio" value="41" /></td>
  <td><div align="left">Single Item Stock Status PL Wise(41)</div></td>
</tr>

<? if( $_SESSION['user']['group']!='3'){ ?>
<tr>
<td><input name="report" type="radio" class="radio" value="331" /></td>
<td><div align="left">Stock Position Report with Production Line(Closing)(331)</div></td>
</tr><? } ?>
<tr>
<td width="6%"><input name="report" type="radio" class="radio" value="4" /></td>
<td width="94%"><div align="left">Stock Position Report(Closing)(FG)(4)</div></td>
</tr>

<? if( $_SESSION['user']['depot']=='128'){ ?>
<tr>
<td width="6%"><input name="report" type="radio" class="radio" value="40" /></td>
<td width="94%"><div align="left">Head Office Shop Stock Report(40)</div></td>
</tr>
<?php } ?><?php */?>



<!--<tr>
<td><input name="report" type="radio" class="radio" value="100911" /></td>
<td><div align="left">Stock Movement Report (100911)slow</div></td>
</tr>
<tr>-->
						       <!-- <tr>
                                  <td><input name="report" type="radio" class="radio" value="225" /></td>
						          <td><div align="left">Cold Storage  Closing Report(225)</div></td>
					          </tr>
						        <tr>
                                  <td><input name="report" type="radio" class="radio" value="332" /></td>
						          <td><div align="left">SR VS Consumption Report(332)</div></td>
					          </tr>
						        <tr>
						          <td>&nbsp;</td>
						          <td>&nbsp;</td>
					          </tr>
						        <td>&nbsp;</td>
						        <td>&nbsp;</td>
					          </tr>
						      <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="1012" /></td>
                                <td width="94%"><div align="left">Claim Product Summery IN OUT Report(1012)</div></td>
                              </tr>-->
							  <!-- <tr>
                                 <td><input name="report" type="radio" class="radio" value="10011" /></td>
							     <td><div align="left">Stock Valuation Report (HFL) </div></td>
						      </tr>-->
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="1004" /></td>
							    <td><div align="left">RM Consumtion Report</div></td>
						      </tr>-->
							 <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="1016" /></td>
							    <td><div align="left">Reprocess Product Summery IN OUT Report(1016)</div></td>
						      </tr>-->
							 <!-- <tr>
							    <td><input name="report" type="radio" class="radio" value="1005" /></td>
							    <td><div align="left">FG Production Report(1005)</div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1001" /></td>
							    <td><div align="left">Stock Valuation Report </div></td>
						      </tr>-->
							  
							 <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="1003" /></td>
							    <td><div align="left">Material Consumption  Report </div></td>
						      </tr>-->
<!--							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1006" /></td>
							    <td><div align="left">Product Movement Detail Report(FG)(1006)</div></td>
						      </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1007" /></td>
							    <td><div align="left">Product Movement Summary Report(FG)(1007)</div></td>
						      </tr>-->
							  
							  <?php /*?> <tr>
							     <td><input name="report" type="radio" class="radio" value="1009" /></td>
							     <td><div align="left">Daily Chalan Issue ReportTransfered(1009)</div></td>
						      </tr>
							  
<tr>
	 <td><input name="report" type="radio" class="radio" value="201" /></td>
	 <td><div align="left">Warehouse Adjust Report(201)</div></td>
</tr>

<? if($_SESSION['user']['group']=='3'){?><tr>
	 <td><input name="report" type="radio" class="radio" value="1015" /></td>
	 <td><div align="left">HFL FG Statement Report(1015)</div></td>
</tr>
<tr>
	<td><input name="report" type="radio" class="radio" value="10091" /></td>
	<td><div align="left">Daily HFL Sales to Jamuna(10091)</div></td>
</tr>
<? } ?>

<? if($_SESSION['user']['group']=='10'){?><tr>
	 <td><input name="report" type="radio" class="radio" value="111" /></td>
	 <td><div align="left">HFML Stock Closing Production Line Wise(111)</div></td>
</tr>
<? } ?>

<tr>
	 <td><input name="report" type="radio" class="radio" value="222" /></td>
	 <td><div align="left">Store Movement Report(Select Sub Group)(222)</div></td>
</tr>
<tr>
  <td><input name="report" type="radio" class="radio" value="224" /></td>
  <td><div align="left">Line Movement Report(Select Line)(224)</div></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
	 <td><input name="report" type="radio" class="radio" value="223" /></td>
	 <td><div align="left">Production Vs Delivery Checking(223)</div></td>
</tr>


                               <tr>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                               </tr>
                               <tr>
                                 <td><input name="report" type="radio" class="radio" value="21" /></td>
                                 <td><div align="left">Print Store Item Audit (21)</div></td>
                               </tr>
                               <tr>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                               </tr>
                               <tr>
                                 <td><input name="report" type="radio" class="radio" value="226" /></td>
                                 <td><div align="left">Store Audit (226) </div></td>
                               </tr>
                               <tr>
                                 <td><input name="report" type="radio" class="radio" value="227" /></td>
                                 <td><div align="left">Store Audit  Summary(227)</div></td>
                               </tr>
                               <tr>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                               </tr>
                               
                               <tr>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                               </tr>
                              

							  
                          </table></td>
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
                    <td>Item Name:</td>
                    <td><input type="text" name="item_id" id="item_id" style="width:250px" /></td>
                  </tr>
                  <tr>
                    <td>Item Sub Group:</td>
                    <td><select name="item_sub_group" id="item_sub_group">
                      <option></option>
                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name');?>
                    </select></td>
                  </tr>
				   <tr>
                    <td>Item Brand Name:</td>
                    <td><select name="item_sub_brand" id="item_sub_brand">
                      <option></option>
                      <? foreign_relation('item_brand','brand_name','brand_name');?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Item Audit Group:</td>
                    <td><select name="audit_group" id="audit_group">
                        <option></option>
                        <? foreign_relation('item_sub_group','audit_group','audit_group',$_POST['audit_group'],'1 group by audit_group');?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Product Group: </td>
                    <td><select name="sales_item_type" id="sales_item_type">
                      <option></option>
<? foreign_relation('product_group','group_name','group_name',$PBI_GROUP,'1 order by group_name');?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>From:</td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01');?>" readonly="readonly"/></td>
                  </tr>
                  <tr>
                    <td>To:</td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d');?>"  readonly="readonly"/></td>
                  </tr>
				  <tr>
                    <td>Issue Status: </td>
                    <td><select name="issue_status" id="issue_status">
<option value=""></option>
<option value='Sales'>Sales</option>
<option value='Bulk Sales'>Bulk Sales</option>
<option value='Issue'>Issue</option>
<option value='Sample Issue'>Sample Issue</option>
<option value='Gift Issue'>Gift Issue</option>
<option value='Entertainment Issue'>Entertainment Issue</option>
<option value='R & D Issue'>R & D Issue</option>
<option value='Other Issue'>Other Issue</option>
<option value='Staff Sales'>Staff Sales</option>
<option value='Export'>Export Sales</option>
<option value='Other Sales'>Other Sales</option>
<option value='Consumption'>Consumption</option>
<option value='Reprocess Issue'>Reprocess Issue</option>
<option value='Claim Item Issue'>Claim Item Issue</option>
<option value='Direct Sales'>Direct Sales</option>
                    </select></td>
                  </tr>
					
				  <tr>
				    <td>Receive Status: </td>
				    <td>
					<select name="receive_status" id="receive_status">
<option value=""></option>
<option value='All_Purchase'>All Purchase</option>
<option value='Purchase'>Purchase</option>
<option value='Receive'>Receive</option>
<option value='Return'>Return</option>
<option value='Opening'>Opening</option>
<option value='Other Receive'>Other Receive</option>
<option value='Local Purchase'>Local Purchase</option>
<option value='Sample Receive'>Sample Receive</option>
<option value='Import'>Import</option>
<option value='Production'>Production</option>
<option value='Reprocess Receive'>Reprocess Receive</option>
<option value='Claim Item Receive'>Claim Item Receive</option>
			        </select></td>
			      </tr>
                  <tr>
                    <td>Inventory Name: </td>
                    <td><select name="warehouse_id" id="warehouse_id">
                      <option selected="selected"></option>
                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',
$_POST['warehouse_id'],'group_for="'.$_SESSION['user']['group'].'" and status="Active" order by warehouse_name');?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Requisition No: </td>
                    <td><input type="text" name="req_no" /></td>
                  </tr>	
				                    <tr>
                    <td>Sales Party : </td>
                    <td><select name="dealer_code" id="dealer_code">
					<option></option>
<? foreign_relation('dealer_info','dealer_code','concat(dealer_code," : ",dealer_name_e)',$dealer_code,' 1 and `dealer_type`="BulkBuyer"
AND  `direct_sales`=  "YES" AND  `group_for` ="'.$_SESSION['user']['group'].'"');?>
                    </select></td>
                  </tr>	
				  	                <tr>
				  	                  <td>Purchase Party: </td>
<td><select name="vendor_id" id="vendor_id">
<option></option>
<? foreign_relation('vendor','vendor_id','concat(vendor_id," : ",vendor_name)',$vendor_id,' 1 AND  `group_for` ="'.$_SESSION['user']['group'].'"');?>
</select></td>
                  </tr>
  	                <tr>
                    <td>Other Issue Type  : </td>
                    <td><select name="issued_to" id="issued_to">
					<option></option>
<? foreign_relation('warehouse_other_issue_type','issue_type','issue_type',$issued_to,'1 and group_for="'.$_SESSION['user']['group'].'" order by issue_type');?>
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
              <td><input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
</form><?php */?>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>