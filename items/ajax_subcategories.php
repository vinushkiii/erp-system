<?php
// Include database config
require_once '../includes/config.php';

// Connect to database
$db = getDB();

// Get category ID from URL parameters 
$category_id = $_GET['category_id'] ?? 0;

// Prepare query to fetch matching subcategories
$stmt = $db->prepare("SELECT id, name FROM item_sub_categories WHERE category_id = ? ORDER BY name");

// Execute query with the category ID
$stmt->execute([$category_id]);

// Fetch all matching records
$subcategories = $stmt->fetchAll();

// Set response header to return JSON data
header('Content-Type: application/json');

// Convert results to JSON format and output them
echo json_encode($subcategories);