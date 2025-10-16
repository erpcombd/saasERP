<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Requisition Status';
?>

<style>
    .drophere {
      float: left;
      width: 100%;
/*      border: 1px solid red;
      padding: 5px;*/
    }

    .draghere {
      width: 100%;
      text-align: center;
/*      line-height: 50px;*/
    }
    .ui-draggable-dragging {
 /*     background: blue;*/
    }

    .hoverClass {
      border: 2px solid #9d9b9b;
	  border-style: dotted;
      background: #ffedd3;
    }
</style>

<div class="form-container_large">
	<form id="form1" name="form1" method="post" action="?" onsubmit="return checking()">
		<!--        top form start hear-->
		<div class="container-fluid ">
			<div class="row">
				<!--left form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

					<div class="container-fluid p-0 drophere">
						<div class="col-12 shadow1 pb-3 draghere">
							<div class="row add">
								<div class="col-9 new_left p-2" style="text-align: left;"><p> select option</p></div>
								<div class="col-3 new_right p-2"><p>&nbsp;</p></div>
							</div>


						<div id="cash_check" class="col-12 m-0 p-0 pt-3">

								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Voucher No:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">									
										<input  type="text"  class="form-control req1" value="">


									</div>
								</div>
							
						
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Voucher Date:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8  p-0 pr-2 ">
										<input type="date"  value="" required="" class="form-control req">


									</div>
								</div>
						

					
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Received From:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
										<input name="r_from" type="text" id="r_from" value="" class="form-control req" required="">

									</div>
								</div>
							
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Type:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

										<select name="type" id="type" required="" onchange="check_type()" class="form-control req1">
											<option value="0"></option>
											<option value="CASH">CASH</option>
											<option value="BANK">BANK</option>
											</select>
									</div>
								</div>
							
								<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Cash A/C:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

										<select name="type" id="type" required="" onchange="check_type()" class="form-control req1">
											<option value="0"></option>
											<option value="1260010001">Central Cash - H/O</option>
											<option value="1260010002">Petty Cash - H/O</option>
											</select>
									</div>
								</div>

						</div>
						


						<div id="bank_check" class="col-12 m-0 p-0">
														<div class="form-group row m-0 pb-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Bank A/C Debit:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

										<select name="type" id="type" required="" onchange="check_type()" class="form-control req">
											<option value="0"></option>
											<option value="1260020001">IBBL-20501300100587011</option>
											<option value="1260010002">OBL-0811020006661</option>
											<option value="1260020003">SND Account Number</option>
											</select>
									</div>
								</div>
						</div>
						
						
						
					<div class="form-group row m-0 pb-1">
						<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Cheque No:</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="r_from" type="text" id="r_from" value="" class="form-control req1" required="">

						</div>
					</div>
								
								
					<div class="form-group row m-0 pb-1">
						<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Cheque Date:</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="r_from" type="date" id="r_from" value="" class="form-control req1" tabindex="1" required="">

						</div>
					</div>

					<div class="form-group row m-0 pb-1">
						<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Of Bank:</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="r_from" type="text" id="r_from" value="" class="form-control req1" tabindex="1" required="">

						</div>
					</div>


						<div class="form-group row m-0 pb-1">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 font-size12 bg-form-titel-text">Remarks:</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
								<input name="remarks" type="text" id="remarks" value="" class="form-control req1">
							</div>
						</div>

						</div>
					</div>


				</div>

				<!--Right form-->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 drophere ">
					<div class="col-12 shadow1 draghere ">
						<div class="row add">
							<div class="col-9 new_left p-2" ><p> View Data</p></div>
							<div class="col-3 new_right p-2">
						
								<button onclick="openFullscreen();"><i class="fa-solid fa-maximize"></i></button>
								<button onclick="closeFullscreen();"><i class="fa-solid fa-minimize"></i></button>
							</div>
						</div>

				
						<div class="pt-3 pb-3">
						<table class="table1  table-striped table-bordered table-hover table-sm" border="0">

							<thead class="thead1">
							<tr class="bgc-info">
								<th>Vou No</th>
								<th>Amount</th>
								<th>Date</th>
								<th>Status</th>
								<th></th>
							</tr>
							</thead>

							<tbody class="tbody1">

							
									<tr>

										<td>2301000017</td>

										<td>200.00</td>

										<td>22-03-2023</td>

										<td>YES</td>

		

										<td style="padding:1px;"><a href="general_voucher_print_view_for_draft.php?jv_no=23032201000001" target="_blank">
										<button type="button" onclick="custom(278)" class="btn2 btn1-bg-hrm"><i class="fa-solid fa-print"></i></button></a></td>
									</tr>

								
									<tr>

										<td>2301000016</td>

										<td>28000.00</td>

										<td>21-03-2023</td>

										<td>YES</td>



										<td style="padding:1px;"><a href="general_voucher_print_view_for_draft.php?jv_no=23032101000001" target="_blank">
										<button type="button" onclick="custom(278)" class="btn2 btn1-bg-hrm"><i class="fa-solid fa-print"></i></button>
										</a></td>
									</tr>

								
									<tr>

										<td>2301000014</td>

										<td>3080.00</td>

										<td>07-03-2023</td>

										<td>YES</td>



										<td style="padding:1px;"><a href="general_voucher_print_view_for_draft.php?jv_no=23030701000001" target="_blank">
										<button type="button" onclick="custom(278)" class="btn2 btn1-bg-hrm"><i class="fa-solid fa-print"></i></button>
										</a></td>
									</tr>

								
									<tr>

										<td>2301000013</td>

										<td>35000.00</td>

										<td>05-03-2023</td>

										<td>YES</td>

										

										<td style="padding:1px;"><a href="general_voucher_print_view_for_draft.php?jv_no=23030501000003" target="_blank">
										<button type="button" onclick="custom(278)" class="btn2 btn1-bg-hrm"><i class="fa-solid fa-print"></i></button>
										</a></td>
									</tr>

								
									<tr>

										<td>2301000012</td>

										<td>3300.00</td>

										<td>05-03-2023</td>

										<td>YES</td>

										

										<td style="padding:1px;"><a href="general_voucher_print_view_for_draft.php?jv_no=23030501000002" target="_blank">
										<button type="button" onclick="custom(278)" class="btn2 btn1-bg-hrm"><i class="fa-solid fa-print"></i></button>
										</a></td>
									</tr>

								
							</tbody>

						</table>
						</div>

					</div>



				</div>


			</div>


		</div>


<div class="drophere">
					<div class="col-12 shadow1 mt-3 draghere ">
						<div class="row add">
							<div class="col-9 new_left p-2" style="text-align: left;"><p> Add Information</p></div>
							<div class="col-3 new_right p-2"><p>&nbsp;</p></div>
						</div>

				
						<div class="pt-3 pb-3">
		<!--Table input one design-->
		<div class="container-fluid p-0 ">



			<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
				<tr class="bgc-info">
					<td>GL Code</td>
					<td>GL Name</td>
					<td>Cost Center</td>
					<td>Narration</td>
					<td>Amount</td>
					<td></td>
				</tr>

				</thead>
				<tbody class="tbody1">
				<tr>

					<td>
						<input type="text" id="ledger_id" name="ledger_id" onblur="getData2('acc_reference_ajax.php', 'acc_reference', this.value,
								document.getElementById('ledger_id').value);" value="" class="ui-autocomplete-input" autocomplete="off">
					
					</td>

					<td>

							<span id="acc_reference">
							<table border="1" style="weight:100%">
							    <th style="display:none"></th>
								<tbody><tr>
									<td>
										<input type="text" class="form-control" id="ledger_name" name="ledger_id" value="">
										<input type="hidden" class="form-control" id="reference_id" name="reference_id" value="">

																			</td>
								</tr>
							</tbody></table>
							  </span>
					</td>


					<td>
						<select name="cc_code" id="cc_code">
							<option></option>
							<option value="1">Petty Cash</option><option value="2">Cash On Delivery</option><option value="3">Bank</option><option value="4">Agent</option><option value="5">Evening Snacks</option>						</select>
					</td>

					<td>
						<input name="detail" type="text" id="detail" >
					</td>

					<td class="">
						<input name="amount" type="text" id="amount" size="5" >
					</td>


					<td>
						<input name="add_new" class="btn1 btn1-bg-submit" type="submit" id="add_new" value="Add New">
						<input name="add" type="hidden">
					</td>

				</tr>

				</tbody>

			</table>

		</div>


		<!--Data multi Table design start-->
		<div class="container-fluid pt-4 p-0 ">

			<table class="table1  table-striped table-bordered table-hover table-sm" border="1">

				<thead class="thead1">
				<tr class="bgc-info">
					<td>GL Code</td>
					<td>GL Name</td>
					<td>Cost Center</td>
					<td><strong>Narration</strong></td>
					<td><strong>Amount</strong></td>
					<td><strong>Action</strong></td>
				</tr>

				</thead>


				<tbody class="tbody1">
				
	
	<form method="post"></form>
		<tr>
			<td colspan="4">
				<input name="receipt_varify" class="btn1 btn1-bg-submit" type="button" id="receipt_varify" value="Receipt Verified" onclick="this.form.submit()">
				<input name="limmit" type="hidden" value="">

			</td>

			<td colspan="2">
				<div class="form-group row m-0 pb-1">
					<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 font-size12 bg-form-titel-text"> Total Amount:</label>
					<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
						<input name="t_amount" type="text" id="t_amount" size="15" readonly="" value="">

					</div>
				</div>
				<input name="count" id="count" type="hidden" value="">

			</td>

		</tr>
	


	</tbody>

	</table>

</div>
</div>
</div>
</div>

</form>
</div>
<!--drop start-->
<script>
$(document).ready(function () {
      window.startPos = window.endPos = {};

      makeDraggable(); 

      $('.drophere').droppable({
        hoverClass: 'hoverClass',
        drop: function(event, ui) {
          var $from = $(ui.draggable),
              $fromParent = $from.parent(),
              $to = $(this).children(),
              $toParent = $(this);

          window.endPos = $to.offset();

          swap($from, $from.offset(), window.endPos, 0);
          swap($to, window.endPos, window.startPos, 1000, function() {
            $toParent.html($from.css({position: 'relative', left: '', top: '', 'z-index': ''}));
            $fromParent.html($to.css({position: 'relative', left: '', top: '', 'z-index': ''}));
            makeDraggable();
          });
        }
      });

      function makeDraggable() {
        $('.draghere').draggable({
          zIndex: 99999,
          revert: 'invalid',
          start: function(event, ui) {
            window.startPos = $(this).offset();
          }
        });
      }

      function swap($el, fromPos, toPos, duration, callback) {
        $el.css('position', 'absolute')
          .css(fromPos)
          .animate(toPos, duration, function() {
            if (callback) callback();
          });
      }
    });
</script>
<!--drop end-->



<script>
var elem = document.documentElement;
function openFullscreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.webkitRequestFullscreen) { /* Safari */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE11 */
    elem.msRequestFullscreen();
  }
}

function closeFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.webkitExitFullscreen) { /* Safari */
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) { /* IE11 */
    document.msExitFullscreen();
  }

}
</script>




<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>
