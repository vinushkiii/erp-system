<?php
require_once '../includes/config.php';
$db = getDB();

$category_id = $_GET['category_id'] ?? 0;

$stmt = $db->prepare("SELECT id, name FROM item_sub_categories WHERE category_id = ? ORDER BY name");
$stmt->execute([$category_id]);
$subcategories = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($subcategories);