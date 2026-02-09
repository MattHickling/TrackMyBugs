<?php if ($project_details): ?>
    <div class="project-page ml-3">
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

    <div class="container-fluid mt-1 text-center">
        <h3>Live Bugs</h3>
        <table id="live_project_bugs" class="table table-striped">
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

<?php elseif (!empty($projects)): ?>
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input
                type="text"
                name="q"
                class="form-control"
                placeholder="Search projects"
                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
            >
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <div class="container-fluid py-3 project-list">
    <div class="alert alert-info mb-0 project-list-info">
        Here is all your projects! Click on any project to view details or edit.
    </div>

        <div class="list-group mt-3 project-list-group">
            <?php foreach ($projects as $project): ?>
                <a href="project.php?project_id=<?= (int) $project['id'] ?>"
                class="list-group-item list-group-item-action project-list-item">

                    <strong class="project-title">
                        <?= htmlspecialchars($project['name']) ?>
                    </strong>

                    <div class="project-meta-row">
                        <span>Description:</span>
                        <?= htmlspecialchars($project['description'] ?? '') ?>
                    </div>

                    <div class="project-meta-row">
                        <span>Created:</span>
                        <?= htmlspecialchars($project['created_at'] ?? '') ?>
                    </div>

                    <div class="project-meta-row">
                        <span>Bugs:</span>
                        <?= (int) ($project['bug_count'] ?? 0) ?>
                    </div>

                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <p>Project not found.</p>
<?php endif; ?>
<script src="<?= APP_BASE_URL ?>/assets/js/jquery-3.6.0.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/datatables/js/datatables.min.js"></script>