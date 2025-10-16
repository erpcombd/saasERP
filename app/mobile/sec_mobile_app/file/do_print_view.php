<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$page = "reports";

require_once '../assets/template/inc.header.php';

$user_id = $_SESSION['user_id'];
$order_no = $_GET['do'];
$sql = 'SELECT a.shop_name, a.shop_address, a.mobile, b.* FROM ss_do_master b, ss_shop a 
        WHERE b.do_no="' . $order_no . '" AND a.dealer_code=b.dealer_code';
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_object($result);
$depot_info = findall("SELECT * FROM dealer_info WHERE dealer_code = '".$row->depot_id."' ");
if ($_GET['v'] > 0) {
	 $chalan_no = $_GET['v'];
	$chalan_info = findall("SELECT * FROM ss_do_chalan WHERE chalan_no='" . $chalan_no . "' LIMIT 1");
	$dealer_code = $chalan_info->dealer_code;
	$dealer = findall("SELECT * FROM ss_shop WHERE dealer_code='" . $dealer_code . "'");
	$chalan_amount = find1("SELECT SUM(total_amt) FROM ss_do_chalan WHERE chalan_no='" . $chalan_no . "'");
	 $master_dealer = $dealer->master_dealer_code;
	$mdealer = findall("SELECT * FROM dealer_info WHERE dealer_code='" . $master_dealer . "'");
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
	.logo {
		max-width: 150px;
		width: 100%;
		height: auto;
		padding-left: 7px;
	}

	.invoice-header {
		padding: 7px !important;
		font-size: 38px  !important;
		font-weight: bold;
		display: flex;
		background-color: #fff;
		color: #0089D0;
		
	}
		
	.hhs{
		margin-bottom: -23px;	
	}
	
	
	.fds{
		background-color: 	#0089D0;
		color: #fff;
	
	}
	
	.tttt{
		width: 360px;
		margin-bottom:15px;	
	}
	.card{
		font-size: 	22px;
	}

	h1{
	
		color: black;
		font-size:14px;	
	}

	.table1{
		border: 2.1px solid #595959;	
	}

	.td1 {
		background-color: #0089D0 !important;
		color: white !important;
	}

	
	.card-header {
		background-color: #fff;
	}

	.table2 {
		background-color: #fff !important;
		border: 0px;
	}

	.th1 {
		border: 2px solid black;
	}
	.table th {
		background-color: #0089D0;
		color: white;
	}

	.table-bordered {
		border: 2px solid #000;
	}

	.table td {
		vertical-align: middle;
	}

	.btn-print {
		background-color: #0f3193;
		color: white;
		font-weight: bold;
		text-transform: uppercase;
		border: none;
	}

	.btn-print:hover {
		background-color: #1a237e;
	}
	
	.btn-whatsapp {
		background-color: #25D366;
		color: white;
		font-weight: bold;
		text-transform: uppercase;
		border: none;
		margin-left: 5px;
	}
	
	.btn-whatsapp:hover {
		background-color: #128C7E;
	}
	
	.space{
	display:none;
	}
	
	.hhh {
		margin-bottom: -80px;
	}
	

	@media (max-width: 767px) {
		.invoice-header {
			font-size: 32px !important;
			
		}

		.table {
			font-size: 14px;
		}
		.billing-info {
			text-align: left !important;
		}
		
	.card{
		font-size: 14px !important;	
	}
	.logo {
		max-width: 100px;
		width: 100%;
		height: auto;
		
		
	}
	h1{
	
		font-size:10px;	
	}
	.invoice-header {
		margin-bottom: 16px;
	}
	}

	
	/* Print Styles */
	@media print {
		    @page {
		  size: A4; /* Set page size to A4 */
		  margin: 1cm; /* Set margins */
		}
		.space{
		display: block !important;}
		.online-message,.offline-message,.back_button{
		display:none !important;
		}
		.container,
		#print,
		.card,
		.content,
		.page-content,
		.card-header,
		.row {
			width: 100% !important;
			margin: 0px !important;
			padding: 0px !important;

		}
		
	.hhs{
		padding:25px;	
	}

		#printButton, #whatsappButton {
			display: none;
		}

		#page,
		#footer,
		.opacity-30 {
			display: none !important;
		}

		.footer div table {
			width: 100% !important;
		}

		body {
			zoom: 130%;
		}
		.bds{
			width: 99% !important;	
			
		}
		.invoice-header {
			font-size: 32px !important;
			margin-left: -15px !important;
		}
		.logo {
		max-width: 100px;
		width: 100%;
		height: auto;
		padding-left: 7px;
	}
	
	
		
	}
</style>




<!-- Add JavaScript for creating a downloadable PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
// Function to handle WhatsApp sharing with PDF
// Function to handle WhatsApp sharing
function shareViaWhatsApp() {
    // Get the current URL for sharing
    const currentURL = window.location.href;
    
    // Create the message with proper encoding
    const message = "Invoice for <?php echo addslashes($row->shop_name); ?> - Order No: <?php echo $row->do_no; ?> - " + currentURL;
    
    // Detect if device is mobile
    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    
    try {
        if (isMobile) {
            // For mobile devices, use the WhatsApp app via intent
            window.location.href = "https://api.whatsapp.com/send?text=" + encodeURIComponent(message);
        } else {
            // For desktop, open WhatsApp Web
            window.open("https://web.whatsapp.com/send?text=" + encodeURIComponent(message), "_blank");
        }
    } catch (e) {
        console.error("Error sharing via WhatsApp:", e);
        // Fallback option
        alert("Could not open WhatsApp. Please try copying the link manually.");
    }
    
    closeShareMenu();
}

// For future PDF generation capability
function generatePDF() {
    const { jsPDF } = window.jspdf;
    
    // Hide buttons before capturing
    const printButton = document.getElementById('printButton');
    const whatsappButton = document.getElementById('whatsappButton');
    const backButton = document.querySelector('.back_button');
    
    // Save original display values
    const printDisplay = printButton.style.display;
    const whatsappDisplay = whatsappButton.style.display;
    const backDisplay = backButton.style.display;
    
    // Hide buttons
    printButton.style.display = 'none';
    whatsappButton.style.display = 'none';
    backButton.style.display = 'none';
    
    // Capture the invoice
    const invoice = document.querySelector('.card');
    
    html2canvas(invoice, {
        scale: 2,
        useCORS: true,
        logging: true
    }).then(canvas => {
        // Restore button display
        printButton.style.display = printDisplay;
        whatsappButton.style.display = whatsappDisplay;
        backButton.style.display = backDisplay;
        
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'mm', 'a4');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        pdf.save('invoice-<?php echo $row->do_no; ?>.pdf');
    });
}
</script>

<div class="page-content header-clear-medium hhh ">
    <a href="do_status.php" class="back_button"><button class="btn btn-print" style="background-color:#00BCD4 !important; margin-bottom: 3px; margin-left:5px; color: #fff !important;">Back</button></a>
    <button id="printButton" onClick="window.print()" class="btn btn-print">Print</button>
 <!--   <button id="whatsappButton" onClick="shareViaWhatsApp()" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> Share</button>-->

    <div class="row justify-content-between align-items-center mb-0 mt-3 " style="width:100% !important;">
        <div class="col-6">
            <div>
                <a href="#" class="btn-m btn-full invoice-header text-uppercase font-900">Order</a>
            </div>
        </div>

        <div class="col-6 hhs text-end">
            <h1>Authorized Distributor</h1>
            <img src="../assets/images/logo/Logo MEP Png.png" alt="Logo" class="logo">
        </div>
    </div>
</div>
<br />
<div class="card card-style pt-2 m-0 p-3" style="zoom: 50%; width:100% !important;">

    <div class="content m-0">
        <div class="row mb-0">
            <!-- Page Content -->
            <div class="container mt-4">
                <div class="row">
                    <!-- Shop Details -->
                    <div class="col-6 table-responsive mb-2">
                        <table cellspacing="0" cellpadding="2" border="0">
                            <thead>
                                <tr>
                                    <td width="25%">Retailer Code</td>
                                    <td width="3%">:</td>
                                    <td width="60%"><?php echo $row->dealer_code ?></td>
                                </tr>
                                <tr>
                                    <td>Retailer Name</td>
                                    <td>:</td>
                                    <td><?php echo $row->shop_name ?></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td><?php echo $row->shop_address ?></td>
                                </tr>
                                <tr>
                                    <td>Mobile No</td>
                                    <td>:</td>
                                    <td><?php echo $row->mobile ?></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    
                    <!-- Invoice Details -->
                    <div class="col-6 table-responsive justify-content-end d-flex mb-2 ">
                        <table cellspacing="0" cellpadding="2" border="0">
                            <thead>
                                <tr>
                                    <td width="32%">Distributor Name</td>
                                    <td width="3%">:</td>
                                    <td width="60%"><?= $depot_info->dealer_name_e; ?></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td class="table2"><?=$depot_info->address_e;?></td>
                                </tr>
                                <tr>
                                    <td>Mobile No</td>
                                    <td>:</td>
                                    <td><?=$depot_info->mobile_no;?></td>
                                </tr>
                                <tr>
                                    <td>Order No</td>
                                    <td>:</td>
                                    <td><?php echo $row->do_no ?></td>
                                </tr>
                                <tr>
                                    <td>Order Date:</td>
                                    <td>:</td>
                                    <td><?php echo $row->do_date ?></td>
                                </tr>
                               <?php /*?> <tr>
                                    <td class="table2">Challan Date </td>
                                    <td>:</td>
                                    <td><?= $chalan_info->chalan_date ?></td>
                                </tr><?php */?>
                            </thead>
                        </table>
                    </div>
                </div>


                <!-- Order Table -->
                <div class="table-responsive mt-4">
                    <table class="table text-center mb-4 table-bordered shadow-l bds table1" style="overflow: hidden; margin:0px;">
                        <thead class="th1">
                            <tr class="bg-night-light text-center">
                               <!-- <th>SL</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>QTY</th>
                                <th>TP</th>
                                <th>Total TP Amt</th-->
								<th scope="col" class="color-white">SL</th>
							<th >Item Code</th>
							<th >Item Name</th>
							<th >QTY</th>
							<th >TP</th>
							<th style="display: none;">NSP</th>
							<th style="display: none;">Offer %</th>
							<th >Total TP Amt</th>
							<th style="display: none;">Total NSP Amt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = 'select a.id,b.finish_goods_code,b.item_name,b.unit_name, a.t_price as tp,a.nsp_per,a.stock,a.unit_price as rate,a.pkt_unit as pcs,a.total_amt  as amt ,a.total_tp from ss_do_details a,item_info b where b.item_id=a.item_id and a.do_no=' . $order_no . ' order by a.id';
                            $query = mysqli_query($conn, $res);
                            $sl = 1;
                            $sum_tp_amt = 0;
                            while ($data = mysqli_fetch_object($query)) {
                             
                            ?>
                               <?php /*?> <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $data->finish_goods_code; ?></td>
                                    <td><?php echo $data->item_name; ?></td>
                                    <td><?php echo $data->pcs; ?></td>
                                    <td><?php echo number_format($data->tp, 2); ?></td>
                                    <td><?php echo number_format($data->total_tp, 2); ?></td>
                                </tr><?php */?>
								
								<tr>
								<td class="table1"><?= $sl++ ?></td>
								<td class="table1" align="left"><?= $data->finish_goods_code ?></td>
								  <td><?php echo $data->item_name; ?></td>
								<td class="table1"><?= $data->pcs;
													$gqty += $data->pcs; ?></td>
								<td class="table1"><?= floatval($data->tp); ?></td>
								<td style="display: none;" class="table1"><?= floatval($data->rate); ?></td>
								<td style="display: none;" class="table1"><?= floatval($data->nsp_per); ?></td>
								<td class="table1"><?= floatval($data->total_tp);
													$sum_tp_amt += $data->total_tp; ?></td>
								<td style="display: none;" class="table1"><?= $data->amt;
													$sum_nsp_amt += $data->amt; ?></td>
							</tr>
                            <?php } ?>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Total</td>
                                <td><?php echo number_format($sum_tp_amt, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row mb-0">
                    <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end">
                        <table class="footer-table table-bordered table1 tttt">
                            <tr>
                                <td width="65%">Total TP Amount</td>
                                <td width="65%" align="center"><?= number_format($sum_tp_amt += $data->total_tp, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Discount Amount</td>
                                <td align="center"><?= number_format($sum_dis_amt = $sum_tp_amt - $sum_nsp_amt, 2); ?></td>
                            </tr>
                            <tr class="fds">
                                <td>Net Payable Amount</td>
                                <td align="center"><?= number_format($sum_nsp_amt, 2); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../assets/template/inc.footer.php';
?>