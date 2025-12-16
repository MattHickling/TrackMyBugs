<?php 
use Carbon\Carbon;

if (isset($comment_details)): 
    $createdAt = Carbon::parse($comment_details['created_at']);
    $comment_details['created_at'] = $createdAt->format('M d Y');
    ?>
    <h2 class="ms-2">Comment <strong><?php echo htmlspecialchars($comment_details['comment'] ?? ''); ?></h2>
    <p class="ms-2"><strong>Added by:</strong> <?php echo htmlspecialchars($comment_details['added_by'] ?? ''); ?></p>
    <p class="ms-2"><strong>Created at:</strong> <?php echo htmlspecialchars($comment_details['created_at'] ?? ''); ?></p>
<?php else: ?>
    <p class="ms-2">Comment not found.</p>
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

<script src="/TrackMyBugs/public/assets/js/jquery-3.6.0.min.js"></script>
<script src="/TrackMyBugs/public/assets/js/bootstrap.bundle.min.js"></script>
<script src="/TrackMyBugs/public/assets/datatables/js/datatables.min.js"></script>

<script>
    jQuery(document).ready(function() {

        var table = jQuery('#bug_comments').DataTable({
            ajax: '/TrackMyBugs/public/api/bug_comments.php',
                columns: [
                    { data: 'created_at' },
                    { data: 'comment' },
                    { data: 'added_by' }
                ]
        });

        $('#bug_comments tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            if (!data || !data.id) return;
            window.location.href = '/TrackMyBugs/public/comment.php?id=' + data.id;
        });
    });

</script>

