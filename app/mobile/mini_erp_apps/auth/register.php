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
            $("#loginForm").submit(function (event) {
                event.preventDefault(); // Prevent default form submission

                let mobileNumber = $("#username").val();
                if (!mobileNumber) {
                    alert("Please enter a mobile number");
                    return;
                }

                $.ajax({
                    url: "https://saaserp.ezzy-erp.com/app/mobile/mini_erp_apps/api/mobile_register_api.php",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ "mobile_no": mobileNumber }),
                    success: function (response) {
                        try {
                            let jsonResponse = JSON.parse(response);
                            console.log("API Response: ", jsonResponse);

                            if (jsonResponse.status === "success") {
                                localStorage.setItem("user_mobile", mobileNumber); // Save phone number to local storage
                                if (jsonResponse.otp_verify === "0") {
                                    alert("Registration successful! Please verify your OTP.");
                                }
                                window.location.href = "https://saaserp.ezzy-erp.com/app/mobile/mini_erp_apps/auth/otp.php";
                            } else {
                                alert("Registration failed: " + jsonResponse.message);
                            }
                        } catch (error) {
                            console.error("JSON Parsing Error: ", error);
                            alert("Error processing server response.");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error: ", xhr.responseText);
                        alert("An error occurred: " + xhr.responseText);
                    }
                });
            });
        });
    </script>

    <style>
        .bg-img {
            background-color: var(--theme-color-bgc) !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
        }

        .logo {
            width: 180px;
            margin-top: 4rem;
            margin-bottom: 2rem;
        }

        .login-card {
            background-color: white;
            border-radius: 20px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            min-height: 74vh;
            margin-top: 3rem;
        }
    </style>
</head>

<body class="bg-img">
    <div class="container zoom h-100" style="overflow: hidden;">
        <div class="row h-100 justify-content-center align-items-center">
            <form class="col-md-6 col-lg-4 p-0" id="loginForm">
                <div class="login-card">
                    <div class="mb-3">
                        <label for="username" class="form-label">Mobile Number</label>
                        <input type="text" name="uid" class="form-control" id="username" placeholder="+880" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-login w-100">Next</button>
                    <div class="text-center mt-3">
                        <a href="index.php" class="forgot-password">Already have an account?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
