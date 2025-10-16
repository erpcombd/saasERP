<?php








require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





$title='IOM ENTRY';	





do_calander('#f_date');







do_calander('#t_date');







$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';











auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');















$table='hrm_iom_info';







$unique='id';







$shown='PBI_ID';







$crud      =new crud($table);









if($_GET['emp_id']>0) $emp_id=$_GET['emp_id'];

if($_POST['PBI_ID']!='') { 

    

    



    

    

    $emp_id= $_POST['PBI_ID'];

    

    

    

}







if($_GET['emp_id']>0&&$_GET['iom_id']>0)





{		



$sql="delete from hrm_iom_info where id='".$_GET['iom_id']."'";

db_query($sql);









$up_query='update hrm_att_summary set iom_type="", iom_sl_no="", iom_reason="", iom_approved_by="", iom_entry_at="0000-00-00 00:00:00", iom_entry_by="" 

where iom_id="'.$_GET['iom_id'].'" and emp_id="'.$_GET['emp_id'].'"';







db_query($up_query);















echo 'Deleted';







}







if(prevent_multi_submit()){







if(isset($_POST['search'])&&$_POST['t_date']!=''&&$_POST['f_date']!='')







{		







$iom_type=$_POST['iom_type'];

$iom_reason=$_POST['reason']=$_POST['iom_reason'];

$iom_entry_at=date('Y-m-d H:i:s');

$iom_entry_by=$_SESSION['user']['id'];

$s_date=($_POST['f_date']);

$e_date=($_POST['t_date']);

$iom_category = $_POST['iom_category'];



$s_time=($_POST['s_time']);

$e_time=($_POST['e_time']);



$from_date=$_REQUEST['s_date']=strtotime($_POST['f_date']);

$to_date=$_REQUEST['e_date']=strtotime($_POST['t_date']);









echo 'ID : '.$old_iom = find_a_field('hrm_att_summary','iom_sl_no',' att_date between "'.$_REQUEST['f_date'].'" and  "'.$_REQUEST['t_date'].'" and  emp_id="'.$emp_id.'" and iom_sl_no>0');

' att_date between "'.$_REQUEST['s_date'].'" and  "'.$_REQUEST['e_date'].'" and  emp_id="'.$emp_id.'" and iom_sl_no>0';







if($old_iom==0){

$from_dates = date_create($from_date);

$to_dates = date_create($to_date);

$diff = date_diff(date_create($s_date),date_create($e_date)); 

$total_days =  $diff->format("%a")+1;



if($_POST['iom_type']=='Early Half'){

	 $s_time = '08:30';

	 $e_time = '12:45';

	}elseif($_POST['iom_type']=='Last Half'){

		$s_time = '12:45';

		$e_time = '17:00';

		}elseif($_POST['iom_type']=='Full'){

		$s_time = '08:30';

		$e_time = '17:00';

		}







 $ssql = "INSERT INTO hrm_iom_info (`dept_head_status` ,`PBI_ID` ,`type` ,`s_date` ,`e_date` , `reason` ,`iom_category`,`total_days`,`s_time`,`e_time`,`iom_status`,`entry_at`)



VALUES (  'Approve', '".$emp_id."', '".$_POST['iom_type']."',  '".$_POST['f_date']."', '".$_POST['t_date']."', '".$iom_reason."','".$iom_category."','".$total_days."', 
'".$s_time."' , '".$e_time."','GRANTED','".date('Y-m-d H:i:s')."')";







db_query($ssql);

$iom_sl_no=  mysqli_insert_id();

	

	

for($i=$from_date; $i<=$to_date; $i=$i+86400)

{



$att_date=date('Y-m-d',$i);

$found = find_a_field('hrm_att_summary','1','emp_id="'.$emp_id.'" and att_date="'.$att_date.'"');





if($found==0)



{



 $sql="INSERT INTO hrm_att_summary (emp_id, iom_type, iom_id, att_date,iom_start_time,iom_end_time,iom_entry_at,iom_entry_by,iom_category, dayname)

VALUES ('$emp_id', '$iom_type', '$iom_sl_no','$att_date','$s_time','$e_time','$iom_entry_at','$iom_entry_by','$iom_category', dayname('".$att_date."'))";

$query=db_query($sql);



}

else{



  $sql='update hrm_att_summary set iom_type="'.$iom_type.'", iom_id="'.$iom_sl_no.'",iom_start_time="'.$s_time.'",iom_end_time="'.$e_time.'",dayname=dayname("'.$att_date.'"),

iom_entry_at="'.$iom_entry_at.'", iom_entry_by="'.$iom_entry_by.'",iom_category="'.$iom_category.'"

where  emp_id="'.$emp_id.'" and att_date="'.$att_date.'" ';

$query=db_query($sql);



}



} 







}







else echo $msggg= "<h2 style='color:#FF0000'>You Can't Add Duplicate IOM</h2>";







}}







		







//		if(isset($$unique))







//{







//$condition=$unique."=".$$unique;







//$data=db_fetch_object($table,$condition);







//foreach($data as $key => $value)







//{ $$key=$value;}







//}







//if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);













?>







<script type="text/javascript"> function DosNav(lk1,lk2){







	window.open('../attendence/iom_entry.php?iom_sl_no='+lk1+'&emp_id='+lk2,'_self');







	}</script>







<style type="text/css">















<!--















.style1 {font-size: 24px}







.style3 {







	font-size: 16px;







	font-weight: bold;







	color: #0000FF;







}















-->















</style>

































<!--hello report-->

<form action="?"  method="post">



	<div class="d-flex justify-content-center">

		<div class="n-form1 fo-width pt-0">

			<h4 class="text-center bg-titel bold pt-2 pb-2"> IOM Entry  </h4>

			<div class="container-fluid p-0 pl-2 pr-2">

				<div class="row">

					<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">



						<div class="form-group row  m-0 mb-1 pl-3 pr-3">

							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Code:  </label>

							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" value="<?=$emp_id?>" required />

							</div>

						</div>



						<div class="form-group row  m-0 mb-1 pl-3 pr-3">

							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date From: </label>

							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<input type="text" name="f_date" id="f_date" value="<?=$f_date?>" />

							</div>

						</div>



						<div class="form-group row  m-0 mb-1 pl-3 pr-3">

							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To: </label>

							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<input type="text" name="t_date" id="t_date" value="<?=$t_date?>" />

							</div>

						</div>



					</div>









					<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">



						<div class="form-group row  m-0 mb-1 pl-3 pr-3">

							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">IOM Type:  </label>

							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">



								<select name="iom_type" id="iom_type" style="width:100px;" required> 

                             <option></option>

                             <option>Full</option>

                              <option>Early Half</option>

                              <option>Last Half</option>

                             </select>

							</div>

						</div>



						<div class="form-group row  m-0 mb-1 pl-3 pr-3">

							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Reason: </label>

							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<input name="iom_reason"  type="text" id="iom_reason" size="10" onblur="" tabindex="1" value="<?=$iom_reason?>" />

							</div>

						</div>



						<div class="form-group row  m-0 mb-1 pl-3 pr-3">

							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Check </label>

							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

								<input name="view_data" type="submit"  id="view_data" class="btn1 btn1-bg-update" value="VIEW" />

							</div>

						</div>



					</div>





					<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">

							<img src="../../pic/staff/<?php echo $emp_id;?>.jpg" width="100%" height="117" />

					</div>









				</div>





				<div class="n-form-btn-class">

					<hr>



					<input name="search" type="submit" class="btn1 btn1-bg-submit" id="search" value="SUBMIT" />

				</div>



			</div>



		</div>



	</div>







	<div class="container-fluid pt-5">



		<? if($emp_id>0 || $_POST['view_data']){?>

			<h4 class="text-center bg-titel bold pt-2 pb-2">

				<strong>Employee Name: </strong>

				<? $pbi_date=find_all_field('personnel_basic_info','',' PBI_ID='.$emp_id); echo $pbi_date->PBI_NAME.' ('.$pbi_date->PBI_DESIGNATION.')'; ?>



			</h4>







			<center>



				<table width="100%" border="0" cellspacing="0" cellpadding="0">







					<tr>







						<td align="center"></td>







					</tr>







				</table>







			</center>















			<table class="table1  table-striped table-bordered table-hover table-sm">

				<thead class="thead1">

				<tr class="bgc-info">

					<th>Id</th>

					<th>Emp Id</th>

					<th>Iom Type</th>

					<th>Iom No</th>

					<th>Reason</th>

					<th>Att Date</th>

					<th>Entry At</th>

					<th>Action</th>

				</tr>

				</thead>

				<tbody  class="tbody1">







				<?

	 $res="SELECT iom_id,id,emp_id, iom_type, iom_reason, att_date, iom_entry_at



FROM hrm_att_summary







WHERE emp_id=$emp_id and iom_id>0







order by att_date desc";















				$query = db_query($res);







				while($data=mysqli_fetch_object($query)){







					?>







					<tr <?=(++$i%2)?'class="alt"':'';?>>



						<td><?=$data->id?></td>

						<td><?=$data->emp_id?></td>

						<td><?=$data->iom_type?></td>

						<td><?=$data->iom_id?></td>

						<td><?=$data->iom_reason?></td>

						<td><?=$data->att_date?></td>

						<td><?=$data->iom_entry_at?></td>



						<td><? 	//if(







							//$_SESSION['user']['username']=='faysal'|| // faysal







							//$_SESSION['user']['username']=='9999'	||	// firoz







							//$_SESSION['user']['username']=='12205'		// shoaib







							//){ ?>



							<input type="button" name="button" id="button" class="btn1 btn1-bg-cancel" value="Delete" onclick="DosNav(<?=$data->iom_sl_no?>,<?=$data->emp_id?>)" />



							<? //}?>

						</td>



					</tr>







				<? }?>

				</tbody>

			</table>



		<? }?>







	</div>



</form>































<?php/*>



<div class="oe_view_manager oe_view_manager_current">







  <form action="?"  method="post">







    <div class="oe_view_manager_body">







      <div  class="oe_view_manager_view_list"></div>







      <div class="oe_view_manager_view_form">







        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">





          <div class="oe_form_container">







            <div class="oe_form">







              <div class="">







                <div class="oe_form_sheetbg">







                  <div class="oe_form_sheet oe_form_sheet_width">







                    <div  class="oe_view_manager_view_list">







                      <div  class="oe_list oe_view">







                        <table width="80%" border="1" align="center">







                          <tr>

                            <td height="40" colspan="5" bgcolor="#00FF00"><div align="center" class="style1">IOM Entry</div></td>

                          </tr>



                          <tr>

                            <td><div align="right">Employee Code: </div></td>



                            <td><input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" value="<?=$emp_id?>" required /></td>



                            <td>&nbsp;</td>

                            <td><input name="view_data" type="submit"  id="view_data" value="VIEW" / class="form-control bg-success"></td>







                            <td rowspan="3"><img src="../../pic/staff/<?php echo $emp_id;?>.jpg" width="122" height="117" /></td>







                          </tr>







                          <tr>







                            <td align="right"><div align="right">IOM Type </div></td>







                            <td>

								<select name="iom_type" id="iom_type" class="form-control">







                                <option>REGULAR</option>







                              </select>

							</td>







                            <td><div align="right">Reason</div></td>







                            <td><input name="iom_reason"  type="text" id="iom_reason" size="10" onblur="" tabindex="1" style="width:400px;" value="<?=$iom_reason?>" /></td>







                          </tr>







                          <tr>







                            <td width="20%"><div align="right">FROM:</div></td>







                            <td><input type="text" name="f_date" id="f_date" style="width:100px;" value="<?=$f_date?>"   class="form-control"/></td>







                            <td align="right"><div align="right">TO:</div></td>







                            <td><input type="text" name="t_date" id="t_date" style="width:100px;" value="<?=$t_date?>"   class="form-control"/></td>







                          </tr>







                          <tr>







                            <td colspan="5" style="text-align:center"><label>







                              <div align="center">







                                <input name="search" type="submit" id="search" value="SUBMIT" / class="btn1 btn1-bg-submit">







                              </div>







                              </label></td>







                          </tr>







                        </table>







                        <br />







                        <div style="text-align:center">







                          <div class="oe_form_sheetbg">







                            <div class="oe_form_sheet oe_form_sheet_width">







                              <div class="oe_view_manager_view_list">







                                <div class="oe_list oe_view">







                                  <? if($emp_id>0 || $_POST['view_data']){?>







                                  <center>







                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">







                                      <tr>







                                        <td align="center"><span class="style3"><strong>Employee Name: </strong>







                                          <? $pbi_date=find_all_field('personnel_basic_info','',' PBI_ID='.$emp_id); echo $pbi_date->PBI_NAME.' ('.$pbi_date->PBI_DESIGNATION.')'; ?>







                                          </span></td>







                                      </tr>







                                    </table>







                                  </center>















 <table class="display dataTable no-footer"><thead><tr class="oe_list_header_columns"><th>Id</th><th>Emp Id</th><th>Iom Type</th>







   <th>Iom No</th>







   <th>Reason</th><th>Att Date</th>







   <th>Entry At</th>







   <th>Action</th>







   </tr></thead><tfoot><tr><td></td><td></td><td></td><td></td><td></td><td></td>







       <td></td>







       <td></td>







       </tr></tfoot><tbody>







<?







 $res="SELECT iom_sl_no,id,emp_id, iom_type, iom_sl_no, iom_reason, att_date, iom_entry_at 







FROM hrm_att_summary 







WHERE emp_id=$emp_id and iom_sl_no>0 







order by att_date desc";















$query = db_query($res);







while($data=mysqli_fetch_object($query)){







?>







<tr <?=(++$i%2)?'class="alt"':'';?>>







<td><?=$data->id?></td><td><?=$data->emp_id?></td><td><?=$data->iom_type?></td><td><?=$data->iom_sl_no?></td><td><?=$data->iom_reason?></td><td><?=$data->att_date?></td><td><?=$data->iom_entry_at?></td>







<td><? 	//if(







	//$_SESSION['user']['username']=='faysal'|| // faysal







	//$_SESSION['user']['username']=='9999'	||	// firoz	







	//$_SESSION['user']['username']=='12205'		// shoaib	







	//){ ?><input type="button" name="button" id="button" value="Delete" onclick="DosNav(<?=$data->iom_sl_no?>,<?=$data->emp_id?>)" /><? //}?></td>







</tr>







<? }?></tbody></table>







 <? }?>







                                </div>







                              </div>







                            </div>







                          </div>







                        </div>







                      </div>







                    </div>







                  </div>







                </div>







                <div class="oe_chatter">







                  <div class="oe_followers oe_form_invisible">







                    <div class="oe_follower_list"></div>







                  </div>







                </div>







              </div>







            </div>







          </div>







        </div>







      </div>







    </div>







  </form>







</div>





<*/?>







<?

$main_content=ob_get_contents();

ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>







