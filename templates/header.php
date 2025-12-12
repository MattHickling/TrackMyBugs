<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/config.php';

if (!isset($priorities)) {
    $stmt = $conn->prepare("SELECT id, name FROM priorities ORDER BY id ASC");
    $stmt->execute();
    $priorities = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrackMyBugs</title>
    <link href="/TrackMyBugs/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/TrackMyBugs/public/assets/css/font-awesome.css" rel="stylesheet">
    <link href="/TrackMyBugs/public/assets/css/login.css" rel="stylesheet">
    <script src="/TrackMyBugs/public/assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/TrackMyBugs/public/assets/datatables/css/datatables.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="/TrackMyBugs/public/dashboard.php">TrackMyBugs</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-2">
                    <span class="nav-link">Hello, <?php echo htmlspecialchars($_SESSION['first_name']); ?></span>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link" href="/TrackMyBugs/public/logout.php">Logout</a>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBugModal">
                        Add Bug
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="addBugModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <form action="/TrackMyBugs/public/dashboard.php" method="post">
        <div class="mb-2">
          <label for="bug_title" class="form-label">Bug Title</label>
          <input type="text" class="form-control form-control-sm" id="bug_title" name="bug_title" required>
        </div>
        <div class="mb-2">
          <label for="bug_description" class="form-label">Description</label>
          <textarea class="form-control form-control-sm" id="bug_description" name="bug_description" rows="2" required></textarea>
        </div>
         <div class="mb-2">
          <label for="bug_url" class="form-label">Bug URL</label>
          <input type="text" class="form-control form-control-sm" id="bug_url" name="bug_url" required>
        </div>
        <div class="mb-2">
          <label for="priority" class="form-label">Priority</label>
          <select class="form-select form-select-sm" id="priority" name="priority" required>
            <option value="">Select</option>
            <?php foreach ($priorities as $priority): ?>
              <option value="<?php echo $priority['id']; ?>"><?php echo htmlspecialchars($priority['name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-success btn-sm">Add Bug</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="/TrackMyBugs/public/assets/js/jquery-3.6.0.min.js"></script>
<script src="/TrackMyBugs/public/assets/js/bootstrap.bundle.min.js"></script>
