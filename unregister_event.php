<?php
session_start();
require 'db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'attendee') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $registrationId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    // Delete only if this registration belongs to the current user
    $stmt = $conn->prepare("DELETE FROM Registrations WHERE Id = ? AND UserId = ?");
    $stmt->execute([$registrationId, $userId]);
}

header("Location: attendee_dashboard.php");
exit();
