<?php if ($bug): ?>
<div class="container-fluid py-3">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Edit Bug</h5>
        </div>

        <form method="POST">
            <input type="hidden" name="bug_id" value="<?= (int)$bug['id'] ?>">

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="<?= htmlspecialchars($bug['title']) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea
                        name="description"
                        class="form-control"
                        rows="4"
                        required
                    ><?= htmlspecialchars($bug['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-select">
                        <option value="1">Low</option>
                        <option value="2">Medium</option>
                        <option value="3">High</option>
                        <option value="4">Critical</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bug URL</label>
                    <input
                        type="url"
                        name="bug_url"
                        class="form-control"
                        value="<?= htmlspecialchars($bug['bug_url']) ?>"
                    >
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
