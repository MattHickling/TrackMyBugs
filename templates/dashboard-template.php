<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/TrackMyBugs/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/TrackMyBugs/public/assets/css/font-awesome.css" rel="stylesheet">
    <link href="/TrackMyBugs/public/assets/css/login.css" rel="stylesheet">
    <link rel="stylesheet" href="/TrackMyBugs/public/assets/datatables/css/datatables.min.css">

    <title>Dashboard</title>
</head>
<body>
<div class="container-fluid mt-1 text-center">
<h3>Live Bugs</h3>
<table id="live_bugs">
    <thead>
        <th>Bug ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Project</th>
        <th>Priority</th>
        <th>Reported By</th>
        <th>Status</th>
        <th>Bug URL</th>
        <th>Created</th>
    </thead>
    <tbody>
        <?php if (!empty($bugs)){?>
            <?php foreach ($bugs as $bug): ?>
                <tr>
                    <td><?php echo $bug['id']; ?></td>
                    <td><?php echo htmlspecialchars($bug['title']); ?></td>
                    <td><?php echo htmlspecialchars($bug['description']); ?></td>
                    <td><?php echo htmlspecialchars($bug['project_name']); ?></td>
                    <td><?php echo htmlspecialchars($bug['priority']); ?></td>
                    <td><?php echo htmlspecialchars($bug['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($bug['status']); ?></td>
                    <td><?php echo htmlspecialchars($bug['bug_url']); ?></td>
                    <td><?php echo htmlspecialchars($bug['created_at']); ?></td>
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

        var table = jQuery('#live_bugs').DataTable({
            ajax: '/TrackMyBugs/public/api/live_bugs.php',
                columns: [
                    { data: 'id' },
                    { data: 'title' },
                    { data: 'description' },
                    { data: 'project_name' },
                    { data: 'priority_name' },
                    { data: 'first_name' },
                    { data: 'status_name' },
                    { data: 'bug_url' },
                    { data: 'created_at' }
                ]
        });

        jQuery('#live_bugs tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            if (!data || !data.id) return;
            window.location.href = '/TrackMyBugs/public/bug.php?id=' + data.id;
        });
    });


    
</script>
</body>
</html>
