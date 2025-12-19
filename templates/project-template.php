<?php
if ($project_details): ?>
    <?php if ($project_details): ?>
        <h1 class="ms-4">Project: <?= htmlspecialchars($project_details['name']) ?></h1>

        <p class="ms-4"><strong>Project:</strong> <?= htmlspecialchars($project_details['description']) ?></p>
        <p class="ms-4"><strong>Reported by:</strong> <?= htmlspecialchars($project_details['created_at'] ?? 'Unknown') ?></p>
        <p class="ms-4"><strong>Assigned to:</strong> <?= htmlspecialchars($project_details['language'] ?? 'Unknown') ?></p>
        <p class="ms-4"><strong>Status:</strong> <?= htmlspecialchars($project_details['bug_count']) ?></p>

    <?php else: ?>
        <p>Bug not found.</p>
    <?php endif; ?>
<?php endif; ?>