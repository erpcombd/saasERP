<?php



?>


<form action="" method="post">
    <table class="oe_view_manager_header">
        <tbody>
            <tr class="oe_header_row oe_header_row_top">
                <td colspan="2">
                    <h2 class="oe_view_title">
                        <span class="oe_view_title_text oe_breadcrumb_title"><a href="#" class="oe_breadcrumb_item" data-id="breadcrumb_15">Lead</a> <span class="oe_fade"> >> </span> <span class="oe_breadcrumb_item"><?= $title; ?></span></span>
                    </h2>
                </td>
                <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:25px; vertical-align:middle;">
                        <tr bgcolor="#990000">

                            <td align="center" valign="middle"><strong style="color:#FFF; font-size:15px;"><em>&nbsp;Lead No:</em></strong></td>
                            <td align="center">
                                <strong>
                                    <em>
                                        <input type="text" name="lead_selected" id="lead_selected" style="height:20px; width:127px; color:#F30; font-weight:bold" value="<?= $_SESSION['lead_selected'] ?>" />
                                    </em>
                                </strong>
                            </td>
                            <td align="center" valign="middle"><input type="submit" name="button" class="btn btn-primary" id="button" value="Find" style="width:50px; font-weight:bold" /></td>
                            <td align="center" valign="middle"><input type="submit" name="button" class="btn btn-warning" id="button" value="cancel" style="width:50px; font-weight:bold" /></td>
                        </tr>
                    </table>              
                </td>
            </tr>
        </tbody>
    </table>
</form>