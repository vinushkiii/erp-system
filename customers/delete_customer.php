<?php
// Include database config
require_once '../includes/config.php';

// Connect to database
$db = getDB();

// Get customer ID from URL parameters 
$id = $_GET['id'] ?? 0;

// Prepare SQL statement to safely delete customer
$stmt = $db->prepare("DELETE FROM customers WHERE id = ?");

// Execute deletion query
$stmt->execute([$id]);

// Redirect to customers list
header("Location: index.php");
exit; // Stop script execution