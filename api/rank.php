<?php
header("Content-Type: application/json");
require_once '../admin/config.php';

$stmt = $pdo->query("SELECT name, score FROM student ORDER BY score DESC LIMIT 20");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
