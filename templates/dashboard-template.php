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



<div class="container-fluid">
    <h1>Dashboard</h1>
    <p>Welcome <?php echo htmlspecialchars($_SESSION['email']); ?></p>
<form action="/TrackMyBugs/public/dashboard.php" method="post">
  <div class="form-group">
    <label for="title">Bug Title</label>
    <input type="text" class="form-control" id="bug_title" placeholder="Enter Bug Title...." name="bug_title" required>
  </div>

  <div class="form-group">
    <label for="description">Bug Description</label>
    <textarea class="form-control" id="bug_description" placeholder="What is happening....." name="bug_description" rows="3"></textarea>
  </div>
 

  <div class="form-group">
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


<script src="/TrackMyBugs/public/assets/js/jquery-3.6.0.min.js"></script>
<script src="/TrackMyBugs/public/assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
