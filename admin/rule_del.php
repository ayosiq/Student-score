<?php
include 'auth.php';
$id=(int)$_GET['id'];
$pdo->prepare("DELETE FROM score_rules WHERE id=?")->execute([$id]);
header("Location:rule_list.php");
?>