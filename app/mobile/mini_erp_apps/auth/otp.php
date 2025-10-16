<!doctype html>
<html lang="en" xml:lang="en" style="height: 100%">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Mini ERP Software</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/login/erp_favicon-32x32.png">

    <link href="../assets/styles/bootstrap.v4.4.1.min.css" type="text/css" rel="stylesheet" />
    <link href="../assets/styles/style.css" type="text/css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let mobileNumber = localStorage.getItem("user_mobile");
            if (mobileNumber) {
                $.ajax({
                    url: "https://saaserp.ezzy-erp.com/app/mobile/mini_erp_apps/api/otp_send_api.php",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ "mobile_no": mobileNumber }),
                    success: function (response) {
                        try {
                            let jsonResponse = JSON.parse(response);
                            if (jsonResponse.status === "success") {
                                alert("OTP sent successfully!");
                            } else {
                                alert("Failed to send OTP: " + jsonResponse.message);
                            }
                        } catch (error) {
                            console.error("JSON Parsing Error: ", error);
                            alert("Error processing server response.");
                        }
                    },
                    error: function (xhr) {
                        console.error("Error: ", xhr.responseText);
                        alert("An error occurred while sending OTP.");
                    }
                });
            }

            $("#otpForm").submit(function (event) {
                event.preventDefault();
                let otpCode = $("#otpCode").val();
                if (!otpCode) {
                    alert("Please enter the OTP code");
                    return;
                }
                $.ajax({
                    url: "https://saaserp.ezzy-erp.com/app/mobile/mini_erp_apps/api/otp_verify.php",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ "mobile_no": mobileNumber, "otp": otpCode }),
                    success: function (response) {
                        try {
                            let jsonResponse = JSON.parse(response);
                            if (jsonResponse.status === "success") {
                                alert("OTP verification successful!");
                                window.location.href = "https://saaserp.ezzy-erp.com/app/mobile/mini_erp_apps/auth/registration.php";
                            } else {
                                alert("OTP verification failed: " + jsonResponse.message);
                            }
                        } catch (error) {
                            console.error("JSON Parsing Error: ", error);
                            alert("Error processing server response.");
                        }
                    },
                    error: function (xhr) {
                        console.error("Error: ", xhr.responseText);
                        alert("An error occurred while verifying OTP.");
                    }
                });
            });
        });
    </script>
</head>

<body class="bg-img">
    <div class="container zoom h-100" style="overflow: hidden;">
        <div class="row h-100 justify-content-center align-items-center">
            <form class="col-md-6 col-lg-4 p-0" id="otpForm">
                <div class="login-card">
                    <div class="mb-3">
                        <label for="otpCode" class="form-label">OTP Code</label>
                        <input type="text" name="otp" class="form-control" id="otpCode" placeholder="00000" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-login w-100">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
