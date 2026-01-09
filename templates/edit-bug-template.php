<?php 
$bug = null;
if (isset($_GET['id'])) {
    $bug = $bugRepo->getBug((int)$_GET['id']);
}

$users = $conn->query("SELECT id, first_name, surname FROM users ORDER BY first_name ASC")->fetch_all(MYSQLI_ASSOC);

if ($bug): ?>
<div class="container-fluid py-3">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Edit Bug</h5>
        </div>

        <form method="POST" action="edit_bug.php?id=<?= (int)$bug['id'] ?>">
            <input type="hidden" name="bug_id" value="<?= (int)$bug['id'] ?>">

            <div class="card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control"
                        value="<?= htmlspecialchars($bug['title']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="4"
                        required
                    ><?= htmlspecialchars($bug['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select id="priority" name="priority" class="form-select">
                        <option value="1" <?= $bug['priority_name'] === 'Low' ? 'selected' : '' ?>>Low</option>
                        <option value="2" <?= $bug['priority_name'] === 'Medium' ? 'selected' : '' ?>>Medium</option>
                        <option value="3" <?= $bug['priority_name'] === 'High' ? 'selected' : '' ?>>High</option>
                        <option value="4" <?= $bug['priority_name'] === 'Critical' ? 'selected' : '' ?>>Critical</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="bug_url" class="form-label">Bug URL</label>
                    <input
                        type="text"
                        id="bug_url"
                        name="bug_url"
                        class="form-control"
                        value="<?= htmlspecialchars($bug['bug_url'] ?? '') ?>"
                        placeholder="Optional URL"
                    />
                </div>

                <div class="mb-3">
                    <label for="assigned_to" class="form-label">Assigned To</label>
                    <select id="assigned_to" name="assigned_to" class="form-select">
                        <option value="0" <?= $bug['assigned_to'] === null ? 'selected' : '' ?>>Unassigned</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>" <?= ($bug['assigned_to'] == $user['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($user['first_name'] . ' ' . ($user['last_name'] ?? '')) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="card-footer bg-white">
                <button type="submit" class="btn btn-success">
                    Save Changes
                </button>
                <a href="bug.php?id=<?= (int)$bug['id'] ?>" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
