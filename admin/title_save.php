<?php
include 'auth.php';
$id = (int)$_POST['id'];
$name = trim($_POST['name']);
$color = trim($_POST['color']);

if($id){
  $pdo->prepare("UPDATE titles SET name=?,color=? WHERE id=?")
      ->execute([$name,$color,$id]);
} else {
  $pdo->prepare("INSERT INTO titles(name,color) VALUES(?,?)")
      ->execute([$name,$color]);
}

header("Location: title_list.php");
exit;
?>