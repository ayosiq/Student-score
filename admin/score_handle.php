<?php
include 'auth.php';

if (!isset($_GET['act']) || !in_array($_GET['act'], ['add', 'minus'])) {
    header("Location: student_list.php");
    exit;
}

$act = $_GET['act'];
$id  = (int)$_POST['id'];
$num = (int)$_POST['num'];

if ($num <= 0) {
    header("Location: student_list.php");
    exit;
}

// 1. 更新学生积分
if ($act == 'add') {
    $pdo->prepare("UPDATE student SET score=score+? WHERE id=?")->execute([$num, $id]);
    $score = $num;
} else {
    $pdo->prepare("UPDATE student SET score=score-? WHERE id=?")->execute([$num, $id]);
    $score = -$num;
}

// 2. 写入日志（兼容你原来的字段 + 新增 rule_id=0）
// 保留 type、score、create_time 不动！
$log = $pdo->prepare("INSERT INTO score_log (student_id, rule_id, type, score, create_time) 
                      VALUES (?,?,?,?,NOW())");
$log->execute([$id, 0, $act, $num]);

header("Location: student_list.php");
exit;
?>