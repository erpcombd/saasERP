<?php
    session_start();
    require_once "../engine/routing/default_values.php";
    require_once SERVER_CORE . "core/init.php";
    require_once '../assets/support/ss_function.php';
    //var_dump($_SESSION);

    $title = "Invoice SO Return";
    $page = "invoice_so_return.php";
    //$user_id	=$_SESSION['user_id'];
    $username    = $_SESSION['user']['username'];
    $emp_code = $username;
    require_once '../assets/template/inc.header.php';
    ?>

    <div class="page-content header-clear-medium">
        <form action="" method="post" name="codz" id="codz">

            <div class="card card-style">
                <div class="content mt-0 ms-0 me-0">

                <div class="row mb-1">
                    <div class="col-6">
                    <label for="fdate">Date Form</label>
                    <input type="date" class="form-control validate-text" name="fdate" id="fdate" value="<?= $_POST['fdate'] ? $_POST['fdate'] : date('Y-m-01') ?>" />
                    </div>
					
                    <div class="col-6">
                    <label for="tdate">Date To</label>
                    <input type="date" class="form-control validate-text" name="tdate" id="tdate" value="<?= $_POST['tdate'] ? $_POST['tdate'] : date('Y-m-d') ?>" />
                    </div>
					
					<div class="col-6">
                    <? $field='route_id';?>
						<label for="<?=$field?>">Route Name</label>

							<select name="<?=$field?>" id="<?=$field?>" class="form-select form-control" onchange="FetchShopList(this.value)" >
									<? if($_POST['route_id']>0){ ?>
										<option value="<?=$_POST['route_id']?>"><?=find1("select route_name from ss_route where route_id='".$_POST['route_id']."'");?></option>
									<? }else{ ?>
									<option></option>
									<? } ?>
									<? optionlist("select s.route_id,r.route_name 
									from ss_route r, ss_shop s where s.route_id=r.route_id and s.emp_code='".$_SESSION['user']['username']."' group by s.route_id order by route_name");?>
							</select>
					
                    </div>
					
					<div class="col-6">
                    <? $field='vendor_id';?>
						<label for="<?=$field?>">Shop Name</label>

							<select name="<?=$field?>" id="<?=$field?>" class="form-select form-control" reqired onChange="getshopData()">
									<? if($_POST['route_id']>0){
										optionlist('select dealer_code,shop_name from ss_shop where status="1" 
										and region_id="'.$region_id.'" and zone_id="'.$zone_id.'" and area_id="'.$area_id.'" and route_id="'.$_POST['route_id'].'" order by shop_name');
									}?>
							</select>
                    </div>
					
					
					<div class="col-6">
								<label for="Category">Category</label>
								<select class="form-select form-control" name="category_id" id="category_id" onchange="FetchItemSubcategory(this.value)">
									<option value="<?=$_SESSION['category_id'];?>"><?=find1("select category_name from item_category where id='".$_SESSION['category_id']."'");?></option>
									<?php optionlist("select id,category_name from item_category where 1 order by category_name"); ?>
								</select>
                    </div>
					
					<div class="col-6">
								<label for="SubCategory">SubCategory</label>
								<select class="form-control validate-text" name="subcategory_id" id="subcategory_id" onchange="FetchItem(this.value)">
				    				<option value="<?=$_SESSION['subcategory_id'];?>"><?=find1("select subcategory_name from item_subcategory where id='".$_SESSION['subcategory_id']."'");?></option>
											<?php 
											if($_SESSION['category_id']>0){$cat_group=" and category_id='".$_SESSION['category_id']."' ";}
											optionlist("select id,subcategory_name from item_subcategory where 1 ".$cat_group." order by subcategory_name"); ?>
								</select>
                    </div>
					
										
					<div class="col-12">
							<label for="SubCategory">Item</label>								
							<select  name="item_id" id="item_id" tabindex="1">
								<option></option>
								<?php if($_SESSION['subcategory_id']>0){ optionlist('select item_id,concat(finish_goods_code,"#",item_name) from item_info where 1 and status_sec=1 and subcategory_id="'.$_SESSION['subcategory_id'].'" and status="Active" order by item_name'); } ?>
							</select>
                    </div>
					
                </div>
                
	
	
                    <div class="d-flex justify-content-center row m-0 mt-3">
                        <div class="col-6">
                            <input class="b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" type="submit" name="submitit" id="submitit" value="View" />
                        </div>
                    </div>
                </div>
        </form>
		
 <?php	if(isset($_POST['submitit'])){
			if($_POST['fdate']!=''&&$_POST['tdate']!='')
			$con .= 'and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
			
			if($_POST['vendor_id']!='')
			$shop_con .= 'and c.dealer_code = "'.$_POST['vendor_id'].'"';
						
			if($_POST['item_id']!='')
			$item_con .= 'and c.item_id = "'.$_POST['item_id'].'"';
?>
<div class="card card-style">
					<div class="content ms-0 me-0">
					<div class="table-responsive pt-3" style="zoom: 70%;">
					<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;">
						<thead>
							<tr class="bg-night-light1">
								<th scope="col" class="color-white">Order No</th>
								<th scope="col" class="color-white"> Chalan No</th>
								<th scope="col" class="color-white"> Chalan Date</th>
								<th scope="col" class="color-white"> Shop Name</th>
								<!-- <th scope="col" class="color-white"> Replace Qty</th> -->
								<th scope="col" class="color-white">Delivery Amount</th>
								<th scope="col" class="color-white"> Action</th> 

							</tr>
						</thead>
						<tbody>	
							<?php
								$sql = "select c.do_no,c.chalan_date,c.chalan_no,s.shop_name, s.*,sum(c.total_amt) as total_amt 
                             from ss_shop s,ss_do_chalan c 
                             where s.dealer_code=c.dealer_code
                             and c.entry_by='".$emp_code."'
                             " .$con.$shop_con.$item_con. "
                             group by c.chalan_no order by c.chalan_no DESC";
                 
                         $query = mysqli_query($conn, $sql);
                         while ($data = mysqli_fetch_object($query)) {
							?>		
								<tr>
									<td style=" color: green; font-weight: bold;"><?= $data->do_no; ?></td>
									<td><?= $data->chalan_no; ?></td>
									<td style=" color: #0069b5; font-weight: bold;"><?= $data->chalan_date ?></td>
									<td><?=$data->shop_name; ?> </td>
									<td><?=$data->total_amt; ?></td>
									
									<td class="d-flex gap-2 p-0">
										<a href="return_sales_invoice.php?challan=<?=$data->chalan_no;?>"> <button type="button" class=" b-n btn btn-info btn-3d btn-block  text-light w-100"><i class="fa-solid fa-pen-to-square"></i></button></a>
									</td> 
								</tr>

							<?php } ?>
						</tbody>
					</table>
				</div>
		</div>		
	</div>

	<?php } ?>
</div>
       
    </div> 
    <!-- End of Page Content-->


<?php require_once '../assets/template/inc.footer.php';
selected_two("#vendor_id");
selected_two("#category_id");
selected_two("#subcategory_id");
selected_two("#item_id");
?>


<script>
function getshopData(){
var id = document.getElementById("vendor_id").value;
		jQuery.ajax({
			url:'ajax_location.php',
			type:'post',
			data:'id='+id,
			success:function(result){
				var json_data=jQuery.parseJSON(result);

				jQuery('#latitude2').val(json_data.lat2);
				jQuery('#longitude2').val(json_data.long2);
			}
		})
}
</script> 

<script>
function FetchShopList(id){
    $('#vendor_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { route_id : id},
      success : function(data){
         $('#vendor_id').html(data);
      }

    })
  }

</script> 
<script type="text/javascript">
  function FetchItemCategory(id){
    $('#category_id').html('');
    $('#subcategory_id').html('');
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
         $('#item_id').html(data);
      }

    })
  }


</script>