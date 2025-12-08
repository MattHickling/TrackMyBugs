<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/font-awesome.css">
    <link rel="stylesheet" href="../public/assets/css/login.css">
    <title>Create Account</title>
</head>
<body class="bg-light">
<div class="container p-5 d-flex flex-column align-items-center">

    <?php if (!empty($message)): ?>
        <div class="toast align-items-center text-white border-0" 
             role="alert" aria-live="assertive" aria-atomic="true"
             style="background-color: <?php echo $toastClass ?? '#28a745'; ?>;">
            <div class="d-flex">
                <div class="toast-body"><?php echo $message; ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" 
                        data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <form method="post" class="form-control mt-5 p-4" action="register.php"
          style="width:380px; box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px,
                 rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
        <div class="text-center mb-3">
            </i>
            <h5 class="p-2" style="font-weight: 700;">Create Your Account</h5>
        </div>

        <div class="mb-2">
            <label for="first_name"></i> First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>

        <div class="mb-2">
            <label for="surname"></i> First Name</label>
            <input type="text" name="surname" id="surname" class="form-control" required>
        </div>

        <div class="mb-2">
            <label for="email"></i> Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-2">
            <label for="password"></i> Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100 mt-3">Create Account</button>

        <p class="text-center mt-3" style="font-weight: 600;">
            Already have an account? <a href="?action=login">Login</a>
        </p>
    </form>
</div>

<script src="../public/assets/js/jquery-3.6.0.min.js"></script>
<script src="../public/assets/js/bootstrap.bundle.min.js"></script>
<script>
    let toastElList = [].slice.call(document.querySelectorAll('.toast'))
    let toastList = toastElList.map(function(toastEl) {
        return new bootstrap.Toast(toastEl, { delay: 3000 });
    });
    toastList.forEach(toast => toast.show());
</script>
</body>
</html>
