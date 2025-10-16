<?php
session_start();
ob_start();
//require "../../config/inc.all.php";
$title='Inventory Home Page';
?>
<div class="oe_view_manager oe_view_manager_current">
        <table class="oe_view_manager_header">
            <colgroup><col width="20%">
            <col width="35%">
            <col width="15%">
            <col width="30%">
            </colgroup><tbody><tr class="oe_header_row oe_header_row_top">
              <td colspan="2">
                
                
                <h2 class="oe_view_title">
                  <span class="oe_view_title_text oe_breadcrumb_title"><a href="#" class="oe_breadcrumb_item" data-id="breadcrumb_15">Sales Receipts</a> <span class="oe_fade">/</span> <span class="oe_breadcrumb_item">New</span></span>
                  </h2>
                
                
                </td>
              <td colspan="2">
                <div class="oe_view_manager_view_search"><span class="ui-helper-hidden-accessible" aria-live="polite" role="status"></span></div>
                </td>
            </tr>
            </tbody></table>

        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
    <header>
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="button">Save</button>
    </span>
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="button">Save & New</button>
    </span>

    
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="button">Edit</button>
    </span>
    <span class="oe_form_buttons_edit" style="display: inline;">
    <button class="oe_button oe_form_button" type="button">Cancel</button>
    </span>
    <span class="oe_form_buttons_edit" style="display: inline;">
    <button class="oe_button oe_form_button" type="button">Show All</button>
    </span>
    <span class="oe_form_buttons_edit" style="display: inline;">
    <button accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="button">Delete</button>
    </span>

    
    <ul class="oe_form_field_status oe_form_status">
    
        <li class="oe_active" data-id="draft">
            <span class="label">Data Successfully Saved</span>
            
            <span class="arrow"><span></span></span>
        </li>
    
        <li class="" data-id="posted">
            <span class="label">Report</span>
            
            <span class="arrow"><span></span></span>
        </li>
    
</ul><div class="oe_clear"></div></header>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        Sale Receipt
    </label><span class="oe_form_field oe_form_field_char oe_inline">
        
        
            <span class="oe_form_char_content"></span>
        
    </span></h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell" width="50%"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_invisible oe_form_group_cell_label" width="1%"><label for="oe-field-input-28" title="" class="oe_form_label oe_align_right oe_form_invisible">
        Default Type
    </label></td><td colspan="1" class="oe_form_group_cell oe_form_invisible" width="99%"><span class="oe_form_field oe_form_field_selection oe_form_invisible">
        <select id="oe-field-input-28" name="type">
                
                    <option>
                        
                        
                    </option>
                
                    <option>
                        
                        Sale
                    </option>
                
                    <option>
                        
                        Purchase
                    </option>
                
                    <option>
                        
                        Payment
                    </option>
                
                    <option>
                        
                        Receipt
                    </option>
                
        </select>
    </span></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label for="oe-field-input-29" title="" class=" oe_form_label oe_align_right">
        Customer
    </label></td><td colspan="1" class="oe_form_group_cell" width="99%"><span class="oe_form_field oe_form_field_many2one oe_form_field_with_button">
        

        
            <a style="display: none;" class="oe_m2o_cm_button oe_e" href="#" tabindex="-1">/</a>
            <div>
                <input value="" autocomplete="off" class="ui-autocomplete-input" id="oe-field-input-29" type="text"><span class="ui-helper-hidden-accessible" aria-live="polite" role="status"></span>
                <span class="oe_m2o_drop_down_button">
                    <img src="../../img/down-arrow.png">
                </span>
            </div>
        
    </span></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_invisible oe_form_group_cell_label" width="1%"><label for="oe-field-input-30" title="" class="oe_form_label oe_align_right oe_form_invisible">
        Company
    </label></td><td colspan="1" class="oe_form_group_cell oe_form_invisible" width="99%"><span class="oe_form_field oe_form_field_selection oe_form_required oe_form_invisible">
        <select id="oe-field-input-30" name="company_id">
                
                    <option>
                        
                        
                    </option>
                
                    <option>
                        
                        Demo Company
                    </option>
                
                    <option>
                        
                        Your Company, Birmingham shop
                    </option>
                
                    <option>
                        
                        Your Company, Chicago shop
                    </option>
                
        </select>
    </span></td></tr></tbody></table></td><td colspan="1" class="oe_form_group_cell oe_group_right" width="50%"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label for="oe-field-input-31" title="" class=" oe_form_label oe_align_right">
        Journal
    </label></td><td colspan="1" class="oe_form_group_cell" width="99%"><span class="oe_form_field oe_form_field_selection oe_form_required">
        <select id="oe-field-input-31" name="journal_id">
                
                    <option>
                        
                        
                    </option>
                
                    <option>
                        
                        Sales Journal - (test) (EUR)
                    </option>
                
                    <option>
                        
                        Sales Credit Note Journal - (test) (EUR)
                    </option>
                
        </select>
    </span></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label for="oe-field-input-32" title="Effective date for accounting entries" class=" oe_form_label_help oe_align_right">
        Date
    </label></td><td colspan="1" class="oe_form_group_cell" width="99%"><span class="oe_form_field oe_datepicker_root oe_form_field_date"><span>
        
        <input value="" id="dp1358603602645" class="oe_datepicker_container hasDatepicker" disabled="disabled" style="display: none;" type="text">
        <input value="01/19/2013" class="oe_datepicker_master" name="date" type="text">
    </span></span></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label for="oe-field-input-33" title="" class=" oe_form_label oe_align_right">
        Memo
    </label></td><td colspan="1" class="oe_form_group_cell" width="99%"><span class="oe_form_field oe_form_field_char">
        
            <input value="" id="oe-field-input-33" maxlength="256" type="text">
        
        
    </span></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_invisible oe_form_group_cell_label" width="1%"><label for="oe-field-input-34" title="The Voucher has been totally paid." class="oe_form_label_help oe_align_right oe_form_invisible">
        Paid
    </label></td><td colspan="1" class="oe_form_group_cell oe_form_invisible" width="99%"><span class="oe_form_field oe_form_field_boolean oe_form_invisible">
        <input disabled="" class="field_boolean" id="oe-field-input-34" name="paid" type="checkbox">
    </span></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_invisible oe_form_group_cell_label" width="1%"><label for="oe-field-input-35" title="" class="oe_form_label oe_align_right oe_form_invisible">
        Paid Amount in Company Currency
    </label></td><td colspan="1" class="oe_form_group_cell oe_form_invisible" width="99%"><span class="oe_form_field oe_form_field_float oe_form_invisible">
        
        
            <span class="oe_form_char_content">0.00</span>
        
    </span></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_invisible oe_form_group_cell_label" width="1%"><label for="oe-field-input-36" title="" class="oe_form_label oe_align_right oe_form_invisible">
        Currency
    </label></td><td colspan="1" class="oe_form_group_cell oe_form_invisible" width="99%"><span class="oe_form_field oe_form_field_many2one oe_form_field_with_button oe_form_invisible">
        
            <a class="oe_form_uri" href="#"></a>
            
            <span class="oe_form_m2o_follow"></span>
        
        
    </span></td></tr></tbody></table></td></tr></tbody></table><div class="oe_clear ui-tabs ui-widget ui-widget-content ui-corner-all">
        <ul role="tablist" class="oe_notebook ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
            <li aria-selected="true" aria-labelledby="ui-id-2" aria-controls="notebook_page_37" tabindex="0" role="tab" class="ui-state-default ui-corner-top ui-tabs-active ui-state-active">
                <a id="ui-id-2" tabindex="-1" role="presentation" class="ui-tabs-anchor" href="#notebook_page_37">
                    Sales Information
                </a>
            </li><li aria-selected="false" aria-labelledby="ui-id-3" aria-controls="notebook_page_43" tabindex="-1" role="tab" class="ui-state-default ui-corner-top oe_form_invisible">
                <a id="ui-id-3" tabindex="-1" role="presentation" class="ui-tabs-anchor" href="#notebook_page_43">
                    Journal Items
                </a>
            </li>
        </ul>
    <div aria-hidden="false" aria-expanded="true" style="display: block;" role="tabpanel" aria-labelledby="ui-id-2" id="notebook_page_37" class="oe_notebook_page  ui-tabs-panel ui-widget-content ui-corner-bottom">
    <div class="oe_form_field oe_form_field_one2many"><div class="oe_view_manager">
        <table class="oe_view_manager_header">
            <colgroup><col width="20%">
            <col width="35%">
            <col width="15%">
            <col width="30%">
            </colgroup><tbody><tr class="oe_header_row oe_header_row_top">
                <td colspan="2">
                        <h2 class="oe_view_title">
                            <span class="oe_view_title_text oe_breadcrumb_title"></span>
                        </h2>
                </td>
                <td colspan="2">
                        <div class="oe_view_manager_view_search"></div>
                </td>
            </tr>
            <tr class="oe_header_row">
                <td>
                        <div class="oe_view_manager_buttons"><div class="oe_list_buttons">
    
    </div></div>
                </td>
                <td colspan="2">
                        <div class="oe_view_manager_sidebar"></div>
                </td>
                <td>
                    <ul class="oe_view_manager_switch oe_button_group oe_right">
                        
                    </ul>
                    <div class="oe_view_manager_pager oe_right"><div style="display: none;" class="oe_list_pager oe_list_pager_single_page" colspan="4">
        
    <div class="oe_pager_value">
        
            <span class="oe_list_pager_state">-</span>
        
    </div>
    <ul class="oe_pager_group">
        
        <li>
            <a class="oe_i" data-pager-action="previous" type="button">(</a>
        </li>
        <li>
            <a class="oe_i" data-pager-action="next" type="button">)</a>
        </li>
        
    </ul>

    </div></div>
                </td>
            </tr>
        </tbody></table>

        <div class="oe_view_manager_body">
            
                <div class="oe_view_manager_view_list"><div class="oe_list oe_view oe_list_editable"><div><div style="display: none;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div style="display: none;" class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form"><div class="oe_form_container oe_form_nosheet">
    <field name="account_id" domain="[('user_type.report_type','=','income'),('type','!=','view')]" widget="selection" modifiers="{&quot;required&quot;:true}" nolabel="true"></field><field name="name" modifiers="{}" nolabel="true"></field><field name="amount" sum="Total" modifiers="{}" nolabel="true"></field><field name="account_analytic_id" invisible="1" modifiers="{&quot;invisible&quot;:true,&quot;tree_invisible&quot;:true}" nolabel="true"></field></div></div></div>
    </div></div><table class="oe_list_content">
    
    <thead>
        
        <tr class="oe_list_header_columns">
            
                
            
                
            
                
            
                
            
            
            
                <th data-id="account_id" class="oe_list_header_selection null"><div>
                    Account
                </div></th>
            
                <th data-id="name" class="oe_list_header_char null"><div>
                    Description
                </div></th>
            
                <th data-id="amount" class="oe_list_header_float null"><div>
                    Amount
                </div></th>
            
                
            
            <th class="oe_list_record_delete" width="13px"></th>
        </tr>
    </thead>
    <tfoot>
        
    </tfoot>
<tbody><tr><td class="oe_form_field_one2many_list_row_add" colspan="4"><a href="#">Add an item</a></td></tr><tr><td title="Account">&nbsp;</td><td title="Description">&nbsp;</td><td title="Amount">&nbsp;</td><td class="oe_list_record_delete"><button type="button" style="visibility: hidden;"> </button></td></tr><tr><td title="Account">&nbsp;</td><td title="Description">&nbsp;</td><td title="Amount">&nbsp;</td><td class="oe_list_record_delete"><button type="button" style="visibility: hidden;"> </button></td></tr><tr><td title="Account">&nbsp;</td><td title="Description">&nbsp;</td><td title="Amount">&nbsp;</td><td class="oe_list_record_delete"><button type="button" style="visibility: hidden;"> </button></td></tr></tbody></table></div></div>
            
        </div>
    </div></div><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell" width="50%"><div class="oe_form_field oe_form_field_text">
        <textarea style="height: 119px; overflow: hidden; word-wrap: break-word; resize: vertical;" class="field_text" rows="6" name="narration" placeholder="Internal Notes"></textarea>
    </div></td><td colspan="1" class="oe_form_group_cell oe_group_right" width="50%"><table class="oe_form_group oe_subtotal_footer oe_right" border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell" width="50%"><span class="oe_form_field oe_form_field_selection">
        <select name="tax_id">
                
                    <option>
                        Tax
                        
                    </option>
                
        </select>
    </span></td><td colspan="1" class="oe_form_group_cell" width="50%"><span class="oe_form_field oe_form_field_float">
        
            <input value="0.00" type="text">
        
        
    </span></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell" width="50%"><div class="oe_subtotal_footer_separator"><label for="oe-field-input-38" title="" class=" oe_form_label oe_align_right">
        Total
    </label><button class="oe_button oe_form_button oe_link oe_edit_only" type="button">
        
        <span>(update)</span>
    </button></div></td><td colspan="1" class="oe_form_group_cell" width="50%"><span class="oe_form_field oe_form_field_float oe_subtotal_footer_separator oe_form_required">
        
            <input value="0.00" id="oe-field-input-38" type="text">
        
        
    </span></td></tr></tbody></table></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell" width="50%"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label for="oe-field-input-39" title="" class=" oe_form_label oe_align_right">
        Payment
    </label></td><td colspan="1" class="oe_form_group_cell" width="99%"><span class="oe_form_field oe_form_field_selection oe_form_required">
        <select id="oe-field-input-39" name="pay_now">
                
                    <option>
                        
                        
                    </option>
                
                    <option>
                        
                        Pay Directly
                    </option>
                
                    <option>
                        
                        Pay Later or Group Funds
                    </option>
                
        </select>
    </span></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label oe_form_invisible" width="1%"><label for="oe-field-input-40" title="" class="oe_form_label oe_align_right oe_form_invisible">
        Due Date
    </label></td><td colspan="1" class="oe_form_group_cell oe_form_invisible" width="99%"><span class="oe_form_field oe_datepicker_root oe_form_field_date oe_form_invisible"><span>
        
        <input value="" id="dp1358603602646" class="oe_datepicker_container hasDatepicker" disabled="disabled" style="display: none;" type="text">
        <input value="" class="oe_datepicker_master" name="date_due" type="text">
    </span></span></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label for="oe-field-input-41" title="" class="oe_form_label oe_align_right">
        Account
    </label></td><td colspan="1" class="oe_form_group_cell" width="99%"><span class="oe_form_field oe_form_field_many2one oe_form_field_with_button oe_form_required">
        
        
            <a style="display: none;" class="oe_m2o_cm_button oe_e" href="#" tabindex="-1">/</a>
            <div>
                <input value="" autocomplete="off" class="ui-autocomplete-input" id="oe-field-input-41" type="text"><span class="ui-helper-hidden-accessible" aria-live="polite" role="status"></span>
                <span class="oe_m2o_drop_down_button">
                    <img src="../../img/down-arrow.png">
                </span>
            </div>
        
    </span></td></tr><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label for="oe-field-input-42" title="Transaction reference number." class="oe_form_label_help oe_align_right">
        Ref #
    </label></td><td colspan="1" class="oe_form_group_cell" width="99%"><span class="oe_form_field oe_form_field_char">
        
            <input value="" id="oe-field-input-42" maxlength="64" type="text">
        
        
    </span></td></tr></tbody></table></td></tr></tbody></table></div><div aria-hidden="true" aria-expanded="false" style="display: none;" role="tabpanel" aria-labelledby="ui-id-3" id="notebook_page_43" class="oe_notebook_page ui-tabs-panel ui-widget-content ui-corner-bottom oe_form_invisible">
    <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row"><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label for="oe-field-input-44" title="" class=" oe_form_label oe_align_right">
        Period
    </label></td><td colspan="1" class="oe_form_group_cell" width="49%"><span class="oe_form_field oe_form_field_many2one oe_form_field_with_button oe_form_required">
        
        
            <a style="display: inline;" class="oe_m2o_cm_button oe_e" href="#" tabindex="-1">/</a>
            <div>
                <input value="X 01/2013" autocomplete="off" class="ui-autocomplete-input" id="oe-field-input-44" type="text"><span class="ui-helper-hidden-accessible" aria-live="polite" role="status"></span>
                <span class="oe_m2o_drop_down_button">
                    <img src="../../img/down-arrow.png">
                </span>
            </div>
        
    </span></td><td colspan="1" class="oe_form_group_cell oe_form_group_cell_label" width="1%"><label for="oe-field-input-45" title="Check this box if you are unsure of that journal entry and if you want to note it as 'to be reviewed' by an accounting expert." class=" oe_form_label_help oe_align_right">
        To Review
    </label></td><td colspan="1" class="oe_form_group_cell" width="49%"><span class="oe_form_field oe_form_field_boolean">
        <input class="field_boolean" id="oe-field-input-45" name="audit" type="checkbox">
    </span></td></tr></tbody></table><div class="oe_form_field oe_form_field_one2many"><div class="oe_view_manager">
        <table class="oe_view_manager_header">
            <colgroup><col width="20%">
            <col width="35%">
            <col width="15%">
            <col width="30%">
            </colgroup><tbody><tr class="oe_header_row oe_header_row_top">
                <td colspan="2">
                        <h2 class="oe_view_title">
                            <span class="oe_view_title_text oe_breadcrumb_title"></span>
                        </h2>
                </td>
                <td colspan="2">
                        <div class="oe_view_manager_view_search"></div>
                </td>
            </tr>
            <tr class="oe_header_row">
                <td>
                        <div class="oe_view_manager_buttons"><div class="oe_list_buttons">
    
    </div></div>
                </td>
                <td colspan="2">
                        <div class="oe_view_manager_sidebar"></div>
                </td>
                <td>
                    <ul class="oe_view_manager_switch oe_button_group oe_right">
                        
                    </ul>
                    <div class="oe_view_manager_pager oe_right"><div style="display: none;" class="oe_list_pager oe_list_pager_single_page" colspan="11">
        
    <div class="oe_pager_value">
        
            <span class="oe_list_pager_state">-</span>
        
    </div>
    <ul class="oe_pager_group">
        
        <li>
            <a class="oe_i" data-pager-action="previous" type="button">(</a>
        </li>
        <li>
            <a class="oe_i" data-pager-action="next" type="button">)</a>
        </li>
        
    </ul>

    </div></div>
                </td>
            </tr>
        </tbody></table>

        <div class="oe_view_manager_body">
            
                <div class="oe_view_manager_view_list"><div class="oe_list oe_view"><table class="oe_list_content">
    
    <thead>
        
        <tr class="oe_list_header_columns">
            
                
            
                
            
                
            
                
            
                
            
                
            
                
            
                
            
                
            
                
            
                
            
            
            
                <th data-id="move_id" class="oe_list_header_many2one null"><div>
                    Journal Entry
                </div></th>
            
                <th data-id="ref" class="oe_list_header_char null"><div>
                    Reference
                </div></th>
            
                <th data-id="date" class="oe_list_header_date null"><div>
                    Effective date
                </div></th>
            
                <th data-id="statement_id" class="oe_list_header_many2one null"><div>
                    Statement
                </div></th>
            
                <th data-id="partner_id" class="oe_list_header_many2one null"><div>
                    Partner
                </div></th>
            
                <th data-id="account_id" class="oe_list_header_many2one null"><div>
                    Account
                </div></th>
            
                <th data-id="name" class="oe_list_header_char null"><div>
                    Name
                </div></th>
            
                <th data-id="debit" class="oe_list_header_float null"><div>
                    Debit
                </div></th>
            
                <th data-id="credit" class="oe_list_header_float null"><div>
                    Credit
                </div></th>
            
                <th data-id="state" class="oe_list_header_selection null"><div>
                    Status
                </div></th>
            
                <th data-id="reconcile_id" class="oe_list_header_many2one null"><div>
                    Reconcile
                </div></th>
            
            
        </tr>
    </thead>
    <tfoot>
        
    </tfoot>
<tbody><tr><td title="Journal Entry">&nbsp;</td><td title="Reference">&nbsp;</td><td title="Effective date">&nbsp;</td><td title="Statement">&nbsp;</td><td title="Partner">&nbsp;</td><td title="Account">&nbsp;</td><td title="Name">&nbsp;</td><td title="Debit">&nbsp;</td><td title="Credit">&nbsp;</td><td title="Status">&nbsp;</td><td title="Reconcile">&nbsp;</td></tr><tr><td title="Journal Entry">&nbsp;</td><td title="Reference">&nbsp;</td><td title="Effective date">&nbsp;</td><td title="Statement">&nbsp;</td><td title="Partner">&nbsp;</td><td title="Account">&nbsp;</td><td title="Name">&nbsp;</td><td title="Debit">&nbsp;</td><td title="Credit">&nbsp;</td><td title="Status">&nbsp;</td><td title="Reconcile">&nbsp;</td></tr><tr><td title="Journal Entry">&nbsp;</td><td title="Reference">&nbsp;</td><td title="Effective date">&nbsp;</td><td title="Statement">&nbsp;</td><td title="Partner">&nbsp;</td><td title="Account">&nbsp;</td><td title="Name">&nbsp;</td><td title="Debit">&nbsp;</td><td title="Credit">&nbsp;</td><td title="Status">&nbsp;</td><td title="Reconcile">&nbsp;</td></tr></tbody></table></div></div>
            
        </div>
    </div></div></div></div></div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">        
        <div class="oe_actions">
            <button class="oe_follower oe_notfollow" type="button">
                <span class="oe_follow">Follow</span>
                <span class="oe_unfollow">Unfollow</span>
                <span class="oe_following">Following</span>
            </button>
            
            <div class="oe_subtype_list"></div>
        </div>
        <hr size="2">
        <div class="oe_follower_title_box">
            <h4 class="oe_follower_title">No followers</h4>
            <a class="oe_invite" href="#">Add others</a>
        </div>
        <div class="oe_follower_list"></div>
    </div><div style="display: none;" class="oe_record_thread">
        <div class="oe_mail-placeholder">
        </div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
    </div>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>