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


<div class="container-fluid">
    <p>Hey <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</p>
<form action="/TrackMyBugs/public/dashboard.php" method="post">
  <div class="form-group mb-2">
    <label for="title">Bug Title</label>
    <input type="text" class="form-control" id="bug_title" placeholder="Enter Bug Title...." name="bug_title" required>
  </div>

  <div class="form-group mb-2">
    <label for="description">Bug Description</label>
    <textarea class="form-control" id="bug_description" placeholder="What is happening....." name="bug_description" rows="3"></textarea>
  </div>
 

  <div class="form-group mb-2">
    <label for="exampleFormControlSelect2">Priority</label>
     <select id="priority" name="priority" required>
        <option value="">Select</option>
        <?php foreach ($priorities as $priority): ?>
            <option value="<?php echo $priority['id']; ?>">
                <?php echo htmlspecialchars($priority['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
  </div>


  <button type="submit" class="btn btn-primary">Add Bug</button>
</form>
</div>
<div class="container-fluid mt-1 text-center">
<h3>Live Bugs</h3>
<table id="live_bugs">
    <thead>
        <th>Bug ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Priority</th>
        <th>Reported By</th>
        <th>Status</th>
    </thead>
    <tbody>
        <?php if (!empty($bugs)){?>
            <?php foreach ($bugs as $bug): ?>
                <tr>
                    <td><?php echo $bug['id']; ?></td>
                    <td><?php echo htmlspecialchars($bug['title']); ?></td>
                    <td><?php echo htmlspecialchars($bug['description']); ?></td>
                    <td><?php echo htmlspecialchars($bug['priority']); ?></td>
                    <td><?php echo htmlspecialchars($bug['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($bug['status']); ?></td>
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
                { data: 'priority_name' },
                { data: 'first_name' },
                { data: 'status_name' }
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
