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
            $("#registerForm").submit(function (event) {
                event.preventDefault();

                let mobileNumber = localStorage.getItem("user_mobile");
                let username = $("#username").val().trim();
                let password = $("#password").val().trim();
                let confirmPassword = $("#confirmPassword").val().trim();

                if (!mobileNumber || !username || !password || !confirmPassword) {
                    alert("All fields are required");
                    return;
                }

                if (password !== confirmPassword) {
                    alert("Passwords do not match");
                    return;
                }

                $.ajax({
                    url: "https://saaserp.ezzy-erp.com/app/mobile/mini_erp_apps/api/register_api.php",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ "mobile_no": mobileNumber, "username": username, "password": password }),
                    success: function (response) {
                        try {
                            let jsonResponse = JSON.parse(response);
                            if (jsonResponse.status === "success") {
                                alert("Registration successful!");
                                window.location.href = "https://saaserp.ezzy-erp.com/app/mobile/mini_erp_apps/auth/index.php";
                            } else {
                                alert("Registration failed: " + jsonResponse.message);
                            }
                        } catch (error) {
                            console.error("JSON Parsing Error: ", error);
                            alert("Error processing server response.");
                        }
                    },
                    error: function (xhr) {
                        console.error("Error: ", xhr.responseText);
                        alert("An error occurred during registration.");
                    }
                });
            });
        });
    </script>

</head>

<body class="bg-img">
    <div class="container zoom h-100" style="overflow: hidden;">
        <div class="row h-100 justify-content-center align-items-center">
            <form class="col-md-6 col-lg-4 p-0" id="registerForm">
                <div class="login-card">
                    <div class="mb-1">
                        <label for="username" class="form-label">User Name</label>
                        <input type="text" name="uid" class="form-control" id="username" placeholder="User" required>
                    </div>
                    <div class="mb-1">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="******" required>
                    </div>
                    <div class="mb-1">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" name="password1" class="form-control" id="confirmPassword" placeholder="******" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-login w-100">Next</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
