
<? 
$u_id=$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$check_id =find_a_field('users_basic_permission','update_permission','PBI_ID="'.$PBI_ID.'"');
if($check_id==1){

?>


<header>
    <? if(!isset($_GET[$unique])){?>

    <span class="oe_form_buttons_edit" style="display: inline;">
      <button name="insert" accesskey="S" class="btn btn-success" type="submit">Save</button>
    </span>
    <? }?>
    <? if(!isset($_GET[$unique])){/*?>
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button name="insertn" accesskey="S" class="btn btn-primary" type="submit">Save & New</button>
    </span>
    <? */}?>
    <? if(isset($_GET[$unique])){?>
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button name="update" accesskey="S" class=" btn btn-info" type="submit">Update</button>
    </span>
    <? }?>
    <span class="oe_form_buttons_edit" style="display: inline;">
    <button name="reset" class="btn btn-warning" type="submit" onclick="parent.parent.GB_hide();">Reset</button>
    </span>
    <span class="oe_form_buttons_edit" style="display: inline;">
    <button class="btn btn-primary" type="button" onclick="parent.parent.document.location.href = '../<?=$root?>/<?=$page?>';">Show All</button>
    </span>
    <? if(isset($_GET[$unique])){?>
    <span class="oe_form_buttons_edit" style="display: inline;">
    <button name="delete" accesskey="S" class="btn btn-danger" type="submit">Delete</button>
    </span>
    <? }?>
    
    <!--<ul class="oe_form_field_status oe_form_status">
    
        <li class="oe_active" data-id="draft">
            <span class="label">Data Successfully Saved</span>
            
            <span class="arrow"><span></span></span>
        </li>
    
        <li class="" data-id="posted">
            <span class="label">Report</span>
            
            <span class="arrow"><span></span></span>
        </li>
    
</ul>--><div class="oe_clear"></div></header>

<?  } ?>