<?php
include 'auth.php';
$sid = (int)$_POST['student_id'];
$tid = (int)$_POST['title_id'];

$pdo->prepare("UPDATE student SET title_id=? WHERE id=?")
    ->execute([$tid,$sid]);

header("Location: student_bind_title.php");
exit;
?>