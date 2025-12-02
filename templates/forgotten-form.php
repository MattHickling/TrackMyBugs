<?php
include '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
          content="width=device-width, 
                   initial-scale=1.0">
    <link href="../public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/font-awesome.css">
    <link rel="stylesheet" href="../public/assets/css/login.css">
    <title>Reset Password</title>
</head>

<body>
    <div class="container p-5 d-flex flex-column align-items-center">
        <form action="../public/forgotten.php" method="post" class="form-control mt-5 p-4"
            style="height:auto; width:380px; box-shadow: rgba(60, 64, 67, 0.3) 
            0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
            <div class="row">
                
                <h5 class="text-center p-4" style="font-weight: 700;">
          Change Your Password</h5>
            </div>
            <div class="col-mb-3 position-relative">
                <label for="email"> Email</label>
                <input type="text" name="email" id="email" 
                  class="form-control" required>
                <span id="email-check" class="position-absolute"
                    style="right: 10px; top: 50%; transform: translateY(-50%);"></span>
            </div>
            <div class="col mb-3 mt-3">
                <button type="submit" class="btn bg-dark" 
                  style="font-weight: 600; color:white;">
                  Reset Password</button>
            </div>
            <div class="col mb-2 mt-4">
                <p class="text-center" style="font-weight: 600;
                color: navy;"><a href="?page=register"
                        style="text-decoration: none;">
                  Create Account</a> OR <a href="?page=login"
                        style="text-decoration: none;">Login</a></p>
            </div>
        </form>
    </div>
    <script src="../public/assets/js/jquery-3.6.0.min.js"></script>
    <script src="../public/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#email').on('blur', function () {
                var email = $(this).val();
                if (email) {
                    $.ajax({
                        url: 'check_email.php',
                        type: 'POST',
                        data: { email: email },
                        success: function (response) {
                            if (response == 'exists') {
                                $('#email-check').html('<i class="fa fa-check 
                                text-success"></i>');
                            } else {
                                $('#email-check').html('<i class="fa fa-times
                                text-danger"></i>');
                            }
                        }
                    });
                } else {
                    $('#email-check').html('');
                }
            });

            let toastElList = [].slice.call(document.querySelectorAll('.toast'))
            let toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl, { delay: 3000 });
            });
            toastList.forEach(toast => toast.show());
        });
    </script>
</body>

</html>