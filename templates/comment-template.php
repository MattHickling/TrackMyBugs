<?php if ($comment_details): ?>
    <h2>Comment #<?php echo htmlspecialchars($comment_details['id']); ?></h2>
    <p><strong>Bug ID:</strong> <?php echo htmlspecialchars($comment_details['bug_id']); ?></p>
    <p><strong>Comment:</strong> <?php echo htmlspecialchars($comment_details['comment']); ?></p>
    <p><strong>Added by:</strong> <?php echo htmlspecialchars($comment_details['added_by']); ?></p>
    <p><strong>Created at:</strong> <?php echo htmlspecialchars($comment_details['created_at']); ?></p>
<?php else: ?>
    <p>Comment not found.</p>
<?php endif; ?>


<table id="bug_comments">
    <thead>
        <th>ID</th>
        <th>Date Added</th>
        <th>Comment</th>
        <th>Added By</th>
    </thead>
    <tbody>
        <?php if (!empty($comments)){?>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($comment['id']); ?></td>
                    <td><?php echo htmlspecialchars($comment['bug_id']); ?></td>
                    <td><?php echo htmlspecialchars($comment['comment']); ?></td>
                    <td><?php echo htmlspecialchars($comment['created_at']); ?></td>
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
                    { data: 'id' },
                    { data: 'bug_id' },
                    { data: 'comment' },
                    { data: 'created_at' },
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

