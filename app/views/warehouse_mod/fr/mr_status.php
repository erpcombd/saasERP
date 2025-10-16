<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$c_id = $_SESSION['proj_id'];
$title='FG Requisition Status';


do_calander('#fdate');
do_calander('#tdate');


$table = 'requisition_fg_master';
$unique = 'req_no';
$status = 'UNCHECKED';
$target_url = 'fr_print_view.php';


?>

<script language="javascript">

function custom(theUrl,c_id){
	window.open('<?=$target_url?>?c='+encodeURIComponent(c_id)+'&v='+ encodeURIComponent(theUrl));
}

</script>




<div class="form-container_large">

	<form action="" method="post" name="codz" id="codz">

        <div class="container-fluid bg-form-titel">
            <div class="row">
    <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1 p-0">
                <div class="form-group row m-0">
                    
                    
                    
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                         <input type="text" name="fdate" id="fdate" value="<?=$_POST['fdate']?$_POST['fdate']:date('Y-m-01');?>" class="hasDatepicker">
                         
                         
                         
                    </div>
                </div>

            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1  p-0">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate']?$_POST['tdate']:date('Y-m-d');?>" class="hasDatepicker">

                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1  p-0">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company To : </label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                       <select name="group_for" id="group_for" >
                        <option value="<?=$_POST['group_for']?>"><?=find_a_field('user_group','group_name','id="'.$_POST['group_for'].'"');?></option>
                     <? user_company_access($group_for); ?>
                        <option></option>
                        </select>
                    </div>
                </div>

            </div>
            
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1  p-0">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Status:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
            <select name="status" id="status" >
    <option><?=$_POST['status']?></option>
    <option>CHECKED</option>
    <option>PENDING</option>
    <option>COMPLETE</option>
	</select>
            
            
            </div>
            </div>
            </div>
            
            
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1  p-0">
                <div class="form-group row m-0">
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse To:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <select name="warehouse_id" id="warehouse_id" >
	  <? if($_POST['warehouse_id']!=''){ ?><option value="<?=$_POST['warehouse_id']?>"><?=find_a_field('warehouse','warehouse_id','warehouse_id="'.$_POST['warehouse_id'].'"');?></option> <? }?>
	  <option></option>
	  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','1 and warehouse_id!="'.$_SESSION['user']['depot'].'" and use_type="WH"');?>
	</select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center">
		<input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input">
		
    </div>
</div>
        </div>







        <div class="container-fluid pt-5 p-0 ">
		
			

        </div>
    </form>
</div>











<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td><div class="tabledesign2">

<? 

if($_POST['status']!=''&&$_POST['status']!='ALL')
$con.= ' and a.status="'.$_POST['status'].'"';

if($_POST['group_for']>0) { $company_con= ' and a.group_for="'.$_POST['group_for'].'"'; }
if($_POST['warehouse_id']>0) { $wcon= ' and a.warehouse_to="'.$_POST['warehouse_id'].'"'; }


if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['status']!=''){ 
    $status_con='and a.status ="'.$_POST['status'].'" '; 
}else{
    $status_con='and a.status in ("CHECKED","COMPLETE","PENDING") '; 
}

if($_SESSION['user']['level']==5){

 $res='select a.req_no,a.req_no,a.req_date, b.warehouse_name as warehouse_from, 
(select warehouse_name from warehouse where warehouse_id=a.warehouse_to) as warehouse_to,
(select id from user_group where id=a.group_for) as company, a.is_reqno as req_no,a.req_note as note,a.status, a.need_by, c.fname as entry_by 

from requisition_fg_master a, warehouse b, user_activity_management c 

where a.warehouse_id=b.warehouse_id and a.entry_by=c.user_id '.$con.$wcon.$status_con.$company_con.' 
 
order by a.req_no desc';

    
}else{
    
$res='select a.req_no,a.req_no,a.req_date, b.warehouse_name as warehouse_from, 
(select warehouse_name from warehouse where warehouse_id=a.warehouse_to) as warehouse_to,
(select id from user_group where id=a.group_for) as company, a.is_reqno as req_no,a.req_note as note,a.status, a.need_by, c.fname as entry_by 

from requisition_fg_master a, warehouse b, user_activity_management c 

where a.warehouse_id=b.warehouse_id and a.entry_by=c.user_id 
and a.warehouse_id="'.$_SESSION['user']['depot'].'"
'.$con.$wcon.$status_con.$company_con.' 
 
order by a.req_no desc';

}
echo link_report2($res,'fr_print_view.php',$c_id);

?>

</div></td>

</tr>

</table>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>