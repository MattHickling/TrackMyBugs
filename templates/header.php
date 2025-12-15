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


$stmt = $conn->prepare("SELECT id, name FROM projects ORDER BY id ASC");
$stmt->execute();
$projects = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBugModal">
                        Add Bug
                    </button>
                </li>
                <li class="nav-item ml-3">
                    <button type="button" class="btn btn-primary ml-3 btn-sm" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                        Add Project
                    </button>
                </li>
                <?php if (isset($_GET['id'])):?>
                  <li class="nav-item ms-2">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCommentModal">
                        Add Comment
                    </button>
                  </li>
                <?php endif; ?>
                <li class="nav-item me-2">
                    <a class="nav-link" href="/TrackMyBugs/public/profile.php">
                        Profile
                    </a>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link" href="/TrackMyBugs/public/logout.php">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="addBugModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <form action="/TrackMyBugs/public/bug.php" method="post">
        <div class="mb-2">
         <label for="project_id" class="form-label">Project</label>
          <select class="form-select form-select-sm" id="project_id" name="project_id" required>
            <option value="">Select</option>
            <?php foreach ($projects as $project): ?>
              <option value="<?php echo $project['id']; ?>"><?php echo htmlspecialchars($project['name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
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


<div class="modal fade" id="addProjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <form action="/TrackMyBugs/public/project.php" method="post">
        
        <div class="mb-2">
          <label for="name" class="form-label">Project Name</label>
          <input type="text" class="form-control form-control-sm" id="name" name="name" required>
        </div>
        <div class="mb-2">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control form-control-sm" id="description" name="description" rows="2" required></textarea>
        </div>
        <div class="mb-2">
        <label for="language" class="form-label">Language</label>
        <select class="form-select form-select-sm" id="language" name="language" required>
          <option value="">Select</option>
          <?php foreach ($languages as $language): ?>
            <option value="<?php echo $language['id']; ?>">
              <?php echo htmlspecialchars($language['name']); ?>
            </option>
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


<?php if (isset($_GET['id'])): ?>
<div class="modal fade" id="addCommentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <form action="/TrackMyBugs/public/comment.php" method="post">
        <div class="mb-3">

          <input type="hidden" id="bug_id" name="bug_id" value="<?php echo (int)$_GET['id']; ?>">
          <input type="hidden" id="user_id" name="user_id" value="<?php echo (int)$_SESSION['user_id']; ?>">
          
          <label for="comment" class="form-label">Comment</label>
          <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-success btn-sm">Add Comment</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<script src="/TrackMyBugs/public/assets/js/jquery-3.6.0.min.js"></script>
<script src="/TrackMyBugs/public/assets/js/bootstrap.bundle.min.js"></script>
