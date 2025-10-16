<?php

session_start();

ob_start();

 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



//::::: Edit This Section::::: 

$title='People Information';		// Page Name and Page Title

$page="dealer_info_l.php";		// PHP File Name

$input_page="crm_customer_info.php";

$root='dealer';

$table='crm_customer_info';		// Database Table Name Mainly related to this page
$unique='dealer_code';			// Primary Key of this Database table
$shown='dealer_name_e';	



do_calander('#lead_date');
do_calander('#maturity_date');
do_calander('#priority_date');
do_calander('#permanent_date');

//::::: End Edit Section:::::

$crud      =new crud($table);




$required_id=find_a_field($table,$unique,$unique.'='.$_REQUEST['dealer_code']);
if($required_id>0)

$$unique = $_GET[$unique] = $required_id;



if(isset($_POST[$shown]))

{	if(isset($_POST['insert']))
		{		
		
		
	 
	
		
		
			if($_FILES['customer_image']['tmp_name']!=''){



			$file_name= $_FILES['customer_image']['name'];



			$file_tmp= $_FILES['customer_image']['tmp_name'];



			$ext=end(explode('.',$file_name));



			$path='../../customer_image/';



			move_uploaded_file($file_tmp, $path.$_POST['dealer_code'].'.jpeg');



			}
		
		
		
		 if(count($_POST['having_com'])>0){
	 
	 $total_com_person = $_POST['having_com'];
	 
	 
	 for($i=0;$i<count($_POST['having_com']);$i++){
	 
	 
	 if($total_com_person[$i]>0){
	 
	 $insert = 'insert into crm_having_com set dealer_code="'.$_POST['dealer_code'].'",PBI_ID="'.$total_com_person[$i].'",entry_by="'.$_SESSION['srrr'].'"';
	 db_query($insert);
	 
	 }
	 
	 
	 
	 
	 
	 
	 }
	 
	 }
	 
		
		
				$_POST['entry_by'] = $_SESSION['employee_selected'];
				
				 $crud->insert();
				$type=1;
				$msg='New Entry Successfully Inserted.';
				unset($_POST);
				unset($$unique);
$required_id=find_a_field($table,$unique,$unique.'='.$_REQUEST['dealer_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
echo '<script type="text/javascript">window.location.href = "dealer_info_l.php";</script>';
		}
	//for Modify..................................
	if(isset($_POST['update']))
	{			
	
	
	
			if($_FILES['customer_image']['tmp_name']!=''){



			$file_name= $_FILES['customer_image']['name'];



			$file_tmp= $_FILES['customer_image']['tmp_name'];



			$ext=end(explode('.',$file_name));



			$path='../../customer_image/';



			move_uploaded_file($file_tmp, $path.$$unique.'.jpeg');



			}

$delete = 'delete from crm_having_com where dealer_code="'.$$unique.'"';
db_query($delete);

 if(count($_POST['having_com'])>0){
	 
	 $total_com_person = $_POST['having_com'];
	 
	 
	 for($i=0;$i<count($_POST['having_com']);$i++){
	 
	 
	 if($total_com_person[$i]>0){
	 
	 $insert = 'insert into crm_having_com set dealer_code="'.$_POST['dealer_code'].'",PBI_ID="'.$total_com_person[$i].'",edit_by="'.$_SESSION['srrr'].'", edit_at="'.date("Y-m-d h:i:s").'"';
	 db_query($insert);
	 
	 }
	 
	 
	 
	 
	 
	 
	 }
	 
	 }
	 
	
				$_POST['update_at'] = date("Y-m-d h:i:s");
				$_POST['update_by'] = $_SESSION['srrr'];
				$crud->update($unique);
				$type=1;
				echo '<script type="text/javascript">window.location.href = "dealer_info_l.php";</script>';
	}
}




if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=@each($data))
{ $$key=$value;}
}




?>
<script type="text/javascript"> function DoNav(lk){

	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)

	}

    function add_date(cd)

	{

		var arr=cd.split('-');

		var mon = (arr[1]*1)+6;

		var day = (arr[2]*1);

		var yr =  (arr[0]*1);

		if(mon>12)

		{

			mon = mon-12;

			yr  = yr+1;

		}

		var con_date = yr+'-'+mon+'-'+day;

		document.getElementById('PBI_DOC').value=con_date;

	}

    </script>


  <div class="oe_view_manager oe_view_manager_current">
    <? //include('../../common/title_bar_d.php');?>
	<form action="" method="post" enctype="multipart/form-data">
    <div class="oe_view_manager_body">
      <div  class="oe_view_manager_view_list"></div>
      <div class="oe_view_manager_view_form">
        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
          <div class="oe_form_buttons"></div>
          <div class="oe_form_sidebar"></div>
          <div class="oe_form_pager"></div>
          <div class="oe_form_container">
            <div class="oe_form">
              <div class="">
                <? include('../../common/input_bar.php');?>
                <div class="oe_form_sheetbg">
                  <div class="">
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                      <tbody>
                        <tr class="oe_form_group_row">
                          <td colspan="1" class="oe_form_group_cell"  width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
                              <tbody>
                                
                                <tr class="oe_form_group_row">
                                  <td colspan="5" bgcolor="#00CCFF" class="oe_form_group_cell_label oe_form_group_cell"><div align="center"><strong>General Information </strong></div></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                  <td  class="oe_form_group_cell" >&nbsp;</td>
                                  <td  class="oe_form_group_cell" >&nbsp;</td>
                                  <td colspan="2"  rowspan="7"  class="oe_form_group_cell" ><span class="oe_form_group_cell oe_form_group_cell_label">
                                    
                                    
                                    <img src="../../customer_image/<?=$_GET['dealer_code']?>.jpeg" style="height: 200px; width: 180px; box-shadow: 2px 2px 5px 1px gray; margin-top: 20px;" />
                                    
                                  </span></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td width="19%"  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;People Code:</td>
                                  <td width="30%"  class="oe_form_group_cell" ><input  name="dealer_code" type="text" id="dealer_code" value="<?=($$unique==0)?(find_a_field('crm_customer_info','max(dealer_code)','1')+1):$$unique;?>" class="form-control" readonly="" /></td>
                                  <td width="6%"  class="oe_form_group_cell" >&nbsp;</td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  class="oe_form_group_cell" ><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <label style="min-width:100px;">People Name:</label>
                                  </span></td>
                                  <td  class="oe_form_group_cell" ><input  name="dealer_name_e" type="text" id="dealer_name_e" value="<?=$dealer_name_e?>"  class="form-control"/></td>
                                  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  class="oe_form_group_cell" >Organization</td>
                                  <td  class="oe_form_group_cell" ><select name="PROJECT_ID" id="PROJECT_ID"    class="selectpicker form-control" data-live-search="true" >
                                    <option value=""></option>
                                    <? foreign_relation('crm_project','PROJECT_ID','PROJECT_DESC',$PROJECT_ID,'1')?>
                                  </select></td>
                                  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  class="oe_form_group_cell" >Position</td>
                                  <td  class="oe_form_group_cell" ><input class="form-control" type="text" name="project_desg" id="project_desg" value="<?=$project_desg?>" /></td>
                                  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  class="oe_form_group_cell" >Department</td>
                                  <td  class="oe_form_group_cell" ><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <input class="form-control" type="text" name="project_dept" id="project_dept" value="<?=$project_dept?>" />
                                  </span></td>
                                  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  class="oe_form_group_cell" >Phone No (1) : </td>
                                  <td  class="oe_form_group_cell" ><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <input class="form-control" type="text" name="phone1" id="phone1" value="<?=$phone1?>" />
                                  </span></td>
                                  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >Phone No (2) : </td>
                                  <td class="oe_form_group_cell" ><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <input class="form-control" type="text" name="phone2" id="phone2" value="<?=$phone2?>" />
                                  </span></td>
                                  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td width="15%" class="oe_form_group_cell oe_form_group_cell_label">Upload Image <span style="font-size: 10px; color:red;">(jpeg,png)</span></td>
								  <td width="30%"><span class="oe_form_group_cell oe_form_group_cell_label">
							      <input type="file" name="customer_image" id="customer_image" class="form-control" /></span></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  class="oe_form_group_cell" >Phone No (3) : </td>
                                  <td  class="oe_form_group_cell" ><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <input class="form-control" type="text" name="phone3" id="phone3" value="<?=$phone3?>" />
                                  </span></td>
                                  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >Phone No (4) : </td>
                                  <td class="oe_form_group_cell" ><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <input class="form-control" type="text" name="phone4" id="phone4" value="<?=$phone4?>" />
                                  </span></td>
                                </tr>
								  <tr class="oe_form_group_row">
                                  <td  class="oe_form_group_cell oe_form_group_cell_label">Email (1) :</td>
                                  <td  class="oe_form_group_cell oe_form_group_cell_label"><input class="form-control" type="text" name="email" id="email" value="<?=$email?>" /></td>
                                  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >Email (2) :</td>
                                  <td class="oe_form_group_cell" ><span class="oe_form_group_cell oe_form_group_cell_label">
                                    <input class="form-control" type="text" name="email2" id="email2" value="<?=$email2?>" />
                                  </span></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                  <td  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                                  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                  <td class="oe_form_group_cell" >&nbsp;</td>
                                </tr>
                              
								 <tr class="oe_form_group_row">
                                  <td colspan="5" bgcolor="#00CCFF" class="oe_form_group_cell_label oe_form_group_cell"><div align="center"><strong>Personal Information </strong></div></td>
                                </tr>
                                 <tr class="oe_form_group_row">
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                 </tr>
                                 <tr class="oe_form_group_row">
                                   <td  class="oe_form_group_cell" >Date Of Birth </td>
                                   <td  class="oe_form_group_cell" ><input class="form-control" type="date" name="date_of_birth" id="date_of_birth" value="<?=$date_of_birth?>" /></td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >Gender :</td>
                                   <td  class="oe_form_group_cell" ><select name="gender" id="gender" class="form-control">
                                       <option>
                                         <?=$gender?>
                                      </option>
                                       <option>Male</option>
                                       <option>Female</option>
                                       <option>Trangender</option>
                                     </select>                                   </td>
                                 </tr>
                                 <tr class="oe_form_group_row">
                                   <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >Religion :</td>
                                   <td class="oe_form_group_cell" ><select name="religion" class="form-control">
                                       <option selected="selected">
                                         <?=$religion?>
                                       </option>
                                       <option>Islam</option>
                                       <option>Bahai</option>
                                       <option>Buddhism</option>
                                       <option>Christianity</option>
                                       <option>Confucianism </option>
                                       <option>Druze</option>
                                       <option>Hinduism</option>
                                       <option>Jainism</option>
                                       <option>Judaism</option>
                                       <option>Shinto</option>
                                       <option>Sikhism</option>
                                       <option>Taoism</option>
                                       <option>Zoroastrianism</option>
                                       <option>Others</option>
                                     </select>                                   </td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >Blood Group : </td>
                                   <td class="oe_form_group_cell" ><select name="blood_group" id="blood_group" class="form-control">
                                     <option selected="selected">
                                     <?=$blood_group?>
                                     </option>
                                     <option>A+</option>
                                     <option>A-</option>
                                     <option>B+</option>
                                     <option>B-</option>
                                     <option>AB+</option>
                                     <option>AB-</option>
                                     <option>O+</option>
                                     <option>O-</option>
                                   </select></td>
                                 </tr>
                                 <tr class="oe_form_group_row">
                                   <td  class="oe_form_group_cell" >Current Address : </td>
                                   <td  class="oe_form_group_cell" ><textarea class="form-control" name="current_address" id="current_address" ><?=$current_address?></textarea></td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >Permanent Address </td>
                                   <td class="oe_form_group_cell" ><textarea class="form-control" name="permanent_address" id="permanent_address" ><?=$permanent_address?></textarea></td>
                                 </tr>
								   <tr class="oe_form_group_row">
                                   <td  class="oe_form_group_cell" >Home Town  : </td>
                                   <td  class="oe_form_group_cell" ><textarea class="form-control" name="home_town" id="home_town" ><?=$home_town?></textarea></td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >Behavioral Pattern  : </td>
                                   <td  class="oe_form_group_cell" ><textarea class="form-control" name="behaviour" id="behaviour" ><?=$behaviour?></textarea></td>
                                 </tr>
                                 <tr class="oe_form_group_row">
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                 </tr>
                               
								  <tr class="oe_form_group_row">
                                  <td colspan="5" bgcolor="#00CCFF" class="oe_form_group_cell_label oe_form_group_cell"><div align="center"><strong>Medical Information </strong></div></td>
                                </tr>
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" >&nbsp;</td>
                                    <td colspan="4"  class="oe_form_group_cell" >&nbsp;</td>
                                  </tr>
								   <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" >Common Disease : </td>
                                    <td colspan="4"  class="oe_form_group_cell" ><textarea class="form-control" name="common_disease" id="common_disease" ><?=$common_disease?></textarea></td>
                                  </tr>
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" >&nbsp;</td>
                                    <td colspan="4"  class="oe_form_group_cell" >&nbsp;</td>
                                  </tr>
                                 
								  <tr class="oe_form_group_row">
                                  <td colspan="5" bgcolor="#00CCFF" class="oe_form_group_cell_label oe_form_group_cell"><div align="center"><strong>Job History </strong></div></td>
                                </tr>
								
								  <tr class="oe_form_group_row">
								    <td colspan="5"  class="oe_form_group_cell" >&nbsp;</td>
							    </tr>
							    <tr class="oe_form_group_row">
                                    <td colspan="5"  class="oe_form_group_cell" ><textarea class="form-control" name="job_history" id="job_history" ><?=$job_history?></textarea></td>
                                  </tr>
								  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" >&nbsp;</td>
                                    <td  class="oe_form_group_cell" >&nbsp;</td>
                                    <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td class="oe_form_group_cell" >&nbsp;</td>
                                  </tr>
								  <tr class="oe_form_group_row">
                                  <td colspan="5" bgcolor="#00CCFF" class="oe_form_group_cell_label oe_form_group_cell"><div align="center"><strong>Education </strong></div></td>
                                </tr>
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" >&nbsp;</td>
                                    <td  class="oe_form_group_cell" >&nbsp;</td>
                                    <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td class="oe_form_group_cell" >&nbsp;</td>
                                  </tr>
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >Degree 1(Highest) : </td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" ><input  name="degree1" type="text" id="degree1" value="<?=$degree1?>"  class="form-control"/></td>
                                    <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >Degree 2 : </td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" ><input  name="degree2" type="text" id="degree2" value="<?=$degree2?>"  class="form-control"/></td>
                                  </tr>
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >Institute 1 : </td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" ><input  name="institute1" type="text" id="institute1" value="<?=$institute1?>"  class="form-control"/></td>
                                    <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >Institute 2 : </td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" ><input  name="institute2" type="text" id="institute2" value="<?=$institute2?>"  class="form-control"/></td>
                                  </tr>
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >Year : </td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >
									
									<input  name="pass_year1" type="text" id="pass_year1" value="<?=$pass_year1?>"  class="form-control"/></td>
                                    <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >Year : </td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" ><input  name="pass_year2" type="text" id="pass_year2" value="<?=$pass_year2?>"  class="form-control"/></td>
                                  </tr>
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" >&nbsp;</td>
                                    <td  class="oe_form_group_cell" >&nbsp;</td>
                                    <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td class="oe_form_group_cell" >&nbsp;</td>
                                  </tr>
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >Degree 3 : </td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" ><input  name="degree3" type="text" id="degree3" value="<?=$degree3?>"  class="form-control"/></td>
                                    <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >HSC College  : </td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" ><input  name="hsc_college" type="text" id="hsc_college" value="<?=$hsc_college?>"  class="form-control"/></td>
                                  </tr>
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >Institute 3 : </td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" ><input  name="institute3" type="text" id="institute3" value="<?=$institute3?>"  class="form-control"/></td>
                                    <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >Year : </td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" ><input  name="hsc_year" type="text" id="hsc_year" value="<?=$hsc_year?>"  class="form-control"/></td>
                                  </tr>
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >Year : </td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" ><input  name="pass_year3" type="text" id="pass_year3" value="<?=$pass_year3?>"  class="form-control"/></td>
                                    <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td  class="oe_form_group_cell"  >&nbsp;</td>
                                    <td  class="oe_form_group_cell" >&nbsp;</td>
                                  </tr>
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" >&nbsp;</td>
                                    <td  class="oe_form_group_cell" >&nbsp;</td>
                                    <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td class="oe_form_group_cell" >&nbsp;</td>
                                  </tr>
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >SSC School  : </td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" ><input  name="ssc_school" type="text" id="ssc_school" value="<?=$ssc_school?>"  class="form-control"/></td>
                                    <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td class="oe_form_group_cell" >&nbsp;</td>
                                  </tr>
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" >Year : </td>
                                    <td  class="oe_form_group_cell" bgcolor="#F0F0F0" ><input  name="ssc_year" type="text" id="ssc_year" value="<?=$ssc_year?>"  class="form-control"/></td>
                                    <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td class="oe_form_group_cell" >&nbsp;</td>
                                  </tr>
                                  
                                  <tr class="oe_form_group_row">
                                    <td  class="oe_form_group_cell" >&nbsp;</td>
                                    <td  class="oe_form_group_cell" >&nbsp;</td>
                                    <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                    <td class="oe_form_group_cell" >&nbsp;</td>
                                  </tr>
								  <tr class="oe_form_group_row">
                                  <td colspan="5" bgcolor="#00CCFF" class="oe_form_group_cell_label oe_form_group_cell"><div align="center"><strong>Training </strong></div></td>
                                </tr>
                                 <tr class="oe_form_group_row">
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td class="oe_form_group_cell" >&nbsp;</td>
                                 </tr>
                                 <tr class="oe_form_group_row">
                                   <td  class="oe_form_group_cell" >Training 1 </td>
                                   <td  class="oe_form_group_cell" ><input  name="trainning1" type="text" id="trainning1" value="<?=$trainning1?>"  class="form-control"/></td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >Training 2 </td>
                                   <td class="oe_form_group_cell" ><input  name="trainning2" type="text" id="trainning2" value="<?=$trainning2?>"  class="form-control"/></td>
                                 </tr>
                                 <tr class="oe_form_group_row">
                                   <td  class="oe_form_group_cell" >Training 3 </td>
                                   <td  class="oe_form_group_cell" ><input  name="trainning3" type="text" id="trainning3" value="<?=$trainning3?>"  class="form-control"/></td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >Training 4 </td>
                                   <td class="oe_form_group_cell" ><input  name="trainning4" type="text" id="trainning4" value="<?=$trainning4?>"  class="form-control"/></td>
                                 </tr>
                                 <tr class="oe_form_group_row">
                                   <td  class="oe_form_group_cell" >Training 5 </td>
                                   <td  class="oe_form_group_cell" ><input  name="trainning5" type="text" id="trainning5" value="<?=$trainning5?>"  class="form-control"/></td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td class="oe_form_group_cell" >&nbsp;</td>
                                 </tr>
                                 <tr class="oe_form_group_row">
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td class="oe_form_group_cell" >&nbsp;</td>
                                 </tr>
								 <tr class="oe_form_group_row">
                                  <td colspan="5" bgcolor="#00CCFF" class="oe_form_group_cell_label oe_form_group_cell"><div align="center"><strong>Family Information </strong></div></td>
                                </tr>
                                 <tr class="oe_form_group_row">
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td class="oe_form_group_cell" >&nbsp;</td>
                                 </tr>
                                 
                                 
                                <tr class="oe_form_group_row">
                                  <td  class="oe_form_group_cell" >Father's Name :</td>
                                  <td  class="oe_form_group_cell" ><input  name="father_name" type="text" id="father_name" value="<?=$father_name?>"  class="form-control"/></td>
                                  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >Mother's Name :</td>
                                  <td class="oe_form_group_cell" ><input  name="mother_name" type="text" id="mother_name" value="<?=$mother_name?>"  class="form-control"/></td>
                                </tr>
								<tr class="oe_form_group_row">
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >Spouse Name</td>
								  <td class="oe_form_group_cell" ><input class="form-control" name="spouse_name" type="text" id="spouse_name" value="<?=$spouse_name?>" /></td>
								  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >Spouse Qualification </td>
								  <td class="oe_form_group_cell" ><input class="form-control" name="spouse_qualify" type="text" id="spouse_qualify" value="<?=$spouse_qualify?>" /></td>
								</tr>
								<tr class="oe_form_group_row">
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >Spouse DoB </td>
								  <td class="oe_form_group_cell" ><input class="form-control" name="spouse_dob" type="text" id="spouse_dob" value="<?=$spouse_dob?>" /></td>
								  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td class="oe_form_group_cell" >&nbsp;</td>
							    </tr>
								<tr class="oe_form_group_row">
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td class="oe_form_group_cell" >&nbsp;</td>
							    </tr>
								 <tr class="oe_form_group_row">
                                  <td colspan="5" bgcolor="#00CCFF" class="oe_form_group_cell_label oe_form_group_cell"><div align="center"><strong>Having Communication With </strong></div></td>
                                </tr>
								<tr class="oe_form_group_row">
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td class="oe_form_group_cell" >&nbsp;</td>
							    </tr>
								
								
								<?
								
								$selects = ' select PBI_ID from crm_having_com where dealer_code="'.$$unique.'"';
								$querys = db_query($selects);
								while($rows = mysqli_fetch_object($querys )){
								
								?>
								
								<tr class="oe_form_group_row">
								<td>&emsp;</td>
								  <td colspan="3"  class="oe_form_group_cell" >
								  
								  
								  
								 <? 
								 
								 	 $select1 = ' select p.PBI_ID,p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as designation from personnel_basic_info p  where p.PBI_ID="'.$rows->PBI_ID.'" and  p.PBI_JOB_STATUS="In Service" ';
								 ?>
								  
        <select id="selectpicker" class="selectpicker" name="having_com[]" data-live-search="true">
		
		
		<?
		
	
		
		$query1 = db_query($select1);
		$row1 = mysqli_fetch_object($query1);
		?>
		
		
		<option value="<?=$row1->PBI_ID?>"><?=$row1->PBI_NAME?>&ensp;|&ensp; <?=$row1->department?>&ensp;|&ensp; <?=$row1->designation?></option>
		<option value=""></option>
		 <? 
								 
								 	 $select1 = ' select p.PBI_ID,p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as designation from personnel_basic_info p where p.PBI_JOB_STATUS="In Service" ';
							
	
		
		$query1 = db_query($select1);
		while($row1 = mysqli_fetch_object($query1)){
		?>
		
		
		<option value="<?=$row1->PBI_ID?>"><?=$row1->PBI_NAME?>&ensp;|&ensp; <?=$row1->department?>&ensp;|&ensp; <?=$row1->designation?></option>
		
		<? } ?>
		
        </select>
     					  
								  
								    
								  </td>
								  <td>&emsp;</td>
							    </tr>
								
								<? } ?>
								
								
								<tr class="oe_form_group_row">
								<td>&emsp;</td>
								  <td colspan="3"  class="oe_form_group_cell" >
								  
								  
								  
								  
								 <? 
								 
								 	 $select1 = ' select p.PBI_ID,p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as designation from personnel_basic_info p where p.PBI_JOB_STATUS="In Service" ';
								 ?>
								  
        <select id="selectpicker" class="selectpicker" name="having_com[]" data-live-search="true">
		
		
		<option value=""></option>
		<?
		
	
		
		$query1 = db_query($select1);
		while($row1 = mysqli_fetch_object($query1)){
		?>
		
		
		<option value="<?=$row1->PBI_ID?>"><?=$row1->PBI_NAME?>&ensp;|&ensp; <?=$row1->department?>&ensp;|&ensp; <?=$row1->designation?></option>
		
		<? } ?>
        </select>
     					  
								  
								    
								  </td>
								  <td>&emsp;</td>
							    </tr>
								
								<tr class="oe_form_group_row">
								<td>&emsp;</td>
								  <td colspan="3"  class="oe_form_group_cell" >
								  
								 <? 
								 
								 	 $select1 = ' select p.PBI_ID,p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as designation from personnel_basic_info p where p.PBI_JOB_STATUS="In Service" ';
								 ?>
								  
        <select id="selectpicker" class="selectpicker" name="having_com[]" data-live-search="true">
		
		<option value=""></option>
		
		<?
		
	
		
		$query1 = db_query($select1);
		while($row1 = mysqli_fetch_object($query1)){
		?>
		
		
		<option value="<?=$row1->PBI_ID?>"><?=$row1->PBI_NAME?>&ensp;|&ensp; <?=$row1->department?>&ensp;|&ensp; <?=$row1->designation?></option>
		
		<? } ?>
        </select>
     					  
								  
								    
								  </td>
								  <td>&emsp;</td>
							    </tr>
								
								<tr class="oe_form_group_row">
								<td>&emsp;</td>
								  <td colspan="3"  class="oe_form_group_cell" >
								  
								 <? 
								 
								 	 $select1 = ' select p.PBI_ID,p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as designation from personnel_basic_info p where p.PBI_JOB_STATUS="In Service" ';
								 ?>
								  
        <select id="selectpicker" class="selectpicker" name="having_com[]" data-live-search="true">
		
		<option value=""></option>
		
		<?
		
	
		
		$query1 = db_query($select1);
		while($row1 = mysqli_fetch_object($query1)){
		?>
		
		
		<option value="<?=$row1->PBI_ID?>"><?=$row1->PBI_NAME?>&ensp;|&ensp; <?=$row1->department?>&ensp;|&ensp; <?=$row1->designation?></option>
		
		<? } ?>
        </select>
     					  
								  
								    
								  </td>
								  <td>&emsp;</td>
							    </tr>
								<tr class="oe_form_group_row">
								<td>&emsp;</td>
								  <td colspan="3"  class="oe_form_group_cell" >
								  
								 <? 
								 
								 	 $select1 = ' select p.PBI_ID,p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as designation from personnel_basic_info p where p.PBI_JOB_STATUS="In Service" ';
								 ?>
								  
        <select id="selectpicker" class="selectpicker" name="having_com[]" data-live-search="true">
		
		<option value=""></option>
		
		<?
		
	
		
		$query1 = db_query($select1);
		while($row1 = mysqli_fetch_object($query1)){
		?>
		
		
		<option value="<?=$row1->PBI_ID?>"><?=$row1->PBI_NAME?>&ensp;|&ensp; <?=$row1->department?>&ensp;|&ensp; <?=$row1->designation?></option>
		
		<? } ?>
        </select>
     					  
								  
								    
								  </td>
								  <td>&emsp;</td>
							    </tr>
								<tr class="oe_form_group_row">
								<td>&emsp;</td>
								  <td colspan="3"  class="oe_form_group_cell" >
								  
								 <? 
								 
								 	 $select1 = ' select p.PBI_ID,p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as designation from personnel_basic_info p where p.PBI_JOB_STATUS="In Service" ';
								 ?>
								  
        <select id="selectpicker" class="selectpicker" name="having_com[]" data-live-search="true">
		
		<option value=""></option>
		
		<?
		
	
		
		$query1 = db_query($select1);
		while($row1 = mysqli_fetch_object($query1)){
		?>
		
		<option value="<?=$row1->PBI_ID?>"><?=$row1->PBI_NAME?>&ensp;|&ensp; <?=$row1->department?>&ensp;|&ensp; <?=$row1->designation?></option>
		
		<? } ?>
        </select>
     					  
								  
								    
								  </td>
								  <td>&emsp;</td>
							    </tr>
								
								
								
								
								<tr class="oe_form_group_row">
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td class="oe_form_group_cell" >&nbsp;</td>
							    </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="5" bgcolor="#00CCFF" class="oe_form_group_cell_label oe_form_group_cell"><div align="center"><strong>Social Media Link </strong></div></td>
                                </tr>
								<tr class="oe_form_group_row">
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td class="oe_form_group_cell" >&nbsp;</td>
							    </tr>
								<tr class="oe_form_group_row">
								  <td  class="oe_form_group_cell" >Facebook</td>
								  <td  class="oe_form_group_cell" ><input class="form-control" name="facebook" type="text" id="facebook" value="<?=$facebook?>" /></td>
								  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >Linkedin</td>
								  <td class="oe_form_group_cell" ><input class="form-control" name="linkedin" type="text" id="linkedin" value="<?=$linkedin?>" /></td>
							    </tr>
								<tr class="oe_form_group_row">
								  <td  class="oe_form_group_cell" >Others</td>
								  <td  class="oe_form_group_cell" ><input class="form-control" name="other_social" type="text" id="other_social" value="<?=$other_social?>" /></td>
								  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td class="oe_form_group_cell" >&nbsp;</td>
							    </tr>
								<tr class="oe_form_group_row">
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td class="oe_form_group_cell" >&nbsp;</td>
							    </tr>
								<tr class="oe_form_group_row">
                                  <td colspan="5" bgcolor="#00CCFF" class="oe_form_group_cell_label oe_form_group_cell"><div align="center"><strong>Affiliation With REVERIE </strong></div></td>
                                </tr>
								<tr class="oe_form_group_row">
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td class="oe_form_group_cell" >&nbsp;</td>
							    </tr>
								<tr class="oe_form_group_row">
								  <td colspan="5"  class="oe_form_group_cell" ><textarea style="margin-top: 10px;" class="form-control" name="aff_reverie" id="aff_reverie" ><?=$aff_reverie?></textarea></td>
							    </tr>
								<tr class="oe_form_group_row">
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td class="oe_form_group_cell" >&nbsp;</td>
							    </tr>
								<tr class="oe_form_group_row">
                                  <td colspan="5" bgcolor="#00CCFF" class="oe_form_group_cell_label oe_form_group_cell"><div align="center"><strong>Other Notes </strong></div></td>
                                </tr>
								<tr class="oe_form_group_row">
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td  class="oe_form_group_cell" >&nbsp;</td>
								  <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
								  <td class="oe_form_group_cell" >&nbsp;</td>
							    </tr>
								<tr class="oe_form_group_row">
								  <td colspan="5"  class="oe_form_group_cell" ><textarea style="margin-top: 10px;" class="form-control" name="others_notes" id="others_notes" ><?=$others_notes?></textarea></td>
							    </tr>
								<tr class="oe_form_group_row">
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td  class="oe_form_group_cell" >&nbsp;</td>
                                   <td class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" >&nbsp;</td>
                                   <td class="oe_form_group_cell" >&nbsp;</td>
                                 </tr>
                              </tbody>
                            </table></td>
                        </tr>
                      </tbody>
                    </table>
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
<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>
