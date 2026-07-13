<?php
require_once 'includes/config.php';

try {
    $db = getDB();
    echo "Connected successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}