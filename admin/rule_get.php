<?php
include 'auth.php';
$stmt = $pdo->query("SELECT id, title, score FROM score_rules ORDER BY score DESC, id DESC");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
exit;
?>