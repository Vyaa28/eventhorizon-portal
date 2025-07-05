<?php
session_start();
require 'db.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'attendee') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $userId  = $_SESSION['user_id'];
    $eventId = $_POST['event_id'];

    // Check if already registered
    $check = $conn->prepare("SELECT * FROM Registrations WHERE UserId = ? AND EventId = ?");
    $check->execute([$userId, $eventId]);
    if ($check->rowCount() === 0) {
        // Simulate payment process (real payment integration would go here)

        // Register user for event
        $register = $conn->prepare("INSERT INTO Registrations (UserId, EventId) VALUES (?, ?)");
        $register->execute([$userId, $eventId]);

        header("Location: events.php?registered=success");
        exit();
    } else {
        header("Location: events.php?registered=exists");
        exit();
    }
} else {
    header("Location: events.php");
    exit();
}
