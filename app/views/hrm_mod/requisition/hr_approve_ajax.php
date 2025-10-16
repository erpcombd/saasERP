<?
session_start();
require "../../config/inc.all.php";

function findall($sql){
    $res=@db_query($sql);
    $count=@mysqli_num_rows($res);
    
    if($count>0)
        {
        $data=@mysqli_fetch_object($res);
        return $data;
        }
    else
        return NULL;
    }

$crud      =new crud('hrm_requisition');
$unique = 'id';
$mon=$_GET['mon'];
$year=$_GET['year'];



$_POST[$unique] = $$unique = find_a_field('hrm_requisition','id','dealer_code="'.$_REQUEST['dealer_code'].'" and mon="'.$_REQUEST['mon'].'" 
and year="'.$_REQUEST['year'].'" ');

//$_REQUEST['dealer_code'] = $_REQUEST['ot'];
//$_REQUEST['ot'] = 0;
if($$unique>0){

// auto Employee code open in Basic Information
$dealer_code = $_REQUEST['dealer_code'];
$dealer_info = findall('select * from dealer_info where dealer_code="'.$dealer_code.'"');

$PBI_ID =  $_REQUEST['emp_code'];
$PBI_NAME =  $_REQUEST['emp_name'];
$PBI_MOBILE =  $_REQUEST['emp_mobile'];

$entry_at=date('Y-m-d H:i:s');
$entry_by=$_SESSION['user']['id'];

$check = find_a_field('personnel_basic_info','PBI_ID','PBI_ID="'.$PBI_ID.'"');
if($check>0) die("Duplicate Code");

$isql = "INSERT INTO personnel_basic_info (
PBI_ID ,PBI_ORG,PBI_NAME,DEPT_ID,PBI_DEPARTMENT,DESG_ID,PBI_DESIGNATION,
PBI_BRANCH,PBI_ZONE,PBI_AREA,PBI_GROUP,dealer_code,
PBI_MOBILE,PBI_JOB_STATUS,entry_at,entry_by
)VALUE(
'$PBI_ID',2,'$PBI_NAME',1,'Sales','185','SO',
'$dealer_info->region_id','$dealer_info->zone_id','$dealer_info->area_code','$dealer_info->product_group','$dealer_code',
'$PBI_MOBILE','In Service','$entry_at','$entry_by'
)";
db_query($isql);
// end auto code open



// update status
$_REQUEST['status']='send';
$_REQUEST['send_by']=$_SESSION['user']['id'];
$_REQUEST['send_at']=date('Y-m-d H:i:s');
echo 'Done';
$crud->update($unique);

}

?>