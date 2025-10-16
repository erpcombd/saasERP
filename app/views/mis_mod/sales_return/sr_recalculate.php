<?php
session_start();
ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
// ::::: Start Edit Section ::::: 

$title='SR Re-calculate';			// Page Name and Page Title

if(isset($_POST['sr_recalculate'])){

$chalan_no = $_REQUEST['chalan_no'];
$type = find_a_field('sale_return_master s,sales_return_type t','t.sales_return_type','1 and s.sr_no = "'.$chalan_no.'" and s.do_type=t.id');
if($type=='Goods Return'){
$cogs = 'GoodsReturnCOGS';
}elseif($type=='Damage Return'){
$cogs = 'DamageReturnCOGS';
}else{
$cogs = '';
}

if($chalan_no>0)
{
    $sec_del = db_query("insert into secondary_journal_del select * from secondary_journal where tr_from in ('".$type."','".$cogs."') and tr_no=".$chalan_no."");
	 $sql= "DELETE FROM `secondary_journal` WHERE tr_from in ('".$type."','".$cogs."') and  tr_no=".$chalan_no."";
	 $sql3 = db_query($sql);
	
	$j_del = db_query('insert into journal_del select * from journal where tr_from in ("'.$type.'","'.$cogs.'") and tr_no='.$chalan_no.'');
	$sql3 = db_query("DELETE FROM `journal` WHERE tr_from in ('".$type."','".$cogs."') and  tr_no=".$chalan_no."");
	auto_insert_sales_return_secoundary($chalan_no);
	db_query("insert into del_modify_logs set tr_no='".$chalan_no."',tr_from='".$type."',action='Modify',entry_by='".$_SESSION['user']['id']."',entry_at='".date('Y-m-d H:i:s')."'");

}
}

	?>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
.style2 {
	color: #006600;
	font-weight: bold;
}
-->
</style>
<? 
if($found>0){
?>

		<div class="alert alert-danger p-2" role="alert">
  			Sorry Journal Exists!
		</div>

		
<? 
}
elseif($chalan_no>0)
{

?>

		<div class="alert alert-success p-2" role="alert">
  			Successfull
		</div>

		
<? }?>



<form action="" method="post">
	<div class="container-fluid bg-form-titel">
				<div class="row">
				<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
						
					  
					   
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">SR No</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input name="chalan_no" type="text" id="chalan_no" value="<?=$chalan_no?>" required />
							</div>
						</div>
	
					</div>
					
	
					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
						<input name="sr_recalculate" type="submit" class="btn1 btn1-submit-input" id="sr_recalculate" value="Confirm" />
					  
					   
					</div>
	
				</div>
			</div>
	</form>



<?php /*?><form action="" method="post">
<div class="oe_view_manager oe_view_manager_current">
        
   
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
<div class="oe_form_sheetbg" style="min-height:10px;">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
           	 <table border="0" style="text-align:center; weight: 85%" ><th></th>
  <tr>
    <td style="background-color:#33CCCC; height:35px"><strong>SR No: </strong></td>
    <td style="background-color:#33CCCC;"><input name="chalan_no" type="text" id="chalan_no" maxlength="16" value="<?=$chalan_no?>" required /></td>
    <td style="text-align:center; vertical-align:middle; background-color:#33CCCC;"><input name="search" type="submit" class="btn1 btn1-submit-input" id="search" value="Confirm" /></td>
  </tr>
  

</table>

		
		  
          </div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
  </div>
</form><?php */?>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>