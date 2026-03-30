<?php
include 'auth.php';

// 接收弹窗提交的 id + 表单数据
if (!isset($_POST['id'])) {
    header("Location: student_list.php");
    exit;
}

$id    = (int)$_POST['id'];
$name  = $_POST['name'];
$code  = $_POST['code'];
$class = $_POST['class'];

$stmt = $pdo->prepare("UPDATE student SET name=?, code=?, class=? WHERE id=?");
$stmt->execute([$name, $code, $class, $id]);

header("Location: student_list.php");
exit;
?>
