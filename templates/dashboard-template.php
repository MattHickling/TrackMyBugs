<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="/TrackMyBugs/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/TrackMyBugs/public/assets/css/font-awesome.css" rel="stylesheet">
    <link href="/TrackMyBugs/public/assets/css/login.css" rel="stylesheet">

    <title>Dashboard</title>
</head>
<body>

<h1>Dashboard</h1>
<p>Welcome <?php echo htmlspecialchars($_SESSION['email']); ?></p>

<form action="/TrackMyBugs/public/dashboard.php" method="post">
    <label for="title">Bug Title:</label>
    <input type="text" id="bug_title" name="bug_title" required>

    <label for="description">Bug Description:</label>
    <textarea id="bug_description" name="bug_description" required></textarea>

   <label for="priority">Priority:</label>
    <select id="priority" name="priority" required>
        <option value="">Select</option>
        <?php foreach ($priorities as $priority): ?>
            <option value="<?php echo $priority['id']; ?>">
                <?php echo htmlspecialchars($priority['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Add Bug</button>
</form>

<script src="/TrackMyBugs/public/assets/js/jquery-3.6.0.min.js"></script>
<script src="/TrackMyBugs/public/assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
