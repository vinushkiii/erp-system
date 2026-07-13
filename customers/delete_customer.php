<?php
require_once '../includes/config.php';
$db = getDB();

$id = $_GET['id'] ?? 0;

$stmt = $db->prepare("DELETE FROM customers WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;