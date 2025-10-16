<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Offer";
$page = 'offer.php';

require_once '../assets/template/inc.header.php';

?>



    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>


        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        
        .popup-container {
            position: relative;
            width: 100%;
            max-width: 500px;
        }
        
        .popup-trigger {
            margin-bottom: 20px;
        }
        
        .circular-popup {
            background-color: #e9ecef;
            border-radius: 5% 5% 5% 5%;
            padding: 25px 15px 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        
        .popup-header {
            text-align: center;
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #adb5bd;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .popup-table th {
            background-color: #495057;
            color: white;
        }
        
        .popup-table tr:nth-child(odd) {
            background-color: #dee2e6;
        }
        
        .popup-table tr:nth-child(even) {
            background-color: #e9ecef;
        }
        
        .popup-table td, .popup-table th {
            padding: 12px 15px;
            text-align: center;
        }
        
        .modal-backdrop {
            background-color: rgba(0,0,0,0.5);
        }
        .btn-close {
    background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    opacity: .5;
    padding: 0.5rem;
    transition: opacity .3s ease;
}

.btn-close:hover {
    opacity: 1;
}

.circular-popup {
    position: relative; /* Needed for absolute positioning of close button */
}
    </style>
    
</head>
<body>
    <div class="container popup-container">
        <div class="popup-trigger text-center">
            <button class="btn btn-primary" id="openPopupBtn">Show Popup</button>
        </div>
        
        <!-- The Modal -->
        <div class="modal fade" id="popupModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 bg-transparent">
                    <div class="circular-popup">
                        <button id="closePopupBtn" class="btn-close position-absolute" style="top: 10px; right: 15px;" aria-label="Close"></button>
                        <div class="popup-header">Offer</div>
                        <div class="table-responsive">
                            <table class="table popup-table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Slab</th>
                                        <th>Gift Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1 Lac Taka </td>
                                        <td>Oven</td>
                                    </tr>
                                    <tr>
                                        <td>2 Lac Taka</td>
                                        <td>Nepal Tour</td>
                                    </tr>
                                    <tr>
                                        <td>3 Lac Taka</td>
                                        <td>Cox's Bazar Tour</td>
                                    </tr>
                                    <tr>
                                        <td>1 Lac Taka</td>
                                        <td>Rice Cooker</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
     





     document.addEventListener('DOMContentLoaded', function() {
    // Hide the button since we don't want manual triggering
    const openPopupBtn = document.getElementById('openPopupBtn');
    if (openPopupBtn) {
        openPopupBtn.style.display = 'none'; // Hide the button
    }
    
    const popupModal = new bootstrap.Modal(document.getElementById('popupModal'));
    const closeBtn = document.getElementById('closePopupBtn');
    
    // Function to show the popup
    function showPopup() {
        popupModal.show();
    }
    
    // Add event listener to close button
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            popupModal.hide();
        });
    }
    
    // Show popup immediately when page loads
    showPopup();
    
    // Set interval to show popup every 10 seconds
    setInterval(showPopup, 10000);
});
        
    </script>
</body>
</html>


<?php 
 require_once '../assets/template/inc.footer.php';

 ?>