<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>EventHorizon - Home</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Welcome to EventHorizon</h1>
  <?php if (isset($_SESSION['email'])): ?>
    <p>Hello, <?php echo $_SESSION['email']; ?> (<?php echo $_SESSION['role']; ?>)</p>
    <a href="dashboard.php">Dashboard</a> | <a href="logout.php">Logout</a>
  <?php else: ?>
    <a href="login.php">Login</a> | <a href="register.php">Register</a>
  <?php endif; ?>
</body>
</html>
