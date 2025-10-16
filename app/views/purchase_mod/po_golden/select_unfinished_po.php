<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Unfinished Purchase Order';

$table = 'purchase_master';
$unique = 'po_no';
$status = 'MANUAL';
$target_url = '../po_golden/po_create.php';

if($_POST[$unique]>0)
{
$req_check = find_a_field('purchase_master','req_no','po_no="'.$_POST[$unique].'"');
$_SESSION[$unique] = $_POST[$unique];
if($req_check>0){
header('location:po_create.php');
}else{
header('location:'.$target_url);
}
}

?>



<div class="form-container_large">
    
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"><?=$title?>:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="<?=$unique?>" id="<?=$unique?>">
								<? 
									$sql = "select p.po_no,p.po_no from purchase_master p,vendor v 
							where p.vendor_id=v.vendor_id and p.status='MANUAL' ";
									foreign_relation_sql($sql);?>
							  </select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/ >
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
		$sql = "select p.po_no,p.po_no from purchase_master p,vendor v 
where p.vendor_id=v.vendor_id and p.status='MANUAL' ";
		foreign_relation_sql($sql);?>
      </select>
    </strong></td>
    <td bgcolor="#FF9966" class="pt-2 pb-2"><strong>
      <input type="submit" name="submitit" id="submitit" value="View Detail" class="btn1 btn1-submit-input"/>
    </strong></td>
  </tr>
</table>

</form>
</div><?php */?>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>