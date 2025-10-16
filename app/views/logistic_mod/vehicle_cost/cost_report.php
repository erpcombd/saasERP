<?

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$tabel = 'vehicle_req_list';

$title = "Cost Report List";

$table = 'vehicle_cost_master';

$cost_no = $_GET["id"];
$req_no = $_GET["req_no"];

$vehicle_qry = 'SELECT * FROM vehicle_information WHERE 1';
$vehicle_res = db_query($vehicle_qry);
while($vehicle_rows = mysqli_fetch_object($vehicle_res)){
    $vehicle_name[$vehicle_rows->id] = $vehicle_rows->vehicle_model;
}

$driver_qry = 'SELECT * FROM  vehicle_driver_info WHERE 1';
$driver_res = db_query($driver_qry);
while($driver_rows = mysqli_fetch_object($driver_res)){
    $driver_name[$driver_rows->id] = $driver_rows->d_name;
}

$costType_qry = 'SELECT * FROM  vehicle_cost_type WHERE 1';
$costType_res = db_query($costType_qry);
while($costType_rows = mysqli_fetch_object($costType_res)){
    $cost_name[$costType_rows->id] = $costType_rows->cost_name;
}

$req_info = 'SELECT * FROM vehicle_cost_master  WHERE id = "'.$_GET["id"].'" ';
$req_res=db_query($req_info);
$req_rows = mysqli_fetch_object($req_res);

$cost_qry = 'SELECT * FROM vehicle_req_cost  WHERE cost_id = "'.$_GET["id"].'" AND  req_no = "'.$_GET["req_no"].'"';
$cost_res=db_query($cost_qry);
 
$v_req_info = 'SELECT * FROM vehicle_req_list  WHERE id = "'.$req_no.'" ';
$v_req_res=db_query($v_req_info);
$v_req_rows = mysqli_fetch_object($v_req_res);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Voucher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .header {
            text-align: center;
        }
        .header h2 {
            margin: 5px 0;
        }
        .invoice-btn {
            text-align: center;
            margin: 10px 0;
        }
        .invoice-btn button {
            margin: 5px;
            padding: 5px 10px;
        }
        .info {
            border: 1px solid #000;
            padding: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table, .table th, .table td {
            border: 1px solid #000;
        }
        .table th, .table td {
            padding: 10px;
            text-align: left;
        }
        .footer {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Logistic Mod</h2>
            <p>Mirpur Dohs Road 16</p>
            <p>Tel: +880 184 100 000, Email: ceo@erp.com.bd</p>
            <h3>VEHICLE TRIP REPORT</h3>
        </div>
        <div class="invoice-btn">
            <!-- <button>Print</button>
            <button>Excel</button>
            <button>Client Copy</button> -->
        </div>
        <div class="info">
            <p>Cost NO: <strong><?=$req_no ?></strong> &nbsp;&nbsp; ENTRY DATE: <strong><?=$req_rows->entry_date?></strong> &nbsp;&nbsp; Trip NO: <strong><?=$cost_no?></strong></p>
            <p>Concern :<strong></strong> &nbsp;&nbsp; Type :<strong></strong> </p>

        </div>
        <table class="table">
            <tr>
                <th>Cost Type</th>
                <th>Note</th>
                <th>Amount</th>
            </tr>
            <? while($cost_rows = mysqli_fetch_object($cost_res)){?>
                <tr>
                    <td><?=$cost_name[$cost_rows->cost_type]?></td>
                    <td><?=$cost_rows->note?></td>
                    <td><?=$cost_rows->cost_amt?></td>
                </tr>
            <? 
                $total_cost += $cost_rows->cost_amt;
                }?>
            <tr>
                <td  colspan="2" style="text-align: right;"><strong>Total Taka:</strong></td>
                <td><strong><?=$total_cost?></strong></td>
            </tr>

            <tr>
                <td  colspan="3" style="text-align: right;"></td>
            </tr>
            
            <? if( $v_req_rows->customer_info > 0 ){ ?>    
            <tr>
                <th colspan="2">Customer Name</th>
                <th>Rent Amount</th>
            </tr>
            <tr>
                <td colspan="2"><?=find_a_field('customer_list','customer_name','id ="'.$v_req_rows->customer_info.'" ');?></td>
                <td><?=$v_req_rows->rent_amt?></td>
            </tr>
            <? } ?>
        </table>
    </div>
</body>
</html>