				
				<table class="footer-table" width="100%" cellspacing="0" cellpadding="0">
						<tr style=" font-size: 12px; font-weight: 500;">
							<td class="text-left w-33">
							Printed by: <?=find_a_field('user_activity_management','fname','user_id='.$_SESSION['user']['id'])?> 
							(<?=find_a_field('user_activity_management','designation','user_id='.$_SESSION['user']['id'])?>)
							<?php /*?> <?=find_a_field('user_activity_management','user_id','user_id='.$_SESSION['user']['id'])?><?php */?>
							 Date:  <?=date("d-m-Y")?>  Time: <?=date("h:i A")?>
							</td>
						</tr>
						<tr style="border-top: 2px solid #333;">
							<td  style="text-align: center;font-size: 11px;color: #444;"> This is an ERP generated report. That is Powered By www.erp.com.bd</td>
						</tr>
				</table>