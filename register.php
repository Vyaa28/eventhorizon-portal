<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Hash the password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check if user already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $error = "User with this email already exists.";
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$email, $hashedPassword, $role]);

            $_SESSION["email"] = $email;
            $_SESSION["role"] = $role;

            // Get user ID
            $userId = $conn->lastInsertId();
            $_SESSION["user_id"] = $userId;

            header("Location: dashboard.php");
            exit();
        }
    } catch (PDOException $e) {
        $error = "Registration failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        Role:
        <select name="role">
            <option value="organizer">Organizer</option>
            <option value="attendee">Attendee</option>
        </select><br><br>
        <button type="submit">Register</button>
    </form>
    <p>Already registered? <a href="login.php">Login here</a></p>
</body>
</html>
