<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_datatable('table');
$title='Requisition Status';
?>

<div class="form-container_large">
    <a href="#"><button type="button" class="btn2 btn1-bg-submit mb-3">Create <i class="fa-regular fa-plus"></i></button></a>
	
    <form action="" method="post" name="codz" id="codz">
       <div class="container-fluid  shadowdiv round p-0"> 
		
            <div class="row p-3">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 p-2">
                    <div class="form-group row m-0 p-0">
                        <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From:</label>
                        <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 p-0">
                            <input type="date" name="fdate"  value="" class="form-control req"  />
                        </div>
                    </div>

                </div>
				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 p-2">
                    <div class="form-group row m-0 p-0">
                        <label class="col-sm-2 col-md-2 col-lg-2 col-xl-2 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To:</label>
                        <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 p-0">
                            <input type="date" name="tdate"  value="" class="form-control req" />
                        </div>
                    </div>

                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-2">
                    <div class="form-group row m-0 p-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req Status:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="status" id="status" class="req1">
								<option></option>
								<option>CHECKED</option>
								<option>COMPLETED</option>
							</select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 p-2 d-flex justify-content-cente align-items-center">
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input">
                    
                </div>

            </div>
	</div>


            
        <div class="container-fluid shadowdiv  round mt-3 pt-3 pb-3">
				<table id="table" class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Req No</th>
                        <th>Req Date</th>
                        <th>Req For</th>

                        <th>Warehouse </th>
                        <th>Note</th>
                        <th>Need By</th>

                        <th>Entry At</th>
						<th>Entry By</th>
						<th>Status</th>
						<th>Action</th>
                        
                    </tr>
                    </thead>

                  <tbody class="tbody1">
						<tr>
                            <td>278</td>
                            <td>2023-02-25</td>
                            <td></td>

                            <td>Head Office</td>
                            <td>Make sure you are not applying borders on both table and td/th elements separately. Instead, apply borders only where needed:Make sure you are not applying borders on both table and td/th elements separately. Instead, apply borders only where needed:</td>
                            <td>0000-00-00</td>
							<td>2023-02-25 08:50:20</td>
							<td>Omar Faruk</td>
							<td>CHECKED</td>

                            
                            <td>
							<button type="button" onclick="custom(278)" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button>
							<button type="button" onclick="custom(278)" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button>
							<button type="button" onclick="DoNav('<?php echo $rp[0];?>');" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button>
							
							<button type="button" onclick="custom(278)" class="btn2 btn1-bg-cancel"><i class="fa-solid fa-trash"></i></button>
							</td>
                        </tr>
							                        
						<tr>
                            <td>276</td>
                            <td>2023-02-23</td>
                            <td></td>

                            <td>Head Office</td>
                            <td>Make sure you are not applying borders on both table and td/th elements separately. Instead, apply borders only where needed:Make sure you are not applying borders on both table and td/th elements separately. Instead, apply borders only where needed:</td>
                            <td>2023-02-23</td>
							<td>2023-02-23 08:27:45</td>
							<td>Omar Faruk</td>
							<td>CHECKED</td>

                            <td>
							<button type="button" onclick="custom(278)" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button>
							<button type="button" onclick="custom(278)" class="btn2 btn1-bg-update"><i class="fa-solid fa-pencil"></i></button>
							
							<button type="button" onclick="DoNav('<?php echo $rp[0];?>');" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button>
							
							<button type="button" onclick="custom(278)" class="btn2 btn1-bg-cancel"><i class="fa-solid fa-trash"></i></button>
							<button type="button" onclick="custom(278)" class="btn2 btn1-bg-help"><i class="fa-solid fa-floppy-disk"></i></button>
							
							</td>
                        </tr>
						
						</tbody>
                </table>

        </div>
    </form>
</div>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>