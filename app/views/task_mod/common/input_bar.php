<header>
    <? if(!isset($_GET[$unique])){?>

    <span class="oe_form_buttons_edit" style="display: inline;">
      <button name="insert" accesskey="S" class="oe_button oe_form_button_save  btn btn-success" type="submit">Save</button>
    </span>
    <? }?>
    <? if(!isset($_GET[$unique])){?>
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button name="insertn" accesskey="S" class="oe_button oe_form_button_save  btn btn-success" type="submit">Save & New</button>
    </span>
    <? }?>
    <? if(isset($_GET[$unique])){?>
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button name="update" accesskey="S" class="oe_button oe_form_button_save  btn btn-warning" type="submit">Update</button>
    </span>
    <? }?>
    <span class="oe_form_buttons_edit" style="display: inline;">
    <button name="reset" class="oe_button oe_form_button btn btn-danger" type="button" onclick="parent.parent.GB_hide();">Cancel</button>
    </span>
    <span class="oe_form_buttons_edit" style="display: inline;">
    <button class="oe_button oe_form_button btn btn-primary" type="button" onclick="parent.parent.document.location.href = '../<?=$root?>/<?=$page?>';">Show All</button>
    </span>
	<?
	$group_led = find_a_field('user_activity_management','user_type','user_id="'.$_SESSION['user']['id'].'"');

if($group_led!="EXECUTIVE"){
	?>
	
    <? if(isset($_GET[$unique])){?>
    <!--<span class="oe_form_buttons_edit" style="display: inline;">
    <button name="delete" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Delete</button>
    </span>-->
    <? }?>
    <? } ?>
   <div class="oe_clear"></div></header>