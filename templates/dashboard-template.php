<?php
// session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require '../config/config.php';
require '../vendor/autoload.php';

use Src\Classes\Bug;

$bugRepo = new Bug($conn);

// include '../templates/header.php';
?>

<div class="container-fluid mt-1 text-center">
    <h3>Live Bugs</h3>
    <table id="live_bugs" class="table table-striped">
        <thead>
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

<script src="/TrackMyBugs/public/assets/js/jquery-3.6.0.min.js"></script>
<script src="/TrackMyBugs/public/assets/js/bootstrap.bundle.min.js"></script>
<script src="/TrackMyBugs/public/assets/datatables/js/datatables.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#live_bugs').DataTable({
        ajax: '/TrackMyBugs/public/api/live_bugs.php',
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
        var data = table.row(this).data();
        if (!data || !data.id) return;
        window.location.href = '/TrackMyBugs/public/bug.php?id=' + data.id;
    });
});
</script>

<?php include '../templates/footer.php'; ?>
