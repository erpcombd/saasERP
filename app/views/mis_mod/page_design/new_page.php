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
				<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7">

					<div class="container-fluid p-0 drophere">
						<div class="col-12 shadow1 pb-3 draghere">
							<div class="row add">
								<div class="col-9 new_left p-2" style="text-align: left;"><p> select option</p></div>
								<div class="col-3 new_right p-2"><p>&nbsp;</p></div>
							</div>
							
						
					<div class="form-group row m-0 pb-1 pt-1">
						<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Cheque No:</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="r_from" type="text" id="r_from" value="" class="form-control req" required="">

						</div>
					</div>
								
								
					<div class="form-group row m-0 pb-1">
						<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Cheque Date:</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="r_from" type="date" id="r_from" value="" class="form-control req1" required="">

						</div>
					</div>
						
							<div class="n-form-btn-class">
									<input name="submit" type="submit" class="btn1 btn1-bg-submit" value="submit">
									<input name="new" type="submit" class="btn1 btn1-bg-update" value="Update">
									<input name="new" type="submit" class="btn1 btn1-bg-cancel" value="Cancel">
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
		<!--Data multi Table design start-->
		<div class="container-fluid pt-4 p-0">

			<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
				<tr class="bgc-info">
					<th>Id</th>
					<th>Name</th>
					<th>Test</th>
				</tr>
				</thead>
				
				<tbody class="tbody1">
					<tr>
					<td>test</td>
					<td>test</td>
					<td>test</td>
					</tr>
				</tbody>
			</table>

</div>
</div>
</div>
</div>


				</div>

				<!--Right form-->
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 drophere ">
					<div class="col-12 shadow1 draghere ">
						<div class="row add">
							<div class="col-9 new_left p-2"><p> View Data</p></div>
							<div class="col-3 new_right p-2">
								<button onclick="openFullscreen();"><i class="fa-solid fa-maximize"></i></button>
								<button onclick="closeFullscreen();"><i class="fa-solid fa-minimize"></i></button>
							</div>
						</div>

				
						<div class="pt-3 pb-3">
											<div class="form-group row m-0 pb-1">
						<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Test :</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="r_from" type="text" id="r_from" value="" class="form-control req" required="">

						</div>
					</div>
								
								
					<div class="form-group row m-0 pb-1">
						<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Test :</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="r_from" type="date" id="r_from" value="" class="form-control req1" required="">

						</div>
					</div>

					<div class="form-group row m-0 pb-1">
						<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text font-size12">Test :</label>
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								<input name="r_from" type="text" id="r_from" value="" class="form-control req1" required="">

						</div>
					</div>
					
				<div class="n-form-btn-class text-center">
						<input name="submit" type="submit" class="btn1 btn1-bg-submit" value="submit">
						<input name="new" type="submit" class="btn1 btn1-bg-update" value="Update">
						<input name="new" type="submit" class="btn1 btn1-bg-cancel" value="Cancel">
						<input name="new" type="submit" class="btn1 btn1-bg-help" value="reseat">
				</div>
			
						</div>

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
