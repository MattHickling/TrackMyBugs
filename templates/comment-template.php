<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/TrackMyBugs/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/TrackMyBugs/public/assets/css/font-awesome.css" rel="stylesheet">
    <link href="/TrackMyBugs/public/assets/css/login.css" rel="stylesheet">
    <link rel="stylesheet" href="/TrackMyBugs/public/assets/datatables/css/datatables.min.css">

    <title>Comments</title>
</head>
<body>
<div class="container-fluid mt-1 text-center">
<h3>Comments</h3>
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

        jQuery('#bug_comments tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            if (!data || !data.id) return;
            window.location.href = '/TrackMyBugs/public/comment.php?id=' + data.id;
        });
    });

</script>
</body>
</html>
