<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

do_calander('#roster_date');

$title='Shift Schedule View'; 

if(isset($_POST['save']))
{		
		//if($_POST['designation']>0) $con .=' and a.PBI_DESIGNATION='.$_POST['designation'];
		if($_POST['department']>0) 		$con .=' and a.DEPT_ID='.$_POST['department'];
		if($_POST['job_location']>0) 	$con .=' and a.JOB_LOCATION='.$_POST['job_location'];
		if($_POST['group_for']>0) 		$con .=' and a.PBI_ORG='.$_POST['group_for'];
		if($_POST['PBI_DOMAIN']!='')	$con .=' and a.PBI_DOMAIN="'.$_POST['PBI_DOMAIN'].'"';
		
		 $sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,d.DEPT_DESC as PBI_DEPARTMENT from 
		personnel_basic_info a,department d
		where  1 ".$con." and d.DEPT_ID=a.DEPT_ID  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";
		
		$query = db_query($sql);
		while($info=mysqli_fetch_object($query))
		{
		
$r_date = $rp1_date = $rp2_date = $rp3_date = $_POST['roster_date'];
$re_date = date('Y-m-d',strtotime($r_date)+(6*86400));
		
		$roster_date = $_POST['roster_date'];
		$entry_by = $_SESSION['user']['id'];
		
		while(strtotime($rp3_date) <= strtotime($re_date)){ 

		$point = $_POST['p_'.$info->PBI_ID];
		$shedule = $_POST['s_'.$info->PBI_ID.'_'.$rp3_date];
		
		if($shedule>0){
		$del_sql = "delete from hrm_roster_allocation where PBI_ID='".$info->PBI_ID."' and roster_date = '".$rp3_date."'";
		db_query($del_sql);
		 $insSql = 'INSERT INTO hrm_roster_allocation( PBI_ID, roster_date, point_1, shedule_1, job_location,group_for, entry_by) 
		 VALUES ("'.$info->PBI_ID.'", "'.$rp3_date.'", "'.$point.'", "'.$shedule.'", "'.$_POST['job_location'].'", "'.$_POST['group_for'].'", "'.$entry_by.'")';
		db_query($insSql);
		}
 $rp3_date = date ("Y-m-d", strtotime("+1 day", strtotime($rp3_date)));} 
			}
		}

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

	function update_value(id,rdate)
	{
var PBI_ID=id; // Rent
var rdate = rdate;
var sdate=document.getElementById('sdate').value;
var tdate=document.getElementById('tdate').value;
var type =document.getElementById('s_'+id+"_"+rdate).value;
var strURL="roster_ajax.php?PBI_ID="+PBI_ID+"&sdate="+sdate+"&tdate="+tdate+"&type="+type;

		var req = getXMLHTTP();

		if (req) {
			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+id).style.display='inline';

						document.getElementById('divi_'+id).innerHTML=req.responseText;						

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

<div class="form-container_large">
<h4 class="text-center bg-titel bold pt-2 pb-2"> Select Option </h4>
<form action="?"  method="post">
<div class="container-fluid bg-form-titel">
  <div class="row">
    <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
      <div class="form-group row m-0">
        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Start Date Form:</label>
        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
          <input name="roster_date" type="text"  class="form-control" id="roster_date" autocomplete="off" value="<?=$_POST['roster_date']?>" required="required" />
        </div>
      </div>
    </div>
    <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
      <div class="form-group row m-0">
        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department/Section</label>
        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
          <select name="department"  class="form-control" id="department">
            <? foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['department'],' 1 order by DEPT_DESC');?>
          </select>
        </div>
      </div>
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
      <input name="create" id="create" value="SHOW EMPLOYEE" type="submit" class="btn1 btn1-submit-input">
    </div>
  </div>
</div>
<? 
						
$r_date = $rp1_date = $rp2_date = $rp3_date = $_POST['roster_date'];
$re_date = date('Y-m-d',strtotime($r_date)+(6*86400));

						?>
<br />
<table class="table1  table-striped table-bordered table-hover table-sm">
  <thead class="thead1">
    <tr class="bgc-info">
      <th rowspan="2">Code</th>
      <th rowspan="2">Full Name</th>
      <th rowspan="2">Desg</th>
      <th rowspan="2">Dept</th>
      <th rowspan="2">LOC</th>
      <? while(strtotime($rp1_date) <= strtotime($re_date)){ ?>
      <th><?=$rp1_date?></th>
      <? $rp1_date = date ("Y-m-d", strtotime("+1 day", strtotime($rp1_date)));} ?>
    </tr>
    <tr>
      <? while(strtotime($rp3_date) <= strtotime($re_date)){ ?>
      <th class="bgc-info">SCH</th>
      <? $rp3_date = date ("Y-m-d", strtotime("+1 day", strtotime($rp3_date)));} ?>
    </tr>
  </thead>
  <tbody class="tbody1">
    <?
	     if(isset($_POST['create'])){
		//if($_POST['designation']>0) 		$con .=' and a.PBI_DESIGNATION='.$_POST['designation'];
		if($_POST['department']>0)			$con .=' and a.DEPT_ID='.$_POST['department'];
		if($_POST['job_location']>0)		$con .=' and a.JOB_LOCATION='.$_POST['job_location'];
		if($_POST['group_for']>0)			$con .=' and a.PBI_ORG='.$_POST['group_for'];
		if($_POST['PBI_DOMAIN']!='')		$con .=' and a.PBI_DOMAIN="'.$_POST['PBI_DOMAIN'].'"';
		
		$show=1;
		
		 $sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_CODE,g.DESG_DESC as PBI_DESIGNATION,d.DEPT_DESC as PBI_DEPARTMENT from personnel_basic_info a,department d,designation g
		where  1 ".$con." and a.DEPT_ID=d.DEPT_ID and a.DESG_ID=g.DESG_ID and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";
		
		$query = db_query($sql);
		
		while($info=mysqli_fetch_object($query))
		{
		$rp2_date = $r_date;
		
		$ros = "select * from hrm_roster_allocation where PBI_ID='".$info->PBI_ID."' and roster_date between '".$r_date."' and '".$re_date."' ";
		$ros_r = db_query($ros);
		while($roster = mysqli_fetch_object($ros_r)){
		$point[$roster->PBI_ID]=$roster->point_1;

		$shedule[$roster->PBI_ID][$roster->roster_date]=$roster->shedule_1;

		
		}
		?>
    <tr>
      <td><?=$info->PBI_CODE?>
        <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" />
        <input type="hidden" name="sdate" id="sdate" value="<?=$r_date?>" />
        <input type="hidden" name="tdate" id="tdate" value="<?=$re_date?>" /></td>
      <td><?=$info->PBI_NAME?></td>
      <td><?=$info->PBI_DESIGNATION?></td>
      <td><?=$info->PBI_DEPARTMENT?></td>
      <td><!--<select name="p_<?=$info->
        PBI_ID?>" id="p_
        <?=$info->PBI_ID?>
        " style="width:70px; font-size:12px;">
        <? foreign_relation('hrm_roster_point','id','point_short_name',$point[$info->PBI_ID],'group_for = "'.$_POST['group_for'].'"');?>
        </select>
        --> </td>
      <td><select name="s_<?=$info->PBI_ID?>_<?=$rp2_date?>" id="s_<?=$info->PBI_ID?>_<?=$rp2_date?>" onchange="update_value(<?=$info->PBI_ID?>,'<?=$r_date?>')">
          <option></option>
          <? foreign_relation('hrm_schedule_info','id','schedule_name',$shedule[$info->PBI_ID][$rp2_date]);?>
        </select>
        <? $rp2_date = date ("Y-m-d", strtotime("+1 day", strtotime($rp2_date)));?>
      </td>
      <td colspan="6"><span id="divi_<?=$info->PBI_ID?>">
        <table>
          <tr>
            <? while (strtotime($rp2_date) <= strtotime($re_date)){ ?>
            <td><select name="s_<?=$info->PBI_ID?>_<?=$rp2_date?>" id="s_<?=$info->PBI_ID?>_<?=$rp2_date?>">
                <option></option>
                <? foreign_relation('hrm_schedule_info','id','schedule_name',$shedule[$info->PBI_ID][$rp2_date]);?>
              </select></td>
            <? $rp2_date = date ("Y-m-d", strtotime("+1 day", strtotime($rp2_date)));   } ?>
          </tr>
        </table>
        </span></td>
    </tr>
    <?	} }?>
  </tbody>
</table>
<div class="n-form-btn-class">
  <? if($show>0){?>
  <input name="save" type="submit" id="save" value="SET SCHEDULE" class="btn1 btn1-submit-input"/>
  <? } ?>
</div>
</div>
<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>
