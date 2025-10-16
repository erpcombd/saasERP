<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../../../../public/assets/css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Increment Edit ';
?>
<script>
function getXMLHTTP() { //fuction to return the xml http object

		var xmlhttp=false;	


		try{

			xmlhttp=new XMLHttpRequest();

		}

		catch(e)	{		

			try{			

				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){
				try{

				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

				}

				catch(e1){

					xmlhttp=false;

				}

			}
	}

		return xmlhttp;

    }
	
	

function approve_data(id)

{
var inc_id=id;  
 
 
//var item_id=document.getElementById('item_id'+id).value;
var PBI_ID=document.getElementById('PBI_ID_'+id).value;
var inc_id=document.getElementById('inc_id_'+id).value;

 
var strURL="update_ajax.php?PBI_ID="+PBI_ID+"&inc_id="+inc_id;
		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {
		if (req.readyState == 4) {
		// only if "OK"

					if (req.status == 200) {						
						document.getElementById('pv'+id).style.display='inline';
						document.getElementById('pv'+id).innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}

			req.open("GET", strURL, true);
			req.send(null);
		}	




}

function delete_data(id)

{

var inc_id=id;  
 
 
//var item_id=document.getElementById('item_id'+id).value;
var PBI_ID=document.getElementById('PBI_ID_'+id).value;
var inc_id=document.getElementById('inc_id_'+id).value;

 
var strURL="delete_ajax.php?PBI_ID="+PBI_ID+"&inc_id="+inc_id;
		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {
		if (req.readyState == 4) {
		// only if "OK"

					if (req.status == 200) {						
						document.getElementById('pv'+id).style.display='inline';
						document.getElementById('pv'+id).innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}

			req.open("GET", strURL, true);
			req.send(null);
		}	




}


</script>

<?  
if(isset($_POST['search']))
{


$display = $_POST['check_list'];

foreach ( $display as $key  ) {

 $delete_query = 'DELETE FROM salary_holy_day_individual WHERE PBI_ID = "' . $key . '"  AND holy_day = "' .$_POST['s_date']. '"';
db_query($delete_query);

         } 


}



?>
<style type="text/css">



</style>
<!--Three input table-->
<div class="form-container_large">
 
  <form action="?"  method="post">
  
   <? include('../common/title_bar_bulk_upload.php');?>
   
     
    <!--  ******************* NEW SECTION  *********************-->
	  <?  	if(isset($_POST['button'])){ ?>
	  
    <div class="container-fluid bg-form-titel">
      <!--<div class="row">
	  
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Select Holiday Delete Date : </label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
              <input type="date" name="s_date" autocomplete="off" id="s_date" style="width:50%;" class="form-control" />
			
            </div>
          </div>
        </div>
		
		
		
		
		
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <input name="search" id="search" value="Delete" type="submit" class="btn btn-danger">
        </div>
      </div>-->
    </div>
    <!-- END NEW SECTION-->
  
    <div class="container-fluid pt-5 p-0 ">
      <table class="table1  table-striped table-bordered table-hover table-sm">
        <thead class="thead1">
          <tr class="bgc-info">
            
            <th>ID NO</th>
            <th>Full Name</th>
            <th>Designation</th>
            <th>Department</th>
		
            <th> Effective Date  </th>
			<th>Increment Amount</th>
            <th>  Action </th>
          </tr>
        </thead>
        <tbody class="tbody1">
          <?

					
                            if($_POST['PBI_CODE']!="") $codeConn = " and a.PBI_CODE='".$_POST['PBI_CODE']."'";
                            if($_POST['PBI_IDD']!="") $idConn = " and a.PBI_ID ='".$_POST['PBI_IDD']."'";
                          
                            if($_POST['PBI_NAME']!="") $NameConn = " and a.PBI_NAME='".$_POST['PBI_NAME']."'";
                            if($_POST['DESG_ID']>0) $desgConn = " and a.DESG_ID='".$_POST['DESG_ID']."'";
                            if($_POST['DEPT_ID']>0) $depConn = " and a.DEPT_ID='".$_POST['DEPT_ID']."'";
                            if($_POST['PBI_SEX']!="") $genderConn = " and a.PBI_SEX='".$_POST['PBI_SEX']."'";
                            if($_POST['grade']>0) $gradeConn = " and a.grade='".$_POST['grade']."'";  
                            if($_POST['work_station']>0) $work_station = " and a.PBI_WORK_STATION='".$_POST['work_station']."'";  
                            
                            
                            
                            if($_POST['PBI_RELIGION']!="") $ReligionConn = " and a.PBI_RELIGION='".$_POST['PBI_RELIGION']."'";
                            if($_POST['PBI_ORG']>0) $OrgConn = " and a.PBI_ORG='".$_POST['PBI_ORG']."'";
                            if($_POST['PBI_JOB_STATUS']!="") $job_statusConn = " and a.PBI_JOB_STATUS='".$_POST['PBI_JOB_STATUS']."'";
                            
                            if($_POST['section']>0) $secConn = " and a.section='".$_POST['section']."'";
                            if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and a.JOB_LOC_ID='".$_POST['JOB_LOC_ID']."'";
                            if($_POST['cost_center']>0) $CostConn = " and a.cost_center='".$_POST['cost_center']."'";
                     
                            
                            if($_POST['class']>0) $classConn = " and a.class='".$_POST['class']."'";
                            if($_POST['line']>0) $lineConn = " and a.line='".$_POST['line']."'";
                            if($_POST['incharge_id']>0) $inchargeConn = " and a.incharge_id='".$_POST['incharge_id']."'";
							
                            if($_POST['DOJ']>0) $DOJConn = " and a.PBI_DOJ='".$_POST['DOJ']."'";
							if($_POST['shedule']>0) $shiftConn = " and b.shedule_1 ='".$_POST['shedule']."'";
                            						
          
							

						   $sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT,a.JOB_LOC_ID, a.PBI_CODE,d.*
						   
						   
						   from 

							personnel_basic_info a,increment_detail d

							where  a.PBI_ID=d.PBI_ID   ".$codeConn.$idConn.$genderConn.$NameConn.$ReligionConn.$DOJConn.$OrgConn.$classConn.$gradeConn.$work_station.
$lineConn.$inchargeConn.$depConn.$desgConn.$secConn.$JoblocConn.$CostConn.$levelConn.$job_statusConn.$shiftConn."  and 
a.PBI_JOB_STATUS='In Service' and d.status='Pending'   order by a.PBI_ID ";

							$query = db_query($sql);

							while($info=mysqli_fetch_object($query))

							{

							
							
						

							?>
          <tr>
              
              	
		
			<td height="26"><?=$info->PBI_CODE?>
              <input type="hidden" name="PBI_ID_<?=$info->INCREMENT_D_ID?>" id="PBI_ID_<?=$info->INCREMENT_D_ID?>" value="<?=$info->PBI_ID?>" />
			  <input type="hidden" name="inc_id_<?=$info->INCREMENT_D_ID?>" id="inc_id_<?=$info->INCREMENT_D_ID?>" value="<?=$info->INCREMENT_D_ID?>" />
		    </td>
            <td><?=$info->PBI_NAME?></td>
            <td><?=$info->PBI_DESIGNATION?></td>
            <td><?=$info->PBI_DEPARTMENT?></td>
			<td> <?=$info->INCREMENT_EFFECT_DATE;?> </td> 
			<td><?=$info->INCREMENT_AMT?></td> 
			
            <td><div id="pv<?=$info->INCREMENT_D_ID?>">
			<a href="increment_edits.php?id=<?=$info->INCREMENT_D_ID?>&pbi_id=<?=$info->PBI_ID;?>" target="_blank"><input type="button" name="edit" value="Edit" class="btn1 btn1-bg-help" /></a> 
			<input type="button" name="Delete" value="Delete" onclick="delete_data(<?=$info->INCREMENT_D_ID?>)" class="btn1 btn1-bg-cancel" />
			 <input type="button" name="" value="Approved" onclick="approve_data(<?=$info->INCREMENT_D_ID?>)" class="btn1 btn1-bg-submit" /></div></td>
          </tr>
          <?  }   ?>
		
		
		   
        </tbody>
      </table>
  
    </div>
    <?  } ?>
    
    
    
  </form>
</div>

  

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
