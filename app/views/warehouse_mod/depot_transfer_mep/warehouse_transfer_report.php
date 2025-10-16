<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Transfer Report';

do_calander("#f_date");
do_calander("#t_date");
?>

<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
                
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="5" checked="checked" />
                    <label class="form-check-label p-0" for="report1-btn">
                        Issue Report (Details)(5)
                    </label>
                </div>
                
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="6" />
                    <label class="form-check-label p-0" for="report1-btn">Issue Report (Brief)(6)</label>
                </div>
                
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="7" />
                    <label class="form-check-label p-0" for="report1-btn">Entry Wise PI Report(7)
                    </label>
                </div> 
                
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="8" />
                    <label class="form-check-label p-0" for="report1-btn">Other Store Requisition Vs Delivery Report(8)
                    </label>
                </div>  
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="9" />
                    <label class="form-check-label p-0" for="report1-btn">My Requisition Vs Delivery Report(9)
                    </label>
                </div>                 
                
                
                
                
               
<div align="left">Receive Report</div>


                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="501" />
                    <label class="form-check-label p-0" for="report1-btn">
                        	
Receive Report (Details)(501)
                    </label>
                </div>
                
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="502" />
                    <label class="form-check-label p-0" for="report1-btn">
                        Receive Report (Brief)(502)
                    </label>
                </div>
                
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="503" />
                    <label class="form-check-label p-0" for="report1-btn">
                        Entry Wise Receive Report(503)
                    </label>
                </div>  
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="504" />
                    <label class="form-check-label p-0" for="report1-btn">
                      My Store Less Qty Receive Report(504)
                    </label>
                </div> 
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="505" />
                    <label class="form-check-label p-0" for="report1-btn">
                      Other Store Less Qty Receive Report(505)
                    </label>
                </div>                  



</div>

           
<div class="col-sm-7">
    
    
    
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Company:</label>
                    <div class="col-sm-8 p-0">
                <select name="group_for" id="group_for">
                      <option></option>
                        <? foreign_relation('user_group','id','company_short_code',$group_for,'1 order by company_short_code');?>
                </select>
                    </div>
                </div>   
                
                                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Group:</label>
                    <div class="col-sm-8 p-0">
                <select name="item_group" id="item_group" onchange="FetchItemCategory(this.value)">
                      <option></option>
                        <? foreign_relation('product_group','id','group_name',$product_group,'1 order by group_name');?>
                </select>
                    </div>
                </div> 
                
                                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Category:</label>
                    <div class="col-sm-8 p-0">
                       <select name="category_id" id="category_id" onchange="FetchItemSubcategory(this.value)">
                      		<option></option>
							<? foreign_relation('item_category','id','category_name',$category_name,'1 order by category_name');?>
                    	</select>
                    </div>
                </div> 
                
                                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product SubCategory:</label>
                    <div class="col-sm-8 p-0">
                       <select name="subcategory_id" id="subcategory_id" onchange="FetchItem(this.value)">
                      		<option></option>
							<? foreign_relation('item_subcategory','id','subcategory_name',$subcategory_name,'1 order by subcategory_name');?>
                    	</select>
                    </div>
                </div> 
    
    

                
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product name:</label>
                    <div class="col-sm-8 p-0">
        <input list="items" name="item_id" type="text" class="form-control"  value="" id="item_id" autocomplete="off"/>
        <datalist id="items">
        <? foreign_relation('item_info','item_id','concat(item_id,"->",finish_goods_code,"#",item_name)',$item_id,'1  ');?>
        </datalist>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From:</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        	<input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" required autocomplete="off" / class="form-control">
                      </span>

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required autocomplete="off" / class="form-control">

                        </span>


                    </div>
                </div>
                
                
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Warehouse:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <select name="warehouse_id" id="warehouse_id">
                      <option></option>
					  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','use_type=!"PL"');?>
                      
                      <option value="68">HFML</option>
                      <option value="5">HFL</option>
                    </select>

                        </span>


                    </div>
                </div>                


                




            </div>

        </div>
        <div class="n-form-btn-class">
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" />
        </div>
    </form>
</div>



 </tr>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>


<script type="text/javascript">
  function FetchZone(id){
    $('#zone').html('');
    $('#area').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { region_id : id},
      success : function(data){
         $('#zone').html(data);
      }

    })
  }

  function FetchArea(id){
    $('#area').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { zone_id : id},
      success : function(data){
         $('#area').html(data);
      }

    })
  }


    function FetchRoute(id){
    $('#route').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { area_id : id},
      success : function(data){
         $('#route').html(data);
      }

    })
  }

</script>


<script type="text/javascript">
  function FetchItemCategory(id){
    $('#category_id').html('');
    $('#subcategory_id').html('');
    $('#item_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { item_group : id},
      success : function(data){
         $('#category_id').html(data);
      }

    })
  }

  function FetchItemSubcategory(id){
    $('#subcategory_id').html('');
    $('#item_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { category_id : id},
      success : function(data){
         $('#subcategory_id').html(data);
      }

    })
  }


  function FetchItem(id){
    $('#item_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { subcategory_id : id},
      success : function(data){
         $('#items').html(data);
      }

    })
  }


</script>