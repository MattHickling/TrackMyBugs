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
