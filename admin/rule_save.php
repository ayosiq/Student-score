<?php
include 'auth.php';
$id = (int)$_POST['id'];
$title = $_POST['title'];
$score = (int)$_POST['score'];

if($id){
  $pdo->prepare("UPDATE score_rules SET title=?, score=? WHERE id=?")->execute([$title, $score, $id]);
}else{
  $pdo->prepare("INSERT INTO score_rules (title, score) VALUES (?,?)")->execute([$title, $score]);
}

header("Location: rule_list.php");
exit;
?>