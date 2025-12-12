<?php
if ($bug_details): ?>

<h1>Bug<?php echo htmlspecialchars($bug_details['title']); ?></h1>

<?php foreach ($bug_details as $key => $value): ?>
    <strong><?php echo htmlspecialchars($key); ?>:</strong>
    <?php echo htmlspecialchars($value ?? ''); ?><br>
<?php endforeach; ?>

<?php else: ?>

<p>Bug not found.</p>

<?php endif; ?>
