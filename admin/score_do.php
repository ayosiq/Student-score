<?php
include 'auth.php';
$act = $_GET['act'];
$id = $_POST['id'];
$num = (int)$_POST['num'];

if ($act == 'add') {
    $stmt = $pdo->prepare("UPDATE student SET score = score + ? WHERE id=?");
} else {
    $stmt = $pdo->prepare("UPDATE student SET score = score - ? WHERE id=?");
}
$stmt->execute([$num, $id]);

header("Location: student_list.php");
exit;
?>
