<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Requisition Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'requisition_fg_master';
$unique = 'req_no';
$status = 'UNCHECKED';
$target_url = '../fr/mr_print_view.php';

?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
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
                    <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Request From:</label>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                        <select name="warehouse_id" id="warehouse_id" >
	  <? if($_POST['warehouse_id']!=''){ ?><option value="<?=$_POST['warehouse_id']?>"><?=find_a_field('warehouse','warehouse_name','warehouse_id="'.$_POST['warehouse_id'].'"');?></option> <? }?>
	  <option></option>
	  <? foreign_relation('warehouse w, warehouse_define d','w.warehouse_id','w.warehouse_name',$warehouse_id,'1 and d.user_id="'.$_SESSION['user']['id'].'" and w.warehouse_id=d.warehouse_id');?>
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
if(isset($_POST['submitit'])){
    
if($_POST['status']!=''&&$_POST['status']!='ALL') $con .= 'and a.status="'.$_POST['status'].'"';

if($_POST['warehouse_id']>0) { $wcon= ' and a.warehouse_id="'.$_POST['warehouse_id'].'"'; }


if($_POST['fdate']!='' && $_POST['tdate']!='')
$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

$wh_sql="SELECT GROUP_CONCAT(DISTINCT w.warehouse_id) as defined_wh FROM `warehouse_define` w where w.user_id='".$_SESSION['user']['id']."'  ";
	 
	 $wh_conn=db_query($wh_sql);
	 
	 $data=mysqli_fetch_object($wh_conn);
	 
	 if($data->defined_wh !=''){
	 	$wh_con2 = ' and b.warehouse_id in ('.$data->defined_wh.','.$_SESSION['user']['depot'].') ';
	 }

 $res='select a.req_no,a.req_no, a.req_date,(select group_name from user_group where id=a.group_for) as company,
(select warehouse_name from warehouse where warehouse_id=a.warehouse_id) warehouse_from,
b.warehouse_name as warehouse_to, a.req_note as note, a.need_by, c.fname as entry_by, a.entry_at,a.status 

from requisition_fg_master a, warehouse b, user_activity_management c 

where  a.warehouse_to=b.warehouse_id and a.entry_by=c.user_id 
'.$con.$wcon.$wh_con.' 
and a.status not in ("MANUAL","UNCHECKED") order by a.req_no desc';


echo link_report($res,'mr_print_view.php');
}
?>
</div></td>
</tr>
</table>













<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>