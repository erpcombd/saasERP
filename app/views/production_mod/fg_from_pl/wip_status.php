<?php
session_start();
ob_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='WIP Status';

?>

<div class="content">
        <div class="container-fluid">


            <div class="row">
			
			<?





            $wq='select warehouse_id,sum(item_in-item_ex) as qty from journal_item group by warehouse_id';
            $wquery=db_query($wq);
            while($wdata=mysqli_fetch_object($wquery)){
                $stock[$wdata->warehouse_id]=$wdata->qty;
            }

            $sql = 'select * from warehouse where use_type="PL"';
            $query = db_query($sql);
            $datas = ['primary', 'secondary', 'success', 'danger', 'warning', 'info'];
            $usedColors = [];
            while ($data = mysqli_fetch_object($query)) {
                do {
                    $randomKey = array_rand($datas);
                    $randomElement = $datas[$randomKey];
                } while (in_array($randomElement, $usedColors));
            
                $usedColors[] = $randomElement;
                ?>

                <div class="col-lg-3 col-md-6 col-sm-6">

                    <div class="card card-stats" style="border: 1px solid orange;">

                        <div class="card-header card-header-<?=$randomElement?> card-header-icon">

                            <div class="card-icon p-0">

                              <i class="fa-solid fa-warehouse"></i>
                            </div>
                            <p class="card-category bold">WIP Qty</p>
							
                            <h3 class="card-title font-siz"><?=number_format($stock[$data->warehouse_id],2)?></h3>

                        </div>

                        <div class="card-footer" style="border-top:1px solid orange">

                            <div class="stats m-0">
                                <h5 class="m-0 font-weight-bold"><?=$data->warehouse_name?></h5>

                            </div>
                            

                        </div>

                    </div>

                </div>

                <?  }?>



            </div>
        </div>
    </div>


<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>