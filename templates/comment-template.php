<?php 
use Carbon\Carbon;

if (isset($comment_details)): 
    $createdAt = Carbon::parse($comment_details['created_at']);
    $formattedDate = $createdAt->format('M d Y');
?>
<div class="container-fluid py-3">

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Comment Details</h5>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <h6 class="fw-bold">Comment</h6>
                <p class="mb-0">
                    <?= nl2br(htmlspecialchars($comment_details['comment'] ?? '')) ?>
                </p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1">
                        <strong>Added by:</strong>
                        <?= htmlspecialchars($comment_details['added_by'] ?? 'Unknown') ?>
                    </p>
                </div>

                <div class="col-md-6">
                    <p class="mb-1">
                        <strong>Created at:</strong>
                        <?= htmlspecialchars($formattedDate) ?>
                    </p>
                </div>
            </div>

            <?php if (!empty($attachments)): ?>
            <div class="mt-3">
                <h6 class="fw-bold">Attachments</h6>
                <ul class="list-group list-group-flush">
                    <?php foreach ($attachments as $attachment): ?>
                        <li class="list-group-item px-0">
                            <a
                                href="<?= APP_BASE_URL . '/' . htmlspecialchars($attachment['file_path']) ?>"
                                target="_blank"
                            >
                                <?= htmlspecialchars(basename($attachment['file_path'])) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

        </div>
    </div>

<?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">All Comments</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="bug_comments" class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date Added</th>
                            <th>Comment</th>
                            <th>Added By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($comments)): ?>
                            <?php foreach ($comments as $comment): ?>
                                <tr>
                                    <td><?= htmlspecialchars($comment['created_at']) ?></td>
                                    <td><?= htmlspecialchars($comment['comment']) ?></td>
                                    <td><?= htmlspecialchars($comment['added_by']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</div>



<script src="<?= APP_BASE_URL ?>/assets/js/jquery-3.6.0.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/datatables/js/datatables.min.js"></script>

<script>
    jQuery(document).ready(function() {

       var table = jQuery('#bug_comments').DataTable({
            ajax: {
                url: '<?= APP_BASE_URL ?>/api/bug_comments.php',
                data: { bug_id: <?= (int)$_GET['id'] ?> },
                dataSrc: 'data'
            },
            columns: [
                { data: 'created_at' },
                { data: 'comment' },
                { data: 'added_by' }
            ]
        });


        $('#bug_comments tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            if (!data || !data.id) return;
            window.location.href = '<?= APP_BASE_URL ?>/comment.php?id=' + data.id;
        });
    });

</script>

