<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';

if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT id, message 
                            FROM notifications 
                            WHERE user_id = ? AND read_at IS NULL
                            ORDER BY created_at DESC
                          ");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $notifications = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

$unread_count = 0;
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS unread_count
                            FROM notifications 
                            WHERE user_id = ? AND read_at IS NULL");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $unread_count = $result['unread_count'] ?? 0;
}

if (!isset($priorities)) {
    $stmt = $conn->prepare("SELECT id, name FROM priorities ORDER BY id ASC");
    $stmt->execute();
    $priorities = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

if (!isset($users)) {
    $stmt = $conn->prepare("SELECT id, first_name, surname FROM users ORDER BY id ASC");
    $stmt->execute();
    $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/assets/css/font-awesome.css">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/assets/css/login.css">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/assets/datatables/css/datatables.min.css">

    <script src="<?= APP_BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= APP_BASE_URL ?>/dashboard.php">TrackMyBugs</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-2">
                    <button type="button" class="btn btn-success btn-sm d-flex flex-column align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addBugModal" style="width: 80px; height: 80px;">
                        <span style="font-size: 24px; line-height: 1;">+</span>
                        <small>Bug</small>
                    </button>
                </li>
                <li class="nav-item me-2">
                    <button type="button" class="btn btn-success btn-sm d-flex flex-column align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addProjectModal" style="width: 80px; height: 80px;">
                        <span style="font-size: 24px; line-height: 1;">+</span>
                        <small>Project</small>
                    </button>
                </li>

                <?php if (isset($_GET['id'])):?>
                  <li class="nav-item me-2">
                      <button type="button" class="btn btn-success btn-sm d-flex flex-column align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addCommentModal" style="width: 80px; height: 80px;">
                          <span style="font-size: 24px; line-height: 1;">+</span>
                          <small>Comment</small>
                      </button>
                  </li>
                <?php endif; ?>
                <li class="nav-item me-2" >
                    <a class="btn btn-primary nav-link text-white" href="<?= APP_BASE_URL ?>/dashboard.php">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item me-2 position-relative">
                  <a class="btn btn-primary nav-link text-white" href="<?= APP_BASE_URL ?>/profile.php">
                      Profile
                      <?php if ($unread_count > 0): ?>
                          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                              <?= $unread_count ?>
                              <span class="visually-hidden">unread notifications</span>
                          </span>
                      <?php endif; ?>
                  </a>
              </li>
                <li class="nav-item me-2">
                    <a class="btn btn-dark nav-link text-warning" href="<?= APP_BASE_URL ?>/logout.php">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- <div id="notification-container" style="position: fixed; top: 1rem; right: 1rem; z-index: 1050;"></div> -->
<div class="modal fade" id="addBugModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">

      <form action="<?= APP_BASE_URL ?>/bug.php" method="post" enctype="multipart/form-data">

        <div class="mb-2">
          <label for="project_id" class="form-label">
            Which Project Does This Bug Belong To?
          </label>
          <select class="form-select form-select-sm" id="project_id" name="project_id" required>
            <option value="">Select</option>
            <?php foreach ($projects as $project): ?>
              <option value="<?= $project['id']; ?>">
                <?= htmlspecialchars($project['name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-2">
          <label for="bug_title" class="form-label">Bug Title</label>
          <input
            type="text"
            class="form-control form-control-sm"
            id="bug_title"
            name="bug_title"
            required
          >
        </div>

        <div class="mb-2">
          <label for="bug_description" class="form-label">Description</label>
          <textarea
            class="form-control form-control-sm"
            id="bug_description"
            name="bug_description"
            rows="2"
            required
          ></textarea>
        </div>

        <div class="mb-2">
          <label for="bug_url" class="form-label">Bug URL</label>
          <input
            type="text"
            class="form-control form-control-sm"
            id="bug_url"
            name="bug_url"
            required
          >
        </div>

        <div class="mb-2">
          <label for="assigned_to" class="form-label">Assigned To</label>
          <select class="form-select form-select-sm" id="assigned_to" name="assigned_to" required>
            <option value="">Select</option>
            <?php foreach ($users as $user): ?>
              <option value="<?= $user['id']; ?>">
                <?= htmlspecialchars($user['first_name'] . ' ' . $user['surname']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-2">
          <label for="priority" class="form-label">Priority</label>
          <select class="form-select form-select-sm" id="priority" name="priority" required>
            <option value="">Select</option>
            <?php foreach ($priorities as $priority): ?>
              <option value="<?= $priority['id']; ?>">
                <?= htmlspecialchars($priority['name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-2">
          <label for="attachments" class="form-label">
            Attachments
          </label>
          <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
        </div>

        <div class="text-end">
          <button type="submit" class="btn btn-success btn-sm">
            Add Bug
          </button>
        </div>

      </form>

    </div>
  </div>
</div>



<div class="modal fade" id="addProjectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <form action="<?= APP_BASE_URL ?>/project.php" method="post">
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
      <form action="<?= APP_BASE_URL ?>/comment.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
              <input type="hidden" id="bug_id" name="bug_id" value="<?= (int)$_GET['id']; ?>">
              <input type="hidden" id="user_id" name="user_id" value="<?= (int)$_SESSION['user_id']; ?>">
              <label for="comment" class="form-label">Comment</label>
              <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
          </div>

          <div class="mb-3">
              <label for="attachments" class="form-label">Attachments</label>
              <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
          </div>

          <div class="text-end">
              <button type="submit" class="btn btn-success btn-sm">Add Comment</button>
          </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<script src="<?= APP_BASE_URL ?>/assets/js/jquery-3.6.0.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>

