<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= APP_BASE_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= APP_BASE_URL ?>/assets/css/font-awesome.css" rel="stylesheet">
    <link href="<?= APP_BASE_URL ?>/assets/css/login.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="bg-light">
<div class="container p-5 d-flex flex-column align-items-center">

    <?php if (!empty($message)): ?>
        <div class="toast align-items-center text-white border-0"
             role="alert" aria-live="assertive" aria-atomic="true"
             style="background-color: <?php echo $toastClass; ?>;">
            <div class="d-flex">
                <div class="toast-body"><?php echo $message; ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; 
    ?>

    <form method="post" class="form-control mt-5 p-4" 
          style="width:380px; box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px,
                 rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;" action="login.php">
        <div class="text-center mb-3">
            <h5 class="p-2" style="font-weight: 700;">Login</h5>
        </div>

        <div class="mb-2">
            <label for="email"></i> Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-2">
            <label for="password"></i> Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100 mt-3">Login</button>

        <p class="text-center mt-3" style="font-weight: 600;">
            <a href="?action=register">Create Account</a> | 
            <a href="?action=forgotten">Forgot Password</a>
        </p>

    </form>
</div>

<script src="<?= APP_BASE_URL ?>/assets/js/jquery-3.6.0.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>

<script>
    let toastElList = [].slice.call(document.querySelectorAll('.toast'))
    let toastList = toastElList.map(function(toastEl) {
        return new bootstrap.Toast(toastEl, { delay: 3000 });
    });
    toastList.forEach(toast => toast.show());
</script>
</body>
</html>
