<?php
// Include database config
require_once '../includes/config.php';

// Connect to database
$db = getDB();

// Get item ID from URL parameters 
$id = $_GET['id'] ?? 0;

// Prepare SQL statement to safely delete item
$stmt = $db->prepare("DELETE FROM items WHERE id = ?");

// Execute deletion query
$stmt->execute([$id]);

// Redirect to items list
header("Location: index.php");
exit; // Stop script execution