<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
          <span id="ui-id-19" class="ui-dialog-title"><?=$title;?>
</span>


<div style="float:right">

    <? if(!isset($_GET[$unique])){?>
<button name="insert" accesskey="S" class="btn" value="Add New" type="submit">Save</button>
    <? }?>
    <? if(!isset($_GET[$unique])){?>
<button name="insertn" accesskey="S" class="btn" value="Record" type="submit">Save & New</button>
    <? }?>
    <? if(isset($_GET[$unique])){?>
<button name="update" accesskey="S" class="btn" type="submit" value="Modify">Update</button>
    <? }?>
    <? if(isset($_GET[$unique])){?>
<button name="delete" accesskey="S" class="btn" type="submit" value="Delete">Delete</button>
    <? }?>

<button class="btn" type="button" onclick="parent.parent.document.location.href = '../<?=$root?>/<?=$page?>';" value="Show">Show All</button>
<button name="reset" class="btn" type="button" onclick="parent.parent.GB_hide();" value="Close">Close</button>



</div>

</div>