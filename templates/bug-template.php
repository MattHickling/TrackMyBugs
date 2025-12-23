<?php if ($bug_details): ?>
    <div class="bug-page">
        <div class="bug-header">
            <h1>Bug: <?= htmlspecialchars($bug_details['title']) ?></h1>
        </div>

        <div class="bug-meta">
            <p><strong>Project:</strong> <?= htmlspecialchars($bug_details['project_name']) ?></p>
            <p><strong>Reported by:</strong> <?= htmlspecialchars($bug_details['reported_by'] ?? 'Unknown') ?></p>
            <p><strong>Assigned to:</strong> <?= htmlspecialchars($bug_details['assigned_to'] ?? 'Unassigned') ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($bug_details['status_name']) ?></p>
            <p><strong>Priority:</strong> <?= htmlspecialchars($bug_details['priority_name']) ?></p>
            <p><strong>Description:</strong><br>
                <?= nl2br(htmlspecialchars($bug_details['description'])) ?>
            </p>
            <p><strong>URL:</strong>
                <a href="<?= htmlspecialchars($bug_details['bug_url']) ?>" target="_blank">
                    <?= htmlspecialchars($bug_details['bug_url']) ?>
                </a>
            </p>
            <p><strong>Created at:</strong> <?= htmlspecialchars($bug_details['created_at']) ?></p>
        </div>
    </div>
<?php else: ?>
    <p>Bug not found.</p>
<?php endif; ?>
