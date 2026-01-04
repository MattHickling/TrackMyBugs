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
            <?php if (!empty($bug_details['attachments'])): ?>
                <div class="bug-attachments">
                    <h4>Attachments:</h4>
                    <ul>
                        <?php foreach ($bug_details['attachments'] as $attachment): ?>
                            <li>
                                <a href="<?= APP_BASE_URL . '/' . htmlspecialchars($attachment) ?>" target="_blank">
                                    <?= basename($attachment) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <form action="post_bug_closed.php" method="POST" class="mt-3">
        <input type="hidden" name="bug_id" value="<?= (int)$bug_details['id'] ?>">
        <button type="submit" class="btn btn-danger">Close Bug</button>
    </form>

<?php else: ?>
    <p>Bug not found.</p>
<?php endif; ?>
