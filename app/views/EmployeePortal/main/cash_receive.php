<?php
session_start();
include 'config/db.php';
include 'config/function.php';
include 'config/access.php';
$user_id	=$_SESSION['user_id'];

$page="home";

include "inc/header.php";


if(isset($_REQUEST['new'])){

        $jv_no			= next_jv_no('','Receipt','');
        $tr_date 		= $_POST['tr_date'];
        $ledger_id_dr 	= $_POST['ledger_id_dr'];
        $ledger_id_cr 	= $_POST['ledger_id_cr'];
        $amount         = $_POST['amt'];
        $member_name         = find1("select name from ledger_head where ledger_id='".$_POST['ledger_id_cr']."' ");

        $narration 	    = "Collection from ".$member_name;
        $tr_from 		= 'Collection';
        $group_for 		= $_SESSION['company_id'];
        $entry_at       = date('Y-m-d H:i:s');
        $entry_by       = $_SESSION['username'];
        $tr_no 		    = 0;

if($amount>0){
    $journal_dr="INSERT ignore INTO journal (jv_no, tr_date, ledger_id, dr, tr_from, tr_no, narration, cheq_no, cheq_date,group_for,cc_code,entry_by,entry_at
    	)VALUES (
    '$jv_no', '$tr_date', '$ledger_id_dr', '$amount', '$tr_from','$tr_no','$narration', '','','$group_for','$cc_code','$entry_by','$entry_at')";
    db_query($conn, $journal_dr);
    
    $journal_cr="INSERT ignore INTO journal (jv_no, tr_date, ledger_id, cr, tr_from, tr_no, narration, cheq_no, cheq_date,group_for,cc_code,entry_by,entry_at
    	)VALUES (
    '$jv_no', '$tr_date', '$ledger_id_cr', '$amount', '$tr_from','$tr_no','$narration', '','','$group_for','$cc_code','$entry_by','$entry_at')";
    db_query($conn, $journal_cr);
}    



$msg="New data insert successfully";

redirect2("cash_receive.php");
}

?>

<!-- main page content -->
<div class="main-container container">
<?php if(isset($msg)){ ?><div class="alert alert-primary msg" role="alert"><?php echo @$msg; ?></div><?php } ?>
<?php if(isset($emsg)){ ?><div class="alert alert-danger emsg" role="alert"><?php echo @$emsg; ?></div><?php } ?>            
            
            
<!-- select Amount -->
<form action="" method="post" id="demo" data-parsley-validate class="form-horizontal form-label-left">


<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="first-name">Source<span class="required"></span></label></div>
	<div class="col-7"><select class="form-control " id="ledger_id_dr" name="ledger_id_dr" required>
        <? optionlist('select id,name from ledger_head where ledger_group=2'); ?>
        </select>
    </div>
</div> 
            
            
<div class="row mb-2">
    <div class="col-12 text-center mb-4">
        <input type="text" name="amt" class="trasparent-input text-center" value="" placeholder="Enter Amount" required="required" autocomplete="off">
    </div>
</div>
            

<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="first-name">Date<span class="required"></span></label></div>
	<div class="col-7"><input type="date" name="tr_date" required="required" autocomplete="off" value="<?=date('Y-m-d')?>" class="form-control"></div>
</div> 


<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="first-name">Member<span class="required"></span></label></div>
	<div class="col-7"><select class="form-control " id="ledger_id_cr" name="ledger_id_cr" required>
        <option></option>
        <? optionlist('select id,name from ledger_head where ledger_group=3 and status=1'); ?>
        </select>
    </div>
</div>            
            

<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="first-name">Note<span></span></label></div>
	<div class="col-7"><input type="text" name="narration" required="required" autocomplete="off" value="" class="form-control"></div>
</div>   


            
            <div class="row mb-4">
                <div class="col-12 ">
                    <button type="submit" name="new" class="btn btn-default btn-lg shadow-sm w-100 btn-rounded">Collection</button>
                </div>
            </div>

</form>
        
        
</div>
<!-- main page content ends -->
</main>
<!-- Page ends-->

<?php include "inc/footer.php"; ?>