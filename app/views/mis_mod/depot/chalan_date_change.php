<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Start Edit Section ::::: 
$title='Depot Chalan Date Change';			// Page Name and Page Title
$page="task_assign.php";			// PHP File Name
$root='mis';

$table='sale_do_chalan';					// Database Table Name Mainly related to this page
$unique='id';						// Primary Key of this Database table
$shown='chalan_date';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::
do_calander('#chalan_date');

do_calander('#serial_no');

$chalan_no = $_REQUEST['chalan_no'];
$crud      =new crud($table);

// $$unique = $_GET[$unique];

$do= find_a_field('sale_do_chalan','do_no','chalan_no='.$chalan_no); 

if(isset($_REQUEST['change_date'])&&$_REQUEST['chalan_date']!='')
{
	$chalan_date = $_REQUEST['chalan_date'];
	$chalan_date_st = strtotime($chalan_date);
	$sql_chalan = 'update sale_do_chalan set chalan_date = "'.$chalan_date.'" where chalan_no = "'.$chalan_no.'"';
	$sql_journal_item = 'update journal_item set ji_date="'.$chalan_date.'" where tr_from="Sales" and sr_no="'.$chalan_no.'"';
	$sql_sec_journal = 'update secondary_journal set jv_date="'.$chalan_date_st.'" where tr_from="Sales" and tr_no="'.$chalan_no.'"';
	db_query($sql_chalan);db_query($sql_journal_item);db_query($sql_sec_journal);
	
}

if(isset($_REQUEST['change_serial_no'])&&$_REQUEST['serial_no']!='')
{
	$serial_no = $_REQUEST['serial_no'];
	
	$sql_chalan = 'update sale_do_chalan set do_date = "'.$serial_no.'" where chalan_no = "'.$chalan_no.'"';
	db_query($sql_chalan);
	
	 $sql_do_master = 'update sale_do_master set do_date = "'.$serial_no.'" where do_no = "'.$do.'"';
	db_query($sql_do_master);
	
	$sql_do_details = 'update sale_do_details set do_date = "'.$serial_no.'" where do_no = "'.$do.'"';
	db_query($sql_do_details);
	
	
}
?>
<form action="" method="post">
<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../../common/title_bar.php');?>
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
           	 <table style="width:85%" border="0" class="text-center">
           	     <th></th>
  <tr>
    <td style="background-color:#33CCFF"><strong>Chalan No: </strong></td>
    <td style="background-color:#33CCFF"><strong>
      <label>
      <input name="chalan_no" type="text" id="chalan_no" maxlength="11" value="<?=$chalan_no?>" required / class="form-control">
        </label>
    </strong></td>
    <td style="background-color:#33CCFF" style="text-align:center"><strong>
      <label>
      <input name="search" type="submit" id="search" value="Search Chalan" / class="form-control">
        </label>
    </strong></td>
  </tr>
  <tr>
    <td style="background-color:#FFFFFF">&nbsp;</td>
    <td style="background-color:#FFFFFF">&nbsp;</td>
    <td style="background-color:#FFFFFF">&nbsp;</td>
  </tr>
  <? if($chalan_no>0){?>
  <tr>
    <td style="background-color:#FFCCCC"><strong>Chalan Date : </strong></td>
    <td style="background-color:#FFCCCC"><input name="chalan_date" type="text" id="chalan_date" value="<?=find_a_field('sale_do_chalan','chalan_date','chalan_no='.$chalan_no);?>" / class="form-control"></td>
    <td style="background-color:#FFCCCC" style="text-align:center">
	<input name="change_date" type="submit" id="change" value="Change Chalan Date" /  class="form-control"></td>
  </tr>
    <tr>
    <td style="background-color:#FFFFFF">&nbsp;</td>
    <td style="background-color:#FFFFFF">&nbsp;</td>
    <td style="background-color:#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td style="background-color:#CC99CC"><strong>DO Date : </strong></td>
    <td style="background-color:#CC99CC"><input name="serial_no" type="text" id="serial_no" value="<?=find_a_field('sale_do_chalan','do_date','chalan_no='.$chalan_no);?>" / class="form-control"></td>

    <td style="background-color:#CC99CC" style="text-align:center">
	<input name="change_serial_no" type="submit" id="change_serial_no" value="Change DO Date " / class="form-control"></td>
  </tr>
  <? }?>
</table>

		
		  
          </div></div>
          </div>
    </div><? if($chalan_no>0){?>
<div class="oe_form_sheetbg" style="min-height:0px;">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
		  <span color="#003399"><u>Depot Information</u></span><br /><br />
          <? 	 
		  
		 $res='select c.id,c.do_no,c.chalan_no,c.chalan_date,m.do_date,concat(d.dealer_name_e,"(",d.dealer_code,")") as party_name,c.driver_name as serial_no,count(1) as items,sum(c.total_amt) as total_amt from sale_do_chalan c,sale_do_master m, dealer_info d where d.dealer_code=c.dealer_code and m.do_no=c.do_no and c.chalan_no = "'.$chalan_no.'"';
		  
				echo link_report($res,$link);?>
          </div></div>
          </div>
    </div>
<div class="oe_form_sheetbg" style="min-height:0px;">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
		  <span color="#003399"><u>Accounts Information</u></span><br /><br />
          <? 	 
		  
		   $res='select sj.id,sj.jv_no,sj.tr_no as chalan_no,DATE_FORMAT(FROM_UNIXTIME(sj.jv_date), "%Y-%m-%d") as jv_date,l.ledger_name,sj.narration,sj.dr_amt,sj.cr_amt,sj.checked from secondary_journal sj,accounts_ledger l where l.ledger_id=sj.ledger_id and sj.tr_from="Sales" and sj.tr_no = "'.$chalan_no.'"';
		  
				echo link_report($res,$link);?>
          </div></div>
          </div>
    </div>
<? }?>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
  </div>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>