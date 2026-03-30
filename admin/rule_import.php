<?php
include 'auth.php';
$content = trim($_POST['content']);
$lines = explode("\n", $content);

foreach($lines as $line){
  $line = trim($line);
  if(!$line) continue;
  
  $arr = explode(",", $line);
  $title = trim($arr[0] ?? '');
  $score = (int)trim($arr[1] ?? 0);
  
  if($title){
    $pdo->prepare("INSERT INTO score_rules (title, score) VALUES (?,?)")->execute([$title, $score]);
  }
}

header("Location: rule_list.php");
exit;
?>