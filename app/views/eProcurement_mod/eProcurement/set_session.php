<?php
session_start();
if (isset($_POST['hidden_rfq_data'])) {
    $_SESSION['rfq_no'] = $_POST['hidden_rfq_data'];
    echo "Session variable set.";
} else {
    echo "No data received.";
}
?>
