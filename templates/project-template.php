<?php if ($project_details): ?>
<div class="project-page">
    <div class="project-header">
        <h1>Project: <?= htmlspecialchars($project_details['name']) ?></h1>
    </div>

    <div class="project-meta">
        <p><strong>Description:</strong> <?= htmlspecialchars($project_details['description']) ?></p>
        <p><strong>Created:</strong> <?= htmlspecialchars($project_details['created_at'] ?? 'Unknown') ?></p>
        <p><strong>Language:</strong> <?= htmlspecialchars($project_details['language_name']) ?></p>
        <p><strong>Total Bugs:</strong> <?= htmlspecialchars($project_details['bug_count']) ?></p>
    </div>
</div>
<?php else: ?>
<p>Project not found.</p>
<?php endif; ?>

<div class="container-fluid mt-1 text-center">
    <h3>Live Bugs</h3>
    <table id="live_project_bugs" class="table table-striped">
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

<script src="/TrackMyBugs/public/assets/datatables/js/datatables.min.js"></script>
<script>
$(document).ready(function() {
    var bugTable = $('#live_project_bugs').DataTable({
        ajax: {
            url: '/TrackMyBugs/public/api/live_project_bugs.php',
            data: {
                project_id: <?= (int)$project_id ?>
            }
        },
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

    $('#live_project_bugs tbody').on('click', 'tr', function () {
        var data = bugTable.row(this).data();
        if (!data || !data.id) return;
        window.location.href = '/TrackMyBugs/public/bug.php?id=' + data.id;
    });
});
</script>
