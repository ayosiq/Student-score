<?php
include 'auth.php';
$id = (int)$_POST['id'];
$rid = (int)$_POST['rid'];

// 获取理由分数
$rule = $pdo->prepare("SELECT score FROM score_rules WHERE id = ?");
$rule->execute([$rid]);
$score = $rule->fetchColumn();

// 计算类型
$type = $score > 0 ? 'add' : 'minus';

// 更新学生积分
$pdo->prepare("UPDATE student SET score = score + ? WHERE id = ?")->execute([$score, $id]);

// 写入日志（自动区分 add / minus）
$pdo->prepare("INSERT INTO score_log (student_id, rule_id, type, score, create_time) 
               VALUES (?,?,?,?,NOW())")
    ->execute([$id, $rid, $type, abs($score)]);

echo 'ok';
?>