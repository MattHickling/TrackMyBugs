<?php if ($bug_details): ?>
<div class="bug-page py-3">
    <div class="container-fluid">

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    Bug: <?= htmlspecialchars($bug_details['title']) ?>
                </h5>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Project:</strong> <?= htmlspecialchars($bug_details['project_name']) ?></p>
                        <p class="mb-1"><strong>Reported by:</strong> <?= htmlspecialchars($bug_details['reported_by'] ?? 'Unknown') ?></p>
                        <p class="mb-1"><strong>Assigned to:</strong> <?= htmlspecialchars($bug_details['assigned_to'] ?? 'Unassigned') ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Status:</strong> <?= htmlspecialchars($bug_details['status_name']) ?></p>
                        <p class="mb-1"><strong>Priority:</strong> <?= htmlspecialchars($bug_details['priority_name']) ?></p>
                        <p class="mb-1"><strong>Created at:</strong> <?= htmlspecialchars($bug_details['created_at']) ?></p>
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold">Description</h6>
                    <p class="mb-0">
                        <?= nl2br(htmlspecialchars($bug_details['description'])) ?>
                    </p>
                </div>

                <?php if (!empty($bug_details['bug_url'])): ?>
                <div class="mb-3">
                    <h6 class="fw-bold">URL</h6>
                    <a href="<?= htmlspecialchars($bug_details['bug_url']) ?>" target="_blank">
                        <?= htmlspecialchars($bug_details['bug_url']) ?>
                    </a>
                </div>
                <?php endif; ?>

                <?php if (!empty($bug_details['attachments'])): ?>
                <div class="mb-3">
                    <h6 class="fw-bold">Attachments</h6>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($bug_details['attachments'] as $attachment): ?>
                            <li class="list-group-item px-0">
                                <a href="<?= APP_BASE_URL . '/' . htmlspecialchars($attachment) ?>" target="_blank">
                                    <?= htmlspecialchars(basename($attachment)) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>

            <div class="card-footer bg-white">
                <form action="post_bug_closed.php" method="POST" class="d-inline">
                    <input type="hidden" name="bug_id" value="<?= (int)$bug_details['id'] ?>">
                    <button type="submit" class="btn btn-danger">
                        Close Bug
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<?php else: ?>
<div class="container-fluid py-3">
    <div class="alert alert-warning mb-0">
        Bug not found.
    </div>
</div>
<?php endif; ?>
