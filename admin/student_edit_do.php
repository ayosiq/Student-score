<?php
include 'auth.php';
$id = $_POST['id'];
$name = $_POST['name'];
$code = $_POST['code'];
$class = $_POST['class'];

$stmt = $pdo->prepare("UPDATE student SET name=?, code=?, class=? WHERE id=?");
$stmt->execute([$name, $code, $class, $id]);

header("Location: student_list.php");
exit;
?>
