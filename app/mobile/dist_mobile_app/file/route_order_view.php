<?php
session_start();
require_once "../../../assets/template/layout.top.php";

$do_no = $_GET['v_no'];
$master=findall("select * from sale_do_master where do_no='".$do_no."'");
$sales_type=$master->sales_type;

$dealer_code = $master->dealer_code;
$dealer_type = find1("select dealer_type from dealer_info where dealer_code='".$dealer_code."'");


if($dealer_type==2){ ?>
        <script>window.location.href = "../corporate_sales/sales_order_print_view.php?v_no=<?=$do_no;?>";</script>  

<? }else{ ?>

        <? if($sales_type==6){?>
            <script>window.location.href = "../booking_sales/sales_order_print_view.php?v_no=<?=$do_no;?>";</script>
        <? }else{ ?>
            <script>window.location.href = "../wo/sales_order_print_view.php?v_no=<?=$do_no;?>";</script> 
        <? } ?>    
<? } ?>

