<?php 
use Carbon\Carbon;

if (isset($comment_details)): 
    $createdAt = Carbon::parse($comment_details['created_at']);
    $comment_details['created_at'] = $createdAt->format('M d Y');
    ?>
<div class="comments-page">
        <h2 class="ms-3 text-start">Comment <strong><?php echo htmlspecialchars($comment_details['comment'] ?? ''); ?></h2>
        <p class="ms-3 text-start"><strong>Added by:</strong> <?php echo htmlspecialchars($comment_details['added_by'] ?? ''); ?></p>
        <p class="ms-3"><strong>Created at:</strong> <?php echo htmlspecialchars($comment_details['created_at'] ?? ''); ?></p>
    <?php endif; ?>
    <?php if (!empty($attachments)): ?>
    <div class="comment-attachments ms-3">
            <h4>Attachments</h4>
            <ul>
                <?php foreach ($attachments as $attachment): ?>
                    <li>
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

    <table id="bug_comments">
        <thead>
            <th>Date Added</th>
            <th>Comment</th>
            <th>Added By</th>
        </thead>
        <tbody>
            <?php if (!empty($comments)){
                    foreach ($comments as $comment): 
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($comment['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($comment['comment']); ?></td>
                        <td><?php echo htmlspecialchars($comment['added_by']); ?></td>
                    </tr>
                <?php endforeach; 
                }?>
        </tbody>
    </table>
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

