<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Button';
?>


<div class="form-container_large">
    
    <form action="" method="post" name="codz" id="codz">
       <div class="container-fluid ">    
	   <div class="p-3">

				<button type="button" onclick="custom(278)" class="btn1 btn1-bg-submit">Submit</button>
				<button type="button" onclick="custom(278)" class="btn1 btn1-submit-input">Input</button>
				
				<button type="button" onclick="custom(278)" class="btn1 btn1-bg-cancel">Cancel</button>
				<button type="button" onclick="custom(278)" class="btn1 btn1-bg-update">Update</button>
				<button type="button" onclick="custom(278)" class="btn1 btn1-bg-help">Help</button>
				<button type="button" onclick="custom(278)" class="btn1 btn1-bg-hrm">Hrm</button>
	</div>
	 
        <div class="col-12 shadow1 ">
			<div class="row add">
				<div class="new_left p-2"><p>select option</p></div>
				<div class="new_right p-2"><p>&nbsp;</p></div>
			</div>
		
		
            <div class="row new-bg m-0">
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Text:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="date" name="fdate" id="fdate" value="" class="form-control req"/>
                        </div>
                    </div>
					                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Text:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate" value="" class="form-control req1"/>
                        </div>
                    </div>
					                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Text:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate" value="" class="form-control req1" />
                        </div>
                    </div>
					                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Text:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate" value="" class="form-control req1" />
                        </div>
                    </div>


                </div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Text:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="date" name="tdate" id="tdate" value="" class="form-control req" />
                        </div>
                    </div>
					                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Text:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate" value="" class="form-control req1"/>
                        </div>
                    </div>
					                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Text:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
						<select class="form-control req1">
						<option>Please Select</option>
						<option>Option 1</option>
						<option>Option 2</option>
						</select>
                      
                        </div>
                    </div>
					                    <div class="form-group row m-0 pt-1">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Text:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate" value="" class="form-control req1" />
                        </div>
                    </div>
					

                </div>

            </div>
							
				<div class="n-form-btn-class">

				<input name="new" type="submit" class="btn1 btn1-bg-submit" value="submit">
            </div>
				
        </div>
	</div>




            
        <div class="container-fluid pt-5">
			<div class="col-12 shadow1 ">
				<div class="row add">
					<div class="new_left p-2"><p> View Data</p></div>
					<div class="new_right p-2"><p>&nbsp;</p></div>
				</div>

				
				<div class="pt-3 pb-3">

				<table class="table1  table-striped table-bordered table-hover table-sm">
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
                            <td></td>
                            <td>0000-00-00</td>
							<td>2023-02-25 08:50:20</td>
							<td>Omar Faruk</td>
							<td>CHECKED</td>

                            
                            <td>
							<button type="button" onclick="custom(278)" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button>
							<button type="button" onclick="custom(278)" class="btn2 btn1-bg-update"><i class="fa-solid fa-pencil"></i></button>
							</td>

                        </tr>
							                        
						<tr>
                            <td>276</td>
                            <td>2023-02-23</td>
                            <td></td>

                            <td>Head Office</td>
                            <td></td>
                            <td>2023-02-23</td>
							<td>2023-02-23 08:27:45</td>
							<td>Omar Faruk</td>
							<td>CHECKED</td>

                            <td>
							<button type="button" onclick="custom(278)" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button>
							<button type="button" onclick="custom(278)" class="btn2 btn1-bg-update"><i class="fa-solid fa-pencil"></i></button>
							</td>
							
                        </tr>
						</tbody>
                </table>
				</div>
			</div>


        </div>
    </form>
</div>






<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>




