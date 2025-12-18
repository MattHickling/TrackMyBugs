<?php
if ($bug_details): ?>
    <?php if ($bug_details): ?>
        <h1 class="ms-4">Bug: <?= htmlspecialchars($bug_details['title']) ?></h1>

        <p class="ms-4"><strong>Project:</strong> <?= htmlspecialchars($bug_details['project_name']) ?></p>
        <p class="ms-4"><strong>Reported by:</strong> <?= htmlspecialchars($bug_details['reported_by'] ?? 'Unknown') ?></p>
        <p class="ms-4"><strong>Assigned to:</strong> <?= htmlspecialchars($bug_details['assigned_to'] ?? 'Unassigned') ?></p>
        <p class="ms-4"><strong>Status:</strong> <?= htmlspecialchars($bug_details['status_name']) ?></p>
        <p class="ms-4"><strong>Priority:</strong> <?= htmlspecialchars($bug_details['priority_name']) ?></p>
        <p class="ms-4"><strong>Description:</strong> <?= nl2br(htmlspecialchars($bug_details['description'])) ?></p>
        <p class="ms-4"><strong>URL:</strong> <a href="<?= htmlspecialchars($bug_details['bug_url']) ?>" target="_blank"><?= htmlspecialchars($bug_details['bug_url']) ?></a></p>
        <p class="ms-4"><strong>Created at:</strong> <?= htmlspecialchars($bug_details['created_at']) ?></p>

    <?php else: ?>
        <p>Bug not found.</p>
    <?php endif; ?>
<?php endif; ?>
