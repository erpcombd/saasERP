<header>
    <? if(!isset($_GET[$unique])&&($_SESSION['user']['level']>1)){?>
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button name="insert" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Save</button>
    </span>
    <? }?>
    <? //if(!isset($_GET[$unique])&&($_SESSION['user']['level']>1)){?>
    <!--<span class="oe_form_buttons_edit" style="display: inline;">
      <button name="insertn" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Save & New</button>
    </span>-->
    <? // }?>
    <? if(isset($_GET[$unique])&&($_SESSION['user']['level']>2)){?>
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button name="update" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Edit</button>
    </span>
    <? }?>
    <span class="oe_form_buttons_edit" style="display: inline;">
    <button name="reset" class="oe_button oe_form_button" type="button" onclick="parent.parent.document.location.href = '../<?=$root?>/<?=$page?>?remove=selected';">Cancel</button>
    </span>
   <!-- <span class="oe_form_buttons_edit" style="display: inline;">
    <button class="oe_button oe_form_button" type="button" onclick="parent.parent.document.location.href = '../<?=$location?>/<?=$pages_show?>';">Show All</button>
    </span>-->
    <? if($_SESSION['user']['level']==5){?>
    <span class="oe_form_buttons_edit" style="display: inline;">
    <button name="delete" accesskey="S" onclick="delete_alert()" class="oe_button oe_form_button_save oe_highlight" type="submit">Delete</button>
    </span>
    <? }?>
    
    <ul class="oe_form_field_status oe_form_status">
    
        <li class="oe_active" data-id="draft">
            <span class="label">Data Successfully Saved</span>
            
            <span class="arrow"><span></span></span>
        </li>
    
        <li class="" data-id="posted">
            <span class="label">Report</span>
            
            <span class="arrow"><span></span></span>
        </li>
    
</ul>
<div class="oe_clear"></div>
</header>