<?php
// session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require '../config/config.php';
require '../vendor/autoload.php';

use Src\Classes\Bug;
use Src\Classes\Project;

$bugRepo = new Bug($conn);
$projectRepo = new Project($conn);
?>

<div class="dashboard-page py-3">
    <div class="container-fluid">

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Projects</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="live_projects" class="table table-hover table-striped align-middle mb-0">
                        <thead class="text-black bg-light">
                            <tr>
                                <th>Project ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created</th>
                                <th>Language</th>
                                <th>No. of Bugs</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Live Bugs</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="live_bugs" class="table table-hover table-striped align-middle mb-0">
                        <thead class="text-black bg-light">
                            <tr>
                                <th>Bug ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Project</th>
                                <th>Assigned To</th>
                                <th>Priority</th>
                                <th>Reported By</th>
                                <th>Status</th>
                                <th>Bug URL</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="<?= APP_BASE_URL ?>/assets/js/jquery-3.6.0.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/datatables/js/datatables.min.js"></script>

<script>
$(document).ready(function() {

    var projectTable = $('#live_projects').DataTable({
        ajax: '<?= APP_BASE_URL ?>/api/live_projects.php',
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'description' },
            { data: 'created_at' },
            { data: 'language' },
            { data: 'bug_count' }
        ]
    });

    $('#live_projects tbody').on('click', 'tr', function () {
        var data = projectTable.row(this).data();
        if (!data || !data.id) return;
        window.location.href = '<?= APP_BASE_URL ?>/project.php?project_id=' + data.id;
    });

    var bugTable = $('#live_bugs').DataTable({
        ajax: '<?= APP_BASE_URL ?>/api/live_bugs.php',
        columns: [
            { data: 'id' },
            { data: 'title' },
            { data: 'description' },
            { data: 'project_name' },
            { data: 'assigned_to' },
            { data: 'priority_name' },
            { data: 'reported_by' },
            { data: 'status_name' },
            { data: 'bug_url' },
            { data: 'created_at' }
        ]
    });

    $('#live_bugs tbody').on('click', 'tr', function () {
        var data = bugTable.row(this).data();
        if (!data || !data.id) return;
        window.location.href = '<?= APP_BASE_URL ?>/bug.php?id=' + data.id;
    });

});
</script>

<?php include '../templates/footer.php'; ?>
