<?php
require_once "../../../assets/template/layout.top.php";
$title='Unfinished Depot Transfer';

$table = 'production_issue_master';
$unique = 'pi_no';
$status = 'MANUAL';
$target_url = '../depot_transfer/depot_transfer_entry.php';


$table_master='production_issue_master';
$unique_master='pi_no';

$table_detail='production_issue_detail';
$unique_detail='id';

$$unique_master=$_POST[$unique_master];

if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='UNSEND';
		$pi = find_all_field('production_issue_master','pi_no','pi_no='.$$unique_master);

		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		
		unset($$unique_master);
		unset($_POST[$unique_master]);
		
		$type=1;
		$msg='Successfully Send.';
}

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		unset($$unique_master);
		unset($_POST[$unique_master]);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}
if($_POST[$unique]>0)
{
$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url);
}

?>

<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz">
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"><?=$title?>:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						
						<select name="<?=$unique?>" id="<?=$unique?>">
        <? 
		$sql = "select b.pi_no, concat(w.warehouse_name,' :: ',b.pi_no) from production_issue_master b,warehouse w 
where b.warehouse_to=w.warehouse_id and b.status='MANUAL'";
		foreign_relation_sql($sql);?>
      </select>
						
                         
                        </div>
                    </div>

                </div>
               

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
					 <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
                </div>

            </div>
        </div>

        
    </form>
</div>





<?php /*?><div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>
    <td bgcolor="#FF9966"><strong>
      <select name="<?=$unique?>" id="<?=$unique?>">
        <? 
		$sql = "select b.pi_no, concat(w.warehouse_name,' :: ',b.pi_no) from production_issue_master b,warehouse w 
where b.warehouse_to=w.warehouse_id and b.status='MANUAL'";
		foreign_relation_sql($sql);?>
      </select>
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
    </strong></td>
  </tr>
</table>

</form>
</div><?php */?>

<?
require_once "../../../assets/template/layout.bottom.php";
?>