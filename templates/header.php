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

        <a class="navbar-brand" href="<?= APP_BASE_URL ?>/dashboard.php">
            TrackMyBugs
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto gap-2 mt-3 mt-lg-0">
              <li class="nav-item">
                <button
                    type="button"
                    class="btn btn-success btn-sm d-flex align-items-center justify-content-center px-3 py-2 w-100"
                    data-bs-toggle="modal"
                    data-bs-target="#addBugModal"
                >
                    + Bug
                </button>
              </li>

              <li class="nav-item">
                <button
                    type="button"
                    class="btn btn-success btn-sm d-flex align-items-center justify-content-center px-3 py-2 w-100"
                    data-bs-toggle="modal"
                    data-bs-target="#addProjectModal"
                >
                    + Project
                </button>
              </li>

              <?php if (isset($_GET['id'])): ?>
              <li class="nav-item">
                <button
                    type="button"
                    class="btn btn-success btn-sm d-flex align-items-center justify-content-center px-3 py-2 w-100"
                    data-bs-toggle="modal"
                    data-bs-target="#addCommentModal"
                >
                    + Comment
                </button>
              </li>

                <?php endif; ?>
                <li class="nav-item">
                  <button
                      type="button"
                      class="btn btn-success btn-sm d-flex align-items-center justify-content-center px-3 py-2 w-100"
                      data-bs-toggle="modal"
                      data-bs-target="#addJournalModal">
                      + Journal
                  </button>
                </li>

                <li class="nav-item">
                    <a
                        class="btn btn-primary btn-sm d-flex align-items-center justify-content-center px-3 py-2 w-100 text-white"
                        href="<?= APP_BASE_URL ?>/dashboard.php"
                    >
                        Dashboard
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a 
                      class="btn btn-primary btn-sm dropdown-toggle d-flex align-items-center justify-content-center px-3 py-2 w-100 text-white"
                      href="#"
                      id="entriesDropdown"
                      role="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false"
                    >
                      View
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="entriesDropdown">
                        <li>
                            <a class="dropdown-item" href="<?= APP_BASE_URL ?>/journal.php">
                                Journal Entries
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= APP_BASE_URL ?>/bug.php">
                                Bugs
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= APP_BASE_URL ?>/bug.php">
                                Projects
                            </a>
                        </li>
                        <!-- <li>
                            <a class="dropdown-item" href="<?= APP_BASE_URL ?>/comment.php">
                                Comments
                            </a>
                        </li> -->
                    </ul>
                </li>


                <li class="nav-item position-relative">
                    <a
                        class="btn btn-primary btn-sm d-flex align-items-center justify-content-center px-3 py-2 w-100 text-white"
                        href="<?= APP_BASE_URL ?>/profile.php"
                    >
                        Profile
                        <?php if ($unread_count > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $unread_count ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>

                

                <li class="nav-item">
                    <a
                        class="btn btn-dark btn-sm d-flex align-items-center justify-content-center px-3 py-2 w-100 text-warning"
                        href="<?= APP_BASE_URL ?>/logout.php"
                    >
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
          <button
            type="button"
            class="btn btn-secondary btn-sm px-2 py-1"
            data-bs-dismiss="modal">
            Close
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Journal Entry Modal -->
<div class="modal fade" id="addJournalModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <form action="<?= APP_BASE_URL ?>/journal.php" method="post">
          <div class="mb-2">
              <label for="journal_entry" class="form-label">Entry</label>
              <input
                  type="text"
                  class="form-control form-control-sm"
                  id="journal_entry"
                  name="entry"
                  required
              >
          </div>

          <div class="mb-2">
              <label for="journal_description" class="form-label">Description</label>
              <textarea
                  class="form-control form-control-sm"
                  id="journal_description"
                  name="description"
                  rows="3"
              ></textarea>
          </div>

          <input type="hidden" name="user_id" value="<?= (int)$_SESSION['user_id']; ?>">

          <div class="text-end">
              <button type="submit" class="btn btn-success btn-sm">Add Journal</button>
              <button
                  type="button"
                  class="btn btn-secondary btn-sm px-2 py-1"
                  data-bs-dismiss="modal"
              >
                  Close
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
          <button
                type="button"
                class="btn btn-secondary btn-sm px-2 py-1"
                data-bs-dismiss="modal">
                Close
          </button>
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
              <button
                type="button"
                class="btn btn-secondary btn-sm px-2 py-1"
                data-bs-dismiss="modal">
                Close
              </button>
          </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<script src="<?= APP_BASE_URL ?>/assets/js/jquery-3.6.0.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>

