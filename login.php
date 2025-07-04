<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    $stmt = $conn->prepare("SELECT Id, Password FROM Users WHERE Email = ? AND Role = ?");
    $stmt->execute([$email, $role]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['Password'])) {
        session_regenerate_id(true);
        $_SESSION['email']   = $email;
        $_SESSION['role']    = $role;
        $_SESSION['user_id'] = $user['Id'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
  <h2>Login</h2>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="POST">
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    Role:
    <select name="role">
      <option value="organizer">Organizer</option>
      <option value="attendee">Attendee</option>
    </select><br><br>
    <button type="submit">Login</button>
  </form>
</body>
</html>
